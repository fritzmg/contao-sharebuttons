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
 * Add palettes to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['sharebuttons'] = '{title_legend},name,headline,type;{sharebuttons_legend},sharebuttons_networks,sharebuttons_theme,sharebuttons_template;{sharebuttons_css_legend},sharebuttons_usecss;{expert_legend},cssID,align,space';

/**
 * Add fields to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['sharebuttons_networks'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['sharebuttons_networks'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options_callback'		  => array('tl_module_sharebuttons','getNetworks'),
	'eval'                    => array('multiple'=>true),
	'sql'                     => "text NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['sharebuttons_theme'] = array(
	'label'                 => &$GLOBALS['TL_LANG']['tl_module']['sharebuttons_theme'],
	'exclude'				=> true,
	'inputType'				=> 'select',
	'options_callback'		=> array('tl_module_sharebuttons','getButtonThemes'),
	'eval'                  => array('tl_class'=>'w50'),
	'sql'                   => "varchar(32) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['sharebuttons_template'] = array(
	'label'                 => &$GLOBALS['TL_LANG']['tl_module']['sharebuttons_template'],
	'exclude'				=> true,
	'inputType'				=> 'select',
	'options_callback'		=> array('tl_module_sharebuttons','getSharebuttonsTemplates'),
	'eval'                  => array('tl_class'=>'w50'),
	'sql'                   => "varchar(32) NOT NULL default ''"
);


class tl_module_sharebuttons extends Backend
{
	public function getNetworks()
	{
		return $GLOBALS['sharebuttons']['networks'];
	}

	public function getButtonThemes()
	{
		$themes = array( '' => $GLOBALS['TL_LANG']['sharebuttons']['no_theme'] );
		foreach( $GLOBALS['sharebuttons']['themes'] as $k => $v )
			$themes[$k] = $v[0];
		return $themes;
	}

	public function getSharebuttonsTemplates(DataContainer $dc)
	{
		$intPid = $dc->activeRecord->pid;

		if (\Input::get('act') == 'overrideAll')
		{
			$intPid = \Input::get('id');
		}

		return $this->getTemplateGroup('sharebuttons_', $intPid);
	}
}