(function( $ ) {
    'use strict';

    let mainMenu = $( '#main-menu' );
    let goTop = $( '#mloc-go-top' );
    let scrollTop;

    /**
     * Change elements depending on window
     * scroll location
     */
    function initScrollWatch() {
        if ( ! $( window ).scrollTop() ) {
            mainMenu.addClass( 'at-top' );
        }

        $( window ).on( 'scroll', function () {
            scrollTop = $( this ).scrollTop();

            if ( scrollTop > 0 ) {
                mainMenu.removeClass( 'at-top' );
                if ( scrollTop > 100 ) {
                    goTop.removeClass( 'faded-out' );
                } else {
                    goTop.addClass( 'faded-out' );
                }
            } else {
                mainMenu.addClass( 'at-top' );
            }
        } );
    }
    initScrollWatch();

    /**
     * Navigation bar toggle for mobile
     */
    function initMainMenuToggle() {
        let menuToggle = $( '.navbar-toggle' );

        if ( ! menuToggle.length ) {
            return;
        }

        menuToggle.on( 'click', function () {
            $( this ).attr( 'aria-expanded', $( this ).hasClass( 'collapsed' ) );
            $( this ).toggleClass( 'collapsed' );
            let toggleTarget = $( $( this ).data( 'target' ) );
            toggleTarget.toggleClass( 'in' );
            if ( toggleTarget.hasClass( 'in' ) ) {
                toggleTarget.slideDown();
            } else {
                toggleTarget.slideUp();
            }
        } );
    }
    initMainMenuToggle();

    function goTopClick() {
        goTop.on( 'click', function () {
            $( 'html, body' ).animate( {scrollTop : 0}, 800 );
            return false;
        } );
    }
    goTopClick();

}( jQuery ));