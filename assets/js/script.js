'use strict';

document.addEventListener('DOMContentLoaded', function () {
  var $ = document.querySelector.bind(document),
      $$ = document.querySelectorAll.bind(document),
      mainMenu = $('#main-menu'),
      menuToggle = $('.navbar-toggle'),
      goTop = $('#mloc-go-top');
  var isCollapsed = void 0,
      toggleTarget = void 0,
      scrollTop = void 0;

  /**
   * Change elements depending on window
   * scroll location
   */
  (function () {
    if (!window.scrollTop) {
      mainMenu.classList.add('at-top');
    }

    window.addEventListener('scroll', function () {
      scrollTop = window.pageYOffset;

      if (scrollTop > 0) {
        mainMenu.classList.remove('at-top');
        if (scrollTop > 100) {
          goTop.classList.remove('faded-out');
        } else {
          goTop.classList.add('faded-out');
        }
      } else {
        mainMenu.classList.add('at-top');
      }
    });
  })();

  /**
   * Navigation bar toggle for mobile
   */
  (function () {
    if (!menuToggle) {
      return;
    }

    toggleTarget = $(menuToggle.getAttribute('data-target'));

    menuToggle.addEventListener('click', function () {
      if (menuToggle.classList.contains('collapsed')) {
        isCollapsed = true;
      } else {
        isCollapsed = false;
      }

      menuToggle.setAttribute('aria-expanded', isCollapsed);
      menuToggle.classList.toggle('collapsed');

      toggleTarget.classList.toggle('in');
    });
  })();

  /**
   * Smooth scroll to location
   * @param to
   * @param duration
   */
  function scrollTo(to, duration) {
    var element = document.scrollingElement || document.documentElement,
        start = element.scrollTop,
        change = to - start,
        startDate = new Date().getTime();

    var easeInOutAnimation = function easeInOutAnimation(pCurrentTime, pStart, pChange, pDuration) {
      pCurrentTime /= pDuration / 2;
      if (pCurrentTime < 1) {
        return pChange / 2 * pCurrentTime * pCurrentTime + pStart;
      }
      pCurrentTime--;
      return -pChange / 2 * (pCurrentTime * (pCurrentTime - 2) - 1) + pStart;
    };

    var animateScroll = function animateScroll() {
      var currentDate = new Date().getTime();
      var currentTime = currentDate - startDate;
      element.scrollTop = parseInt(easeInOutAnimation(currentTime, start, change, duration));
      if (currentTime < duration) {
        requestAnimationFrame(animateScroll);
      } else {
        element.scrollTop = to;
      }
    };
    animateScroll();
  }

  /**
   * Scroll to top on click
   */
  (function () {
    goTop.addEventListener('click', function () {
      scrollTo(0, 800);
    });
  })();
});
