<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/*
*
*	Telecash - Ricarica Web
*	ver. 1.0
*
*/

include "messages.php";
include "config.php";
include "database.php";

class telecash_ricaricaweb {

	private $_dblink;
	private $_conf;
	private $messages;

	public $currLang = "";

	public function __construct() {
		$this->loadConf();
	}

	public function __destruct() {}

	public function setup() {}

	// create and collect the basic info for a request
	public function getRequestBaseData($code="", $ek="") {

		$rk = ($ek!="")?$ek:$this->requestKey($code);
		$rdata = array();
		$page = explode("?", $_SERVER['REQUEST_URI'], 2);
		$rdata["tc_url_ok_dinamic"] = "http://".$_SERVER['HTTP_HOST'].$page[0]."?rres=OK";
		$rdata["tc_url_ko_dinamic"] = "http://".$_SERVER['HTTP_HOST'].$page[0]."?rres=KO";
		$rdata["tc_payment_notification"] = "http://".$_SERVER['HTTP_HOST'].$page[0]."?mng=1";
		//$rdata["tc_payment_notification"] = urlencode("http://moneymaster.telecash.it/rpc/operate.php?cmd=updatetrack");
		$rdata["tc_custom1"] = $rk;
		return $rdata;

	}

	public function getForm($conf=array()) {

		$conf = array_merge($conf, $this->getRequestBaseData($conf["tc_alias"], $_REQUEST["mres"]));
		$rows = array();

//		$trakingdata = $this->getUrl("http://moneymaster.telecash.it/rpc/operate.php?cmd=starttrack&tcode=".$conf["tc_custom1"]."&tproductid=".$conf["tc_affiliate_merchant"]);

		if ($conf["tc_merchant"]=="")
			return $rows[] = $this->messages["error_messages"]["ERR_MSG_NO_INSTANCE_FOUND"];

		$cssclass = "";
		$cssclass .= ($conf["tc_has_paypal"]=="1")?"":"nopaypal";
		$action = ($conf["tc_affiliate_merchant"]!="")?"http://panel.moneymaster.it/rpc/send.php":$conf["tc_url"];
		$rows[] = "<form action='".$action."' method='POST' id='form_tc_service' class='$cssclass' onsubmit=\"return checkStartPay();\">";
		$inopf = array("tc_usetcjs","tc_url","tc_taglio","tc_require_customer_email","tc_has_paypal","tc_template","template","tc_disable_paypal","tc_affiliate_merchant","tc_doublenum","tc_coupon_enable","tc_coupon_enable_default","tc_coupon_default","tc_coupon_default_hidden");
		$conf["tc_custom2"] = $conf["tc_affiliate_merchant"];

		if ($conf["tc_usetcjs"]=="1") {
			$inopf[] = "tc_country";
			$usetcjs=true;
		}

		foreach ($conf as $bfk => $bfv) {
			if (!in_array($bfk, $inopf)) {
				if ($bfv!="") {
					if ($bfk=="tc_set_phone_credit"&&$bfv=="1")
						$rows[] = "<input type=hidden id='$bfk' name='".substr($bfk,3)."' value='0' />";
					else
						$rows[] = "<input type=hidden id='$bfk' name='".substr($bfk,3)."' value='$bfv' />";
				}
			}
		}

		if ($conf["tc_coupon_enable"]=="1") {
			if ($conf["tc_coupon_enable_default"]=="1")
				$rows[] = "<input type=hidden id='tc_coupon' name='coupon' value='".$conf["tc_coupon_default"]."' />";
		}

		if (!in_array("tc_set_phone_credit", array_keys($conf)))
			$rows[] = "<input type=hidden id='tc_set_phone_credit' name='set_phone_credit' value='1' />";

		if ($usetcjs) {
			$rows[] = "<div class='tc_field'><select id='tc_taglio' name='taglio'></select></div>";
			$rows[] = "<div class='tc_field'><select id='tc_country' name='country'></select></div>";
		} else {
			$stropts = explode(";", $conf["tc_taglio"]);
			if (count($stropts)==1) {
				$rows[] = "<input type='hidden' name='taglio' id='tc_taglio' value='".$conf["tc_taglio"]."' />";
				$wideani = 1;
			} else {
				$rows[] = "<div class='tc_field'><select id='tc_taglio' name='taglio'>";
				foreach ($stropts as $opt) {
					$pcs = explode("|", $opt);
					$rows[] = "<option value='".$pcs[0]."'>".$pcs[1]."</option>";
				}
				$rows[] = "</select></div>";
			}
		}

		$rows[] = "<div class='tc_field ".(($wideani)?"wide":"")."'><input type='text' name='ani' id='tc_ani' size=35 maxlength=35 tabindex=1 placeholder='".$this->messages["translations"][$this->currLang]["tc_string_yourphonenumber"]."' /></div>";
		if ($conf["tc_doublenum"]=="1")
			$rows[] = "<div class='tc_field ".(($wideani)?"wide":"")."'><input type='text' name='anicheck' id='anicheck' size=35 maxlength=35 tabindex=1 placeholder='".$this->messages["translations"][$this->currLang]["tc_string_yourphonenumber2"]."' /></div>";


		if ($conf["tc_coupon_enable"]=="1") {
			if ($conf["tc_coupon_enable_default"]=="1"&&$conf["tc_coupon_default_hidden"]!="1")
				$rows[] = "<div class='tc_field'><span class='coupon'>".$conf["tc_coupon_default"]."</span></div>";
			elseif ($conf["tc_coupon_enable_default"]!="1")
				$rows[] = "<div class='tc_field'><input type=text id='tc_coupon' name='coupon' value='' placeholder='".$this->messages["translations"][$this->currLang]["tc_string_insertcoupon"]."' /></div>";
		}

		// payment method
		switch ($conf["tc_disable_paypal"]) {
			case "0": // paypal and cc
/*
				$rows[] = "<div class='tc_field wide'>
					<label class='pwselector'><input type='radio' name='disable_paypal' id='tc_disable_paypal' placeholder='' value='0' checked='checked' class='paypal' />&nbsp;<img src='/wp-content/plugins/tc_ricaricaweb/templates/images/paypal.png' border='0' align='absmiddle' /></label>
					<label class='pwselector'><input type='radio' name='disable_paypal' id='tc_disable_paypal' placeholder='' value='1' class='creditcard' />&nbsp;<img src='/wp-content/plugins/tc_ricaricaweb/templates/images/credit-card.png' border='0' align='absmiddle' /></label>
					</div>";
*/
				$rows[] = "<div class='tc_field wide'>
					<label class='pwselector paypal'><input type='radio' name='disable_paypal' id='tc_disable_paypal' placeholder='' value='0' class='paypal' onclick='switchRadio(\"tc_disable_paypal\", this);' /></label>
					<label class='pwselector creditcard checked'><input type='radio' name='disable_paypal' id='tc_disable_paypal' placeholder='' value='1' class='creditcard' checked='checked' onclick='switchRadio(\"tc_disable_paypal\", this);' /></label>
					</div>";
				$conf["template"] = dirname(__FILE__)."/../templates/tc_ricaricaweb_both.tpl";
				break;
			case "1": // only paypal
				$rows[] = "<input type='hidden' name='disable_paypal' id='tc_disable_paypal' value='0'>";
				$conf["template"] = dirname(__FILE__)."/../templates/tc_ricaricaweb_paypal.tpl";
				break;
			case "2": // only cc
				$rows[] = "<input type='hidden' name='disable_paypal' id='tc_disable_paypal' value='1'>";
				$conf["template"] = dirname(__FILE__)."/../templates/tc_ricaricaweb_cc.tpl";
				break;
		}

		if ($conf["tc_require_customer_email"]=="1")
			$rows[] = "<div class='tc_field'><input type='text' name='customer_email' id='tc_customer_email' size=35 maxlength=100 tabindex=2 placeholder='".$this->messages["translations"][$this->currLang]["tc_string_youremail"]."' /></div>";

		$rows[] = "<div class='tc_button wide'><input type='submit' value='".$this->messages["translations"][$this->currLang]["tc_string_pay"]."' name='B1' /></div>";
//		$rows[] = "<div class='tc_button'><input type='reset' value='".$this->messages["translations"][$this->currLang]["tc_string_cancel"]."' name='reset' /></div>";

		$rows[] = "</form>";

		if ($conf["tc_doublenum"]=="1")
			$rows[] = "<style>
			@media screen
  and (min-device-width: 320px)
  and (max-device-width: 480px)
  and (-webkit-min-device-pixel-ratio: 2)
  and (orientation: portrait) {

				.tc_div_ricaricaweb.paypal:after, .tc_div_ricaricaweb.cc:after {margin-top:43%;}.tc_div_ricaricaweb:after {margin-top:75%;}
			}
			</style>";

		if ($usetcjs) {
			add_action('wp_footer', 'tc_add_javascript');
			//$rows[] = "<script src='https://secure.tcserver.it/js/tc.js'></script>";
		}
		add_action('wp_footer', 'tc_add_javascript_x');

		$tpl = file_get_contents($conf["template"]);
		$out = str_replace("##fields##", join("", $rows), $tpl);

//		return join("", $rows);
		return $out;

	}

	// manage the response from TC server
	public function manageResponse($conf=array()) {

		$rk = sanitize_text_field($_REQUEST["custom1"]);
		$apid = sanitize_text_field($_REQUEST["custom2"]);
		$rkc = $this->validRK($rk);
		$find = preg_match("/_([A-Za-z\s]+)$/", $rkc[1]->result_descr, $statusmessage);

		$trakingdata = json_decode($this->getUrl("http://moneymaster.telecash.it/rpc/operate.php?cmd=gettrack&tcode=$rk&tproductid=$apid"));

		if ($rkc[0]) {

			$result = sanitize_text_field($_REQUEST["result"]);
			$rescode = sanitize_text_field($_REQUEST["result_code"]);
			$resmsg = $this->messages["return_codes"][sanitize_text_field($_REQUEST["result_code"])];

			if (sanitize_text_field($_REQUEST["rres"])=="OK") {
				$result = "<div class='tc_message_confirm'>".$this->messages["translations"][$this->currLang]["tc_string_paymentok"]."</div>";
				if ($apid!="")
					$result .= '<img src="http://moneymaster.telecash.it/scripts/sale.php?TotalCost='.$trakingdata->tamount.'&OrderID='.$trakingdata->tcode.'&ProductID='.$trakingdata->tproductid.'" width="1" height="1" >';
			}

			if (sanitize_text_field($_REQUEST["rres"])=="KO") {
				$ERRMSG = $this->messages["return_codes"][$_REQUEST["result_code"]];
				$result = "<div class='tc_message_error'>".$this->messages["translations"][$this->currLang]["tc_string_paymenterr"]."<br />Errore: ".$ERRMSG."</div>";
			}

			if (sanitize_text_field($_REQUEST["mng"])=="1") {

				$status = (sanitize_text_field($_REQUEST["result"])=="OK")?"validated":"failed";
				$q = "update tcrw_tickets set merchant='%s',service_type=%s,status='%s',transaction_id='%s',result='%s',result_code='%s',result_descr='%s',amount='%s',endat='%s',credit_time='%s',service_phone='%s',ps='%s', customer_email='%s' where rk='$rk'";
				$q = sprintf($q,
	                                sanitize_text_field($_REQUEST["merchant"]),
	                                sanitize_text_field($_REQUEST["service_type"]),
	                                $status,
	                                sanitize_text_field($_REQUEST["transaction_id"]),
	                                sanitize_text_field($_REQUEST["result"]),
	                                sanitize_text_field($_REQUEST["result_code"]),
	                                sanitize_text_field($_REQUEST["result_descr"]),
	                                sanitize_text_field($_REQUEST["amount"]),
	                                sanitize_text_field($_REQUEST["timestamp"]),
	                                sanitize_text_field($_REQUEST["credit_time"]),
	                                sanitize_text_field($_REQUEST["service_phone"]),
	                                sanitize_text_field($_REQUEST["ps"]),
	                                sanitize_email($_REQUEST["customer_email"])
	                        );

				$this->_dblink->query($q);

			} else {

				$status = (sanitize_text_field($_REQUEST["result"])=="OK")?"validated":"failed";
				$q = "update tcrw_tickets set status='%s',transaction_id='%s',result='%s',result_code='%s',result_descr='%s',amount='%s',endat='%s',credit_time='%s',service_phone='%s',ps='%s',customer_email='%s' where rk='$rk'";
				$q = sprintf($q,
	                                $status,
	                                sanitize_text_field($_REQUEST["transaction_id"]),
	                                sanitize_text_field($_REQUEST["result"]),
	                                sanitize_text_field($_REQUEST["result_code"]),
	                                sanitize_text_field($_REQUEST["result_descr"]),
	                                sanitize_text_field($_REQUEST["amount"]),
	                                sanitize_text_field($_REQUEST["timestamp"]),
	                                sanitize_text_field($_REQUEST["credit_time"]),
	                                sanitize_text_field($_REQUEST["service_phone"]),
	                                sanitize_text_field($_REQUEST["ps"]),
	                                sanitize_email($_REQUEST["customer_email"])
	                        );

				$this->_dblink->query($q);

			}

			$result .= $this->getForm($conf);
			return $result;

		} else {

			return $this->getForm($conf);

		}

	}

	// create a request key
	private function requestKey($code="") {

		$rk = md5($this->_conf->merchant.time());
		$_SESSION["TcRw_Rk"] = $rk;
		$q = "insert into tcrw_tickets (rk,startat,status,service_phone) values ('$rk', now(), 'created', '$code')";
		$this->_dblink->query($q);
		return $rk;

	}

	// validate the current request key
	private function validRK($tcrk="") {
		$r = $this->_dblink->select("select * from tcrw_tickets where rk='$tcrk'");
//		return array(($r[0]->status!=""&&$r[0]->status!="failed"&&$r[0]->status!="cancelled"),$r);
		return array(($r[0]->id!=""),$r[0]);
	}

	private function getCurrLang() {
		global $wp_version;
		$supported = array("it","en","es","fr","de");
		// Wordpress
		if ($wp_version!="") {
			$cl = substr(get_bloginfo( 'language' ), 0, 2);
		}
                // Joomla
                // Prestashop
                // Magento

		if (in_array($cl,$supported))
			return $cl;
		else
			return "en";

	}

	// load confiugration from the current environment
	private function loadConf() {
		$this->_dblink = new tcrw_db();
		$confloader = new tcrw_config();
		$this->_conf = $confloader->getConf();
		$_messages = new telecash_messages();
		$_messages->load();
		$this->messages = $_messages->items;
		$this->currLang = $this->getCurrLang();
		foreach ($this->messages["static_strings"] as $k => $v) {
			if ($this->messages["translations"][$this->currLang][$k]=="")
				$this->messages["translations"][$this->currLang][$k]=$v;
		}
	}

	private function getUrl($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		$res = curl_exec($ch);
		curl_close($ch);
		return $res;
	}

}


function tc_add_javascript() {
   wp_register_script('custom_script',
       'https://secure.tcserver.it/js/tc.js',
       array('jquery'),
       '1.0',
       true);
   wp_enqueue_script('custom_script');
}
function tc_add_javascript_x() {
   wp_register_script('custom_script_x',
       plugins_url( 'telecash-ricaricaweb/javascript/frontend.js' ),
       array('jquery'),
       '1.0',
       true);
   wp_enqueue_script('custom_script_x');
}
