# Thamm IT WordPress Shortcodes

Assorted Shortcodes for WordPress

Implements a number of assorted shortcodes to your WordPress Website.

## Shortcodes
### ti_button
![ti_button shortcode examples](Assets/Img/ti_button.jpg)

The ``ti_button`` shortcode creates a beatufil button in your content area. This button is meant to be used to highlight links.

#### Syntax
``[ti_button align="" type="" link="" target=""]Buttontext[/ti_button]``

The options are as following:
- ``align`` defines the button alignment. Valid choices are: left, center and right. (Default: center)
- ``type`` defines the button type/style. Valid choiced are: primary, secondary and link. (Default: primary)
- ``link`` defines the actual link of the button. Every valid link can be used here.
- ``target`` defines the link target/where the link is opened. This option is actually the [HTML a-Tags target attribute](https://www.w3schools.com/tags/att_a_target.asp)

### ti_download
![ti_download shortcode examples](Assets/Img/ti_download.jpg)

The ``ti_download`` shortcode creates a download button. It is similar to the ``ti_button`` shortcode but with its focus on being an actual download button rather than just a link button. Depending on the download filetype it also has a nice little icon in it.

#### Syntax
``[ti_download link="" type="" title="" target="" align=""]``
(This shortcode does not need a closing tag)

The options are as following:
- ``align`` defines the button alignment. Valid choices are: left, center and right. (Default: center)
- ``type`` defines the button type/style. Valid choiced are: primary, secondary and link. (Default: primary)
- ``link`` defines the actual link of the download. Every valid link can be used here.
- ``target`` defines the link target/where the link is opened. This option is actually the [HTML a-Tags target attribute](https://www.w3schools.com/tags/att_a_target.asp)
- ``title`` the download title/name that is written on the button. (Default: Download)
