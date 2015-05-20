<?php
/**
 * Get as for an ask.
 *
 * @package   foundri
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Foundri
 */

namespace foundri\lib\data;


class ask extends get_item {

	/**
	 * The name of the Pod.
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @var string
	 */
	protected $pod_name = FOUNDRI_ASK;

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
		'name' => array(),
		'ask_type' => array(),
		'ask_details' => array(),
		'community' => array(
			'ID',
			'post_title',
		),
		'author' => array(
			'first_name',
			'last_name',
			'bio',
			'email',
			'twitter',
			'facebook',
		)

	);
}
