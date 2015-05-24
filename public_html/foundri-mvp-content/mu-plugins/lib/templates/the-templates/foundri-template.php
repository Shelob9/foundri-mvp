<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/handlebars.js/3.0.3/handlebars.min.js"></script>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<!--[if lt IE 9]>
		<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
		<![endif]-->

	<?php
		global $post;
		if ( ! is_object( $post ) ) {
			$post = new stdClass();
			$post->ID = 0;
		}

		wp_head();
	?>
	</head>
	<body <?php body_class(); ?>>
		<div id="page" class="hfeed site">
			<div id="content" class="site-content">
				<div id="primary" class="content-area">
					<main id="main" class="site-main" role="main">
						<?php echo foundri_view(); ?>
					</main>
				</div><!-- #primary -->
			</div><!-- .site-content -->

			<footer id="colophon" class="site-footer" role="contentinfo">
				<div class="site-info">

				</div><!-- .site-info -->
			</footer><!-- .site-footer -->

		</div><!-- #page .site -->


	<script>
		/**
		 * Set up vars
		 */
		//store html for ask results when in detail view
		var foundri_ask_results_store;

		//element for ask results #ask-results
		var foundri_ask_results_el = document.getElementById( 'ask-results' );

		//back button element #ask-close
		var foundri_back_button_el =  document.getElementById( 'ask-close' );

		//serch button element #search_2
		var foundri_search_button = document.getElementById( 'search_2' );

		//current user ID
		var foundri_user_id = <?php echo (int) get_current_user_id(); ?>;

		//URL for deleting asks
		var foundri_delete_ask_endpoint_url = "<?php echo esc_url( trailingslashit( foundri_api_url( 'ask' ) ) ); ?>";

		//URL for communities
		var foundri_community_api_url = "<?php echo esc_url( trailingslashit( foundri_api_url( 'community' ) ) ); ?>";

		//nonce
		var foundri_nonce = "<?php echo foundri_api_nonce(); ?>";

		var foundri_nonce_field = "<?php echo foundri_nonce_field(); ?>";
		/**
		 * Search for asks by type
		 */
		function foundri_ask_search( obj ) {

			data = {
				ask_type: obj.data.type_search,
				text: encodeURIComponent( obj.data.text_search ),
				community:<?php echo $post->ID; ?>,
				foundriApiNonce: foundri_nonce,
				uid: foundri_user_id
			};

			$.get(
				"<?php echo esc_url( foundri_api_url( 'asks' ) ); ?>",
				data,
				function( response ) {
					asks_el = document.getElementById( 'ask-results' );
					asks_el.innerHTML = '';

					$.each( response, function ( i, ask ) {
						source = $( '#foundri-ask-preview' ).html();
						template = Handlebars.compile( source );
						html = '<div class="col-sm-6 col-md-3">' + template( ask );
						if ( foundri_user_id == ask.author.ID ) {
							html += '<div><a href="#" data-ask-id="' + ask.ID + '" class="delete-ask btn btn-default" >Delete</a></div>';
						}
						html += '</div>';
						$( asks_el ).append( html );
					});
				},
				'json'
			);
		}

		/**
		 * Delete asks on click of delete button
		 */
		$( document ).on( 'click', '.delete-ask', function(e) {
			e.preventDefault();
			id = $( this ).attr( 'data-ask-id' );
			parent = $( this ).parent().parent();

			$.ajax( {
				url: foundri_delete_ask_endpoint_url + id + '?foundriApiNonce=' + foundri_nonce + '&uid=' + foundri_user_id,
				type: 'DELETE',
				success: function() {
					el = 'ask-' + id;
					ask_el = document.getElementById( el );
					if ( null != ask_el ) {
						$( parent ).remove();
					}
				}
			} )

		});

		/**
		 * Join Community on click of join button.
		 */
		$( document ).on( 'click', '#join-community', function(e) {
			e.preventDefault;
			id = $( this ).attr( 'data-community' );

			url = foundri_community_api_url + id + '/join';

			$.ajax( {
					url: url,
					method: 'POST',
					data: {
						foundriApiNonce: foundri_nonce,
						uid: foundri_user_id
					},
					success: function() {
						$( this ).remove();
					}
				} );
		});


		/**
		 * View ask details on click of ask preview
		 */
		$( document ).on( 'click', '.ask-preview', function(e) {
			e.preventDefault;
			id = $( this ).attr( 'data-ask-id' );
			foundri_get_ask_details( id );
		});

		/**
		 * Close ask on click of close button
		 */
		$( document ).on( 'click', '#ask-close', function(e) {
			e.preventDefault;
			$( '.ask-single' ).remove();
			$( foundri_ask_results_el ).html( foundri_ask_results_store );
			$( foundri_back_button_el ).hide();
			$( foundri_search_button ).show();
		});




		function foundri_get_ask_details( id ) {
			data = {
				ask: id,
				foundriApiNonce: foundri_nonce
			};

			$.get(
				"<?php echo esc_url( foundri_api_url( 'ask' ) ); ?>",
				data,
				function( response ) {
					source = $( '#foundri-ask-single' ).html();
					template = Handlebars.compile( source );
					html = template( response );
					foundri_ask_results_store = $( foundri_ask_results_el ).html();
					foundri_ask_results_el.innerHTML = html;
					$( foundri_back_button_el ).show();
					$( foundri_search_button ).hide();



				}
			);
		}





	</script>
		<?php
		foundri_print_handelbars_js_templates();
		wp_footer();
		?>

	</body>
</html>