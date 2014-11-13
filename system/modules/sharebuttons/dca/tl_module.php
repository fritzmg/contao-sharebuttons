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
 * Add palettes to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['sharebuttons'] = '{title_legend},name,headline,type;{sharebuttons_legend},sharebuttons_facebook,sharebuttons_twitter,sharebuttons_gplus,sharebuttons_linkedin,sharebuttons_xing,sharebuttons_mail,sharebuttons_template;{expert_legend},cssID,align,space';

/**
 * Add fields to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['sharebuttons_facebook'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_module']['sharebuttons_facebook'],
	'default'   => true,
	'exclude'   => true,
	'inputType' => 'checkbox',
	'eval'      => array('tl_class'=>'w50'),
	'sql'       => "tinyint(1) unsigned NOT NULL default '1'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['sharebuttons_twitter'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_module']['sharebuttons_twitter'],
	'default'   => true,
	'exclude'   => true,
	'inputType' => 'checkbox',
	'eval'      => array('tl_class'=>'w50'),
	'sql'       => "tinyint(1) unsigned NOT NULL default '1'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['sharebuttons_gplus'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_module']['sharebuttons_gplus'],
	'default'   => true,
	'exclude'   => true,
	'inputType' => 'checkbox',
	'eval'      => array('tl_class'=>'w50'),
	'sql'       => "tinyint(1) unsigned NOT NULL default '1'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['sharebuttons_linkedin'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_module']['sharebuttons_linkedin'],
	'default'   => true,
	'exclude'   => true,
	'inputType' => 'checkbox',
	'eval'      => array('tl_class'=>'w50'),
	'sql'       => "tinyint(1) unsigned NOT NULL default '1'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['sharebuttons_xing'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_module']['sharebuttons_xing'],
	'default'   => true,
	'exclude'   => true,
	'inputType' => 'checkbox',
	'eval'      => array('tl_class'=>'w50'),
	'sql'       => "tinyint(1) unsigned NOT NULL default '1'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['sharebuttons_mail'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_module']['sharebuttons_mail'],
	'default'   => true,
	'exclude'   => true,
	'inputType' => 'checkbox',
	'eval'      => array('tl_class'=>'w50'),
	'sql'       => "tinyint(1) unsigned NOT NULL default '1'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['sharebuttons_template'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['sharebuttons_template'],
	'default'			      => 'sharebuttons_default',
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'		  => array('tl_sharebuttons_module', 'getSharebuttonsTemplates'),
	'eval'                    => array('mandatory'=>true,'tl_class'=>'w50'),
	'sql'                     => "varchar(32) NOT NULL default 'sharebuttons_default'"
);

class tl_sharebuttons_module extends Backend
{
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

?>