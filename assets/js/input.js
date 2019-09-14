(function($) {
	/**
	 *  initialize_field
	 *
	 *  This function will initialize the $field.
	 */

	function initialize_field($field) {
		//$field.doStuff();

		$selectElement = $field.find('select');

		$selectElement.select2({
			placeholder: 'Select Which Post types to show sidebar on',
			closeOnSelect: false,
			width: '100%'
		});

		$field.on('change', function(e) {
			// if is empty
			if ($field.find('ul li').length < 2) {
				// select null
				$selectElement.val('null');
			}
		});
	}

	if (typeof acf.add_action !== 'undefined') {
		/*
		 *  ready & append (ACF5)
		 *
		 *  These two events are called when a field element is ready for initizliation.
		 *  - ready: on page load similar to $(document).ready()
		 *  - append: on new DOM elements appended via repeater field or other AJAX calls
		 *
		 *  @param	n/a
		 *  @return	n/a
		 */

		acf.add_action('ready_field/type=cm_post_type_selector', initialize_field);
		acf.add_action('append_field/type=cm_post_type_selector', initialize_field);
	} else {
		/*
		 *  acf/setup_fields (ACF4)
		 *
		 *  These single event is called when a field element is ready for initizliation.
		 *
		 *  @param	event		an event object. This can be ignored
		 *  @param	element		An element which contains the new HTML
		 *  @return	n/a
		 */

		$(document).on('acf/setup_fields', function(e, postbox) {
			// find all relevant fields
			$(postbox)
				.find('.field[data-field_type="cm_post_type_selector"]')
				.each(function() {
					// initialize
					initialize_field($(this));
				});
		});
	}
})(jQuery);
