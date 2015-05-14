/**
 * Created by josh on 5/13/15.
 */
jQuery( document ).ready( function ( $ ) {
    (function ( $, app ) {
        /**
         * Bootstrap
         *
         * @since 0.0.1
         */
        app.init = function() {
            app.vars = window.FoundriVars;

        };

        app.ask_search = function( data ) {
            text = encodeURIComponent( text );
            $.get(
                app.vars.ask_query_url,
                data,
                function( response ) {
                    console.log( response );
                    asks_el = document.getElementById( 'asks' );
                    asks_el.innerHTML = '';
                    asks = JSON.parse( response );
                    console.log( asks );
                    $.each( asks, function ( i, ask ) {
                        source = $( '#foundri-ask-preview' ).html();
                        template = Handlebars.compile( source );
                        html = template( ask );
                        $( asks_el ).append( html );
                    });
                },
                'json'
            );
        }


    })( jQuery, window.Foundri || ( window.Foundri = {} ) );
    jQuery( function () {
        Foundri.init();

    } );
} );
