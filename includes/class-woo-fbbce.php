<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

class Woo_Fbbce {

  /**
    * @var Woo_Fbbce_Coupon_Setting
    */
  private $coupon_settings;

  /**
    * @var Woo_Fbbce_Date_Limiter
    */
  private $date_limiter;

  /**
   * The single instance of the class.
   *
   * @var Woo_Fbbce
   */
  protected static $_instance = null;

  /**
   * Main Plugin Instance.
   *
   * Ensures only one instance of plugin is loaded or can be loaded.
   *
   * @static
   * @return Woo_Fbbce - Main instance.
   */
  public static function instance() {
    if ( is_null( self::$_instance ) ) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }

  public function __construct() {
    $this->includes();
    $this->init();
  }

  /**
    * Include files
    */
  public function includes() {
    include_once WOO_FBBCE_PLUGIN_PATH . 'includes/class-woo-fbbce-coupon-settings.php';
    include_once WOO_FBBCE_PLUGIN_PATH . 'includes/class-woo-fbbce-date-limiter.php';
  }

  /**
    * Init plugin
    */
  public function init() {

    // Add custom checkbox to coupon options
    $this->coupon_settings = new Woo_Fbbce_Coupon_Setting();

    // Logic for limiting coupon usage
    $this->date_limiter = new Woo_Fbbce_Date_Limiter();
  }

}
