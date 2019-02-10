<?php

/**
 * Contao Open Source CMS
 *
 * simple extension to provide a share buttons module
 * 
 * @copyright inspiredminds 2015-2019
 * @package   sharebuttons
 * @link      http://www.inspiredminds.at
 * @author    Fritz Michael Gschwantner <fmg@inspiredminds.at>
 * @license   LGPL-3.0-or-later
 */


class ShareButtons
{
    const DEFAULT_THEME = '';
    const DEFAULT_TEMPLATE = 'sharebuttons_default';

    public static function createShareButtons($networks, $theme = self::DEFAULT_THEME, $template = self::DEFAULT_TEMPLATE, $url = null, $title = null, $description = null, $image = null, $articleId = null)
    {
        // access to page
        global $objPage;

        // try to deserialize
        if( is_string( $networks ) )
            $networks = deserialize( $networks );

        $networks = array_intersect(array_keys($GLOBALS['sharebuttons']['networks']), $networks);

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
        $objButtonsTemplate->networks = $networks;

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

        // add PDF link
        if (\in_array('pdf', $networks)) {
            $objArticle = $articleId ? \ArticleModel::findById($articleId) : \ArticleModel::findPublishedByPidAndColumn($objPage->id, 'main');

            if (null !== $objArticle) {
                $articleAlias = $objArticle->alias ?: $objArticle->id;
                $articleHref = '/articles/' . (($objArticle->inColumn != 'main') ? $objArticle->inColumn . ':' : '') . $articleAlias;
                $objButtonsTemplate->pdfLink = $objArticle->getRelated('pid')->getFrontendUrl($articleHref) . '?getpdf=' . $objArticle->id;
            }
        }

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

    public static function createInsertTag($networks, $theme = '', $template = '', $articleId = null)
    {
        // try to deserialize
        if (is_string($networks)) {
            $networks = deserialize($networks, true);
        }

        $networks = array_intersect(array_keys($GLOBALS['sharebuttons']['networks']), $networks);

        // check for networks
        if (!\is_array($networks) || count($networks) === 0) {
            return '';
        }

        $elements = [];

        if ($theme) {
            $elements[] = $theme;
        }

        if ($template) {
            $elements[] = $template;
        }

        $elements[] = implode(':', $networks);

        if ($articleId) {
            $elements[] = $articleId;
        }

        // build insert tag
        $strInsertTag = '{{sharebuttons::' . implode('::', $elements) . '}}';

        // return insert tag
        return $strInsertTag;
    }


    /**
     * parseArticles hook for news
     *
     * @param \Template $objTemplate
     * @param array $arrData
     * @param \Module $objModule
     * 
     * @return void
     */
    public function parseArticles(\Template $objTemplate, $arrData, \Module $objModule)
    {
        // check for news module
        if(!$objModule instanceof \ModuleNews)
        {
            return;
        }

        // get the news archive
        $objArchive = \NewsArchiveModel::findById($arrData['pid']);

        // get the networks for the archive
        $arrNetworks = deserialize($objArchive->sharebuttons_networks, true); 

        // prepare sharebuttons string
        $strSharebuttons = '';

        // check if there are any networks
        if (count($arrNetworks) > 0)
        {
            // set data
            $theme       = $objArchive->sharebuttons_theme;
            $template    = $objArchive->sharebuttons_template;
            $url         = $objTemplate->link;
            $title       = $arrData['headline'];
            $description = $arrData['teaser'];
            $image       = ($objTemplate->addImage && $objTemplate->singleSRC) ? \Environment::get('base') . $objTemplate->singleSRC : null;

            // create the share buttons
            $strSharebuttons = self::createShareButtons($arrNetworks, $theme, $template, $url, $title, $description, $image);
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
                $strSharebuttons = self::createShareButtons($networks, $theme, $template, $url, $title, $description, null, $objTemplate->id);                
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
        $articleId = null;

        // go through each parameter
        while (count($arrTag) > 0) {
            // get the parameter
            $strParam = array_shift($arrTag);

            // check for theme
            if (in_array($strParam, array_keys($GLOBALS['sharebuttons']['themes']))) {
                $theme = $strParam;
                continue;
            }

            // check for template
            if (strpos($strParam, 'sharebuttons_') !== false) {
                $template = $strParam;
                continue;
            }

            // check for article id
            if (is_numeric($strParam)) {
                $articleId = (int) $strParam;
            }

            // check for networks
            if (count($networks) == 0) {
                $networks = array_intersect(explode(':', $strParam ), array_keys($GLOBALS['sharebuttons']['networks']));
            }
        }

        // create sharebuttons
        return self::createShareButtons($networks, $theme, $template, null, null, null, null, $articleId);
    }


    /**
     * isVisibleElement hook
     * 
     * @param Model $objElement
     * @param bool $blnReturn
     *
     * @return bool
     */
    public function isVisibleElement(\Model $objElement, bool $blnReturn): bool
    {
        if ($objElement instanceof \ArticleModel && null !== ($articleId = \Input::get('getpdf')) && (int) $objElement->id === (int) $articleId) {
            \Input::setGet('pdf', $articleId);
            $printable = $objElement->printable;

            if ((int) $printable !== 1) {
                $options = $printable ? \StringUtil::deserialize($printable) : [];

                if (!\in_array('pdf', $options)) {
                    $options[] = 'pdf';
                    $objElement->printable = serialize($options);
                }
            }
        }

        return $blnReturn;
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
