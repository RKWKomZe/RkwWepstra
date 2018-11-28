<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rkwwepstra_domain_model_wepstra', 'EXT:rkw_wepstra/Resources/Private/Language/locallang_csh_tx_rkwwepstra_domain_model_wepstra.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rkwwepstra_domain_model_wepstra');
$GLOBALS['TCA']['tx_rkwwepstra_domain_model_wepstra'] = array(
	'ctrl' => array(
		'hideTable' => TRUE,
		'title'	=> 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_wepstra',
		'label' => 'last_update',
		'label_alt' => 'crdate',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'enablecolumns' => array(
		),
		'searchFields' => 'guided_mode,guided_asked,knowledge,technical_development_percentage,reason_why,sales_trend,geographical_sector,product_sector,performance,technical_development,productivity,cost_saving,participants,job_family,step_control,frontend_user,anonymous_user,last_update,',
		'iconfile' => 'EXT:rkw_wepstra/Resources/Public/Icons/tx_rkwwepstra_domain_model_wepstra.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, guided_mode, guided_asked, knowledge, technical_development_percentage, reason_why, sales_trend, geographical_sector, product_sector, performance, technical_development, productivity, cost_saving, participants, job_family, frontend_user, anonymous_user, last_update, disabled, target_date',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, guided_mode, guided_asked, knowledge, technical_development_percentage, reason_why, sales_trend, geographical_sector, product_sector, performance, technical_development, productivity, cost_saving, participants, job_family, frontend_user, anonymous_user, last_update, disabled, target_date, --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(

		'tstamp' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_wepstra.tstamp',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),

		'guided_mode' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_wepstra.guided_mode',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			)
		),
		'guided_asked' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_wepstra.guided_asked',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			)
		),
		'knowledge' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_wepstra.knowledge',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			)
		),
		'technical_development_percentage' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_wepstra.technical_development_percentage',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			)
		),
		'reason_why' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_wepstra.reason_why',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'size' => 8,
				'foreign_table' => 'tx_rkwwepstra_domain_model_reasonwhy',
				'foreign_field' => 'wepstra',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),

		),
		'sales_trend' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_wepstra.sales_trend',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_rkwwepstra_domain_model_salestrend',
				'foreign_field' => 'wepstra',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),

		),
		'geographical_sector' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_wepstra.geographical_sector',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_rkwwepstra_domain_model_geographicalsector',
				'foreign_field' => 'wepstra',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'product_sector' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_wepstra.product_sector',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_rkwwepstra_domain_model_productsector',
				'foreign_field' => 'wepstra',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'performance' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_wepstra.performance',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'size' => 8,
				'foreign_table' => 'tx_rkwwepstra_domain_model_performance',
				'foreign_field' => 'wepstra',
				'minitems' => 0,
				'maxitems' => 9999,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'technical_development' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_wepstra.technical_development',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_rkwwepstra_domain_model_technicaldevelopment',
				'foreign_field' => 'wepstra',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),

		),
		'productivity' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_wepstra.productivity',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'size' => 8,
				'foreign_table' => 'tx_rkwwepstra_domain_model_productivity',
				'foreign_field' => 'wepstra',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),

		),
		'cost_saving' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_wepstra.cost_saving',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'size' => 8,
				'foreign_table' => 'tx_rkwwepstra_domain_model_costsaving',
				'foreign_field' => 'wepstra',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),

		),
		'participants' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_wepstra.participants',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'size' => 8,
				'foreign_table' => 'tx_rkwwepstra_domain_model_participant',
				'foreign_field' => 'wepstra',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),

		),
		'job_family' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_wepstra.job_family',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'size' => 8,
				'foreign_table' => 'tx_rkwwepstra_domain_model_jobfamily',
				'foreign_field' => 'wepstra',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'step_control' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_wepstra.step_control',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'size' => 8,
				'foreign_table' => 'tx_rkwwepstra_domain_model_stepcontrol',
				'foreign_field' => 'wepstra',
				'maxitems'      => 1,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'frontend_user' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_wepstra.frontend_user',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'size' => 8,
				'foreign_table' => 'fe_users',
				'minitems' => 0,
				'maxitems' => 1,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'anonymous_user' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_wepstra.anonymous_user',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'size' => 8,
				'foreign_table' => 'fe_users',
				'minitems' => 0,
				'maxitems' => 1,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'last_update' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_wepstra.last_update',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'disabled' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_wepstra.disabled',
			'config' => array(
				'type' => 'check',
			),
		),
		'target_date' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_wepstra.target_date',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'crdate' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.crdate',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => time(),
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),

		
	),
);
