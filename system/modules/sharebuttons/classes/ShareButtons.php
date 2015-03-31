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
    // dirty hack, so that ShareButtons::parseArticles is more likely the last parseArticles hook
    // so that the image is available from the social_images extension
    public function insertParseArticlesHook()
    {
        // check if there is an array of hooks yet
        if( !is_array( $GLOBALS['TL_HOOKS']['parseArticles'] ) )
            $GLOBALS['TL_HOOKS']['parseArticles'] = array();

        // get the index of the SocialImages::collectNewsImages hook, if present
        $index = 0;
        foreach( $GLOBALS['TL_HOOKS']['parseArticles'] as $hook )
        {
            if( $hook[0] == 'SocialImages' && $hook[1] == 'collectNewsImages' );
                break;
            ++$index;
        }

        // insert our hook
        array_splice( $GLOBALS['TL_HOOKS']['parseArticles'], $index + 1, 0, array( array('ShareButtons','parseArticles') ) );
    }

    public static function createShareButtons( $networks, $theme = '', $template = 'sharebuttons_default', $url = null, $title = null, $description = null, $image = null )
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

        // determine the share image (e.g. for pinterest)
        $image = $image ?: null;
        if( !$image && isset( $GLOBALS['SOCIAL_IMAGES'] ) && is_array( $GLOBALS['SOCIAL_IMAGES'] ) && count( $GLOBALS['SOCIAL_IMAGES'] ) > 0 )
            $image = \Environment::get('base') . $GLOBALS['SOCIAL_IMAGES'][0];

        // assign url, title, theme to template
        $objButtonsTemplate->url         = $url   ?: rawurlencode( \Environment::get('base') . \Environment::get('request') );
        $objButtonsTemplate->title       = $title ?: rawurlencode( $objPage->pageTitle ?: $objPage->title );
        $objButtonsTemplate->theme       = $theme;
        $objButtonsTemplate->image       = $image ?: rawurlencode( $image );
        $objButtonsTemplate->description = $description ?: rawurlencode( strip_tags( $objPage->description ) );

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

    public function parseArticles(&$objTemplate, $arrData, $news)
    {
        if( $arrData['sharebuttons_networks'] )
        {
            // extract data from news article
            $networks = $arrData['sharebuttons_networks'];
            $theme    = $arrData['sharebuttons_theme'];
            $template = $arrData['sharebuttons_template'];
            $url = rawurlencode( \Environment::get('url').'/'.$objTemplate->link );
            $title = rawurlencode( $arrData['headline'] );
            $description = rawurlencode( strip_tags( $arrData['teaser'] ) );

            // create the share buttons
            $objTemplate->sharebuttons = self::createShareButtons( $networks, $theme, $template, $url, $title, $description );
        }
    }
}
