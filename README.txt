=== Plugin Name ===
Contributors: (this should be a list of wordpress.org userid's)
Donate link: https://vk.com/id554858695
Tags: comments, spam
Requires at least: 3.0.1
Tested up to: 6.0
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The plugin is designed to display a list of vacancies on the site.

== Description ==

With Company vacancies, you can get information about vacancies from the HeadHunter API, as well as use the HeadHunter functionality for your site.
The plugin allows you to display a list of vacancies from the official HeadHunter website via API.
You can fine-tune the required list of vacancies on the site through the admin panel in the plugin settings.
To customize the list of vacancies, all available filters from the official HeadHunter API documentation are used.
To display a list of vacancies on the page, you need to insert the plugin shortcode on the desired page or section.
The plugin does not make constant requests to the HeadHunter API, but makes a request caches information on the last selected filter, which allows you to load data from the cache, thereby speeding up page loading.
If the data needs to be changed regularly, you need to use WP Cron.

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload `wvcl.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `<?php do_action('[vacancy recruitment="headhunter"]'); ?>` in your templates

== Frequently Asked Questions ==

= The plugin works through the official HeadHunter API =

Yes, that's right, the plugin works through the official HeadHunter API, all requests are sent to HeadHunter and the received response is recorded in the database of your site.

== Screenshots ==

1. Admin panel, setting up a list of vacancies
2. Display a list of vacancies

== Changelog ==

== Arbitrary section ==

== A brief Markdown Example ==
