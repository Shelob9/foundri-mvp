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
	//echo \Caldera_Forms::render_form( 'CF5552ab21a05eb' );
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

		function foundri_ask_search( obj ) {

			data = {
				ask_type: obj.data.type_search,
				text: encodeURIComponent( obj.data.text_search ),
				community:<?php echo $post->ID; ?>
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
						html = '<div class="col-sm-6 col-md-3">' + template( ask ) + '</div>';
						$( asks_el ).append( html );
					});
				},
				'json'
			);
		}

		$( document ).on( 'click', '.ask-preview', function(e) {
			e.preventDefault;
			id = $( this ).attr( 'data-ask-id' );
			foundri_get_ask_details( id );
		});

		$( document ).on( 'click', '#ask-close', function(e) {
			e.preventDefault;
			$( '.ask-single' ).remove();
			$( foundri_ask_results_el ).html( foundri_ask_results_store );
			$( foundri_back_button_el ).hide();
			$( foundri_search_button ).show();
		});


		var foundri_ask_results_store;
		var foundri_ask_results_el = document.getElementById( 'ask-results' );
		var foundri_back_button_el =  document.getElementById( 'ask-close' );
		var foundri_search_button = document.getElementById( 'search_2' );

		function foundri_get_ask_details( id ) {
			data = {
				ask: id
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
