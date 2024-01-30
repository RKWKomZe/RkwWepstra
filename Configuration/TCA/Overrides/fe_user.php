<?php
$tempCols = [

    'tx_rkwwepstra_language_key' => [
        'label'=>'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_frontenduser.tx_rkwwepstra_language_key',
        'exclude' => 0,
        'config'=>[
            'type'=>'input',
            'size' => 20,
            'max' => '256',
            'eval' => 'trim',
        ],
    ],

	'tx_rkwwepstra_is_anonymous' => [
		'label'=>'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_frontenduser.tx_rkwwepstra_is_anonymous',
		'exclude' => 0,
		'config'=>[
			'type' => 'check',
			'readOnly' => 1,
			'default' => 0,
			'items' => [
				'1' => [
					'0' => 'LLL:EXT:rkw_wepstra/Resources/Private/Language/locallang_db.xlf:tx_rkwwepstra_domain_model_frontenduser.tx_rkwwepstra_is_anonymous'
				],
			],
		],
	],

];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users',$tempCols);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('fe_users',', tx_rkwwepstra_language_key');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('fe_users',', tx_rkwwepstra_is_anonymous');

