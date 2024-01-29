<?php

namespace RKW\RkwWepstra\Helper\Register;

use \RKW\RkwBasics\Helper\Common;
use RKW\RkwWepstra\Domain\Model\FrontendUser;
use RKW\RkwWepstra\Domain\Repository\FrontendUserGroupRepository;
use RKW\RkwWepstra\Domain\Repository\FrontendUserRepository;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

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
 * Class Registration
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwWepstra
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Registration implements \TYPO3\CMS\Core\SingletonInterface
{

    /**
     *  Length of token for anonymous users
     *
     * @const integer
     * @see \RKW\RkwWepstra\Helper\Register\Authentication::ANONYMOUS_TOKEN_LENGTH
     */
    const ANONYMOUS_TOKEN_LENGTH = 20;

    /**
     * Setting
     *
     * @var array
     */
    protected $settings;


    /**
     * @var Logger
     */
    protected $logger;


    /**
     * Creates a new anonymous FE-user
     *
     * @return FrontendUser
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    public function registerAnonymous(): FrontendUser
    {

        /** @var FrontendUserRepository $frontendUserRepository */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $frontendUserRepository = $objectManager->get(FrontendUserRepository::class);

        // get settings
        $settings = $this->getSettings();

        // create a token for anonymous login and check if this token already exists
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        do {
            $token = substr(str_shuffle($characters), 0, self::ANONYMOUS_TOKEN_LENGTH);
        } while (count($frontendUserRepository->findByUsername($token)));

        // now that we know that the token is non-existent we create a new user from it!
        /** @var FrontendUser $anonymousUser */
        $anonymousUser = GeneralUtility::makeInstance(FrontendUser::class);

        // for session identification set username (token == username)
        $anonymousUser->setUsername($token);
        $anonymousUser->setDisable(0);
        $anonymousUser->setTxRkwwepstraIsAnonymous(true);

        // set pid and crdate
        $anonymousUser->setPid(intval($settings['users']['storagePid']));
        $anonymousUser->setCrdate(time());

        // set lifetime
        if (intval($settings['users']['lifetimeAnonymous'])) {
            $anonymousUser->setEndtime(time() + intval($settings['users']['lifetimeAnonymous']));
        }

        // set languageKey
        if ($settings['users']['languageKeyOnRegister']) {
            $anonymousUser->setTxRkwwepstraLanguageKey($settings['users']['languageKeyOnRegister']);
        }

        // set users server ip-address
        $remoteAddr = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);
        if ($_SERVER['HTTP_X_FORWARDED_FOR']) {
            $ips = GeneralUtility::trimExplode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            if ($ips[0]) {
                $remoteAddr = filter_var($ips[0], FILTER_VALIDATE_IP);
            }
        }

        // @toDo: Privacy??
        //$anonymousUser->setTxRkwregistrationRegisterRemoteIp($remoteAddr);

        // set password
        /** @var \RKW\RkwWepstra\Helper\Register\Password $passwordTool */
        $passwordTool = GeneralUtility::makeInstance(\RKW\RkwWepstra\Helper\Register\Password::class);
        $passwordTool->generatePassword($anonymousUser);

        // set groups - this is needed - otherwise the user won't be able to login at all!
        $this->setUserGroupsOnRegister($anonymousUser);

        // add to repository
        $frontendUserRepository->add($anonymousUser);

        /** @var \TYPO3\CMS\Extbase\\Persistence\Generic\PersistenceManager $persistenceManager */
        $persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
        $persistenceManager->persistAll();

        return $anonymousUser;
    }


    /**
     * setUsersGroupsOnRegister
     *
     * @param FrontendUser $frontendUser
     * @param string                                         $userGroups
     * @return void
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    public function setUserGroupsOnRegister(FrontendUser $frontendUser, string $userGroups = '')
    {

        if (!$userGroups) {
            $settings = $this->getSettings();
            $userGroups = $settings['users']['groupsOnRegister'];

            if ($frontendUser->getTxRkwwepstraIsAnonymous()) {
                $userGroups = $settings['users']['groupsOnRegisterAnonymous'];
            }
        }

        $userGroupIds = GeneralUtility::trimExplode(',', $userGroups);
        foreach ($userGroupIds as $groupId) {

            $frontendUserGroup = $this->getFrontendUserGroupRepository()->findByUid($groupId);
            if ($frontendUserGroup) {
                $frontendUser->addUsergroup($frontendUserGroup);
            }
        }

    }


    /**
     * Returns FrontendUserRepository
     *
     * @return FrontendUserRepository
     */
    protected function getFrontendUserRepository(): FrontendUserRepository
    {
        if (!$this->frontendUserRepository) {
            $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
            $this->frontendUserRepository = $objectManager->get(FrontendUserRepository::class);
        }

        return $this->frontendUserRepository;
    }


    /**
     * Returns FrontendUserGroupRepository
     *
     * @return FrontendUserGroupRepository
     */
    protected function getFrontendUserGroupRepository(): FrontendUserGroupRepository
    {
        if (!$this->frontendUserGroupRepository) {
            $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
            $this->frontendUserGroupRepository = $objectManager->get(FrontendUserGroupRepository::class);
        }

        return $this->frontendUserGroupRepository;
    }


    /**
     * Returns PersistanceManager
     *
     * @return PersistenceManager
     */
    protected function getPersistenceManager(): PersistenceManager
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
            $this->settings = Common::getTyposcriptConfiguration('Rkwregistration');
        }

        if (!$this->settings) {
            return array();
        }

        return $this->settings;
    }


    /**
     * Returns logger instance
     *
     * @return Logger
     */
    protected function getLogger()
    {

        if (!$this->logger instanceof Logger) {
            $this->logger = GeneralUtility::makeInstance('TYPO3\CMS\Core\Log\LogManager')->getLogger(__CLASS__);
        }

        return $this->logger;
    }

}