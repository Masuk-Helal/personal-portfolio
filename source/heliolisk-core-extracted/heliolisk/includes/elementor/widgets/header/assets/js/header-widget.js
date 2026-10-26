/**
 * Heliolisk Header widget frontend behaviour — vanilla JS. Bound per
 * instance via Elementor's widget_ready hook, so it also runs inside the
 * editor preview.
 */
( function () {
	'use strict';

	function getScope( el ) {
		// Elementor passes a jQuery object; the fallback passes a plain element.
		return el && el[ 0 ] ? el[ 0 ] : el;
	}

	function initHeader( $scope ) {
		var scope = getScope( $scope );
		var header = scope.querySelector( '.hlw-header' );

		if ( ! header || header.hasAttribute( 'data-hlw-ready' ) ) {
			return;
		}
		header.setAttribute( 'data-hlw-ready', '1' );

		var toggle = header.querySelector( '.hlw-header__toggle' );
		var nav = header.querySelector( '.hlw-header__nav' );

		function closeMenu() {
			if ( ! toggle || ! nav ) {
				return;
			}
			nav.classList.remove( 'is-open' );
			toggle.setAttribute( 'aria-expanded', 'false' );
		}

		if ( toggle && nav ) {
			toggle.addEventListener( 'click', function () {
				var open = nav.classList.toggle( 'is-open' );
				toggle.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
			} );

			nav.addEventListener( 'click', function ( e ) {
				if ( e.target.closest( 'a' ) ) {
					closeMenu();
				}
			} );

			document.addEventListener( 'keydown', function ( e ) {
				if ( 'Escape' === e.key ) {
					closeMenu();
				}
			} );
		}

		// A fixed header leaves the page flow; reserve its height so the
		// content below does not slide underneath it.
		function reserveSpace() {
			if ( header.hasAttribute( 'data-hlw-sticky' ) ) {
				scope.style.minHeight = header.offsetHeight + 'px';
			}
		}

		function onScroll() {
			header.classList.toggle( 'is-scrolled', window.scrollY > 8 );
		}

		reserveSpace();
		onScroll();
		window.addEventListener( 'scroll', onScroll, { passive: true } );
		window.addEventListener( 'resize', reserveSpace );
	}

	if ( window.elementorFrontend && window.elementorFrontend.hooks ) {
		window.elementorFrontend.hooks.addAction( 'frontend/element_ready/hlw-header.default', initHeader );
	} else {
		document.addEventListener( 'DOMContentLoaded', function () {
			document.querySelectorAll( '.elementor-widget-hlw-header' ).forEach( initHeader );
		} );
	}
} )();
