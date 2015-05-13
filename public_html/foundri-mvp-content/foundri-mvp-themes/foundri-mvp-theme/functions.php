<?php
/**
 * Foundri MVP functions and definitions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * @package Foundri MVP
 * @since 0.1.0
 */
 

 
 /**
  * Set up theme defaults and register supported WordPress features.
  *
  * @uses load_theme_textdomain() For translation/localization support.
  *
  * @since 0.1.0
  */
 function foundri_mvp_setup() {
	/**
	 * Makes Foundri MVP available for translation.
	 *
	 * Translations can be added to the /lang directory.
	 * If you're building a theme based on Foundri MVP, use a find and replace
	 * to change 'foundri_mvp' to the name of your theme in all template files.
	 */
	load_theme_textdomain( 'foundri_mvp', get_template_directory() . '/languages' );
 }
 add_action( 'after_setup_theme', 'foundri_mvp_setup' );
 
 /**
  * Enqueue scripts and styles for front-end.
  *
  * @since 0.1.0
  */
 function foundri_mvp_scripts_styles() {
	$postfix = ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) ? '' : '.min';

	wp_enqueue_script( 'foundri_mvp', get_template_directory_uri() . "/assets/js/foundri_mvp{$postfix}.js", array(), FOUNDRI_MVP_VERSION, true );
		
	wp_enqueue_style( 'foundri_mvp', get_template_directory_uri() . "/assets/css/foundri_mvp{$postfix}.css", array(), FOUNDRI_MVP_VERSION );
 }
 add_action( 'wp_enqueue_scripts', 'foundri_mvp_scripts_styles' );
 
 /**
  * Add humans.txt to the <head> element.
  */
 function foundri_mvp_header_meta() {
	$humans = '<link type="text/plain" rel="author" href="' . get_template_directory_uri() . '/humans.txt" />';
	
	echo apply_filters( 'foundri_mvp_humans', $humans );
 }
 add_action( 'wp_head', 'foundri_mvp_header_meta' );
