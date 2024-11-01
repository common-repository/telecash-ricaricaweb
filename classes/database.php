<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class tcrw_db {
	
	public function __construct() {
	}
	
	public function query($q) {
		global $wpdb;
		return $wpdb->query($q);
	}
	
	public function select($q) {
		global $wpdb;
		return $wpdb->get_results($q);
	}
	
}
