=== WP Total Hacks ===
Contributors: miyauchi
Donate link: http://firegoby.theta.ne.jp/
Tags: head, post, page, functions.php, admin, logo, auto save, revision, meta box, dashboard
Requires at least: 3.1
Tested up to: 3.1
Stable tag: 0.1

Enhancing CSS plugin will enable to edit Stylesheet. This Stylesheet is linked as The External Stylesheet. In addition, You can add This Stylesheet to Visual Editor.

== Description ==

Enhancing CSS plugin will enable to edit Stylesheet.
This Stylesheet is linked as The External Stylesheet through WordPress rewrite api.
In addition, You can add This Stylesheet to Visual Editor.

If you will install this plugin with ['Enhancing JavaScript' plugin](http://wordpress.org/extend/plugins/enhancing-js/),
You can customize themes without PHP programming!

* [Plugin Homepage](http://firegoby.theta.ne.jp/wp/enhancingcss)
* [Support](http://wordpress.org/tags/enhancing-css)

= Some features: =

* You can edit External CSS on WordPress admin.
* You can add Stylesheet to visual editor.
* Conditional GET and ETag support.
* You can download stylesheet for the Child Theme.

= Translators: =

* Japanese(ja) - [Takayuki Miyauchi](http://firegoby.theta.ne.jp/)

You can send your own language pack to me.


== Installation ==

* A plug-in installation screen is displayed on the WordPress admin panel.
* It installs it in `wp-content/plugins`.
* The plug-in is made effective.
* Open 'Appearance' -> 'Enhancing CSS' menu.

== Frequently Asked Questions ==

= This Stylesheet is physical file ? =
No. This Stylesheet output through WordPress rewrite API.

= Where is URL for External Stylesheet ? =
Example: http://your_site_url/EnhancingCSS.css

= Can I add Stylesheet to Visual Edtor ? =
Yes. You can select that on 'Appearance' -> 'Enhancing CSS'

= What are Capabilities ? =
edit_theme_options

== Screenshots ==

1. Visual Editor for CSS.

== Changelog ==

= 1.2 =
fixed bug when used with plugin rewrite home_url.

= 1.1 =
fixed bug. chang site_url() to home_url().

= 1.0 =
fixed bug on using with multilingual plugin.

= 0.7 =
Set priority to action of wp_head hook.

= 0.6 =
fixed bug for when do not apply enhancing-css to visual editor, existing css dis appearing.

= 0.5 =
* Codemirror updated.

= 0.4 =
* Fix for bug when giving wordpress its own directory.

= 0.3 =
* Conditional GET and ETag support.
* Added a download link for the Child Theme.
* Delete carriage return.

= 0.2 =
* Add buttons to visual css editor. (Redo, Undo, and other)
* Add CodeMirror Lisence file.
* Some other little fixes.

= 0.1 =
* The first release.

== Credits ==

This plug-in is not guaranteed though the user of WordPress can freely use this plug-in free of charge regardless of the purpose.
The author must acknowledge the thing that the operation guarantee and the support in this plug-in use are not done at all beforehand.

WordPress のユーザーは目的を問わず、このプラグインを無償で自由に利用することができますがこのプラグインは無保証です。
作者はこのプラグインの利用における一切の動作保証とサポートを行わない事を予めご了承下さい。

== Contact ==

email to miya[at]theta.ne.jp
twitter @miya0001
