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

/**
 * Register the widget
 */
add_action('widgets_init', create_function('', 'return register_widget("MML_Footer_Logos");'));

/**
 * Class MML_Footer_Logos
 */
class MML_Footer_Logos extends WP_Widget
{
    const WIDGET_NAME = "Footer Logos";
    const WIDGET_DESCRIPTION = "Drop some images into a widget, with optional links. Designed for footer logos, but can be used anywhere.";

    var $textdomain;
    var $fields;

    /**
     * Construct the widget
     */
    function __construct()
    {
        $this->textdomain = strtolower(get_class($this));

        $this->add_field('title', 'Enter [optional] title', '');
        $this->add_field('logos', 'Logos', array());

        wp_register_script('mml-footer-logos', plugins_url() . "/footer-logos/footer-logos.js", ['jquery'], '1.0', true);
        //Init the widget
        parent::__construct($this->textdomain, __(self::WIDGET_NAME, $this->textdomain), array( 'description' => __(self::WIDGET_DESCRIPTION, $this->textdomain), 'classname' => $this->textdomain));
    }

    /**
     * Widget frontend
     *  Exposes the following actions:
     *      mml_footer_logos_single    filters an individual logo in the widget (fired on every logo)
     *      mml_footer_logos_content   filters the built content of the widget. (fired once)
     *      mml_footer_logos_output    filters the entire widget, including any before or after widget gubbins and the title. (fired once)
     *
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance)
    {
        wp_enqueue_script('jquery');

        $output = $args['before_widget'];
        $title = apply_filters('widget_title', $instance['title']);
        if (!empty($title)) {
            $output .= $args['before_title'] . $title . $args['after_title'];
        }

        $output .= $this->widget_output($args, $instance);

        $output .= $args['after_widget'];

        echo apply_filters( 'mml_footer_logos_output', $output );
    }

    /**
     * This function will execute the widget frontend logic.
     * Everything you want in the widget should be output here.
     */
    private function widget_output($args, $instance)
    {
        extract($instance);
        ob_start();

        ?>
            <p>
                Here is the widget
                And here is our example field: <?= $logos; ?>
            </p>
        <?php

        return apply_filters( 'mml_footer_logos_content', ob_get_clean() );
    }

    public function form( $instance ) {
        wp_enqueue_script('mml-footer-logos');
        $title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $logos = ( isset( $instance['logos'] ) && is_array($instance['logos']) ) ? $instance['logos'] : array();
        ?>
            <div class="mml-footer-logos">
                <p><label for="<?= $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
                <input class="widefat" id="<?= $this->get_field_id( 'title' ); ?>" name="<?= $this->get_field_name( 'title' ); ?>" type="text" value="<?= $title; ?>" /></p>

                <div class="mml-footer-logos-loop">
                    <?php if ( ! count($logos) ) : ?>

                        <p class="mml-footer-logos-logo">
                            <label><?php _e( 'Logo link:' ); ?>
                                <input name="<?= $this->get_field_name( 'logos' ); ?>[]" type="text" value="" />
                            </label>
                            <a href="#" class="mml-footer-logos-remove-logo" style="float:right;">&times;</a>
                        </p>

                    <?php else :
                        foreach ($logos as $logo) : ?>
                            <p class="mml-footer-logos-logo clearfix">
                                <label><?php _e( 'Logo link:' ); ?>
                                    <input name="<?= $this->get_field_name( 'logos' ); ?>[]" type="text" value="<?= $logo ?>" />
                                </label>
                                <a href="#" class="mml-footer-logos-remove-logo" style="float:right;">&times;</a>
                            </p>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <a href="#" class="mml-footer-logos-add-logo">Add a logo</a>
            </div>
        <?php
    }

    /**
     * Adds a text field to the widget
     *
     * @param $field_name
     * @param string $field_description
     * @param string $field_default_value
     * @param string $field_type
     */
    private function add_field($field_name, $field_description = '', $field_default_value = '')
    {
        if(!is_array($this->fields)) {
            $this->fields = array();
        }

        $this->fields[$field_name] = array('name' => $field_name, 'description' => $field_description, 'default_value' => $field_default_value);
    }

    /**
     * Updating widget by replacing the old instance with new
     *
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    public function update($new_instance, $old_instance)
    {
        return $new_instance;
    }
}
