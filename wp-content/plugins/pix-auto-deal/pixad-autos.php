<?php
/*
Plugin Name: PixAutoDeal
Description: Extends Wordpress with auto posts.
Version: 1.0.2
Author: Templines
Author URI: http://www.templines.com

*/

if( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'Pix_Autos' ) ) {
	class Pix_Autos {
		
		/**
		 * Refers to a single instance of this class.
		 * 
		 * @rewritten
		 * @since 1.0
		 */
		private static $instance = null;
		
		/**
		 * Plugin Version
		 *
		 * @rewritten
		 * @since 1.0
		 */
		static private $version = '1.0.2';
		
		/**
		 * Class Constructor
		 *
		 * @rewritten
		 * @since 1.0
		 */
		function __construct() {
			
			add_action( 'plugins_loaded', array( $this, 'localization' ) );
			$this->init();
			
		}
		
		/**
		 * Creates or returns an instance of this class.
		 *
		 * @rewritten
		 * @since 1.0
		 */
		public static function get_instance() {
			
			if( null == self::$instance ) {
				self::$instance = new self;
			}
			
			return self::$instance;
		}
		
		/**
		 * Plugin Localization
		 *
		 * @rewritten
		 * @since 1.0
		 */
		function localization() {
			$path = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
			load_plugin_textdomain( 'pixautodeal', false, $path );
		}
		
		/**
		 * Plugin Initialization
		 *
		 * @rewritten
		 * @since 1.0
		 */
		public function init() {
			
			$this->defines();
			$this->includes();
			
		}
		
		/**
		 * Plugin Defines
		 *
		 * @rewritten
		 * @since 1.0
		 */
		private function defines() {
			if( ! defined( 'TEXTDOMAIN' ) )
				   define( 'TEXTDOMAIN', 'pixautodeal' );
			 
			if( ! defined( 'PIXAD_AUTO_URI' ) )
				   define( 'PIXAD_AUTO_URI', plugin_dir_url( __FILE__ ) );
			
			if( ! defined( 'PIXAD_AUTO_DIR' ) ) 
				   define( 'PIXAD_AUTO_DIR', plugin_dir_path( __FILE__ ) );
			  
			if( ! defined( 'PIXAD_TEMPLATES_DIR' ) ) 
				   define( 'PIXAD_TEMPLATES_DIR', PIXAD_AUTO_DIR . 'templates/' );

		}
		
		/**
		 * Include Necessary Files
		 *
		 * @rewritten
		 * @since 1.0
		 */
		private function includes() {
			$files = array(
				PIXAD_AUTO_DIR . 'classes/class.pixad-custom.php',
				PIXAD_AUTO_DIR . 'includes/backend/post_taxonomy_type.php',
				PIXAD_AUTO_DIR . 'install.php',
				PIXAD_AUTO_DIR . 'classes/class.pixad-settings.php',
				PIXAD_AUTO_DIR . 'classes/class.pixad-country.php',
				PIXAD_AUTO_DIR . 'classes/class.pixad-autos.php',
				PIXAD_AUTO_DIR . 'includes/global/media_uploader.php',
				PIXAD_AUTO_DIR . 'includes/functions_global.php',
				PIXAD_AUTO_DIR . 'includes/functions_backend.php',
				//PIXAD_AUTO_DIR . 'classes/class.pixad-ajax.php',
				PIXAD_AUTO_DIR . 'includes/widgets/widget_sidebar.php',
			);
			if( $files ) {
				foreach( $files as $file ) {
					require_once $file;
				}
			}
		}

		/**
		 * Load Shortcodes
		 *
		 * @rewritten
		 * @since 0.7
		 */
		private function shortcodes() {
			$files = glob( PIXAD_AUTO_DIR . 'shortcodes/*.php' );
			foreach( $files as $file ) {
				require_once $file;
			}
		}

		/**
		 * Get Plugin Version
		 *
		 * @rewritten
		 * @since 1.0
		 */
		public static function version() {
			return self::$version;
		}
	}
	Pix_Autos::get_instance();
}