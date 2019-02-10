<?php

/**
 * Contao Open Source CMS
 *
 * simple extension to provide a share buttons module
 * 
 * @copyright inspiredminds 2014-2019
 * @package   sharebuttons
 * @link      http://www.inspiredminds.at
 * @author    Fritz Michael Gschwantner <fmg@inspiredminds.at>
 * @license   LGPL-3.0-or-later
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'ModuleShareButtons'  => 'system/modules/sharebuttons/modules/ModuleShareButtons.php',
	'ShareButtons'        => 'system/modules/sharebuttons/classes/ShareButtons.php',
	'ContentShareButtons' => 'system/modules/sharebuttons/elements/ContentShareButtons.php'
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'ce_sharebuttons'          => 'system/modules/sharebuttons/templates',
	'mod_sharebuttons'         => 'system/modules/sharebuttons/templates',
	'sharebuttons_default'     => 'system/modules/sharebuttons/templates',
	'sharebuttons_fontawesome' => 'system/modules/sharebuttons/templates'
));
