<?php
/**
 * @TODO What this does.
 *
 * @package   @TODO
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link      
 * @copyright 2015 Josh Pollock
 */

namespace foundri\lib\data\save;


class comment implements save_interface {
	/**
	 * Do the actual save
	 *
	 * @todo make work for update
	 *
	 * @since 0.0.1
	 *
	 * @param array $data Data from request.
	 *
	 * @return int|bool Item ID.
	 */
	public static function make_save( $data ) {
		$pods = pods( 'comment', null );
		$data = new prepare_data( $data, self::save_fields() );
		$data = $data->data;

		if ( is_array( $data ) ) {

			if ( ! isset( $data[ 'ask_comment_id' ] ) || ! $data[ 'ask_comment_id' ] ) {
				$data[ 'ask_comment_id' ] = 1;
			}

			$data[ 'comment_post_ID'] = $data[ 'community' ];
			unset( $data[ 'community' ] );
			$data[ 'comment_author' ] = get_current_user_id();
			$data[ 'comment_author_IP' ] = $_SERVER[ 'REMOTE_ADDR' ];
			$data[ 'comment_date' ] = current_time( 'mysql' );
			$data[ 'comment_date_gmt' ] = current_time( 'mysql', 1 );

			$id             = $pods->save( $data );

			return $id;
		}else{
			return false;
		}

	}

	/**
	 * Fields to include in the saving
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @return array
	 */
	public static function save_fields() {
		return array(
			'comment_content',
			'community',
			'ask_comment_id'
		);
	}

}
