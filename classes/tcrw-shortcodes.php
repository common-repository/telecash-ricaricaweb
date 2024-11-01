<?php

if ( ! defined( 'ABSPATH' ) ) exit;

// declare TC Ricaricaweb shortcodes

function fn_shortcode_tcrw($atts) {

	$id = $atts["id"];
	if ($id!="") {
		$conf = get_option("tcrw_settings");
		//$instance = $conf["instances"]["tc_instances"][$id];
		$instance = $conf["instances"][$id];
//		$instance["tc_merchant"] = $conf["basic"]["tc_merchant"];
		$instance["tc_merchant_email"] = $conf["basic"]["tc_merchant_email"];
		$instance["tc_url"] = $conf["advanced"]["tc_URL"];
//		$instance["template"] = dirname( __FILE__ )."/../tc_ricaricaweb.tpl";
		$instance["template"] = dirname( __FILE__ )."/../templates/".$instance["tc_template"];
		if ($conf["advanced"]["tc_debug"]=="1")
			$instance["tc_debug"] = "1";
		$rw = new telecash_ricaricaweb();
		$page = $rw->manageResponse($instance);
		return $page;
	}

}

add_shortcode("tcrw", "fn_shortcode_tcrw");

