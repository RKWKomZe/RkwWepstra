<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'RKW.' . $_EXTKEY,
	'Rkwwepstra',
	array(

		'Step' =>   'index, step0, step1, step2, step2sub2, step3, step3sub2, step3sub3, step3sub4, step4, step4results, step5, step5sub2,
					step5sub3, step5sub4, step5sub5, step6, loginChoice, loginAnonymous, loginForm, loginRegisterForm, loginRegisterUser, loginOptIn, loginAuthenticate, logoutUser, importantInformation,
					helpPage, anonymousLink, projectList, printAll, guided, new, open, loginPasswordForgotShow, loginPasswordForgot, finish, contact, promotion',


		'Data' => 	'createparticipant, updateparticipant, deleteparticipant, createreasonwhy, deletereasonwhy, updatereasonwhy,
					proofpreparation, createjobfamily, deletejobfamily, savepriority, selectjobfamily, updatesalestrend,
					creategeographicalsector, deletegeographicalsector, createproductsector, deleteproductsector,
					updategeographicalsector, updateproductsector, updateperformance, updateknowledge, createtechdev,
					updatetechdev, deletetechdev, updateproductivity, updatecostsaving, createcostsaving, deletecostsaving, savestrategy,
					updategraph, updatetasks, importantinformations, updateplanninghorizon'
		
	),
	// non-cacheable actions
	array(
		'Step' =>   'index, step0, step1, step2, step2sub2, step3, step3sub2, step3sub3, step3sub4, step4, step4results, step5, step5sub2,
					step5sub3, step5sub4, step5sub5, step6, loginChoice, loginAnonymous, loginForm, loginRegisterForm, loginRegisterUser, loginOptIn, loginAuthenticate, logoutUser, importantInformation,
					helpPage, anonymousLink, projectList, printAll, guided, new, open, loginPasswordForgotShow, loginPasswordForgot, finish, contact, promotion',


		'Data' => 	'createparticipant, updateparticipant, deleteparticipant, createreasonwhy, deletereasonwhy, updatereasonwhy,
					proofpreparation, createjobfamily, deletejobfamily, savepriority, selectjobfamily, updatesalestrend,
					creategeographicalsector, deletegeographicalsector, createproductsector, deleteproductsector,
					updategeographicalsector, updateproductsector, updateperformance, updateknowledge, createtechdev,
					updatetechdev, deletetechdev, updateproductivity, updatecostsaving, createcostsaving, deletecostsaving, savestrategy,
					updategraph, updatetasks, importantinformations, updateplanninghorizon'
	)
);

// register command controller (cronjob)
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'RKW\\RkwWepstra\\Controller\\WepstraCommandController';

/**
 * @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher
 */
$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');
$signalSlotDispatcher->connect(
	'RKW\\RkwWepstra\\Controller\\StepController',
	\RKW\RkwWepstra\Controller\StepController::SIGNAL_AFTER_USER_PASSWORD_RESET,
	'RKW\\RkwRegistration\\Service\\RkwMailService',
	'handlePasswordResetEvent'
);

// set logger
$GLOBALS['TYPO3_CONF_VARS']['LOG']['RKW']['RkwWepstra']['writerConfiguration'] = array(

	// configuration for WARNING severity, including all
	// levels with higher severity (ERROR, CRITICAL, EMERGENCY)
	\TYPO3\CMS\Core\Log\LogLevel::DEBUG => array(
		// add a FileWriter
		'TYPO3\\CMS\\Core\\Log\\Writer\\FileWriter' => array(
			// configuration for the writer
			'logFile' => 'typo3temp/logs/tx_rkwwepstra.log'
		)
	),
);
