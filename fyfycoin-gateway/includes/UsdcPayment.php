<?php


/**
 * UsdcPayment setup
 *
 * @package UsdcPayment
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;



/**
 * Main UsdcPayment Class.
 *
 * @class UsdcPayment
 */

final class UsdcPayment
{
    /**
     * UsdcPayment version.
     *
     * @var string
     */
    public $version = '1.0.0';

    /**
     * The single instance of the class.
     *
     * @var UsdcPayment
     * @since  1.0
     */
    private static $instance;

    /**
     * UsdcPayment HTML Element Helper Object.
     *
     * @var object|UsdcPayment_HTML_Elements
     * @since 1.0
     */
    public $html;


    public static function instance()
    {
        if (!isset(self::$instance) && !(self::$instance instanceof RestroPress)) {
            self::$instance = new UsdcPayment;

            add_action('plugins_loaded', array(self::$instance, 'load_configuration'));
            add_filter( 'woocommerce_payment_gateways', array(self::$instance, 'add_fyfyusdc_payment_gateway'));
            add_filter( 'woocommerce_currencies', array(self::$instance, 'add_usdc_currency'));
            add_filter( 'woocommerce_currency_symbol', array(self::$instance, 'add_usdc_currency_symbol'), 10 ,2);

            self::$instance->includes();

        }
    }


    /**
     * Cloning is forbidden.
     *
     * @since 2.1
     */
    public function __clone() {
        _doing_it_wrong( __FUNCTION__, __( 'Cloning is forbidden.', 'fyfyusdc' ), '2.6.1' );
    }

    /**
     * Unserializing instances of this class is forbidden.
     *
     * @since 2.1
     */
    public function __wakeup() {
        _doing_it_wrong( __FUNCTION__, __( 'Unserializing instances of this class is forbidden.', 'fyfyusdc' ), '2.6.1' );
    }

    /**
     * Include required core files used in admin and on the frontend.
     */
    public function includes() {

    }


    /**
     * UsdcPayment Constructor.
     */
    public function __construct() {
        $this->define_constants();
    }

    /**
     * Define RPRESS Constants.
     */
    private function define_constants() {
        $this->define( 'FYFY_VERSION', $this->version );
        $this->define( 'FYFY_PLUGIN_DIR', plugin_dir_path( FYFY_PLUGIN_FILE ) );
        $this->define( 'FYFY_PLUGIN_URL', plugin_dir_url( FYFY_PLUGIN_FILE ) );
        $this->define( 'CAL_GREGORIAN', 1 );
    }

    /**
     * Define constant if not already set.
     *
     * @param string      $name  Constant name.
     * @param string|bool $value Constant value.
     */
    private function define( $name, $value ) {
        if ( ! defined( $name ) ) {
            define( $name, $value );
        }
    }



    public function load_configuration() {

        /**
         * Import and configure new Payment Gateway for Woocommerce
         */

        if (class_exists('WooCommerce')) {
            require_once FYFY_PLUGIN_DIR . 'includes/class-fyfyusdc-woocommerce.php';
        }


        /**
         * Load Localisation files.
         *
         * Note: the first-loaded translation file overrides any following ones if the same translation is present.
         */

        load_plugin_textdomain( 'fyfyusdc', false, dirname( plugin_basename( FYFY_PLUGIN_FILE ) ). '/languages/' );

    }

    /**
     * Add Payment Gateway to Woocommerce Payment Gateway list
     */
    public function add_fyfyusdc_payment_gateway($gateways){

        /**
         * Validation of Setting for Store address, Enable/Disable USDC
         */

        $gateways[] = 'WC_FYFYUSDC_Gateway';

        return $gateways;
    }

    /**
     * Add Custom Currency to Woocommerce
     */
    public function add_usdc_currency($cw_currency ){
        $cw_currency['FYFYUSDC'] = __( 'USDC(FYFY) CURRECY', 'woocommerce' );
        return $cw_currency;
    }

    function add_usdc_currency_symbol( $custom_currency_symbol, $custom_currency ) {
        switch( $custom_currency ) {
            case 'FYFYUSDC': $custom_currency_symbol = 'USDC'; break;
        }
        return $custom_currency_symbol;
    }

}