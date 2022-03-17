<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://bitcaster.de
 * @since      1.1.2
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
     * @since    1.1.2
     * @access   private
     * @var      string $wp_customizer The ID of this plugin.
     */
    private string $wp_customizer;

    /**
     * The version of this plugin.
     *
     * @since    1.1.2
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private string $version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $wp_customizer The name of this plugin.
     * @param string $version The version of this plugin.
     * @since    1.1.2
     */
    public function __construct(string $wp_customizer, string $version)
    {
        $this->wp_customizer = $wp_customizer;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.1.2
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
            $this->version
        );
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.1.2
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
            $this->version
        );
    }

    public function bitcaster_add_settings_page()
    {
        add_options_page(
            'Bitcaster wp-customizer plugin page',
            'Bitcaster WP-Customizer Plugin Menu',
            'manage_options',
            'bitcaster-wp-customizer-plugin',
            function () { ?>
                <h2>Bitcaster WP-Customizer Plugin Settings</h2>
                <form action="options.php" method="post">
                    <?php
                    settings_fields('bitcaster_wp_customizer_plugin_options');
                    do_settings_sections('bitcaster_wp_customizer_plugin'); ?>
                    <input name="submit" class="button button-primary" type="submit" value="<?php
                    esc_attr_e('Save'); ?>"/>
                </form>
                <?php
            }
        );
    }


    public function bitcaster_wp_customizer_register_settings()
    {
        register_setting(
            'bitcaster_wp_customizer_plugin_options',
            'bitcaster_wp_customizer_plugin_options',
            'bitcaster_wp_customizer_plugin_options_validate'
        );
        add_settings_section(
            'general_settings',
            'General Settings',
            function() {
                echo '<p>Here you can set all the options for using the API</p>';
            },
            'bitcaster_wp_customizer_plugin'
        );

        add_settings_field(
            'bitcaster_wp_customizer_setting_frontend_url',
            'Frontend Url',
            function () {
                if (($options = get_option('bitcaster_wp_customizer_plugin_options'))
                    && $options && isset($options['frontend_url'])
                    && ($frontendUrl = $options['frontend_url']) && $frontendUrl) {
                    echo "<input id='bitcaster_wp_customizer_setting_frontend_url' name='bitcaster_wp_customizer_plugin_options[frontend_url]' type='text' value='" . esc_attr($frontendUrl) . "' />";
                } else {
                    echo "<input id='bitcaster_wp_customizer_setting_frontend_url' placeholder='https://frontend.url' name='bitcaster_wp_customizer_plugin_options[frontend_url]' type='text' />";
                }
            },
            'bitcaster_wp_customizer_plugin',
            'general_settings'
        );

        add_settings_field(
            'bitcaster_wp_customizer_setting_backend_url',
            'Backend Url',
            function () {
                if (($options = get_option('bitcaster_wp_customizer_plugin_options'))
                    && $options && isset($options['backend_url'])
                    && ($backendUrl = $options['backend_url']) && $backendUrl) {
                    echo "<input id='bitcaster_wp_customizer_setting_backend_url' name='bitcaster_wp_customizer_plugin_options[backend_url]' type='text' value='" . esc_attr($backendUrl) . "' />";
                } else {
                    echo "<input id='bitcaster_wp_customizer_setting_backend_url' placeholder='https://backend.url' name='bitcaster_wp_customizer_plugin_options[backend_url]' type='text' />";
                }
            },
            'bitcaster_wp_customizer_plugin',
            'general_settings'
        );
    }
}
