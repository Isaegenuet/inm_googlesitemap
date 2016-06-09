<?php
/***************************************************************
 *  Copyright notice
 *  (c) 2016 Ralf Merz <ralf.merz@inm.ch>, INM AG
 *  All rights reserved
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * @package SitemapGenerator.php
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

namespace INM\InmGooglesitemap\Generators;

require_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('inm_googlesitemap') . 'Libraries/PHPCrawl/libs/PHPCrawler.class.php');

class SitemapGenerator extends \PHPCrawler {

	protected $sitemapTemporaryOutputFile;

	protected $sitemapFinalOutputFile;

	public function setSitemapOutputFile($file) {
		$this->sitemapTemporaryOutputFile = PATH_site . '_temporary_' . $file;
		$this->sitemapFinalOutputFile = PATH_site . $file;

		if (file_exists($this->sitemapTemporaryOutputFile)) {
			unlink($this->sitemapTemporaryOutputFile);
		}

		file_put_contents($this->sitemapTemporaryOutputFile,
				"<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n" .
				"<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\r\n",
				FILE_APPEND);
	}

	public function handleDocumentInfo($DocInfo) {
		if ($DocInfo->error_occured === TRUE) {
			$message = 'Error Code: ' . $DocInfo->error_code . ' --- Reason: ' . $DocInfo->error_string;
			$GLOBALS['BE_USER']->simplelog($message, $extKey = 'inm_googlesitemap', $error = 0);
		} else {
			$urlForFile = $DocInfo->protocol . $DocInfo->host . $DocInfo->path . htmlspecialchars($DocInfo->query);

			file_put_contents($this->sitemapTemporaryOutputFile, " <url>\r\n" .
					"  <loc>" . $urlForFile . "</loc>\r\n" .
					" </url>\r\n", FILE_APPEND);
		}
	}

	public function closeFile() {
		file_put_contents($this->sitemapTemporaryOutputFile, '</urlset>', FILE_APPEND);
	}

	public function publishFile() {
		rename($this->sitemapTemporaryOutputFile, $this->sitemapFinalOutputFile);
	}
}
?>