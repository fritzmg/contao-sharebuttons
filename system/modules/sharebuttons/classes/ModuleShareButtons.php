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
    protected $strTemplate = 'mod_sharebuttons';

    /**
     * Generate module
     */
    protected function compile()
    {
        global $objPage;

        $sharebuttons_networks = deserialize( $this->sharebuttons_networks );
        $sharebuttons_theme = $this->sharebuttons_theme;
        $objButtonsTemplate = new FrontendTemplate( $this->sharebuttons_template );
        foreach( $sharebuttons_networks as $v )
            $objButtonsTemplate->$v = true;
        $objButtonsTemplate->url = rawurlencode( \Environment::get('base') . \Environment::get('request') );
        $objButtonsTemplate->title = rawurlencode( $objPage->pageTitle );
        $objButtonsTemplate->theme = $sharebuttons_theme;
        $this->Template->sharebuttons = $objButtonsTemplate->parse();

        if( $sharebuttons_theme && TL_MODE == 'FE' )
        {
            $css_base  = 'system/modules/sharebuttons/assets/sharebuttons_base.css';
            $css_theme = 'system/modules/sharebuttons/assets/'.$sharebuttons_theme.'.css';

            if( !is_array( $GLOBALS['TL_CSS'] ) )
                $GLOBALS['TL_CSS'] = array();

            if( !in_array( $css_base, $GLOBALS['TL_CSS'] ) )
                $GLOBALS['TL_CSS'][] = $css_base;

            if( !in_array( $css_theme, $GLOBALS['TL_CSS'] ) && $sharebuttons_theme != 'sharebuttons_text' )
                $GLOBALS['TL_CSS'][] = $css_theme;
        }
    }
}
?>
