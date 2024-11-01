<?php $wooshopping_options = get_option( "wooshopping-options" ); ?>

<script type="text/javascript">
	jQuery(document).ready(function() {
	'use strict';

		/******TIME FORMAT******/
		
		jQuery('#timeformat').change(function() {
			if(this.value == "24 hours") {
				jQuery('.wooshopping-input').timepicker('remove');
				jQuery('.wooshopping-input').timepicker({'timeFormat': 'G:i' });
			}	
			else {
				jQuery('.wooshopping-input').timepicker('remove');
				jQuery('.wooshopping-input').timepicker({'timeFormat': 'g:i A' });
			}
		});

		/******DEFAULT TIME FORMAT******/

		var value = '<?php echo $wooshopping_options["timeformat"]; ?>';
		if( value == '12 hours' || value == '' ) {
			jQuery('.wooshopping-input').timepicker({'timeFormat': 'g:i A'  });
		}
		else {
			jQuery('.wooshopping-input').timepicker({'timeFormat': 'G:i'  });
		}

		jQuery('#mondayfrom').val('<?php echo $wooshopping_options["mondayfrom"]; ?>');
		jQuery('#mondayto').val('<?php echo $wooshopping_options["mondayto"]; ?>');
		jQuery('#tuesdayfrom').val('<?php echo $wooshopping_options["tuesdayfrom"]; ?>');
		jQuery('#tuesdayto').val('<?php echo $wooshopping_options["tuesdayto"]; ?>');
		jQuery('#wednesdayfrom').val('<?php echo $wooshopping_options["wednesdayfrom"]; ?>');
		jQuery('#wednesdayto').val('<?php echo $wooshopping_options["wednesdayto"]; ?>');
		jQuery('#thursdayfrom').val('<?php echo $wooshopping_options["thursdayfrom"]; ?>');
		jQuery('#thursdayto').val('<?php echo $wooshopping_options["thursdayto"]; ?>');
		jQuery('#fridayfrom').val('<?php echo $wooshopping_options["fridayfrom"]; ?>');
		jQuery('#fridayto').val('<?php echo $wooshopping_options["fridayto"]; ?>');
		jQuery('#saturdayfrom').val('<?php echo $wooshopping_options["saturdayfrom"]; ?>');
		jQuery('#saturdayto').val('<?php echo $wooshopping_options["saturdayto"]; ?>');
		jQuery('#sundayfrom').val('<?php echo $wooshopping_options["sundayfrom"]; ?>');
		jQuery('#sundayto').val('<?php echo $wooshopping_options["sundayto"]; ?>');
		jQuery('#wooshoppingbgcolor').val('<?php echo $wooshopping_options["wooshoppingbgcolor"]; ?>');
		jQuery('#wooshoppingfontcolor').val('<?php echo $wooshopping_options["wooshoppingfontcolor"]; ?>');

		/******GENERATE SHORTCODE******/
		function wooshopping_genrate_shortcode(){
			jQuery('#genrated-shortcode').val( "[wooshopping title='Woo Shopping Hours' mondayfrom='"+jQuery('#mondayfrom').val()+"' mondayto='"+jQuery('#mondayto').val()+"' tuesdayfrom='"+jQuery('#tuesdayfrom').val()+"' tuesdayto='"+jQuery('#tuesdayto').val()+"' wednesdayfrom='"+jQuery('#wednesdayfrom').val()+"' wednesdayto='"+jQuery('#wednesdayto').val()+"' thursdayfrom='"+jQuery('#thursdayfrom').val()+"' thursdayto='"+jQuery('#thursdayto').val()+"' fridayfrom='"+jQuery('#fridayfrom').val()+"' fridayto='"+jQuery('#fridayto').val()+"' saturdayfrom='"+jQuery('#saturdayfrom').val()+"' saturdayto='"+jQuery('#saturdayto').val()+"' sundayfrom='"+jQuery('#sundayfrom').val()+"' sundayto='"+jQuery('#sundayto').val()+"' wooshoppingbgcolor='"+jQuery('#wooshoppingbgcolor').val()+"' wooshoppingfontcolor='"+jQuery('#wooshoppingfontcolor').val()+"']" );	
		}

		function wooshopping_genrate_cshortcode(wooshoppingbgcolor, wooshoppingfontcolor){
			jQuery('#genrated-shortcode').val( "[wooshopping title='Woo Shopping Hours' mondayfrom='"+jQuery('#mondayfrom').val()+"' mondayto='"+jQuery('#mondayto').val()+"' tuesdayfrom='"+jQuery('#tuesdayfrom').val()+"' tuesdayto='"+jQuery('#tuesdayto').val()+"' wednesdayfrom='"+jQuery('#wednesdayfrom').val()+"' wednesdayto='"+jQuery('#wednesdayto').val()+"' thursdayfrom='"+jQuery('#thursdayfrom').val()+"' thursdayto='"+jQuery('#thursdayto').val()+"' fridayfrom='"+jQuery('#fridayfrom').val()+"' fridayto='"+jQuery('#fridayto').val()+"' saturdayfrom='"+jQuery('#saturdayfrom').val()+"' saturdayto='"+jQuery('#saturdayto').val()+"' sundayfrom='"+jQuery('#sundayfrom').val()+"' sundayto='"+jQuery('#sundayto').val()+"' wooshoppingbgcolor='"+wooshoppingbgcolor+"' wooshoppingfontcolor='"+wooshoppingfontcolor+"']" );
		}
	

		/******HIGHLIGHT CURRENT DAY COLOR PICKER******/	
		
		jQuery('.wooshopping-highlight-color').wpColorPicker({ defaultColor: '<?php echo $wooshopping_options["wooshoppingbgcolor"]; ?>', change: function(event, ui) {
			wooshopping_genrate_cshortcode( ui.color.toString() , jQuery('#wooshoppingfontcolor').val() );
		}});

		jQuery('.wooshopping-highlight-font-color').wpColorPicker({defaultColor: '<?php echo $wooshopping_options["wooshoppingfontcolor"]; ?>', change: function(event, ui) {
			wooshopping_genrate_cshortcode( jQuery('#wooshoppingbgcolor').val(), ui.color.toString() );
		}});
		
		// On Changing inputs call
		jQuery('#mondayfrom,#mondayto,#tuesdayfrom,#tuesdayto,#wednesdayfrom,#wednesdayto,#thursdayfrom,#thursdayto,#fridayfrom,#fridayto,#saturdayfrom,#saturdayto,#sundayfrom,#sundayto').change(function() {
			wooshopping_genrate_shortcode();
		});

		// Default Call
		wooshopping_genrate_shortcode();
		
	});	
</script>