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

		//id of containter for asks comments

		var foundri_ask_comment_id = 'ask-comments';

		//element for ask comments #ask-comments
		var foundri_ask_comment_el = document.getElementById( foundri_ask_comment_id );

		//nonce
		var foundri_nonce = "<?php echo foundri_api_nonce(); ?>";

		//header for comment form #discussion-headline
		var foundri_comment_headline = document.getElementById( 'discussion-headline' );

		//element for general discussion #community-comments-general
		var foundri_community_comments_el = document.getElementById( 'community-comments-general' );

		//element wrapping commment form itself #foundri-comment-form-wrap
		var foundri_comment_form_wrap_el = document.getElementById( 'foundri-comment-form-wrap' );

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
						html = '<div id="search-result" class="col-sm-6 col-md-3">' + template( ask );
						if ( foundri_user_id == ask.author.ID ) {
							html += '<div><a href="#ask-results" data-ask-id="' + ask.ID + '" class="ask-preview-btn delete-ask btn btn-default" >Delete</a></div>';
						}
						html += '<div><a href="#ask-results" data-ask-id="' + ask.ID + '" class="ask-preview-btn view-ask btn btn-default" >View</a></div>';
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
		$( document ).on( 'click', '.ask-preview, .view-ask', function(e) {
			e.preventDefault;
			$( '#community-comments-header' ).hide();
			id = $( this ).attr( 'data-ask-id' );
			foundri_get_ask_details( id );
			$( foundri_community_comments_el ).hide();

		});

		/**
		 * Close ask on click of close button
		 */
		$( document ).on( 'click', '#ask-close', function(e) {
			e.preventDefault;
			$( '.ask-single' ).remove();
			$( foundri_ask_results_el ).html( foundri_ask_results_store );
			$( foundri_search_button ).show();
			$( foundri_ask_comment_el ).empty();
			$( '[name="ask_comment_id"]' ).val( 0 );
			$( foundri_comment_headline ).html( 'Discuss This Community' );
			$( foundri_comment_form_wrap_el ).appendTo( '#community-discussion' );
			$( foundri_community_comments_el ).show();
			$( '#community-comments-header' ).show();
		});

		/**
		 * Get comments for an ask
		 */
		function foundri_get_ask_comments( id ) {
			data = {
				ask: id,
				foundriApiNonce: foundri_nonce,
				uid: foundri_user_id,
				community:<?php echo $post->ID; ?>
			};

			url = "<?php echo esc_url( foundri_api_url( 'ask' ) ); ?>" + '/' + id  + '/comments/';

			$.get(
				url,
				data,
				function( response ) {
					if ( null == foundri_ask_comment_el ) {
						comment_div = '<div id="'+foundri_ask_comment_id +'"><h5>Discussion</h5></div>'
						$( '#ask-single-bottom' ).append( comment_div );
						foundri_ask_comment_el = document.getElementById( foundri_ask_comment_id );

					}

					if ( 'object' == typeof  response ) {

						$.each( response, function( i, comment ) {
							source = $( '#foundri-comment-single' ).html();
							template = Handlebars.compile( source );
							html = template( comment );

							$( foundri_ask_comment_el ).append( html  );

						});

					}else{
						$( foundri_ask_comment_el ).html( "No Discussion Yet." );
					}

					$( foundri_comment_form_wrap_el ).appendTo( '#ask-single-bottom');

				}
			);


		}

		/**
		 * Get details for an ask
		 *
		 * @param id Ask ID
		 */
		function foundri_get_ask_details( id ) {
			data = {
				ask: id,
				foundriApiNonce: foundri_nonce,
				uid: foundri_user_id
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
					$( foundri_search_button ).hide();

					//set comment ID in ask form
					$( '[name="ask_comment_id"]' ).val( id );
					//get comments
					foundri_get_ask_comments( id );
					$( foundri_comment_headline ).html( 'Discuss ' + response.name );



				}
			);
		}

		/**
		 * Runs after a comment is saved.
		 *
		 * @param obj
		 */
		function foundri_after_comment( obj ){
			console.log( obj );
		}


		/**
		 * Get communitiy general comments
		 */
		function foundri_get_community_comments() {
			url = "<?php echo trailingslashit(esc_url( foundri_api_url( 'community' ) ) ) . $post->ID .'/comments/'; ?>"
			$.get(
				url,
				{
					foundriApiNonce: foundri_nonce,
					uid: foundri_user_id,
					community: <?php echo $post->ID; ?>
				}, function( response ) {
					if ( 'object' == typeof  response ) {

						$.each( response, function( i, comment ) {
							source = $( '#foundri-comment-single' ).html();
							template = Handlebars.compile( source );
							html = template( comment );
							$( foundri_community_comments_el ).append( html  );

						});

					}else{
						$( foundri_community_comments_el ).html( "No Discussion Yet." );
					}


				}
			)
		}
		foundri_get_community_comments();

		/**
		 * Logout button click event
		 */
		$( document ).on( 'click', '#foundri-logout', function(e) {
			e.preventDefault();
			$.get(
				"<?php echo esc_url( admin_url( 'admin-ajax.php' ) );  ?>",
				{
					action: "foundri_logout"
				},function(){
					window.location.replace( "<?php echo esc_url( foundri_link( 'home' ) ); ?>" );
				}
			);
		});

		/**
		 * Refresh page after registering
		 *
		 * @param obj
		 */
		function foundri_post_register( obj ) {
			if ( 'object' == typeof obj  && 'complete' == obj.status ) {
				window.location.replace( "<?php echo esc_url( foundri_link( 'home' ) ); ?>" );
			}

		}


	</script>
		<?php
		foundri_print_handelbars_js_templates();
		wp_footer();
		?>

	</body>
</html>
