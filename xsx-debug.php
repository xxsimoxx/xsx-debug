<?php
/*
* Plugin Name: xsx-debug
* Plugin URI: https://www.gieffeedizioni.it/classicpress
* Description: toggle php debug 
* Version: 0.0.1
* License: GPL2
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Author: Gieffe edizioni srl
* Author URI: https://www.gieffeedizioni.it/classicpress
* Text Domain: xsxdebug
*/

if (!defined('ABSPATH')) die('-1');

/*
* Load text domain
*/
add_action( 'plugins_loaded', 'xsx_debug_load_textdomain' );
function xsx_debug_load_textdomain() {
	load_plugin_textdomain( 'xsxdebug', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
}

/*
*  handle ajax call
*/
add_action( 'wp_ajax_xsx_debug_toggle', 'xsx_debug_toggle' );
function xsx_debug_toggle() {
	global $wpdb;
	if( current_user_can( 'manage_options' ) ){
		$xsx_debug_status = get_option ( 'xsx-debug' );
		update_option( 'xsx-debug', ! $xsx_debug_status );
	}
	echo "OK!";
	exit();
}

/*
*  enable php debugging if the option sais to
*/
if ( get_option ( 'xsx-debug' ) ){
	ini_set('display_startup_errors', true);
	error_reporting(E_ALL);
	ini_set('display_errors', true);
}

/*
*  add our button to menu bar and make it work
*/
add_action('init','xsx_debug_setup');
function xsx_debug_setup(){
	if( current_user_can( 'manage_options' ) && is_admin() ){
		add_action( 'wp_before_admin_bar_render', 'xsx_debug_addtoolbar' );
		wp_enqueue_style( 'xsx_debug_css', plugins_url( 'css/xsx-debug.css', __FILE__ ) );
		wp_register_script( 'xsx_debug_js', plugins_url( 'js/xsx-debug.js', __FILE__ ) );
		$xsx_debug_translation_array = array(
			'message' => __( "Do you want to toggle PHP DEBUG?\nIt will reload the page and you'll loose your changes...", 'xsxdebug' ),
			'url' => admin_url( 'admin-ajax.php' )
		);
		wp_localize_script( 'xsx_debug_js', 'xsx_debug_translation', $xsx_debug_translation_array );
		wp_enqueue_script( 'xsx_debug_js' );
	}
}

function xsx_debug_addtoolbar() {
	global $wp_admin_bar;
	$xsx_debug_title = ( get_option ( 'xsx-debug' ) ) ? __( "PHP DEBUG ENABLED", 'xsxdebug' ) : __( "PHP DEBUG DISABLED", 'xsxdebug' ) ;
	$xsx_debug_css   = ( get_option ( 'xsx-debug' ) ) ? "xsx-debug-toggle xsx-debug-red" : "xsx-debug-toggle xsx-debug-green" ;
	$wp_admin_bar->add_node(array(
		'id'    => 'xsx_debug',
		'title' => $xsx_debug_title,
		'meta'  => array("class" => $xsx_debug_css),
		'href'  => '#',
	));
}

/**
* uninstall hook
*/

register_uninstall_hook( __FILE__ , 'xsx_debug_cleanup' );
function xsx_debug_cleanup (){
	delete_option( 'xsx-debug' );
}

/**
* activation hook
*/
register_activation_hook( __FILE__, 'xsx_debug_activate' );
function xsx_debug_activate() {
    update_option( 'xsx-debug', false );
}


?>