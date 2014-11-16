<?php

/**
 * Contao Open Source CMS
 *
 * simple extension to provide a share buttons module
 * 
 * Copyright (C) 2013 Fritz Michael Gschwantner
 * 
 * @package sharebuttons
 * @link    http://www.inspiredminds.at
 * @author  Fritz Michael Gschwantner <fmg@inspiredminds.at>
 * @license GPL-2.0
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


/**
 * Custom settings
 */
$GLOBALS['sharebuttons']['networks'] = array(
	'facebook' => 'Facebook',
	'twitter' => 'Twitter',
	'gplus' => 'Google+',
	'linkedin' => 'LinkedIn',
	'xing' => 'Xing',
	'mail' => 'E-Mail'
);

$GLOBALS['sharebuttons']['themes'] = array(
	''                               => '-',
	'sharebuttons_text'              => 'Text',
	'sharebuttons_boxxed'            => 'Boxxed',
	'sharebuttons_boxxed_16'         => 'Boxxed (16px)',
	'sharebuttons_light'             => 'Light',
	'sharebuttons_shadow'            => 'Shadow',
	'sharebuttons_simpleflat'        => 'Simple Flat',
	'sharebuttons_simpleicons_black' => 'Simple Icons Black',
	'sharebuttons_simpleicons_white' => 'Simple Icons White'
);