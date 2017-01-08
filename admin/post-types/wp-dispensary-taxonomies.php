<?php
/**
 * The file that defines the taxonomies used by the various custom post types
 *
 * @link       http://www.wpdispensary.com
 * @since      1.0.0
 *
 * @package    WP_Dispensary
 * @subpackage WP_Dispensary/admin/post-types
 */

/**
 * Aroma Taxonomy
 *
 * Adds the Aroma taxonomy to all custom post types
 *
 * @since    1.0.0
 */

add_action( 'init', 'wpdispensary_aroma', 0 );

/**
 * Aroma
 */
function wpdispensary_aroma() {

	  $labels = array(
		'name' => _x( 'Aromas', 'general name' ),
		'singular_name' => _x( 'Aroma', 'singular name' ),
		'search_items' => __( 'Search Aromas' ),
		'popular_items' => __( 'Popular Aromas' ),
		'all_items' => __( 'All Aromas' ),
		'parent_item' => null,
		'parent_item_colon' => null,
		'edit_item' => __( 'Edit Aroma' ),
		'update_item' => __( 'Update Aroma' ),
		'add_new_item' => __( 'Add New Aroma' ),
		'new_item_name' => __( 'New Aroma Name' ),
		'separate_items_with_commas' => __( 'Separate aromas with commas' ),
		'add_or_remove_items' => __( 'Add or remove aromas' ),
		'choose_from_most_used' => __( 'Choose from the most used aromas' ),
		'not_found' => 'No aromas found',
		'menu_name' => __( 'Aromas' ),
	  );

	  register_taxonomy('aroma',array( 'flowers', 'concentrates' ), array(
			'hierarchical' => false,
			'labels' => $labels,
			'show_ui' => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'update_count_callback' => '_update_post_term_count',
			'query_var' => true,
			'rewrite' => array( 'slug' => 'aroma' ),
	  ));

}

/**
 * Flavor Taxonomy
 *
 * Adds the Flavor taxonomy to all custom post types
 *
 * @since    1.0.0
 */

add_action( 'init', 'wpdispensary_flavor', 0 );

/**
 * Flavor
 */
function wpdispensary_flavor() {

	  $labels = array(
		'name' => _x( 'Flavors', 'general name' ),
		'singular_name' => _x( 'Flavor', 'singular name' ),
		'search_items' => __( 'Search Flavors' ),
		'popular_items' => __( 'Popular Flavors' ),
		'all_items' => __( 'All Flavors' ),
		'parent_item' => null,
		'parent_item_colon' => null,
		'edit_item' => __( 'Edit Flavor' ),
		'update_item' => __( 'Update Flavor' ),
		'add_new_item' => __( 'Add New Flavor' ),
		'new_item_name' => __( 'New Flavor Name' ),
		'separate_items_with_commas' => __( 'Separate flavors with commas' ),
		'add_or_remove_items' => __( 'Add or remove flavors' ),
		'choose_from_most_used' => __( 'Choose from the most used flavors' ),
		'not_found' => 'No flavors found',
		'menu_name' => __( 'Flavors' ),
	  );

	  register_taxonomy('flavor',array( 'flowers', 'concentrates' ), array(
			'hierarchical' => false,
			'labels' => $labels,
			'show_ui' => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'update_count_callback' => '_update_post_term_count',
			'query_var' => true,
			'rewrite' => array( 'slug' => 'flavor' ),
	  ));
}

/**
 * Effect Taxonomy
 *
 * Adds the Effect taxonomy to all custom post types
 *
 * @since    1.0.0
 */

add_action( 'init', 'wpdispensary_effect', 0 );

/**
 * Effect
 */
function wpdispensary_effect() {

	  $labels = array(
		'name' => _x( 'Effects', 'general name' ),
		'singular_name' => _x( 'Effect', 'singular name' ),
		'search_items' => __( 'Search Effects' ),
		'popular_items' => __( 'Popular Effects' ),
		'all_items' => __( 'All Effects' ),
		'parent_item' => null,
		'parent_item_colon' => null,
		'edit_item' => __( 'Edit Effect' ),
		'update_item' => __( 'Update Effect' ),
		'add_new_item' => __( 'Add New Effect' ),
		'new_item_name' => __( 'New Effect Name' ),
		'separate_items_with_commas' => __( 'Separate effects with commas' ),
		'add_or_remove_items' => __( 'Add or remove effects' ),
		'choose_from_most_used' => __( 'Choose from the most used effects' ),
		'not_found' => 'No effects found',
		'menu_name' => __( 'Effects' ),
	  );

	  register_taxonomy('effect',array( 'flowers', 'concentrates' ), array(
			'hierarchical' => false,
			'labels' => $labels,
			'show_ui' => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'update_count_callback' => '_update_post_term_count',
			'query_var' => true,
			'rewrite' => array( 'slug' => 'effect' ),
	  ));
}

/**
 * Symptom Taxonomy
 *
 * Adds the Symptom taxonomy to all custom post types
 *
 * @since    1.0.0
 */

add_action( 'init', 'wpdispensary_symptom', 0 );

/**
 * Symptom
 */
function wpdispensary_symptom() {

	  $labels = array(
		'name' => _x( 'Symptoms', 'general name' ),
		'singular_name' => _x( 'Symptom', 'singular name' ),
		'search_items' => __( 'Search Symptoms' ),
		'popular_items' => __( 'Popular Symptoms' ),
		'all_items' => __( 'All Symptoms' ),
		'parent_item' => null,
		'parent_item_colon' => null,
		'edit_item' => __( 'Edit Symptom' ),
		'update_item' => __( 'Update Symptom' ),
		'add_new_item' => __( 'Add New Symptom' ),
		'new_item_name' => __( 'New Symptom Name' ),
		'separate_items_with_commas' => __( 'Separate symptoms with commas' ),
		'add_or_remove_items' => __( 'Add or remove symptoms' ),
		'choose_from_most_used' => __( 'Choose from the most used symptoms' ),
		'not_found' => 'No symptoms found',
		'menu_name' => __( 'Symptoms' ),
	  );

	  register_taxonomy('symptom',array( 'flowers', 'concentrates' ), array(
			'hierarchical' => false,
			'labels' => $labels,
			'show_ui' => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'update_count_callback' => '_update_post_term_count',
			'query_var' => true,
			'rewrite' => array( 'slug' => 'symptom' ),
	  ));
}

/**
 * Condition Taxonomy
 *
 * Adds the Condition taxonomy to all custom post types
 *
 * @since    1.0.0
 */

add_action( 'init', 'wpdispensary_condition', 0 );

/**
 * Condition
 */
function wpdispensary_condition() {

	  $labels = array(
		'name' => _x( 'Conditions', 'general name' ),
		'singular_name' => _x( 'Condition', 'singular name' ),
		'search_items' => __( 'Search Conditions' ),
		'popular_items' => __( 'Popular Conditions' ),
		'all_items' => __( 'All Conditions' ),
		'parent_item' => null,
		'parent_item_colon' => null,
		'edit_item' => __( 'Edit Condition' ),
		'update_item' => __( 'Update Condition' ),
		'add_new_item' => __( 'Add New Condition' ),
		'new_item_name' => __( 'New Condition Name' ),
		'separate_items_with_commas' => __( 'Separate conditions with commas' ),
		'add_or_remove_items' => __( 'Add or remove conditions' ),
		'choose_from_most_used' => __( 'Choose from the most used conditions' ),
		'not_found' => 'No conditions found',
		'menu_name' => __( 'Conditions' ),
	  );

	  register_taxonomy('condition',array( 'flowers', 'concentrates' ), array(
			'hierarchical' => false,
			'labels' => $labels,
			'show_ui' => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'update_count_callback' => '_update_post_term_count',
			'query_var' => true,
			'rewrite' => array( 'slug' => 'condition' ),
	  ));
}

/**
 * Ingredient Taxonomy
 *
 * Adds the Ingredient taxonomy to all custom post types
 *
 * @since    1.0.0
 */

add_action( 'init', 'wpdispensary_ingredient', 0 );

/**
 * Ingredient
 */
function wpdispensary_ingredient() {

	  $labels = array(
		'name' => _x( 'Ingredients', 'general name' ),
		'singular_name' => _x( 'Ingredient', 'singular name' ),
		'search_items' => __( 'Search Ingredients' ),
		'popular_items' => __( 'Popular Ingredients' ),
		'all_items' => __( 'All Ingredients' ),
		'parent_item' => null,
		'parent_item_colon' => null,
		'edit_item' => __( 'Edit Ingredient' ),
		'update_item' => __( 'Update Ingredient' ),
		'add_new_item' => __( 'Add New Ingredient' ),
		'new_item_name' => __( 'New Ingredient Name' ),
		'separate_items_with_commas' => __( 'Separate ingredients with commas' ),
		'add_or_remove_items' => __( 'Add or remove ingredients' ),
		'choose_from_most_used' => __( 'Choose from the most used ingredients' ),
		'not_found' => 'No ingredients found',
		'menu_name' => __( 'Ingredients' ),
	  );

	  register_taxonomy('ingredients',array( 'edibles', 'topicals' ),array(
			'hierarchical' => false,
			'labels' => $labels,
			'show_ui' => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'update_count_callback' => '_update_post_term_count',
			'query_var' => true,
			'rewrite' => array( 'slug' => 'ingredient' ),
	  ));
}

/**
 * Flower Category Taxonomy
 *
 * Adds the Flower Category taxonomy to all custom post types
 *
 * @since    1.0.0
 */

add_action( 'init', 'wpdispensary_flowercategory', 0 );

/**
 * Flower category
 */
function wpdispensary_flowercategory() {

	  $labels = array(
		'name' => _x( 'Flower Categories', 'taxonomy general name' ),
		'singular_name' => _x( 'Flower Category', 'taxonomy singular name' ),
		'search_items' => __( 'Search Categories' ),
		'all_items' => __( 'All Categories' ),
		'parent_item' => __( 'Parent Category' ),
		'parent_item_colon' => __( 'Parent Category:' ),
		'edit_item' => __( 'Edit Category' ),
		'update_item' => __( 'Update Category' ),
		'add_new_item' => __( 'Add New Category' ),
		'new_item_name' => __( 'New Category Name' ),
		'not_found' => 'No categories found',
		'menu_name' => __( 'Categories' ),
	  );

	  register_taxonomy( 'flowers_category', 'flowers', array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'query_var' => true,
			'rewrite' => array(
				'slug' => 'flowers/category',
				'with_front' => false,
			),
	  ));

}

/**
 * Edible Category Taxonomy
 *
 * Adds the Edible Category taxonomy to all custom post types
 *
 * @since    1.0.0
 */

add_action( 'init', 'wpdispensary_ediblecategory', 0 );

/**
 * Edible category
 */
function wpdispensary_ediblecategory() {

	  $labels = array(
		'name' => _x( 'Edible Categories', 'taxonomy general name' ),
		'singular_name' => _x( 'Edible Category', 'taxonomy singular name' ),
		'search_items' => __( 'Search Edible Categories' ),
		'all_items' => __( 'All Edible Categories' ),
		'parent_item' => __( 'Parent Edible Category' ),
		'parent_item_colon' => __( 'Parent Edible Category:' ),
		'edit_item' => __( 'Edit Edible Category' ),
		'update_item' => __( 'Update Edible Category' ),
		'add_new_item' => __( 'Add New Edible Category' ),
		'new_item_name' => __( 'New Edible Category Name' ),
		'not_found' => 'No edible categories found',
		'menu_name' => __( 'Categories' ),
	  );

	  register_taxonomy('edibles_category','edibles', array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'query_var' => true,
			'rewrite' => array(
				'slug' => 'edibles/category',
				'with_front' => false,
			),
	  ));

}

/**
 * Concentrate Category Taxonomy
 *
 * Adds the Concentrate Category taxonomy to all custom post types
 *
 * @since    1.0.0
 */

add_action( 'init', 'wpdispensary_concentratecategory', 0 );

/**
 * Concentrate category
 */
function wpdispensary_concentratecategory() {

	  $labels = array(
		'name' => _x( 'Concentrate Categories', 'taxonomy general name' ),
		'singular_name' => _x( 'Concentrate Category', 'taxonomy singular name' ),
		'search_items' => __( 'Search Categories' ),
		'all_items' => __( 'All Categories' ),
		'parent_item' => __( 'Parent Category' ),
		'parent_item_colon' => __( 'Parent Category:' ),
		'edit_item' => __( 'Edit Category' ),
		'update_item' => __( 'Update Category' ),
		'add_new_item' => __( 'Add New Category' ),
		'new_item_name' => __( 'New Category Name' ),
		'not_found' => 'No categories found',
		'menu_name' => __( 'Categories' ),
	  );

	  register_taxonomy('concentrates_category','concentrates', array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'query_var' => true,
			'rewrite' => array(
				'slug' => 'concentrates/category',
				'with_front' => false,
			),
	  ));

}

/**
 * Topical Category Taxonomy
 *
 * Adds the Topical Category taxonomy to all custom post types
 *
 * @since    1.4.0
 */

add_action( 'init', 'wpdispensary_topicalcategory', 0 );

/**
 * Topical category
 */
function wpdispensary_topicalcategory() {

	  $labels = array(
		'name' => _x( 'Topical Categories', 'taxonomy general name' ),
		'singular_name' => _x( 'Topical Category', 'taxonomy singular name' ),
		'search_items' => __( 'Search Categories' ),
		'all_items' => __( 'All Categories' ),
		'parent_item' => __( 'Parent Category' ),
		'parent_item_colon' => __( 'Parent Category:' ),
		'edit_item' => __( 'Edit Category' ),
		'update_item' => __( 'Update Category' ),
		'add_new_item' => __( 'Add New Category' ),
		'new_item_name' => __( 'New Category Name' ),
		'not_found' => 'No categories found',
		'menu_name' => __( 'Categories' ),
	  );

	  register_taxonomy('topicals_category','topicals', array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'query_var' => true,
			'rewrite' => array(
				'slug' => 'topicals/category',
				'with_front' => false,
			),
	  ));

}

/**
 * Grower Category Taxonomy
 *
 * Adds the Grower Category taxonomy to all custom post types
 *
 * @since    1.7.0
 */

add_action( 'init', 'wpdispensary_growerscategory', 0 );

/**
 * Growers category
 */
function wpdispensary_growerscategory() {

	  $labels = array(
		'name' => _x( 'Growers Categories', 'taxonomy general name' ),
		'singular_name' => _x( 'Growers Category', 'taxonomy singular name' ),
		'search_items' => __( 'Search Categories' ),
		'all_items' => __( 'All Categories' ),
		'parent_item' => __( 'Parent Category' ),
		'parent_item_colon' => __( 'Parent Category:' ),
		'edit_item' => __( 'Edit Category' ),
		'update_item' => __( 'Update Category' ),
		'add_new_item' => __( 'Add New Category' ),
		'new_item_name' => __( 'New Category Name' ),
		'not_found' => 'No categories found',
		'menu_name' => __( 'Categories' ),
	  );

	  register_taxonomy('growers_category','growers', array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'query_var' => true,
			'rewrite' => array(
				'slug' => 'growers/category',
				'with_front' => false,
			),
	  ));

}

?>
