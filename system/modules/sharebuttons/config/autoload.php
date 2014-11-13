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
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'ModuleShareButtons' => 'system/modules/sharebuttons/classes/ModuleShareButtons.php'
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'sharebuttons_default' => 'system/modules/sharebuttons/templates'
));