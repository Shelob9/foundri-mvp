<?php
/**
 * The form for making new asks
 *
 * @package   foundri
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Foundri
 */
$form = array (
	'_last_updated' => 'Wed, 13 May 2015 01:38:42 +0000',
	'ID' => 'ask_make',
	'name' => 'ask_make',
	'description' => '',
	'db_support' => 1,
	'pinned' => 0,
	'check_honey' => null,
	'success' => 'Form has been successfully submitted. Thank you.',
	'avatar_field' => '',
	'form_ajax' => 1,
	'custom_callback' => '',
	'form_ajax_post_submission_disable' => 1,
	'form_visibility' => 'all',
	'layout_grid' =>
		array (
			'fields' =>
				array (
					'ask_type' => '1:1',
					'name' => '1:2',
					'ask_details'  => '2:1',
					'community_id' => '3:1',
					'user_id' => '3:1',
					'save' => '3:2',
				),
			'structure' => '4:8|12|6:6',
		),
	'fields' =>
		array (
			'ask_type' => array (
				'ID' => 'ask_type',
				'type' => 'dropdown',
				'label' => 'Ask Type',
				'slug' => 'ask_type',
				'required' => 1,
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
								'ask_type_opt_talk' =>
									array (
										'value' => 'talk',
										'label' => 'To Talk about',
									),
								'ask_type_opt_find_job' =>
									array (
										'value' => 'find_job',
										'label' => 'To Be Hired',
									),
								'ask_type_opt_offer_job' =>
									array (
										'value' => 'offer_job',
										'label' => 'To Hire Someone',
									),
							),
					),
				'conditions' =>
					array (
						'type' => '',
					),
			),
			'name' => array (
				'ID' => 'name',
				'type' => 'text',
				'label' => 'I Want To',
				'slug' => 'name',
				'required' => 1,
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
			'ask_details' => array (
				'ID' => 'ask_details',
				'type' => 'paragraph',
				'label' => 'Ask Details',
				'slug' => 'ask_details',
				'caption' => '',
				'config' =>
					array (
						'custom_class' => '',
						'visibility' => 'all',
						'placeholder' => '',
						'rows' => 4,
						'default' => '',
					),
				'conditions' =>
					array (
						'type' => '',
					),

			),
			'save' => array (
				'ID' => 'save',
				'type' => 'button',
				'label' => 'Save',
				'slug' => 'save',
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
			'community_id' =>
				array (
					'ID' => 'community_id',
					'type' => 'hidden',
					'label' => 'community_id',
					'slug' => 'community_id',
					'caption' => '',
					'config' =>
						array (
							'custom_class' => '',
							'visibility' => 'all',
							'default' => '{post:ID}',
						),
					'conditions' =>
						array (
							'type' => '',
						),
				),
			'user_id' =>
			array (
				'ID' => 'user_id',
				'type' => 'hidden',
				'label' => 'user_id',
				'slug' => 'user_id',
				'caption' => '',
				'config' =>
					array (
						'custom_class' => '',
						'visibility' => 'all',
						'default' => '{user:id}',
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
					0 => 'ask_title',
					1 => 'community_id',
					2 => 'user',
				),
			'values' =>
				array (
					0 => '{user:user_login}  %ask_type% %name%',
					1 => '{embed_post:ID}',
					2 => get_current_user_id(),
				),
			'types' =>
				array (
					0 => 'static',
					1 => 'static',
					3 => 'static',
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
			'email_message' => '{summary}',
		),
);

return $form;
