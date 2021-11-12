<?php
if (!defined('ABSPATH')) exit;

/**
 *
 * This file includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function that starts the plugin.
 *
 * @link              https://fyfy.io
 * @since             1.0.0
 * @package           fyfyusdc
 *
 * @wordpress-plugin
 * Plugin Name:       FyFyusdc Gateway
 * Plugin URI:        https://fyfy.io
 * Description:       Add the USDC token in Woocommerce, making use of Phantom and SolFare for decentralized commerce.
 * Version:           1.0.0
 * Author:            FyFy
 * Author URI:        https://fyfy.io
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       fyfyusdc
 */


if ( ! defined( 'FYFY_PLUGIN_FILE' ) ) {
    define( 'FYFY_PLUGIN_FILE', __FILE__ );
}

// Include the main UsdcPayment class.
if ( ! class_exists( 'UsdcPayment', false ) ) {
    include_once dirname( __FILE__ ) . '/includes/UsdcPayment.php';
}


/**
 * Returns the main instance of UsdcPayment.
 *
 * @return UsdcPayment
 */
function FYFYUSDC() {
    return UsdcPayment::instance();
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/fyfyusdc-activator.php
 */
function activate_fyfyusdc() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/fyfyusdc-activator.php';
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/fyfyusdc-deactivator.php
 */
function deactivate_fyfyusdc() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/fyfyusdc-deactivator.php';
}

register_activation_hook( __FILE__, 'activate_fyfyusdc' );
register_deactivation_hook( __FILE__, 'deactivate_fyfyusdc' );

//Get UsdcPayment Running.
FYFYUSDC();