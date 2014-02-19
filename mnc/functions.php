<?php
/**
* @package WordPress
* @subpackage m320
*/

/**
* Constants
*/
define('MNC_DEBUG', true);

/**
* Custom post type
*/
//require_once( STYLESHEETPATH . '/inc/custom_posts_types/custom_posts_types.php' );

/**
* Custom metaboxes
*/
//require_once( STYLESHEETPATH . '/inc/metabox/example-functions.php' );

/**
* Set the content width based on the theme's design and stylesheet.
*/
if ( ! isset( $content_width ) ){
	$content_width = 720;
}




/*
-------------------------------------------------------------------------------
HOOKS
-------------------------------------------------------------------------------
*/

/**
* JavaScript & CSS Load
**/
add_action('wp_enqueue_scripts', function() {

	// CSS
	if (MNC_DEBUG) {
		wp_enqueue_style( 'style', M320_STYLESHEET_URI . '/dist/css/main.css', '', time() );
	} else {
		wp_enqueue_style( 'style', M320_STYLESHEET_URI . '/dist/css/main.min.css', '', null );
	}

	// jQuery
	wp_deregister_script('jquery');

	if (MNC_DEBUG) {
		wp_register_script('jquery', M320_STYLESHEET_URI . '/dist/js/lib/jquery.js', false, '1.11.0', true);
	} else {
		wp_register_script('jquery', M320_STYLESHEET_URI . '/dist/js/lib/jquery.min.js', false, '1.11.0', true);
	}

	// Plugins
	if (MNC_DEBUG) {
		wp_register_script('plugins', M320_STYLESHEET_URI . '/dist/js/plugins.js', array('jquery'), time(), true);
	} else {
		wp_register_script('plugins', M320_STYLESHEET_URI . '/dist/js/plugins.min.js', array('jquery'), null, true);
	}

	$theme_constants = array(
		'siteUrl' => site_url(),
		'siteLang' => get_bloginfo('language'),
		'stylesheetUri' => M320_STYLESHEET_URI,
		'siteEmail' => M320_SITE_EMAIL,
		'siteName' => M320_SITE_NAME,
		'imageFolder' => M320_STYLESHEET_URI . '/images/',
		'jsFolder' => M320_STYLESHEET_URI . '/js/',
		);

	wp_localize_script('plugins', 'MNC', $theme_constants);

	// Script
	if (MNC_DEBUG) {
		wp_enqueue_script('scripts', M320_STYLESHEET_URI . '/dist/js/script.js', array('jquery', 'plugins'), time(), true);
	} else {
		wp_enqueue_script('scripts', M320_STYLESHEET_URI . '/dist/js/script.min.js', array('jquery', 'plugins'), null, true);
	}

});


/**
 * Set Up Email FROM data
 */
add_filter('wp_mail_from', function(){
    return M320_SITE_EMAIL;
});

add_filter('wp_mail_from_name', function(){
    return M320_SITE_NAME;
});

/**
 * Remove Comments & Revisions Support for Pages
 */
add_action('init', function(){
    remove_post_type_support( 'post', 'comments' );
    remove_post_type_support( 'post', 'revisions' );
    remove_post_type_support( 'post', 'trackbacks' );
    remove_post_type_support( 'post', 'custom-fields' );
    remove_post_type_support( 'page', 'comments' );
    remove_post_type_support( 'page', 'revisions' );
    remove_post_type_support( 'page', 'trackbacks' );
    remove_post_type_support( 'page', 'custom-fields' );
});



/*
-------------------------------------------------------------------------------
STUFF FOR NON-ADMINS
-------------------------------------------------------------------------------
*/

if(current_user_can('administrator')) return false;

/**
* Remove Dashboard menus
*/
add_action('admin_menu', function(){
	remove_menu_page('wpcf7');
	global $menu;
	$restricted = array(__('Contact', 'm320'), __('Comments'), __('Tools'), __('Contact'));
	end($menu);
	while (prev($menu)){
		$value = explode(' ',$menu[key($menu)][0]);
		if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
	}
});

?>
