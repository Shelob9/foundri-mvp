<?php
/**
 * Login or register form
 *
 * @package   foundri
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Foundri
 */
$form = array (
		'_last_updated' => 'Sat, 16 May 2015 02:41:24 +0000',
		'ID' => 'login_or_register',
		'name' => 'login_or_register',
		'description' => '',
		'db_support' => 1,
		'pinned' => 0,
		'hide_form' => 1,
		'check_honey' => null,
		'success' => '',
		'avatar_field' => '',
		'form_ajax' => 1,
		'custom_callback' => 'foundri_post_register',
		'form_visibility' => 'all',
		'layout_grid' =>
			array (
				'fields' =>
					array (
						'login_or_register' => '1:1',
						'email' => '2:1',
						'first_name' => '3:1',
						'last_name' => '3:2',
						'password_register' => '4:1',
						'password_login' => '4:1',
						'login' => '6:2',
						'register' => '6:2',
						'remember' => '5:1',
						'invite_code' => '5:1'
					),
				'structure' => '12|12|6:6|12|12|8:4',
			),
		'fields' =>
			array (
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
				'login_or_register' =>
					array (
						'ID' => 'login_or_register',
						'type' => 'toggle_switch',
						'label' => 'Login Or Register',
						'slug' => 'login_or_register',
						'required' => 1,
						'caption' => '',
						'config' =>
							array (
								'custom_class' => '',
								'visibility' => 'all',
								'orientation' => 'horizontal',
								'selected_class' => 'btn-success',
								'default_class' => 'btn-default',
								'auto_type' => '',
								'taxonomy' => 'category',
								'post_type' => 'post',
								'value_field' => 'name',
								'show_values' => 1,
								'default' => 'login',
								'option' =>
									array (
										'login' =>
											array (
												'value' => 'login',
												'label' => 'Login',
											),
										'register' =>
											array (
												'value' => 'register',
												'label' => 'Register',
											),
									),
							),
						'conditions' =>
							array (
								'type' => '',
							),
					),
				'login' =>
					array (
						'ID' => 'login',
						'type' => 'button',
						'label' => 'Login',
						'slug' => 'login',
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
								'type' => 'show',
								'group' =>
									array (
										'login_button_conditional' =>
											array (
												'1' =>
													array (
														'field' => 'login_or_register',
														'compare' => 'is',
														'value' => 'login',
													),
											),
									),
							),
					),
				'register' =>
					array (
						'ID' => 'register',
						'type' => 'button',
						'label' => 'Register',
						'slug' => 'register',
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
								'type' => 'show',
								'group' =>
									array (
										'register_button_conditional' =>
											array (
												'2' =>
													array (
														'field' => 'login_or_register',
														'compare' => 'is',
														'value' => 'register',
													),
											),
									),
							),
					),
				'password_register' =>
					array (
						'ID' => 'password_register',
						'type' => 'password',
						'label' => 'Password',
						'slug' => 'password_register',
						'caption' => '',
						'config' =>
							array (
								'custom_class' => '',
								'visibility' => 'all',
								'confirm_pass' => 1,
							),
						'conditions' =>
							array (
								'type' => 'show',
								'group' =>
									array (
										'password_register_conditional' =>
											array (
												'1' =>
													array (
														'field' => 'login_or_register',
														'compare' => 'is',
														'value' => 'register',
													),
											),
									),
							),
					),
				'password_login' =>
					array (
						'ID' => 'password_login',
						'type' => 'password',
						'label' => 'Password',
						'slug' => 'password_login',
						'caption' => '',
						'config' =>
							array (
								'custom_class' => '',
								'visibility' => 'all',
							),
						'conditions' =>
							array (
								'type' => 'show',
								'group' =>
									array (
										'login_button_conditional' =>
											array (
												'1' =>
													array (
														'field' => 'login_or_register',
														'compare' => 'is',
														'value' => 'login',
													),
											),
									),
							),
					),
				'remember' =>
					array (
						'ID' => 'remember',
						'type' => 'checkbox',
						'label' => 'Remember Me?',
						'slug' => 'remember',
						'caption' => '',
						'config' =>
							array (
								'custom_class' => '',
								'visibility' => 'all',
								'inline' => 1,
								'auto_type' => '',
								'taxonomy' => 'category',
								'post_type' => 'post',
								'value_field' => 'name',
								'default' => '',
								'option' =>
									array (
										'yes' =>
											array (
												'value' => 'yes',
												'label' => 'Yes',
											),
									),
							),
						'conditions' =>
							array (
								'type' => 'show',
								'group' =>
									array (
										'remember_conditional' =>
											array (
												'1' =>
													array (
														'field' => 'login_or_register',
														'compare' => 'is',
														'value' => 'login',
													),
											),
									),
							),
					),
				'first_name' =>
					array (
						'ID' => 'first_name',
						'type' => 'text',
						'label' => 'First Name',
						'slug' => 'first_name',
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
								'type' => 'show',
								'group' =>
									array (
										'first_name_conditional' =>
											array (
												'1' =>
													array (
														'field' => 'login_or_register',
														'compare' => 'is',
														'value' => 'register',
													),
											),
									),
							),
					),
				'last_name' =>
					array (
						'ID' => 'last_name',
						'type' => 'text',
						'label' => 'Last Name',
						'slug' => 'last_name',
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
								'type' => 'show',
								'group' =>
									array (
										'last_name_conditional' =>
											array (
												'1' =>
													array (
														'field' => 'login_or_register',
														'compare' => 'is',
														'value' => 'register',
													),
											),
									),
							),
					),
				'invite_code' =>
					array (
						'ID' => 'invite_code',
						'type' => 'text',
						'label' => 'Invite Code',
						'slug' => 'invite_code',
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
								'type' => 'show',
								'group' =>
									array (
										'first_name_conditional' =>
											array (
												'1' =>
													array (
														'field' => 'login_or_register',
														'compare' => 'is',
														'value' => 'register',
													),
											),
									),
							),
					),
			),
		'page_names' =>
			array (
				0 => 'Page 1',
			),
		'processors' =>
			array (
				'foundri_invite' =>
					array (
						'ID' => 'foundri_invite',
						'type' => 'foundri_invite',
						'config' =>
							array (

							),
						'conditions' =>
							array (
								'type' => 'show',
								'group' =>
									array (
										'invite_conditional' =>
											array (
												'1' =>
													array (
														'field' => 'login_or_register',
														'compare' => 'is',
														'value' => 'register',
													),
											),
									),
							),
					),
				'user_login' =>
					array (
						'ID' => 'user_login',
						'type' => 'user_login',
						'config' =>
							array (
								'user' => 'email',
								'_required_bounds' =>
									array (
										0 => 'user',
									),
								'pass' => 'password_login',
								'remember' => 'remember',
								'redirect' => foundri_link( 'home' ),
								'fail_message' => __( 'Your username or password was not valid.', 'foundri' ),
							),
						'conditions' =>
							array (
								'type' => 'show',
								'group' =>
									array (
										'login_conditional' =>
											array (
												'1' =>
													array (
														'field' => 'login_or_register',
														'compare' => 'is',
														'value' => 'login',
													),
											),
									),
							),
					),
				'user_register' =>
					array (
						'ID' => 'user_register',
						'type' => 'user_register',
						'config' =>
							array (
								'user_login' => 'email',
								'_required_bounds' =>
									array (
										0 => NULL,
										1 => 'user_login',
									),
								'user_pass' => 'password_register',
								'user_email' => 'email',
								'do_login' => 1,
								'show_admin_bar_front' => false,
								'email_details' => 1,
								'role' => 'subscriber',
								'first_name' => 'first_name',
								'last_name' => 'last_name',
								'nickname' => '{variable:display_name}',
								'display_name' => '{variable:display_name}',
							),
						'conditions' =>
							array (
								'type' => 'show',
								'group' =>
									array (
										'register_conditional' =>
											array (
												'1' =>
													array (
														'field' => 'login_or_register',
														'compare' => 'is',
														'value' => 'register',
													),
											),
									),
							),
					),
			),
		'variables' =>
			array (
				'keys' =>
					array (
						0 => 'display_name',
					),
				'values' =>
					array (
						0 => '%first_name% %last_name%',
					),
				'types' =>
					array (
						0 => 'static',
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
