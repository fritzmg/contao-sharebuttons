Contao Share Buttons
===================

Simple extension to provide share buttons as a module, content element and for news articles in Contao.

In each case you can define which share buttons should be included:

- Facebook
- Twitter
- Google+
- LinkedIn
- Xing (not working at the moment)
- E-Mail

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
- Simple Icons White

Be aware that not all themes support all buttons. 

There is also a theme called "Text", which simply aligns the elements horizontally, but leaves the textual content of each button visible.

You can also set the template in each element, if you happen to need a different structure in some cases.

If you use the share buttons in news, it may be useful to define a default value for the selected search buttons (and may be theme). You can do this via the `dcaconfig.php` like so:

```php
// this pre-selects the Facebook, Twitter and Google+ share button
$GLOBALS['TL_DCA']['tl_news']['fields']['sharebuttons_networks']['default'] = array('facebook','twitter','gplus');

// this pre-selects the "Boxxed" theme
$GLOBALS['TL_DCA']['tl_news']['fields']['sharebuttons_theme']['default'] = 'boxxed';
```

Have a look at the `$GLOBALS['sharebuttons']['themes']` array in `config/config.php` in order to find the key-string for your desired theme.