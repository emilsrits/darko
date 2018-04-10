document.addEventListener( 'DOMContentLoaded', () => {
  const
    $ = document.querySelector.bind(document),
    $$ = document.querySelectorAll.bind(document),
    mainMenu = $( '#main-menu' ),
    menuToggle = $( '.navbar-toggle' ),
    goTop = $( '#mloc-go-top' );
  let
    isCollapsed,
    toggleTarget,
    scrollTop;

  /**
   * Change elements depending on window
   * scroll location
   */
  ( () => {
    if ( ! window.scrollTop ) {
      mainMenu.classList.add( 'at-top' );
    }

    window.addEventListener( 'scroll', () => {
      scrollTop = window.pageYOffset;

      if ( scrollTop > 0 ) {
        mainMenu.classList.remove( 'at-top' );
        if ( scrollTop > 100 ) {
          goTop.classList.remove( 'faded-out' );
        } else {
          goTop.classList.add( 'faded-out' );
        }
      } else {
        mainMenu.classList.add( 'at-top' );
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

    toggleTarget = $( menuToggle.getAttribute( 'data-target' ) );

    menuToggle.addEventListener( 'click', () => {
      if ( menuToggle.classList.contains( 'collapsed' ) ) {
        isCollapsed = true;
      } else {
        isCollapsed = false;
      }

      menuToggle.setAttribute( 'aria-expanded', isCollapsed );
      menuToggle.classList.toggle( 'collapsed' );

      toggleTarget.classList.toggle( 'in' );
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
    goTop.addEventListener( 'click', () => {
      scrollTo( 0, 800 );
    } );
  }) ();
} );