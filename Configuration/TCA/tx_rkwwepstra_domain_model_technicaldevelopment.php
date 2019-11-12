<?php
return [
	'ctrl' => [
		'hideTable' => 1,
		'title'	=> 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_technicaldevelopment',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'enablecolumns' => [
		],
		'searchFields' => 'title,description,value,',
		'iconfile' => 'EXT:rkw_wepstra/Resources/Public/Icons/tx_rkwwepstra_domain_model_technicaldevelopment.gif'
	],
	'interface' => [
			'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, description, value',
	],
	'types' => [
			'1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden,--palette--;;1, title, description, valu, percentage'],
	],
	'palettes' => [
			'1' => ['showitem' => ''],
	],
	'columns' => [

		'title' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_technicaldevelopment.title',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'description' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_technicaldevelopment.description',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			],
		],
		'value' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_technicaldevelopment.value',
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
