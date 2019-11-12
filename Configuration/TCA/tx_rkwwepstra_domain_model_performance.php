<?php
return [
	'ctrl' => [
		'hideTable' => 1,
		'title'	=> 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_performance',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'enablecolumns' => [
		],
		'searchFields' => 'title,description,value,influence,knowledge,',
		'iconfile' => 'EXT:rkw_wepstra/Resources/Public/Icons/tx_rkwwepstra_domain_model_performance.gif'
	],
	'interface' => [
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, description, value, influence, knowledge, type',
	],
	'types' => [
		'Tx_RkwWepstra_Item' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden,--palette--;;1, title, description, value, influence, knowledge, type'],
	],
	'palettes' => [
		'1' => ['showitem' => ''],
	],
	'columns' => [
	
		'title' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_performance.title',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'description' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_performance.description',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			],
		],
		'value' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_performance.value',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'influence' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_performance.influence',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'knowledge' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_performance.knowledge',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'type' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_performance.type',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],

		'wepstra' => [
			'config' => [
				'type' => 'passthrough',
			],
		],
	],
];
