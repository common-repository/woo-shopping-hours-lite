<?php

/**
 * Add WooShopping_Widget widget.
 */
class WooShopping_Widget extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'wooshoppingwidget', // Base ID
			__( 'Woo Shopping Hours', 'woo-shopping' ), // Name
			array( 'description' => __( 'Woo Shopping Hours Widget', 'woo-shopping' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		$wooshopping_options = get_option( "wooshopping-options" );
		$wooshopping_currentday_style = 'style="background-color:'.$wooshopping_options["wooshoppingbgcolor"].';color:'.$wooshopping_options["wooshoppingfontcolor"].';"';
		$timezone = $wooshopping_options["timezone"];
		if(empty($timezone) || stristr($timezone, 'UTC+') || stristr($timezone, 'UTC-') ) {
			$timezone = 'UTC';
		}
		
		$date = new DateTime('now', new DateTimeZone($timezone));
		$currentday = $date->format('w');
		?>
		<table class="wooshopping-table wooshopping-widget">
			<thead>
				<tr><th><?php _e('Day', 'woo-shopping'); ?></th><th><?php _e('From', 'woo-shopping'); ?></th><th><?php _e('To', 'woo-shopping'); ?></th></tr>
			</thead>
			<tbody>
				<?php if($wooshopping_options["mondayfrom"] != 'Close' || $wooshopping_options["mondayto"] != 'Close') { ?>
				<tr <?php if($currentday == 1){ echo $wooshopping_currentday_style;} ?>><td><?php _e('Monday', 'woo-shopping'); ?></td><td><?php echo $wooshopping_options["mondayfrom"]; ?></td><td><?php echo $wooshopping_options["mondayto"]; ?></td></tr>
				<?php } else { ?>
				<tr <?php if($currentday == 1){ echo $wooshopping_currentday_style;} ?> style="color:#ff0000"><td><?php _e('Monday', 'woo-shopping'); ?></td><td><?php _e('Close', 'woo-shopping'); ?></td><td><?php _e('Close', 'woo-shopping'); ?></td></tr>
				<?php } ?>
				
				<?php if($wooshopping_options["tuesdayfrom"] != 'Close' || $wooshopping_options["tuesdayto"] != 'Close') { ?>
				<tr <?php if($currentday == 2){ echo $wooshopping_currentday_style;} ?>><td><?php _e('Tuesday', 'woo-shopping'); ?></td><td><?php echo $wooshopping_options["tuesdayfrom"]; ?></td><td><?php echo $wooshopping_options["tuesdayto"]; ?></td></tr>
				<?php } else { ?>
				<tr <?php if($currentday == 2){ echo $wooshopping_currentday_style;} ?> style="color:#ff0000"><td><?php _e('Tuesday', 'woo-shopping'); ?></td><td><?php _e('Close', 'woo-shopping'); ?></td><td><?php _e('Close', 'woo-shopping'); ?></td></tr>
				<?php } ?>
				
				<?php if($wooshopping_options["wednesdayfrom"] != 'Close' || $wooshopping_options["wednesdayto"] != 'Close') { ?>
				<tr <?php if($currentday == 3){ echo $wooshopping_currentday_style;} ?>><td><?php _e('Wednesday', 'woo-shopping'); ?></td><td><?php echo $wooshopping_options["wednesdayfrom"]; ?></td><td><?php echo $wooshopping_options["wednesdayto"]; ?></td></tr>
				<?php } else { ?>
				<tr <?php if($currentday == 3){ echo $wooshopping_currentday_style;} ?> style="color:#ff0000"><td><?php _e('Wednesday', 'woo-shopping'); ?></td><td><?php _e('Close', 'woo-shopping'); ?></td><td><?php _e('Close', 'woo-shopping'); ?></td></tr>
				<?php } ?>
				
				<?php if($wooshopping_options["thursdayfrom"] != 'Close' || $wooshopping_options["thursdayto"] != 'Close') { ?>
				<tr <?php if($currentday == 4){ echo $wooshopping_currentday_style;} ?>><td><?php _e('Thursday', 'woo-shopping'); ?></td><td><?php echo $wooshopping_options["thursdayfrom"]; ?></td><td><?php echo $wooshopping_options["thursdayto"]; ?></td></tr>
				<?php } else { ?>
				<tr <?php if($currentday == 4){ echo $wooshopping_currentday_style;} ?> style="color:#ff0000"><td><?php _e('Thursday', 'woo-shopping'); ?></td><td><?php _e('Close', 'woo-shopping'); ?></td><td><?php _e('Close', 'woo-shopping'); ?></td></tr>
				<?php } ?>
				
				<?php if($wooshopping_options["fridayfrom"] != 'Close' || $wooshopping_options["fridayto"] != 'Close') { ?>
				<tr <?php if($currentday == 5){ echo $wooshopping_currentday_style;} ?>><td><?php _e('Friday', 'woo-shopping'); ?></td><td><?php echo $wooshopping_options["fridayfrom"]; ?></td><td><?php echo $wooshopping_options["fridayto"]; ?></td></tr>
				<?php } else { ?>
				<tr <?php if($currentday == 5){ echo $wooshopping_currentday_style;} ?> style="color:#ff0000"><td><?php _e('Friday', 'woo-shopping'); ?></td><td><?php _e('Close', 'woo-shopping'); ?></td><td><?php _e('Close', 'woo-shopping'); ?></td></tr>
				<?php } ?>
				
				<?php if($wooshopping_options["saturdayfrom"] != 'Close' || $wooshopping_options["saturdayto"] != 'Close') { ?>
				<tr <?php if($currentday == 6){ echo $wooshopping_currentday_style;} ?>><td><?php _e('Saturday', 'woo-shopping'); ?></td><td><?php echo $wooshopping_options["saturdayfrom"]; ?></td><td><?php echo $wooshopping_options["saturdayto"]; ?></td></tr>
				<?php } else { ?>
				<tr <?php if($currentday == 6){ echo $wooshopping_currentday_style;} ?> style="color:#ff0000"><td><?php _e('Saturday', 'woo-shopping'); ?></td><td><?php _e('Close', 'woo-shopping'); ?></td><td><?php _e('Close', 'woo-shopping'); ?></td></tr>
				<?php } ?>
				
				<?php if($wooshopping_options["sundayfrom"] != 'Close' || $wooshopping_options["sundayto"] != 'Close') { ?>
				<tr <?php if($currentday == 0){ echo $wooshopping_currentday_style;} ?>><td><?php _e('Sunday', 'woo-shopping'); ?></td><td> <?php echo $wooshopping_options["sundayfrom"]; ?></td><td><?php echo $wooshopping_options["sundayto"]; ?></td></tr>
				<?php } else { ?>
				<tr <?php if($currentday == 0){ echo $wooshopping_currentday_style;} ?> style="color:#ff0000"><td><?php _e('Sunday', 'woo-shopping'); ?></td><td><?php _e('Close', 'woo-shopping'); ?></td><td><?php _e('Close', 'woo-shopping'); ?></td></tr>
				<?php } ?>
		    </tbody>
		</table>
		<?php
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		/***INPUT TITLE***/
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Shopping Hours', 'woo-shopping' );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

} // class WooShopping_Widget	

// register WooShopping_Widget widget
function wooshopping_register_widget() {
    register_widget( 'WooShopping_Widget' );
}
add_action( 'widgets_init', 'wooshopping_register_widget' );

?>