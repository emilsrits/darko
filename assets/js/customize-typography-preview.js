/**
 * Theme customizer typography preview JS file
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
        } );
    } );
    api( 'mloc_typography_size_hero', function ( setting ) {
        setting.bind( function ( to ) {
            var inlineOld = $( '.customizer-typography-size-hero-inline' );
            if ( to ) {
                var inline = '<style class="customizer-typography-size-hero-inline">header .hero .hero-title { font-size: ' + to + 'px; }</style>';
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
    api( 'mloc_typography_size_blog_heading', function ( setting ) {
        setting.bind( function ( to ) {
            var inlineOld = $( '.customizer-typography-size-blog-heading-inline' );
            if ( to ) {
                var inline = '<style class="customizer-typography-size-blog-heading-inline">.blog .post .post-title { font-size: ' + to + 'px; }</style>';
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
    api( 'mloc_typography_size_blog_body', function ( setting ) {
        setting.bind( function ( to ) {
            var inlineOld = $( '.customizer-typography-size-blog-body-inline' );
            if ( to ) {
                var inline = '<style class="customizer-typography-size-blog-body-inline">.blog .post .post-content { font-size: ' + to + 'px; }</style>';
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
    api( 'mloc_typography_size_page_body', function ( setting ) {
        setting.bind( function ( to ) {
            var inlineOld = $( '.customizer-typography-size-page-body-inline' );
            if ( to ) {
                var inline = '<style class="customizer-typography-size-page-body-inline">.page .page-content, .single-post .post-content { font-size: ' + to + 'px; }</style>';
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
    api( 'mloc_typography_size_sidebar', function ( setting ) {
        setting.bind( function ( to ) {
            var inlineOld = $( '.customizer-typography-size-sidebar-inline' );
            if ( to ) {
                var inline = '<style class="customizer-typography-size-sidebar-inline">#sidebar-primary { font-size: ' + to + 'px; }</style>';
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
    api( 'mloc_typography_size_footer_sidebar', function ( setting ) {
        setting.bind( function ( to ) {
            var inlineOld = $( '.customizer-typography-size-footer-sidebar-inline' );
            if ( to ) {
                var inline = '<style class="customizer-typography-size-footer-sidebar-inline">#site-footer .sidebar-footer-item { font-size: ' + to + 'px; }</style>';
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
    api( 'mloc_typography_size_copyright', function ( setting ) {
        setting.bind( function ( to ) {
            var inlineOld = $( '.customizer-typography-size-copyright-inline' );
            if ( to ) {
                var inline = '<style class="customizer-typography-size-copyright-inline">#site-footer .copyright { font-size: ' + to + 'px; }</style>';
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
