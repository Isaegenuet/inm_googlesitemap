<?php

/***************************************************************
 * Extension Manager/Repository config file for ext: "inm_googlesitemap"
 *
 * Auto generated by Extension Builder 2016-02-02
 *
 * Manual updates:
 * Only the data in the array - anything else is removed by next write.
 * "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'INM Google Sitemap',
	'description' => 'Generates a google sitemap by crawling the given URL with PHPCrawl library.',
	'category' => 'services',
	'author' => 'Ralf Merz',
	'author_email' => 'mail@merzilla.de',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => '0',
	'createDirs' => '',
	'clearCacheOnLoad' => 0,
	'version' => '0.3.3',
	'constraints' => array(
		'depends' => array(
			'typo3' => '6.2.0-7.6.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
);
