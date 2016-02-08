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
 * Flowers Shortcode Fuction
 */
function wpdispensary_flowers_shortcode( $atts ) {

	/* Attributes */
	extract( shortcode_atts(
		array(
			'posts' => '100',
		), $atts )
	);

	/**
	 * Code to create shortcode for Flowers
	 */

	$wpdquery = new WP_Query(
		array(
			'post_type' 		=> 'flowers',
			'posts_per_page'	=> $posts,
		)
	);

	$wpdposts = '<div class="wpdispensary"><h2 class="wpd-title">Flowers</h2>';

	while($wpdquery->have_posts()) : $wpdquery->the_post();
	
		$thumbnail_id = get_post_thumbnail_id();
		$thumbnail_url_array = wp_get_attachment_image_src($thumbnail_id, 'dispensary-image', true);
		$thumbnail_url = $thumbnail_url_array[0];
		$title = get_the_title();
		
		// Get the pricing for Flowers and Concentrates
		
		if ( get_post_meta( get_the_ID(), '_halfgram', true ) ) {
			$pricinglow = "$" . get_post_meta(get_the_id(), '_halfgram', true);
		} elseif ( get_post_meta( get_the_ID(), '_gram', true ) ) {
			$pricinglow = "$" . get_post_meta(get_the_id(), '_gram', true);
		} elseif ( get_post_meta( get_the_ID(), '_eighth', true ) ) {
			$pricinglow = "$" . get_post_meta(get_the_id(), '_eighth', true);
		} elseif ( get_post_meta( get_the_ID(), '_quarter', true ) ) {
			$pricinglow = "$" . get_post_meta(get_the_id(), '_quarter', true);
		} elseif ( get_post_meta( get_the_ID(), '_halfounce', true ) ) {
			$pricinglow = "$" . get_post_meta(get_the_id(), '_halfounce', true);
		}
		$pricingsep = ' - ';
		if ( get_post_meta( get_the_ID(), '_ounce', true ) ) {
			$pricinghigh = "$" . get_post_meta(get_the_id(), '_ounce', true);
		} elseif ( get_post_meta( get_the_ID(), '_halfounce', true ) ) {
			$pricinghigh = "$" . get_post_meta(get_the_id(), '_halfounce', true);
		} elseif ( get_post_meta( get_the_ID(), '_quarter', true ) ) {
			$pricinghigh = "$" . get_post_meta(get_the_id(), '_quarter', true);
		} elseif ( get_post_meta( get_the_ID(), '_eighth', true ) ) {
			$pricinghigh = "$" . get_post_meta(get_the_id(), '_eighth', true);
		} elseif ( get_post_meta( get_the_ID(), '_gram', true ) ) {
			$pricinghigh = "$" . get_post_meta(get_the_id(), '_gram', true);
		}

		$wpdposts .= '<div class="wpdshortcode wpd-flowers' . $class .'">
			<a href="' . get_permalink() . '"><img src="' . $thumbnail_url . '" alt="Menu - Flower" /></a>
			<p><strong><a href="' . get_permalink() . '">' . $title . '</a></strong></p>
			<span class="wpd-pricing">' . $pricinglow . '' . $pricingsep . '' . $pricinghigh . '</span>
		</div>';

	endwhile;

	wp_reset_query();

	return $wpdposts . '</div>';

}
add_shortcode( 'wpd-flowers', 'wpdispensary_flowers_shortcode' );

/**
 * Concentrates Shortcode Function
 */
function wpdispensary_concentrates_shortcode( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'posts' => '100',
		), $atts )
	);

	/**
	 * Code to create shortcode for Concentrates
	 */

	$wpdquery = new WP_Query(
		array(
			'post_type' 		=> 'concentrates',
			'posts_per_page'	=> $posts,
		)
	);

	$wpdposts = '<div class="wpdispensary"><h2 class="wpd-title">Concentrates</h2>';

	while($wpdquery->have_posts()) : $wpdquery->the_post();

		$thumbnail_id = get_post_thumbnail_id();
		$thumbnail_url_array = wp_get_attachment_image_src($thumbnail_id, 'dispensary-image', true);
		$thumbnail_url = $thumbnail_url_array[0];
		$title = get_the_title();

		// Get the pricing for Concentrates

		if ( get_post_meta( get_the_ID(), '_halfgram', true ) ) {
			$pricinglow = "$" . get_post_meta(get_the_id(), '_halfgram', true);
		} elseif ( get_post_meta( get_the_ID(), '_gram', true ) ) {
			$pricinglow = "$" . get_post_meta(get_the_id(), '_gram', true);
		} elseif ( get_post_meta( get_the_ID(), '_eighth', true ) ) {
			$pricinglow = "$" . get_post_meta(get_the_id(), '_eighth', true);
		} elseif ( get_post_meta( get_the_ID(), '_quarter', true ) ) {
			$pricinglow = "$" . get_post_meta(get_the_id(), '_quarter', true);
		} elseif ( get_post_meta( get_the_ID(), '_halfounce', true ) ) {
			$pricinglow = "$" . get_post_meta(get_the_id(), '_halfounce', true);
		}

		$wpdposts .= '<div class="wpdshortcode wpd-concentrates' . $class .'">
			<a href="' . get_permalink() . '"><img src="' . $thumbnail_url . '" alt="Menu - Concentrate" /></a>
			<p><strong><a href="' . get_permalink() . '">' . $title . '</a></strong></p>
			<span class="wpd-pricing">' . $pricinglow . '</span>
		</div>';

	endwhile;

	wp_reset_query();

	return $wpdposts . '</div>';
	
}
add_shortcode( 'wpd-concentrates', 'wpdispensary_concentrates_shortcode' );

/**
 * Edibles Shortcode Function
 */
function wpdispensary_edibles_shortcode( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'posts' => '100',
		), $atts )
	);

	/**
	 * Code to create shortcode for Edibles
	 */

	$wpdquery = new WP_Query(
		array(
			'post_type' 		=> 'edibles',
			'posts_per_page'	=> $posts,
		)
	);

	$wpdposts = '<div class="wpdispensary"><h2 class="wpd-title">Edibles</h2>';

	while($wpdquery->have_posts()) : $wpdquery->the_post();

		$thumbnail_id = get_post_thumbnail_id();
		$thumbnail_url_array = wp_get_attachment_image_src($thumbnail_id, 'dispensary-image', true);
		$thumbnail_url = $thumbnail_url_array[0];
		$title = get_the_title();

		/*
		 * Get the pricing for Edibles
		 */

		if ( get_post_meta( get_the_ID(), '_thcmg', true ) ) {
			$thcmg = get_post_meta(get_the_id(), '_thcmg', true) . "mg";
		}
		$thcsep = ' - ';
		if ( get_post_meta( get_the_ID(), '_thcservings', true ) ) {
			$thcservings = "Servings: " . get_post_meta(get_the_id(), '_thcservings', true);
		}

		$wpdposts .= '<div class="wpdshortcode wpd-edibles' . $class .'">
			<a href="' . get_permalink() . '"><img src="' . $thumbnail_url . '" alt="Menu - Edible" /></a>
			<p><strong><a href="' . get_permalink() . '">' . $title . '</a></strong></p>
			<span class="wpd-thc">' . $thcmg . '' . $thcsep . '' . $thcservings . '</span>
		</div>';

	endwhile;

	wp_reset_query();

	return $wpdposts . '</div>';
	
}
add_shortcode( 'wpd-edibles', 'wpdispensary_edibles_shortcode' );

/**
 * Prerolls Shortcode Function
 */
function wpdispensary_prerolls_shortcode( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'posts' => '100',
		), $atts )
	);

	/**
	 * Code to create shortcode for Prerolls
	 */

	$wpdquery = new WP_Query(
		array(
			'post_type' 		=> 'prerolls',
			'posts_per_page'	=> $posts,
		)
	);

	$wpdposts = '<div class="wpdispensary"><h2 class="wpd-title">Prerolls</h2>';

	while($wpdquery->have_posts()) : $wpdquery->the_post();

		$thumbnail_id = get_post_thumbnail_id();
		$thumbnail_url_array = wp_get_attachment_image_src($thumbnail_id, 'dispensary-image', true);
		$thumbnail_url = $thumbnail_url_array[0];
		$title = get_the_title();

		/*
		 * Get the pricing for Prerolls
		 */

		if ( get_post_meta( get_the_ID(), '_priceeach', true ) ) {
			$pricinglow = "$" . get_post_meta(get_the_id(), '_priceeach', true) . " per roll";
		}

		$wpdposts .= '<div class="wpdshortcode wpd-prerolls' . $class .'">
			<a href="' . get_permalink() . '"><img src="' . $thumbnail_url . '" alt="Menu - Pre-roll" /></a>
			<p><strong><a href="' . get_permalink() . '">' . $title . '</a></strong></p>
			<span class="wpd-pricing">' . $pricinglow . '</span>
		</div>';

	endwhile;

	wp_reset_query();

	return $wpdposts . '</div>';
	
}
add_shortcode( 'wpd-prerolls', 'wpdispensary_prerolls_shortcode' );

?>