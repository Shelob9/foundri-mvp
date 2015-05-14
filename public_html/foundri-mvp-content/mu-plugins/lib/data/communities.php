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


class communities extends community {

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

	protected function where_clause() {
		if( property_exists( $this, 'user_id' ) ) {
			return sprintf( 'members.ID = %d', $this->user_id );
		}else{
			return false;
		}
	}


}
