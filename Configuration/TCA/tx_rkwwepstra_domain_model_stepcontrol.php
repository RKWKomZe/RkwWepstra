<?php
return [
	'ctrl' => [
		'hideTable' => 1,
		'title'	=> 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_stepcontrol',
		'label' => 'token',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'enablecolumns' => [
		],
		'searchFields' => 'step0,step1,step2,step2sub2,step3,step3sub2,step3sub3,step4,step5,step5sub2,step5sub3,step6,',
		'iconfile' => 'EXT:rkw_wepstra/Resources/Public/Icons/tx_rkwwepstra_domain_model_stepcontrol.gif'
	],
	'interface' => [
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, step0, step1, step2, step2sub2, step3, step3sub2, step3sub3, step4sub4, step4, step5, step5sub2, step5sub3, step5sub4, step5sub5, step6',
	],
	'types' => [
		'1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden,--palette--;;1, step0, step1, step2, step2sub2, step3, step3sub2, step3sub3, step3sub4, step4, step5, step5sub2, step5sub3, step5sub4, step5sub5, step6'],
	],
	'palettes' => [
		'1' => ['showitem' => ''],
	],
	'columns' => [
	
		'step0' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_stepcontrol.step0',
			'config' => [
				'type' => 'check',
			],
		],
		'step1' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_stepcontrol.step1',
			'config' => [
				'type' => 'check',
			],
		],
		'step2' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_stepcontrol.step2',
			'config' => [
				'type' => 'check',
			],
		],
		'step2sub2' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_stepcontrol.step2sub2',
			'config' => [
				'type' => 'check',
			],
		],
		'step3' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_stepcontrol.step3',
			'config' => [
				'type' => 'check',
			],
		],
		'step3sub2' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_stepcontrol.step3sub2',
			'config' => [
				'type' => 'check',
			],
		],
		'step3sub3' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_stepcontrol.step3sub3',
			'config' => [
				'type' => 'check',
			],
		],
		'step3sub4' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_stepcontrol.step3sub4',
			'config' => [
				'type' => 'check',
			],
		],
		'step4' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_stepcontrol.step4',
			'config' => [
				'type' => 'check',
			],
		],
		'step5' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_stepcontrol.step5',
			'config' => [
				'type' => 'check',
			],
		],
		'step5sub2' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_stepcontrol.step5sub2',
			'config' => [
				'type' => 'check',
			],
		],
		'step5sub3' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_stepcontrol.step5sub3',
			'config' => [
				'type' => 'check',
			],
		],
		'step5sub4' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_stepcontrol.step5sub4',
			'config' => [
				'type' => 'check',
			],
		],
		'step5sub5' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_stepcontrol.step5sub5',
			'config' => [
				'type' => 'check',
			],
		],
		'step6' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_stepcontrol.step6',
			'config' => [
				'type' => 'check',
			],
		],

		'wepstra' => [
			'config' => [
				'type' => 'passthrough',
			],
		],
	],
];
