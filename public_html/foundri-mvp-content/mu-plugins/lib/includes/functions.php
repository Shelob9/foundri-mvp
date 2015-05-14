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
			$item = new \foundri\lib\data\asks( $id, true );
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


function foundri_api_url( $endpoint = false ) {
	$class = new foundri\lib\api\urls();
	if ( ! $endpoint ) {
		return $class->root_url();
	}elseif( 'asks' == $endpoint ) {
		return $class->ask_query();
	}
}

/**
 * Output templates as handlebars.js templates
 */
function foundri_print_handelbars_js_templates() {
	foreach( array(
		'foundri-ask-single' => 'ask-single',
		'foundri-ask-preview' => 'ask-preview',
		'foundri-community-single' => 'community-single'
	) as $id => $template ) {
		$template = FOUNDDRI_VIEW_DIR . $template;
		printf( '<script id="%1s" type="text/x-handlebars-template">%2s</script>', $id, $template );
	}
}

/**
 * The ask types
 *
 * @since 0.0.1
 *
 * @return array
 */
function foundri_ask_types() {
	return array(
		'talk' => __( 'Talk About', 'foundri' ),
		'find_job' => __( 'Find A Job', 'foundri' ),
		'offer_job' => __( 'Hire Someone', 'foundri' )
	);
}
