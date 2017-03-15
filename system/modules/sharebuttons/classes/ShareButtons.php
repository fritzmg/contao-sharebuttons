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


class ShareButtons
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

        // check for empty template
        if( !$template )
            $template = self::DEFAULT_TEMPLATE;

        // create share buttons template
        $objButtonsTemplate = new \FrontendTemplate( $template );

        // assign enabled networks to template
        foreach( $networks as $network )
            $objButtonsTemplate->$network = true;

        // determine the share image (e.g. for pinterest)
        if( !$image && isset( $GLOBALS['SOCIAL_IMAGES'] ) && is_array( $GLOBALS['SOCIAL_IMAGES'] ) && count( $GLOBALS['SOCIAL_IMAGES'] ) > 0 )
            $image = \Environment::get('base') . $GLOBALS['SOCIAL_IMAGES'][0];

        // process url
        if( $url && stripos( $url, 'http' ) !== 0 )
            $url = \Environment::get('base') . $url;

        // assign url, title, theme, image, description to template
        $objButtonsTemplate->url         = rawurlencode( $url ?: \Environment::get('base') . \Environment::get('request') );
        $objButtonsTemplate->title       = rawurlencode( strip_tags( $title ?: ( $objPage->pageTitle ?: $objPage->title ) ) );
        $objButtonsTemplate->theme       = $theme;
        $objButtonsTemplate->image       = rawurlencode( $image );
        $objButtonsTemplate->description = rawurlencode( strip_tags( $description ?: $objPage->description ) );

        // add translations to template
        $translations = $GLOBALS['TL_LANG']['sharebuttons'];
        $translations['mail_subject'] = rawurlencode( $translations['mail_subject'] );
        $objButtonsTemplate->lang = $translations;

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


    /**
     * parseArticles hook for news
     *
     * @param \Template $objTemplate
     * @param array $arrData
     * @param \Module $objModule
     */
    public function parseArticles( \Template $objTemplate, $arrData, \Module $objModule )
    {
        // check for news module
        if( strpos( get_class($objModule), 'ModuleNews') === false )
            return;

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
            $url         = $objTemplate->link;
            $title       = $arrData['headline'];
            $description = $arrData['teaser'];
            $image       = ( $objTemplate->addImage && $objTemplate->singleSRC ) ? \Environment::get('base') . $objTemplate->singleSRC : null;

            // create the share buttons
            $strSharebuttons = self::createShareButtons( $networks, $theme, $template, $url, $title, $description, $image );
        }

        // set sharebuttons string
        $objTemplate->sharebuttons = $strSharebuttons;
    }


    /**
     * parseTemplate hook for articles and events
     *
     * @param \Template $objTempalte
     */
    public function parseTemplate( \Template $objTemplate )
    {
        // check for mod_article template
        if( stripos( $objTemplate->getName(), 'mod_article' ) !== false )
        {
            // prepare sharebuttons string
            $strSharebuttons = '';

            // get the networks
            $arrNetworks = deserialize( $objTemplate->sharebuttons_networks );

            // check if there are any networks
            if( $arrNetworks )
            {
                // set data
                $networks    = $arrNetworks;
                $theme       = $objTemplate->sharebuttons_theme;
                $template    = $objTemplate->sharebuttons_template;
                $url         = $objTemplate->href;
                $title       = $objTemplate->title;
                $description = $objTemplate->teaser;

                // create the share buttons
                $strSharebuttons = self::createShareButtons( $networks, $theme, $template, $url, $title, $description );                
            }

            // set sharebuttons variable
            $objTemplate->sharebuttons = $strSharebuttons;
        }
        // check for event template
        elseif( stripos( $objTemplate->getName(), 'event_' ) === 0 )
        {
            // prepare sharebuttons string
            $strSharebuttons = '';

            // get the calendar
            if( ( $objCalendar = \CalendarModel::findById( $objTemplate->pid ) ) !== null )
            {
                // get the networks
                $arrNetworks = deserialize( $objCalendar->sharebuttons_networks );

                // check if there are any networks
                if( $arrNetworks )
                {
                    // set data
                    $networks    = $arrNetworks;
                    $theme       = $objCalendar->sharebuttons_theme;
                    $template    = $objCalendar->sharebuttons_template;
                    $url         = $objTemplate->href;
                    $title       = $objTemplate->title;
                    $description = $objTemplate->teaser;
                    $image       = $objTemplate->singleSRC;

                    // create the share buttons
                    $strSharebuttons = self::createShareButtons( $networks, $theme, $template, $url, $title, $description, $image );                
                }

            }

            // set sharebuttons variable
            $objTemplate->sharebuttons = $strSharebuttons;            
        }
    }


    /**
     * replaceInsertTag hook
     *
     * @param string $strTag
     * @param bool $blnCache
     *
     * @return string
     */
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

        return \Controller::getTemplateGroup('sharebuttons_', $intPid);
    }
}
