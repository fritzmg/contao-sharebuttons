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
 * Add palettes to tl_content
 */
$GLOBALS['TL_DCA']['tl_content']['palettes']['sharebuttons'] = '{type_legend},type,headline;{sharebuttons_legend},sharebuttons_networks,sharebuttons_theme,sharebuttons_template;{expert_legend},cssID,align,space';

/**
 * Add fields to tl_content
 */
$GLOBALS['TL_DCA']['tl_content']['fields']['sharebuttons_networks'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['sharebuttons']['sharebuttons_networks'],
	'exclude'                 => true,
	'inputType'               => 'checkboxWizard',
	'options_callback'		  => array('ShareButtons','getNetworks'),
	'eval'                    => array('multiple'=>true,'tl_class'=>'w50'),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['sharebuttons_theme'] = array(
	'label'                 => &$GLOBALS['TL_LANG']['sharebuttons']['sharebuttons_theme'],
	'exclude'				=> true,
	'inputType'				=> 'select',
	'options_callback'		=> array('ShareButtons','getButtonThemes'),
	'eval'                  => array('tl_class'=>'w50'),
	'sql'                   => "varchar(32) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['sharebuttons_template'] = array(
	'label'                 => &$GLOBALS['TL_LANG']['sharebuttons']['sharebuttons_template'],
	'exclude'				=> true,
	'inputType'				=> 'select',
	'options_callback'		=> array('ShareButtons','getSharebuttonsTemplates'),
	'eval'                  => array('tl_class'=>'w50'),
	'sql'                   => "varchar(64) NOT NULL default ''"
);
