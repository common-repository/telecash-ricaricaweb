<?php
/*
Plugin Name: Telecash Ricaricaweb
Plugin URI:  http://www.telecash.it/servizi/ricarica-web/plugins-ricaricaweb/#wordpress
Description: Implement Ricaricaweb functions into your Wordpress blog
Version:     2.2
Author:      Gabriele Valenti
Author URI:  http://www.acticode.it
*/

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

define( 'tcrw_NAME',                 'Telecash Ricaricaweb' );
define( 'tcrw_REQUIRED_PHP_VERSION', '5.3' );
define( 'tcrw_REQUIRED_WP_VERSION',  '3.1' );

function tcrw_requirements_met() {
	global $wp_version;

	require_once( ABSPATH . '/wp-admin/includes/plugin.php' );

	if ( version_compare( PHP_VERSION, tcrw_REQUIRED_PHP_VERSION, '<' ) ) {
		return false;
	}

	if ( version_compare( $wp_version, tcrw_REQUIRED_WP_VERSION, '<' ) ) {
		return false;
	}

	return true;
}

function tcrw_requirements_error() {
	global $wp_version;

	require_once( dirname( __FILE__ ) . '/views/requirements-error.php' );
}

function tcrw_ricaricaweb_buttons( $buttons ) {
   array_push( $buttons, 'separator', 'TelecashRicaricaweb' );
   return $buttons;
}

function tcrw_ricaricaweb_buttons_js( $plugin_array ) {
   $plg = tcrw_Settings::get_instance();
   $ops = $plg->settings["instances"];
   $strs = array();
   foreach ($ops as $k => $op)
           $_SESSION["tcrw_instances"][] = "{text:'".$op["tc_merchant"].(($op["tc_alias"]!="")?" (".$op["tc_alias"].")":"")."',value:'$k'}";
   $purl = plugins_url( 'addInstance.php', __FILE__ );
   $plugin_array['TelecashRicaricaweb'] = plugins_url( '/javascript/editor.js.php?its='.base64_encode(serialize($_SESSION["tcrw_instances"])).'&p='.base64_encode($purl),__FILE__ );
   return $plugin_array;
}

if ( tcrw_requirements_met() ) {

	require_once( __DIR__ . '/classes/ricaricaweb.php' );
	require_once( __DIR__ . '/classes/tcrw-module.php' );
	require_once( __DIR__ . '/classes/tcrw-ricaricaweb.php' );
	require_once( __DIR__ . '/includes/admin-notice-helper/admin-notice-helper.php' );
	require_once( __DIR__ . '/classes/tcrw-settings.php' );
	require_once( __DIR__ . '/classes/tcrw-shortcodes.php' );

	if ( class_exists( 'tcrw_ricaricaweb' ) ) {
		$GLOBALS['tcrw'] = tcrw_ricaricaweb::get_instance();
		register_activation_hook(   __FILE__, array( $GLOBALS['tcrw'], 'activate' ) );
		register_deactivation_hook( __FILE__, array( $GLOBALS['tcrw'], 'deactivate' ) );
		add_filter( 'mce_buttons', 'tcrw_ricaricaweb_buttons' );
		add_filter( 'mce_external_plugins', 'tcrw_ricaricaweb_buttons_js' );
	}

} else {
	add_action( 'admin_notices', 'tcrw_requirements_error' );
}
