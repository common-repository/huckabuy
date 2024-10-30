=== Huckabuy ===
Contributors: huckabuy
Author: Huckabuy.com
Author URI: https://huckabuy.com/
Tags: seo, structured data, rich result, google, markup, marketing
Requires at least: 1.0.0
Tested up to: 6.1.1
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


Automated Structured Data plugin for Wordpress

== Description ==

Our automated structured data markup qualifies your content for enhanced search result features that capture attention and drive more qualified organic traffic to your site. As the internet has become more complex, Google has signaled its preference for website content to be marked up in a language called structured data.
Most plugins give you tools to build your own markup, which takes time and effort. Huckabuy's solution is fully automated which means you get world-class, rich result eligible markup across your entire site without the need to do any configuring.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/huckabuy` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Settings->Huckabuy screen to configure the plugin

== Frequently Asked Questions ==

= What is structured data? =

Structured data is a standardized format for providing information about a page and classifying the page content. It makes your content more visible and understandable to search engines. Structured data markup is a way to add machine-readable information to your web pages. This information can then be used by search engines to better understand your content.

= How does the plugin work? =

The plugin automatically adds structured data markup to your site. It works by analyzing your content and adding the appropriate markup to your pages. The plugin is fully automated and requires no configuration. There is a settings page where you can add social media links and search paths.  Adding these links will help the plugin to add markup to your pages, but it is not required.

= What is the difference between the free and paid versions? =

The free version of the plugin adds the following objects to your site: Organization, Website, WebPage. The paid version includes all of the objects listed above but also adds the following objects: Article, Book, BreadcrumbList, ClaimReview, Course, Dataset, Event, FAQPage, HowTo, JobPosting, LocalBusiness, Movie, NewsArticle, Occupation, Offer, Product, QAPage, Recipe, Review, SoftwareApplication, VideoObject (and more to come!)

= Does the plugin make requests to any external services? =

The Huckabuy Structured Data Wordpress plugin accesses a third-party service that is built and maintained by Huckabuy.

On initial activation of the plugin, a request is made to the third-party service to initialize your settings. This request includes your site URL and the email address you used to register for your account.  This information is used to uniquely identify your account and to provide you with support. 

When you make any updates in the plugin settings, a request is made to the same third-party service to update your settings.  Additionally, if you subscribe to the premium version of the plugin, a request is made to the third-party service to update your subscription status.  Besides these settings, no other information is sent to the third-party service from your plugin.

Once the plugin is activated and configured, our structured data script is added to your site. This script is responsible for injecting structured data to your website. This script does not make any external requests and does not collect any data from your website or visitors. The script is loaded asynchronously and does not affect the loading time of your website. It is generated dynamically (https://api.huckabuy.com/s/{$hash_hostname}/install.js) based on your hostname and the settings you have configured in the plugin.

For more information, please see our privacy policy: https://huckabuy.com/huckabuy-privacy-policy/ and our terms of service: https://huckabuy.com/legal/terms-of-service-agreement/

= Is the plugin compatible with my theme? =

The plugin is compatible with all themes. It does not require any configuration and works out of the box. The plugin is fully automated and does not require any configuration.

== Changelog ==

= 1.0 =
* Initial version.

= 1.0.1 -
* Adds assets.