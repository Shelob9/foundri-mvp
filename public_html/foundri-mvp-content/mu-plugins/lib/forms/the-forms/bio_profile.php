<?php
/**
 * Bio/ profile form
 *
 * @package   foundri
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Foundri
 */
$form = array (
	'_last_updated' => 'Wed, 20 May 2015 01:16:50 +0000',
	'ID' => 'bio_profile',
	'name' => 'bio_profile',
	'description' => '',
	'db_support' => 1,
	'pinned' => 0,
	'hide_form' => 1,
	'check_honey' => 1,
	'success' => 'Form has been successfully submitted. Thank you.',
	'form_ajax' => 1,
	'custom_callback' => '',
	'form_visibility' => 'all',
	'layout_grid' =>
		array (
			'fields' =>
				array (
					'first_name' => '1:1',
					'last_name' => '1:2',
					'bio' => '2:1',
					'email' => '2:2',
					'twitter' => '2:2',
					'facebook' => '2:2',
					'save' => '3:2',
				),
			'structure' => '6:6|6:6|6:6',
		),
	'fields' =>
		array (
			'first_name' =>
				array (
					'ID' => 'first_name',
					'type' => 'text',
					'label' => 'First Name',
					'slug' => 'first_name',
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
			'last_name' =>
				array (
					'ID' => 'last_name',
					'type' => 'text',
					'label' => 'Last Name',
					'slug' => 'last_name',
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
			'bio' =>
				array (
					'ID' => 'bio',
					'type' => 'paragraph',
					'label' => 'Bio',
					'slug' => 'bio',
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
			'save' =>
				array (
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
			'email' =>
				array (
					'ID' => 'email',
					'type' => 'email',
					'label' => 'Email',
					'slug' => 'email',
					'caption' => '',
					'config' =>
						array (
							'custom_class' => '',
							'visibility' => 'all',
							'placeholder' => '',
							'default' => '',
						),
					'conditions' =>
						array (
							'type' => '',
						),
				),
			'twitter' =>
				array (
					'ID' => 'twitter',
					'type' => 'text',
					'label' => 'Twitter',
					'slug' => 'twitter',
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
			'facebook' =>
				array (
					'ID' => 'facebook',
					'type' => 'text',
					'label' => 'Facebook',
					'slug' => 'facebook',
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
			'enable_mailer' => 1,
			'sender_name' => 'Caldera Forms Notification',
			'sender_email' => 'josh@joshpress.net',
			'reply_to' => '',
			'email_type' => 'html',
			'recipients' => '',
			'bcc_to' => '',
			'email_subject' => '_user_profile',
			'email_message' => '{summary}',
		),
);

return $form;
