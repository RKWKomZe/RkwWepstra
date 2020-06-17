<?php

/***************************************************************
 * Extension Manager/Repository config file for ext: "rkw_wepstra"
 *
 * Auto generated by Extension Builder 2015-11-11
 *
 * Manual updates:
 * Only the data in the array - anything else is removed by next write.
 * "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = [
	'title' => 'RKW Wepstra',
	'description' => '',
	'category' => 'plugin',
	'author' => 'Maximilian Fäßler',
	'author_email' => '',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => '0',
	'createDirs' => '',
	'clearCacheOnLoad' => 0,
	'version' => '8.7.4',
	'constraints' => [
		'depends' => [
            'typo3' => '7.6.0-7.6.99',
            'rkw_registration' => '8.7.0-8.7.99',
			'rkw_basics' => '8.7.0-8.7.99',
		],
		'conflicts' => [
		],
		'suggests' => [
		],
	],
];