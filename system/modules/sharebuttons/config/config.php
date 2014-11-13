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