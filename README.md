Contao Share Buttons
===================

Simple extension to provide share buttons as a module, content element and for news articles in Contao. In each case you have the same set of options.

![Element settings](https://raw.githubusercontent.com/fritzmg/contao-sharebuttons/master/element.png)

## Themes

In each case you can also set an optional theme. If you select a theme, basic styling is included for the buttons, making them align horizontally and applying background images. These are the current available themes:

![Available themes](https://raw.githubusercontent.com/fritzmg/contao-sharebuttons/master/buttons.png)

From top to bottom:

- Boxxed
- Boxxed (16px)
- Contao
- Light
- Shadow
- Simple Flat
- Simple Icons Black
- Simple Icons White (grey background added for visibility)

The "Contao" theme uses Contao's own icons, however only Facebook, Twitter and Google+ is available there.  There is also a theme called "Text", which simply aligns the elements horizontally, but leaves the textual content of each button visible.

The following themes offer higher resolution images for devices with high DPI:

- Boxxed (16px)
- Light
- Shadow
- Simple Icons Black 
- Simple Icons White

## Template

You can also set the template in each element, if you happen to need a different structure in some cases. If you want to use your own template, create one with a name that starts with `sharebuttons_` in your templates folder.

## News

In order to use the share buttons in your news articles, you need to add the following to your news template:

```php
<?php echo $this->sharebuttons; ?>
```

And you need to enable the share buttons and set the optional theme _for each news entry_. If you use the share buttons in news this way, it may be useful to define a default value for the selected search buttons (and may be theme). You can do this via the `dcaconfig.php` like so:

```php
// this pre-selects the Facebook, Twitter and Google+ share button
$GLOBALS['TL_DCA']['tl_news']['fields']['sharebuttons_networks']['default'] = array('facebook','twitter','gplus');

// this pre-selects the "Boxxed" theme
$GLOBALS['TL_DCA']['tl_news']['fields']['sharebuttons_theme']['default'] = 'boxxed';
```

Have a look at the `$GLOBALS['sharebuttons']['themes']` and `$GLOBALS['sharebuttons']['networks']` array in [`config/config.php`](https://github.com/fritzmg/contao-sharebuttons/blob/master/system/modules/sharebuttons/config/config.php) in order to find the key-string for your desired networks and theme.

Using the share buttons in news articles this way is especially important, if you want to show share buttons in a news list — otherwise the url and title will not be correct (since the share buttons just use the url and title of the current page otherwise). 

## Insert Tag

Since version 1.1.0 there is also an insert tag available. The name of the insert tag is `sharebuttons`, the first parameter is the theme and the following parameter are the networks separated by a single colon:

```
{{sharebuttons::THEME::NETWORK:NETWORK:...}}
```

The following insert tag would create share buttons with the `boxxed` theme with all currently available social networks:

```
{{sharebuttons::boxxed::facebook:twitter:gplus:linkedin:xing:mail:tumblr:pinterest:reddit}}
```

The theme parameter is optional. The following insert tag would simply generate the HTML source for a Facebook, Twitter and Google+ share button, without including a stylesheet for a theme:

```
{{sharebuttons::facebook:twitter:gplus}}
```

## Attributions

### Icon sources

- Boxxed: http://www.twelveskip.com/resources/icons/1091/boxxed-flat-social-media-icons
- Light: http://www.kplitsolutions.com/freebies.html
- Shadow: http://wegraphics.net/downloads/free-long-shadow-social-media-icons/
- Simple Flat: http://iconsandcoffee.com/freebie-flat-web-icon-set/
- Simple Icons: http://simpleicons.org/