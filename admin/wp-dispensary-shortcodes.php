<?php
/**
 * Adding the Shortcodes for easy output of content
 * within any theme
 *
 * @link       http://www.wpdispensary.com
 * @since      1.2.0
 *
 * @package    WP_Dispensary
 * @subpackage WP_Dispensary/admin
 */

/**
 * Shortcode Image
 */
if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'dispensary-image', 360, 250, true );
}

/**
 * Flowers Shortcode Fuction
 *
 * @access public
 *
 * @return string HTML markup.
 */
function wpdispensary_flowers_shortcode( $atts ) {

	/* Attributes */
	extract( shortcode_atts(
		array(
			'posts'		=> '100',
			'class'		=> '',
			'name'		=> 'show',
			'info'		=> 'show',
			'title'		=> 'Flowers',
			'category'	=> '',
		),
		$atts
	) );

	/**
	 * Code to create shortcode for Flowers
	 */

	$wpdquery = new WP_Query(
		array(
			'post_type' 		=> 'flowers',
			'posts_per_page'	=> $posts,
			'flowers_category'	=> $category,
		)
	);

	$wpdposts = '<div class="wpdispensary"><h2 class="wpd-title">'. $title .'</h2>';

	while ( $wpdquery->have_posts() ) : $wpdquery->the_post();

		$thumbnail_id 			= get_post_thumbnail_id();
		$thumbnail_url_array	= wp_get_attachment_image_src( $thumbnail_id, 'dispensary-image', true );
		$thumbnail_url			= $thumbnail_url_array[0];
		$querytitle 			= get_the_title();

		/** Get the pricing for Flowers and Concentrates */

		$priceHalfGram			= get_post_meta( get_the_ID(), '_halfgram', true );
		$priceGram				= get_post_meta( get_the_ID(), '_gram', true );
		$priceEighth			= get_post_meta( get_the_ID(), '_eighth', true );
		$priceQuarter			= get_post_meta( get_the_ID(), '_quarter', true );
		$priceHalfOunce			= get_post_meta( get_the_ID(), '_halfounce', true );
		$priceOunce				= get_post_meta( get_the_ID(), '_ounce', true );

		$wp_dispensary_options = get_option( 'wp_dispensary_option_name' ); // Array of All Options
		$wpd_hide_details = $wp_dispensary_options['wpd_hide_details']; // hidedetails
		$wpd_hide_pricing = $wp_dispensary_options['wpd_hide_pricing']; // hidepricing
		$wpd_content_placement = $wp_dispensary_options['wpd_content_placement']; // movecontent
		if ( null === $wp_dispensary_options['wpd_currency'] ) {
			$wpd_currency = 'USD';
		} else {
			$wpd_currency = $wp_dispensary_options['wpd_currency'];
		}
		if ( null === $wp_dispensary_options['wpd_cost_phrase'] ) {
			$wpd_cost_phrase = 'Price';
		} else {
			$wpd_cost_phrase = $wp_dispensary_options['wpd_cost_phrase']; // costphrase
		}

		$currency_symbols = array(
			'AED' => '&#1583;.&#1573;', // ?
			'AFN' => '&#65;&#102;',
			'ALL' => '&#76;&#101;&#107;',
			'AMD' => '',
			'ANG' => '&#402;',
			'AOA' => '&#75;&#122;', // ?
			'ARS' => '&#36;',
			'AUD' => '&#36;',
			'AWG' => '&#402;',
			'AZN' => '&#1084;&#1072;&#1085;',
			'BAM' => '&#75;&#77;',
			'BBD' => '&#36;',
			'BDT' => '&#2547;', // ?
			'BGN' => '&#1083;&#1074;',
			'BHD' => '.&#1583;.&#1576;', // ?
			'BIF' => '&#70;&#66;&#117;', // ?
			'BMD' => '&#36;',
			'BND' => '&#36;',
			'BOB' => '&#36;&#98;',
			'BRL' => '&#82;&#36;',
			'BSD' => '&#36;',
			'BTN' => '&#78;&#117;&#46;', // ?
			'BWP' => '&#80;',
			'BYR' => '&#112;&#46;',
			'BZD' => '&#66;&#90;&#36;',
			'CAD' => '&#36;',
			'CDF' => '&#70;&#67;',
			'CHF' => '&#67;&#72;&#70;',
			'CLF' => '', // ?
			'CLP' => '&#36;',
			'CNY' => '&#165;',
			'COP' => '&#36;',
			'CRC' => '&#8353;',
			'CUP' => '&#8396;',
			'CVE' => '&#36;', // ?
			'CZK' => '&#75;&#269;',
			'DJF' => '&#70;&#100;&#106;', // ?
			'DKK' => '&#107;&#114;',
			'DOP' => '&#82;&#68;&#36;',
			'DZD' => '&#1583;&#1580;', // ?
			'EGP' => '&#163;',
			'ETB' => '&#66;&#114;',
			'EUR' => '&#8364;',
			'FJD' => '&#36;',
			'FKP' => '&#163;',
			'GBP' => '&#163;',
			'GEL' => '&#4314;', // ?
			'GHS' => '&#162;',
			'GIP' => '&#163;',
			'GMD' => '&#68;', // ?
			'GNF' => '&#70;&#71;', // ?
			'GTQ' => '&#81;',
			'GYD' => '&#36;',
			'HKD' => '&#36;',
			'HNL' => '&#76;',
			'HRK' => '&#107;&#110;',
			'HTG' => '&#71;', // ?
			'HUF' => '&#70;&#116;',
			'IDR' => '&#82;&#112;',
			'ILS' => '&#8362;',
			'INR' => '&#8377;',
			'IQD' => '&#1593;.&#1583;', // ?
			'IRR' => '&#65020;',
			'ISK' => '&#107;&#114;',
			'JEP' => '&#163;',
			'JMD' => '&#74;&#36;',
			'JOD' => '&#74;&#68;', // ?
			'JPY' => '&#165;',
			'KES' => '&#75;&#83;&#104;', // ?
			'KGS' => '&#1083;&#1074;',
			'KHR' => '&#6107;',
			'KMF' => '&#67;&#70;', // ?
			'KPW' => '&#8361;',
			'KRW' => '&#8361;',
			'KWD' => '&#1583;.&#1603;', // ?
			'KYD' => '&#36;',
			'KZT' => '&#1083;&#1074;',
			'LAK' => '&#8365;',
			'LBP' => '&#163;',
			'LKR' => '&#8360;',
			'LRD' => '&#36;',
			'LSL' => '&#76;', // ?
			'LTL' => '&#76;&#116;',
			'LVL' => '&#76;&#115;',
			'LYD' => '&#1604;.&#1583;', // ?
			'MAD' => '&#1583;.&#1605;.', // ?
			'MDL' => '&#76;',
			'MGA' => '&#65;&#114;', // ?
			'MKD' => '&#1076;&#1077;&#1085;',
			'MMK' => '&#75;',
			'MNT' => '&#8366;',
			'MOP' => '&#77;&#79;&#80;&#36;', // ?
			'MRO' => '&#85;&#77;', // ?
			'MUR' => '&#8360;', // ?
			'MVR' => '.&#1923;', // ?
			'MWK' => '&#77;&#75;',
			'MXN' => '&#36;',
			'MYR' => '&#82;&#77;',
			'MZN' => '&#77;&#84;',
			'NAD' => '&#36;',
			'NGN' => '&#8358;',
			'NIO' => '&#67;&#36;',
			'NOK' => '&#107;&#114;',
			'NPR' => '&#8360;',
			'NZD' => '&#36;',
			'OMR' => '&#65020;',
			'PAB' => '&#66;&#47;&#46;',
			'PEN' => '&#83;&#47;&#46;',
			'PGK' => '&#75;', // ?
			'PHP' => '&#8369;',
			'PKR' => '&#8360;',
			'PLN' => '&#122;&#322;',
			'PYG' => '&#71;&#115;',
			'QAR' => '&#65020;',
			'RON' => '&#108;&#101;&#105;',
			'RSD' => '&#1044;&#1080;&#1085;&#46;',
			'RUB' => '&#1088;&#1091;&#1073;',
			'RWF' => '&#1585;.&#1587;',
			'SAR' => '&#65020;',
			'SBD' => '&#36;',
			'SCR' => '&#8360;',
			'SDG' => '&#163;', // ?
			'SEK' => '&#107;&#114;',
			'SGD' => '&#36;',
			'SHP' => '&#163;',
			'SLL' => '&#76;&#101;', // ?
			'SOS' => '&#83;',
			'SRD' => '&#36;',
			'STD' => '&#68;&#98;', // ?
			'SVC' => '&#36;',
			'SYP' => '&#163;',
			'SZL' => '&#76;', // ?
			'THB' => '&#3647;',
			'TJS' => '&#84;&#74;&#83;', // ? TJS (guess)
			'TMT' => '&#109;',
			'TND' => '&#1583;.&#1578;',
			'TOP' => '&#84;&#36;',
			'TRY' => '&#8356;', // New Turkey Lira (old symbol used)
			'TTD' => '&#36;',
			'TWD' => '&#78;&#84;&#36;',
			'TZS' => '',
			'UAH' => '&#8372;',
			'UGX' => '&#85;&#83;&#104;',
			'USD' => '&#36;',
			'UYU' => '&#36;&#85;',
			'UZS' => '&#1083;&#1074;',
			'VEF' => '&#66;&#115;',
			'VND' => '&#8363;',
			'VUV' => '&#86;&#84;',
			'WST' => '&#87;&#83;&#36;',
			'XAF' => '&#70;&#67;&#70;&#65;',
			'XCD' => '&#36;',
			'XDR' => '',
			'XOF' => '',
			'XPF' => '&#70;',
			'YER' => '&#65020;',
			'ZAR' => '&#82;',
			'ZMK' => '&#90;&#75;', // ?
			'ZWL' => '&#90;&#36;',
		);

		if ( '' === $priceHalfGram && '' === $priceEighth && '' === $priceQuarter && '' === $priceHalfOunce && '' === $priceOunce ) {
			$pricing = $currency_symbols[ $wpd_currency ] .'' . get_post_meta( get_the_id(), '_gram', true ) . ' per gram';
		} else {
			$pricing = '';
		}

		if ( get_post_meta( get_the_ID(), '_halfgram', true ) ) {
			$pricinglow = $currency_symbols[ $wpd_currency ] . '' . get_post_meta( get_the_id(), '_halfgram', true );
		} elseif ( get_post_meta( get_the_ID(), '_gram', true ) ) {
			$pricinglow = $currency_symbols[ $wpd_currency ] . '' . get_post_meta( get_the_id(), '_gram', true );
		} elseif ( get_post_meta( get_the_ID(), '_eighth', true ) ) {
			$pricinglow = $currency_symbols[ $wpd_currency ] . '' . get_post_meta( get_the_id(), '_eighth', true );
		} elseif ( get_post_meta( get_the_ID(), '_quarter', true ) ) {
			$pricinglow = $currency_symbols[ $wpd_currency ] . '' . get_post_meta( get_the_id(), '_quarter', true );
		} elseif ( get_post_meta( get_the_ID(), '_halfounce', true ) ) {
			$pricinglow = $currency_symbols[ $wpd_currency ] . '' . get_post_meta( get_the_id(), '_halfounce', true );
		}
		$pricingsep = ' - ';
		if ( get_post_meta( get_the_ID(), '_ounce', true ) ) {
			$pricinghigh = $currency_symbols[ $wpd_currency ] . '' . get_post_meta( get_the_id(), '_ounce', true );
		} elseif ( get_post_meta( get_the_ID(), '_halfounce', true ) ) {
			$pricinghigh = $currency_symbols[ $wpd_currency ] . '' . get_post_meta( get_the_id(), '_halfounce', true );
		} elseif ( get_post_meta( get_the_ID(), '_quarter', true ) ) {
			$pricinghigh = $currency_symbols[ $wpd_currency ] . '' . get_post_meta( get_the_id(), '_quarter', true );
		} elseif ( get_post_meta( get_the_ID(), '_eighth', true ) ) {
			$pricinghigh = $currency_symbols[ $wpd_currency ] . '' . get_post_meta( get_the_id(), '_eighth', true );
		} elseif ( get_post_meta( get_the_ID(), '_gram', true ) ) {
			$pricinghigh = $currency_symbols[ $wpd_currency ] . '' . get_post_meta( get_the_id(), '_gram', true );
		}

		/** Check shortcode options input by user */

		if ( 'show' === $name ) {
			$showname = '<p><strong><a href="' . get_permalink() . '">' . $querytitle . '</a></strong></p>';
		} else {
			$showname = '';
		}

		if ( 'show' === $info ) {
			if ( empty( $pricing ) ) {
				$showinfo = '<span class="wpd-productinfo"><strong>'. $wpd_cost_phrase .':</strong> ' . $pricinglow . '' . $pricingsep . '' . $pricinghigh . '</span>';
			} else {
				$showinfo = '<span class="wpd-productinfo"><strong>'. $wpd_cost_phrase .':</strong> ' . $pricing . '</span>';
			}
		} else {
			$showinfo = '';
		}

		/** Shortcode display */

		$wpdposts .= '<div class="wpdshortcode wpd-flowers ' . $class .'"><a href="' . get_permalink() . '"><img src="' . $thumbnail_url . '" alt="Menu - Flower" /></a>'. $showname .''. $showinfo .'</div>';

	endwhile;

	wp_reset_postdata();

	return $wpdposts . '</div>';

}
add_shortcode( 'wpd-flowers', 'wpdispensary_flowers_shortcode' );

/**
 * Concentrates Shortcode Function
 */
function wpdispensary_concentrates_shortcode( $atts ) {

	/** Attributes */
	extract( shortcode_atts(
		array(
			'posts'		=> '100',
			'class'		=> '',
			'name'		=> 'show',
			'info'		=> 'show',
			'title'		=> 'Concentrates',
			'category'	=> '',
		),
		$atts
	) );

	/**
	 * Code to create shortcode for Concentrates
	 */

	$wpdquery = new WP_Query(
		array(
			'post_type' 			=> 'concentrates',
			'posts_per_page'		=> $posts,
			'concentrates_category'	=> $category,
		)
	);

	$wpdposts = '<div class="wpdispensary"><h2 class="wpd-title">'. $title .'</h2>';

	while ( $wpdquery->have_posts() ) : $wpdquery->the_post();

		$thumbnail_id			= get_post_thumbnail_id();
		$thumbnail_url_array	= wp_get_attachment_image_src( $thumbnail_id, 'dispensary-image', true );
		$thumbnail_url			= $thumbnail_url_array[0];
		$querytitle				= get_the_title();

		$wp_dispensary_options = get_option( 'wp_dispensary_option_name' ); // Array of All Options
		$wpd_hide_details = $wp_dispensary_options['wpd_hide_details']; // hidedetails
		$wpd_hide_pricing = $wp_dispensary_options['wpd_hide_pricing']; // hidepricing
		$wpd_content_placement = $wp_dispensary_options['wpd_content_placement']; // movecontent
		if ( null === $wp_dispensary_options['wpd_currency'] ) {
			$wpd_currency = 'USD';
		} else {
			$wpd_currency = $wp_dispensary_options['wpd_currency'];
		}
		if ( null === $wp_dispensary_options['wpd_cost_phrase'] ) {
			$wpd_cost_phrase = 'Price';
		} else {
			$wpd_cost_phrase = $wp_dispensary_options['wpd_cost_phrase']; // costphrase
		}

		$currency_symbols = array(
			'AED' => '&#1583;.&#1573;', // ?
			'AFN' => '&#65;&#102;',
			'ALL' => '&#76;&#101;&#107;',
			'AMD' => '',
			'ANG' => '&#402;',
			'AOA' => '&#75;&#122;', // ?
			'ARS' => '&#36;',
			'AUD' => '&#36;',
			'AWG' => '&#402;',
			'AZN' => '&#1084;&#1072;&#1085;',
			'BAM' => '&#75;&#77;',
			'BBD' => '&#36;',
			'BDT' => '&#2547;', // ?
			'BGN' => '&#1083;&#1074;',
			'BHD' => '.&#1583;.&#1576;', // ?
			'BIF' => '&#70;&#66;&#117;', // ?
			'BMD' => '&#36;',
			'BND' => '&#36;',
			'BOB' => '&#36;&#98;',
			'BRL' => '&#82;&#36;',
			'BSD' => '&#36;',
			'BTN' => '&#78;&#117;&#46;', // ?
			'BWP' => '&#80;',
			'BYR' => '&#112;&#46;',
			'BZD' => '&#66;&#90;&#36;',
			'CAD' => '&#36;',
			'CDF' => '&#70;&#67;',
			'CHF' => '&#67;&#72;&#70;',
			'CLF' => '', // ?
			'CLP' => '&#36;',
			'CNY' => '&#165;',
			'COP' => '&#36;',
			'CRC' => '&#8353;',
			'CUP' => '&#8396;',
			'CVE' => '&#36;', // ?
			'CZK' => '&#75;&#269;',
			'DJF' => '&#70;&#100;&#106;', // ?
			'DKK' => '&#107;&#114;',
			'DOP' => '&#82;&#68;&#36;',
			'DZD' => '&#1583;&#1580;', // ?
			'EGP' => '&#163;',
			'ETB' => '&#66;&#114;',
			'EUR' => '&#8364;',
			'FJD' => '&#36;',
			'FKP' => '&#163;',
			'GBP' => '&#163;',
			'GEL' => '&#4314;', // ?
			'GHS' => '&#162;',
			'GIP' => '&#163;',
			'GMD' => '&#68;', // ?
			'GNF' => '&#70;&#71;', // ?
			'GTQ' => '&#81;',
			'GYD' => '&#36;',
			'HKD' => '&#36;',
			'HNL' => '&#76;',
			'HRK' => '&#107;&#110;',
			'HTG' => '&#71;', // ?
			'HUF' => '&#70;&#116;',
			'IDR' => '&#82;&#112;',
			'ILS' => '&#8362;',
			'INR' => '&#8377;',
			'IQD' => '&#1593;.&#1583;', // ?
			'IRR' => '&#65020;',
			'ISK' => '&#107;&#114;',
			'JEP' => '&#163;',
			'JMD' => '&#74;&#36;',
			'JOD' => '&#74;&#68;', // ?
			'JPY' => '&#165;',
			'KES' => '&#75;&#83;&#104;', // ?
			'KGS' => '&#1083;&#1074;',
			'KHR' => '&#6107;',
			'KMF' => '&#67;&#70;', // ?
			'KPW' => '&#8361;',
			'KRW' => '&#8361;',
			'KWD' => '&#1583;.&#1603;', // ?
			'KYD' => '&#36;',
			'KZT' => '&#1083;&#1074;',
			'LAK' => '&#8365;',
			'LBP' => '&#163;',
			'LKR' => '&#8360;',
			'LRD' => '&#36;',
			'LSL' => '&#76;', // ?
			'LTL' => '&#76;&#116;',
			'LVL' => '&#76;&#115;',
			'LYD' => '&#1604;.&#1583;', // ?
			'MAD' => '&#1583;.&#1605;.', // ?
			'MDL' => '&#76;',
			'MGA' => '&#65;&#114;', // ?
			'MKD' => '&#1076;&#1077;&#1085;',
			'MMK' => '&#75;',
			'MNT' => '&#8366;',
			'MOP' => '&#77;&#79;&#80;&#36;', // ?
			'MRO' => '&#85;&#77;', // ?
			'MUR' => '&#8360;', // ?
			'MVR' => '.&#1923;', // ?
			'MWK' => '&#77;&#75;',
			'MXN' => '&#36;',
			'MYR' => '&#82;&#77;',
			'MZN' => '&#77;&#84;',
			'NAD' => '&#36;',
			'NGN' => '&#8358;',
			'NIO' => '&#67;&#36;',
			'NOK' => '&#107;&#114;',
			'NPR' => '&#8360;',
			'NZD' => '&#36;',
			'OMR' => '&#65020;',
			'PAB' => '&#66;&#47;&#46;',
			'PEN' => '&#83;&#47;&#46;',
			'PGK' => '&#75;', // ?
			'PHP' => '&#8369;',
			'PKR' => '&#8360;',
			'PLN' => '&#122;&#322;',
			'PYG' => '&#71;&#115;',
			'QAR' => '&#65020;',
			'RON' => '&#108;&#101;&#105;',
			'RSD' => '&#1044;&#1080;&#1085;&#46;',
			'RUB' => '&#1088;&#1091;&#1073;',
			'RWF' => '&#1585;.&#1587;',
			'SAR' => '&#65020;',
			'SBD' => '&#36;',
			'SCR' => '&#8360;',
			'SDG' => '&#163;', // ?
			'SEK' => '&#107;&#114;',
			'SGD' => '&#36;',
			'SHP' => '&#163;',
			'SLL' => '&#76;&#101;', // ?
			'SOS' => '&#83;',
			'SRD' => '&#36;',
			'STD' => '&#68;&#98;', // ?
			'SVC' => '&#36;',
			'SYP' => '&#163;',
			'SZL' => '&#76;', // ?
			'THB' => '&#3647;',
			'TJS' => '&#84;&#74;&#83;', // ? TJS (guess)
			'TMT' => '&#109;',
			'TND' => '&#1583;.&#1578;',
			'TOP' => '&#84;&#36;',
			'TRY' => '&#8356;', // New Turkey Lira (old symbol used)
			'TTD' => '&#36;',
			'TWD' => '&#78;&#84;&#36;',
			'TZS' => '',
			'UAH' => '&#8372;',
			'UGX' => '&#85;&#83;&#104;',
			'USD' => '&#36;',
			'UYU' => '&#36;&#85;',
			'UZS' => '&#1083;&#1074;',
			'VEF' => '&#66;&#115;',
			'VND' => '&#8363;',
			'VUV' => '&#86;&#84;',
			'WST' => '&#87;&#83;&#36;',
			'XAF' => '&#70;&#67;&#70;&#65;',
			'XCD' => '&#36;',
			'XDR' => '',
			'XOF' => '',
			'XPF' => '&#70;',
			'YER' => '&#65020;',
			'ZAR' => '&#82;',
			'ZMK' => '&#90;&#75;', // ?
			'ZWL' => '&#90;&#36;',
		);

		/** Get the pricing for Concentrates */

		if ( get_post_meta( get_the_ID(), '_halfgram', true ) ) {
			$pricinglow		= $currency_symbols[ $wpd_currency ] .'' . get_post_meta( get_the_id(), '_halfgram', true );
			$pricingname	= '<strong>1/2 gram: </strong>';
		} elseif ( get_post_meta( get_the_ID(), '_gram', true ) ) {
			$pricinglow		= $currency_symbols[ $wpd_currency ] .'' . get_post_meta( get_the_id(), '_gram', true );
			$pricingname	= '<strong>1 gram: </strong>';
		} elseif ( get_post_meta( get_the_ID(), '_eighth', true ) ) {
			$pricinglow		= $currency_symbols[ $wpd_currency ] .'' . get_post_meta( get_the_id(), '_eighth', true );
			$pricingname	= '<strong>1/8 ounce: </strong>';
		} elseif ( get_post_meta( get_the_ID(), '_quarter', true ) ) {
			$pricinglow		= $currency_symbols[ $wpd_currency ] .'' . get_post_meta( get_the_id(), '_quarter', true );
			$pricingname	= '<strong>1/4 ounce: </strong>';
		} elseif ( get_post_meta( get_the_ID(), '_halfounce', true ) ) {
			$pricinglow		= $currency_symbols[ $wpd_currency ] .'' . get_post_meta( get_the_id(), '_halfounce', true );
			$pricingname	= '<strong>1/2 ounce: </strong>';
		} elseif ( get_post_meta( get_the_ID(), '_ounce', true ) ) {
			$pricinglow		= $currency_symbols[ $wpd_currency ] .'' . get_post_meta( get_the_id(), '_ounce', true );
			$pricingname	= '<strong>1 ounce: </strong>';
		}

		/** Check shortcode options input by user */

		if ( 'show' === $name ) {
			$showname = '<p><strong><a href="' . get_permalink() . '">' . $querytitle . '</a></strong></p>';
		} else {
			$showname = '';
		}

		if ( 'show' === $info ) {
			$showinfo = '<span class="wpd-productinfo">' . $pricingname . '' . $pricinglow . '</span>';
		} else {
			$showinfo = '';
		}

		/** Shortcode display */

		$wpdposts .= '<div class="wpdshortcode wpd-concentrates ' . $class .'"><a href="' . get_permalink() . '"><img src="' . $thumbnail_url . '" alt="Menu - Concentrate" /></a>'. $showname .''. $showinfo .'</div>';

	endwhile;

	wp_reset_postdata();

	return $wpdposts . '</div>';

}
add_shortcode( 'wpd-concentrates', 'wpdispensary_concentrates_shortcode' );

/**
 * Edibles Shortcode Function
 */
function wpdispensary_edibles_shortcode( $atts ) {

	/** Attributes */
	extract( shortcode_atts(
		array(
			'posts'		=> '100',
			'class'		=> '',
			'name'		=> 'show',
			'info'		=> 'show',
			'title'		=> 'Edibles',
			'category'	=> '',
		),
		$atts
	) );

	/**
	 * Code to create shortcode for Edibles
	 */

	$wpdquery = new WP_Query(
		array(
			'post_type' 		=> 'edibles',
			'posts_per_page'	=> $posts,
			'edibles_category'	=> $category,
		)
	);

	$wpdposts = '<div class="wpdispensary"><h2 class="wpd-title">'. $title .'</h2>';

	while ( $wpdquery->have_posts() ) : $wpdquery->the_post();

		$thumbnail_id			= get_post_thumbnail_id();
		$thumbnail_url_array	= wp_get_attachment_image_src( $thumbnail_id, 'dispensary-image', true );
		$thumbnail_url			= $thumbnail_url_array[0];
		$querytitle				= get_the_title();

		$wp_dispensary_options = get_option( 'wp_dispensary_option_name' ); // Array of All Options
		$wpd_hide_details = $wp_dispensary_options['wpd_hide_details']; // hidedetails
		$wpd_hide_pricing = $wp_dispensary_options['wpd_hide_pricing']; // hidepricing
		$wpd_content_placement = $wp_dispensary_options['wpd_content_placement']; // movecontent
		if ( null === $wp_dispensary_options['wpd_currency'] ) {
			$wpd_currency = 'USD';
		} else {
			$wpd_currency = $wp_dispensary_options['wpd_currency'];
		}
		if ( null === $wp_dispensary_options['wpd_cost_phrase'] ) {
			$wpd_cost_phrase = 'Price';
		} else {
			$wpd_cost_phrase = $wp_dispensary_options['wpd_cost_phrase']; // costphrase
		}

		$currency_symbols = array(
			'AED' => '&#1583;.&#1573;', // ?
			'AFN' => '&#65;&#102;',
			'ALL' => '&#76;&#101;&#107;',
			'AMD' => '',
			'ANG' => '&#402;',
			'AOA' => '&#75;&#122;', // ?
			'ARS' => '&#36;',
			'AUD' => '&#36;',
			'AWG' => '&#402;',
			'AZN' => '&#1084;&#1072;&#1085;',
			'BAM' => '&#75;&#77;',
			'BBD' => '&#36;',
			'BDT' => '&#2547;', // ?
			'BGN' => '&#1083;&#1074;',
			'BHD' => '.&#1583;.&#1576;', // ?
			'BIF' => '&#70;&#66;&#117;', // ?
			'BMD' => '&#36;',
			'BND' => '&#36;',
			'BOB' => '&#36;&#98;',
			'BRL' => '&#82;&#36;',
			'BSD' => '&#36;',
			'BTN' => '&#78;&#117;&#46;', // ?
			'BWP' => '&#80;',
			'BYR' => '&#112;&#46;',
			'BZD' => '&#66;&#90;&#36;',
			'CAD' => '&#36;',
			'CDF' => '&#70;&#67;',
			'CHF' => '&#67;&#72;&#70;',
			'CLF' => '', // ?
			'CLP' => '&#36;',
			'CNY' => '&#165;',
			'COP' => '&#36;',
			'CRC' => '&#8353;',
			'CUP' => '&#8396;',
			'CVE' => '&#36;', // ?
			'CZK' => '&#75;&#269;',
			'DJF' => '&#70;&#100;&#106;', // ?
			'DKK' => '&#107;&#114;',
			'DOP' => '&#82;&#68;&#36;',
			'DZD' => '&#1583;&#1580;', // ?
			'EGP' => '&#163;',
			'ETB' => '&#66;&#114;',
			'EUR' => '&#8364;',
			'FJD' => '&#36;',
			'FKP' => '&#163;',
			'GBP' => '&#163;',
			'GEL' => '&#4314;', // ?
			'GHS' => '&#162;',
			'GIP' => '&#163;',
			'GMD' => '&#68;', // ?
			'GNF' => '&#70;&#71;', // ?
			'GTQ' => '&#81;',
			'GYD' => '&#36;',
			'HKD' => '&#36;',
			'HNL' => '&#76;',
			'HRK' => '&#107;&#110;',
			'HTG' => '&#71;', // ?
			'HUF' => '&#70;&#116;',
			'IDR' => '&#82;&#112;',
			'ILS' => '&#8362;',
			'INR' => '&#8377;',
			'IQD' => '&#1593;.&#1583;', // ?
			'IRR' => '&#65020;',
			'ISK' => '&#107;&#114;',
			'JEP' => '&#163;',
			'JMD' => '&#74;&#36;',
			'JOD' => '&#74;&#68;', // ?
			'JPY' => '&#165;',
			'KES' => '&#75;&#83;&#104;', // ?
			'KGS' => '&#1083;&#1074;',
			'KHR' => '&#6107;',
			'KMF' => '&#67;&#70;', // ?
			'KPW' => '&#8361;',
			'KRW' => '&#8361;',
			'KWD' => '&#1583;.&#1603;', // ?
			'KYD' => '&#36;',
			'KZT' => '&#1083;&#1074;',
			'LAK' => '&#8365;',
			'LBP' => '&#163;',
			'LKR' => '&#8360;',
			'LRD' => '&#36;',
			'LSL' => '&#76;', // ?
			'LTL' => '&#76;&#116;',
			'LVL' => '&#76;&#115;',
			'LYD' => '&#1604;.&#1583;', // ?
			'MAD' => '&#1583;.&#1605;.', // ?
			'MDL' => '&#76;',
			'MGA' => '&#65;&#114;', // ?
			'MKD' => '&#1076;&#1077;&#1085;',
			'MMK' => '&#75;',
			'MNT' => '&#8366;',
			'MOP' => '&#77;&#79;&#80;&#36;', // ?
			'MRO' => '&#85;&#77;', // ?
			'MUR' => '&#8360;', // ?
			'MVR' => '.&#1923;', // ?
			'MWK' => '&#77;&#75;',
			'MXN' => '&#36;',
			'MYR' => '&#82;&#77;',
			'MZN' => '&#77;&#84;',
			'NAD' => '&#36;',
			'NGN' => '&#8358;',
			'NIO' => '&#67;&#36;',
			'NOK' => '&#107;&#114;',
			'NPR' => '&#8360;',
			'NZD' => '&#36;',
			'OMR' => '&#65020;',
			'PAB' => '&#66;&#47;&#46;',
			'PEN' => '&#83;&#47;&#46;',
			'PGK' => '&#75;', // ?
			'PHP' => '&#8369;',
			'PKR' => '&#8360;',
			'PLN' => '&#122;&#322;',
			'PYG' => '&#71;&#115;',
			'QAR' => '&#65020;',
			'RON' => '&#108;&#101;&#105;',
			'RSD' => '&#1044;&#1080;&#1085;&#46;',
			'RUB' => '&#1088;&#1091;&#1073;',
			'RWF' => '&#1585;.&#1587;',
			'SAR' => '&#65020;',
			'SBD' => '&#36;',
			'SCR' => '&#8360;',
			'SDG' => '&#163;', // ?
			'SEK' => '&#107;&#114;',
			'SGD' => '&#36;',
			'SHP' => '&#163;',
			'SLL' => '&#76;&#101;', // ?
			'SOS' => '&#83;',
			'SRD' => '&#36;',
			'STD' => '&#68;&#98;', // ?
			'SVC' => '&#36;',
			'SYP' => '&#163;',
			'SZL' => '&#76;', // ?
			'THB' => '&#3647;',
			'TJS' => '&#84;&#74;&#83;', // ? TJS (guess)
			'TMT' => '&#109;',
			'TND' => '&#1583;.&#1578;',
			'TOP' => '&#84;&#36;',
			'TRY' => '&#8356;', // New Turkey Lira (old symbol used)
			'TTD' => '&#36;',
			'TWD' => '&#78;&#84;&#36;',
			'TZS' => '',
			'UAH' => '&#8372;',
			'UGX' => '&#85;&#83;&#104;',
			'USD' => '&#36;',
			'UYU' => '&#36;&#85;',
			'UZS' => '&#1083;&#1074;',
			'VEF' => '&#66;&#115;',
			'VND' => '&#8363;',
			'VUV' => '&#86;&#84;',
			'WST' => '&#87;&#83;&#36;',
			'XAF' => '&#70;&#67;&#70;&#65;',
			'XCD' => '&#36;',
			'XDR' => '',
			'XOF' => '',
			'XPF' => '&#70;',
			'YER' => '&#65020;',
			'ZAR' => '&#82;',
			'ZMK' => '&#90;&#75;', // ?
			'ZWL' => '&#90;&#36;',
		);

		/*
		 * Get the pricing for Edibles
		 */

		if ( get_post_meta( get_the_ID(), '_thcmg', true ) ) {
			$thcmg = ' - <strong>THC: </strong>' . get_post_meta( get_the_id(), '_thcmg', true ) . 'mg';
		}
		$thcsep = ' - ';
		if ( get_post_meta( get_the_ID(), '_thccbdservings', true ) ) {
			$servingcount = ' - <strong>Servings: </strong>' . get_post_meta( get_the_id(), '_thccbdservings', true );
		}
		if ( get_post_meta( get_the_ID(), '_priceeach', true ) ) {
			$priceeach = '<strong>'. $wpd_cost_phrase .':</strong> ' . $currency_symbols[ $wpd_currency ] . '' . get_post_meta( get_the_id(), '_priceeach', true );
		}

		/** Check shortcode options input by user */

		if ( 'show' === $name ) {
			$showname = '<p><strong><a href="' . get_permalink() . '">' . $querytitle . '</a></strong></p>';
		} else {
			$showname = '';
		}

		if ( 'show' === $info ) {
			$showinfo = '<span class="wpd-productinfo">' . $priceeach . '' . $thcmg . '' . $servingcount . '</span>';
		} else {
			$showinfo = '';
		}

		/** Shortcode display */

		$wpdposts .= '<div class="wpdshortcode wpd-edibles ' . $class .'"><a href="' . get_permalink() . '"><img src="' . $thumbnail_url . '" alt="Menu - Edible" /></a>'. $showname .''. $showinfo .'</div>';

	endwhile;

	wp_reset_postdata();

	return $wpdposts . '</div>';

}
add_shortcode( 'wpd-edibles', 'wpdispensary_edibles_shortcode' );

/**
 * Pre-rolls Shortcode Function
 */
function wpdispensary_prerolls_shortcode( $atts ) {

	/** Attributes */
	extract( shortcode_atts(
		array(
			'posts'		=> '100',
			'class'		=> '',
			'name'		=> 'show',
			'info'		=> 'show',
			'title'		=> 'Pre-rolls',
		),
		$atts
	) );

	/**
	 * Code to create shortcode for Pre-rolls
	 */

	$wpdquery = new WP_Query(
		array(
			'post_type' 		=> 'prerolls',
			'posts_per_page'	=> $posts,
		)
	);

	$wpdposts = '<div class="wpdispensary"><h2 class="wpd-title">'. $title .'</h2>';

	while ( $wpdquery->have_posts() ) : $wpdquery->the_post();

		$thumbnail_id			= get_post_thumbnail_id();
		$thumbnail_url_array	= wp_get_attachment_image_src( $thumbnail_id, 'dispensary-image', true );
		$thumbnail_url			= $thumbnail_url_array[0];
		$querytitle 			= get_the_title();

		$wp_dispensary_options = get_option( 'wp_dispensary_option_name' ); // Array of All Options
		$wpd_hide_details = $wp_dispensary_options['wpd_hide_details']; // hidedetails
		$wpd_hide_pricing = $wp_dispensary_options['wpd_hide_pricing']; // hidepricing
		$wpd_content_placement = $wp_dispensary_options['wpd_content_placement']; // movecontent
		if ( null === $wp_dispensary_options['wpd_currency'] ) {
			$wpd_currency = 'USD';
		} else {
			$wpd_currency = $wp_dispensary_options['wpd_currency'];
		}
		if ( null === $wp_dispensary_options['wpd_cost_phrase'] ) {
			$wpd_cost_phrase = 'Price';
		} else {
			$wpd_cost_phrase = $wp_dispensary_options['wpd_cost_phrase']; // costphrase
		}

		$currency_symbols = array(
			'AED' => '&#1583;.&#1573;', // ?
			'AFN' => '&#65;&#102;',
			'ALL' => '&#76;&#101;&#107;',
			'AMD' => '',
			'ANG' => '&#402;',
			'AOA' => '&#75;&#122;', // ?
			'ARS' => '&#36;',
			'AUD' => '&#36;',
			'AWG' => '&#402;',
			'AZN' => '&#1084;&#1072;&#1085;',
			'BAM' => '&#75;&#77;',
			'BBD' => '&#36;',
			'BDT' => '&#2547;', // ?
			'BGN' => '&#1083;&#1074;',
			'BHD' => '.&#1583;.&#1576;', // ?
			'BIF' => '&#70;&#66;&#117;', // ?
			'BMD' => '&#36;',
			'BND' => '&#36;',
			'BOB' => '&#36;&#98;',
			'BRL' => '&#82;&#36;',
			'BSD' => '&#36;',
			'BTN' => '&#78;&#117;&#46;', // ?
			'BWP' => '&#80;',
			'BYR' => '&#112;&#46;',
			'BZD' => '&#66;&#90;&#36;',
			'CAD' => '&#36;',
			'CDF' => '&#70;&#67;',
			'CHF' => '&#67;&#72;&#70;',
			'CLF' => '', // ?
			'CLP' => '&#36;',
			'CNY' => '&#165;',
			'COP' => '&#36;',
			'CRC' => '&#8353;',
			'CUP' => '&#8396;',
			'CVE' => '&#36;', // ?
			'CZK' => '&#75;&#269;',
			'DJF' => '&#70;&#100;&#106;', // ?
			'DKK' => '&#107;&#114;',
			'DOP' => '&#82;&#68;&#36;',
			'DZD' => '&#1583;&#1580;', // ?
			'EGP' => '&#163;',
			'ETB' => '&#66;&#114;',
			'EUR' => '&#8364;',
			'FJD' => '&#36;',
			'FKP' => '&#163;',
			'GBP' => '&#163;',
			'GEL' => '&#4314;', // ?
			'GHS' => '&#162;',
			'GIP' => '&#163;',
			'GMD' => '&#68;', // ?
			'GNF' => '&#70;&#71;', // ?
			'GTQ' => '&#81;',
			'GYD' => '&#36;',
			'HKD' => '&#36;',
			'HNL' => '&#76;',
			'HRK' => '&#107;&#110;',
			'HTG' => '&#71;', // ?
			'HUF' => '&#70;&#116;',
			'IDR' => '&#82;&#112;',
			'ILS' => '&#8362;',
			'INR' => '&#8377;',
			'IQD' => '&#1593;.&#1583;', // ?
			'IRR' => '&#65020;',
			'ISK' => '&#107;&#114;',
			'JEP' => '&#163;',
			'JMD' => '&#74;&#36;',
			'JOD' => '&#74;&#68;', // ?
			'JPY' => '&#165;',
			'KES' => '&#75;&#83;&#104;', // ?
			'KGS' => '&#1083;&#1074;',
			'KHR' => '&#6107;',
			'KMF' => '&#67;&#70;', // ?
			'KPW' => '&#8361;',
			'KRW' => '&#8361;',
			'KWD' => '&#1583;.&#1603;', // ?
			'KYD' => '&#36;',
			'KZT' => '&#1083;&#1074;',
			'LAK' => '&#8365;',
			'LBP' => '&#163;',
			'LKR' => '&#8360;',
			'LRD' => '&#36;',
			'LSL' => '&#76;', // ?
			'LTL' => '&#76;&#116;',
			'LVL' => '&#76;&#115;',
			'LYD' => '&#1604;.&#1583;', // ?
			'MAD' => '&#1583;.&#1605;.', // ?
			'MDL' => '&#76;',
			'MGA' => '&#65;&#114;', // ?
			'MKD' => '&#1076;&#1077;&#1085;',
			'MMK' => '&#75;',
			'MNT' => '&#8366;',
			'MOP' => '&#77;&#79;&#80;&#36;', // ?
			'MRO' => '&#85;&#77;', // ?
			'MUR' => '&#8360;', // ?
			'MVR' => '.&#1923;', // ?
			'MWK' => '&#77;&#75;',
			'MXN' => '&#36;',
			'MYR' => '&#82;&#77;',
			'MZN' => '&#77;&#84;',
			'NAD' => '&#36;',
			'NGN' => '&#8358;',
			'NIO' => '&#67;&#36;',
			'NOK' => '&#107;&#114;',
			'NPR' => '&#8360;',
			'NZD' => '&#36;',
			'OMR' => '&#65020;',
			'PAB' => '&#66;&#47;&#46;',
			'PEN' => '&#83;&#47;&#46;',
			'PGK' => '&#75;', // ?
			'PHP' => '&#8369;',
			'PKR' => '&#8360;',
			'PLN' => '&#122;&#322;',
			'PYG' => '&#71;&#115;',
			'QAR' => '&#65020;',
			'RON' => '&#108;&#101;&#105;',
			'RSD' => '&#1044;&#1080;&#1085;&#46;',
			'RUB' => '&#1088;&#1091;&#1073;',
			'RWF' => '&#1585;.&#1587;',
			'SAR' => '&#65020;',
			'SBD' => '&#36;',
			'SCR' => '&#8360;',
			'SDG' => '&#163;', // ?
			'SEK' => '&#107;&#114;',
			'SGD' => '&#36;',
			'SHP' => '&#163;',
			'SLL' => '&#76;&#101;', // ?
			'SOS' => '&#83;',
			'SRD' => '&#36;',
			'STD' => '&#68;&#98;', // ?
			'SVC' => '&#36;',
			'SYP' => '&#163;',
			'SZL' => '&#76;', // ?
			'THB' => '&#3647;',
			'TJS' => '&#84;&#74;&#83;', // ? TJS (guess)
			'TMT' => '&#109;',
			'TND' => '&#1583;.&#1578;',
			'TOP' => '&#84;&#36;',
			'TRY' => '&#8356;', // New Turkey Lira (old symbol used)
			'TTD' => '&#36;',
			'TWD' => '&#78;&#84;&#36;',
			'TZS' => '',
			'UAH' => '&#8372;',
			'UGX' => '&#85;&#83;&#104;',
			'USD' => '&#36;',
			'UYU' => '&#36;&#85;',
			'UZS' => '&#1083;&#1074;',
			'VEF' => '&#66;&#115;',
			'VND' => '&#8363;',
			'VUV' => '&#86;&#84;',
			'WST' => '&#87;&#83;&#36;',
			'XAF' => '&#70;&#67;&#70;&#65;',
			'XCD' => '&#36;',
			'XDR' => '',
			'XOF' => '',
			'XPF' => '&#70;',
			'YER' => '&#65020;',
			'ZAR' => '&#82;',
			'ZMK' => '&#90;&#75;', // ?
			'ZWL' => '&#90;&#36;',
		);

		/*
		 * Get the pricing for Pre-rolls
		 */

		if ( get_post_meta( get_the_ID(), '_priceeach', true ) ) {
			$pricingeach = '<strong>'. $wpd_cost_phrase .':</strong> ' . $currency_symbols[ $wpd_currency ] . '' . get_post_meta( get_the_id(), '_priceeach', true ) . ' per roll';
		}

		/** Check shortcode options input by user */

		if ( 'show' === $name ) {
			$showname = '<p><strong><a href="' . get_permalink() . '">' . $querytitle . '</a></strong></p>';
		} else {
			$showname = '';
		}

		if ( 'show' === $info ) {
			$showinfo = '<span class="wpd-productinfo">' . $pricingeach . '</span>';
		} else {
			$showinfo = '';
		}

		/** Shortcode display */

		$wpdposts .= '<div class="wpdshortcode wpd-prerolls ' . $class .'"><a href="' . get_permalink() . '"><img src="' . $thumbnail_url . '" alt="Menu - Pre-roll" /></a>'. $showname .''. $showinfo .'</div>';

	endwhile;

	wp_reset_postdata();

	return $wpdposts . '</div>';

}
add_shortcode( 'wpd-prerolls', 'wpdispensary_prerolls_shortcode' );


/**
 * Topicals Shortcode Fuction
 */
function wpdispensary_topicals_shortcode( $atts ) {

	/* Attributes */
	extract( shortcode_atts(
		array(
			'posts'		=> '100',
			'class'		=> '',
			'name'		=> 'show',
			'info'		=> 'show',
			'title'		=> 'Topicals',
			'category'	=> '',
		),
		$atts
	) );

	/**
	 * Code to create shortcode for Topicals
	 */

	$wpdquery = new WP_Query(
		array(
			'post_type' 		=> 'topicals',
			'posts_per_page'	=> $posts,
			'topicals_category'	=> $category,
		)
	);

	$wpdposts = '<div class="wpdispensary"><h2 class="wpd-title">'. $title .'</h2>';

	while ( $wpdquery->have_posts() ) : $wpdquery->the_post();

		$thumbnail_id			= get_post_thumbnail_id();
		$thumbnail_url_array	= wp_get_attachment_image_src( $thumbnail_id, 'dispensary-image', true );
		$thumbnail_url			= $thumbnail_url_array[0];
		$querytitle				= get_the_title();

		$wp_dispensary_options = get_option( 'wp_dispensary_option_name' ); // Array of All Options
		$wpd_hide_details = $wp_dispensary_options['wpd_hide_details']; // hidedetails
		$wpd_hide_pricing = $wp_dispensary_options['wpd_hide_pricing']; // hidepricing
		$wpd_content_placement = $wp_dispensary_options['wpd_content_placement']; // movecontent
		if ( null === $wp_dispensary_options['wpd_currency'] ) {
			$wpd_currency = 'USD';
		} else {
			$wpd_currency = $wp_dispensary_options['wpd_currency'];
		}
		if ( null === $wp_dispensary_options['wpd_cost_phrase'] ) {
			$wpd_cost_phrase = 'Price';
		} else {
			$wpd_cost_phrase = $wp_dispensary_options['wpd_cost_phrase']; // costphrase
		}

		$currency_symbols = array(
			'AED' => '&#1583;.&#1573;', // ?
			'AFN' => '&#65;&#102;',
			'ALL' => '&#76;&#101;&#107;',
			'AMD' => '',
			'ANG' => '&#402;',
			'AOA' => '&#75;&#122;', // ?
			'ARS' => '&#36;',
			'AUD' => '&#36;',
			'AWG' => '&#402;',
			'AZN' => '&#1084;&#1072;&#1085;',
			'BAM' => '&#75;&#77;',
			'BBD' => '&#36;',
			'BDT' => '&#2547;', // ?
			'BGN' => '&#1083;&#1074;',
			'BHD' => '.&#1583;.&#1576;', // ?
			'BIF' => '&#70;&#66;&#117;', // ?
			'BMD' => '&#36;',
			'BND' => '&#36;',
			'BOB' => '&#36;&#98;',
			'BRL' => '&#82;&#36;',
			'BSD' => '&#36;',
			'BTN' => '&#78;&#117;&#46;', // ?
			'BWP' => '&#80;',
			'BYR' => '&#112;&#46;',
			'BZD' => '&#66;&#90;&#36;',
			'CAD' => '&#36;',
			'CDF' => '&#70;&#67;',
			'CHF' => '&#67;&#72;&#70;',
			'CLF' => '', // ?
			'CLP' => '&#36;',
			'CNY' => '&#165;',
			'COP' => '&#36;',
			'CRC' => '&#8353;',
			'CUP' => '&#8396;',
			'CVE' => '&#36;', // ?
			'CZK' => '&#75;&#269;',
			'DJF' => '&#70;&#100;&#106;', // ?
			'DKK' => '&#107;&#114;',
			'DOP' => '&#82;&#68;&#36;',
			'DZD' => '&#1583;&#1580;', // ?
			'EGP' => '&#163;',
			'ETB' => '&#66;&#114;',
			'EUR' => '&#8364;',
			'FJD' => '&#36;',
			'FKP' => '&#163;',
			'GBP' => '&#163;',
			'GEL' => '&#4314;', // ?
			'GHS' => '&#162;',
			'GIP' => '&#163;',
			'GMD' => '&#68;', // ?
			'GNF' => '&#70;&#71;', // ?
			'GTQ' => '&#81;',
			'GYD' => '&#36;',
			'HKD' => '&#36;',
			'HNL' => '&#76;',
			'HRK' => '&#107;&#110;',
			'HTG' => '&#71;', // ?
			'HUF' => '&#70;&#116;',
			'IDR' => '&#82;&#112;',
			'ILS' => '&#8362;',
			'INR' => '&#8377;',
			'IQD' => '&#1593;.&#1583;', // ?
			'IRR' => '&#65020;',
			'ISK' => '&#107;&#114;',
			'JEP' => '&#163;',
			'JMD' => '&#74;&#36;',
			'JOD' => '&#74;&#68;', // ?
			'JPY' => '&#165;',
			'KES' => '&#75;&#83;&#104;', // ?
			'KGS' => '&#1083;&#1074;',
			'KHR' => '&#6107;',
			'KMF' => '&#67;&#70;', // ?
			'KPW' => '&#8361;',
			'KRW' => '&#8361;',
			'KWD' => '&#1583;.&#1603;', // ?
			'KYD' => '&#36;',
			'KZT' => '&#1083;&#1074;',
			'LAK' => '&#8365;',
			'LBP' => '&#163;',
			'LKR' => '&#8360;',
			'LRD' => '&#36;',
			'LSL' => '&#76;', // ?
			'LTL' => '&#76;&#116;',
			'LVL' => '&#76;&#115;',
			'LYD' => '&#1604;.&#1583;', // ?
			'MAD' => '&#1583;.&#1605;.', // ?
			'MDL' => '&#76;',
			'MGA' => '&#65;&#114;', // ?
			'MKD' => '&#1076;&#1077;&#1085;',
			'MMK' => '&#75;',
			'MNT' => '&#8366;',
			'MOP' => '&#77;&#79;&#80;&#36;', // ?
			'MRO' => '&#85;&#77;', // ?
			'MUR' => '&#8360;', // ?
			'MVR' => '.&#1923;', // ?
			'MWK' => '&#77;&#75;',
			'MXN' => '&#36;',
			'MYR' => '&#82;&#77;',
			'MZN' => '&#77;&#84;',
			'NAD' => '&#36;',
			'NGN' => '&#8358;',
			'NIO' => '&#67;&#36;',
			'NOK' => '&#107;&#114;',
			'NPR' => '&#8360;',
			'NZD' => '&#36;',
			'OMR' => '&#65020;',
			'PAB' => '&#66;&#47;&#46;',
			'PEN' => '&#83;&#47;&#46;',
			'PGK' => '&#75;', // ?
			'PHP' => '&#8369;',
			'PKR' => '&#8360;',
			'PLN' => '&#122;&#322;',
			'PYG' => '&#71;&#115;',
			'QAR' => '&#65020;',
			'RON' => '&#108;&#101;&#105;',
			'RSD' => '&#1044;&#1080;&#1085;&#46;',
			'RUB' => '&#1088;&#1091;&#1073;',
			'RWF' => '&#1585;.&#1587;',
			'SAR' => '&#65020;',
			'SBD' => '&#36;',
			'SCR' => '&#8360;',
			'SDG' => '&#163;', // ?
			'SEK' => '&#107;&#114;',
			'SGD' => '&#36;',
			'SHP' => '&#163;',
			'SLL' => '&#76;&#101;', // ?
			'SOS' => '&#83;',
			'SRD' => '&#36;',
			'STD' => '&#68;&#98;', // ?
			'SVC' => '&#36;',
			'SYP' => '&#163;',
			'SZL' => '&#76;', // ?
			'THB' => '&#3647;',
			'TJS' => '&#84;&#74;&#83;', // ? TJS (guess)
			'TMT' => '&#109;',
			'TND' => '&#1583;.&#1578;',
			'TOP' => '&#84;&#36;',
			'TRY' => '&#8356;', // New Turkey Lira (old symbol used)
			'TTD' => '&#36;',
			'TWD' => '&#78;&#84;&#36;',
			'TZS' => '',
			'UAH' => '&#8372;',
			'UGX' => '&#85;&#83;&#104;',
			'USD' => '&#36;',
			'UYU' => '&#36;&#85;',
			'UZS' => '&#1083;&#1074;',
			'VEF' => '&#66;&#115;',
			'VND' => '&#8363;',
			'VUV' => '&#86;&#84;',
			'WST' => '&#87;&#83;&#36;',
			'XAF' => '&#70;&#67;&#70;&#65;',
			'XCD' => '&#36;',
			'XDR' => '',
			'XOF' => '',
			'XPF' => '&#70;',
			'YER' => '&#65020;',
			'ZAR' => '&#82;',
			'ZMK' => '&#90;&#75;', // ?
			'ZWL' => '&#90;&#36;',
		);

		/** Get the pricing for Topicals */

		if ( get_post_meta( get_the_ID(), '_pricetopical', true ) ) {
			$topicalprice = '<strong>'. $wpd_cost_phrase .':</strong> ' . $currency_symbols[ $wpd_currency ] . '' . get_post_meta( get_the_id(), '_pricetopical', true ) . '';
		}
		if ( get_post_meta( get_the_ID(), '_sizetopical', true ) ) {
			$topicalsize = ' - <strong>Size:</strong> '. get_post_meta( get_the_id(), '_sizetopical', true ) . 'oz';
		}
		if ( get_post_meta( get_the_ID(), '_thctopical', true ) ) {
			$topicalthc = ' - <strong>THC:</strong> '. get_post_meta( get_the_id(), '_thctopical', true ) . 'mg';
		}
		if ( get_post_meta( get_the_ID(), '_cbdtopical', true ) ) {
			$topicalcbd = ' - <strong>CBD:</strong> '. get_post_meta( get_the_id(), '_cbdtopical', true ) . 'mg';
		}

		/** Check shortcode options input by user */

		if ( 'show' === $name ) {
			$showname = '<p><strong><a href="' . get_permalink() . '">' . $querytitle . '</a></strong></p>';
		} else {
			$showname = '';
		}

		if ( 'show' === $info ) {
			$showinfo = '<span class="wpd-productinfo">' . $topicalprice . '' . $topicalsize . '' . $topicalthc . '' . $topicalcbd . '</span>';
		} else {
			$showinfo = '';
		}

		/** Shortcode display */

		$wpdposts .= '<div class="wpdshortcode wpd-topicals ' . $class .'"><a href="' . get_permalink() . '"><img src="' . $thumbnail_url . '" alt="Menu - Flower" /></a>' . $showname . '' . $showinfo . '</div>';

	endwhile;

	wp_reset_postdata();

	return $wpdposts . '</div>';

}
add_shortcode( 'wpd-topicals', 'wpdispensary_topicals_shortcode' );


/**
 * Growers Shortcode Function
 */
function wpdispensary_growers_shortcode( $atts ) {

	/** Attributes */
	extract( shortcode_atts(
		array(
			'posts'		=> '100',
			'class'		=> '',
			'name'		=> 'show',
			'info'		=> 'show',
			'title'		=> 'Growers',
			'category'	=> '',
		),
		$atts
	) );

	/**
	 * Code to create shortcode for Growers
	 */

	$wpdquery = new WP_Query(
		array(
			'post_type' 		=> 'growers',
			'posts_per_page'	=> $posts,
			'growers_category'	=> $category,
		)
	);

	$wpdposts = '<div class="wpdispensary"><h2 class="wpd-title">'. $title .'</h2>';

	while ( $wpdquery->have_posts() ) : $wpdquery->the_post();

		$thumbnail_id			= get_post_thumbnail_id();
		$thumbnail_url_array	= wp_get_attachment_image_src( $thumbnail_id, 'dispensary-image', true );
		$thumbnail_url			= $thumbnail_url_array[0];
		$querytitle 			= get_the_title();

		$wp_dispensary_options = get_option( 'wp_dispensary_option_name' ); // Array of All Options
		$wpd_hide_details = $wp_dispensary_options['wpd_hide_details']; // hidedetails
		$wpd_hide_pricing = $wp_dispensary_options['wpd_hide_pricing']; // hidepricing
		$wpd_content_placement = $wp_dispensary_options['wpd_content_placement']; // movecontent
		if ( null === $wp_dispensary_options['wpd_currency'] ) {
			$wpd_currency = 'USD';
		} else {
			$wpd_currency = $wp_dispensary_options['wpd_currency'];
		}
		if ( null === $wp_dispensary_options['wpd_cost_phrase'] ) {
			$wpd_cost_phrase = 'Price';
		} else {
			$wpd_cost_phrase = $wp_dispensary_options['wpd_cost_phrase']; // costphrase
		}

		$currency_symbols = array(
			'AED' => '&#1583;.&#1573;', // ?
			'AFN' => '&#65;&#102;',
			'ALL' => '&#76;&#101;&#107;',
			'AMD' => '',
			'ANG' => '&#402;',
			'AOA' => '&#75;&#122;', // ?
			'ARS' => '&#36;',
			'AUD' => '&#36;',
			'AWG' => '&#402;',
			'AZN' => '&#1084;&#1072;&#1085;',
			'BAM' => '&#75;&#77;',
			'BBD' => '&#36;',
			'BDT' => '&#2547;', // ?
			'BGN' => '&#1083;&#1074;',
			'BHD' => '.&#1583;.&#1576;', // ?
			'BIF' => '&#70;&#66;&#117;', // ?
			'BMD' => '&#36;',
			'BND' => '&#36;',
			'BOB' => '&#36;&#98;',
			'BRL' => '&#82;&#36;',
			'BSD' => '&#36;',
			'BTN' => '&#78;&#117;&#46;', // ?
			'BWP' => '&#80;',
			'BYR' => '&#112;&#46;',
			'BZD' => '&#66;&#90;&#36;',
			'CAD' => '&#36;',
			'CDF' => '&#70;&#67;',
			'CHF' => '&#67;&#72;&#70;',
			'CLF' => '', // ?
			'CLP' => '&#36;',
			'CNY' => '&#165;',
			'COP' => '&#36;',
			'CRC' => '&#8353;',
			'CUP' => '&#8396;',
			'CVE' => '&#36;', // ?
			'CZK' => '&#75;&#269;',
			'DJF' => '&#70;&#100;&#106;', // ?
			'DKK' => '&#107;&#114;',
			'DOP' => '&#82;&#68;&#36;',
			'DZD' => '&#1583;&#1580;', // ?
			'EGP' => '&#163;',
			'ETB' => '&#66;&#114;',
			'EUR' => '&#8364;',
			'FJD' => '&#36;',
			'FKP' => '&#163;',
			'GBP' => '&#163;',
			'GEL' => '&#4314;', // ?
			'GHS' => '&#162;',
			'GIP' => '&#163;',
			'GMD' => '&#68;', // ?
			'GNF' => '&#70;&#71;', // ?
			'GTQ' => '&#81;',
			'GYD' => '&#36;',
			'HKD' => '&#36;',
			'HNL' => '&#76;',
			'HRK' => '&#107;&#110;',
			'HTG' => '&#71;', // ?
			'HUF' => '&#70;&#116;',
			'IDR' => '&#82;&#112;',
			'ILS' => '&#8362;',
			'INR' => '&#8377;',
			'IQD' => '&#1593;.&#1583;', // ?
			'IRR' => '&#65020;',
			'ISK' => '&#107;&#114;',
			'JEP' => '&#163;',
			'JMD' => '&#74;&#36;',
			'JOD' => '&#74;&#68;', // ?
			'JPY' => '&#165;',
			'KES' => '&#75;&#83;&#104;', // ?
			'KGS' => '&#1083;&#1074;',
			'KHR' => '&#6107;',
			'KMF' => '&#67;&#70;', // ?
			'KPW' => '&#8361;',
			'KRW' => '&#8361;',
			'KWD' => '&#1583;.&#1603;', // ?
			'KYD' => '&#36;',
			'KZT' => '&#1083;&#1074;',
			'LAK' => '&#8365;',
			'LBP' => '&#163;',
			'LKR' => '&#8360;',
			'LRD' => '&#36;',
			'LSL' => '&#76;', // ?
			'LTL' => '&#76;&#116;',
			'LVL' => '&#76;&#115;',
			'LYD' => '&#1604;.&#1583;', // ?
			'MAD' => '&#1583;.&#1605;.', // ?
			'MDL' => '&#76;',
			'MGA' => '&#65;&#114;', // ?
			'MKD' => '&#1076;&#1077;&#1085;',
			'MMK' => '&#75;',
			'MNT' => '&#8366;',
			'MOP' => '&#77;&#79;&#80;&#36;', // ?
			'MRO' => '&#85;&#77;', // ?
			'MUR' => '&#8360;', // ?
			'MVR' => '.&#1923;', // ?
			'MWK' => '&#77;&#75;',
			'MXN' => '&#36;',
			'MYR' => '&#82;&#77;',
			'MZN' => '&#77;&#84;',
			'NAD' => '&#36;',
			'NGN' => '&#8358;',
			'NIO' => '&#67;&#36;',
			'NOK' => '&#107;&#114;',
			'NPR' => '&#8360;',
			'NZD' => '&#36;',
			'OMR' => '&#65020;',
			'PAB' => '&#66;&#47;&#46;',
			'PEN' => '&#83;&#47;&#46;',
			'PGK' => '&#75;', // ?
			'PHP' => '&#8369;',
			'PKR' => '&#8360;',
			'PLN' => '&#122;&#322;',
			'PYG' => '&#71;&#115;',
			'QAR' => '&#65020;',
			'RON' => '&#108;&#101;&#105;',
			'RSD' => '&#1044;&#1080;&#1085;&#46;',
			'RUB' => '&#1088;&#1091;&#1073;',
			'RWF' => '&#1585;.&#1587;',
			'SAR' => '&#65020;',
			'SBD' => '&#36;',
			'SCR' => '&#8360;',
			'SDG' => '&#163;', // ?
			'SEK' => '&#107;&#114;',
			'SGD' => '&#36;',
			'SHP' => '&#163;',
			'SLL' => '&#76;&#101;', // ?
			'SOS' => '&#83;',
			'SRD' => '&#36;',
			'STD' => '&#68;&#98;', // ?
			'SVC' => '&#36;',
			'SYP' => '&#163;',
			'SZL' => '&#76;', // ?
			'THB' => '&#3647;',
			'TJS' => '&#84;&#74;&#83;', // ? TJS (guess)
			'TMT' => '&#109;',
			'TND' => '&#1583;.&#1578;',
			'TOP' => '&#84;&#36;',
			'TRY' => '&#8356;', // New Turkey Lira (old symbol used)
			'TTD' => '&#36;',
			'TWD' => '&#78;&#84;&#36;',
			'TZS' => '',
			'UAH' => '&#8372;',
			'UGX' => '&#85;&#83;&#104;',
			'USD' => '&#36;',
			'UYU' => '&#36;&#85;',
			'UZS' => '&#1083;&#1074;',
			'VEF' => '&#66;&#115;',
			'VND' => '&#8363;',
			'VUV' => '&#86;&#84;',
			'WST' => '&#87;&#83;&#36;',
			'XAF' => '&#70;&#67;&#70;&#65;',
			'XCD' => '&#36;',
			'XDR' => '',
			'XOF' => '',
			'XPF' => '&#70;',
			'YER' => '&#65020;',
			'ZAR' => '&#82;',
			'ZMK' => '&#90;&#75;', // ?
			'ZWL' => '&#90;&#36;',
		);

		/*
		 * Get the pricing for Growers
		 */

		if ( get_post_meta( get_the_ID(), '_priceeach', true ) ) {
			$pricingperunit = '<strong>'. $wpd_cost_phrase .':</strong> ' . $currency_symbols[ $wpd_currency ] . '' . get_post_meta( get_the_id(), '_priceeach', true );
		}

		/*
		 * Get the seed count for Growers
		 */

		if ( get_post_meta( get_the_ID(), '_seedcount', true ) ) {
			$wpdseedcount = ' - <strong>Seeds:</strong> ' . get_post_meta( get_the_id(), '_seedcount', true );
		} else {
			$wpdseedcount = '';
		}

		/*
		 * Get the clone count for Growers
		 */

		if ( get_post_meta( get_the_ID(), '_clonecount', true ) ) {
			$wpdclonecount = ' - <strong>Clones:</strong> ' . get_post_meta( get_the_id(), '_clonecount', true );
		} else {
			$wpdclonecount = '';
		}

		/** Check shortcode options input by user */

		if ( 'show' === $name ) {
			$showname = '<p><strong><a href="' . get_permalink() . '">' . $querytitle . '</a></strong></p>';
		} else {
			$showname = '';
		}

		if ( 'show' === $info ) {
			$showinfo = '<span class="wpd-productinfo">' . $pricingperunit . '' . $wpdseedcount . '' . $wpdclonecount . '</span>';
		} else {
			$showinfo = '';
		}

		/** Shortcode display */

		$wpdposts .= '<div class="wpdshortcode wpd-growers ' . $class .'"><a href="' . get_permalink() . '"><img src="' . $thumbnail_url . '" alt="Menu - Grower" /></a>'. $showname .''. $showinfo .'</div>';

	endwhile;

	wp_reset_postdata();

	return $wpdposts . '</div>';

}
add_shortcode( 'wpd-growers', 'wpdispensary_growers_shortcode' );
