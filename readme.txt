=== Plugin Name ===
Contributors: kolnik
Donate link: http://zanematthew.com/donate/
Tags: widget, tip type, post, custom post type, custom taxonomies
Requires at least: 3.0
Tested up to: 3.0
Stable tag: trunk

Use this plugin to create a new post type called "Tip" with the following taxonomies: "skill", "topic"

== Description ==
This plugin was written to better organize content and leverage registered post types along with 
custom taxonomies. What this plugin will do is add a new post type called "Tip" along with a "skill" and "topic"
taxonomy whioh are registered to our "Tip" post type. 

The TipType supports the following:
- title
- comments
- editor*
- thumbanil

*IMO -- It's recommeneded that you use the editor "lightly", if you're making a really lengthy "tip", one
with several pragraphs and screenshots it probally should be an post or "article" or "tutorial".

Our taxonomies are like "tags" (not hierarchical) it's best practice to keep these short and concise.
Again, this plugin was written to better organize our "post", so good terms for the "skill" taxonomy 
would be: "easy", "medium", "hard" and NOT "guru", "super easy", "super crazy easy", but really you can
use what ever you want (just hopefully you'll find a use for it). Please respect the resevered terms:
http://codex.wordpress.org/Function_Reference/register_taxonomy#Reserved_Terms

== Installation ==
1. Upload `tiptype` into `/wp-content/plugins` directory
2. Activate the plugin through the 'Plugins" menu in WordPress

Widget (your theme must support widgets)
1. Goto 'Appearance'
2. Drag 'Most Recent Tip' into the desired widget area
3. Fill out the form
4. Click update

== Screenshots ==
1. Tip as seen from the "add new Tip"
2. Tip in the widget area
3. Tip in action

== Frequently Asked Questions ==
= Permalinks do not work for 'Tips'? =
Goto the permalinks section of your site and click 'Save Changes'

= If I disable the plugin are my old "tips" deleted from the databse? =
No, I may add a feature to remove them, but I beleive it is bad practice for a plugin to remove data from the database

== ChangeLog == 
= 1.0.6 =
* Removed base.css - file was not there resulted in 404
* Removed init to 'tip_type_theme'
* Added variable $image into the function
* Added ', ' and space for multiple skills and tips
* Updated FAQ, "enable/disabling this plugin does NOT remove any 'tips' from the databse"

