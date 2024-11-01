<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class telecash_messages {

	public $items;

	public function load() {
		global $wp_version;
		$this->items = parse_ini_file(dirname(__FILE__)."/messages.ini", true);
		// Wordpress
		if ($wp_version!="") {
			$extitems = get_option( 'tcrw_settings' );
			$this->items = array_merge($this->items,array("translations"=>$extitems["translations"]));
		}
		// Joomla
		// Prestashop
		// Magento
	}

}
