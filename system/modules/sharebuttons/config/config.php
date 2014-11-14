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
array_insert($GLOBALS['FE_MOD']['miscellaneous'], 1, array
(
	'sharebuttons' => 'ModuleShareButtons'
));

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
	'text'              => 'Text',
	'boxxed'            => 'Boxxed',
	'boxxed_16'         => 'Boxxed (16px)',
	'light'             => 'Light',
	'shadow'            => 'Shadow',
	'simpleflat'        => 'Simple Flat',
	'simpleicons_black' => 'Simple Icons Black',
	'simpleicons_white' => 'Simple Icons White'
);