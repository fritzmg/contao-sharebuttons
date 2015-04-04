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


class ModuleShareButtons extends \Module
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_sharebuttons';

    /**
     * Generate module
     */
    protected function compile()
    {
        $this->Template->sharebuttons = ShareButtons::createInsertTag( $this->sharebuttons_networks, 
                                                                       $this->sharebuttons_theme, 
                                                                       $this->sharebuttons_template );
    }
}
