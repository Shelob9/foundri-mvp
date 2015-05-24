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
	return \foundri\lib\views\view_loader::get_view();

}

/**
 * Get URL for Foundri API endpoint
 *
 * @since 0.0.1
 *
 * @param string $endpoint Name of endpoint
 * @param null| array $args Optionally an array of query args to add.
 *
 * @return string
 */
function foundri_api_url( $endpoint, $args = null  ) {
	$urls = new \foundri\lib\api\urls();
	$url = $urls->root_url( $endpoint, $args );
	return $url;
}

/**
 * Output templates as handlebars.js templates
 */
function foundri_print_handelbars_js_templates() {
	foreach( array(
		'foundri-ask-single' => 'ask-single',
		'foundri-ask-preview' => 'ask-preview',
		'foundri-community-single' => 'community-single',
		'home' => 'home'
	) as $id => $template ) {
		$template = FOUNDDRI_VIEW_DIR . $template . '.html';
		$template = file_get_contents( $template );
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

/**
 * Get link to a Foundri item.
 *
 * @since 0.0.1
 *
 * @param int|string $id_or_slug ID, or for ask permalink slug for the link, or use "home" to link to home.
 *
 * @return bool|string|void
 */
function foundri_link( $id_or_slug ) {
	if ( 0 < (int) $id_or_slug ) {
		$link = get_permalink( $id_or_slug );
	}elseif( is_string( $id_or_slug ) ){
		$link = home_url( $id_or_slug );
	}elseif( $id_or_slug = 'home' ) {
		$link = home_url();
	}

	return $link;
}

/**
 * Get link markup for link to a Foundri item.
 *
 * IMPORTANT: Failure to use this function for creating an internal link is a violation of intergalactic law.
 *
 * @since 0.0.1
 *
 * @param int|string $id_or_slug ID, or for ask permalink slug for the link, or use "home" to link to home.
 * @param string $text Link text
 * @param null|string $title Optional, the ttile attribute for link
 *
 * @return string
 */
function foundri_link_markup( $id_or_slug, $text, $title = null ) {
	if ( ! $title  ) {
		$title = sprintf( __( 'Link to ', 'foundri' ) );
	}
	$link = foundri_link( $id_or_slug );

	return sprintf( '<a href="%1s" class="foundri-link" data-foundri-internal="true" title="%2s">%3s</a>', $link, $title, $text );
}

