<?php
return [
	'ctrl' => [
		'hideTable' => 1,
		'title'	=> 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_priority',
		'label' => 'value',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'enablecolumns' => [
		],
		'searchFields' => 'value,job_family,participant,',
		'iconfile' => 'EXT:rkw_wepstra/Resources/Public/Icons/tx_rkwwepstra_domain_model_priority.gif'
	],
	'interface' => [
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, value, job_family, participant',
	],
	'types' => [
		'1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden,--palette--;;1, value, job_family, participant'],
	],
	'palettes' => [
		'1' => ['showitem' => ''],
	],
	'columns' => [
	
		'value' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_priority.value',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'job_family' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_priority.job_family',
			'config' => [
				'type' => 'inline',
				'foreign_table' => 'tx_rkwwepstra_domain_model_jobfamily',
				'minitems' => 0,
				'maxitems' => 1,
				'appearance' => [
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				],
			],
		],
		'participant' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_priority.participant',
			'config' => [
				'type' => 'inline',
				'foreign_table' => 'tx_rkwwepstra_domain_model_participant',
				'minitems' => 0,
				'maxitems' => 1,
				'appearance' => [
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				],
			],
		],
	],
];
