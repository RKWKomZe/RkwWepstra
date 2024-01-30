<?php

namespace RKW\RkwWepstra\Helper\Register;

use \RKW\RkwBasics\Helper\Common;
use RKW\RkwWepstra\Domain\Repository\FrontendUserRepository;
use RKW\RkwWepstra\Exception;
use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use RKW\RkwBasics\Service\CookieService;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Class Authenticate
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwWepstra
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Authentication implements \TYPO3\CMS\Core\SingletonInterface
{

    /**
     * Length of token for anonymous users
     *
     * @const integer
     * @see \RKW\RkwWepstra\Tools\Registration::ANONYMOUS_TOKEN_LENGTH
     */
    const ANONYMOUS_TOKEN_LENGTH = 20;

    /**
     * FrontendUserRepository
     *
     * @var FrontendUserRepository
     */
    protected $frontendUserRepository;


    /**
     * Persistence Manager
     *
     * @var PersistenceManager
     */
    protected $persistenceManager;


    /**
     * Setting
     *
     * @var array
     */
    protected $settings;

    /**
     * Checks the given token of an anonymous user
     *
     * @param string $token
     * @return \RKW\RkwWepstra\Domain\Model\FrontendUser| boolean
     */
    public function validateAnonymousUser($token)
    {
        /** @var FrontendUserRepository $frontendUserRepository */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $frontendUserRepository = $objectManager->get(FrontendUserRepository::class);

        // check if given token exists and has the expected length!
        if (
            (strlen($token) == self::ANONYMOUS_TOKEN_LENGTH)
            && ($anonymousUser = $frontendUserRepository->findOneByToken($token))
        ) {

            $this->getLogger()->log(LogLevel::INFO, sprintf('Successfully authenticated anonymous user with token "%s".', trim($token)));
            return $anonymousUser;
        }

        $this->getLogger()->log(LogLevel::WARNING, sprintf('Anonymous user with token "%s" not found.', trim($token)));
        return false;
    }


    /**
     * Sets a temporary session cookie with the user-id
     * IMPORTANT: After a redirect the user is logged in then
     * DANGER: This method authenticates the given user without checking for password!!!
     *
     * @param FrontendUser $frontendUser
     * @return void
     * @throws Exception
     */
    public static function loginUser(FrontendUser $frontendUser)
    {
        if (!$frontendUser->getUid()) {
            throw new Exception('No valid uid for user given.', 1435002338);
        }

        $userArray = array(
            'uid' => $frontendUser->getUid()
        );

        /** @var \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $GLOBALS['TSFE']*/
        /** @var \TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication $GLOBALS['TSFE']->fe_user */
        $GLOBALS['TSFE']->fe_user->is_permanent = 0; //set 1 for a permanent cookie, 0 for session cookie
        $GLOBALS['TSFE']->fe_user->checkPid = 0;
        $GLOBALS['TSFE']->fe_user->dontSetCookie = false;
        $GLOBALS['TSFE']->fe_user->start(); // set cookie and initiate login
        $GLOBALS['TSFE']->fe_user->createUserSession($userArray);  // create user session in database
        $GLOBALS['TSFE']->fe_user->user = $GLOBALS['TSFE']->fe_user->fetchUserSession(); // get user session from database
        $GLOBALS['TSFE']->fe_user->loginSessionStarted = true; // set session as started equal to a successful login
        $GLOBALS['TSFE']->initUserGroups(); // Initializes the front-end user groups based on all fe_groups records that the current fe_user is member of
        $GLOBALS['TSFE']->loginUser = true; //  Global flag indicating that a frontend user is logged in. Should already by set by \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController::initUserGroups();
        $GLOBALS['TSFE']->storeSessionData(); // store session in database

        self::getLogger()->log(LogLevel::INFO, sprintf('Logging in User "%s" with uid %s.', strtolower($frontendUser->getUsername()), $frontendUser->getUid()));
    }


    /**
     * Checks if user is logged in
     *
     * @param FrontendUser $frontendUser
     * @return boolean
     */
    public static function isUserLoggedIn(FrontendUser $frontendUser)
    {

        // check which id is logged in and compare it with given user
        if (
            ($GLOBALS['TSFE'])
            && ($GLOBALS['TSFE']->loginUser)
            && ($GLOBALS['TSFE']->fe_user->user['uid'])
        ) {
            if ($frontendUser->getUid() == intval($GLOBALS['TSFE']->fe_user->user['uid'])) {
                return true;
            }
        }

        return false;
    }


    /**
     * Logout
     *
     * @return void
     */
    public static function logoutUser()
    {
        self::getLogger()->log(LogLevel::INFO, sprintf('Logging out user with uid %s.', intval($GLOBALS['TSFE']->fe_user->user['uid'])));
        $GLOBALS['TSFE']->fe_user->removeSessionData();
        $GLOBALS['TSFE']->fe_user->logoff();

        // same like in login action: We have to reset data we need for further (multi-)domain logouts
        $version = VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version);
        if ($version >=  8000000) {
            // re-set url for further logouts
            CookieService::copyCookieDataToFeUserSession();
        }
    }


    /**
     * Extracts the domain from the given url
     *
     * @param string $url
     * @return string | NULL
     */
    protected function getDomain($url)
    {
        $match = array();
        if (preg_match('#^http(s)?://([[:alnum:]._-]+)/#', $url, $match)) {
            return $match[2];
        }

        return null;
    }


    /**
     * Returns logger instance
     *
     * @return \TYPO3\CMS\Core\Log\Logger
     */
    public static function getLogger()
    {
        return GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
    }


    /**
     * Returns FrontendUserRepository
     *
     * @return \RKW\RkwWepstra\Domain\Repository\FrontendUserRepository
     */
    protected function getFrontendUserRepository()
    {

        if (!$this->frontendUserRepository) {
            $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
            $this->frontendUserRepository = $objectManager->get(FrontendUserRepository::class);
        }

        return $this->frontendUserRepository;
    }


    /**
     * Returns PersistenceManager
     *
     * @return PersistenceManager
     */
    protected function getPersistenceManager()
    {

        if (!$this->persistenceManager) {
            $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
            $this->persistenceManager = $objectManager->get(PersistenceManager::class);
        }

        return $this->persistenceManager;
    }


    /**
     * Returns TYPO3 settings
     *
     * @return array
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    protected function getSettings()
    {

        if (!$this->settings) {
            $this->settings = Common::getTyposcriptConfiguration('Rkwwepstra');
        }


        if (!$this->settings) {
            return array();
        }

        return $this->settings;
    }


}