<?php
/**
 * Get data for a community.
 *
 * @package   foundri
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Foundri
 */

namespace foundri\lib\data;


use foundri\lib\forms\load\form_load;
use foundri\lib\forms\load\output;

class community extends get_item {

	/**
	 * The name of the Pod.
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @var string
	 */
	protected $pod_name = FOUNDRI_COMMUNITY;

	/**
	 * Array of fields to use to construct output.
	 *
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @var array
	 */
	protected $display_fields = array(
		'post_title' => array(),
		'post_name'=> array(),
		'members' => array(
			'ID',
			'display_name',
		),
		'asks' => array(
			'name',
			'created',
			'modified',
			'author' => array(
				'ID',
				'display_name'
			)
		),
		'logo' => array(),
		'location' => array(),
	);



	/**
	 * Set up the extra fields we need, IE the HTML of the forms.
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @return array
	 */
	protected function set_markup_fields() {
		$fields = array(
			'forms' => array(
				'ask_make' => output::ask_make(),
				'ask_search' => output::ask_search()
			),
		);

		return $fields;
	}


}
