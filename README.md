# What does it do?
This is a TYPO3 CMS extension. It provides an Extbase Command Controller task to generate 
a sitemap.xml by using the PHPCrawl library.
It parses the given URL and finds all links in the HTML an follows them. So it works like a frontend crawler.

# Usage
After installing the extension (activating it in your Extension Manager) you have to create a new Scheduler Task using
the `Extbase CommandController Task`. Select `InmGooglesitemap Sitemap: generateSitemap` as command and then you´ll get
the following options. (Besides the default cron options of TYPO3).

You may get this extension via Git clone or composer to your preferred destination.

# Scheduler Task Options / Arguments for the crawling process
## url: The URL entry point for crawling.
*http://example.com* - This will be the entry point for crawling, the first URL that will be called.

## sitemapFileName: File name of the XML file. Default is "sitemap.xml".
*sitemap.xml* - This file will be saved in your webroot, so the sitemap will be reachable under URL `http://example.com/sitemap.xml`

## regexFileEndings: Regular expression for file endings to skip
*#\\.(jpg|jpeg|gif|png|mp3|mp4|gz|ico)$# i* - per default, URLs having one of these file endings will be skipped

## regexDirectoryExclude: Regular expression for directories to skip.
*#\\/(typo3conf|fileadmin|uploads)\\/.\*$# i* - per default, these paths are skipped when found in URL
 
## obeyRobotsTxt: Check to obey rules from robots.txt
Check this if you want to obey the rules in robots.txt

## requestLimit: Max number of URLs to crawl.
*0* - Default is "0" which means `no limit`. Enter a number > 0 to set a limit.

## countOnlyProcessed: Check if only fetched URLs should count for $requestLimit.
Checkbox to fine tune the limit of max requested URLs.

## phpTimeLimit: Value in seconds for setting time limit. Default = 10000.
*10000* - is the default value.

## htmlSuffix: Default true: will only allow .htm|.html endings. Will also exclude query strings
Checkbox to tell the crawler that a URL must end with `.html` or `.html`.

## linkExtractionTags: By default the crawler searches for links in the following html-tags: 
href, src, url, location, codebase, background, data, profile, action and open. You may change this comma-separated list

## useTransferProtocol: Enter transfer protocol to use: http (=default) or https. URLs with wrong protocol will not be written.
*http* - maybe if you use a prox you have to set the protocol that must be prepended to the URLs.


# Big Thanks to Uwe Hunfeld for th GPL licensed PHPCrawl library
http://phpcrawl.cuab.de

PHPCrawl is completly free opensource software and is licensed under the GNU GENERAL PUBLIC LICENSE v2

# More to know
The PHPCrawl Library offers the possibility to use multi-processes. But there are a few requirements which may be not on
every webserver.
http://phpcrawl.cuab.de/requirements.html

For the moment, the extension has the multi-process not implemented yet. It is planned to be able to activate it in the 
Scheduler Task settings, too.

## A temporary file
While the process runs, it generates a file named `_temporary_sitemap.xml` which will be renamed to `sitemap.xml` (or the 
given name in the settings), after the Scheduler Task run successfully.

## The generated sitemap.xml
The `sitemap.xml` only contains the URLs that the crawling process has found, which is the minimum requirement for a XML
sitemap. This means we do not extend `pages` with fields like `priority` or add dates. I think that´ ok as Google does a
good job either.