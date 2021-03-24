<?php
/**
 * Plugin Name: Woo Email
 * Plugin URI: https://www.tidbitsolution.com/
 * Description: Woo Email is redesign woocoomerce default email template
 * Version: 1.0.0
 * Author: Shanay
 * Author URI: https://www.tidbitsolution.com/
 * Text Domain: wc-email
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define WC_PLUGIN_FILE.
if ( ! defined( 'WOO_EMAIL_PLUGIN_FILE' ) ) {
	define( 'WOO_EMAIL_PLUGIN_FILE', __FILE__ );
}

define( 'WOO_EMAIL_VERSION', '1.0.0' );
define( 'WOO_EMAIL_TEMPLATE_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/template/' );
define( 'WOO_EMAIL_PLUGIN_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );
define( 'WOO_EMAIL_MAIN_FILE', __FILE__ );
define( 'WOO_EMAIL_ABSPATH', dirname( __FILE__ ) . '/' );

function WC_EMAIL_Active() {

	// Require parent plugin
	if( ! is_plugin_active('woocommerce/woocommerce.php') && current_user_can('activate_plugins')) {

		// Stop activation redirect and show error
        wp_die('Sorry, but this plugin requires the Woocommerce Plugin to be installed and active. <br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>');
	}
}
register_activation_hook( WOO_EMAIL_MAIN_FILE , 'WC_EMAIL_Active');

// Include the main WooCommerce class.
if ( ! class_exists( 'WC_Email' ) ) {
	include_once dirname( __FILE__ ) . '/includes/settings.php';
}

if (class_exists('Custom_Checkout_PD')) {
	
	class Remove_act extends Custom_Checkout_PD {
		public function __construct() {

			remove_filter('woocommerce_email_order_meta_keys', array($this, 'wps_select_order_meta_keys'), 50);
		}
	}
	new Remove_act;
}