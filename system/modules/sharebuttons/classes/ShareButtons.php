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
    const DEFAULT_THEME = '';
    const DEFAULT_TEMPLATE = 'sharebuttons_default';

    public static function createShareButtons( $networks, $theme = self::DEFAULT_THEME, $template = self::DEFAULT_TEMPLATE, $url = null, $title = null, $description = null, $image = null )
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
        // force template to fontawesome if fontawesome theme is used
        elseif( $theme == 'fontawesome' )
            $template = 'sharebuttons_fontawesome';

        // create share buttons template
        $objButtonsTemplate = new \FrontendTemplate( $template );

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
        $objButtonsTemplate->lang        = $GLOBALS['TL_LANG']['sharebuttons'];

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

    public static function createInsertTag( $networks, $theme = '', $template = '' )
    {
        // try to deserialize
        if( is_string( $networks ) )
            $networks = deserialize( $networks );

        // check for networks
        if( !is_array( $networks ) || count( $networks ) == 0 )
            return '';

        // build insert tag
        $strInsertTag = '{{sharebuttons';
        if( $theme ) $strInsertTag.= '::'.$theme;
        if( $template ) $strInsertTag.= '::'.$template;
        $strInsertTag.= '::'.implode(':', $networks).'}}';

        // return insert tag
        return $strInsertTag;
    }

    public function parseArticles( $objTemplate, $arrData, $objModule )
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
            $template    = ( $arrData['sharebuttons_template'] && $arrData['sharebuttons_template'] != 'sharebuttons_default' ) ? $arrData['sharebuttons_template'] : $objArchive->sharebuttons_template;
            $url         = \Environment::get('base') . $objTemplate->link;
            $title       = $arrData['headline'];
            $description = $arrData['teaser'];
            $image       = ( $objTemplate->addImage && $objTemplate->singleSRC ) ? \Environment::get('base') . $objTemplate->singleSRC : null;

            // create the share buttons
            $strSharebuttons = self::createShareButtons( $networks, $theme, $template, $url, $title, $description, $image );
        }

        // set sharebuttons string
        $objTemplate->sharebuttons = $strSharebuttons;
    }

    public function replaceInsertTag( $strTag, $blnCache = false )
    {
        // split tag
        $arrTag = explode( '::', $strTag );

        // check for share button tag
        if( $arrTag[0] !== 'sharebuttons' )
            return false;
        else
            array_shift( $arrTag );

        // determine theme, networks and template
        $networks = array();
        $theme = self::DEFAULT_THEME;
        $template = self::DEFAULT_TEMPLATE;

        // go through each parameter
        while( count( $arrTag ) > 0 )
        {
            // get the parameter
            $strParam = array_shift( $arrTag );

            // check for theme
            if( in_array( $strParam, array_keys( $GLOBALS['sharebuttons']['themes'] ) ) )
            {
                $theme = $strParam;
                continue;
            }

            // check for template
            if( strpos( $strParam, 'sharebuttons_' ) !== false )
            {
                $template = $strParam;
                continue;
            }

            // check for networks
            if( count( $networks ) == 0 )
                $networks = array_intersect( explode( ':', $strParam ), array_keys( $GLOBALS['sharebuttons']['networks'] ) );
        }

        // create sharebuttons
        return self::createShareButtons( $networks, $theme, $template );
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
