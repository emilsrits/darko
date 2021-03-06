/**
 * Main scripts file
 *
 * @package Darko
 */

( ($) => {
    const
        win = $( window ),
        mainMenu = $( '#main-menu' ),
        menuToggle = mainMenu.find( '.navbar-toggle' ),
        navItemToggle = $( '#main-navigation' ).find( '.nav-children-icon' ),
        goTop = $( '#darko-go-top' ),
        rp = $( '#related-posts' ),
        rpRow = rp.find( '.row' ),
        rpNav = $( '#related-posts-navigation' ),
        rpnNext = rpNav.find( '.ajax-next-page' ),
        rpnPrev = rpNav.find( '.ajax-prev-page' ),
        rpSpinner = rp.find( '.darko-ajax-spinner' ),
        lmp = $('#darko-load-more');
    let
        data,
        rpnFirst,
        rpnLast,
        toggleTarget,
        scrollTop,
        rpNavPage;

    /**
     * Change elements depending on window
     * scroll location
     */
    ( () => {
        if ( ! goTop.length ) {
            return;
        }

        if ( ! win.scrollTop() ) {
            mainMenu.addClass( 'at-top' );
        }

        win.on( 'scroll', function () {
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
    }) ();

    /**
     * Toggle main navigation dropdown items
     */
    ( () => {
		navItemToggle.click( 'click', function ( e ) {
		    e.preventDefault();
			let currentItem = $( this );
			currentItem.toggleClass( 'collapsed' );
			currentItem.parent().siblings().toggleClass( 'open' );
        } );
    }) ();

    /**
     * Navigation bar toggle for mobile
     */
    ( () => {
        if ( ! menuToggle.length ) {
            return;
        }

        toggleTarget = $( menuToggle.attr( 'data-target' ) );

        menuToggle.on( 'click', function () {
            $( this ).attr( 'aria-expanded', $( this ).hasClass( 'collapsed' ) );
            $( this ).toggleClass( 'collapsed' );

            toggleTarget = $( $( this ).data( 'target' ) );
            toggleTarget.toggleClass( 'in' );
            mainMenu.toggleClass( 'open' );

            if ( toggleTarget.hasClass( 'in' ) ) {
                toggleTarget.slideDown();
            } else {
                toggleTarget.slideUp(400, function () {
                    toggleTarget.css('display', '');
                });
            }
        } );
    }) ();

    /**
     * Scroll to top on click
     */
    ( () => {
        goTop.on( 'click', function () {
            $( 'html, body' ).animate( {scrollTop: 0}, 800 );
            return false;
        } );
    }) ();

    rpNavPage = 1; // set default starting page for ajax post pagination
    rpnFirst = true; // related posts always start at first page
    /**
     * Load next page of related posts
     */
    ( () => {
        rpnNext.on( 'click', ( ) => {
            rpnNext.prop( 'disabled', true );
            $.ajax( {
                type: 'POST',
                url: phpVars.ajaxUrl,
                data: {
                    action: 'darko_related_posts',
                    security: phpVars.check_nonce,
                    postId: rp.data( 'id' ),
                    paged: rpNavPage + 1
                },
                beforeSend: () => {
                  rpSpinner.show();
                },
                success: ( response ) => {
                    data = JSON.parse( response );
                    if ( $.trim( data.html ) ) {
                        rpNavPage++;
                        rpRow.html( data.html );
                    }
                    data.lastPage ? rpnLast = true : rpnLast = false;
                },
                complete: () => {
                    rpSpinner.hide();
                    if ( rpnFirst ) {
                        rpnFirst = false;
                        rpnPrev.prop( 'disabled', false );
                    }
                    if ( ! rpnLast ) {
                        rpnNext.prop( 'disabled', false );
                    }
                }
            } );
        } );
    }) ();

    /**
     * Load previous page of related posts
     */
    ( () => {
        rpnPrev.on( 'click', ( ) => {
            rpnPrev.prop( 'disabled', true );
            $.ajax( {
                type: 'POST',
                url: phpVars.ajaxUrl,
                data: {
                    action: 'darko_related_posts',
                    security: phpVars.check_nonce,
                    postId: rp.data( 'id' ),
                    paged: rpNavPage - 1
                },
                beforeSend: () => {
                    rpSpinner.show();
                },
                success: ( response ) => {
                    data = JSON.parse( response );
                    rpNavPage--;
                    if ( rpNavPage < 1) {
                        rpNavPage = 1;
                    } else {
                        rpRow.html( data.html );
                    }
                    data.firstPage ? rpnFirst = true : rpnFirst = false;
                },
                complete: () => {
                    rpSpinner.hide();
                    if ( rpnLast ) {
                        rpnLast = false;
                        rpnNext.prop( 'disabled', false );
                    }
                    if ( ! rpnFirst ) {
                        rpnPrev.prop( 'disabled', false );
                    }
                }
            } );
        } );
    }) ();

    ( () => {
        lmp.on( 'click', () => {
            $.ajax( {
                type: 'POST',
                url: phpVars.ajaxUrl,
                data: {
                    action: 'darko_load_more',
                    security: phpVars.check_nonce,
                    paged: phpVars.current_page
                },
                beforeSend: () => {
                    lmp.text( 'Loading...' );
                },
                success: ( response ) => {
                    if ( response ) {
                        lmp.text( 'Load more posts' ).before( response );
                        phpVars.current_page++;
                        if ( phpVars.current_page == phpVars.max_page ) {
                            lmp.remove();
                        }
                    } else {
                        lmp.remove();
                    }
                }
            } );
        } );
    }) ();
} )( jQuery );