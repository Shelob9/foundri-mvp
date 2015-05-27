<?php
/**
 * Boots Foundri
 *
 * @package   foundri
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Foundri
 */
namespace foundri\lib;


use foundri\lib\api\endpoints;
use foundri\lib\api\view_api;
use foundri\lib\forms\load\form_load;
use foundri\lib\forms\process\process_forms;
use foundri\lib\templates\loader;

class foundri {
	public function __construct() {
		add_filter( 'template_include', array( $this, 'template' ) );
		add_action( 'init', array( $this, 'main_classes' ) );
		add_action( 'rest_api_init', array( $this, 'boot_rest_api' ) );
		add_action( 'template_redirect', array( $this, 'view_api' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'assets' ), 666 );
		add_action( 'wp_logout', array( $this, 'logout' ) );
		add_action( 'wp_ajax_foundri_logout', array( $this, 'logout_button' ) );
		//add_action( 'init', array( $this, 'login_form_redirect' ) );
		add_filter('show_admin_bar', '__return_false');
	}

	/**
	 * Use Foundri Template for all requests
	 *
	 * @uses "template_include"
	 *
	 * @since 0.0.1
	 *
	 * @return string Template path
	 */
	public function template( $template ) {
		if ( ! $this->is_view_api() ) {
			$template = FOUNDRI_TEMPLATE_DIR . 'foundri-template.php';
		}

		return $template;
	}

	/**
	 * Load the main classes that need to run always
	 *
	 * @uses "init" action
	 *
	 * @since 0.0.1
	 */
	public function main_classes() {
		new form_load();
		new process_forms();
	}

	/**
	 * Boot up our RESTful API
	 *
	 * @uses "rest_api_init"
	 *
	 * @since 0.0.1
	 */
	public function boot_rest_api() {
		$api = new endpoints();
		$api->register_routes();
	}


	/**
	 * Add endpoints for the view API
	 *
	 * @uses "init" action
	 */
	public function view_api() {
		if ( $this->is_view_api() ) {
			view_api::do_api();
		}


	}

	protected function is_view_api() {
		return loader::is_view_api();

	}

	/**
	 * Load JS/CSS
	 *
	 * @uses "wp_enqueue_scripts" action
	 *
	 * @since 0.0.1
	 */
	public function assets() {
		$version = FOUNDRI_MVP_VERSION;
		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			$version = rand();
		}

		$vendor_dir = trailingslashit( content_url() ) . 'mu-plugins/lib/vendor/';
		//wp_enqueue_script( 'caldera-modals', $vendor_dir . '/calderawp/caldera-modals/caldera-modals.js', array( 'jquery' ), $version );
		//wp_enqueue_style( 'caldera-modals', $vendor_dir . '/calderawp/caldera-modals/modals.css' );
		wp_enqueue_style( 'foundri', trailingslashit( content_url() ) .'mu-plugins/lib/css/foundri.css' );
	}

	/**
	 * Redirect to home on logout
	 *
	 * @uses "wp_logout" action
	 *
	 * @since 0.0.1
	 */
	public function logout() {
		pods_redirect( foundri_link( 'home' ) );
	}

	/**
	 * Do a logout on logout button click
	 *
	 * @since 0.0.1
	 *
	 * @uses "wp_ajax_foundri_logout" action
	 */
	public function logout_button() {
		wp_logout();
		status_header( 200 );
		pods_redirect( foundri_link( 'home' ) );
		die();
	}

	/**
	 * Redirect login page to home
	 *
	 * @since 0.0.1
	 */
	public function login_form_redirect() {
		global $pagenow;
		if( 'wp-login.php' == $pagenow ) {
			wp_redirect( foundri_link( 'home' ) );
			exit();
		}
	}



}
