<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://bitcaster.de
 * @since             1.1.4
 * @package           Wp_Customizer
 *
 * @wordpress-plugin
 * Plugin Name:       Bitcaster WP Customizer
 * Plugin URI:        https://github.com/Bitcaster/wp-customizer-plugin
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.1.4
 * Author:            Bitcaster GmbH
 * Author URI:        https://bitcaster.de/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-customizer
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
const WP_CUSTOMIZER_VERSION = '1.1.4';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-customizer-activator.php
 */
function activate_wp_customizer()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-wp-customizer-activator.php';
    Wp_Customizer_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-customizer-deactivator.php
 */
function deactivate_wp_customizer()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-wp-customizer-deactivator.php';
    Wp_Customizer_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_wp_customizer');
register_deactivation_hook(__FILE__, 'deactivate_wp_customizer');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-wp-customizer.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.1.4
 */
function run_wp_customizer()
{
    $plugin = new Wp_Customizer();
    $plugin->run();
}

run_wp_customizer();
