<?php
/*
	Plugin Name: Woo Shopping Hours Lite
	Plugin URI: http://wpfruits.com/
	Description: Woo Shopping Hours Lite is a multipurpose wordpress plugin that enables woocommerce sites to specify shopping time, hot deals, shop opening hours, limited period deals and other offers limited within hours. This plugin is built on 100% woocommerce framework which gives extra convenience to every user. With Woo-Commerce shoppings hours plugin, you can select time zone, set time format, set different times for each day of the week and even coloured highlight for current day. With easy shortcodes for widget, this plugin is perfectly developed for multiplying business on your woocommerce site.
	Version: 1.0.0
	Author: wpfruits, tikendramaitry
	Author URI: http://wpfruits.com/
*/

/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
function wooshopping_load_textdomain() {
  load_plugin_textdomain( 'woo-shopping', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'wooshopping_load_textdomain' );

class WooShoppingSettingPage
{
	/**
	 * Holds the values to be used in the fields callbacks
	 */
	private $options;

	/**
	 * Start up
	 */
	public function __construct()
	{
		add_action( 'admin_menu', array( $this, 'wooshopping_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'wooshopping_page_init' ) );
	}

	/**
	 * Add plugin page
	 */
	public function wooshopping_plugin_page()
	{
		// This page will be in "Dashboard Menu"
		add_menu_page(
			__('Settings Admin', 'woo-shopping'), 
			__('Woo Shop Hours', 'woo-shopping'), 
			'manage_options', 
			'wooshopping-setting-admin', 
			array( $this, 'wooshopping_admin_page' ),
			plugins_url( '/images/icon.png',__FILE__)
		);
	}

	/**
	 * Plugin page callback
	 */
	public function wooshopping_admin_page()
	{
		// Set class property
		$this->options = get_option( 'wooshopping-options' );
?>
		<div class="wrap">
			<h2><?php _e('Woo Shopping Hours', 'woo-shopping'); ?></h2>
			<div id="wooshopping_setting">
			<form method="post" action="options.php">
			<?php
				// This printts out all hidden setting fields          
				settings_fields( 'wooshopping_option_group' );   
				do_settings_sections( 'wooshopping-setting-admin' );
				?>
				<hr/>
				<?php
				submit_button();
			?>
			</form>
			</div>
		</div>
<?php
	}

	/**
	 * Register and add settings
	 */
	public function wooshopping_page_init()
	{
		register_setting(
			'wooshopping_option_group', // Option group
			'wooshopping-options', // Option name
			array( $this, 'sanitize' ) // Sanitize
		);

		add_settings_section(
			'setting_section_id', // ID
			'', // Title
			array( $this, 'wooshopping_print_section_info' ), // Callback
			'wooshopping-setting-admin' // Page
		);  

		add_settings_field(
			'time_zone', // ID
			__('Select Timezone','woo-shopping'), // Title 
			array( $this, 'wooshopping_time_zone_callback' ), // Callback
			'wooshopping-setting-admin', // Page
			'setting_section_id' // Section           
		);

		add_settings_field(
			'time_format', // ID
			__('Time Format','woo-shopping'), // Title 
			array( $this, 'wooshopping_time_format_callback' ), // Callback
			'wooshopping-setting-admin', // Page
			'setting_section_id' // Section           
		);

		add_settings_field(
			'monday', // ID
			__('Monday','woo-shopping'), // Title 
			array( $this, 'wooshopping_monday_callback' ), // Callback
			'wooshopping-setting-admin', // Page
			'setting_section_id' // Section           
		);    

		add_settings_field(
			'tuesday', // ID
			__('Tuesday','woo-shopping'), // Title
			array( $this, 'wooshopping_tuesday_callback' ), // Callback
			'wooshopping-setting-admin', // Page
			'setting_section_id' // Section
		);

		add_settings_field(
			'wednesday', // ID
			__('Wednesday','woo-shopping'), // Title
			array( $this, 'wooshopping_wednesday_callback' ), // Callback
			'wooshopping-setting-admin', // Page
			'setting_section_id' // Section
		);

		add_settings_field(
			'thursday', // ID
			__('Thursday','woo-shopping'), // Title
			array( $this, 'wooshopping_thursday_callback' ), // Callback 
			'wooshopping-setting-admin', // Page
			'setting_section_id' // Section
		);

		add_settings_field(
			'friday', // ID
			__('Friday','woo-shopping'), // Title
			array( $this, 'wooshopping_friday_callback' ), // Callback
			'wooshopping-setting-admin', // Page
			'setting_section_id' //Section
		);

		add_settings_field(
			'saturday', // ID
			__('Saturday','woo-shopping'), // Title
			array( $this, 'wooshopping_saturday_callback' ), // Callback
			'wooshopping-setting-admin', // Page
			'setting_section_id' // Section
		);

		add_settings_field(
			'sunday', // ID
			__('Sunday','woo-shopping'), // Title
			array( $this, 'wooshopping_sunday_callback' ), // Callback 
			'wooshopping-setting-admin', // Page
			'setting_section_id' // Section
		);


		add_settings_field(
			'highlight_color', // ID
			__('Highlight Current Day','woo-shopping'), // Title
			array( $this, 'wooshopping_highlight_bgcolor_callback' ), // Callback 
			'wooshopping-setting-admin', // Page
			'setting_section_id' // Section
		);

		add_settings_field(
			'highlight_font_color', // ID
			'', // Title
			array( $this, 'wooshopping_highlight_color_callback' ), // Callback 
			'wooshopping-setting-admin', // Page
			'setting_section_id' // Section
		);

		add_settings_field(
			'genrated_shortcode', // ID
			__('Genrated Shortcode','woo-shopping'), // Title
			array( $this, 'wooshopping_genrated_shortcode_callback' ), // Callback 
			'wooshopping-setting-admin', // Page
			'setting_section_id' // Section
		);
	}

	/**
	 * Sanitize each setting field as needed
	 *
	 * @param array $input Contains all settings fields as array keys
	 */
	public function sanitize( $input )
	{
		$new_input = array();

		if( isset( $input['timeformat'] ) )
			$new_input['timeformat'] = sanitize_text_field( $input['timeformat'] );

		if( isset( $input['timezone'] ) )
			$new_input['timezone'] = sanitize_text_field( $input['timezone'] );

		if( isset( $input['mondayfrom'] ) )
			$new_input['mondayfrom'] = sanitize_text_field( $input['mondayfrom'] );
		if( isset( $input['mondayto'] ) )
			$new_input['mondayto'] = sanitize_text_field( $input['mondayto'] );
		    
		if( isset( $input['tuesdayfrom'] ) )
			$new_input['tuesdayfrom'] = sanitize_text_field( $input['tuesdayfrom'] );
		if( isset( $input['tuesdayto'] ) )
			$new_input['tuesdayto'] = sanitize_text_field( $input['tuesdayto'] );

		if( isset( $input['wednesdayfrom'] ) )
			$new_input['wednesdayfrom'] = sanitize_text_field( $input['wednesdayfrom'] );
		if( isset( $input['wednesdayto'] ) )
			$new_input['wednesdayto'] = sanitize_text_field( $input['wednesdayto'] );

		if( isset( $input['thursdayfrom'] ) )
			$new_input['thursdayfrom'] = sanitize_text_field( $input['thursdayfrom'] );
		if( isset( $input['thursdayto'] ) )
			$new_input['thursdayto'] = sanitize_text_field( $input['thursdayto'] );

		if( isset( $input['fridayfrom'] ) )
			$new_input['fridayfrom'] = sanitize_text_field( $input['fridayfrom'] );
		if( isset( $input['fridayto'] ) )
			$new_input['fridayto'] = sanitize_text_field( $input['fridayto'] );

		if( isset( $input['saturdayfrom'] ) )
			$new_input['saturdayfrom'] = sanitize_text_field( $input['saturdayfrom'] );
		if( isset( $input['saturdayto'] ) )
			$new_input['saturdayto'] = sanitize_text_field( $input['saturdayto'] );

		if( isset( $input['sundayfrom'] ) )
			$new_input['sundayfrom'] = sanitize_text_field( $input['sundayfrom'] );
		if( isset( $input['sundayto'] ) )
			$new_input['sundayto'] = sanitize_text_field( $input['sundayto'] );

		if( isset( $input['wooshoppingbgcolor'] ) )
			$new_input['wooshoppingbgcolor'] = sanitize_text_field( $input['wooshoppingbgcolor'] );

		if( isset( $input['wooshoppingfontcolor'] ) )
			$new_input['wooshoppingfontcolor'] = sanitize_text_field( $input['wooshoppingfontcolor'] );

		return $new_input;
	}

	/** 
	 * Print the Section text
	 */
	public function wooshopping_print_section_info()
	{
		echo '<div id="wooshopping-setting-note"><p><br/>'.__("The saved settings will work in the Woo Shopping Hours Widget.You can also use Genrated Shortcode in the page or post.", "woo-shopping").'</p></div><hr/>';
	}

	/** 
	 * Get the settings option array and print one of its values
	 */

	public function wooshopping_time_zone_callback()
	{
		$timezone = $this->options["timezone"];
		$alltimezone = array ('Pacific/Midway' => '(UTC-11:00) Midway Island', 'Pacific/Samoa' => '(UTC-11:00) Samoa', 'Pacific/Honolulu' => '(UTC-10:00) Hawaii', 'US/Alaska' => '(UTC-09:00) Alaska', 'America/Los_Angeles' => '(UTC-08:00) Pacific Time (US &amp; Canada)', 'America/Tijuana' => '(UTC-08:00) Tijuana', 'US/Arizona' => '(UTC-07:00) Arizona', 'America/Chihuahua' => '(UTC-07:00) Chihuahua', 'America/Chihuahua' => '(UTC-07:00) La Paz', 'America/Mazatlan' => '(UTC-07:00) Mazatlan', 'US/Mountain' => '(UTC-07:00) Mountain Time (US &amp; Canada)', 'America/Managua' => '(UTC-06:00) Central America', 'US/Central' => '(UTC-06:00) Central Time (US &amp; Canada)', 'America/Mexico_City' => '(UTC-06:00) Guadalajara', 'America/Mexico_City' => '(UTC-06:00) Mexico City', 'America/Monterrey' => '(UTC-06:00) Monterrey', 'Canada/Saskatchewan' => '(UTC-06:00) Saskatchewan', 'America/Bogota' => '(UTC-05:00) Bogota', 'US/Eastern' => '(UTC-05:00) Eastern Time (US &amp; Canada)', 'US/East-Indiana' => '(UTC-05:00) Indiana (East)', 'America/Lima' => '(UTC-05:00) Lima', 'America/Bogota' => '(UTC-05:00) Quito', 'Canada/Atlantic' => '(UTC-04:00) Atlantic Time (Canada)', 'America/Caracas' => '(UTC-04:30) Caracas', 'America/La_Paz' => '(UTC-04:00) La Paz', 'America/Santiago' => '(UTC-04:00) Santiago', 'Canada/Newfoundland' => '(UTC-03:30) Newfoundland', 'America/Sao_Paulo' => '(UTC-03:00) Brasilia', 'America/Argentina/Buenos_Aires' => '(UTC-03:00) Buenos Aires', 'America/Argentina/Buenos_Aires' => '(UTC-03:00) Georgetown', 'America/Godthab' => '(UTC-03:00) Greenland', 'America/Noronha' => '(UTC-02:00) Mid-Atlantic', 'Atlantic/Azores' => '(UTC-01:00) Azores', 'Atlantic/Cape_Verde' => '(UTC-01:00) Cape Verde Is.', 'Africa/Casablanca' => '(UTC+00:00) Casablanca', 'Europe/London' => '(UTC+00:00) Edinburgh', 'Etc/Greenwich' => '(UTC+00:00) Greenwich Mean Time : Dublin', 'Europe/Lisbon' => '(UTC+00:00) Lisbon', 'Europe/London' => '(UTC+00:00) London', 'Africa/Monrovia' => '(UTC+00:00) Monrovia', 'UTC' => '(UTC+00:00)','Europe/Amsterdam' => '(UTC+01:00) Amsterdam', 'Europe/Belgrade' => '(UTC+01:00) Belgrade', 'Europe/Berlin' => '(UTC+01:00) Berlin', 'Europe/Berlin' => '(UTC+01:00) Bern', 'Europe/Bratislava' => '(UTC+01:00) Bratislava', 'Europe/Brussels' => '(UTC+01:00) Brussels', 'Europe/Budapest' => '(UTC+01:00) Budapest', 'Europe/Copenhagen' => '(UTC+01:00) Copenhagen', 'Europe/Ljubljana' => '(UTC+01:00) Ljubljana', 'Europe/Madrid' => '(UTC+01:00) Madrid', 'Europe/Paris' => '(UTC+01:00) Paris', 'Europe/Prague' => '(UTC+01:00) Prague', 'Europe/Rome' => '(UTC+01:00) Rome', 'Europe/Sarajevo' => '(UTC+01:00) Sarajevo', 'Europe/Skopje' => '(UTC+01:00) Skopje', 'Europe/Stockholm' => '(UTC+01:00) Stockholm', 'Europe/Vienna' => '(UTC+01:00) Vienna', 'Europe/Warsaw' => '(UTC+01:00) Warsaw', 'Africa/Lagos' => '(UTC+01:00) West Central Africa', 'Europe/Zagreb' => '(UTC+01:00) Zagreb', 'Europe/Athens' => '(UTC+02:00) Athens', 'Europe/Bucharest' => '(UTC+02:00) Bucharest', 'Africa/Cairo' => '(UTC+02:00) Cairo', 'Africa/Harare' => '(UTC+02:00) Harare', 'Europe/Helsinki' => '(UTC+02:00) Helsinki', 'Europe/Istanbul' => '(UTC+02:00) Istanbul', 'Asia/Jerusalem' => '(UTC+02:00) Jerusalem', 'Europe/Helsinki' => '(UTC+02:00) Kyiv', 'Africa/Johannesburg' => '(UTC+02:00) Pretoria', 'Europe/Riga' => '(UTC+02:00) Riga', 'Europe/Sofia' => '(UTC+02:00) Sofia', 'Europe/Tallinn' => '(UTC+02:00) Tallinn', 'Europe/Vilnius' => '(UTC+02:00) Vilnius', 'Asia/Baghdad' => '(UTC+03:00) Baghdad', 'Asia/Kuwait' => '(UTC+03:00) Kuwait', 'Europe/Minsk' => '(UTC+03:00) Minsk', 'Africa/Nairobi' => '(UTC+03:00) Nairobi', 'Asia/Riyadh' => '(UTC+03:00) Riyadh', 'Europe/Volgograd' => '(UTC+03:00) Volgograd', 'Asia/Tehran' => '(UTC+03:30) Tehran', 'Asia/Muscat' => '(UTC+04:00) Abu Dhabi', 'Asia/Baku' => '(UTC+04:00) Baku', 'Europe/Moscow' => '(UTC+04:00) Moscow', 'Asia/Muscat' => '(UTC+04:00) Muscat', 'Europe/Moscow' => '(UTC+04:00) St. Petersburg', 'Asia/Tbilisi' => '(UTC+04:00) Tbilisi', 'Asia/Yerevan' => '(UTC+04:00) Yerevan', 'Asia/Kabul' => '(UTC+04:30) Kabul', 'Asia/Karachi' => '(UTC+05:00) Islamabad', 'Asia/Karachi' => '(UTC+05:00) Karachi', 'Asia/Tashkent' => '(UTC+05:00) Tashkent', 'Asia/Calcutta' => '(UTC+05:30) Chennai', 'Asia/Kolkata' => '(UTC+05:30) Kolkata', 'Asia/Calcutta' => '(UTC+05:30) Mumbai', 'Asia/Calcutta' => '(UTC+05:30) New Delhi', 'Asia/Calcutta' => '(UTC+05:30) Sri Jayawardenepura', 'Asia/Katmandu' => '(UTC+05:45) Kathmandu', 'Asia/Almaty' => '(UTC+06:00) Almaty', 'Asia/Dhaka' => '(UTC+06:00) Astana', 'Asia/Dhaka' => '(UTC+06:00) Dhaka', 'Asia/Yekaterinburg' => '(UTC+06:00) Ekaterinburg', 'Asia/Rangoon' => '(UTC+06:30) Rangoon', 'Asia/Bangkok' => '(UTC+07:00) Bangkok', 'Asia/Bangkok' => '(UTC+07:00) Hanoi', 'Asia/Jakarta' => '(UTC+07:00) Jakarta', 'Asia/Novosibirsk' => '(UTC+07:00) Novosibirsk', 'Asia/Hong_Kong' => '(UTC+08:00) Beijing', 'Asia/Chongqing' => '(UTC+08:00) Chongqing', 'Asia/Hong_Kong' => '(UTC+08:00) Hong Kong', 'Asia/Krasnoyarsk' => '(UTC+08:00) Krasnoyarsk', 'Asia/Kuala_Lumpur' => '(UTC+08:00) Kuala Lumpur', 'Australia/Perth' => '(UTC+08:00) Perth', 'Asia/Singapore' => '(UTC+08:00) Singapore', 'Asia/Taipei' => '(UTC+08:00) Taipei', 'Asia/Ulan_Bator' => '(UTC+08:00) Ulaan Bataar', 'Asia/Urumqi' => '(UTC+08:00) Urumqi', 'Asia/Irkutsk' => '(UTC+09:00) Irkutsk', 'Asia/Tokyo' => '(UTC+09:00) Osaka', 'Asia/Tokyo' => '(UTC+09:00) Sapporo', 'Asia/Seoul' => '(UTC+09:00) Seoul', 'Asia/Tokyo' => '(UTC+09:00) Tokyo', 'Australia/Adelaide' => '(UTC+09:30) Adelaide', 'Australia/Darwin' => '(UTC+09:30) Darwin', 'Australia/Brisbane' => '(UTC+10:00) Brisbane', 'Australia/Canberra' => '(UTC+10:00) Canberra', 'Pacific/Guam' => '(UTC+10:00) Guam', 'Australia/Hobart' => '(UTC+10:00) Hobart', 'Australia/Melbourne' => '(UTC+10:00) Melbourne', 'Pacific/Port_Moresby' => '(UTC+10:00) Port Moresby', 'Australia/Sydney' => '(UTC+10:00) Sydney', 'Asia/Yakutsk' => '(UTC+10:00) Yakutsk', 'Asia/Vladivostok' => '(UTC+11:00) Vladivostok', 'Pacific/Auckland' => '(UTC+12:00) Auckland', 'Pacific/Fiji' => '(UTC+12:00) Fiji', 'Pacific/Kwajalein' => '(UTC+12:00) International Date Line West', 'Asia/Kamchatka' => '(UTC+12:00) Kamchatka', 'Asia/Magadan' => '(UTC+12:00) Magadan', 'Pacific/Fiji' => '(UTC+12:00) Marshall Is.', 'Asia/Magadan' => '(UTC+12:00) New Caledonia', 'Asia/Magadan' => '(UTC+12:00) Solomon Is.', 'Pacific/Auckland' => '(UTC+12:00) Wellington', 'Pacific/Tongatapu' => '(UTC+13:00) Nuku\'alofa');
		if(empty($timezone) || stristr($timezone, 'UTC+') || stristr($timezone, 'UTC-') ) {
			$timezone = 'UTC';
		}
		$date = new DateTime('now', new DateTimeZone($timezone));	
		
		$localtime = $date->format('h:i:s a');
		echo '<select id="timezone" name="wooshopping-options[timezone]">';
		foreach ($alltimezone as $key => $value) {
			echo '<option value="'.$key.'"';
			if($timezone == $key) { echo 'selected'; }
			echo '>'.$value.'</option>';
		}
		echo "</select><br>Local time is $localtime.";

	}

	public function wooshopping_time_format_callback()
	{
		
		echo '<select id="timeformat" name="wooshopping-options[timeformat]"><option value="12 hours"';
			if($this->options["timeformat"]=="12 hours") { echo 'selected'; }
			echo '>12 hours</option><option value="24 hours"';
			if($this->options["timeformat"]=="24 hours") { echo 'selected'; }
			echo '>24 hours</option>
		</select>';
	}

	public function wooshopping_monday_callback()
	{
		printf(
			'<input type="text" id="mondayfrom" class="wooshopping-input" name="wooshopping-options[mondayfrom]" value="%s" />
			 <input type="text" id="mondayto" class="wooshopping-input" name="wooshopping-options[mondayto]" value="%s" />',
			isset( $this->options['mondayfrom'] ) ? esc_attr( $this->options['mondayfrom']) : '',
			isset( $this->options['mondayto'] ) ? esc_attr( $this->options['mondayto']) : ''
		);
	}

	/** 
	 * Get the settings option array and print one of its values
	 */
	public function wooshopping_tuesday_callback()
	{
		printf(
			'<input type="text" id="tuesdayfrom" class="wooshopping-input" name="wooshopping-options[tuesdayfrom]" value="%s" />
			 <input type="text" id="tuesdayto" class="wooshopping-input" name="wooshopping-options[tuesdayto]" value="%s" />',
			isset( $this->options['tuesdayfrom'] ) ? esc_attr( $this->options['tuesdayfrom']) : '',
			isset( $this->options['tuesdayto'] ) ? esc_attr( $this->options['tuesdayto']) : ''
		);
	}

	/** 
	 * Get the settings option array and print one of its values
	 */
	public function wooshopping_wednesday_callback()
	{
		printf(
			'<input type="text" id="wednesdayfrom" class="wooshopping-input" name="wooshopping-options[wednesdayfrom]" value="%s" />
			 <input type="text" id="wednesdayto" class="wooshopping-input" name="wooshopping-options[wednesdayto]" value="%s" />',
			isset( $this->options['wednesdayfrom'] ) ? esc_attr( $this->options['wednesdayfrom']) : '',
			isset( $this->options['wednesdayto'] ) ? esc_attr( $this->options['wednesdayto']) : ''
		);
	}

	/** 
	 * Get the settings option array and print one of its values
	 */
	public function wooshopping_thursday_callback()
	{
		printf(
			'<input type="text" id="thursdayfrom" class="wooshopping-input" name="wooshopping-options[thursdayfrom]" value="%s" />
			 <input type="text" id="thursdayto" class="wooshopping-input" name="wooshopping-options[thursdayto]" value="%s" />',
			isset( $this->options['thursdayfrom'] ) ? esc_attr( $this->options['thursdayfrom']) : '',
			isset( $this->options['thursdayto'] ) ? esc_attr( $this->options['thursdayto']) : ''
		);
	}

	/** 
	 * Get the settings option array and print one of its values
	 */
	public function wooshopping_friday_callback()
	{
		printf(
			'<input type="text" id="fridayfrom" class="wooshopping-input" name="wooshopping-options[fridayfrom]" value="%s" />
			 <input type="text" id="fridayto" class="wooshopping-input" name="wooshopping-options[fridayto]" value="%s" />',
			isset( $this->options['fridayfrom'] ) ? esc_attr( $this->options['fridayfrom']) : '',
			isset( $this->options['fridayto'] ) ? esc_attr( $this->options['fridayto']) : ''
		);
	}

	/** 
	 * Get the settings option array and print one of its values
	 */
	public function wooshopping_saturday_callback()
	{
		printf(
			'<input type="text" id="saturdayfrom" class="wooshopping-input" name="wooshopping-options[saturdayfrom]" value="%s" />
			 <input type="text" id="saturdayto" class="wooshopping-input" name="wooshopping-options[saturdayto]" value="%s" />',
			isset( $this->options['saturdayfrom'] ) ? esc_attr( $this->options['saturdayfrom']) : '',
			isset( $this->options['saturdayto'] ) ? esc_attr( $this->options['saturdayto']) : ''
		);
	}

	/** 
	 * Get the settings option array and print one of its values
	 */
	public function wooshopping_sunday_callback()
	{
		printf(
			'<input type="text" id="sundayfrom" class="wooshopping-input" name="wooshopping-options[sundayfrom]" value="%s" />
			 <input type="text" id="sundayto" class="wooshopping-input" name="wooshopping-options[sundayto]" value="%s" />',
			isset( $this->options['sundayfrom'] ) ? esc_attr( $this->options['sundayfrom']) : '',
			isset( $this->options['sundayto'] ) ? esc_attr( $this->options['sundayto']) : ''
		);
	}

	/** 
	 * Get the settings option array and print one of its values
	 */
	public function wooshopping_genrated_shortcode_callback()
	{
		echo '<textarea id="genrated-shortcode" onclick="this.focus();this.select()" name="genrated-shortcode" rows="8" cols="50" readonly></textarea>
			<p id="boh-message">Copy and Paste above shortcode. You can change title attribute as you wish.</p>';
	}

	public function wooshopping_highlight_bgcolor_callback()
	{
		printf('<p><label>Select Background Color&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></p><p><input type="text" id="wooshoppingbgcolor" name="wooshopping-options[wooshoppingbgcolor]" value="%s" class="wooshopping-highlight-color" data-default-color="#000000" /></p>',
			isset( $this->options['wooshoppingbgcolor'] ) ? esc_attr( $this->options['wooshoppingbgcolor']) : '#000000'
		);
	}

	public function wooshopping_highlight_color_callback()
	{
		printf('<p><label>Select Font Color&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></p><p><input type="text" id="wooshoppingfontcolor" name="wooshopping-options[wooshoppingfontcolor]" value="%s" class="wooshopping-highlight-font-color" data-default-color="#ffffff" /></p>',
			isset( $this->options['wooshoppingfontcolor'] ) ? esc_attr( $this->options['wooshoppingfontcolor']) : '#ffffff'
		);
	}
}

/**** Instantiate Class ****/
if( is_admin() )
	$wooshopping_settings_page = new WooShoppingSettingPage();

/**** Include Admin Style ****/
function wooshopping_admin_style() {
	// Color Picker JS
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_style( 'wp-color-picker' );
	// Timepicker JS
	wp_enqueue_script('wooshopping-timepicker-js', plugins_url('js/jquery.timepicker.min.js',__FILE__), true );
	// Admin Custom CSS
	wp_enqueue_style('wooshopping-admin-style', plugins_url('css/wooshopping-hours-admin.css',__FILE__), false, '1.0.0' );
}
add_action( 'admin_enqueue_scripts', 'wooshopping_admin_style' );

function wooshopping_admin_custom_script() {
	
	if(isset($_REQUEST['page']) && $_REQUEST['page']=="wooshopping-setting-admin")
		include('js/admin-custom-js.php'); // Admin Custom JS
}
add_action( 'wp_before_admin_bar_render', 'wooshopping_admin_custom_script' );

function wooshopping_front_styles() {
    wp_enqueue_style('wooshopping-front-style', plugins_url('css/wooshopping-hours.css',__FILE__), false, '1.0.0' );
}
add_action( 'wp_footer', 'wooshopping_front_styles' );

/**** Include WooShopping Hours Widget ****/
include ('include/wooshopping-hours-widget.php');
include ('include/wooshopping-hours-shortcode.php');
include ('include/wooshopping-add-item.php');
?>