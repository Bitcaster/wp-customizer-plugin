<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://bitcaster.de
 * @since      1.0.5
 *
 * @package    Wp_Customizer
 * @subpackage Wp_Customizer/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.5
 * @package    Wp_Customizer
 * @subpackage Wp_Customizer/includes
 * @author     Bitcaster GmbH <info@bitcaster.de>
 */
class Wp_Customizer_i18n
{


    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.5
     */
    public function load_plugin_textdomain()
    {
        load_plugin_textdomain(
            'wp-customizer',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );
    }


}
