(function($) {
    /**
     *  initialize_field
     *
     *  This function will initialize the $field.
     */

    function initialize_field($field) {
        //$field.doStuff();

        $selectElement = $field.find('select');

        /* initialize Select2 */
        $selectElement.select2({
            placeholder: 'Select Post types',
            closeOnSelect: true, // this eleminates some bugs regaring updating
            width: '100%'
        });

        $selectElement.on('select2:select', function(e) {
            var data = e.params.data;

            if (data.text === 'none') {
                /* clear all */
                clearAllSelections($selectElement);
            } else {
                /* remove "null" option */
                $selectElement
                    .find('option[value="null"]')
                    .prop('selected', false)
                    .trigger('change');
            }
        });

        $selectElement.on('select2:unselect', selectNullIfEmpty.bind(null, $selectElement));
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

        acf.add_action(
            'ready_field/type=acf_post_type_selector',
            initialize_field
        );
        acf.add_action(
            'append_field/type=acf_post_type_selector',
            initialize_field
        );
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
                .find('.field[data-field_type="acf_post_type_selector"]')
                .each(function() {
                    // initialize
                    initialize_field($(this));
                });
        });
    }

    function clearAllSelections($selectElement) {
        $selectElement
            .val(null)
            .val('null')
            .trigger('change');
    }

    function selectNullIfEmpty($selectElement) {
        /* if no elements are selected */
        if (!$selectElement.select2('data').length) {
            /* choose "null" option */
            $selectElement.val('null').trigger('change');
        }
    }
})(jQuery);
