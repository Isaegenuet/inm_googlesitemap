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
 * @package SitemapCommandController.php
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

namespace INM\InmGooglesitemap\Command;

use INM\InmGooglesitemap\Generators\SitemapGenerator;

class SitemapCommandController extends \TYPO3\CMS\Extbase\Mvc\Controller\CommandController {

	/**
	 * objectManager
	 *
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManager
	 * @inject
	 */
	protected $objectManager = NULL;

	public function generateSitemapCommand() {
		// It may take a whils to crawl a site ...
		set_time_limit(10000);

		$crawler = $this->objectManager->get('INM\InmGooglesitemap\Generators\SitemapGenerator');
		$crawler->setSitemapOutputFile("sitemap.xml"); // Set output-file, but temporary, until created.
		$crawler->setURL("www.energie-experten.ch");
		$crawler->addContentTypeReceiveRule("#text/html#");
		// exclude file endings for assets
		$crawler->addURLFilterRule("#\.(jpg|jpeg|gif|png|mp3|mp4|gz|ico)$# i");
		// exclude css and js which have unique timestamps, e.g. like "some.css?12345678"
		$crawler->addURLFilterRule("#(css|js).*$# i");
		// exclude unnecessary directories
		$crawler->addURLFilterRule("#\/(typo3conf|fileadmin|uploads)\/.*$# i");
		// exclude URLs with unnecessary query strings
		#$crawler->addURLFilterRule("#.*tx_felogin_pi1.*$# i");

		$crawler->addURLFollowRule("#(htm|html)$# i");
		$crawler->obeyRobotsTxt(TRUE);

		// ... apply all other options and rules to the crawler

		$crawler->setRequestLimit(20, TRUE); // Just for testing
		//$crawler->goMultiProcessed(5); // Or use go() if you don't want multiple processes
		$crawler->go();
		$crawler->closeFile();

		// now that we are finished, hopefully, put the file into right place / name
		$crawler->publishFile();
	}
}