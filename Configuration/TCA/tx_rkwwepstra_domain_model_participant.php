<?php
return [
	'ctrl' => [
		'hideTable' => 1,
		'title'	=> 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_participant',
		'label' => 'username',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'enablecolumns' => [
		],
		'searchFields' => 'first_name,last_name,username,',
		'iconfile' => 'EXT:rkw_wepstra/Resources/Public/Icons/tx_rkwwepstra_domain_model_participant.gif'
	],
	'interface' => [
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, first_name, last_name, username',
	],
	'types' => [
		'1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden,--palette--;;1, first_name, last_name, username'],
	],
	'palettes' => [
		'1' => ['showitem' => ''],
	],
	'columns' => [

		'first_name' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_participant.first_name',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'last_name' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_participant.last_name',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'username' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_participant.username',
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
