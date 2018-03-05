<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('inm_googlesitemap', 'Configuration/TypoScript', 'INM Google Sitemap');
