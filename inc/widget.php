<?php
defined('ABSPATH') or die('No direct access permitted');

// widget class
class sfb_widget extends WP_Widget {

	// construct the widget
	public function __construct() {
		parent::__construct(
 		'sfb_widget', // Base ID
		'Follow Buttons', // Name
		array( 'description' => __( 'Simple Follow Buttons', 'text_domain' ), ) // Args
	);
	}

	// extract required arguments and run the shortcode
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;
		if (!empty($title))
		echo $before_title . $title . $after_title;

		echo do_shortcode('[sfb]', 'text_domain' );
		echo $after_widget;
	}

	public function form( $instance )
	{
		if (isset($instance['title'])) {
			$title = $instance['title'];
		}
		else {
			$title = 'Follow Buttons';
		}

		# Title
		echo '<p><label for="' . $this->get_field_id('title') . '">' . 'Title:' . '</label><input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" /></p>';
    }

	public function update($new_instance, $old_instance)
    {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		return $instance;
	}

}

// add sfb to available widgets
add_action( 'widgets_init', create_function( '', 'register_widget( "sfb_widget" );' ) );

function mywidget_init()
{
	register_sidebar_widget('Follow Buttons Widget', 'sfb_widget');
	register_widget_control('Follow Buttons Widget', 'sfb_widget_control');
}
