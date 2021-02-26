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


$GLOBALS['TL_LANG']['sharebuttons']['no_theme'] = "Kein Theme (es wird kein Style angewandt)";
$GLOBALS['TL_LANG']['sharebuttons']['share_title'] = "Teilen:";
$GLOBALS['TL_LANG']['sharebuttons']['share_on_facebook'] = "auf Facebook teilen";
$GLOBALS['TL_LANG']['sharebuttons']['share_on_twitter'] = "auf Twitter teilen";
$GLOBALS['TL_LANG']['sharebuttons']['share_on_gplus'] = "auf Google+ teilen";
$GLOBALS['TL_LANG']['sharebuttons']['share_on_linkedin'] = "auf LinkedIn teilen";
$GLOBALS['TL_LANG']['sharebuttons']['share_on_xing'] = "auf Xing teilen";
$GLOBALS['TL_LANG']['sharebuttons']['share_on_tumblr'] = "auf tumblr teilen";
$GLOBALS['TL_LANG']['sharebuttons']['share_on_pinterest'] = "auf Pinterest teilen";
$GLOBALS['TL_LANG']['sharebuttons']['share_on_reddit'] = "auf Reddit teilen";
$GLOBALS['TL_LANG']['sharebuttons']['share_on_whatsapp'] = "über WhatsApp teilen";
$GLOBALS['TL_LANG']['sharebuttons']['print_page'] = "Seite drucken";
$GLOBALS['TL_LANG']['sharebuttons']['create_pdf'] = "Seite als PDF downloaden";
$GLOBALS['TL_LANG']['sharebuttons']['mail_subject'] = "Website Empfehlung";

$GLOBALS['TL_LANG']['sharebuttons']['sharebuttons_legend'] = "Share buttons";
$GLOBALS['TL_LANG']['sharebuttons']['sharebuttons_networks'] = array('Share buttons','Wähle die share buttons aus, die sichtbar sein sollen');
$GLOBALS['TL_LANG']['sharebuttons']['sharebuttons_template'] = array('Template','Template für die Share buttons. Dateiname beginnt mit sharebuttons_');
$GLOBALS['TL_LANG']['sharebuttons']['sharebuttons_theme'] = array('Theme','Wähle ein Theme aus, das für die buttons verwendet wird');

$GLOBALS['TL_LANG']['tl_content']['sharebuttons_legend'] = $GLOBALS['TL_LANG']['sharebuttons']['sharebuttons_legend'];
$GLOBALS['TL_LANG']['tl_module']['sharebuttons_legend'] = $GLOBALS['TL_LANG']['sharebuttons']['sharebuttons_legend'];
$GLOBALS['TL_LANG']['tl_news_archive']['sharebuttons_legend'] = $GLOBALS['TL_LANG']['sharebuttons']['sharebuttons_legend'];
$GLOBALS['TL_LANG']['tl_article']['sharebuttons_legend'] = $GLOBALS['TL_LANG']['sharebuttons']['sharebuttons_legend'];
$GLOBALS['TL_LANG']['tl_calendar']['sharebuttons_legend'] = $GLOBALS['TL_LANG']['sharebuttons']['sharebuttons_legend'];

$GLOBALS['TL_LANG']['CTE']['sharebuttons'] = array('Share buttons', 'Buttons zum teilen von Seitenlinks auf sozialen Netzwerken.');
$GLOBALS['TL_LANG']['FMD']['sharebuttons'] = $GLOBALS['TL_LANG']['CTE']['sharebuttons'];

$GLOBALS['TL_LANG']['sharebuttons']['networks']['print'] =  'Drucken';
$GLOBALS['TL_LANG']['sharebuttons']['networks']['pdf'] = 'PDF erzeugen';
