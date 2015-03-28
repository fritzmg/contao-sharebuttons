<?php

/**
 * Contao Open Source CMS
 *
 * simple extension to provide a share buttons module
 * 
 * @copyright inspiredminds 2015
 * @package   sharebuttons
 * @link      http://www.inspiredminds.at
 * @author    Fritz Michael Gschwantner <fmg@inspiredminds.at>
 * @license   GPL-2.0
 */


class ShareButtons extends \Frontend
{
    public static function createShareButtons( $networks, $theme = '', $template = 'sharebuttons_default', $url = null, $title = null, $description = null )
    {
        // access to page
        global $objPage;

        // try to deserialize
        if( is_string( $networks ) )
            $networks = deserialize( $networks );

        // if there are no networks, don't do anything
        if( count( $networks ) == 0 )
            return '';

        // process theme
        if( $theme == 'sharebuttons_none' || $theme == 'none' )
            $theme = '';

        // create share buttons template
        $objButtonsTemplate = new FrontendTemplate( $template );

        // assign enabled networks to template
        foreach( $networks as $network )
            $objButtonsTemplate->$network = true;

        // assign url, title, theme to template
        $objButtonsTemplate->url         = $url   ?: rawurlencode( \Environment::get('base') . \Environment::get('request') );
        $objButtonsTemplate->title       = $title ?: rawurlencode( $objPage->pageTitle?: $objPage->title );
        $objButtonsTemplate->theme       = $theme;
        $objButtonsTemplate->image       = $GLOBALS['share_image'] ? rawurlencode( $GLOBALS['share_image'] ) : '';
        $objButtonsTemplate->description = $description ?: rawurlencode( $objPage->description );

        // insert CSS if necessary
        if( $theme )
        {
            $css_base  = 'system/modules/sharebuttons/assets/base.css';
            $css_theme = $GLOBALS['sharebuttons']['themes'][ $theme ][1];

            if( !is_array( $GLOBALS['TL_CSS'] ) )
                $GLOBALS['TL_CSS'] = array();

            if( !in_array( $css_base, $GLOBALS['TL_CSS'] ) )
                $GLOBALS['TL_CSS'][] = $css_base.'||static';

            if( !in_array( $css_theme, $GLOBALS['TL_CSS'] ) && is_file( TL_ROOT . '/' . $css_theme ) )
                $GLOBALS['TL_CSS'][] = $css_theme.'||static';
        }

        // insert javascript
        $js = 'system/modules/sharebuttons/assets/scripts.js|static';

        if( !is_array( $GLOBALS['TL_JAVASCRIPT'] ) )
            $GLOBALS['TL_JAVASCRIPT'] = array();

        if( !in_array( $js, $GLOBALS['TL_JAVASCRIPT'] ) )
            $GLOBALS['TL_JAVASCRIPT'][] = $js;

        // return parsed template
        return $objButtonsTemplate->parse();
    }

    public function parseArticles(&$objTemplate, $objArticle, $news)
    {
        if( $objArticle['sharebuttons_networks'] )
        {
            // extract data from news article
            $networks = $objArticle['sharebuttons_networks'];
            $theme    = $objArticle['sharebuttons_theme'];
            $template = $objArticle['sharebuttons_template'];
            $url = rawurlencode( \Environment::get('url').'/'.$objTemplate->link );
            $title = rawurlencode( $objArticle['headline'] );
            $description = $objArticle['teaser'];

            // create the share buttons
            $objTemplate->sharebuttons = self::createShareButtons( $networks, $theme, $template, $url, $title, $description );
        }
    }
}
