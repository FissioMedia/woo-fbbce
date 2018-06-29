<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

/**
  * Add and save checkbox to the coupon options
  */
class Woo_Fbbce_Coupon_Setting {

  public function __construct() {
    add_action( 'woocommerce_coupon_options', array( $this, 'add_coupon_limiter_checkbox' ), 10, 0 );
    add_action( 'woocommerce_coupon_options_save', array( $this, 'save_coupon_limiter_checkbox' ) );
  }

  /**
    * Add checkbox to coupon options
    */
  public function add_coupon_limiter_checkbox() {

    woocommerce_wp_checkbox( array(
      'id'          => 'book_before_expiration',
      'label'       => __( 'Force booking before coupon expiration', 'woo-fbbce' ),
      'description' => sprintf( __( 'This coupon can only be applied to bookings that have date prior to coupon expiry date.', 'woo-fbbce' ) )
    ) );

  }

  /**
    * Save checkbox
    *
    * @param int $post_id ID of the coupon post
    */
  public function save_coupon_limiter_checkbox( $post_id ) {

    $coupon_limiter = isset( $_POST['book_before_expiration'] ) ? 'yes' : 'no';

    update_post_meta( $post_id, 'book_before_expiration', $coupon_limiter );

  }

}
