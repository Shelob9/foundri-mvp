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

function foundri_view() {
	$id = get_queried_object_id();
	$view = false;
	if ( FOUNDRI_COMMUNITY == get_post_type( $id ) ) {
		$view = 'community-single.html';
	}

	if ( $view ) {
		$view = FOUNDDRI_VIEW_DIR . $view;

		$community = new \foundri\lib\data\community( $id, true );

		return caldera_metaplate_from_file( $view, null,  $community->display_data );
	}

}
