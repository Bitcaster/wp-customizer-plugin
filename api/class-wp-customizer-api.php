<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://bitcaster.de
 * @since      1.0.2
 *
 * @package    Wp_Customizer
 * @subpackage Wp_Customizer/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Customizer
 * @subpackage Wp_Customizer/public
 * @author     Bitcaster GmbH <info@bitcaster.de>
 */
class Wp_Customizer_Api
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
     * @param string $wp_customizer The name of the plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.2
     */
    public function __construct($wp_customizer, $version)
    {
        $this->wp_customizer = $wp_customizer;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.2
     */
    public function validate_woo_customer_request($result)
    {
        global $woocommerce;
        if ($woocommerce && $woocommerce->is_rest_api_request()) {
            $result = true;
        }
        return $result;
    }

}
