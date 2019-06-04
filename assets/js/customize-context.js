/**
 * Theme customizer context JS file
 *
 * @package Darko
 */

( function ( $ ) {
    var api = wp.customize;

    api.bind( 'ready', function() {
        // Background transparency setting control
        bgTransparency = api.control( 'darko_background_transparency' );

        // Toggle visibility of background transparency setting depending on background image setting status
        api( 'background_image', function ( setting ) {
            setting.bind( function ( to ) {
                if ( to === '' ) {
                    bgTransparency.deactivate();
                }
                if ( to !== '' && ! bgTransparency.active() ) {
                    bgTransparency.activate();
                }
            } );
        } );
    } );
} )( jQuery );
