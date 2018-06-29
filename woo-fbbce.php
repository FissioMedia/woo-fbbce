<?php
/*
 * Plugin Name:   WooCommerce Force Booking Before Coupon Expiration
 * Version:       1.0.0
 * Plugin URI:    https://www.github.com/fissiomedia
 * Description:   Add-on for WooCommerce and WooCommerce Bookings that forces booked date to be before the expiration date of a coupon used while making the booking.
 * Author:        FissioMedia
 * Author URI:    https://www.fissiomedia.fi
 * Text Domain:   woo-fbbce
 * Domain Path:   /languages
 * License:       GPL-2.0+
 * License URI:   http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * WC requires at least: 3.2.0
 * WC tested up to: 3.4.3
 *
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

// Define WC_PLUGIN_FILE.
if ( ! defined( 'WOO_FBBCE_PLUGIN_PATH' ) ) {
	define( 'WOO_FBBCE_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
}

// Load localization
if ( ! function_exists( 'woo_fbcce_load_text_domain' ) ) {

  function woo_fbcce_load_text_domain() {
    load_plugin_textdomain( 'woo-fbbce', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
  }

}
add_action( 'init', 'woo_fbcce_load_text_domain' );

// Include the main plugin class.
if ( ! class_exists( 'Woo_Fbbce' ) ) {
	include_once WOO_FBBCE_PLUGIN_PATH . 'includes/class-woo-fbbce.php';
}

// Check dependencies
if ( ! function_exists( 'check_woo_fbcce_plugin_dependencies' ) ) {

  function check_woo_fbcce_plugin_dependencies() {

    $dependencies_installed = true;

    $active_plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );

    // Is WooCommerce active
    if ( !in_array( 'woocommerce/woocommerce.php', $active_plugins ) ) {
      $dependencies_installed = false;
    }

    // Is WooCommerce Bookings active
    if ( !in_array( 'woocommerce-bookings/woocommerce-bookings.php', $active_plugins ) ) {
      $dependencies_installed = false;
    }

    return $dependencies_installed;

  }

}

// Admin error message
if ( ! function_exists( 'woo_fbcce_dependencies_missing_admin_notice' ) ) {

  function woo_fbcce_dependencies_missing_admin_notice() {

    $class = 'notice notice-error is-dismissible';
    $message = _x( 'Please install and activate both WooCommerce and WooCommerce Bookings to use the WooCommerce Force Booking Before Coupon Expiration plugin.', 'Dependencies missing admin notice', 'woo-fbbce' );

    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );

  }

}

/**
  * Main plugin instance
  *
  * @since 0.0.1
  * @return Woo_Fbbce
  *
  */
if ( ! function_exists( 'run_woo_fbcce_plugin' ) ) {

  function run_woo_fbcce_plugin() {

    if ( true == check_woo_fbcce_plugin_dependencies() ) {

      return Woo_Fbbce::instance();

    } else {

      add_action( 'admin_notices', 'woo_fbcce_dependencies_missing_admin_notice' );

    }

  }

}

// Kickstart the plugin
run_woo_fbcce_plugin();

?>
