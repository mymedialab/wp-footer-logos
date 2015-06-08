<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Class MML_Footer_Logos
 *
 * @todo  can i strip a whole bunch of rubbish out by using multiple in the image library?!
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

        wp_register_style('mml-footer-logos', plugin_dir_url(__FILE__) . "/footer-logo-panel.css");
        wp_register_script('mml-footer-logos', plugin_dir_url(__FILE__) . "/footer-logos.js", ['jquery'], '1.0', true);
        //Init the widget
        parent::__construct($this->textdomain, __(self::WIDGET_NAME, $this->textdomain), array( 'description' => __(self::WIDGET_DESCRIPTION, $this->textdomain), 'classname' => $this->textdomain));
    }

    /**
     * Widget frontend
     *  Exposes the following filters:
     *      mml_footer_logos_single    filters an individual logo in the widget (fired on every logo)
     *      mml_footer_logos_content   filters the built content of the widget. (fired once)
     *      mml_footer_logos_output    filters the entire widget, including any before or after widget gubbins and the title. (fired once)
     *
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance)
    {
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
        $logos = ( isset( $instance['logos'] ) && is_array($instance['logos']) ) ? $instance['logos'] : array();
        ob_start();

        include __DIR__ . '/widget-public.php';

        return apply_filters( 'mml_footer_logos_content', ob_get_clean() );
    }

    public function form( $instance ) {
        wp_enqueue_media();
        wp_enqueue_script('mml-footer-logos');
        wp_enqueue_style('mml-footer-logos');
        $title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $logos = ( isset( $instance['logos'] ) && is_array($instance['logos']) ) ? $instance['logos'] : array();

        include __DIR__ . '/widget-panel.php';
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
