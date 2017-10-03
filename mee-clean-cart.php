<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.wking.io
 * @since             1.0.0
 * @package           MeeCleanCart
 *
 * @wordpress-plugin
 * Plugin Name:       Clean Cart
 * Plugin URI:        https://www.wking.io
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Will King
 * Author URI:        https://www.wking.io
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mee-clean-cart
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'PLUGIN_VERSION', '1.0.0' );
define( 'PLUGIN_NAME', 'mee-clean-cart' );
define( 'PLUGIN_DIR', plugin_dir_path(__FILE__));

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mee_clean_cart-activator.php
 */
function activate_mee_clean_cart() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/MeeCleanCart_Activator.php';
	MeeCleanCart_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mee_clean_cart-deactivator.php
 */
function deactivate_mee_clean_cart() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/MeeCleanCart_Deactivator.php';
	MeeCleanCart_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_mee_clean_cart' );
register_deactivation_hook( __FILE__, 'deactivate_mee_clean_cart' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/MeeCleanCart.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mee_clean_cart() {

	$plugin = new MeeCleanCart();
	$plugin->run();

}
run_mee_clean_cart();
