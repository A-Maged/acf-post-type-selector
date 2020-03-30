<?php



// exit if accessed directly
if (! defined('ABSPATH')) {
    exit;
}


// check if class already exists
if (!class_exists('cm_post_type_field')) :


class cm_post_type_field extends acf_field
{
    
    
    /*
    *  __construct
    *
    *  This function will setup the field type data
    *
    *  @type	function
    *  @date	5/03/2014
    *  @since	5.0.0
    *
    *  @param	n/a
    *  @return	n/a
    */
    
    public function __construct($settings)
    {
        
        /*
        *  name (string) Single word, no spaces. Underscores allowed
        */
        
        $this->name = 'acf_post_type_selector';
        
        
        /*
        *  label (string) Multiple words, can include spaces, visible when selecting a field type
        */
        
        $this->label = 'Post Type Selector';
        
        
        /*
        *  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
        */
        
        $this->category = 'relational';
        
        
        /*
        *  defaults (array) Array of default settings which are merged into the field object. These are used later in settings
        */
        
        $this->defaults = array(
        );
        
        
        /*
        *  settings (array) Store plugin settings (url, path, version) as a reference for later use with assets
        */
        
        $this->settings = $settings;
        
        
        // do not delete!
        parent::__construct();
    }
    
    
    /*
    *  render_field_settings()
    *
    *  Create extra settings for your field. These are visible when editing a field
    *
    *  @type	action
    *  @since	3.6
    *  @date	23/01/13
    *
    *  @param	$field (array) the $field being edited
    *  @return	n/a
    */
    
    public function render_field_settings($field)
    {
        
        /*
        *  acf_render_field_setting
        *
        *  This function will create a setting for your field. Simply pass the $field parameter and an array of field settings.
        *  The array of settings does not require a `value` or `prefix`; These settings are found from the $field array.
        *
        *  More than one setting can be added by copy/paste the above code.
        *  Please note that you must also have a matching $defaults value for the field name (font_size)
        */
        
        acf_render_field_setting($field, array(
            'label'			=> __('Allow multiple?'),
            'instructions'	=> '',
            'name'			=> 'multiple',
            'type'			=> 'true_false',
            'ui'			=> 1,
        ));
    }

    /*
    *  render_field()
    *
    *  Create the HTML interface for your field
    *
    *  @param	$field (array) the $field being rendered
    *
    *  @type	action
    *  @since	3.6
    *  @date	23/01/13
    *
    *  @param	$field (array) the $field being edited
    *  @return	n/a
    */
    
    public function render_field($field)
    {

        $post_types = get_post_types(
            [
                'show_ui' => true,
            ],
            'objects'
        );
        
        $isMultiple = $field['multiple'] ? 'multiple="multiple"' : '';
        $checked = [];
        if (! empty($field[ 'value'])) {
            foreach ($field[ 'value' ] as $val) {
                $checked[ $val ] = true;
            }
        } ?>
            <select class="js-multiple-select2" def name="<?php echo $field[ 'name' ] ?>[]" <?php echo $isMultiple ?>>
                <option value="null">none</option>
                <?php
                  foreach ($post_types as $type => $typeObject) {
                      $isSelected = isset($checked[ $type ]) && $checked[ $type ] ? 'selected="1"'  : null;
                      echo '<option  ' . $isSelected . ' value="' . $type . '" >' . $typeObject->label . '</option>';
                  } ?>
            </select>
		<?php
    }


    /*
    *  input_admin_enqueue_scripts()
    *
    *  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
    *  Use this action to add CSS + JavaScript to assist your render_field() action.
    *
    *  @type	action (admin_enqueue_scripts)
    *  @since	3.6
    *  @date	23/01/13
    *
    *  @param	n/a
    *  @return	n/a
    */


    public function input_admin_enqueue_scripts()
    {

        // vars
        $url = $this->settings['url'];
        $version = $this->settings['version'];


        // register & include JS
        wp_enqueue_script('select2', "https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js", array('acf-input'), $version);

        wp_enqueue_script('custom-js', "{$url}assets/js/input.js", array('acf-input'), $version);
        wp_enqueue_style('custom-css', "{$url}assets/style/style.css");

        // register & include CSS
        // wp_register_style('select2-css', "https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css", array('acf-input'), $version);
        // wp_enqueue_style('select2-css');
    }

    /*
    *  update_value()
    *
    *  This filter is applied to the $value before it is saved in the db
    *
    *  @type	filter
    *  @since	3.6
    *  @date	23/01/13
    *
    *  @param	$value (mixed) the value found in the database
    *  @param	$post_id (mixed) the $post_id from which the value was loaded
    *  @param	$field (array) the field array holding all the field options
    *  @return	$value
    */
    
    
    public function update_value($value, $post_id, $field)
    {
        return $value;
    }
}


// initialize
new cm_post_type_field($this->settings);


// class_exists check
endif;
