<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class tcrw_config {

	public function getConf() {

		$this->merchant = get_option("tc_merchant");
		$this->lang = get_option("tc_lang");
		$this->country = get_option("tc_country");
		$this->useTcJs = get_option("tc_usetcjs");
		$this->tagli = get_option("tc_tagli");
		$this->alias = get_option("tc_alias");
		$this->merchant_email = get_option("tc_merchant_email");
		$this->order_detail = get_option("tc_set_order_detail");
		$this->order_item = get_option("tc_set_order_item");
		$this->debug = get_option("tc_debug");
		$this->tcUrl = get_option("tc_URL");
		$this->form_layout = get_option("tc_form_layout");
		return $this;

	}


}


