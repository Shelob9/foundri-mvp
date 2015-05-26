<?php
/**
 * Get all asks, for a given community.
 *
 * @package   foundri
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Foundri
 */

namespace foundri\lib\data;


class asks extends ask {

	/**
	 * Sprintf pattern for creating where clause
	 *
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @var string
	 */
	protected $where_pattern = 'community.ID = "%d"';

	/**
	 * Set to be a collection of items.
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @var bool
	 */
	protected $single = false;
}
