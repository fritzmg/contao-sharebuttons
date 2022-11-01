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

use Contao\ContentElement;

class ContentShareButtons extends ContentElement
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
        if(ShareButtons::isBackendRequest())
            $this->Template->sharebuttons = ShareButtons::createShareButtons($this->sharebuttons_networks, 
                                                                             $this->sharebuttons_theme, 
                                                                             $this->sharebuttons_template,
                                                                             null,
                                                                             null,
                                                                             null,
                                                                             null,
                                                                             $this->pid);
        // otherwise generate insert tag
        else
            $this->Template->sharebuttons = ShareButtons::createInsertTag($this->sharebuttons_networks, 
                                                                          $this->sharebuttons_theme, 
                                                                          $this->sharebuttons_template,
                                                                          $this->pid);
    }
}
