<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rkwwepstra_domain_model_stepcontrol', 'EXT:rkw_wepstra/Resources/Private/Language/locallang_csh_tx_rkwwepstra_domain_model_stepcontrol.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rkwwepstra_domain_model_stepcontrol');
$GLOBALS['TCA']['tx_rkwwepstra_domain_model_stepcontrol'] = array(
	'ctrl' => array(
		'hideTable' => 1,
		'title'	=> 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_stepcontrol',
		'label' => 'token',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'enablecolumns' => array(
		),
		'searchFields' => 'step0,step1,step2,step2sub2,step3,step3sub2,step3sub3,step4,step5,step5sub2,step5sub3,step6,',
		'iconfile' => 'EXT:rkw_wepstra/Resources/Public/Icons/tx_rkwwepstra_domain_model_stepcontrol.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, step0, step1, step2, step2sub2, step3, step3sub2, step3sub3, step4sub4, step4, step5, step5sub2, step5sub3, step5sub4, step5sub5, step6',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden,--palette--;;1, step0, step1, step2, step2sub2, step3, step3sub2, step3sub3, step3sub4, step4, step5, step5sub2, step5sub3, step5sub4, step5sub5, step6'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
	
		'step0' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_stepcontrol.step0',
			'config' => array(
				'type' => 'check',
			),
		),
		'step1' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_stepcontrol.step1',
			'config' => array(
				'type' => 'check',
			),
		),
		'step2' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_stepcontrol.step2',
			'config' => array(
				'type' => 'check',
			),
		),
		'step2sub2' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_stepcontrol.step2sub2',
			'config' => array(
				'type' => 'check',
			),
		),
		'step3' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_stepcontrol.step3',
			'config' => array(
				'type' => 'check',
			),
		),
		'step3sub2' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_stepcontrol.step3sub2',
			'config' => array(
				'type' => 'check',
			),
		),
		'step3sub3' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_stepcontrol.step3sub3',
			'config' => array(
				'type' => 'check',
			),
		),
		'step3sub4' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_stepcontrol.step3sub4',
			'config' => array(
				'type' => 'check',
			),
		),
		'step4' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_stepcontrol.step4',
			'config' => array(
				'type' => 'check',
			),
		),
		'step5' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_stepcontrol.step5',
			'config' => array(
				'type' => 'check',
			),
		),
		'step5sub2' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_stepcontrol.step5sub2',
			'config' => array(
				'type' => 'check',
			),
		),
		'step5sub3' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_stepcontrol.step5sub3',
			'config' => array(
				'type' => 'check',
			),
		),
		'step5sub4' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_stepcontrol.step5sub4',
			'config' => array(
				'type' => 'check',
			),
		),
		'step5sub5' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_stepcontrol.step5sub5',
			'config' => array(
				'type' => 'check',
			),
		),
		'step6' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_stepcontrol.step6',
			'config' => array(
				'type' => 'check',
			),
		),

		'wepstra' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
	),
);
