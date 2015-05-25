<?php
/**
 * Comment queries
 *
 * @package   foundri
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Foundri
 */

namespace foundri\lib\data;

class comments {

	/**
	 * ID of community to fetch comments for.
	 *
	 * @since 0.0.1
	 *
	 * @var int
	 */
	public $community;

	/**
	 * ID of ask to limit comments to.
	 *
	 * May be null if not limiting by ask.
	 *
	 * @var int|null
	 */
	public $ask;

	/**
	 * Display data, parsed comments for this query
	 *
	 * @since 0.0.1
	 *
	 * @var array
	 */
	public $display_data;

	/**
	 * @var object|\WP_Comment_Query
	 */
	protected $query;

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
		'comment_ID' => array(),
		'comment_author' => array(),
		'comment_post_ID' => array(),
		'comment_content' => array(),
		'user_id' => array(),
		'ask_comment_id' => array()

	);

	/**
	 * Class constructor
	 *
	 * @param int $community Community ID to get comments for
	 * @param null|int $ask Optional. Ask to limit comments to
	 */
	public function __construct( $community, $ask = null ) {
		if ( 0 < absint( $community ) ) {
			$this->set_community( $community );
			$this->set_ask( $ask );
			$this->do_query();
			$data = $this->prepare();
			$this->set_display_data( $data );

		}else{
			$this->set_display_data( array() );
			$this->set_community( 0 );
			$this->set_ask( null );
		}

	}

	/**
	 * Do the actual query
	 *
	 * Sets $this->query
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 */
	protected function do_query() {
		$args[ 'post_id' ] = $this->community;

		switch( $this->ask ) {
			case false === $this->ask || 1 === $this->ask :
				$args[ 'meta_value' ] = "1";
				$args[ 'meta_key' ] = 'ask_comment_id';
				break;
			case is_int( $this->ask ) && 1 < $this->ask :
				$args[ 'meta_value' ] = $this->ask;
				$args[ 'meta_key' ] = 'ask_comment_id';
				break;

		}

		$this->query = new \WP_Comment_Query( $args );
	}

	/**
	 * Parse data
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @return array Parsed comments
	 */
	protected function prepare() {
		$data = array();
		if ( ! empty( $this->query->comments ) ) {
			foreach( $this->query->comments as $comment ) {
				$comment = (array) $comment;
				foreach( array_keys( $this->display_fields ) as $field ) {
					if ( 'ask_comment_id' == $field && isset( $comment[ 'meta_key' ] ) && 'ask_comment_id' == $comment[ 'meta_key' ] ) {
						$_data[ 'ask_comment_id' ] = $comment[ 'meta_value' ];
						continue;
					}

					if ( 'comment_author' == $field ) {
						$user = get_user_by( 'id', $comment[ 'user_id' ] );
						$_data[ 'author_avatar' ] = get_avatar( $user->user_email );
						$_data[ 'author_name' ] = sprintf( '%s %s', $user->user_firstname, $user->user_lastname );
						continue;
					}

					if ( isset( $comment[ $field ] ) ) {
						$value = $comment[ $field ];
						if ( $value ) {
							$_data[ $field ] = $value;
						} else {
							$_data[ $field ] = null;
						}
					} else {
						$_data[ $field ] = null;
					}

				}

				$data[] = $_data;
			}
		}

		return $data;
	}

	/**
	 * Set community ID property
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @param int $community Community ID
	 */
	private function set_community( $community ) {
		$this->community = $community;
	}

	/**
	 * Set ask ID property
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @param int $ask
	 */
	private function set_ask( $ask ) {
		$this->ask = $ask;
	}

	/**
	 * Set display data property
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @param array $data The display data
	 */
	private function set_display_data( $data ) {
		$this->display_data = $data;
	}





}
