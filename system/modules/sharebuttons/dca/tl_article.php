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
 * Change default palette of tl_article
 */
$GLOBALS['TL_DCA']['tl_article']['palettes']['default'] = str_replace(',printable;{template', ',printable;{sharebuttons_legend},sharebuttons_networks,sharebuttons_theme,sharebuttons_template;{template', $GLOBALS['TL_DCA']['tl_article']['palettes']['default']);

/**
 * Add fields to tl_article
 */
$GLOBALS['TL_DCA']['tl_article']['fields']['sharebuttons_networks'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['sharebuttons']['sharebuttons_networks'],
	'exclude'                 => true,
	'inputType'               => 'checkboxWizard',
	'options_callback'		  => array('ShareButtons','getNetworks'),
	'eval'                    => array('multiple'=>true,'tl_class'=>'w50'),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_article']['fields']['sharebuttons_theme'] = array(
	'label'                 => &$GLOBALS['TL_LANG']['sharebuttons']['sharebuttons_theme'],
	'exclude'				=> true,
	'inputType'				=> 'select',
	'options_callback'		=> array('ShareButtons','getButtonThemes'),
	'eval'                  => array('tl_class'=>'w50'),
	'sql'                   => "varchar(32) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_article']['fields']['sharebuttons_template'] = array(
	'label'                 => &$GLOBALS['TL_LANG']['sharebuttons']['sharebuttons_template'],
	'exclude'				=> true,
	'inputType'				=> 'select',
	'options_callback'		=> array('ShareButtons','getSharebuttonsTemplates'),
	'eval'                  => array('tl_class'=>'w50'),
	'sql'                   => "varchar(64) NOT NULL default ''"
);
