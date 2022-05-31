<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://bitcaster.de
 * @since      1.1.4
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
class Wp_Customizer_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.1.4
	 * @access   private
	 * @var      string $wp_customizer The ID of this plugin.
	 */
	private string $wp_customizer;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.1.4
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private string $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $wp_customizer The name of the plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.1.4
	 */
	public function __construct( string $wp_customizer, string $version ) {
		$this->wp_customizer = $wp_customizer;
		$this->version       = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.1.4
	 */
	public function enqueue_styles() {
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
			plugin_dir_url( __FILE__ ) . 'css/wp-customizer-public.css',
			[],
			$this->version
		);
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.1.4
	 */
	public function enqueue_scripts() {
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
			plugin_dir_url( __FILE__ ) . 'js/wp-customizer-public.js',
			[ 'jquery' ],
			$this->version
		);
	}

	public function bitcaster_wp_customizer_register_event_reviews() {
		/**
		 * Post Type: Event Reviews.
		 */

		$labels = [
			'name'                     => __( 'Event Reviews', 'oceanwp' ),
			'singular_name'            => __( 'Event Review', 'oceanwp' ),
			'menu_name'                => __( 'Omicron Event Reviews', 'oceanwp' ),
			'all_items'                => __( 'All Event Reviews', 'oceanwp' ),
			'add_new'                  => __( 'Add new', 'oceanwp' ),
			'add_new_item'             => __( 'Add new Event Review', 'oceanwp' ),
			'edit_item'                => __( 'Edit Event Review', 'oceanwp' ),
			'new_item'                 => __( 'New Event Review', 'oceanwp' ),
			'view_item'                => __( 'View Event Review', 'oceanwp' ),
			'view_items'               => __( 'View Event Reviews', 'oceanwp' ),
			'search_items'             => __( 'Search Event Reviews', 'oceanwp' ),
			'not_found'                => __( 'No Event Reviews found', 'oceanwp' ),
			'not_found_in_trash'       => __( 'No Event Reviews found in trash', 'oceanwp' ),
			'parent'                   => __( 'Parent Event Review:', 'oceanwp' ),
			'featured_image'           => __( 'Featured image for this Event Review', 'oceanwp' ),
			'set_featured_image'       => __( 'Set featured image for this Event Review', 'oceanwp' ),
			'remove_featured_image'    => __( 'Remove featured image for this Event Review', 'oceanwp' ),
			'use_featured_image'       => __( 'Use as featured image for this Event Review', 'oceanwp' ),
			'archives'                 => __( 'Event Review archives', 'oceanwp' ),
			'insert_into_item'         => __( 'Insert into Event Review', 'oceanwp' ),
			'uploaded_to_this_item'    => __( 'Upload to this Event Review', 'oceanwp' ),
			'filter_items_list'        => __( 'Filter Event Reviews list', 'oceanwp' ),
			'items_list_navigation'    => __( 'Event Reviews list navigation', 'oceanwp' ),
			'items_list'               => __( 'Event Reviews list', 'oceanwp' ),
			'attributes'               => __( 'Event Reviews attributes', 'oceanwp' ),
			'name_admin_bar'           => __( 'Event Review', 'oceanwp' ),
			'item_published'           => __( 'Event Review published', 'oceanwp' ),
			'item_published_privately' => __( 'Event Review published privately.', 'oceanwp' ),
			'item_reverted_to_draft'   => __( 'Event Review reverted to draft.', 'oceanwp' ),
			'item_scheduled'           => __( 'Event Review scheduled', 'oceanwp' ),
			'item_updated'             => __( 'Event Review updated.', 'oceanwp' ),
			'parent_item_colon'        => __( 'Parent Event Review:', 'oceanwp' ),
		];

		$args = [
			'label'                 => __( 'Event Reviews', 'oceanwp' ),
			'labels'                => $labels,
			'description'           => 'Stores a review of an event',
			'public'                => true,
			'publicly_queryable'    => true,
			'show_ui'               => true,
			'show_in_rest'          => true,
			'rest_base'             => 'event-review',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			'rest_namespace'        => 'wp/v2',
			'has_archive'           => false,
			'show_in_menu'          => true,
			'show_in_nav_menus'     => true,
			'delete_with_user'      => false,
			'exclude_from_search'   => true,
			'capability_type'       => 'event-review',
			'map_meta_cap'          => true,
			'hierarchical'          => false,
			'can_export'            => true,
			'rewrite'               => [ 'slug' => 'event_review', 'with_front' => true ],
			'query_var'             => 'event-review',
			'menu_position'         => 100,
			'supports'              => [ 'title', 'custom-fields', 'email', 'review', 'rating', 'event-review', 'review-group' ],
			'register_meta_box_cb'  => function () {
				$fields = [ 'review', 'rating', 'email'];
				foreach ( $fields as $field ) {
					add_meta_box( 'review-group-' . $field, $field, static function () use ( $field ) {
						global $post;

						//Nonce to verify the data
						echo '<input type="hidden" '
						     . 'name="property_meta_noncename" '
						     . 'id="property_meta_noncename" '
						     . 'value = "' . wp_create_nonce( plugin_basename( __FILE__ ) ) . '" />';

						//Get the contact data if it is already written
						$fieldData = get_post_meta( $post->ID, $field, true );

						//Output the field
						echo '<input type="text" name="' . $field . '" value="' . $fieldData . '" class = "property-" . $field ';
					},            'event_review' );
				}
			},
			'taxonomies'            => [ 'event_review' ],
			'show_in_graphql'       => false,
		];

		register_post_type( 'event_review', $args );

		/**
		 * Taxonomy: Event Reviews.
		 */

		$labels = [
			'name'                       => __( 'Event Reviews', 'oceanwp' ),
			'singular_name'              => __( 'Event Review', 'oceanwp' ),
			'menu_name'                  => __( 'Event Reviews', 'oceanwp' ),
			'all_items'                  => __( 'All Event Reviews', 'oceanwp' ),
			'edit_item'                  => __( 'Edit Event Review', 'oceanwp' ),
			'view_item'                  => __( 'View Event Review', 'oceanwp' ),
			'update_item'                => __( 'Update Event Review name', 'oceanwp' ),
			'add_new_item'               => __( 'Add new Event Review', 'oceanwp' ),
			'new_item_name'              => __( 'New Event Review name', 'oceanwp' ),
			'parent_item'                => __( 'Parent Event Review', 'oceanwp' ),
			'parent_item_colon'          => __( 'Parent Event Review:', 'oceanwp' ),
			'search_items'               => __( 'Search Event Reviews', 'oceanwp' ),
			'popular_items'              => __( 'Popular Event Reviews', 'oceanwp' ),
			'separate_items_with_commas' => __( 'Separate Event Reviews with commas', 'oceanwp' ),
			'add_or_remove_items'        => __( 'Add or remove Event Reviews', 'oceanwp' ),
			'choose_from_most_used'      => __( 'Choose from the most used Event Reviews', 'oceanwp' ),
			'not_found'                  => __( 'No Event Reviews found', 'oceanwp' ),
			'no_terms'                   => __( 'No Event Reviews', 'oceanwp' ),
			'items_list_navigation'      => __( 'Event Reviews list navigation', 'oceanwp' ),
			'items_list'                 => __( 'Event Reviews list', 'oceanwp' ),
			'back_to_items'              => __( 'Back to Event Reviews', 'oceanwp' ),
		];


		$args = [
			'label'                 => __( 'Event Reviews', 'oceanwp' ),
			'labels'                => $labels,
			'public'                => true,
			'publicly_queryable'    => true,
			'hierarchical'          => false,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'show_in_nav_menus'     => true,
			'query_var'             => true,
			'rewrite'               => [ 'slug' => 'event_review', 'with_front' => true, ],
			'show_admin_column'     => true,
			'show_in_rest'          => true,
			'show_tagcloud'         => false,
			'rest_base'             => 'event-review-taxonomy',
			'rest_controller_class' => 'WP_REST_Terms_Controller',
			'rest_namespace'        => 'wp/v2',
			'show_in_quick_edit'    => false,
			'sort'                  => false,
			'show_in_graphql'       => false,
		];
		register_taxonomy( 'event_review', [ 'event_review' ], $args );
	}
}
