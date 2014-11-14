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


class ShareButtons extends \Frontend
{
    public function parseArticles(&$objTemplate, $objArticle, $news)
    {
        var_dump($news);
        if( $objArticle['sharebuttons_networks'] )
        {
            $sharebuttons_networks = deserialize( $objArticle['sharebuttons_networks'] );
            $sharebuttons_theme = $objArticle['sharebuttons_theme'];

            $objButtonsTemplate = new FrontendTemplate( $objArticle['sharebuttons_template'] );
            foreach( $sharebuttons_networks as $v )
                $objButtonsTemplate->$v = true;
            $objButtonsTemplate->url = rawurlencode( \Environment::get('url').'/'.$objTemplate->link );
            $objButtonsTemplate->title = rawurlencode( $objArticle['headline'] );
            $objButtonsTemplate->theme = $sharebuttons_theme;
            $objTemplate->sharebuttons = $objButtonsTemplate->parse();

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
}

?>
