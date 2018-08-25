<?php
/*
 * Plugin Name: Auto Load Next Post: Support Boilerplate
 * Plugin URI:  https://github.com/AutoLoadNextPost/alnp-support-boilerplate
 * Description: Boilerplate for providing theme support for Auto Load Next Post.
 * Author: Auto Load Next Post
 * Author URI: https://autoloadnextpost.com
 * Version: 1.0.0
 * Developer: Sébastien Dumont
 * Developer URI: https://sebastiendumont.com
 * Text Domain: alnp-support-boilerplate
 * Domain Path: /languages/
 *
 * Copyright: © 2018 Sébastien Dumont
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package   Auto Load Next Post: Support Boilerplate
 * @author    Auto Load Next Post
 * @copyright Copyright © 2018, Auto Load Next Post
 * @license   GNU General Public License v3.0 http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! class_exists( 'ALNP_Support_Boilerplate' ) ) {
	class ALNP_Support_Boilerplate {

		/**
		 * @var ALNP_Support_Boilerplate - the single instance of the class.
		 *
		 * @access protected
		 * @static
		 * @since 1.0.0
		 */
		protected static $_instance = null;

		/**
		 * Plugin Version
		 *
		 * @access public
		 * @static
		 * @since  1.0.0
		 */
		public static $version = '1.0.0';

		/**
		 * Required Auto Load Next Post Version
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public $required_alnp = '1.5.0';

		/**
		 * Main ALNP_Support_Boilerplate Instance.
		 *
		 * Ensures only one instance of ALNP_Support_Boilerplate is loaded or can be loaded.
		 *
		 * @access public
		 * @static
		 * @since  1.0.0
		 * @see    ALNP_Support_Boilerplate()
		 * @return ALNP_Support_Boilerplate - Main instance
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		} // END instance()

		/**
		 * Cloning is forbidden.
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, __( 'Cloning this object is forbidden.', 'alnp-support-boilerplate' ), self::$version );
		} // END __clone()

		/**
		 * Unserializing instances of this class is forbidden.
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, __( 'Unserializing instances of this class is forbidden.', 'alnp-support-boilerplate' ), self::$version );
		} // END __wakeup()

		/**
		 * ALNP_Support_Boilerplate Constructor.
		 *
		 * @access public
		 * @since  1.0.0
		 * @return ALNP_Support_Boilerplate
		 */
		public function __construct() {
			$this->init_hooks();
		} // END __construct()

		/**
		 * Initialize hooks.
		 *
		 * @access private
		 * @since  1.0.0
		 */
		private function init_hooks() {
			// Check that the required version of Auto Load Next Post is installed.
			add_action( 'auto_load_next_post_loaded', array( $this, 'check_required_version' ) );

			// Load textdomain.
			add_action( 'init', array( $this, 'load_plugin_textdomain' ), 0 );

			// Add theme support and preset the theme selectors and if the JavaScript should load in the footer.
			add_action( 'after_setup_theme', array( $this, 'add_theme_support' ) );

			// Filters the location of the repeater template. - Uncomment the next line to enable filter.
			//add_filter( 'alnp_template_redirect', array( $this, 'template_redirect' ) );

			// Filters the repeater template location. - Uncomment the next line to enable filter.
			//add_filter( 'alnp_template_location', array( $this, 'alnp_template_location' ) );

			// Register support once plugin is activated.
			register_activation_hook( __FILE__, array( $this, 'update_alnp_settings' ) );
		} // END init_hooks()

		/**
		 * Checks if the required Auto Load Next Post is installed.
		 *
		 * @access public
		 * @since  1.0.0
		 * @return bool
		 */
		public function check_required_version() {
			if ( ! defined( 'AUTO_LOAD_NEXT_POST_VERSION' ) || version_compare( AUTO_LOAD_NEXT_POST_VERSION, $this->required_alnp, '<' ) ) {
				add_action( 'admin_notices', array( $this, 'alnp_not_installed' ) );
				return false;
			}
		} // END check_alnp_installed()

		/**
		 * Required version of Auto Load Next Post is Not Installed Notice.
		 *
		 * @access public
		 * @since  1.0.0
		 * @return void
		 */
		public function alnp_not_installed() {
			echo '<div class="error"><p>' . sprintf( __( 'Auto Load Next Post: Support Boilerplate requires $%1s v%2$s or higher to be installed.', 'alnp-support-boilerplate' ), '<a href="https://autoloadnextpost.com/" target="_blank">Auto Load Next Post</a>', $this->required_alnp ) . '</p></div>';
		} // END alnp_not_installed()

		/***
		 * Add theme support for Auto Load Next Post by setting the 
		 * theme selectors, if the theme requires the JavaScript
		 * to load in the footer and only in the footer.
		 *
		 * These settings will be applied once the plugin is activated. 
		 *
		 * @access public
		 */
		public function add_theme_support() {
			add_theme_support( 'auto-load-next-post', array(
				'content_container'    => 'main.site-main',
				'title_selector'       => 'h1.entry-title',
				'navigation_container' => 'nav.post-navigation',
				'comments_container'   => 'div#comments',
				'load_js_in_footer'    => 'no',
				'lock_js_in_footer'    => 'no',
			) );
		} // END add_theme_support()

		/**
		 * Filters the location of the repeater template to override the default repeater template.
		 *
		 * @access public
		 * @return string
		 */
		public function template_redirect() {
			return dirname( plugin_basename( __FILE__ ) ) . '/content-alnp.php';
		} // END template_redirect()

		/**
		 * Filters the template location for get_template_part().
		 *
		 * @access public
		 * @return string
		 */
		public function alnp_template_location() {
			return '';
		} // END alnp_template_location()

		/*-----------------------------------------------------------------------------------*/
		/*  Helper Functions                                                                 */
		/*-----------------------------------------------------------------------------------*/

		/**
		 * Updates the theme selectors and any additionl supported feature.
		 *
		 * @access public
		 */
		public function update_alnp_settings( $stylesheet = '', $old_theme = false ) {
			$theme_support = get_theme_support( 'auto-load-next-post' );

			if ( is_array( $theme_support ) ) {
				// Preferred implementation, where theme provides an array of options
				if ( isset( $theme_support[0] ) && is_array( $theme_support[0] ) ) {
					foreach( $theme_support[0] as $key => $value ) {
						if ( ! empty( $value ) ) update_option( 'auto_load_next_post_' . $key, $value );
					}
				}
			}
		} // END update_alnp_settings()

		/*-----------------------------------------------------------------------------------*/
		/*  Localization                                                                     */
		/*-----------------------------------------------------------------------------------*/

		/**
		 * Make the plugin translation ready.
		 *
		 * Translations should be added in the WordPress language directory:
		 *  - WP_LANG_DIR/plugins/alnp-support-boilerplate-LOCALE.mo
		 *
		 * @access public
		 * @since  1.0.0
		 * @return void
		 */
		public function load_plugin_textdomain() {
			load_plugin_textdomain( 'alnp-support-boilerplate', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		} // END load_plugin_textdomain()

	} // END class

} // END if class exists

return ALNP_Support_Boilerplate::instance();
