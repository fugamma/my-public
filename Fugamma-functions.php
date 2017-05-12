<?php

/*setup*/
function fug_setup() {
	add_editor_style();
	add_theme_support('automatic-feed-links');
	add_theme_support('post-thumbnails');
}

add_action( 'after_setup_theme', 'fug_setup' );
/*setup*/



/*resources global ACF*/
if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> 'Global Options',
		'menu_title'	=> 'Global Options',
		'menu_slug' 	=> 'global_options',
		'capability'	=> 'edit_posts',
		'redirect'	=> false,
                'icon_url' => 'dashicons-media-spreadsheet',
		'position' => 6
	));

}
/*resources global ACF*/

/* remove emojis */

remove_action( 'wp_head', 'print_emoji_detection_script', 7 ); 
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' ); 
remove_action( 'wp_print_styles', 'print_emoji_styles' ); 
remove_action( 'admin_print_styles', 'print_emoji_styles' );

/* remove emojis */

/* really remove emojis */

/**
* Disable the emoji's
*/
function disable_emojis() {
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_emojis' );

/**
* Filter function used to remove the tinymce emoji plugin.
* 
* @param array $plugins 
* @return array Difference betwen the two arrays
*/
function disable_emojis_tinymce( $plugins ) {
if ( is_array( $plugins ) ) {
return array_diff( $plugins, array( 'wpemoji' ) );
} else {
return array();
}
}

/**
* Remove emoji CDN hostname from DNS prefetching hints.
*
* @param array $urls URLs to print for resource hints.
* @param string $relation_type The relation type the URLs are printed for.
* @return array Difference betwen the two arrays.
*/
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
if ( 'dns-prefetch' == $relation_type ) {
/** This filter is documented in wp-includes/formatting.php */
$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );

$urls = array_diff( $urls, array( $emoji_svg_url ) );
}

return $urls;
}

/* really remove emojis */

/*admin logo*/
function custom_login_logo() {
	echo '<style type="text/css">
	h1 a { background-image: url('.get_template_directory_uri().'/img/logo-admin.png) !important;background-size: 291px 371px !important;width:291px !important;height:371px !important;}
	</style>';
}
add_action('login_head', 'custom_login_logo');
/*admin logo*/


/*admin footer*/
function remove_footer_admin ()
{
    echo '<span id="footer-thankyou">Made with love by <a target="_blank" href="http://www.agilecat.com">AgileCat</a>';
}
add_filter('admin_footer_text', 'remove_footer_admin');
/*admin footer*/


/*admin favicon*/
function FGU_favicon() { echo '<link rel="shortcut icon" type="image/x-icon" href="'.get_template_directory_uri().'/img/favicon.png">';}
add_action('wp_head', 'FGU_favicon');
add_action('admin_head', 'FGU_favicon');
/*admin favicon*/

/*disable admin bar*/
add_filter('show_admin_bar', '__return_false');
/*disable admin bar*/


function remove_dashboard_meta() {
        remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');//since 3.8
}
add_action( 'admin_init', 'remove_dashboard_meta' );


/*disable xmlrpc*/
add_filter('xmlrpc_enabled', '__return_false');
/*disable xmlrpc*/





/* for adding */	



// filter to remove TinyMCE emojis
if ( !function_exists( 'disable_emojicons_tinymce' ) ) {
	function disable_emojicons_tinymce( $plugins ) {
		if ( is_array( $plugins ) ) {
			return array_diff( $plugins, array( 'wpemoji' ) );
		} else {
			return array();
		}
	}
}
// launching operation cleanup
if ( !function_exists( 'head_cleanup' ) ) {
	function head_cleanup() {
		// EditURI link
		remove_action( 'wp_head', 'rsd_link' );
		// windows live writer
		remove_action( 'wp_head', 'wlwmanifest_link' );
		// previous link
		remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
		// start link
		remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
		// links for adjacent posts
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
		// WP version
		remove_action( 'wp_head', 'wp_generator' );
		// remove emoji
		// all actions related to emojis
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
		// remove_all_filters('posts_orderby');
		add_filter( 'max_srcset_image_width', create_function( '', 'return 1;' ) );
	}
	add_action( 'init', 'head_cleanup' );
}
if ( !function_exists( 'cb_remove_smileys' ) ) {
	function cb_remove_smileys($bool) {
		return false;
	}
	add_filter('option_use_smilies','cb_remove_smileys',99,1);
}
// disable default dashboard widgets
if ( !function_exists( 'disable_default_dashboard_widgets' ) ) {
	function disable_default_dashboard_widgets() {
		global $wp_meta_boxes;
		// unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);    // Right Now Widget
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);        // Activity Widget
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']); // Comments Widget
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);  // Incoming Links Widget
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);         // Plugins Widget
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);    // Quick Press Widget
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);     // Recent Drafts Widget
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);           //
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);         //
		// remove plugin dashboard boxes
		// unset($wp_meta_boxes['dashboard']['normal']['core']['yoast_db_widget']);           // Yoast's SEO Plugin Widget
		unset($wp_meta_boxes['dashboard']['normal']['core']['rg_forms_dashboard']);        // Gravity Forms Plugin Widget
		unset($wp_meta_boxes['dashboard']['normal']['core']['bbp-dashboard-right-now']);   // bbPress Plugin Widget
	}
	add_action( 'wp_dashboard_setup', 'disable_default_dashboard_widgets' );
}
// remove WP version from RSS
if ( !function_exists( 'rss_version' ) ) {
	function rss_version() { return ''; }
	add_filter( 'the_generator', 'rss_version' );
}
// remove WP version from scripts
if ( !function_exists( 'remove_wp_ver_css_js' ) ) {
	function remove_wp_ver_css_js( $src ) {
		if ( strpos( $src, 'ver=' ) )
			$src = remove_query_arg( 'ver', $src );
		return $src;
	}
	add_filter( 'style_loader_src', 'remove_wp_ver_css_js', 9999 );
	add_filter( 'script_loader_src', 'remove_wp_ver_css_js', 9999 );
}
// remove pesky injected css for recent comments widget
if ( !function_exists( 'remove_wp_widget_recent_comments_style' ) ) {
	function remove_wp_widget_recent_comments_style() {
		if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
			remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
		}
	}
	add_filter( 'wp_head', 'remove_wp_widget_recent_comments_style', 1 );
}
// remove injected CSS from recent comments widget
if ( !function_exists( 'remove_recent_comments_style' ) ) {
	function remove_recent_comments_style() {
		global $wp_widget_factory;
		if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
			remove_action( 'wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style') );
		}
	}
	add_action( 'wp_head', 'remove_recent_comments_style', 1 );
}
if ( !function_exists( 'remove_menus' ) ) {
	function remove_menus(){
		// remove_menu_page( 'index.php' );                  //Dashboard
		// remove_menu_page( 'edit.php' );                   //Posts
		// remove_menu_page( 'upload.php' );                 //Media
		// remove_menu_page( 'edit.php?post_type=page' );    //Pages
		remove_menu_page( 'edit-comments.php' );          //Comments
		// remove_menu_page( 'themes.php' );                 //Appearance
		// remove_menu_page( 'plugins.php' );                //Plugins
		// remove_menu_page( 'users.php' );                  //Users
		// remove_menu_page( 'tools.php' );                  //Tools
		// remove_menu_page( 'options-general.php' );        //Settings
	}
	add_action( 'admin_menu', 'remove_menus' );
}
// Enable font size & font family selects in the editor
if ( !function_exists( 'wpex_mce_buttons' ) ) {
	function wpex_mce_buttons( $buttons ) {
			// array_unshift( $buttons, 'fontselect' ); // Add Font Select
			array_unshift( $buttons, 'fontsizeselect' ); // Add Font Size Select
			// array_unshift($buttons, 'styleselect'); // Add stle select
			return $buttons;
	}
	add_filter( 'mce_buttons_2', 'wpex_mce_buttons' );
}
// Customize mce editor font sizes
if ( !function_exists( 'wpex_mce_text_sizes' ) ) {
	function wpex_mce_text_sizes( $initArray ){
		$initArray['fontsize_formats'] = "9px 10px 11px 12px 13px 14px 16px 18px 21px 24px 28px 32px 36px";
		return $initArray;
	}
	add_filter( 'tiny_mce_before_init', 'wpex_mce_text_sizes' );
}



