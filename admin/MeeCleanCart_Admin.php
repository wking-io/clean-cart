<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.wking.io
 * @since      1.0.0
 *
 * @package    MeeCleanCart
 * @subpackage MeeCleanCart/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    MeeCleanCart
 * @subpackage MeeCleanCart/admin
 * @author     Will King <contact@wking.io>
 */
class MeeCleanCart_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Products CPT.
	 *
	 * @since  1.0.0
	 *
	 * @var string $products The products custom post type.
	 */
	 public $products_cpt = null;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->products_cpt = 'cc_products';

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in MeeCleanCart_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The MeeCleanCart_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mee-clean-cart-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in MeeCleanCart_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The MeeCleanCart_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mee-clean-cart-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Registers the additional post types for lesson resources.
	 *
	 * This is hooked into the action 'init'.
	 *
	 * @author Will King
	 * @return void
	 */
	 public function cc_register_post_types()
	 {
 
		 $labels = array(
			 'name'               => _x( 'Products', 'post type general name', $this->plugin_name ),
			 'singular_name'      => _x( 'Product', 'post type singular name', $this->plugin_name ),
			 'menu_name'          => _x( 'Products', 'admin menu', $this->plugin_name ),
			 'name_admin_bar'     => _x( 'Product', 'add new on admin bar', $this->plugin_name ),
			 'add_new'            => _x( 'Add New', 'Product', $this->plugin_name ),
			 'add_new_item'       => __( 'Add New Product', $this->plugin_name ),
			 'new_item'           => __( 'New Product', $this->plugin_name ),
			 'edit_item'          => __( 'Edit Product', $this->plugin_name ),
			 'view_item'          => __( 'View Product', $this->plugin_name ),
			 'all_items'          => __( 'All Products', $this->plugin_name ),
			 'search_items'       => __( 'Search Products', $this->plugin_name ),
			 'parent_item_colon'  => __( 'Parent Products:', $this->plugin_name ),
			 'not_found'          => __( 'No Products found.', $this->plugin_name ),
			 'not_found_in_trash' => __( 'No Products found in Trash.', $this->plugin_name ),
		 );
 
		 $args = array(
			 'labels'             => apply_filters( 'cc_cpt_labels', $labels ),
			 'description'        => __( 'Products Custom Post Type.', $this->plugin_name ),
			 'public'             => true,
			 'publicly_queryable' => true,
			 'show_ui'            => true,
			 'show_in_menu'       => true,
			 'query_var'          => true,
			 'capability_type'    => 'post',
			 'has_archive'        => true,
			 'hierarchical'       => false,
			 'menu_position'      => null,
			 'supports'           => array( 'title' ),
		 );
		 register_post_type( $this->products_cpt, apply_filters( 'cc_cpt_args', $args ) );
	}

	/**
   * Register options pages.
   *
   * @since 1.0.0
   *
   * @author Will King
   * @return void
   */
	public function cc_add_options() {
		// add sub page
		acf_add_options_sub_page(array(
			'page_title' 	=> 'Product Options',
			'menu_title' 	=> 'Product Options',
			'parent_slug' 	=> 'edit.php?post_type=' . $this->products_cpt,
		));
	}

	/**
	 * Add Product Fields
	 *
	 * @since  1.0.0
	 *
	 * @author Will King
	 * @return void
	 */
	public function cc_register_product_fields() {
		if ( function_exists( 'acf_add_local_field_group' ) ) :
			$field_location = array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => $this->products_cpt,
					),
				),
			);

			$field_setup = array(
				array(
					'key'     => 'field_product_img',
					'label'   => __( 'Product Image', $this->plugin_name ),
					'name'    => 'product_img',
					'type'    => 'image',
					'return_format' => 'array',
					'mime_types' => 'jpg, png, gif',
				),
				array(
					'key'      => 'field_product_description',
					'label'    => __( 'Product Description', $this->plugin_name ),
					'name'     => 'product_description',
					'type'     => 'wysiwyg',
					'toolbar' => 'basic', 
					'media_upload' => 0,
				),
				array(
					'key'      => 'field_product_options',
					'label'    => __( 'Product Options', $this->plugin_name ),
					'name'     => 'product_options',
					'type'     => 'repeater',
					'button_label' => __( 'Add Option', $this->plugin_name ),
					//'max'      => 1,
					'min'      => 1,
					'layout'   => 'block',
					'sub_fields'  => array(
						array(
							'key'      => 'field_option_name',
							'label'    => __( 'Option Name', $this->plugin_name ),
							'name'     => 'option_name',
							'type'     => 'text',
							'placeholder' => 'Coral',
						),
					),
				),
			);
			acf_add_local_field_group(array(
				'key'      => 'products_info',
				'title'    => 'Product Info',
				'fields'   => $field_setup,
				'location' => $field_location,
			));

		endif;
	}

	/**
	 * Add Product Fields
	 *
	 * @since  1.0.0
	 *
	 * @author Will King
	 * @return void
	 */
	 public function cc_register_product_option_fields() {
		if ( function_exists( 'acf_add_local_field_group' ) ) :
			$field_location = array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'acf-options-product-options',
					),
				),
			);

			$field_setup = array(
				array(
					'key'      => 'field_product_option_label',
					'label'    => __( 'Product Option Label', $this->plugin_name ),
					'name'     => 'option_label',
					'type'     => 'text',
					'placeholder' => 'Select Your Option',
					'default_value' => 'Select Your Option',
				),
				array(
					'key'      => 'field_product_default_option',
					'label'    => __( 'Product Default Option', $this->plugin_name ),
					'name'     => 'default_option',
					'type'     => 'text',
					'placeholder' => 'Default',
					'default_value' => 'Default',
				),
				array(
					'key'      => 'field_product_message_label',
					'label'    => __( 'Product Message Label', $this->plugin_name ),
					'name'     => 'message_label',
					'type'     => 'text',
					'placeholder' => 'Enter Extra Details Below',
					'default_value' => 'Enter Extra Details Below',
				),
				array(
					'key'      => 'field_product_error_message',
					'label'    => __( 'Product Error Message', $this->plugin_name ),
					'name'     => 'error_message',
					'type'     => 'text',
					'placeholder' => 'Please choose an option',
					'default_value' => 'Please choose an option',
				),
				array(
					'key'      => 'field_product_success_heading',
					'label'    => __( 'Product Success Heading', $this->plugin_name ),
					'name'     => 'success_heading',
					'type'     => 'text',
					'placeholder' => 'Congrats!',
					'default_value' => 'Congrats!',
				),
				array(
					'key'      => 'field_product_success_message',
					'label'    => __( 'Product Success Message', $this->plugin_name ),
					'name'     => 'success_message',
					'type'     => 'text',
					'placeholder' => 'This item has been successfully added to your cart.',
					'default_value' => 'This item has been successfully added to your cart.',
				),
			);
			acf_add_local_field_group(array(
				'key'      => 'product_options',
				'title'    => 'Product Options',
				'fields'   => $field_setup,
				'location' => $field_location,
			));

		endif;
	}

/**
 * Register product photo sizes.
 *
 * @since 1.0.0
 *
 * @author Will King
 * @return void
 */
	public function cc_add_sizes() {
			add_image_size( 'product-l', 720, 480 );
			add_image_size( 'product-m', 528, 352 );
			add_image_size( 'product-s', 330, 220 );
	}

}
