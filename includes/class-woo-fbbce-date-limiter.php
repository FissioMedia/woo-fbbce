<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

/**
  * Control coupon usage on bookings
  */
class Woo_Fbbce_Date_Limiter {

  public function __construct() {
    add_filter( 'woocommerce_coupon_is_valid', array( $this, 'limit_coupon_validity' ), 10, 2);
    add_filter( 'woocommerce_coupon_error', array( $this, 'validity_error_message' ), 10, 3);
  }

  /**
    * Check if coupon is valid
    *
    * @param bool $valid is coupon valid
    * @param object WC_Coupon
    *
    * @return bool is coupon valid
    */
  function limit_coupon_validity( $valid, $coupon ) {

    $limit_booking = $this->book_before_expiration( $coupon );

    if ( $limit_booking ) {

      $expiry_exceeding_products = $this->get_coupon_expiry_exceeding_products( $coupon );

      if ( $expiry_exceeding_products ) {
        $valid = false;
      }

    }

    return $valid;
  }

  /**
    * Custom coupon validity error message
    *
    * @param string $err error string
    * @param bool $err_code
    * @param object WC_Coupon
    *
    * @return string custom i18n error string
    */
  function validity_error_message( $err, $err_code, $coupon ) {

    $limit_booking = $this->book_before_expiration( $coupon );

    if ( $limit_booking && intval( $err_code ) === WC_COUPON::E_WC_COUPON_INVALID_FILTERED ) {

      $expiry_exceeding_products = $this->get_coupon_expiry_exceeding_products( $coupon );

      if ( $expiry_exceeding_products ) {

        $product_count = count( $expiry_exceeding_products );
        $coupon_name   = $coupon->get_code();
        $coupon_expiry = $coupon->get_date_expires()->date('j.n.Y');

        if ( $product_count == 1 ) {

          $product_name = '<strong>' . $expiry_exceeding_products[0]['data']->get_name() . ' (' . $expiry_exceeding_products[0]['booking']['date'] . ')' . '</strong>';

          $err = sprintf( _x( 'The coupon "%1$s" can only be used on a booking with date prior to %2$s. Please book an earlier date for %3$s to benefit from "%1$s".', 'coupon name, coupon expiry, product name', 'woo-fbbce' ), $coupon_name, $coupon_expiry, $product_name );

        } elseif ( $product_count > 1 ) {

          $product_names = '';

          foreach ( $expiry_exceeding_products as $index => $product ) {

            $product_name = '<strong>' . $product['data']->get_name() . ' (' . $product['booking']['date'] . ')' . '</strong>';

            $product_names .= ( $index == $product_count - 1 ) ? __( 'and', 'woo-fbbce' ) . ' ' . $product_name : $product_name . ', ';

          }

          $err = sprintf( _x( 'The coupon "%1$s" can only be used on bookings with dates prior to %2$s. Please book earlier dates for %3$s to benefit from "%1$s".', 'coupon name, coupon expiry, product names', 'woo-fbbce' ), $coupon_name, $coupon_expiry, $product_names );

        }

      }

    }

    return $err;
  }

  /**
    * Separates bookable products from cart items
    *
    * @param array $cart_items items currently in cart
    * @return array bookable products
    *
    * @uses WooCommerce Bookings is_wc_booking_product()
    */
  private function get_bookable_products( $cart_items ) {

    if ( !$cart_items || !is_array( $cart_items ) ) {
      return;
    }

    $bookables = array();

    foreach ( $cart_items as $item ) {

      if ( isset( $item['booking'] ) ) {
        $bookables[] = $item;
      }

    }

    return $bookables;
  }

  /**
    * Get bookable products end dates
    *
    * @param array bookable products
    * @return array end date as key and product as value
    */
  private function get_end_dates_with_products( $bookable_products ) {

    if ( !$bookable_products || !is_array( $bookable_products ) ) {
      return;
    }

    $end_dates = array();

    foreach ( $bookable_products as $product ) {

      if ( !empty( $product['booking']['_end_date'] ) && !isset( $end_dates['booking']['_end_date'] ) ) {
        $date = $product['booking']['_end_date'];
        $end_dates[$date] = $product;
      }

    }

    return $end_dates;

  }

  /**
    * Compare bookable products end dates to coupon expiration
    *
    * @param object WC_Coupon
    * @return array bookable products which end dates exceed coupon expiration
    */
  private function get_coupon_expiry_exceeding_products( $coupon ) {

    global $woocommerce;
    $cart_items        = $woocommerce->cart->get_cart();
    $bookable_products = $this->get_bookable_products( $cart_items );

    if ( !$bookable_products || !$coupon ) {
      return;
    }

    $coupon_expiry      = $coupon->get_date_expires();
    $end_dates          = $this->get_end_dates_with_products( $bookable_products );
    $exceeding_products = array();

    if ( $coupon_expiry && $end_dates ) {

      foreach ( $end_dates as $timestamp => $product ) {

        if ( $timestamp > $coupon_expiry->getOffsetTimestamp() ) {
          $exceeding_products[] = $product;
        }

      }

    }

    return $exceeding_products;

  }

  /**
    * Check if limit option is set for coupon
    *
    * @param object WC_Coupon
    * @return bool true if option is used else false
    */
  private function book_before_expiration( $coupon ) {

    $limit_booking = false;

    $limit_booking_option = get_post_meta( $coupon->get_id(), 'book_before_expiration', true );

    if ( 'yes' == $limit_booking_option ) {
      $limit_booking = true;
    }

    return $limit_booking;

  }

}
