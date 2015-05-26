<?php
/**
 * Query for asks.
 *
 * @package   foundri
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Foundri
 */

namespace foundri\lib\data;


class ask_query extends asks {

	/**
	 * Define a custom where clause for this query
	 *
	 * @since 0.0.1
	 *
	 * @return string
	 */
	public function where_clause() {
		$parts = sprintf( $this->where_pattern, $this->id );

		if ( property_exists( $this, 'ask_type' ) && $this->ask_type ) {
			$parts .= sprintf( ' AND t.ask_type = "%s"', $this->ask_type );

		}

		return $parts;

	}

}
