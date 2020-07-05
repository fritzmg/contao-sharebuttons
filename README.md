[![](https://img.shields.io/packagist/v/fritzmg/contao-sharebuttons.svg)](https://packagist.org/packages/fritzmg/contao-sharebuttons)
[![](https://img.shields.io/packagist/dt/fritzmg/contao-sharebuttons.svg)](https://packagist.org/packages/fritzmg/contao-sharebuttons)

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
- Font Awesome

The "Contao" theme uses Contao's own icons, however only Facebook, and Twitter is available there. There is also a theme called "Text", which simply aligns the elements horizontally, but leaves the textual content of each button visible.

The following themes offer higher resolution images for devices with high DPI:

- Boxxed (16px)
- Light
- Shadow
- Simple Flat
- Simple Icons Black 
- Simple Icons White

## Template

You can also set the template in each element, if you happen to need a different structure in some cases. If you want to use your own template, create one with a name that starts with `sharebuttons_` in your templates folder.

## Font Awesome

Since version 1.1.0 there is also a theme and template for Font Awesome icons. If you have the Font Awesome icon font integrated on your page and want to use it for your share buttons, simply select the `sharebuttons_fontawesome` template. Theme wise you can choose between _None_, _Text_ and _Font Awesome_. The latter one comes with some styles that will make the icons about as big as the other themes. If you select any theme other than those three and you have the template selected, it will default to the _Font Awesome_ theme currently.

If you want to exchange the icons for one of the buttons simply create your own `sharebuttons_fontawesome` template (or rename it to something else) and replace the `fa-` class. For example, if you want the square version of the facebook icon, simply replace `fa-facebook` with `fa-facebook-square`.

## News, Events, Articles

You can output share buttons directly in your `news_*`, `event_*` and `mod_article*` templates:

```php
<?= $this->sharebuttons ?>
```

You can set the options for the news sharebuttons in the news archive, calendar or article settings.

Using the share buttons this way is especially important if you want to show share buttons in a news or event list or when you show article teasers — otherwise the url and title will not be correct (since the share buttons just use the url and title of the current page then).

## Insert Tag

Since version 1.1.0 there is also an insert tag available. The name of the insert tag is `sharebuttons`, parameters like theme, template and networks can be passed as following:

```
{{sharebuttons::THEME::TEMPLATE::NETWORK:NETWORK:...}}
```

All parameters are optional (however, without any networks, nothing will be displayed). The following insert tag would create share buttons with the `boxxed` theme with all currently available social networks:

```
{{sharebuttons::boxxed::facebook:twitter:linkedin:xing:mail:tumblr:pinterest:reddit:whatsapp:print:pdf}}
```

The following insert tag would simply generate the HTML source for a Facebook and Twitter share button, without including a stylesheet for a theme:

```
{{sharebuttons::facebook:twitter}}
```

Have a look at the `$GLOBALS['sharebuttons']['themes']` and `$GLOBALS['sharebuttons']['networks']` array in [`config/config.php`](https://github.com/fritzmg/contao-sharebuttons/blob/master/system/modules/sharebuttons/config/config.php) in order to find the key-string for your desired networks and theme.

Since version `2.1.0` you can also define an article ID, if you want to provide a PDF link for a specific article:

```
{{sharebuttons::pdf::6}}
```

## Pinterest button

The Pinterest share button will only be displayed, if an image is available. There are 3 ways an image can be present:

* If you use the sharebuttons in your news or event template via `<?= $this->sharebuttons ?>`, the Pinterest button will automatically use the teaser image.
* Simply install the [social_images](https://github.com/codefog/contao-social_images) extension (also available in the [ER2](https://contao.org/de/extension-list/view/social_images.en.html)) and enable it in your layout. The Pinterest share button will automatically take the first social image available.
* You can also manually set a social image by providing an absolute URL to the image in `$GLOBALS['SOCIAL_IMAGES'][0]` in any template or PHP script _before_ the sharebuttons are generated.

## Attributions

### Icon sources

- Boxxed: http://www.twelveskip.com/resources/icons/1091/boxxed-flat-social-media-icons
- Light: http://www.kplitsolutions.com/freebies.html
- Shadow: http://wegraphics.net/downloads/free-long-shadow-social-media-icons/
- Simple Flat: http://iconsandcoffee.com/freebie-flat-web-icon-set/
- Simple Icons: http://simpleicons.org/
