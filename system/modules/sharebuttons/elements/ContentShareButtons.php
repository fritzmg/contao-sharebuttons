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


class ContentShareButtons extends \ContentElement
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'ce_sharebuttons';

    /**
     * Generate module
     */
    protected function compile()
    {
        // show share buttons in backend
        if( TL_MODE == 'BE' )
            $this->Template->sharebuttons = ShareButtons::createShareButtons( $this->sharebuttons_networks, 
                                                                              $this->sharebuttons_theme, 
                                                                              $this->sharebuttons_template );
        // otherwise generate insert tag
        else
            $this->Template->sharebuttons = ShareButtons::createInsertTag( $this->sharebuttons_networks, 
                                                                           $this->sharebuttons_theme, 
                                                                           $this->sharebuttons_template );
    }
}
