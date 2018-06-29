=== Plugin Name ===
Contributors: fissiomedia,kantti
Donate link: https://www.fissiomedia.fi/
Tags: woocommerce, woocommerce bookings, coupon, expiration,
Requires at least: 4.4
Tested up to: 4.9.6
Stable tag: 1.0.0
Requires PHP: 5.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Add-on for WooCommerce and WooCommerce Bookings that forces booked date to be before the expiration date of a coupon used while making the booking.

== Description ==

By default you can set an expiration date for a WooCommerce coupon. If expiry is set, the customer must use the coupon before that date to benefit from the discount. This works fine for regular physical and virtual products.

But what do you do, if you are selling bookings, a special season is coming up, and you don't want to let customers make discounted bookings outside the season? You use this plugin.

WooCommerce Force Booking Before Coupon Expiration plugin does exaclty what the name says. When this plugin is used coupons can't be used on bookings which dates are past the coupon expiration date. This restriction is optional and be controlled on per coupon basis.

For this plugin to work the following plugins are required:
* [WooCommerce](https://wordpress.org/plugins/woocommerce/)
* [WooCommerce Bookings](https://woocommerce.com/products/woocommerce-bookings/) (premium plugin sold separately)

== Installation ==

= Requirements =

You need to install and activate WooCommerce and WooCommerce Bookings to use this plugin. WooCommerce Bookings is a premium plugin that is sold separately.

= Automatic installation =

To add this plugin to your WordPress site using the built-in plugin installer, please consult the [automatic plugin installation guide](https://codex.wordpress.org/Managing_Plugins#Automatic_Plugin_Installation)

= Manual installation =

If you wish to install the plugin manually, please consult the [manual plugin installation guide](https://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation)

== Frequently Asked Questions ==

= Why was this plugin developed and published? =

We needed this feature myself in a project and we thought that perhaps someone else would also need this.

= Are you affiliated with WooCommerce or WooCommerce Bookings? =

Not in any way, and we don't get any compensation for mentioning or linking to WooCommerce or WooCommerce Bookings.

= WooCommerce is not working! =

Please use the [WooCommerce Plugin Forum](https://wordpress.org/support/plugin/woocommerce).

= WooCommerce Bookings is not working! =

For help with premium extensions from WooCommerce.com, use [their helpdesk](https://woocommerce.com/my-account/tickets/).

= This plugin is not working! =

Please use the [plugin support forum](https://wordpress.org/support/), but please don't hold your breath while waiting for a reply. We're working on this plugin after hours.

== Screenshots ==

1. Custom checkbox on the coupon general options tab.
2. Error message when one booked date is past the coupon expiry.
3. Error message when multiple booked dates are past the coupon expiry.

== Changelog ==

= 1.0.0 =
* Initial launch
