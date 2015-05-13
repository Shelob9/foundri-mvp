<?php
/**
 * Loads forms making them availble to render
 *
 * @package   foundri
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Foundri
 */

namespace foundri\lib\forms\load;


class form_load {
	/**
	 * Name of forms to load with this class
	 *
	 * Acts as a while list for $this->include_forms and $this->__call
	 *
	 * @var array
	 */
	public $forms = array(
		'ask_make',
		'login',
		'bio_profile',
		'ask_search',
		'community_search'
	);

	/**
	 * Constructor for class, used to make Caldera Forms aware of forms in file system.
	 */
	public function __construct() {
		// add internal forms
		add_filter( 'caldera_forms_get_form', array( $this, 'include_forms' ), 10, 2 );
	}

	/**
	 * Add a form to Caldera Forms as needed
	 *
	 * @param array $form From data
	 * @param string $name The name of the form.
	 *
	 * @return array
	 */
	public function include_forms( $form, $name ){
		if ( in_array( $form, $this->forms ) ) {
			$location = dirname( dirname( __FILE__ ) ) . '/the-forms/' . $name . '.php';
			if ( in_array( $name, $this->forms ) && file_exists( $location ) ) {
				$form = include $location;
			}
		}

		//use to export forms as php
		//echo "<pre>";var_export( $form );echo "</pre>";


		return $form;
	}


	/**
	 * Class instance
	 *
	 * @var \foundri_mvp_lib\forms\load\form_load|object
	 */
	protected static $instance;

	/**
	 * Return an instance of this class.
	 *
	 * @return \foundri_mvp_lib\forms\load\form_load|object
	 */
	public static function get_instance() {

		if ( ! self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

}
