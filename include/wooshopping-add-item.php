<?php

function wooshopping_current_time_zone_validation( $passed, $product_id) {
	// Make $woocommerce accessable
	global $woocommerce;
	$wooshopping_options = get_option( "wooshopping-options" );
	$timezone = $wooshopping_options["timezone"];
	$time_format = $wooshopping_options["timeformat"];

	if(empty($timezone))
		$timezone = 'UTC';
	
	$date = new DateTime('now', new DateTimeZone($timezone));
	$day = $date->format('w');
	$time = strtotime($date->format('H:i:s'));
		
	if ($day == 1){
		$_shop_time_from = ($wooshopping_options['mondayfrom']) ? $wooshopping_options['mondayfrom'] : '';
		$_shop_time_to = ($wooshopping_options['mondayto']) ? $wooshopping_options['mondayto'] : '';
		
	}
	if ($day == 2){
		$_shop_time_from = ($wooshopping_options['tuesdayfrom']) ? $wooshopping_options['tuesdayfrom'] : '';
		$_shop_time_to = ($wooshopping_options['tuesdayto']) ? $wooshopping_options['tuesdayto'] : '';
	
	}
	if ($day == 3){
		$_shop_time_from = ($wooshopping_options['wednesdayfrom']) ? $wooshopping_options['wednesdayfrom'] : '';
		$_shop_time_to = ($wooshopping_options['wednesdayto']) ? $wooshopping_options['wednesdayto'] : '';
	
	}
	if ($day == 4){
		$_shop_time_from = ($wooshopping_options['thursdayfrom']) ? $wooshopping_options['thursdayfrom'] : '';
		$_shop_time_to = ($wooshopping_options['thursdayto']) ? $wooshopping_options['thursdayto'] : '';
	
	}
	if ($day == 5){
		$_shop_time_from = ($wooshopping_options['fridayfrom']) ? $wooshopping_options['fridayfrom'] : '';
		$_shop_time_to = ($wooshopping_options['fridayto']) ? $wooshopping_options['fridayto'] : '';
	
	}
	if ($day == 6){
		$_shop_time_from = ($wooshopping_options['saturdayfrom']) ? $wooshopping_options['saturdayfrom'] : '';
		$_shop_time_to = ($wooshopping_options['saturdayto']) ? $wooshopping_options['saturdayto'] : '';
	
	}
	if ($day == 0){
		$_shop_time_from = ($wooshopping_options['sundayfrom']) ? $wooshopping_options['sundayfrom'] : '';
		$_shop_time_to = ($wooshopping_options['sundayto']) ? $wooshopping_options['sundayto'] : '';
	
	}
	    
    if($time_format == '12 hours'){
    	$date_from = date_create( $_shop_time_from );
		$date_to = date_create( $_shop_time_to );
    	$from = strtotime( date_format( $date_from, 'G:i:s' ) );
	    $to = strtotime( date_format( $date_to, 'G:i:s' ) );
    }else{
	    $from = strtotime($_shop_time_from.':00');
	    $to = strtotime($_shop_time_to.':00');
	}
	
	$value = '';

	// Check if the current Time is between the time zone
	if(($from < $time) && ($to > $time)){
		$value = '0';
		return true;
	}

	if($value != '0'){
		// Get the product title for the error statement
		$product = get_product( $product_id );
		$product_title = $product->post->post_title;
	
		// Add the error
		wc_add_notice( sprintf( __('Shop is Closed', 'woo-shopping') , $product_title ) , 'error' );
	}


}
add_action( 'woocommerce_add_to_cart_validation', 'wooshopping_current_time_zone_validation', 1, 2 );

// define the woocommerce_cart_redirect_after_error callback 
function wooshopping_ajax_redirect_after_error( $get_permalink, $product_id ) { 
    // make filter magic happen here... 
    return $get_permalink.'?add-to-cart='.$product_id; 
}; 
add_filter( 'woocommerce_cart_redirect_after_error', 'wooshopping_ajax_redirect_after_error', 10, 2 );

/**
 * Process the checkout
 */
function wooshopping_checkout_field_process() {

	global $woocommerce;
	$wooshopping_options = get_option( "wooshopping-options" );
	$timezone = $wooshopping_options["timezone"];
	$time_format = $wooshopping_options["timeformat"];

	if(empty($timezone))
		$timezone = 'UTC';
	
	$date = new DateTime('now', new DateTimeZone($timezone));
	$day = $date->format('w');
	$time = strtotime($date->format('H:i:s'));
		
	if ($day == 1){
		$_shop_time_from = ($wooshopping_options['mondayfrom']) ? $wooshopping_options['mondayfrom'] : '';
		$_shop_time_to = ($wooshopping_options['mondayto']) ? $wooshopping_options['mondayto'] : '';
		
	}
	if ($day == 2){
		$_shop_time_from = ($wooshopping_options['tuesdayfrom']) ? $wooshopping_options['tuesdayfrom'] : '';
		$_shop_time_to = ($wooshopping_options['tuesdayto']) ? $wooshopping_options['tuesdayto'] : '';
	
	}
	if ($day == 3){
		$_shop_time_from = ($wooshopping_options['wednesdayfrom']) ? $wooshopping_options['wednesdayfrom'] : '';
		$_shop_time_to = ($wooshopping_options['wednesdayto']) ? $wooshopping_options['wednesdayto'] : '';
	
	}
	if ($day == 4){
		$_shop_time_from = ($wooshopping_options['thursdayfrom']) ? $wooshopping_options['thursdayfrom'] : '';
		$_shop_time_to = ($wooshopping_options['thursdayto']) ? $wooshopping_options['thursdayto'] : '';
	
	}
	if ($day == 5){
		$_shop_time_from = ($wooshopping_options['fridayfrom']) ? $wooshopping_options['fridayfrom'] : '';
		$_shop_time_to = ($wooshopping_options['fridayto']) ? $wooshopping_options['fridayto'] : '';
	
	}
	if ($day == 6){
		$_shop_time_from = ($wooshopping_options['saturdayfrom']) ? $wooshopping_options['saturdayfrom'] : '';
		$_shop_time_to = ($wooshopping_options['saturdayto']) ? $wooshopping_options['saturdayto'] : '';
	
	}
	if ($day == 0){
		$_shop_time_from = ($wooshopping_options['sundayfrom']) ? $wooshopping_options['sundayfrom'] : '';
		$_shop_time_to = ($wooshopping_options['sundayto']) ? $wooshopping_options['sundayto'] : '';
	
	}
	    
    if($time_format == '12 hours'){
    	$date_from = date_create( $_shop_time_from );
		$date_to = date_create( $_shop_time_to );
    	$from = strtotime( date_format( $date_from, 'G:i:s' ) );
	    $to = strtotime( date_format( $date_to, 'G:i:s' ) );
    }else{
	    $from = strtotime($_shop_time_from.':00');
	    $to = strtotime($_shop_time_to.':00');
	}
	
	// Check if the current Time is between the time zone
	if(($from < $time) && ($to > $time)){
		$value = '0';
		return true;
	}

	if($value != '0'){
		if ( is_user_logged_in() ) {
				global $current_user;
				$current_user = wp_get_current_user();
		    	update_user_meta( $current_user->ID, '_sktlast_login', 'shop_closed' );
				wc_add_notice( __('Shop is Closed', 'woo-shopping'), 'error' );
		}else{
			$skt_info_message  = __( 'Shop is Closed', 'woo-shopping' );
			if('no' === get_option( 'woocommerce_enable_checkout_login_reminder' )){
				$link = get_permalink( get_option('woocommerce_myaccount_page_id') ); 
				$skt_info_message .= ' <a href="'.$link.'" >' . __( 'Click here to login', 'woo-shopping' ) . '</a>';
				$skt_info_message .= __(' and save your product in cart.', 'woo-shopping');
			}else{
				$skt_info_message  .= __( 'Please login first from above link and save your product in cart.', 'woo-shopping' );
			}

			if ( !is_admin() && !isset($_COOKIE['time_newvisitor'])) {
				setcookie('time_newvisitor', 1, time()+86400, '/');
			}
			
			wc_add_notice( $skt_info_message, 'error' );
		}	
			

	}


       
}
add_action('woocommerce_checkout_process', 'wooshopping_checkout_field_process', 0);



function wooshopping_user_last_login($login){
	if (isset($_COOKIE['time_newvisitor'])) {
		$user = get_user_by('login',$login);
		$user_ID = $user->ID;
		update_user_meta( $user->ID, '_sktlast_login', 'shop_closed' );
	}
}
add_action( 'wp_login', 'wooshopping_user_last_login', 10, 2 );


// Add a new interval of a week
// See http://codex.wordpress.org/Plugin_API/Filter_Reference/cron_schedules
function wooshopping_add_weekly_cron_schedule( $schedules ) {
    $schedules['mint'] = array(
        'interval' => 60*60*24, // 1 week in seconds
        'display'  => __( 'Once day', 'woo-shopping' ),
    );
    return $schedules;
}
add_filter( 'cron_schedules', 'wooshopping_add_weekly_cron_schedule' );
 
// Schedule an action if it's not already scheduled
if ( ! wp_next_scheduled( 'wooshopping_my_cron_action' ) ) {
    wp_schedule_event( current_time( 'timestamp' ), 'mint', 'wooshopping_my_cron_action' );
}
 
// Hook into that action that'll fire weekly
add_action( 'wooshopping_my_cron_action', 'wooshopping_function_to_run' );
function wooshopping_function_to_run() {

	function wooshopping_get_user_by_meta_data( $meta_key, $meta_value ) {

		// Query for users based on the meta data
		$user_query = new WP_User_Query(
			array(
				'meta_key'	  =>	$meta_key,
				'meta_value'	=>	$meta_value
			)
		);
		// User Loop
		if ( ! empty( $user_query->results ) ) {
			$notify_user_email = array();
			foreach ( $user_query->results as $user ) {
				$notify_user_email[] = $user->user_email;
			}
		} 

		print_r($notify_user_email);

		foreach($notify_user_email as $notify_user_email)
		{
		   wp_mail($notify_user_email, 'Shop Open Notification', 'Shop is open now.', $headers);
		}

	} // end get_user_by_meta_data
	
	wooshopping_get_user_by_meta_data('_sktlast_login','shop_closed');

}

function wooshopping_custom_tracking( $order_id ) {

	// Lets grab the order
	$order = new WC_Order( $order_id );
	$user_id = $order->user_id;
	$meta_key = '_sktlast_login';
	$meta_value = 'shop_closed';

	delete_user_meta( $user_id, $meta_key, $meta_value ); 

}
// Hook into order completed
add_action( 'woocommerce_thankyou', 'wooshopping_custom_tracking' );