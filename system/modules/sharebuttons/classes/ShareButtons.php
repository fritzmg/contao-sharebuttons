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
    public static function createShareButtons( $networks, $theme = '', $template = 'sharebuttons_default', $url = null, $title = null, $description = null, $image = null )
    {
        // access to page
        global $objPage;

        // try to deserialize
        if( is_string( $networks ) )
            $networks = deserialize( $networks );

        // if there are no networks, don't do anything
        if( !is_array( $networks ) || count( $networks ) == 0 )
            return '';

        // process theme
        if( $theme == 'sharebuttons_none' || $theme == 'none' || !in_array( $theme, array_keys( $GLOBALS['sharebuttons']['themes'] ) ) )
            $theme = '';

        // force theme to fontawesome if fontawesome template is used
        if( stripos( $template, 'fontawesome' ) !== false && $theme !== '' && $theme !== 'text' )
            $theme = 'fontawesome';

        // create share buttons template
        $objButtonsTemplate = new FrontendTemplate( $template );

        // assign enabled networks to template
        foreach( $networks as $network )
            $objButtonsTemplate->$network = true;

        // determine the share image (e.g. for pinterest)
        if( !$image && isset( $GLOBALS['SOCIAL_IMAGES'] ) && is_array( $GLOBALS['SOCIAL_IMAGES'] ) && count( $GLOBALS['SOCIAL_IMAGES'] ) > 0 )
            $image = \Environment::get('base') . $GLOBALS['SOCIAL_IMAGES'][0];

        // assign url, title, theme, image, description to template
        $objButtonsTemplate->url         = rawurlencode( $url ?: \Environment::get('base') . \Environment::get('request') );
        $objButtonsTemplate->title       = rawurlencode( strip_tags( $title ?: ( $objPage->pageTitle ?: $objPage->title ) ) );
        $objButtonsTemplate->theme       = $theme;
        $objButtonsTemplate->image       = rawurlencode( $image );
        $objButtonsTemplate->description = rawurlencode( strip_tags( $description ?: $objPage->description ) );

        // insert CSS if necessary
        if( $theme )
        {
            $GLOBALS['TL_CSS'][] ='system/modules/sharebuttons/assets/base.css||static';
            $css_theme = $GLOBALS['sharebuttons']['themes'][ $theme ][1];
            if( is_file( TL_ROOT . '/' . $css_theme ) )
                $GLOBALS['TL_CSS'][] = $css_theme.'||static';
        }

        // insert javascript
        $GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/sharebuttons/assets/scripts.js|static';

        // return parsed template
        return $objButtonsTemplate->parse();
    }

    public function parseArticles($objTemplate, $arrData, $news)
    {
        // get the news archive
        $objArchive = \NewsArchiveModel::findById( $arrData['pid'] );

        // get the networks for the archive
        $networksArchive = deserialize( $objArchive->sharebuttons_networks ); 

        // get the networks for the article
        $networksArticle = deserialize( $arrData['sharebuttons_networks'] );

        // create merged networks
        $networksMerged = array();
        if( is_array( $networksArchive ) && is_array( $networksArticle ) )
            $networksMerged = array_unique( array_merge( $networksArchive, $networksArticle ) );
        else
            $networksMerged = is_array( $networksArchive ) ? $networksArchive : ( is_array( $networksArticle ) ? $networksArticle : array() );

        // prepare sharebuttons string
        $strSharebuttons = '';

        // check if there are any networks
        if( count( $networksMerged ) > 0 )
        {
            // set data
            $networks    = $networksMerged;
            $theme       = $arrData['sharebuttons_theme'] ?: $objArchive->sharebuttons_theme;
            $template    = $arrData['sharebuttons_template'] != 'sharebuttons_default' ? $arrData['sharebuttons_template'] : $objArchive->sharebuttons_template;
            $url         = \Environment::get('base') . $objTemplate->link;
            $title       = $arrData['headline'];
            $description = $arrData['teaser'];
            $image       = \Environment::get('base') . $objTemplate->singleSRC;

            // create the share buttons
            $strSharebuttons = self::createShareButtons( $networks, $theme, $template, $url, $title, $description, $image );
        }

        // set sharebuttons string
        $objTemplate->sharebuttons = $strSharebuttons;
    }

    public function replaceInsertTags( $strTag, $blnCache = false )
    {
        // split tag
        $arrTag = explode( '::', $strTag );

        // check for share button tag
        if( $arrTag[0] !== 'sharebuttons' )
            return false;

        // check for parameters
        if( count( $arrTag ) <= 1 )
            return '';

        // determine theme
        $theme = '';
        if( in_array( $arrTag[1], array_keys( $GLOBALS['sharebuttons']['themes'] ) ) )
            $theme = $arrTag[1];

        // now get the networks
        $networks = array();
        if( count( $arrTag ) == 2 )
            $networks = explode( ':', $arrTag[1] );
        elseif( count( $arrTag ) == 3 )
            $networks = explode( ':', $arrTag[2] );

        // validate networks
        $networks = array_intersect( $networks, array_keys( $GLOBALS['sharebuttons']['networks'] ) );

        // create sharebuttons
        return self::createShareButtons( $networks, $theme );
    }


    /**
     * DCA functions
     */
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
