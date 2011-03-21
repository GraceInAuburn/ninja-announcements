=== Ninja Announcements ===
Contributors: Kevin Stover, James Laws
Donate link: http://wpninjas.net
Tags: announcement, alert, notice
Requires at least: 3.0
Tested up to: 3.0
Stable tag: 1.2

This plugin lets you create announcements (text and/or media) that are displayed in various places of your WordPress installation.

== Description ==

The Ninja Announcements plugin displays small portions of text and/or images/video on pages and posts. Generally, these
are used to let your visitors know about something special. They can be scheduled so that they are only displayed 
between specified dates/times.  For Example, if you wanted to wish everyone a Merry Christmas, but you didn't want
to display the message until the 20th of December, you could schedule an announcement to begin on December 20 and
end on December 26. A visitor coming to your site would see the announcement between those dates, but otherwise your 
site would look just the same.

As with all WP Ninjas plugins, we have tried to keep our code as simple and unobtrusive as possible. To this end, all 
annoucements are edited via the built-in WordPress Rich Text Editor. This means that Ninja Announcements doesn't have
to include its own version of TinyMCE. Moreover, you can also include images and videos from your WordPress media 
library or YouTube, so you don't have to create or maintain a separate media library for your announcements.

Each of your announcements has its own location and scheduling settings, allowing you to place the announcement 
exactly when and where you want it, even display it as a widget.

The administration section of Ninja Announcements makes it very easy to add and edit announcements. Older announcements
are not automatically deleted, but simply deactivated so that they can be edited later. Of course, these can just be deleted if you want.

Features:

	* Use multiple announcements, each with its own settings.
	* Choose from three different announcement placements: Header, Widget or Manual.
	* Schedule announcements by date and/or hour so that they only show for a certain time period.
	* Edit announcements using the same rich text editor as a WordPress post.
	* Insert images or videos into announcements from your WordPress Media Library, just like you would a post.
	* Since it uses the built-in WordPress rich text editor and media gallery, it has a small footprint.
	* NEW for 1.1 - Users are able to close the announcement for the rest of their browsing session
	* NEW for 1.1 - Inclusion of a shortcode allows you to easily place an announcement on a page or post.
	* NEW for 1.1 - A new function for template designers that allows you to show all active announcements.

	
== Screenshots ==

1. Ninja Announcements - Main Administration Panel
2. Ninja Announcements - New Announcement
3. Ninja Announcements - Editing An Announcement
4. Ninja Announcements - Default Display Position
5. Ninja Announcements - Custom Display Position
6. Ninja Announcements - Sidebar/Widget Display Position
	
== Installation ==

Installing Ninja Announcements is really simple. 
*Notice* - If you're installing Ninja Announcements on an 3.0 Multi-Site, you'll have to activate it on each blog you want to use
it on. Ninja Announcements does not currently support Network Activation.

1. Upload the plugin folder (i.e. ninja_annc) to the /wp-content/plugins/ directory of your WordPress installation.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Add or edit announcements by clicking on the "Ninja Announcements" link underneath "Settings" in the admin panel.
4. Have a snack. You're done.

== Use ==

The default position for all announcements is at the top of your blog, before any of your images or text. If you don't assign a location to
an announcement, this is where it will show up. If you don't want to put the announcement there, you have two other options: sidebar or manual.

If you select "Sidebar (Widget)" from the location list, the announcement will appear as a widget underneath your "Appearance->Widgets" 
admin section. You can then place the widget anywhere in your sidebar that you would like.

The third location option, "Manual (Function)", is for more advanced WordPress users. This option gives you a php function
to call within your template file. The function will show the desired announcement wherever you place the code within your template.
As each announcement has its own, slightly different, function, you'll have to set the location to "Manual (Function)" and
save your changes before you are given the php code.

NEW for 1.1:
* You can add any announcement to your posts or pages by using the shortcode [ninja_annc id=2] (where 2 is the id of the announcement you want to display).
* Template designers can now call the function: ninja_annc_display_all(); This will display all active announcements in one location.

(To see examples and screenshots of each of these uses, please visit http://plugins.wpninjas.net)


== Advanced Styling ==

As you can see from the screenshots in the section above, the default and manual locations come with a default style applied to them. 
These styles are located in the ninja_annc/css/ninja_annc_display.css file. If you would like to overwrite these default styles, you can do 
so by styling the id of the container div. This div will always have an id of: ninja_annc_3 where 3 is the id of the announcement you want to style. 
This id number can be found at the top of each announcement's edit page. We highly recommend that you change this in your own stylesheet, 
as future versions of this plugin will likely overwrite the display css file. 

For a more detailed explaination of styling your announcements and the close button, please visit: http://plugins.wpninjas.net

== Help / Bugs ==

*Notice* - This plugin has not been tested with any version of WordPress prior to 3.0. If you have trouble installing it on a
previous version, please keep this in mind. If you do have a working install of Ninja Announcements on an older version
of WordPress, we'd love to hear about it. Drop by the forums at http://plugins.wpninjas.net and let us know.

If you need help installing or getting things working with Ninja Announcements, visit our forums at http://plugins.wpninjas.net. The
forums are also where we take bug reports and feature requests.

== Requested Features ==

We are contemplating adding many features to future versions of the Ninja Announcements plugin. This is a non-exhaustive list:

	* Currently, the widget location is not as robust as we would like it to be. Future versions will improve upon the widget display location.
	* Announcement previews
	* Multiple widget announcements
	* Multi-site network activation


If you have any requests, please drop by the forums at http://wpninjas.net and tell us about them.

== Changelog ==

= 1.0 =
* First version of Ninja Announcements released.

= 1.1 =
* Added a "close" button to each announcement. This allows the user to close each for the rest of their browsing session
* Inclusion of a shortcode allows you to easily place an announcement on a page or post. [ninja_annc id=3]
* Added a new function for template designers that allows you to show all active announcements.

= 1.2 =
* Fixed some minor bugs. One dealing with HTML validation and another with security issues.