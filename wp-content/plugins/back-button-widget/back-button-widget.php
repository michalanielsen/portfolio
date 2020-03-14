<?php
/*
Plugin Name: Back Button Widget
Plugin URI: https://wpfactory.com/item/back-button-widget-wordpress-plugin/
Description: Back button widget for WordPress.
Version: 1.2.1
Author: Algoritmika Ltd
Author URI: https://algoritmika.com
Text Domain: back-button-widget
Domain Path: /langs
Copyright: © 2020 Algoritmika Ltd.
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_Back_Button_Widget' ) ) :

/**
 * Main Alg_Back_Button_Widget Class.
 *
 * @class   Alg_Back_Button_Widget
 * @version 1.2.1
 * @since   1.0.0
 */
final class Alg_Back_Button_Widget {

	/**
	 * Plugin version.
	 *
	 * @var   string
	 * @since 1.0.0
	 */
	public $version = '1.2.1';

	/**
	 * @var   Alg_Back_Button_Widget The single instance of the class
	 * @since 1.0.0
	 */
	protected static $_instance = null;

	/**
	 * Main Alg_Back_Button_Widget Instance.
	 *
	 * Ensures only one instance of Alg_Back_Button_Widget is loaded or can be loaded.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @static
	 * @return  Alg_Back_Button_Widget - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Alg_Back_Button_Widget Constructor.
	 *
	 * @version 1.2.1
	 * @since   1.0.0
	 * @access  public
	 */
	function __construct() {

		// Check for active plugins
		if ( 'back-button-widget.php' === basename( __FILE__ ) && $this->is_plugin_active( 'back-button-widget-pro/back-button-widget-pro.php' ) ) {
			return;
		}

		// Set up localisation
		load_plugin_textdomain( 'back-button-widget', false, dirname( plugin_basename( __FILE__ ) ) . '/langs/' );

		// Pro
		if ( 'back-button-widget-pro.php' === basename( __FILE__ ) ) {
			require_once( 'includes/pro/class-alg-back-button-widget-pro.php' );
		}

		// Include required files
		$this->includes();

		// Admin
		if ( is_admin() ) {
			$this->admin();
		}

	}

	/**
	 * is_plugin_active.
	 *
	 * @version 1.2.0
	 * @since   1.2.0
	 */
	function is_plugin_active( $plugin ) {
		return ( function_exists( 'is_plugin_active' ) ? is_plugin_active( $plugin ) :
			(
				in_array( $plugin, apply_filters( 'active_plugins', ( array ) get_option( 'active_plugins', array() ) ) ) ||
				( is_multisite() && array_key_exists( $plugin, ( array ) get_site_option( 'active_sitewide_plugins', array() ) ) )
			)
		);
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function includes() {
		require_once( 'includes/alg-back-button-functions.php' );
		require_once( 'includes/class-alg-back-button-wp-widget.php' );
	}

	/**
	 * admin.
	 *
	 * @version 1.2.1
	 * @since   1.2.1
	 */
	function admin() {
		// Action links
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'action_links' ) );
		// Version update
		if ( get_option( 'alg_back_button_widget_version', '' ) !== $this->version ) {
			add_action( 'admin_init', array( $this, 'version_updated' ) );
		}
	}

	/**
	 * action_links.
	 *
	 * @version 1.2.1
	 * @since   1.2.1
	 * @param   mixed $links
	 * @return  array
	 */
	function action_links( $links ) {
		$custom_links = array();
		if ( 'back-button-widget.php' === basename( __FILE__ ) ) {
			$custom_links[] = '<a target="_blank" href="https://wpfactory.com/item/back-button-widget-wordpress-plugin/">' . __( 'Go Pro', 'back-button-widget' ) . '</a>';
		}
		return array_merge( $custom_links, $links );
	}

	/**
	 * version_updated.
	 *
	 * @version 1.2.1
	 * @since   1.2.1
	 */
	function version_updated() {
		update_option( 'alg_back_button_widget_version', $this->version );
	}

	/**
	 * Get the plugin url.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @return  string
	 */
	function plugin_url() {
		return untrailingslashit( plugin_dir_url( __FILE__ ) );
	}

	/**
	 * Get the plugin path.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @return  string
	 */
	function plugin_path() {
		return untrailingslashit( plugin_dir_path( __FILE__ ) );
	}

}

endif;

if ( ! function_exists( 'alg_back_button_widget' ) ) {
	/**
	 * Returns the main instance of Alg_Back_Button_Widget to prevent the need to use globals.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @return  Alg_Back_Button_Widget
	 */
	function alg_back_button_widget() {
		return Alg_Back_Button_Widget::instance();
	}
}

alg_back_button_widget();
