<?php
/**
 * Get URLs for Foundri API
 *
 * @package   foundri
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Foundri
 */

namespace foundri\lib\api;


class urls extends vars {

	/**
	 * Get URL for Foundri API
	 *
	 * @todo validation?
	 *
	 * @since 0.0.1
	 *
	 * @param string $endpoint Name of endpoint
	 * @param null| array $args Optionally an array of query args to add.
	 *
	 * @return string
	 */
	public function root_url( $endpoint, $args = null ) {
		$url = get_rest_url( null, $this->api_root . '/' . $this->version . '/' . $endpoint );
		if ( is_array( $args ) ) {
			$url = add_query_arg( $args, $url );
		}

		return $url;

	}

}
