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
use foundri\lib\views\view_loader;

class foundri {
	public function __construct() {
		add_filter( 'template_include', array( $this, 'template' ) );
		add_action( 'init', array( $this, 'main_classes' ) );
		add_action( 'rest_api_init', array( $this, 'boot_rest_api' ) );
		add_action( 'template_redirect', array( $this, 'view_api' ) );

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
			$template = FOUNDDRI_VIEW_DIR . 'foundri-template.php';
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
		return view_loader::is_view_api();

	}


}