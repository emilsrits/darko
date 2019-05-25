/**
 * Theme customizer preview JS file
 *
 * @package Mloc
 */

( function ( $ ) {
    var api = wp.customize;

    api( 'mloc_typography_size_menu', function ( setting ) {
        setting.bind( function ( to ) {
            var inlineOld = $( '.customizer-typography-size-menu-inline' );
            if ( to ) {
                var inline = '<style class="customizer-typography-size-menu-inline">#main-menu #main-navigation .navbar-nav { font-size: ' + to + 'px; }</style>';
                if ( inlineOld.length ) {
                    inlineOld.replaceWith( inline );
                } else {
                    $( 'head' ).append( inline );
                }
            } else {
                inlineOld.remove();
            }
        } )
    } )
} )( jQuery );
