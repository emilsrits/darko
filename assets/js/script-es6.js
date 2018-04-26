( ($) => {
    const
        mainMenu = $( '#main-menu' ),
        menuToggle = mainMenu.find( '.navbar-toggle' ),
        goTop = $( '#mloc-go-top' ),
        rp = $( '#related-posts' ),
        rpRow = rp.find( '.row' ),
        rpNav = $( '#related-posts-navigation' ),
        rpnNext = rpNav.find( '.ajax-next-page' ),
        rpnPrev = rpNav.find( '.ajax-prev-page' ),
        rpSpinner = rp.find( '.mloc-ajax-spinner' );
    let
        data,
        rpnFirst,
        rpnLast,
        isCollapsed,
        toggleTarget,
        scrollTop,
        rpNavPage;

    /**
     * Change elements depending on window
     * scroll location
     */
    ( () => {
        if ( ! window.scrollTop ) {
            mainMenu.addClass( 'at-top' );
        }

        window.addEventListener( 'scroll', () => {
            scrollTop = window.pageYOffset;

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
     * Navigation bar toggle for mobile
     */
    ( () => {
        if ( ! menuToggle ) {
            return;
        }

        toggleTarget = $( menuToggle.attr( 'data-target' ) );

        menuToggle.on( 'click', () => {
            if ( menuToggle.hasClass( 'collapsed' ) ) {
                isCollapsed = true;
            } else {
                isCollapsed = false;
            }

            menuToggle.attr( 'aria-expanded', isCollapsed );
            menuToggle.toggleClass( 'collapsed' );
            toggleTarget.toggleClass( 'in' );
        } );
    }) ();

    /**
     * Smooth scroll to location
     * @param to
     * @param duration
     */
    function scrollTo( to, duration ) {
        const
            element = document.scrollingElement || document.documentElement,
            start = element.scrollTop,
            change = to - start,
            startDate = new Date().getTime();

        const easeInOutAnimation = function( pCurrentTime, pStart, pChange, pDuration ) {
            pCurrentTime /= pDuration / 2;
            if ( pCurrentTime < 1 ) {
                return pChange / 2 * pCurrentTime * pCurrentTime + pStart;
            }
            pCurrentTime--;
            return -pChange / 2 * ( pCurrentTime * ( pCurrentTime - 2 ) - 1 ) + pStart;
        };

        const animateScroll = function() {
            const currentDate = new Date().getTime();
            const currentTime = currentDate - startDate;
            element.scrollTop = parseInt( easeInOutAnimation( currentTime, start, change, duration ) );
            if ( currentTime < duration ) {
                requestAnimationFrame( animateScroll );
            }
            else {
                element.scrollTop = to;
            }
        };
        animateScroll();
    }

    /**
     * Scroll to top on click
     */
    ( () => {
        goTop.on( 'click', () => {
            scrollTo( 0, 800 );
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
                    action: 'mloc_related_posts',
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
                    action: 'mloc_related_posts',
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
} )( jQuery );