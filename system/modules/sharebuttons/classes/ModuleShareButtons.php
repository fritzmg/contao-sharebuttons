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


class ModuleShareButtons extends Module
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'sharebuttons_default';

    /**
     * Generate module
     */
    protected function compile()
    {
        if( $this->sharebuttons_template )
        {
            $this->Template = new FrontendTemplate( $this->sharebuttons_template );
        }

        // add settings to template
        $this->Template->facebook = $this->sharebuttons_facebook;
        $this->Template->twitter = $this->sharebuttons_twitter;
        $this->Template->gplus = $this->sharebuttons_gplus;
        $this->Template->linkedin = $this->sharebuttons_linkedin;
        $this->Template->xing = $this->sharebuttons_xing;
        $this->Template->mail = $this->sharebuttons_mail;
        $this->Template->usecss = $this->sharebuttons_usecss;
        $this->Template->theme = $this->sharebuttons_theme;

        if( $this->sharebuttons_usecss && TL_MODE == 'FE' )
        {
            $base = 'system/modules/sharebuttons/assets/sharebuttons_base.css';
            $theme = 'system/modules/sharebuttons/assets/'.$this->sharebuttons_theme.'.css';

            if( !is_array( $GLOBALS['TL_CSS'] ) )
                $GLOBALS['TL_CSS'] = array();

            if( !in_array( $base, $GLOBALS['TL_CSS'] ) )
                $GLOBALS['TL_CSS'][] = $base;

            if( !in_array( $theme, $GLOBALS['TL_CSS'] ) && $this->sharebuttons_theme != 'sharebuttons_none' )
                $GLOBALS['TL_CSS'][] = $theme;
        }
    }
}
?>
