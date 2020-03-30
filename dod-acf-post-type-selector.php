<?php

/*
Plugin Name: acf post type selector
Plugin URI: PLUGIN_URL
Description: SHORT_DESCRIPTION
Version: 1.0.0
Author: AUTHOR_NAME
Author URI: AUTHOR_URL
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/


// exit if accessed directly
if (! defined('ABSPATH')) {
    exit;
}


// check if class already exists
if (!class_exists('cm_acf_post_type_selector')) :

class cm_acf_post_type_selector
{
    
    // vars
    public $settings;
    
    
    /*
    *  __construct
    *
    *  This function will setup the class functionality
    *
    *  @type	function
    *  @date	17/02/2016
    *  @since	1.0.0
    *
    *  @param	void
    *  @return	void
    */
    
    public function __construct()
    {
        
        // settings
        // - these will be passed into the field class.
        $this->settings = array(
            'version'	=> '1.0.0',
            'url'		=> plugin_dir_url(__FILE__),
            'path'		=> plugin_dir_path(__FILE__)
        );
        
        
        // include field
        add_action('acf/include_field_types', array($this, 'include_field')); // v5
    }
    
    
    /*
    *  include_field
    *
    *  This function will include the field type class
    *
    *  @type	function
    *  @date	17/02/2016
    *  @since	1.0.0
    *
    *  @param	$version (int) major ACF version. Defaults to false
    *  @return	void
    */
    
    public function include_field($version = false)
    {
        // include
        include_once('post-type-field.php');
    }
}


// initialize
new cm_acf_post_type_selector();


// class_exists check
endif;
