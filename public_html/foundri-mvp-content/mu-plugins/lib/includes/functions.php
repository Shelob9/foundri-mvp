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
	return \foundri\lib\templates\loader::get_view();

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
	$urls = foundri_api_urls_instance();
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
		'home' => 'home',
		'foundri-comment-single' => 'comment-single'
	) as $id => $template ) {
		$template = FOUNDRI_TEMPLATE_DIR . $template . '.html';
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
 * IMPORTANT: Link is not escaped here, as it could be used later, be sure to late escape.
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
	}elseif( $id_or_slug = 'home' ) {
		$link = home_url();
	}elseif( is_string( $id_or_slug ) ){
		$link = home_url( $id_or_slug );
	}else{
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
 * @param null|string $title Optional. The title attribute for link
 * @param bool $button Optional. Whether link is a button or not. Default is false.
 *
 * @return string
 */
function foundri_link_markup( $id_or_slug, $text, $title = null, $button = false ) {
	if ( ! $title  ) {
		$title = sprintf( __( 'Link to ', 'foundri' ) );
	}
	$link = foundri_link( $id_or_slug );

	$class = 'foundri-link';
	if ( $button ) {
		$class .= ' btn btn-default';
	}

	$type = 'a';


	return sprintf( '<a href="%2s" class="%3s" data-foundri-internal="true" title="%4s">%5s</a>', $link, $class, $title, $text );
}


/**
 * Get markup for a join community button
 *
 * @since 0.0.1
 *
 * @param int $id Community ID
 *
 * @return string
 */
function foundri_join_community_link_markup( $id ) {

	return sprintf( '<a href="#" class="join btn btn-success" data-community="%d" id="join-community">%s</a>', $id, __( 'Join', 'foundri' ) );
}

/**
 * Check if current user is a member of a community.
 *
 * @since 0.0.1
 *
 * @param int $id Community ID
 *
 * @return bool
 */
function foundri_is_member( $id ) {
	$community = new \foundri\lib\data\community( $id );
	$members = $community->pods->field( 'members.ID' );
	if ( in_array( get_current_user_id(), $members ) ) {
		return true;
	}
}

/**
 * Get an instance of the API URLs class.
 *
 * Use as a shortcut to get to URLs, and the public vars of that class.
 *
 * @return \foundri\lib\api\urls
 */
function foundri_api_urls_instance() {
	global $foundri_api_urls_instance;
	if ( ! is_object( $foundri_api_urls_instance ) ){
		$foundri_api_urls_instance = new \foundri\lib\api\urls();
	}

	return $foundri_api_urls_instance;
}

/**
 * Create a nonce for the API
 *
 * @since 0.0.1
 *
 * @return string
 */
function foundri_api_nonce() {
	$class = foundri_api_urls_instance();

	$nonce = wp_create_nonce( $class->nonce_action );

	return $nonce;
}

function foundri_nonce_field() {
	$class = foundri_api_urls_instance();

	return $class->nonce_field;
}
