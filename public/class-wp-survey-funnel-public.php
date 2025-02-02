<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://club.wpeka.com
 * @since      1.0.0
 *
 * @package    Wp_Survey_Funnel
 * @subpackage Wp_Survey_Funnel/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Survey_Funnel
 * @subpackage Wp_Survey_Funnel/public
 * @author     WPEka Club <support@wpeka.com>
 */
class Wp_Survey_Funnel_Public {


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
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style(
			$this->plugin_name . '-public',
			plugin_dir_url( __FILE__ ) . 'css/wp-survey-funnel-public.css',
			array( 'jquery' ),
			$this->version,
			'all'
		);
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'js/wp-survey-funnel-public.js',
			array( 'jquery' ),
			$this->version,
			false
		);

		wp_register_script(
			$this->plugin_name . '-display',
			plugin_dir_url( __FILE__ ) . 'js/wp-survey-funnel-display.js',
			array(),
			time(),
			false
		);
	}

	/**
	 * Public init of wpsf.
	 */
	public function wpsf_public_init() {
		add_shortcode( 'wpsf_survey', array( $this, 'wpsf_survey_shortcode_render' ) );
	}

	/**
	 * Display survey at the frontend.
	 */
	public function wpsf_survey_shortcode_render( $atts ) {
		$atts = shortcode_atts(
			array(
				'id' => 0,
			),
			$atts
		);

		return $this->wpsf_display_survey( $atts );
	}

	/**
	 * Display function of survey.
	 */
	public function wpsf_display_survey( $atts ) {
		if ( intval( $atts['id'] ) === 0 ) {
			return '';
		}

		$data = get_post_meta( $atts['id'], 'wpsf-survey-data', true );
		wp_enqueue_script( $this->plugin_name . '-display' );
		wp_localize_script( $this->plugin_name . '-display', 'data', $data );
		return '<div id="wpsf-survey-frontend" style="width: 100%"></div>';
	}
}
