<?php
/**
 * Plugin Name: Custom Banner
 * Plugin URI:
 * Description: A customizable banner with HTML support and color picker options
 * Version: 1.0.0
 * Author: Your Name
 * Author URI:
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: custom-banner
 *
 * @package Custom_Banner
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('CUSTOM_BANNER_VERSION', '1.0.0');
define('CUSTOM_BANNER_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CUSTOM_BANNER_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include required files
require_once CUSTOM_BANNER_PLUGIN_DIR . 'includes/class-custom-banner-admin.php';
require_once CUSTOM_BANNER_PLUGIN_DIR . 'includes/class-custom-banner-display.php';

/**
 * Initialize the plugin
 *
 * Sets up the admin and display functionality.
 */
function custom_banner_init() {
    // Initialize admin
    if (is_admin()) {
        new Custom_Banner_Admin();
    }

    // Initialize display
    new Custom_Banner_Display();
}
add_action('plugins_loaded', 'custom_banner_init');

/**
 * Plugin activation hook
 */
function custom_banner_activate() {
    // Set default options
    $default_options = array(
        'banner_text'      => 'Welcome to our website!',
        'text_color'       => '#ffffff',
        'background_color' => '#000000',
        'button_text'      => 'Shop All',
        'button_url'       => '#',
        'button_color'     => '#ffffff',
        'button_text_color' => '#000000',
        'is_active'        => true,
    );

    add_option('custom_banner_options', $default_options);
}
register_activation_hook(__FILE__, 'custom_banner_activate');

/**
 * Plugin deactivation hook
 */
function custom_banner_deactivate() {
    // Cleanup if needed
}
register_deactivation_hook(__FILE__, 'custom_banner_deactivate');