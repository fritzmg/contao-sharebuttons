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
 

$GLOBALS['TL_DCA']['tl_news_archive']['palettes']['default'] .= ';{sharebuttons_legend},sharebuttons_networks,sharebuttons_theme,sharebuttons_template';

$GLOBALS['TL_DCA']['tl_news_archive']['fields']['sharebuttons_networks'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['sharebuttons']['sharebuttons_networks'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options_callback'		  => array('ShareButtons','getNetworks'),
	'eval'                    => array('multiple'=>true),
	'sql'                     => "text NULL"
);

$GLOBALS['TL_DCA']['tl_news_archive']['fields']['sharebuttons_theme'] = array(
	'label'                 => &$GLOBALS['TL_LANG']['sharebuttons']['sharebuttons_theme'],
	'exclude'				=> true,
	'inputType'				=> 'select',
	'options_callback'		=> array('ShareButtons','getButtonThemes'),
	'eval'                  => array('tl_class'=>'w50'),
	'sql'                   => "varchar(32) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_news_archive']['fields']['sharebuttons_template'] = array(
	'label'                 => &$GLOBALS['TL_LANG']['sharebuttons']['sharebuttons_template'],
	'exclude'				=> true,
	'inputType'				=> 'select',
	'options_callback'		=> array('ShareButtons','getSharebuttonsTemplates'),
	'eval'                  => array('tl_class'=>'w50'),
	'sql'                   => "varchar(32) NOT NULL default ''"
);
