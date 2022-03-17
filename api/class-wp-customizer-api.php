<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://bitcaster.de
 * @since      1.1.2
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
     * List of media fields to filter.
     *
     * @var array
     */
    protected array $media_fields = [
        'media',
        'file',
        'file_upload',
        'file_advanced',
        'image',
        'image_upload',
        'image_advanced',
        'plupload_image',
        'thickbox_image',
    ];

    /**
     * List of fields that have no values.
     *
     * @var array
     */
    protected array $no_value_fields = [
        'heading',
        'custom_html',
        'divider',
        'button',
    ];

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
     * @param string $wp_customizer The name of the plugin.
     * @param string $version The version of this plugin.
     * @since    1.1.2
     */
    public function __construct(string $wp_customizer, string $version)
    {
        $this->wp_customizer = $wp_customizer;
        $this->version = $version;
    }

    public function validate_woocommerce_rest_check_permissions(
        ?bool   $result = false,
        ?string $method = null,
        ?int    $objectId = null,
        ?string $objectType = null
    ): ?bool {
        if (!is_null($method) && !is_null($objectId) && !is_null($objectType)) {
            $supportedObjectTypesAndMethods =
                [
                    'user' => ['read', 'edit'],
                    'shop_order' => ['read', 'create'],
                    'product' => ['read'],
                    'taxes' => ['read'],
                    'settings' => ['read'],
                ];
        }
        if (!$result && isset($supportedObjectTypesAndMethods) && in_array(
                $objectType,
                array_keys($supportedObjectTypesAndMethods)
            )
            && ($supportedMethods = $supportedObjectTypesAndMethods[$objectType]) && (in_array($method, $supportedMethods) || in_array(
                    '*',
                    $supportedMethods
                ))) {
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
            } elseif ($objectType === 'product') {
                /** @var WP_User $currentUser */
                $currentUser = wp_get_current_user();
                if ($currentUser->ID) {
                    $result = true;
                }
            } elseif ($objectType === 'taxes') {
                /** @var WP_User $currentUser */
                $currentUser = wp_get_current_user();
                if ($currentUser->ID) {
                    $result = true;
                }
            } elseif ($objectType === 'settings') {
                /** @var WP_User $currentUser */
                $currentUser = wp_get_current_user();
                if ($currentUser->ID) {
                    $result = true;
                }
            }
        }
        return $result;
    }

    /**
     * @throws WC_REST_Exception
     * @throws Exception
     */
    public function validate_woocommerce_rest_orders_prepare_object_query(
        ?array           $args = null,
        ?WP_REST_Request $request = null
    ) {
        /** @var WP_User $currentUser */
        if (($currentUser = wp_get_current_user()) && ($currentUserId = $currentUser->ID)) {
            if (!current_user_can('administrator')) {
                if (isset($args['meta_query']) && ($metaQuery = $args['meta_query'])) {
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

    /**
     * Filters the permalink to events
     *
     * @param mixed $link The link, possibly HTML, just URL, or false
     * @param int $post_id Post ID
     * @param bool $full_link Whether to output full HTML <a> link
     * @param string $url The URL itself
     */
    public function modify_tribe_get_event_link(
        $link,
        int $post_id,
        bool $full_link,
        string $url
    ) {
        $customizerOptions = get_option('bitcaster_wp_customizer_plugin_options');
        if (isset($customizerOptions['frontend_url'], $customizerOptions['backend_url'])
            && ($frontendUrl = $customizerOptions['frontend_url'])
            && ($backendUrl = $customizerOptions['backend_url'])) {
            $link = str_replace($backendUrl, $frontendUrl, $link);
        }
        return $link;
    }

    public function modify_tribe_rest_event_data(
        array   $data,
        WP_Post $event
    ): array {
        $data = $this->changeUrl($data);
        return $this->addMetaDownloadData($event, $data);
    }

    public function add_event_review_fields(): void
    {
        $fields = ['review', 'rating', 'email', 'event_id'];
        foreach ($fields as $field) {
            register_rest_field(
                'event_review',
                $field,
                [
                    'get_callback' => function ($object) use ($field) {
                        return get_post_meta($object['id'], $field, true);
                    },
                    'update_callback' => null,
                    'schema' => null,
                ]
            );
            register_meta(
                'post',
                $field,
                [
                    'type' => 'string',
                    'description' => $field . ' of Event',
                    'single' => true,
                    'show_in_rest' => true
                ]
            );
        }
    }


    /**
     * Get all fields' values from list of meta boxes.
     *
     * @param array $meta_boxes Array of meta box object.
     *
     * @param int $object_id Object ID.
     * @param array $args Additional params for helper function.
     *
     * @return array
     */
    protected function get_values(array $meta_boxes, int $object_id, array $args = []): array
    {
        $fields = [];
        foreach ($meta_boxes as $meta_box) {
            $fields = array_merge($fields, $meta_box->fields);
        }

        // Remove fields with no values.
        $fields = array_filter($fields, function ($field) {
            return !empty($field['id']) && !in_array($field['type'], $this->no_value_fields, true);
        });

        $values = [];
        foreach ($fields as $field) {
            $value = rwmb_get_value($field['id'], $args, $object_id);
            $value = $this->normalize_value($field, $value);

            $values[$field['id']] = $value;
        }

        return $values;
    }

    /**
     * Normalize value.
     *
     * @param array $field Field settings.
     * @param mixed $value Field value.
     * @return mixed
     */
    private function normalize_value(array $field, $value)
    {
        $value = $this->normalize_group_value($field, $value);
        return $this->normalize_media_value($field, $value);
    }

    /**
     * Normalize group value.
     *
     * @param array $field Field settings.
     * @param mixed $value Field value.
     * @return mixed
     */
    private function normalize_group_value(array $field, $value)
    {
        if ('group' !== $field['type']) {
            return $value;
        }
        if (isset($value['_state'])) {
            unset($value['_state']);
        }

        foreach ($field['fields'] as $subfield) {
            if (empty($subfield['id']) || empty($value[$subfield['id']])) {
                continue;
            }
            $subvalue = $value[$subfield['id']];
            $subvalue = $this->normalize_value($subfield, $subvalue);

            $value[$subfield['id']] = $subvalue;
        }

        return $value;
    }

    /**
     * Normalize media value.
     *
     * @param array $field Field settings.
     * @param mixed $value Field value.
     * @return mixed
     */
    private function normalize_media_value(array $field, $value)
    {
        /*
         * Make sure values of file/image fields are always indexed 0, 1, 2, ...
         * @link https://github.com/wpmetabox/mb-rest-api/commit/31aa8fa445c188e8a71ebff80027acbcaa0fd268
         */
        if (is_array($value) && in_array($field['type'], $this->media_fields, true)) {
            $value = array_values($value);
        }

        return $value;
    }

    public function post_register_meta_boxes($meta_boxes)
    {
        $prefix = '';

        $meta_boxes[] = [
            'title' => esc_html__('Downloads', 'online-generator'),
            'id' => 'download-group',
            'post_types' => ['post', 'page', 'tribe_events'],
            'context' => 'normal',
            'fields' => [
                [
                    'type' => 'file_advanced',
                    'name' => esc_html__('private content', 'online-generator'),
                    'id' => $prefix . 'private_content',
                    'clone' => true,
                    'attributes' => [
                        'private' => true,
                    ],
                ],
                [
                    'type' => 'file_advanced',
                    'name' => esc_html__('public content', 'online-generator'),
                    'id' => $prefix . 'public_content',
                    'clone' => true,
                    'attributes' => [
                        'private' => false,
                    ],
                ],
            ],
        ];

        $meta_boxes[] = [
            'title' => esc_html__('Event Review Group', 'online-generator'),
            'id' => 'review-group',
            'post_types' => ['event-review'],
            'context' => 'normal',
            'fields' => [
                [
                    'type' => 'taxonomy',
                    'name' => esc_html__('Rating', 'online-generator'),
                    'id' => $prefix . 'rating',
                    'taxonomy' => 'event-review-taxonomy',
                    'field_type' => 'radio_list'
                ],
                [
                    'type' => 'textarea',
                    'name' => esc_html__('Review', 'online-generator'),
                    'id' => $prefix . 'review',
                    'rows' => 3,
                ],
                [
                    'type' => 'text',
                    'name' => esc_html__('Email', 'online-generator'),
                    'id' => $prefix . 'email'
                ]
            ],
        ];

        return $meta_boxes;
    }

    public function woo_custom_redirect_after_purchase(): void
    {
        global $wp;
        if (!empty($wp->query_vars['order-received']) && is_checkout()) {
            if (($frontendUrl = $this->getFrontendUrl())) {
                $url = $frontendUrl . '/order-success?order_id=' . $wp->query_vars['order-received'];
            } else {
                $url = 'https://app-omicron.bitcaster.dev:3337/order-success?order_id=' . $wp->query_vars['order-received'];
            }
            wp_redirect($url);
            exit;
        }
    }

    /**
     * @param WP_Post $event
     * @param array $data
     * @return array
     */
    private function addMetaDownloadData(WP_Post $event, array $data): array
    {
        $meta_boxes = rwmb_get_registry('meta_box')->get_by(['object_type' => 'post']);
        $metaFields = $this->get_values($meta_boxes, $event->ID);
        if (isset($metaFields['private_content']) && ($privateContent = $metaFields['private_content']) && is_user_logged_in()) {
            $data['meta']['downloads']['private'] = $privateContent;
        }
        if (isset($metaFields['public_content']) && ($metaFields['public_content'])) {
            $data['meta']['downloads']['public'] = $metaFields['public_content'];
        }
        return $data;
    }

    /**
     * @param array $data
     * @return array
     */
    private function changeUrl(array $data): array
    {
        if (isset($data['url'])
            && ($frontendUrl = $this->getFrontendUrl())
            && ($backendUrl = $this->getBackendUrl())) {
            $data['url'] = str_replace($backendUrl, $frontendUrl, $data['url']);
        }
        return $data;
    }

    private function getFrontendUrl(): ?string
    {
        $customizerOptions = get_option('bitcaster_wp_customizer_plugin_options');
        if (isset($customizerOptions['frontend_url'])
            && ($frontendUrl = $customizerOptions['frontend_url'])) {
            return $frontendUrl;
        }
        return null;
    }

    private function getBackendUrl(): ?string
    {
        $customizerOptions = get_option('bitcaster_wp_customizer_plugin_options');
        if (isset($customizerOptions['backend_url'])
            && ($backendUrl = $customizerOptions['backend_url'])) {
            return $backendUrl;
        }
        return null;
    }
}
