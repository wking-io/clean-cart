<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.wking.io
 * @since      1.0.0
 *
 * @package    MeeCleanCart
 * @subpackage MeeCleanCart/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    MeeCleanCart
 * @subpackage MeeCleanCart/public
 * @author     Will King <contact@wking.io>
 */
class MeeCleanCart_Public {

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mee-clean-cart-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mee-clean-cart-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
  * Register product photo sizes.
  *
  * @since 1.0.0
  *
  * @author Will King
  * @return void
  */
  public function cc_add_shortcodes() {
		add_shortcode('productform', 'display_product_form');
		add_shortcode('producttitle', 'display_product_form');
		add_shortcode('productimage', 'display_product_form');
		add_shortcode('productdescription', 'display_product_form');
	}

	/**
  * Register product photo sizes.
  *
  * @since 1.0.0
  *
  * @author Will King
  * @return void
  */
	function display_product_form($atts) {
		$a = shortcode_atts( array(
			"product" => '123',
		), $atts);
		$form = '';
		$options = array();
		if( have_rows('product_options', $a['product']) ) {
			while ( have_rows('product_options', $a['product']) ) : the_row();
				array_push($options, the_sub_field('option_name'));
			endwhile;
		} else {
			array_push($options, the_field('default_option', 'options'));
		}

		ob_start(); ?>
		<div>
			<form>
				<div>
					<div class="error-message"><?php the_field('error_message', 'options'); ?></div>
					<label for="product_option"><?php the_field('option_label', 'options'); ?></label>
					<select name ="product_option">
						<?php foreach($options as $option) : ?>
							<option value="<?php echo str_replace(' ', '-', strtolower($option)); ?>"><? echo $option; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div>
					<label for="product_message"><?php the_field('message_label', 'options'); ?></label>
					<textarea type="text" name ="product_message"></textarea>
				</div>
				<input type="submit" />
			</form>
			<div>
				<h3><?php the_field('success_heading', 'options'); ?></h3>
				<p><?php the_field('success_message', 'options'); ?></p>
			</div>
		</div>
		<?php $form = ob_get_contents();
		ob_end_clean();
	}

}
