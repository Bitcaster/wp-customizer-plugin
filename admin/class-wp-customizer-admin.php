<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://bitcaster.de
 * @since      1.0.2
 *
 * @package    Wp_Customizer
 * @subpackage Wp_Customizer/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Customizer
 * @subpackage Wp_Customizer/admin
 * @author     Bitcaster GmbH <info@bitcaster.de>
 */
class Wp_Customizer_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.2
     * @access   private
     * @var      string $wp_customizer The ID of this plugin.
     */
    private $wp_customizer;

    /**
     * The version of this plugin.
     *
     * @since    1.0.2
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $wp_customizer The name of this plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.2
     */
    public function __construct($wp_customizer, $version)
    {
        $this->wp_customizer = $wp_customizer;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.2
     */
    public function enqueue_styles()
    {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Wp_Customizer_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Wp_Customizer_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style(
            $this->wp_customizer,
            plugin_dir_url(__FILE__) . 'css/wp-customizer-admin.css',
            [],
            $this->version,
            'all'
        );
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.2
     */
    public function enqueue_scripts()
    {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Wp_Customizer_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Wp_Customizer_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script(
            $this->wp_customizer,
            plugin_dir_url(__FILE__) . 'js/wp-customizer-admin.js',
            ['jquery'],
            $this->version,
            false
        );
    }

}
