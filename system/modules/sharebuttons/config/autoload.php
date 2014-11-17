<?php

/**
 * Contao Open Source CMS
 *
 * simple extension to provide a share buttons module
 * 
 * @copyright inspiredminds 2014
 * @package   sharebuttons
 * @link      http://www.inspiredminds.at
 * @author    Fritz Michael Gschwantner <fmg@inspiredminds.at>
 * @license   GPL-2.0
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
	'mod_sharebuttons'     => 'system/modules/sharebuttons/templates',
	'sharebuttons_default' => 'system/modules/sharebuttons/templates',
	'ce_sharebuttons'      => 'system/modules/sharebuttons/templates'
));