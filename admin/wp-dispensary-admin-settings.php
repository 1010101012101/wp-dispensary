<?php
/**
 * Adding the Admin Settings Page
 *
 * @link       http://www.wpdispensary.com
 * @since      1.6.0
 *
 * @package    WP_Dispensary
 * @subpackage WP_Dispensary/admin
 */

/**
 * Creating the menu item
 */
add_action( 'admin_menu', 'wpd_settings_add_admin_menu' );
add_action( 'admin_init', 'wpd_settings_settings_init' );


function wpd_settings_add_admin_menu(  ) { 

	add_menu_page(
		'WP Dispensary',
		'WP Dispensary',
		'manage_options',
		'wp_dispensary',
		'wpd_settings_options_page',
		plugin_dir_url( __FILE__ ) . ( '/images/menu-icon.png' )
	);

}


function wpd_settings_settings_init(  ) { 

	register_setting( 'wpdsettings', 'wpd_settings_settings' );

	add_settings_section(
		'wpd_settings_wpdsettings_section', 
		__( 'Your section description', 'wp-dispensary' ), 
		'wpd_settings_settings_section_callback', 
		'wpdsettings'
	);

	add_settings_field( 
		'wpd_settings_radio_field_0', 
		__( 'Settings field description', 'wp-dispensary' ), 
		'wpd_settings_radio_field_0_render', 
		'wpdsettings', 
		'wpd_settings_wpdsettings_section' 
	);

	add_settings_field( 
		'wpd_settings_radio_field_1', 
		__( 'Settings field description', 'wp-dispensary' ), 
		'wpd_settings_radio_field_1_render', 
		'wpdsettings', 
		'wpd_settings_wpdsettings_section' 
	);

	add_settings_field( 
		'wpd_settings_text_field_2', 
		__( 'Settings field description', 'wp-dispensary' ), 
		'wpd_settings_text_field_2_render', 
		'wpdsettings', 
		'wpd_settings_wpdsettings_section' 
	);

	add_settings_field( 
		'wpd_settings_checkbox_field_3', 
		__( 'Settings field description', 'wp-dispensary' ), 
		'wpd_settings_checkbox_field_3_render', 
		'wpdsettings', 
		'wpd_settings_wpdsettings_section' 
	);

	add_settings_field( 
		'wpd_settings_textarea_field_4', 
		__( 'Settings field description', 'wp-dispensary' ), 
		'wpd_settings_textarea_field_4_render', 
		'wpdsettings', 
		'wpd_settings_wpdsettings_section' 
	);

	add_settings_field( 
		'wpd_settings_select_field_5', 
		__( 'Settings field description', 'wp-dispensary' ), 
		'wpd_settings_select_field_5_render', 
		'wpdsettings', 
		'wpd_settings_wpdsettings_section' 
	);


}


function wpd_settings_radio_field_0_render(  ) {

	$options = get_option( 'wpd_settings_settings' );
	?>
	<input type='radio' name='wpd_settings_settings[wpd_settings_radio_field_0]' <?php checked( $options['wpd_settings_radio_field_0'], 1 ); ?> value='1'>
	<?php

}


function wpd_settings_radio_field_1_render(  ) {

	$options = get_option( 'wpd_settings_settings' );
	?>
	<input type='radio' name='wpd_settings_settings[wpd_settings_radio_field_1]' <?php checked( $options['wpd_settings_radio_field_1'], 1 ); ?> value='1'>
	<?php

}


function wpd_settings_text_field_2_render(  ) {

	$options = get_option( 'wpd_settings_settings' );
	?>
	<input type='text' name='wpd_settings_settings[wpd_settings_text_field_2]' value='<?php echo $options['wpd_settings_text_field_2']; ?>'>
	<?php

}


function wpd_settings_checkbox_field_3_render(  ) { 

	$options = get_option( 'wpd_settings_settings' );
	?>
	<input type='checkbox' name='wpd_settings_settings[wpd_settings_checkbox_field_3]' <?php checked( $options['wpd_settings_checkbox_field_3'], 1 ); ?> value='1'>
	<?php

}


function wpd_settings_textarea_field_4_render(  ) { 

	$options = get_option( 'wpd_settings_settings' );
	?>
	<textarea cols='40' rows='5' name='wpd_settings_settings[wpd_settings_textarea_field_4]'> 
		<?php echo $options['wpd_settings_textarea_field_4']; ?>
 	</textarea>
	<?php

}


function wpd_settings_select_field_5_render(  ) { 

	$options = get_option( 'wpd_settings_settings' );
	?>
	<select name='wpd_settings_settings[wpd_settings_select_field_5]'>
		<option value='1' <?php selected( $options['wpd_settings_select_field_5'], 1 ); ?>>Option 1</option>
		<option value='2' <?php selected( $options['wpd_settings_select_field_5'], 2 ); ?>>Option 2</option>
	</select>

<?php

}


function wpd_settings_settings_section_callback(  ) { 

	echo __( 'This section description', 'wp-dispensary' );

}


function wpd_settings_options_page(  ) { 

	?>
	<form action='options.php' method='post' class="wpd-settings">

		<p><img src="<?php echo plugin_dir_url( __FILE__ ) . ( '/images/wpd-logo.png' ); ?>" alt="WP Dispensary logo" class="wpd-settings-logo" /></p>

		<?php
			settings_fields( 'wpdsettings' );
			do_settings_sections( 'wpdsettings' );
			submit_button();
		?>

	</form>
	<?php

}

?>