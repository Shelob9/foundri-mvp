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
$form = array (
	'_last_updated' => 'Wed, 13 May 2015 06:40:14 +0000',
	'ID' => 'ask_search',
	'name' => 'ask_search',
	'description' => '',
	'db_support' => 1,
	'pinned' => 0,
	'success' => ' ',
	'avatar_field' => '',
	'form_ajax' => 1,
	'has_ajax_callback' => 1,
	'custom_callback' => 'foundri_ask_search',
	'form_visibility' => 'all',
	'layout_grid' =>
		array (
			'fields' =>
				array (
					'ask_type' => '1:1',
					'text_search' => '1:2',
					'search' => '2:1',
				),
			'structure' => '3:9|12',
		),
	'fields' =>
		array (
			'ask_type' =>
				array (
					'ID' => 'ask_type',
					'type' => 'dropdown',
					'label' => 'Type',
					'slug' => 'ask_type',
					'caption' => '',
					'config' =>
						array (
							'custom_class' => '',
							'visibility' => 'all',
							'placeholder' => '',
							'auto_type' => '',
							'taxonomy' => 'category',
							'post_type' => 'post',
							'value_field' => 'name',
							'default' => '',
							'show_values' => 1,
							'option' =>
								array (
									'one' =>
										array (
											'value' => 1,
											'label' => 'one',
										),
								),
						),
					'conditions' =>
						array (
							'type' => '',
						),
				),
			'text_search' =>
				array (
					'ID' => 'text_search',
					'type' => 'text',
					'label' => 'Text Search',
					'slug' => 'text_search',
					'caption' => '',
					'config' =>
						array (
							'custom_class' => '',
							'visibility' => 'all',
							'placeholder' => '',
							'default' => '',
							'mask' => '',
						),
					'conditions' =>
						array (
							'type' => '',
						),
				),
			'search' =>
				array (
					'ID' => 'search',
					'type' => 'button',
					'label' => 'Search',
					'slug' => 'search',
					'caption' => '',
					'config' =>
						array (
							'custom_class' => '',
							'visibility' => 'all',
							'type' => 'submit',
							'class' => 'btn btn-default',
						),
					'conditions' =>
						array (
							'type' => '',
						),
				),
		),
	'page_names' =>
		array (
			0 => 'Page 1',
		),
	'variables' =>
		array (
			'keys' =>
				array (
					0 => 'type_search',
					1 => 'text_search',
				),
			'values' =>
				array (
					0 => '%ask_type%',
					1 => '%text_search%',
				),
			'types' =>
				array (
					0 => 'passback',
					1 => 'passback',
				),
		),
	'settings' =>
		array (
			'responsive' =>
				array (
					'break_point' => 'sm',
				),
		),
	'mailer' =>
		array (
			'enable_mailer' => 0,
			'sender_name' => '',
			'sender_email' => '',
			'reply_to' => '',
			'email_type' => 'html',
			'recipients' => '',
			'bcc_to' => '',
			'email_subject' => '',
			'email_message' => '',
		),
);

return $form;
