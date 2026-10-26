/**
 * Turns the plain <select> elements WordPress prints (Categories dropdown,
 * Archives dropdown, block variants) into nice-select widgets.
 *
 * Core's dropdowns listen for a *native* change event with addEventListener,
 * which jQuery's .trigger('change') does not reach, so every pick is replayed
 * as a real Event on the original select.
 */
(function ($) {
	'use strict';

	// Where a styled dropdown is wanted. Anything outside these wrappers
	// (plugin UIs, Elementor forms) is left alone.
	var SELECTOR = [
		'.widget-area select',
		'.hl-sidebar-widget select',
		'.hl-footer-widget select',
		'.hl-blog-sidebar select',
		'.wp-block-categories-dropdown select',
		'.wp-block-archives-dropdown select',
		'.entry-content select'
	].join( ',' );

	function initNiceSelect( context ) {
		$( SELECTOR, context || document )
			.not( '[multiple], [size], .no-nice-select, .nice-select-ready' )
			.each( function () {
				var $select = $( this );

				$select.addClass( 'nice-select-ready' ).niceSelect();

				// Replay the pick natively for core's own listeners. The guard
				// stops the native event from re-entering this same handler,
				// which jQuery also bound natively.
				$select.on( 'change.heliolisk-nice-select', function () {
					if ( this.dataset.niceSelectReplaying ) {
						return;
					}
					this.dataset.niceSelectReplaying = '1';
					this.dispatchEvent( new Event( 'change', { bubbles: true } ) );
					delete this.dataset.niceSelectReplaying;
				} );

				// nice-select copies the select's width classes but not its
				// label; keep the accessible name on the generated control.
				var label = $select.attr( 'aria-label' ) || $( 'label[for="' + this.id + '"]' ).text();
				if ( label ) {
					$select.next( '.nice-select' ).attr( 'aria-label', $.trim( label ) );
				}
			} );
	}

	$( function () {
		initNiceSelect();
	} );

	// Widgets added live in the Customizer preview / block editor preview.
	$( document ).on( 'widget-added widget-updated', function ( event, widget ) {
		initNiceSelect( widget );
	} );

	// Exposed so other scripts can restyle markup they inject.
	window.helioliskNiceSelect = initNiceSelect;
})( jQuery );
