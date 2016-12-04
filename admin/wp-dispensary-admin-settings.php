<?php
/**
 * Adding the Admin Settings Page
 *
 * @link       https://www.wpdispensary.com
 * @since      1.6.0
 *
 * @package    WP_Dispensary
 * @subpackage WP_Dispensary/admin
 */

class WPDispensarySettings {
	private $wp_dispensary_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'wp_dispensary_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'wp_dispensary_page_init' ) );
	}

	public function wp_dispensary_add_plugin_page() {
		add_menu_page(
			'WP Dispensary', // page_title
			'WP Dispensary', // menu_title
			'manage_options', // capability
			'wpd-settings', // menu_slug
			array( $this, 'wp_dispensary_create_admin_page' ), // function
			plugin_dir_url( __FILE__ ) . ( 'images/menu-icon.png' ), // icon_url
			100 // position
		);
	}

	public function wp_dispensary_create_admin_page() {
		$this->wp_dispensary_options = get_option( 'wp_dispensary_option_name' ); ?>

		<div class="wpd-settings-wrap">
			<div class="wpd-settings-page-ads">
			<?php if( ! class_exists( 'WPD_Inventory' ) || ! class_exists( 'WPD_TopSellers' ) ) { ?>
				<h1>Premium Add-Ons</h1>
			<?php } ?>
			<?php if( ! class_exists( 'WPD_Inventory' ) ) { ?>
				<a href="https://www.wpdispensary.com/downloads/dispensary-inventory-management" target="_blank"><img src="<?php $url = plugins_url(); echo $url; ?>/wp-dispensary/admin/images/ad_dispensary-inventory.png" /></a>
			<?php } ?>
			<?php if( ! class_exists( 'WPD_TopSellers' ) ) { ?>
				<a href="https://www.wpdispensary.com/downloads/dispensary-top-sellers" target="_blank"><img src="<?php $url = plugins_url(); echo $url; ?>/wp-dispensary/admin/images/ad_dispensary-topsellers.png" /></a>
			<?php } ?>
			</div>
			<div class="wpd-settings-content">
				<img src="<?php $url = plugins_url(); echo $url; ?>/wp-dispensary/admin/images/wpd-logo.png" />
				<p>Settings page for the WP Dispensary plugin</p>
				<?php settings_errors(); ?>

				<form method="post" action="options.php">
					<?php
						settings_fields( 'wp_dispensary_option_group' );
						do_settings_sections( 'wp-dispensary-admin' );
						submit_button();
					?>
				</form>
			</div>
		</div>
	<?php }

	public function wp_dispensary_page_init() {
		register_setting(
			'wp_dispensary_option_group', // option_group
			'wp_dispensary_option_name', // option_name
			array( $this, 'wp_dispensary_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'wp_dispensary_setting_section', // id
			'Settings', // title
			array( $this, 'wp_dispensary_section_info' ), // callback
			'wp-dispensary-admin' // page
		);

		add_settings_field(
			'wpd_hide_details', // id
			'Hide details table', // title
			array( $this, 'wpd_hide_details_callback' ), // callback
			'wp-dispensary-admin', // page
			'wp_dispensary_setting_section' // section
		);

		add_settings_field(
			'wpd_hide_pricing', // id
			'Hide pricing table', // title
			array( $this, 'wpd_hide_pricing_callback' ), // callback
			'wp-dispensary-admin', // page
			'wp_dispensary_setting_section' // section
		);

		add_settings_field(
			'wpd_content_placement', // id
			'Move content', // title
			array( $this, 'wpd_content_placement_callback' ), // callback
			'wp-dispensary-admin', // page
			'wp_dispensary_setting_section' // section
		);

		add_settings_field(
			'wpd_currency', // id
			'Currency code', // title
			array( $this, 'wpd_currency_callback' ), // callback
			'wp-dispensary-admin', // page
			'wp_dispensary_setting_section' // section
		);

		add_settings_field(
			'wpd_cost_phrase', // id
			'Cost phrase', // title
			array( $this, 'wpd_cost_phrase_callback' ), // callback
			'wp-dispensary-admin', // page
			'wp_dispensary_setting_section' // section
		);
	}

	public function wp_dispensary_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['wpd_hide_details'] ) ) {
			$sanitary_values['wpd_hide_details'] = $input['wpd_hide_details'];
		}

		if ( isset( $input['wpd_hide_pricing'] ) ) {
			$sanitary_values['wpd_hide_pricing'] = $input['wpd_hide_pricing'];
		}

		if ( isset( $input['wpd_content_placement'] ) ) {
			$sanitary_values['wpd_content_placement'] = $input['wpd_content_placement'];
		}

		if ( isset( $input['wpd_currency'] ) ) {
			$sanitary_values['wpd_currency'] = $input['wpd_currency'];
		}

		if ( isset( $input['wpd_cost_phrase'] ) ) {
			$sanitary_values['wpd_cost_phrase'] = $input['wpd_cost_phrase'];
		}

		return $sanitary_values;
	}

	public function wp_dispensary_section_info() {
		
	}

	public function wpd_hide_details_callback() {
		printf(
			'<input type="checkbox" name="wp_dispensary_option_name[wpd_hide_details]" id="wpd_hide_details" value="wpd_hide_details" %s> <label for="wpd_hide_details">hide details from data output</label>',
			( isset( $this->wp_dispensary_options['wpd_hide_details'] ) && $this->wp_dispensary_options['wpd_hide_details'] === 'wpd_hide_details' ) ? 'checked' : ''
		);
	}

	public function wpd_hide_pricing_callback() {
		printf(
			'<input type="checkbox" name="wp_dispensary_option_name[wpd_hide_pricing]" id="wpd_hide_pricing" value="wpd_hide_pricing" %s> <label for="wpd_hide_pricing">hide pricing from data output</label>',
			( isset( $this->wp_dispensary_options['wpd_hide_pricing'] ) && $this->wp_dispensary_options['wpd_hide_pricing'] === 'wpd_hide_pricing' ) ? 'checked' : ''
		);
	}

	public function wpd_content_placement_callback() {
		printf(
			'<input type="checkbox" name="wp_dispensary_option_name[wpd_content_placement]" id="wpd_content_placement" value="wpd_content_placement" %s> <label for="wpd_content_placement">move all menu info below the_content</label>',
			( isset( $this->wp_dispensary_options['wpd_content_placement'] ) && $this->wp_dispensary_options['wpd_content_placement'] === 'wpd_content_placement' ) ? 'checked' : ''
		);
	}

	public function wpd_currency_callback() {
		?> <select name="wp_dispensary_option_name[wpd_currency]" id="wpd_currency">
			<?php $selected = (isset( $this->wp_dispensary_options['wpd_currency'] ) && $this->wp_dispensary_options['wpd_currency'] === 'AUD') ? 'selected' : '' ; ?>
			<option value="AUD" <?php echo $selected; ?>>(AUD) Australian Dollar</option>
			<?php $selected = (isset( $this->wp_dispensary_options['wpd_currency'] ) && $this->wp_dispensary_options['wpd_currency'] === 'BRL') ? 'selected' : '' ; ?>
			<option value="BRL" <?php echo $selected; ?>>(BRL) Brazilian Real</option>
			<?php $selected = (isset( $this->wp_dispensary_options['wpd_currency'] ) && $this->wp_dispensary_options['wpd_currency'] === 'CAD') ? 'selected' : '' ; ?>
			<option value="CAD" <?php echo $selected; ?>>(CAD) Canadian Dollar</option>
			<?php $selected = (isset( $this->wp_dispensary_options['wpd_currency'] ) && $this->wp_dispensary_options['wpd_currency'] === 'CZK') ? 'selected' : '' ; ?>
			<option value="CZK" <?php echo $selected; ?>>(CZK) Czech Koruna</option>
			<?php $selected = (isset( $this->wp_dispensary_options['wpd_currency'] ) && $this->wp_dispensary_options['wpd_currency'] === 'DKK') ? 'selected' : '' ; ?>
			<option value="DKK" <?php echo $selected; ?>>(DKK) Danish Krone</option>
			<?php $selected = (isset( $this->wp_dispensary_options['wpd_currency'] ) && $this->wp_dispensary_options['wpd_currency'] === 'EUR') ? 'selected' : '' ; ?>
			<option value="EUR" <?php echo $selected; ?>>(EUR) Euro</option>
			<?php $selected = (isset( $this->wp_dispensary_options['wpd_currency'] ) && $this->wp_dispensary_options['wpd_currency'] === 'HKD') ? 'selected' : '' ; ?>
			<option value="HKD" <?php echo $selected; ?>>(HKD) Hong Kong Dollar</option>
			<?php $selected = (isset( $this->wp_dispensary_options['wpd_currency'] ) && $this->wp_dispensary_options['wpd_currency'] === 'HUF') ? 'selected' : '' ; ?>
			<option value="HUF" <?php echo $selected; ?>>(HUF) Hungarian Forint</option>
			<?php $selected = (isset( $this->wp_dispensary_options['wpd_currency'] ) && $this->wp_dispensary_options['wpd_currency'] === 'ILS') ? 'selected' : '' ; ?>
			<option value="ILS" <?php echo $selected; ?>>(ILS) Israeli New Sheqel</option>
			<?php $selected = (isset( $this->wp_dispensary_options['wpd_currency'] ) && $this->wp_dispensary_options['wpd_currency'] === 'JPY') ? 'selected' : '' ; ?>
			<option value="JPY" <?php echo $selected; ?>>(JPY) Japanese Yen</option>
			<?php $selected = (isset( $this->wp_dispensary_options['wpd_currency'] ) && $this->wp_dispensary_options['wpd_currency'] === 'MYR') ? 'selected' : '' ; ?>
			<option value="MYR" <?php echo $selected; ?>>(MYR) Malaysian Ringgit</option>
			<?php $selected = (isset( $this->wp_dispensary_options['wpd_currency'] ) && $this->wp_dispensary_options['wpd_currency'] === 'MXN') ? 'selected' : '' ; ?>
			<option value="MXN" <?php echo $selected; ?>>(MXN) Mexican Peso</option>
			<?php $selected = (isset( $this->wp_dispensary_options['wpd_currency'] ) && $this->wp_dispensary_options['wpd_currency'] === 'NOK') ? 'selected' : '' ; ?>
			<option value="NOK" <?php echo $selected; ?>>(NOK) Norwegian Krone</option>
			<?php $selected = (isset( $this->wp_dispensary_options['wpd_currency'] ) && $this->wp_dispensary_options['wpd_currency'] === 'NZD') ? 'selected' : '' ; ?>
			<option value="NZD" <?php echo $selected; ?>>(NZD) New Zealand Dollar</option>
			<?php $selected = (isset( $this->wp_dispensary_options['wpd_currency'] ) && $this->wp_dispensary_options['wpd_currency'] === 'PHP') ? 'selected' : '' ; ?>
			<option value="PHP" <?php echo $selected; ?>>(PHP) Philippine Peso</option>
			<?php $selected = (isset( $this->wp_dispensary_options['wpd_currency'] ) && $this->wp_dispensary_options['wpd_currency'] === 'PLN') ? 'selected' : '' ; ?>
			<option value="PLN" <?php echo $selected; ?>>(PLN) Polish Zloty</option>
			<?php $selected = (isset( $this->wp_dispensary_options['wpd_currency'] ) && $this->wp_dispensary_options['wpd_currency'] === 'GBP') ? 'selected' : '' ; ?>
			<option value="GBP" <?php echo $selected; ?>>(GBP) Pound Sterling</option>
			<?php $selected = (isset( $this->wp_dispensary_options['wpd_currency'] ) && $this->wp_dispensary_options['wpd_currency'] === 'SGD') ? 'selected' : '' ; ?>
			<option value="SGD" <?php echo $selected; ?>>(SGD) Singapore Dollar</option>
			<?php $selected = (isset( $this->wp_dispensary_options['wpd_currency'] ) && $this->wp_dispensary_options['wpd_currency'] === 'SEK') ? 'selected' : '' ; ?>
			<option value="SEK" <?php echo $selected; ?>>(SEK) Swedish Krona</option>
			<?php $selected = (isset( $this->wp_dispensary_options['wpd_currency'] ) && $this->wp_dispensary_options['wpd_currency'] === 'CHF') ? 'selected' : '' ; ?>
			<option value="CHF" <?php echo $selected; ?>>(CHF) Swiss Franc</option>
			<?php $selected = (isset( $this->wp_dispensary_options['wpd_currency'] ) && $this->wp_dispensary_options['wpd_currency'] === 'TWD') ? 'selected' : '' ; ?>
			<option value="TWD" <?php echo $selected; ?>>(TWD) Taiwan New Dollar</option>
			<?php $selected = (isset( $this->wp_dispensary_options['wpd_currency'] ) && $this->wp_dispensary_options['wpd_currency'] === 'THB') ? 'selected' : '' ; ?>
			<option value="THB" <?php echo $selected; ?>>(THB) Thai Baht</option>
			<?php $selected = (isset( $this->wp_dispensary_options['wpd_currency'] ) && $this->wp_dispensary_options['wpd_currency'] === 'TRY') ? 'selected' : '' ; ?>
			<option value="TRY" <?php echo $selected; ?>>(TRY) Turkish Lira</option>
			<?php $selected = (isset( $this->wp_dispensary_options['wpd_currency'] ) && $this->wp_dispensary_options['wpd_currency'] === 'USD') ? 'selected' : '' ; ?>
			<option value="USD" <?php echo $selected; ?>>(USD) U.S. Dollar</option>
		</select> <?php
	}

	public function wpd_cost_phrase_callback() {
		?> <select name="wp_dispensary_option_name[wpd_cost_phrase]" id="wpd_cost_phrase">
			<?php $selected = (isset( $this->wp_dispensary_options['wpd_cost_phrase'] ) && $this->wp_dispensary_options['wpd_cost_phrase'] === 'Price') ? 'selected' : '' ; ?>
			<option value="Price" <?php echo $selected; ?>>Price</option>
			<?php $selected = (isset( $this->wp_dispensary_options['wpd_cost_phrase'] ) && $this->wp_dispensary_options['wpd_cost_phrase'] === 'Donation') ? 'selected' : '' ; ?>
			<option value="Donation" <?php echo $selected; ?>>Donation</option>
		</select> <?php
	}

}
if ( is_admin() )
	$wp_dispensary = new WPDispensarySettings();

/* 
 * Retrieve this value with:
 * $wp_dispensary_options = get_option( 'wp_dispensary_option_name' ); // Array of All Options
 * $wpd_hide_details = $wp_dispensary_options['wpd_hide_details']; // hidedetails
 * $wpd_hide_pricing = $wp_dispensary_options['wpd_hide_pricing']; // hidepricing
 * $wpd_content_placement = $wp_dispensary_options['wpd_content_placement']; // movecontent
 * $wpd_currency = $wp_dispensary_options['wpd_currency']; // currencycode
 * $wpd_cost_phrase = $wp_dispensary_options['wpd_cost_phrase']; // costphrase
 */
