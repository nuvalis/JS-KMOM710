<?php

#include "config.theme.php";

/**
 * Theme related functions. 
 *
 */

/**
 * Get title for the webpage by concatenating page specific title with site-wide title.
 *
 * @param string $title for this page.
 * @param string $titleAppend a general title to append.
 * @return string/null wether the favicon is defined or not.
 */
/*function get_title($title, $titleAppend = null) {
  return $title . $title_append;
}

*/


function themeLinks() {

	$di  = new \Anax\DI\CDIFactoryDefault();

	$url = $di->url->getBaseUrl();

	$baseUrl = dirname($url) . "/theme/" . basename(dirname(__FILE__));

	//$link = '<link rel="stylesheet" type="text/css" href="' . $baseUrl . "/stylephp/style.php" . '">';
	$link = '<link rel="stylesheet/less" type="text/css" href="' . $baseUrl . "/css/main.less" . '">';
	$link .= '<script src="' . $baseUrl . "/js/less.min.js" . '"></script>';
	$link .= '<script src="' . $baseUrl . "/js/theme.js" . '"></script>';
	return $link;

}

