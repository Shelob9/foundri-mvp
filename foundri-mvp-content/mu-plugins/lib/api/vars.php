<?php
/**
 * Common properties to share between all API classes
 *
 * @package   foundri
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Foundri
 */

namespace foundri\lib\api;


class vars {

	/**
	 * API root
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @var string
	 */
	protected $api_root = 'foundri';

	/**
	 * API version
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @var string
	 */
	protected $version = 'v1';

	/**
	 * Field to use for nonces
	 *
	 * @since 0.0.1
	 *
	 * @var string
	 */
	public $nonce_field = 'foundriApiNonce';

	/**
	 * Prefix for nonce actions
	 *
	 * @since 0.0.1
	 *
	 * @var string
	 */
	public $nonce_action_prefix = '_foundri_api_';

	/**
	 * The nonce action
	 *
	 * @since 0.0.1
	 *
	 * @var string
	 */
	public $nonce_action = '_foundri_api_';



}
