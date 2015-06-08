<?php
/*
Plugin Name: Footer logos
Plugin URI:
Description: Drop some images into a widget, with optional links. Designed for footer logos, but can be used anywhere.
Version: 1.0
Author: Barry Rhodes | mymedialab
Author URI: http://mymedialab.co.uk
License: GPL2
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require __DIR__ . "/MML_Footer_Logos.php";

/**
 * Register the widget
 */
add_action('widgets_init', function() {
    return register_widget("MML_Footer_Logos");
});
