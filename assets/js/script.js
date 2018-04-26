'use strict';

/**
 * Main scripts file
 *
 * @package Mloc
 */

(function ($) {
    var mainMenu = $('#main-menu'),
        menuToggle = mainMenu.find('.navbar-toggle'),
        goTop = $('#mloc-go-top'),
        rp = $('#related-posts'),
        rpRow = rp.find('.row'),
        rpNav = $('#related-posts-navigation'),
        rpnNext = rpNav.find('.ajax-next-page'),
        rpnPrev = rpNav.find('.ajax-prev-page'),
        rpSpinner = rp.find('.mloc-ajax-spinner');
    var data = void 0,
        rpnFirst = void 0,
        rpnLast = void 0,
        isCollapsed = void 0,
        toggleTarget = void 0,
        scrollTop = void 0,
        rpNavPage = void 0;

    /**
     * Change elements depending on window
     * scroll location
     */
    (function () {
        if (!window.scrollTop) {
            mainMenu.addClass('at-top');
        }

        window.addEventListener('scroll', function () {
            scrollTop = window.pageYOffset;

            if (scrollTop > 0) {
                mainMenu.removeClass('at-top');
                if (scrollTop > 100) {
                    goTop.removeClass('faded-out');
                } else {
                    goTop.addClass('faded-out');
                }
            } else {
                mainMenu.addClass('at-top');
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

        toggleTarget = $(menuToggle.attr('data-target'));

        menuToggle.on('click', function () {
            if (menuToggle.hasClass('collapsed')) {
                isCollapsed = true;
            } else {
                isCollapsed = false;
            }

            menuToggle.attr('aria-expanded', isCollapsed);
            menuToggle.toggleClass('collapsed');
            toggleTarget.toggleClass('in');
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
        goTop.on('click', function () {
            scrollTo(0, 800);
        });
    })();

    rpNavPage = 1; // set default starting page for ajax post pagination
    rpnFirst = true; // related posts always start at first page
    /**
     * Load next page of related posts
     */
    (function () {
        rpnNext.on('click', function () {
            rpnNext.prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: phpVars.ajaxUrl,
                data: {
                    action: 'mloc_related_posts',
                    security: phpVars.check_nonce,
                    postId: rp.data('id'),
                    paged: rpNavPage + 1
                },
                beforeSend: function beforeSend() {
                    rpSpinner.show();
                },
                success: function success(response) {
                    data = JSON.parse(response);
                    if ($.trim(data.html)) {
                        rpNavPage++;
                        rpRow.html(data.html);
                    }
                    data.lastPage ? rpnLast = true : rpnLast = false;
                },
                complete: function complete() {
                    rpSpinner.hide();
                    if (rpnFirst) {
                        rpnFirst = false;
                        rpnPrev.prop('disabled', false);
                    }
                    if (!rpnLast) {
                        rpnNext.prop('disabled', false);
                    }
                }
            });
        });
    })();

    /**
     * Load previous page of related posts
     */
    (function () {
        rpnPrev.on('click', function () {
            rpnPrev.prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: phpVars.ajaxUrl,
                data: {
                    action: 'mloc_related_posts',
                    security: phpVars.check_nonce,
                    postId: rp.data('id'),
                    paged: rpNavPage - 1
                },
                beforeSend: function beforeSend() {
                    rpSpinner.show();
                },
                success: function success(response) {
                    data = JSON.parse(response);
                    rpNavPage--;
                    if (rpNavPage < 1) {
                        rpNavPage = 1;
                    } else {
                        rpRow.html(data.html);
                    }
                    data.firstPage ? rpnFirst = true : rpnFirst = false;
                },
                complete: function complete() {
                    rpSpinner.hide();
                    if (rpnLast) {
                        rpnLast = false;
                        rpnNext.prop('disabled', false);
                    }
                    if (!rpnFirst) {
                        rpnPrev.prop('disabled', false);
                    }
                }
            });
        });
    })();
})(jQuery);
