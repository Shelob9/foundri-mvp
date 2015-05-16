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
namespace foundri;


use foundri\lib\api\endpoints;
use foundri\lib\forms\load\form_load;
use foundri\lib\forms\process\process_forms;

class foundri {
	public function __construct() {
		add_filter( 'template_include', array( $this, 'template' ) );
		add_action( 'init', array( $this, 'main_classes' ) );
		add_action( 'rest_api_init', array( $this, 'boot_api' ) );

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
	public function template() {
		$template = dirname( __FILE__ ) . '/lib/views/the-views/foundri-template.php';
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
	 * Boot up our API
	 *
	 * @uses "rest_api_init"
	 *
	 * @since 0.0.1
	 */
	public function boot_api() {
		$api = new endpoints();
		$api->register_routes();
	}

}
