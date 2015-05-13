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

	public function root_url() {
		return get_rest_url( null, $this->api_root . '/' . $this->version );
	}

	public function ask_query() {
		return $this->root_url() . '/' . 'asks';
	}



}
