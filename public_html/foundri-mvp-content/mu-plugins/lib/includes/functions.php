<?php
/**
 * Functions
 *
 * @package   foundri
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Foundri
 */

/**
 * Output the Foundri UI
 *
 * @return null|string
 */
function foundri_view() {
	$id = get_queried_object_id();
	$template = false;
	if ( FOUNDRI_COMMUNITY == get_post_type( $id ) ) {


		if ( ! is_null( $ask = pods_v_sanitized( 'ask' ) ) && 0 < absint( $ask ) ) {
			$template = 'ask-single.html';
			$item = new \foundri\lib\data\ask( $ask, true );
		}else{
			$template = 'community-single.html';
			$item = new \foundri\lib\data\community( $id, true );

		}

		$data = $item->display_data;


		$template = FOUNDDRI_VIEW_DIR . $template;

		$output =  caldera_metaplate_from_file( $template, null, $data );

		return $output;

	}

}
