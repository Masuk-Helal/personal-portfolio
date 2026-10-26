/**
 * Heliolisk Hero widget frontend behaviour — vanilla JS, no external
 * animation library. Bound per-instance via Elementor's widget_ready hook,
 * so it works safely inside the editor preview too.
 */
( function () {
	'use strict';

	function animateCount( el ) {
		var target = parseFloat( el.getAttribute( 'data-hlw-count' ) );
		var decimals = parseInt( el.getAttribute( 'data-hlw-decimals' ), 10 ) || 0;
		var suffix = el.getAttribute( 'data-hlw-suffix' ) || '';

		if ( isNaN( target ) ) {
			return;
		}

		var duration = 1400;
		var start = null;

		function step( timestamp ) {
			if ( ! start ) {
				start = timestamp;
			}
			var progress = Math.min( ( timestamp - start ) / duration, 1 );
			var eased = 1 - Math.pow( 1 - progress, 3 );
			var value = eased * target;

			el.textContent = value.toFixed( decimals ) + suffix;

			if ( progress < 1 ) {
				window.requestAnimationFrame( step );
			} else {
				el.textContent = target.toFixed( decimals ) + suffix;
			}
		}

		window.requestAnimationFrame( step );
	}

	function initHero( scope ) {
		var root = scope && scope.length ? scope[ 0 ] : scope;

		if ( ! root ) {
			return;
		}

		var statValues = root.querySelectorAll( '.hlw-hero__stat-value[data-hlw-count]' );

		if ( ! statValues.length ) {
			return;
		}

		if ( 'IntersectionObserver' in window ) {
			var observer = new IntersectionObserver(
				function ( entries ) {
					entries.forEach( function ( entry ) {
						if ( entry.isIntersecting ) {
							animateCount( entry.target );
							observer.unobserve( entry.target );
						}
					} );
				},
				{ threshold: 0.4 }
			);

			statValues.forEach( function ( el ) {
				observer.observe( el );
			} );
		} else {
			statValues.forEach( animateCount );
		}
	}

	if ( window.elementorFrontend && window.elementorFrontend.hooks ) {
		window.elementorFrontend.hooks.addAction( 'frontend/element_ready/hlw-hero.default', initHero );
	} else {
		document.addEventListener( 'DOMContentLoaded', function () {
			document.querySelectorAll( '.hlw-hero' ).forEach( initHero );
		} );
	}
} )();
