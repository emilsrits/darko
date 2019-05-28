/**
 * Theme customizer preview JS file
 *
 * @package Mloc
 */

( function ( $ ) {
    var api = wp.customize;

    api( 'mloc_background_transparency', function ( setting ) {
        setting.bind( function ( to ) {
            var inlineOld = $( '.customizer-appearance-background-transparency-inline' );
            if ( to ) {
                var inline = '<style class="customizer-appearance-background-transparency-inline">body.custom-background #main { background-color: rgba(62, 62, 62, ' + to + '); }</style>';
                if ( inlineOld.length ) {
                    inlineOld.replaceWith( inline );
                } else {
                    $( 'head' ).append( inline );
                }
            } else {
                inlineOld.remove();
            }
        } );
    } );
} )( jQuery );
