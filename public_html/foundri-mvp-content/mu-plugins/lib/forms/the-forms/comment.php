<?php
$form = array (
	'_last_updated' => 'Mon, 25 May 2015 00:17:51 +0000',
	'ID' => 'comment',
	'name' => 'comment',
	'description' => '',
	'db_support' => 1,
	'pinned' => 0,
	'hide_form' => 0,
	'check_honey' => null,
	'success' => 'Comment has been successfully submitted. Thank you.',
	'form_ajax' => 1,
	'has_ajax_callback' => 1,
	'custom_callback' => 'foundri_after_comment',
	'form_visibility' => 'all',
	'layout_grid' =>
		array (
			'fields' =>
				array (
					'comment_content' => '1:1',
					'community' => '2:2',
					'ask_comment_id' => '2:2',
					'send' => '2:1',
				),
			'structure' => '12|6:6',
		),
	'fields' =>
		array (
			'comment_content' =>
				array (
					'ID' => 'comment_content',
					'type' => 'paragraph',
					'label' => 'Comment Content',
					'slug' => 'comment_content',
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
			'send' =>
				array (
					'ID' => 'send',
					'type' => 'button',
					'label' => 'Send',
					'slug' => 'send',
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
			'community' =>
				array (
					'ID' => 'community',
					'type' => 'hidden',
					'label' => 'Community',
					'slug' => 'community',
					'caption' => '',
					'config' =>
						array (
							'custom_class' => '',
							'visibility' => 'all',
							'default' => '{embed_post:ID}',
						),
					'conditions' =>
						array (
							'type' => '',
						),
				),
			'ask_comment_id' =>
				array (
					'ID' => 'ask_comment_id',
					'type' => 'hidden',
					'label' => 'Ask',
					'slug' => 'ask_comment_id',
					'caption' => '',
					'config' =>
						array (
							'custom_class' => 'ask-comment',
							'visibility' => 'all',
							'default' => 0,
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
	'settings' =>
		array (
			'responsive' =>
				array (
					'break_point' => 'sm',
				),
		),
	'mailer' =>
		array (
			'enable_mailer' =>0,
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
