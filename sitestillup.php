<?php
/* 
Plugin Name: Sitestillup
Plugin URI: http://www.sitestillup.com/
Description: Sitestillup provides round the clock site monitoring and notifies via Email & SMS the instant there's a problem, giving you peace of mind.
Author: Pertly for The Response Control Group
Version: 2.0
*/


if(!defined('ABSPATH')) die('You are not allowed to call this page directly.');

define("STU_PLUGIN_DIR", plugin_dir_path(__FILE__)); 
define("STU_PLUGIN_URL", plugin_dir_url(__FILE__) ); 
require_once( STU_PLUGIN_DIR . "includes/stu_functions.php" );
/**
 * Sitestillup plugin activation.
 */
register_activation_hook( __FILE__, 'stu_activate' );
function stu_activate() {   
	global $wpdb;
	$id  = $st = $si = $po = "";
	$opts = get_option('stu_warrenty_id');
	if( !empty($opts) ):
		$id = $opts['sitestillup'];
	endif;	
	if( empty($si) )
		$opt['sitestillup'] = sanitize_text_field( '' );	
	if( empty($opts) )	
		update_option( 'stu_warrenty_id', $opt );	
	
	$opts = get_option('stu_settings'); 
	if( !empty($opts) ):			
		$si = $opts['stu_size'];
		$st = $opts['stu_style'];
		$po = $opts['stu_protocol'];
	endif;	
	
	if( empty($si) )
		$options['stu_size'] = sanitize_text_field( '220' );
	if( empty($st) )
		$options['stu_style'] = sanitize_text_field( 'a' );
	if( empty($po) )
		$options['stu_protocol'] = sanitize_text_field( '2' );
	if( empty($opts) )
		update_option( 'stu_settings', $options );	
		
	add_option('activation_redirect', true);					 	 		  
}	

/**
 * Plugin Custom Menus.
 */
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'add_settings_link' );
function add_settings_link($links) {
	$settings_link = '<a href="admin.php?page=warranty_settings">Settings</a>';
	array_unshift($links, $settings_link);
	return $links;
}

/**
 * Redirect after plugin activation.
 */ 
add_action('admin_init', 'sitestillup_redirect');
function sitestillup_redirect() {
    if (get_option('activation_redirect', false)) {
        delete_option('activation_redirect');
		$admin_loc = admin_url();
		$re_url = $admin_loc."admin.php?page=warranty_settings";
        wp_redirect($re_url);
    }
}


function Update_css()
{			
	include_once( STU_PLUGIN_DIR . "includes/stu_css.php" );
}

require_once STU_PLUGIN_DIR . 'includes/sitestillup.php';
new Sitestillup();
?>