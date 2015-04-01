<?php

/**
 * Contao Open Source CMS
 *
 * simple extension to provide a share buttons module
 * 
 * @copyright inspiredminds 2015
 * @package   sharebuttons
 * @link      http://www.inspiredminds.at
 * @author    Fritz Michael Gschwantner <fmg@inspiredminds.at>
 * @license   GPL-2.0
 */


/**
 * Front end modules
 */
$GLOBALS['FE_MOD']['miscellaneous']['sharebuttons'] = 'ModuleShareButtons';


/**
 * Content elements
 */
$GLOBALS['TL_CTE']['links']['sharebuttons'] = 'ContentShareButtons';


/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['parseArticles'][] = array('ShareButtons','parseArticles');
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('ShareButtons','replaceInsertTags');


/**
 * CSS
 */
if( TL_MODE == 'BE' )
	$GLOBALS['TL_CSS'][] = 'system/modules/sharebuttons/assets/backend.css';


/**
 * Custom settings
 */
$GLOBALS['sharebuttons']['networks'] = array(
	'facebook' => 'Facebook',
	'twitter' => 'Twitter',
	'gplus' => 'Google+',
	'linkedin' => 'LinkedIn',
	'xing' => 'Xing',
	'mail' => 'E-Mail',
	'tumblr' => 'tumblr',
	'pinterest' => 'Pinterest',
	'reddit' => 'Reddit'
);

$GLOBALS['sharebuttons']['themes'] = array(
	'text'              => array('Text'              ,''),
	'boxxed'            => array('Boxxed'            ,'system/modules/sharebuttons/assets/boxxed/boxxed.css'),
	'boxxed_16'         => array('Boxxed (16px)'     ,'system/modules/sharebuttons/assets/boxxed/boxxed_16.css'),
	'contao'            => array('Contao'            ,'system/modules/sharebuttons/assets/contao.css'),
	'light'             => array('Light'             ,'system/modules/sharebuttons/assets/light/light.css'),
	'shadow'            => array('Shadow'            ,'system/modules/sharebuttons/assets/shadow/shadow.css'),
	'simpleflat'        => array('Simple Flat'       ,'system/modules/sharebuttons/assets/simpleflat/simpleflat.css'),
	'simpleicons_black' => array('Simple Icons Black','system/modules/sharebuttons/assets/simpleicons/simpleicons_black.css'),
	'simpleicons_white' => array('Simple Icons White','system/modules/sharebuttons/assets/simpleicons/simpleicons_white.css'),
	'fontawesome'       => array('Font Awesome'      ,'system/modules/sharebuttons/assets/fontawesome.css')
);
