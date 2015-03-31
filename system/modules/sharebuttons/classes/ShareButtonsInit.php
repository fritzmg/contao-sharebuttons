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


class ShareButtonsInit
{
    // dirty hack, so that ShareButtons::parseArticles is more likely the last parseArticles hook
    // so that the news image is available from the social_images extension instead of loading it ourselves
    // (saves one db query)
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
}
