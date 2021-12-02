<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://bitcaster.de
 * @since      1.0.4
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

    public function validate_woocommerce_rest_check_permissions(
        ?bool   $result = false,
        ?string $method = null,
        ?int    $objectId = null,
        ?string $objectType = null
    ) {
        if (!is_null($method) && !is_null($objectId) && !is_null($objectType)) {
            $supportedObjectTypesAndMethods =
                [
                    'user' => ['read', 'edit'],
                    'shop_order' => ['read']
                ];
        }
        if (!$result && in_array($objectType, array_keys($supportedObjectTypesAndMethods))
            && ($supportedMethods = $supportedObjectTypesAndMethods[$objectType])
            && $supportedMethods && (in_array($method, $supportedMethods) || in_array('*', $supportedMethods))) {
            if ($objectType === 'user') {
                /** @var WP_User $currentUser */
                $currentUser = wp_get_current_user();
                if ($currentUser->ID === (int)$objectId) {
                    $result = true;
                }
            } elseif ($objectType === 'shop_order') {
                /** @var WP_User $currentUser */
                $currentUser = wp_get_current_user();
                if ($currentUser->ID) {
                    $result = true;
                }
            }
        }
        return $result;
    }

    public function validate_woocommerce_rest_orders_prepare_object_query(
        ?array           $args = null,
        ?WP_REST_Request $request = null
    ) {
        /** @var WP_User $currentUser */
        if (($currentUser = wp_get_current_user()) && ($currentUserId = $currentUser->ID) && $currentUserId) {
            if (!current_user_can('administrator')) {
                if (isset($args['meta_query']) && ($metaQuery = $args['meta_query']) && $metaQuery) {
                    if (!in_array('_customer_user', array_column($metaQuery, 'key'))) {
                        $args['meta_query'][] =
                            [
                                'key' => '_customer_user',
                                'value' => $currentUserId,
                                'type' => 'NUMERIC',
                            ];
                    } else {
                        $key = array_search('_customer_user', array_column($metaQuery, 'key'));
                        $customerMetaQuery = $args['meta_query'][$key];
                        if ($customerMetaQuery['value'] !== $currentUserId) {
                            $customerMetaQuery['value'] = $currentUserId;
                            $args = $customerMetaQuery;
                        }
                    }
                } else {
                    $args['meta_query'][] =
                        [
                            'key' => '_customer_user',
                            'value' => $currentUserId,
                            'type' => 'NUMERIC',
                        ];
                }
            }
        } else {
            throw new WC_REST_Exception(
                'woocommerce_rest_invalid_customer_id',
                __('Customer ID is invalid.', 'woocommerce'),
                400
            );
        }
        return $args;
    }


}
