<?php

namespace RKW\RkwWepstra\Controller;

use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use \RKW\RkwBasics\Helper\Common;
use RKW\RkwRegistration\Tools\Password;
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
 * StepController
 * This is the basic controller of the application which manage the views
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwWepstra
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class StepController extends \RKW\RkwWepstra\Controller\AbstractController
{
    /**
     * Signal name for use in ext_localconf.php
     *
     * @const string
     */
    const SIGNAL_AFTER_USER_PASSWORD_RESET = 'afterUserPasswordReset';


    /**
     * initializeAction
     * !! for all actions !!
     * This initialize action is the "brain" of the application. FrontendUser, AnonymousUser (token) and not logged
     * user are filtered here and routed to their targets.
     *
     * @throws \RKW\RkwRegistration\Exception
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    public function initializeAction()
    {
        parent::initializeAction();

        // Initial / general: Create Helper
        /** @var \RKW\RkwWepstra\Helper\Json jsonHelper */
        $this->jsonHelper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Helper\\Json');

        /** @var \RKW\RkwWepstra\Helper\VerifyStep verifyStepHelper */
        $this->verifyStepHelper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Helper\\VerifyStep');

        /** @var \RKW\RkwWepstra\Helper\BasicData basicDataHelper */
        $this->basicDataHelper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Helper\\BasicData');

        // get arguments (if any)
        $arguments = $this->request->getArguments();
        $token = preg_replace('/[^a-z0-9]+/i', '', $arguments['token']);

        // 2.1 In case of logged frontendUser (can also be a logged in anonymousUser)
        if ($frontendUser = $this->getFrontendUser()) {

            // if a token is given - we log out the current user
            // in order to login the other that is related to that token!
            if ($token) {

                if ($this->getFrontendUser()->getUsername() != $token) {

                    $rkwRegistrationAuthTool = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwRegistration\\Tools\\Authentication');
                    $rkwRegistrationAuthTool->logoutUser();

                    $this->redirect('index', null, null, $arguments);
                    //===
                }
            }

            // a) by anonymousUser
            if ($frontendUser->getTxRkwregistrationIsAnonymous()) {
                $this->wepstra = $this->wepstraRepository->findOneEnabledByAnonymousUser($frontendUser);

                // b) by frontendUser
            } else {
                $this->wepstra = $this->wepstraRepository->findOneEnabledByFrontendUser($frontendUser);
            }

            // create new wepstra if there is no existing wepstra of frontendUser (not for anonymousUser -> see "anonymousStart"-Function)
            if (!$this->wepstra instanceof \RKW\RkwWepstra\Domain\Model\Wepstra) {

                /** @var \RKW\RkwWepstra\Domain\Model\Wepstra wepstra */
                $this->wepstra = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Model\\Wepstra');
                $this->wepstra->setCrdate(time());
                $this->wepstra->setLastUpdate(time());

                // initial: set basic data for project
                $this->basicDataHelper->createAllBasicData($this->wepstra);

                if ($frontendUser->getTxRkwregistrationIsAnonymous()) {
                    $this->wepstra->setAnonymousUser($frontendUser);
                } else {
                    $this->wepstra->setFrontendUser($frontendUser);
                }

                $this->wepstraRepository->add($this->wepstra);
                $this->persistenceManager->persistAll();

            }


            // 2.2 with token (anonymousUser)
        } elseif (
            (!$this->getFrontendUser())
            && ($token)
        ) {

            // find anonymous user by token and login
            /** @var \RKW\RkwRegistration\Tools\Authentication $authentication */
            $authentication = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwRegistration\\Tools\\Authentication');
            if ($anonymousUser = $authentication->validateAnonymousUser($token)) {
                $authentication::loginUser($anonymousUser);

            } else {

                $this->controllerContext = $this->buildControllerContext();
                $this->addFlashMessage(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_step.invalid_token', 'rkw_wepstra'
                    )
                );
            }

            $this->redirect('index');
            //===


            // 2.3 else: Popup -> Login with user (a) or anonymous (b)?
        } else {

            // handle OptIn
            $registration = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('tx_rkwregistration_rkwregistration');
            if (
                $registration['user']
                && ($registration['token_yes'] || $registration['token_no'])
            ) {
                // use forward to kept the GET params
                $this->redirect('loginOptIn', null, null, ['arguments' => $registration]);
                //===
            }

            // handle login screen
            $arguments = $this->request->getArguments();

            // if NOT a "login.." named action is called, show initial loginChoice screen!
            if (!strpos($arguments['action'], 'login') === 0) {
                $this->redirect('loginChoice');
                //===
            }
        }


        // 3. check if user is logged in -> otherwise show login form
        // Because issues can happen, if user reload wepstra via cache
        if (
        (!$this->getFrontendUser()
            && stristr($arguments['action'], 'login') === false)
        ) {

            // use only if ajax is active!! (otherwise the JS is shown on a white page)
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

                $errorMessage = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_rkwwepstra_controller_step.invalid_session', 'rkw_wepstra');

                $replacements = array(
                    'errorMessage' => $errorMessage,
                );

                $this->jsonHelper->setHtml(
                    'tx-rkwwepstra-main-container',
                    $replacements,
                    'replace',
                    'Step/LoginChoice.html'
                );

                print (string)$this->jsonHelper;
                exit();
                //===
            }
        }


        // 4. handle possible guided mode parameter
        if ($arguments['guided']) {

            if (intval($arguments['guided']) === 0 || intval($arguments['guided']) === 1) {
                $this->guidedAction(intval($arguments['guided']));
            }
        }

    }


    /**
     * action loginChoice
     * (1.1 login) initial "landing" login action with choose for login or anonymous
     *
     * @return void
     */
    public function loginChoiceAction()
    {

        // get errors from initialize action - if any
        /** @var \TYPO3\CMS\Core\Messaging\FlashMessage[] $flashMessages */
        $flashMessages = $this->controllerContext->getFlashMessageQueue()->getAllMessagesAndFlush();
        $this->view->assign('errors', $flashMessages);

    }


    /**
     * action loginAnonymous
     * (1.2 login) login anonymous (create token)
     *
     * @param integer $privacy
     * @return void
     * @throws \RKW\RkwRegistration\Exception
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    public function loginAnonymousAction($privacy = null)
    {
        // anonymous privacy agree
        /*
         * @toDo: Do we really need this?, SK
		if (!$privacy) {
			$replacements = array(
				'errorMessage' =>
					\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
						'registrationController.error.accept_privacy', 'rkw_registration'
					)
			);

			$this->jsonHelper->setHtml(
				'anonymous-error-part',
				$replacements,
				'replace',
				'Ajax/Login/AnonymousForm'
			);

			print (string) $this->jsonHelper;
			exit();
			//===
		} else {

            // add privacy info
            \RKW\RkwRegistration\Tools\Privacy::addPrivacyData($this->request, $this->getFrontendUser(), null, 'new anonymous login into WePstra-App');
		}

        */


        /** @var \RKW\RkwRegistration\Tools\Registration $registration */
        $registration = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwRegistration\\Tools\\Registration');

        /** @var \RKW\RkwRegistration\Tools\Authentication $authentication */
        $authentication = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwRegistration\\Tools\\Authentication');

        // register anonymous user and login
        $anonymousUser = $registration->registerAnonymous();
        $authentication::loginUser($anonymousUser);

        // show link with token to anonymous user
        $replacements = array(
            'anonymousToken' => $anonymousUser->getUsername(),
        );

        $this->jsonHelper->setHtml(
            'account-modal',
            $replacements,
            'replace',
            'Ajax/Login/AnonymousHint.html'
        );

        print (string)$this->jsonHelper;
        exit();
        //===
    }


    /**
     * action loginForm
     * (1.3 login) Login form for registered users
     *
     * @param array $loginData
     * @param string $errorMessage
     * @return void
     */
    public function loginFormAction($loginData = null, $errorMessage = null)
    {

        $replacements = array(
            'loginData'    => $loginData,
            'errorMessage' => $errorMessage,
        );

        $this->jsonHelper->setHtml(
            'login-part',
            $replacements,
            'replace',
            'Ajax/Login/LoginForm.html'
        );

        // prepare browser data for reload the page after user-processing (login etc)
        $this->jsonHelper->setJavaScript('
			history.pushState(
				{
					current_page:"/",
					previous_page:"/"
				},
				"Page: Wepstra",
				"/"
			);
		');


        print (string)$this->jsonHelper;
        exit();
        //===
    }


    /**
     * action loginAuthenticate
     * (1.4 login) Authenticate login data from "loginFormAction"
     *
     * @param integer $privacy
     * @return void
     * @throws \RKW\RkwRegistration\Exception
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     */
    public function loginAuthenticateAction($privacy = null)
    {

        $loginData = (array)$this->request->getArgument('loginData');

        // Es muss an dieser Stelle extra abgefragt werden ob Username oder Password nicht gesetzt sind,
        // damit es keinen Crash durch den Aufruf der validateUser() Funktion der RkwRegistration gibt (bei leeren Eingaben)
        if (!$loginData['username'] || !$loginData['password']) {

            $this->loginFormAction($loginData,
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'tx_rkwwepstra_controller_step.login_error', 'rkw_wepstra'
                )
            );
            exit;
            //===
        }


        if (!$privacy) {
            $this->loginFormAction($loginData,
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'registrationController.error.accept_privacy', 'rkw_registration'
                )
            );
            exit;
            //===
        }


        // check if there is a user that matches and log him in
        /** @var \RKW\RkwRegistration\Tools\Authentication $authenticate */
        $authenticate = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwRegistration\\Tools\\Authentication');
        $validateResult = null;
        if (
            ($validateResult = $authenticate->validateUser($loginData['username'], $loginData['password']))
            && ($validateResult instanceof \RKW\RkwRegistration\Domain\Model\FrontendUser)
        ) {

            // do login
            $authenticate->loginUser($validateResult);

            // add privacy info
            \RKW\RkwRegistration\Tools\Privacy::addPrivacyData($this->request, $validateResult, null, 'new login into WePstra-App');

            $this->jsonHelper->setHtml(
                'account-modal',
                array(),
                'replace',
                'Ajax/Login/LoginAuthenticate.html'
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }


        // user blocked
        if ($validateResult == 2) {

            $this->loginFormAction($loginData,
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'tx_rkwwepstra_controller_step.login_blocked', 'rkw_wepstra'
                )
            );
            exit;
            //===

            // wrong login
        } else {
            if ($validateResult == 1) {

                $this->loginFormAction($loginData,
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_step.login_error', 'rkw_wepstra'
                    )
                );
                exit;
                //===

                // user not found
            } else {

                $this->loginFormAction($loginData,
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_step.login_notfound', 'rkw_wepstra'
                    )
                );
                exit;
                //===
            }
        }
    }


    /**
     * loginRegisterForm
     * (1.5 login) returns a register form
     *
     * @param array $registerData
     * @param string $errorMessage
     * @return void
     */
    public function loginRegisterFormAction($registerData = null, $errorMessage = null)
    {

        $replacements = array(
            'registerData' => $registerData,
            'errorMessage' => $errorMessage,
            'termsPid'     => $this->settings['termsPid'],
        );

        $this->jsonHelper->setHtml(
            'register-part',
            $replacements,
            'replace',
            'Ajax/Login/RegisterForm.html'
        );

        print (string)$this->jsonHelper;
        exit();
        //===

    }


    /**
     * loginRegisterUser
     * (1.6 login) register process
     *
     * @param integer $privacy
     * @return void
     * @return \RKW\RkwRegistration\Domain\Model\FrontendUser
     * @throws \RKW\RkwRegistration\Exception
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     */
    public function loginRegisterUserAction($privacy = null)
    {

        $registerData = (array)$this->request->getArgument('registerData');

        // 1. check valid email address
        if (!filter_var($registerData['email'], FILTER_VALIDATE_EMAIL)) {

            $this->loginRegisterFormAction($registerData,
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'tx_rkwwepstra_controller_step.invalid_email', 'rkw_wepstra'
                )
            );
            exit;
            //===
        }

        // 2. if terms are accepted
        if (!$registerData['terms']) {

            $this->loginRegisterFormAction($registerData,
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'tx_rkwwepstra_controller_step.invalid_term', 'rkw_wepstra'
                )
            );
            exit;
            //===
        }

        if (!$privacy) {
            $this->loginRegisterFormAction($registerData,
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'registrationController.error.accept_privacy', 'rkw_registration'
                )
            );
            exit;
            //===
        }


        // 3. check if user with email already exists
        if ($this->frontendUserRepository->findOneByEmailOrUsernameInactive($registerData['email'])) {

            $this->loginRegisterFormAction($registerData,
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'tx_rkwwepstra_controller_step.user_already_exists', 'rkw_wepstra'
                )
            );
            exit;
            //===
        }

        // 3. create user
        /** @var \RKW\RkwRegistration\Tools\Registration $rkwRegistrationAuthTool */
        $rkwRegistrationAuthTool = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwRegistration\\Tools\\Registration');
        $feUser = $rkwRegistrationAuthTool->register($registerData, false, null, null, $this->request);

        if ($feUser) {

            $replacements = array(
                'registerData' => $registerData,
            );

            $this->jsonHelper->setHtml(
                'register-part',
                $replacements,
                'replace',
                'Ajax/Login/RegisterUser.html'
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }


        // 4. else: Something went wrong
        $this->loginRegisterFormAction($registerData,
            \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                'tx_rkwwepstra_controller_step.something_went_wrong', 'rkw_wepstra'
            )
        );
        exit;
        //===


    }


    /**
     * Logout
     * (1.7 login) Logout a user
     *
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     */
    public function logoutUserAction()
    {

        /** @var \RKW\RkwRegistration\Tools\Authentication $rkwRegistrationAuthTool */
        $rkwRegistrationAuthTool = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwRegistration\\Tools\\Authentication');
        $rkwRegistrationAuthTool->logoutUser();

        $this->redirect('index');
        //===
    }


    /**
     * action optIn
     * @param array $arguments
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     */
    public function loginOptInAction($arguments)
    {

    //    $tokenYes = preg_replace('/[^a-zA-Z0-9]/', '', ($this->request->hasArgument('token_yes') ? $this->request->getArgument('token_yes') : ''));
    //    $tokenNo = preg_replace('/[^a-zA-Z0-9]/', '', ($this->request->hasArgument('token_no') ? $this->request->getArgument('token_no') : ''));
    //    $userSha1 = preg_replace('/[^a-zA-Z0-9]/', '', $this->request->getArgument('user'));

        $tokenYes = preg_replace('/[^a-zA-Z0-9]/', '', $arguments['token_yes']);
        $tokenNo = preg_replace('/[^a-zA-Z0-9]/', '', $arguments['token_no']);
        $userSha1 = preg_replace('/[^a-zA-Z0-9]/', '', $arguments['user']);

        /** @var \RKW\RkwRegistration\Tools\Registration $register */
        $register = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwRegistration\\Tools\\Registration');
        $check = $register->checkTokens($tokenYes, $tokenNo, $userSha1, $this->request);

        if ($check == 1) {

            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'tx_rkwwepstra_controller_step.registration_successfull', $this->extensionName
                )
            );


        } elseif ($check == 2) {

            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'tx_rkwwepstra_controller_step.registration_canceled', $this->extensionName
                )
            );


        } else {

            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'tx_rkwwepstra_controller_step.registration_error', $this->extensionName
                ),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
        }

        $this->redirect('loginChoice');
        //===

    }


    /**
     * action anonymousLink
     * (2.1 misc) info page without specific user context
     *
     * @return void
     */
    public function anonymousLinkAction()
    {

        // in case of anonymous user is USERNAME === TOKEN
        $uri = $this->uriBuilder->reset()
            ->setArguments(
                array('tx_rkwwepstra_rkwwepstra' =>
                          array('token' => $this->getFrontendUser()->getUsername()),
                )
            )
            ->setCreateAbsoluteUri(true)
            ->build();

        $this->jsonHelper->setDialogue($uri, 1);
        print (string)$this->jsonHelper;
        exit();
        //===

    }


    /**
     * action guided
     * (2.2 misc) turn guided mode on or off
     * Called as required in initializeAction() and can be used through the main menu
     *
     * @param integer $switchMode
     * @return void
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     */
    public function guidedAction($switchMode = null)
    {

        if (intval($switchMode) === 0 || intval($switchMode) === 1) {
            $this->wepstra->setGuidedAsked(1);
            $this->wepstra->setGuidedMode(intval($switchMode));
        }

        $this->wepstraRepository->update($this->wepstra);
        $this->persistenceManager->persistAll();

        // use only if ajax active (to close a visible overlay)
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

            //	$this->jsonHelper->setJavaScript('jQuery(".overlay").detach();');
            $this->jsonHelper->setJavaScript('location.reload(true);');
            print (string)$this->jsonHelper;
            exit;
            //===

        } else {

            // redirect necessary (to reload the header-pulldown menu -> Switch between "Hilfemodus" and "Normalmodus")
            $this->redirect('index');
        }


    }


    /**
     * action new
     * If a user want to create a new wepstra-project (only available for logged user)
     * (2.3 misc)
     *
     * @return void
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     */
    public function newAction()
    {

        // 1. deactivate current wepstra (disabled = 1)
        $this->wepstra->setDisabled(1);
        $this->wepstraRepository->update($this->wepstra);

        // 2. redirect to index (a new wepstra-project will created there)
        $this->redirect('index');
        //===
    }


    /**
     * action open
     * (2.4 misc)
     *
     * @param \RKW\RkwWepstra\Domain\Model\Wepstra $wepstraToOpen
     * @return void
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     */
    public function openAction(\RKW\RkwWepstra\Domain\Model\Wepstra $wepstraToOpen)
    {

        // 1. Security: Check if user is owner of given Wepstra (normal user, or anonymous)
        if (
            ($frontendUser = $this->getFrontendUser())
            && (
                (
                    ($frontendUser->getTxRkwregistrationIsAnonymous())
                    && ($frontendUser->getUid() == $wepstraToOpen->getAnonymousUser()->getUid())
                )
                || (
                    (!$frontendUser->getTxRkwregistrationIsAnonymous())
                    && ($frontendUser->getUid() == $wepstraToOpen->getFrontendUser()->getUid())
                )
            )
        ) {

            // 2. deactivate current wepstra (disabled = 1)
            $this->wepstra->setDisabled(1);
            $this->wepstraRepository->update($this->wepstra);

            // 3. active wepstraToOpen
            $wepstraToOpen->setDisabled(0);
            unset($this->wepstra);
            $this->wepstra = $wepstraToOpen;
            $this->wepstraRepository->update($this->wepstra);

        } else {

            // No Ajax request possible here (is not a API call!)
            // User is not owner of the given project
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'tx_rkwwepstra_fluid_open.error', 'rkw_wepstra'
                )
            );
        }

        // 4. redirect to index (the activated wepstra should be shown now)
        $this->redirect('index');
        //===

    }


    /**
     * action projectList
     * (2.5 misc)
     *
     * @return void
     */
    public function projectListAction()
    {

        // get all Wepstra-Projects of logged user
        $allWepstraProjectsOfUser = array();
        if ($this->getFrontendUser()) {

            if ($this->getFrontendUser()->getTxRkwregistrationIsAnonymous()) {
                $allWepstraProjectsOfUser = $this->wepstraRepository->findByAnonymousUserAlsoDisabled($this->getFrontendUser());

            } else {
                $allWepstraProjectsOfUser = $this->wepstraRepository->findByFrontendUserAlsoDisabled($this->getFrontendUser());
            }
        }


        $replacements = array(
            'wepstra'                  => $this->wepstra,
            'step'                     => 0,
            'stepBefore'               => 0,
            'stepAfter'                => 1,
            'allWepstraProjectsOfUser' => $allWepstraProjectsOfUser,
        );

        // load content
        $this->jsonHelper->setHtml(
            'tx-rkwwepstra-main-content',
            $replacements,
            'replace',
            'Ajax/Step/ProjectList.html'
        );

        // load navigation
        $this->jsonHelper->setHtml(
            'tx-rkwwepstra-navigation',
            $replacements,
            'replace',
            'Ajax/Navigation.html'
        );

        print (string)$this->jsonHelper;
        exit();
        //===
    }


    /**
     * action index
     * Every action in this controller returns HTML content with standaloneView. This is the initial landing page of the app.
     * For this reason the following index-action works a little bit differently to the other actions*
     *
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     */
    public function indexAction()
    {
        // Login popup for not logged user
        if (!$this->getFrontendUser()) {

            $this->redirect('loginChoice');
            //===

        } else {

            // get all Wepstra-Projects of logged user
            $allWepstraProjectsOfUser = $this->wepstraRepository->findByFrontendUserAlsoDisabled($this->getFrontendUser());

            $replacements = array(
                'wepstra'                 => $this->wepstra,
                'importantInformationPid' => $this->settings['importantInformationPid'],
                'newParticipant'          => \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Model\\Participant'),
                'newReasonWhy'            => \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\Domain\\Model\\ReasonWhy'),
            );

            // create HTML via JSON ViewHelper
            $content = $this->jsonHelper->getHtmlRaw($replacements, 'Ajax/Step/Step0.html');

            // 2. Build view with in point 1. fetched content
            $this->view->assignMultiple(
                array(
                    'wepstra'                  => $this->wepstra,
                    'content'                  => $content,
                    'allWepstraProjectsOfUser' => $allWepstraProjectsOfUser,
                    'step'                     => 0,
                    'stepBefore'               => 0,
                    'stepAfter'                => 1,
                    'importantInformationPid'  => $this->settings['importantInformationPid'],
                )
            );

        }
    }


    /**
     * action preparation
     *
     * @return void
     */
    public function step0Action()
    {

        try {

            $replacements = array(
                'wepstra'                 => $this->wepstra,
                'step'                    => 0,
                'stepBefore'              => 0,
                'stepAfter'               => 1,
                'importantInformationPid' => $this->settings['importantInformationPid'],
            );

            // load content
            $this->jsonHelper->setHtml(
                'tx-rkwwepstra-main-content',
                $replacements,
                'replace',
                'Ajax/Step/Step0.html'
            );

            // load navigation
            $this->jsonHelper->setHtml(
                'tx-rkwwepstra-navigation',
                $replacements,
                'replace',
                'Ajax/Navigation.html'
            );

            $this->jsonHelper->setJavaScript('jQuery("body,html").animate({scrollTop:0},300);');

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }
    }


    /**
     * action step1
     *
     * @return void
     */
    public function step1Action()
    {

        try {

            // 1. verify step0
            $this->verifyStepHelper->step0($this->wepstra);

            // 2. create view
            $replacements = array(
                'wepstra'    => $this->wepstra,
                'step'       => 1,
                'stepBefore' => 0,
                'stepAfter'  => 2,
            );

            // load content
            $this->jsonHelper->setHtml(
                'tx-rkwwepstra-main-content',
                $replacements,
                'replace',
                'Ajax/Step/Step1.html'
            );

            // load navigation
            $this->jsonHelper->setHtml(
                'tx-rkwwepstra-navigation',
                $replacements,
                'replace',
                'Ajax/Navigation.html'
            );

            $this->jsonHelper->setJavaScript('jQuery("body,html").animate({scrollTop:0},300);');

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }
    }


    /**
     * action step2
     *
     * @return void
     */
    public function step2Action()
    {


        try {

            // 1. verify step1
            $this->verifyStepHelper->step1($this->wepstra);

            // 2. get priorities of users in relation to jobfamily (if already exists)
            $participantList = $this->wepstra->getParticipants();
            $jobFamilyList = $this->wepstra->getJobFamily();

            $priorityList = null;
            foreach ($participantList as $participant) {
                foreach ($jobFamilyList as $jobFamily) {

                    $priority = $this->priorityRepository->findByParticipantAndJobFamily($participant, $jobFamily);
                    if ($priority) {
                        $priorityList[$participant->getUid()][$jobFamily->getUid()][] = $priority;
                    }

                }
            }

            // 3. create view
            $replacements = array(
                'wepstra'      => $this->wepstra,
                'priorityList' => $priorityList,
                'step'         => 2,
                'stepBefore'   => 1,
                'stepAfter'    => 3,
            );

            // load content
            $this->jsonHelper->setHtml(
                'tx-rkwwepstra-main-content',
                $replacements,
                'replace',
                'Ajax/Step/Step2.html'
            );

            // load navigation
            $this->jsonHelper->setHtml(
                'tx-rkwwepstra-navigation',
                $replacements,
                'replace',
                'Ajax/Navigation.html'
            );

            $this->jsonHelper->setJavaScript('jQuery("body,html").animate({scrollTop:0},300);');

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }

    }


    /**
     * action step2sub2
     *
     * @return void
     */
    public function step2sub2Action()
    {

        try {

            // 1. verify step2
            $this->verifyStepHelper->step2($this->wepstra);

            // 2. standard select of two job families
            // count number of selected jobfamilies
            $countSelectedJobFamilies = 0;

            /** @var \RKW\RkwWepstra\Domain\Model\JobFamily $jobFamily */
            foreach ($this->wepstra->getJobFamily() as $jobFamily) {
                if ($jobFamily->getSelected()) {
                    $countSelectedJobFamilies++;
                }
            }


            if ($countSelectedJobFamilies < 1) {

                /** @var \RKW\RkwWepstra\ViewHelpers\JobFamilySortViewHelper $jobFamilySortViewHelper */
                $jobFamilySortViewHelper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\ViewHelpers\\JobFamilySortNormalViewHelper');
                $sortedJobFamilies = $jobFamilySortViewHelper->render($this->wepstra);

                /** @var \RKW\RkwWepstra\ViewHelpers\JobFamilySortViewHelper $jobFamilySortViewHelper */
                //$jobFamilySortViewHelper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwWepstra\\ViewHelpers\\JobFamilySortNormalViewHelper');
                //$sortedJobFamilies = $jobFamilySortViewHelper->render($this->wepstra);

                /** @var \RKW\RkwWepstra\Domain\Model\JobFamily $jobFamily */
                foreach ($sortedJobFamilies as $jobFamily) {

                    if ($countSelectedJobFamilies == 1) {
                        break;
                    }
                    //===

                    if (!$jobFamily->getSelected()) {

                        $jobFamily->setSelected(1);
                        $this->jobFamilyRepository->update($jobFamily);
                        $countSelectedJobFamilies++;
                    }
                }

                $this->persistenceManager->persistAll();
            }

            $replacements = array(
                'wepstra'    => $this->wepstra,
                'step'       => 2,
                'stepBefore' => 1,
                'stepAfter'  => 3,
            );

            // load content
            $this->jsonHelper->setHtml(
                'tx-rkwwepstra-main-content',
                $replacements,
                'replace',
                'Ajax/Step/Step2sub2.html'
            );

            // load navigation
            $this->jsonHelper->setHtml(
                'tx-rkwwepstra-navigation',
                $replacements,
                'replace',
                'Ajax/Navigation.html'
            );

            $this->jsonHelper->setJavaScript('jQuery("body,html").animate({scrollTop:0},300);');

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }
    }


    /**
     * action step3
     *
     * @return void
     */
    public function step3Action()
    {

        try {

            // 1. verify step2sub2
            $this->verifyStepHelper->step2sub2($this->wepstra);


            // 2. create view
            $replacements = array(
                'wepstra'    => $this->wepstra,
                'step'       => 3,
                'stepBefore' => 2,
                'stepAfter'  => 4,
            );

            // load content
            $this->jsonHelper->setHtml(
                'tx-rkwwepstra-main-content',
                $replacements,
                'replace',
                'Ajax/Step/Step3.html'
            );

            // load navigation
            $this->jsonHelper->setHtml(
                'tx-rkwwepstra-navigation',
                $replacements,
                'replace',
                'Ajax/Navigation.html'
            );

            $this->jsonHelper->setJavaScript('jQuery("body,html").animate({scrollTop:0},300);');

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }
    }


    /**
     * action step3sub2
     *
     * @return void
     */
    public function step3sub2Action()
    {

        try {

            // 1. verify step3 ~ NOTHING TO PROOF YET
            $this->verifyStepHelper->step3($this->wepstra);

            // 2. create view
            $replacements = array(
                'wepstra'    => $this->wepstra,
                'step'       => 3,
                'stepBefore' => 2,
                'stepAfter'  => 4,
            );

            // load content
            $this->jsonHelper->setHtml(
                'tx-rkwwepstra-main-content',
                $replacements,
                'replace',
                'Ajax/Step/Step3sub2.html'
            );

            // load navigation
            $this->jsonHelper->setHtml(
                'tx-rkwwepstra-navigation',
                $replacements,
                'replace',
                'Ajax/Navigation.html'
            );

            $this->jsonHelper->setJavaScript('jQuery("body,html").animate({scrollTop:0},300);');

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }

    }


    /**
     * action step3sub3
     *
     * @return void
     */
    public function step3sub3Action()
    {

        try {

            // 1. verify step3
            $this->verifyStepHelper->step3sub2($this->wepstra);

            // 2. create view
            $replacements = array(
                'wepstra'    => $this->wepstra,
                'step'       => 3,
                'stepBefore' => 2,
                'stepAfter'  => 4,
            );

            // load content
            $this->jsonHelper->setHtml(
                'tx-rkwwepstra-main-content',
                $replacements,
                'replace',
                'Ajax/Step/Step3sub3.html'
            );

            // load navigation
            $this->jsonHelper->setHtml(
                'tx-rkwwepstra-navigation',
                $replacements,
                'replace',
                'Ajax/Navigation.html'
            );

            $this->jsonHelper->setJavaScript('jQuery("body,html").animate({scrollTop:0},300);');

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }
    }


    /**
     * action step3sub4
     *
     * @return void
     */
    public function step3sub4Action()
    {

        try {

            // 1. verify step3sub3
            $this->verifyStepHelper->step3sub3($this->wepstra);

            $replacements = array(
                'wepstra'    => $this->wepstra,
                'step'       => 3,
                'stepBefore' => 2,
                'stepAfter'  => 4,
            );

            // load content
            $this->jsonHelper->setHtml(
                'tx-rkwwepstra-main-content',
                $replacements,
                'replace',
                'Ajax/Step/Step3sub4.html'
            );

            // load navigation
            $this->jsonHelper->setHtml(
                'tx-rkwwepstra-navigation',
                $replacements,
                'replace',
                'Ajax/Navigation.html'
            );

            $this->jsonHelper->setJavaScript('jQuery("body,html").animate({scrollTop:0},300);');

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }

    }


    /**
     * action step4
     *
     * @return void
     */
    public function step4Action()
    {

        try {

            // 1. verify step3sub3
            $this->verifyStepHelper->step3sub4($this->wepstra);

            $replacements = array(
                'wepstra'    => $this->wepstra,
                'step'       => 4,
                'stepBefore' => 3,
                'stepAfter'  => 5,
            );

            // load content
            $this->jsonHelper->setHtml(
                'tx-rkwwepstra-main-content',
                $replacements,
                'replace',
                'Ajax/Step/Step4.html'
            );

            // load navigation
            $this->jsonHelper->setHtml(
                'tx-rkwwepstra-navigation',
                $replacements,
                'replace',
                'Ajax/Navigation.html'
            );

            $this->jsonHelper->setJavaScript('jQuery("body,html").animate({scrollTop:0},300);');

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }
    }


    /**
     * action step4results
     *
     * @return void
     */
    public function step4resultsAction()
    {

        $this->view->assign('wepstra', $this->wepstra);

        $this->jsonHelper->setModal(
            $this->view->render()
            , 1
        );

        print (string)$this->jsonHelper;
        exit();
        //===

    }


    /**
     * action step5
     *
     * @return void
     */
    public function step5Action()
    {

        try {

            // 1. verify step4
            $this->verifyStepHelper->step4($this->wepstra);

            $replacements = array(
                'wepstra'    => $this->wepstra,
                'step'       => 5,
                'stepBefore' => 4,
                'stepAfter'  => 6,
            );

            // load content
            $this->jsonHelper->setHtml(
                'tx-rkwwepstra-main-content',
                $replacements,
                'replace',
                'Ajax/Step/Step5.html'
            );

            // load navigation
            $this->jsonHelper->setHtml(
                'tx-rkwwepstra-navigation',
                $replacements,
                'replace',
                'Ajax/Navigation.html'
            );

            $this->jsonHelper->setJavaScript('jQuery("body,html").animate({scrollTop:0},300);');

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }
    }


    /**
     * action step5sub2
     *
     * @return void
     */
    public function step5sub2Action()
    {

        try {

            // 1. verify step5
            $this->verifyStepHelper->step5($this->wepstra);

            $replacements = array(
                'wepstra'    => $this->wepstra,
                'step'       => 5,
                'stepBefore' => 4,
                'stepAfter'  => 6,
            );

            // load content
            $this->jsonHelper->setHtml(
                'tx-rkwwepstra-main-content',
                $replacements,
                'replace',
                'Ajax/Step/Step5sub2.html'
            );

            // load navigation
            $this->jsonHelper->setHtml(
                'tx-rkwwepstra-navigation',
                $replacements,
                'replace',
                'Ajax/Navigation.html'
            );

            $this->jsonHelper->setJavaScript('jQuery("body,html").animate({scrollTop:0},300);');

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }
    }


    /**
     * action step5sub3
     *
     * @return void
     */
    public function step5sub3Action()
    {

        try {

            // 1. verify step5sub2
            $this->verifyStepHelper->step5sub2($this->wepstra);

            $replacements = array(
                'wepstra'    => $this->wepstra,
                'step'       => 5,
                'stepBefore' => 4,
                'stepAfter'  => 6,
            );

            // load content
            $this->jsonHelper->setHtml(
                'tx-rkwwepstra-main-content',
                $replacements,
                'replace',
                'Ajax/Step/Step5sub3.html'
            );

            // load navigation
            $this->jsonHelper->setHtml(
                'tx-rkwwepstra-navigation',
                $replacements,
                'replace',
                'Ajax/Navigation.html'
            );

            $this->jsonHelper->setJavaScript('jQuery("body,html").animate({scrollTop:0},300);');

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }
    }


    /**
     * action step5sub4
     *
     * @return void
     */
    public function step5sub4Action()
    {

        try {

            // 1. verify step5sub3
            $this->verifyStepHelper->step5sub3($this->wepstra);

            $replacements = array(
                'wepstra'    => $this->wepstra,
                'step'       => 5,
                'stepBefore' => 4,
                'stepAfter'  => 6,
            );

            // load content
            $this->jsonHelper->setHtml(
                'tx-rkwwepstra-main-content',
                $replacements,
                'replace',
                'Ajax/Step/Step5sub4.html'
            );

            // load navigation
            $this->jsonHelper->setHtml(
                'tx-rkwwepstra-navigation',
                $replacements,
                'replace',
                'Ajax/Navigation.html'
            );

            $this->jsonHelper->setJavaScript('jQuery("body,html").animate({scrollTop:0},300);');

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }
    }


    /**
     * action step5sub5
     *
     * @return void
     */
    public function step5sub5Action()
    {

        try {

            // 1. verify step5sub4
            $this->verifyStepHelper->step5sub4($this->wepstra);

            // get selected JobFamilies
            $jobFamiliesSelected = $this->jobFamilyRepository->findSelectedByWepstra($this->wepstra);

            $replacements = array(
                'wepstra'             => $this->wepstra,
                'step'                => 5,
                'stepBefore'          => 4,
                'stepAfter'           => 6,
                'jobFamiliesSelected' => $jobFamiliesSelected,
            );

            // load content
            $this->jsonHelper->setHtml(
                'tx-rkwwepstra-main-content',
                $replacements,
                'replace',
                'Ajax/Step/Step5sub5.html'
            );

            // load navigation
            $this->jsonHelper->setHtml(
                'tx-rkwwepstra-navigation',
                $replacements,
                'replace',
                'Ajax/Navigation.html'
            );

            $this->jsonHelper->setJavaScript('jQuery("body,html").animate({scrollTop:0},300);');

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }


    }


    /**
     * action step6
     *
     * @return void
     */
    public function step6Action()
    {

        try {

            // 1. verify step5sub5
            $this->verifyStepHelper->step5sub5($this->wepstra);

            $replacements = array(
                'wepstra'    => $this->wepstra,
                'step'       => 6,
                'stepBefore' => 5,
                'stepAfter'  => 0,
            );

            // load content
            $this->jsonHelper->setHtml(
                'tx-rkwwepstra-main-content',
                $replacements,
                'replace',
                'Ajax/Step/Step6.html'
            );

            // load navigation
            $this->jsonHelper->setHtml(
                'tx-rkwwepstra-navigation',
                $replacements,
                'replace',
                'Ajax/Navigation.html'
            );

            $this->jsonHelper->setJavaScript('jQuery("body,html").animate({scrollTop:0},300);');

            print (string)$this->jsonHelper;
            exit();
            //===

        } catch (\Exception $e) {

            $this->jsonHelper->setDialogue(
                sprintf(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_rkwwepstra_controller_data.error_unexpected', 'rkw_wepstra'
                    ),
                    $e->getMessage()
                ), 99
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }
    }


    /**
     * Returns TYPO3 settings
     *
     * @param string $which Which type of settings will be loaded
     * @return array
     */
    protected function getSettings($which = ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS)
    {

        return Common::getTyposcriptConfiguration('Rkwwepstra', $which);
        //===
    }


    /**
     * action printAll
     * Possible to print only one part of it (step0, step1, step2, step2sub2, step3 etc)
     *
     * @param string $printPart
     * @return void
     */
    public function printAllAction($printPart = null)
    {

        // filter optional printPart
        $printPart = preg_replace('/[^stepub0-6]/', '', $printPart);

        // for step 2
        if ($this->getFrontendUser()) {
            $participantList = $this->wepstra->getParticipants();
            $jobFamilyList = $this->wepstra->getJobFamily();

            $priorityList = null;

            $i = 0;
            foreach ($participantList as $participant) {

                $j = 0;
                foreach ($jobFamilyList as $jobFamily) {

                    $priority = $this->priorityRepository->findByParticipantAndJobFamily($participant, $jobFamily);
                    if ($priority) {
                        $priorityList[$participant->getUid()][$jobFamily->getUid()] = $priority->getValue();
                    } else {
                        $priorityList[$participant->getUid()][$jobFamily->getUid()] = '0';
                    }

                    $j++;
                }
                $i++;
            }

            // for step 2.2
            $jobFamilyListSortDesc = $this->jobFamilyRepository->findByWepstraSortDesc($this->wepstra->getUid());

            $this->view->assign('jobFamilyListSortDesc', $jobFamilyListSortDesc);
            $this->view->assign('priorityList', $priorityList);

        }

        $this->view->assign('wepstra', $this->wepstra);
        $this->view->assign('printPart', $printPart);
        //===
    }


    /**
     * Copied from Extension RkwRegistration
     * action forgot password show
     *
     * @param string $errorMessage
     * @return void
     */
    public function loginPasswordForgotShowAction($errorMessage = null)
    {

        $replacements = array(
            'errorMessage' => $errorMessage,
        );

        $this->jsonHelper->setHtml(
            'login-part',
            $replacements,
            'replace',
            'Ajax/Login/PasswordForgotShow.html'
        );

        print (string)$this->jsonHelper;
        exit();
        //===

    }


    /**
     * Copied from Extension RkwRegistration
     * action forgot password
     *
     * @param string $username
     * @return void
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     */
    public function loginPasswordForgotAction($username)
    {

        // 1. check if username is given
        if (!$username) {

            $replacements = array(
                'errorMessage' => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('registrationController.error.login_no_username', 'rkw_registration'),
            );

            $this->jsonHelper->setHtml(
                'login-part',
                $replacements,
                'replace',
                'Ajax/Login/PasswordForgotShow.html'
            );

            print (string)$this->jsonHelper;
            exit();
            //===
        }

        // 2. check if user exists
        if ($registeredUser = $this->frontendUserRepository->findOneByUsername($username)) {

            // reset password
            $plaintextPassword = Password::generatePassword($registeredUser);
            $this->frontendUserRepository->update($registeredUser);

            // dispatcher for e.g. E-Mail
            $this->signalSlotDispatcher->dispatch(__CLASS__, self::SIGNAL_AFTER_USER_PASSWORD_RESET, array($registeredUser, $plaintextPassword));

            $replacements = array(
                'errorMessage' => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('registrationController.message.new_password', 'rkw_registration'),
            );

            $this->jsonHelper->setHtml(
                'login-part',
                $replacements,
                'replace',
                'Ajax/Login/LoginForm.html'
            );

            print (string)$this->jsonHelper;
            exit();
            //===

        }

        // 3. If username does not exists (point 2.)
        $replacements = array(
            'errorMessage' => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('registrationController.error.invalid_username', 'rkw_registration'),
        );

        $this->jsonHelper->setHtml(
            'login-part',
            $replacements,
            'replace',
            'Ajax/Login/PasswordForgotShow.html'
        );

        print (string)$this->jsonHelper;
        exit();
        //===
    }


    /*
     * finishAction
     *
     * @return void
     */
    public function finishAction()
    {

        $this->jsonHelper->setModal(
            $this->view->render()
            , 1
        );

        print (string)$this->jsonHelper;
        exit();
        //===

    }
}