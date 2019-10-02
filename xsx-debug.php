<?php
/*
 * Plugin Name: xsx-debug
 * Plugin URI: https://github.com/xxsimoxx/xsx-debug
 * Description: toggle php debug 
 * Version: 0.0.4-dev
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Author: Gieffe edizioni srl
 * Author URI: https://www.gieffeedizioni.it/classicpress
 * Text Domain: xsxdebug
 * GitHub Plugin URI: xxsimoxx/xsx-debug
 */

if (!defined('ABSPATH')){
	die('-1');
};

/*
 *
 * Load text domain
 *
 */
add_action( 'plugins_loaded', 'xsx_debug_load_textdomain' );
function xsx_debug_load_textdomain() {
	load_plugin_textdomain( 'xsxdebug', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
}

/*
 *
 *  handle ajax call used to toggle settings
 *
 */
add_action( 'wp_ajax_xsx_debug_toggle', 'xsx_debug_toggle' );
function xsx_debug_toggle() {
	global $wpdb;
	if( current_user_can( 'manage_options' ) ){
		$xsx_debug_status = get_option ( 'xsx-debug' );
		update_option( 'xsx-debug', ! $xsx_debug_status );
	}
	exit();
}

/*
 *
 *  enable php debugging
 *
 */
function minimizeCSSsimple($css){
	$css = preg_replace('/\/\*((?!\*\/).)*\*\//','',$css); // negative look ahead
	$css = preg_replace('/\s{2,}/',' ',$css);
	$css = preg_replace('/\s*([:;{}])\s*/','$1',$css);
return $css;
}

if ( get_option ( 'xsx-debug' ) ){
	ini_set('display_startup_errors', true);
	error_reporting(E_ALL);
	ini_set('display_errors', true);
	// Thanks to John Alarcon for the idea.
	// https://codepotent.com/improved-php-error-reporting-in-classicpress/
	$xsx_debug_style_open = "
		width: 100%;
		padding: 2px;
		position: absolute;
		z-index: 10000;
		overflow: auto;
		font-family: monospace;
		font-size: 12pt;
		color: white;
		background-color: rgba(137,40,143,0.8);
		border: 1px solid black;
	";
	ini_set('error_prepend_string', '<div style="' . minimizeCSSsimple($xsx_debug_style_open) . '">');
	ini_set('error_append_string', "<a href='#' style='color:white' onClick='this.parentNode.style.display=\"none\";'>" . __( "CLOSE", "xsxdebug") . "</a></div>");
}

/*
 *
 *  add our button to menu bar and make it work
 *
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
 * 
 * uninstall hook
 *
 */
register_uninstall_hook( __FILE__ , 'xsx_debug_cleanup' );
function xsx_debug_cleanup (){
	delete_option( 'xsx-debug' );
}

/**
 *
 * activation hook
 *
 */
register_activation_hook( __FILE__, 'xsx_debug_activate' );
function xsx_debug_activate() {
	$all_ini = ini_get_all();
	if ( ! $all_ini['error_reporting']['access'] & 1 ){
		// Check if the user can modify settings
		// and if not warn him.
		set_transient( 'xsx-debug-notice', true, 10 );
	};
    update_option( 'xsx-debug', false );
}

add_action( 'admin_notices', 'xsx_debug_notice' );
function xsx_debug_notice(){
	if( get_transient( 'xsx-debug-notice' ) ){
		echo'<div class="notice notice-warning  is-dismissible"><p>';
		_e( "xsx-debug can't change <i>display_errors</i>. You have to do it manually.", "xsxdebug" );
		echo '</p></div>';
		delete_transient( 'xsx-debug-notice' );
	}
}
?>