/*global wp, jQuery, wp_styles_notices */
jQuery( document ).ready( function ( $ ) {

	/**
	 * Display X and Y values and their units, with special displaying of keywords
	 */
	$( '.styles-background-position-unit-keywords' ).each( function () {
		var $select = $(this);
		var unit_setting = wp.customize.value( $select.data('unit-setting') );
		var value_setting = wp.customize.value( $select.data('value-setting') );
		var ok_to_select_keyword = true;

		// Select the keyword option if the value has the corresponding percentage
		var update_select = function() {
			var $container = $select.closest('.background-position-dimension');
			var value = parseFloat(value_setting(), 10);
			var $keyword_option = $select.find('[data-percent="' + value + '"]:first');
			var is_keyword_value = (
				ok_to_select_keyword && unit_setting() === '%' && $keyword_option.length !== 0
			);
			if ( is_keyword_value ) {
				$keyword_option.prop( 'selected', true );
				$container.addClass( 'keyword' );
			}
			else {
				$select.find( '[value="' + unit_setting() + '"]' ).prop( 'selected', true );
				$container.removeClass( 'keyword' );
			}
		};

		// Hide value input if we selected a keyword
		$select.on( 'change', function () {
			var $option = $( this.options[this.selectedIndex] );
			if ( typeof $option.data( 'percent' ) !== 'undefined' ) {
				ok_to_select_keyword = true;
				unit_setting( '%' );
				value_setting( $option.data( 'percent' ) );
			}
			else {
				unit_setting( $option.prop( 'value' ) );
			}
			update_select(); // needed if switching between % and keyword
			ok_to_select_keyword = false;
		});

		value_setting.bind( function () {
			update_select();
		});
		unit_setting.bind( function () {
			update_select();
		});
		update_select();
		ok_to_select_keyword = false;
	});
} );
