<?php
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php if ( 'tc_merchant' == $field['label_for'] ) : ?>

	<input id="<?php esc_attr_e( 'tcrw_settings[basic][tc_merchant]' ); ?>" name="<?php esc_attr_e( 'tcrw_settings[basic][tc_merchant]' ); ?>" class="regular-text" value="<?php esc_attr_e( $settings['basic']['tc_merchant'] ); ?>" />
	<span class="example">Eg. 00000</span>

<?php endif; ?>

<?php if ( 'tc_merchant_email' == $field['label_for'] ) : ?>

	<input id="<?php esc_attr_e( 'tcrw_settings[basic][tc_merchant_email]' ); ?>" name="<?php esc_attr_e( 'tcrw_settings[basic][tc_merchant_email]' ); ?>" class="regular-text" value="<?php esc_attr_e( $settings['basic']['tc_merchant_email'] ); ?>" />
	<span class="example">Eg. yourname@yoursite.com</span>

<?php endif; ?>


<?php if ( 'tc_URL' == $field['label_for'] ) : ?>

	<input id="<?php esc_attr_e( 'tcrw_settings[basic][tc_URL]' ); ?>" name="<?php esc_attr_e( 'tcrw_settings[basic][tc_URL]' ); ?>" class="regular-text" value="<?php esc_attr_e( $settings['advanced']['tc_URL'] ); ?>" />
	<p class="description">This is the URL where all your data will be sent. <strong>Leave empty to use the default URL</strong> (recommended).</p>

<?php endif; ?>

<?php if ( 'tc_debug' == $field['label_for'] ) : ?>

	<input type=checkbox id="<?php esc_attr_e( 'tcrw_settings[advanced][tc_debug]' ); ?>" name="<?php esc_attr_e( 'tcrw_settings[advanced][tc_debug]' ); ?>" <?php if($settings['advanced']['tc_debug']==1) echo "value=1 checked=checked"; else echo "value=0"; ?>" onclick="switchChkValue(this);" />
	<p class="description">Enable debugging for all instances.</p>

<?php endif; ?>

<?php
if ( 'tc_instances' == $field['label_for'] ) {

	$rows = $settings['instances'];

	if (!is_array($rows))
		$rows = array();

?>

<p class="submit">
	<input type="button" name="addinstance" id="addinstance" class="button-save" value="<?php esc_attr_e( 'Add instance' ); ?>" onclick="document.getElementById('addinstancew').style.display='block';" />
</p>

<div id='addinstancew' style='display:none;width:100%;heigth:120px;border:1px solid grey;'>
<table style="width:100%;display:block">
<?php
print '	<tr>
		<td class="column-columnname">
		<label for=add_tc_merchant>Merchant ID *</label>
		<input id=add_tc_merchant name=add_tc_merchant size=8 />
		</td>
		<td class="column-columnname">
		<label for=add_tc_alias>Alias Service Number</label>
		<input id=add_tc_alias name=add_tc_alias size=8 />
		</td>
		<td class="column-columnname">
		<label for=add_tc_disable_paypal>Payment methods</label>
		<select id=add_tc_disable_paypal name=add_tc_disable_paypal>
			<option value="0" selected=selected>Paypal and Credit Card</option>
			<option value="1">Only Paypal</option>
			<option value="2">Only Credit Card</option>
		</select>
		</td>
		<td class="column-columnname">
		<label for=add_tc_doublenum>verify client phone number</label>
		<input type=checkbox id=add_tc_doublenum name=add_tc_doublenum value="1" checked=checked onclick="switchChkValue(this);" />
		</td>
		<td class="column-columnname" style="width:260px">
		<label for=add_tc_coupon_enable>Enable coupon support</label>
		<input type=checkbox id=add_tc_coupon_enable name=add_tc_coupon_enable value="0" onclick="switchChkValueCouponAdd(this);" />
		<div style="background-color:white;padding:4px;border:1px solid #bebebe;border-radius:4px;display:none;" id="add_tc_coupon_enable_default_box">
		<input type=checkbox id=add_tc_coupon_enable_default name=add_tc_coupon_enable_default value="0" onclick="switchChkValueCouponAdd(this);" style="display:none;float:left;margin:0px;" />
		<label for=add_tc_coupon_enable_default id=add_tc_coupon_enable_default_label style="display:none;">&nbsp;Set predefined coupon</label>
		<input id=add_tc_coupon_default name=add_tc_coupon_default size=20 style="display:none;" placeholder="* Predefined coupon" />
		<input type=checkbox id=add_tc_coupon_default_hidden name=add_tc_coupon_default_hidden style="display:none;" value="0" />
		<label for=add_tc_coupon_default_hidden id=add_tc_coupon_default_hidden_label style="display:none;">&nbsp;Hide coupon</label>
		</div>
		</td>
<!--
		<td class="column-columnname">
		<label for=add_tc_template>Instance template</label>
		<select id=add_tc_template name=add_tc_template class=narrow>';
		$dets = array("tc_ricaricaweb_cc.tpl" => _("Credit card"), "tc_ricaricaweb_paypal.tpl" =>_("Paypal"));
		foreach ($dets as $kd => $det)
			print '<option value="'.$kd.'">'.$det.'</option>';
print		'</select>
		</td>
-->
</tr>
<tr style="display:none;padding:4px;background-color:#ccc;border-radius:6px;" id="addAdvanced">
		<td class="column-columnname" style="width:100% !important;">
		<h3>These settings are optional, set them only if necessary.</h3>
		</td>
                <td class="column-columnname">
                <label for=add_tc_affiliate_merchant>Affiliation Merchant ID</label>
                <input id=add_tc_affiliate_merchant name=add_tc_affiliate_merchant size=8 />
                </td>
		<td class="column-columnname">
		<label for=add_tc_country>Country prefix</label>
		<input id=add_tc_country name=add_tc_country size=4 />
		</td>
		<td class="column-columnname">
		<label for=add_tc_lng>Language</label>
		<select id=add_tc_lng name=add_tc_lng>';
		$langs = array("ITA","FRA","ENG","SPA","DEU");
		foreach ($langs as $lang)
			print '<option value="'.$lang.'">'.$lang.'</option>';
print		'</select>
		</td>
		<td class="column-columnname">
		<label for=add_tc_usetcjs>Use Telecash Javascript</label>
		<input type=checkbox id=add_tc_usetcjs name=add_tc_usetcjs value="1" checked=checked onclick="switchChkValue(this);" />
		</td>
		<td class="column-columnname">
		<label for=add_tc_taglio>Refill amounts</label>
		<input id=add_tc_taglio name=add_tc_taglio size=8 />
		</td>
		<td class="column-columnname">
		<label for=add_tc_set_phone_credit>Apply phone recharge</label>
		<input type=checkbox id=add_tc_set_phone_credit name=add_tc_set_phone_credit value="1" checked=checked onclick="switchChkValue(this);" />
		</td>
		<td class="column-columnname">
		<label for=add_tc_set_order_detail>Override item detail</label>
		<select id=add_tc_set_order_detail name=add_tc_set_order_detail class=narrow>';
		$dets = array("0" => _("Service recharge"), "1" =>_("Recharge service by N minutes"), "2" => _("Recharge service XXX by N minutes"), "3" => _("Custom"));
		foreach ($dets as $kd => $det)
			print '<option value="'.$kd.'">'.$det.'</option>';
print		'</select>
		</td>
		<td class="column-columnname">
		<label for=add_tc_set_order_item>Override item description</label>
		<input id=add_tc_set_order_item name=add_tc_set_order_item size=8 />
		</td>
		<td class="column-columnname">
		<label for=add_tc_require_customer_email>Require customer email</label>
		<input type=checkbox id=add_tc_require_customer_email name=add_tc_require_customer_email value="0" onclick="switchChkValue(this);" />
		</td>
		<td class="column-columnname">
		<label for=add_tc_form_layout>Payment form layout</label>
		<select id=add_tc_form_layout name=add_tc_form_layout>';
		for ($fl=1;$fl<=12;$fl++) print "<option value='$fl' ".(($fl=="3")?"selected='selected'":"").">$fl</option>";
print		'</select>
		</td>
		<td class="column-columnname">
		<label for=add_page_background_color>Page background color (#XXXXXX)</label>
		<input id=add_page_background_color name=add_page_background_color size=8 />
		</td>
</tr>
<tr>
		<td class="last">
		<label for=></label>
		<input type=button class="button-primary" id=add_ok name=add_ok value="'._( 'Create instance' ).'" onclick="addInstance();" /> 
		<input type=button class="button-secondary" id=add_ko name=add_ko value="'._('Cancel' ).'" onclick="document.getElementById(\'addinstancew\').style.display=\'none\';" /> 
		<input type=button class="button-secondary" id=add_advanced value="advanced options..." onclick="toggleDiv(\'#addAdvanced\')" />
		</td>
	</tr>';
?>
</table>
</div>

<table class='widefat fixed'>
<thead>
	<tr>
		<th id='merchant' class='manage-column column-cb check-column' scope='col'>Merchant ID</th>
		<th id='alias' class='manage-column column-cb check-column' scope='col'>Alias Service Number</th>
		<th id='country' class='manage-column column-cb check-column' scope='col'>Payment methods</th>
		<th id='verifyphone' class='manage-column column-cb check-column' scope='col'>verify phone number</th>
		<th id='affmerchant' class='manage-column column-cb check-column' scope='col'>Coupon support</th>
		<th id='shortcode' class='manage-column column-cb check-column' scope='col'>shortcode</th>
		<th id='cmds' class='manage-column column-cb check-column' scope='col'>&nbsp;</th>
		<th id='null1' class='manage-column column-cb check-column' scope='col'>&nbsp;</th>
		<th id='null2' class='manage-column column-cb check-column' scope='col'>&nbsp;</th>
	</tr>
</thead>
<tfoot>
	<tr>
		<th id='merchant' class='manage-column column-cb check-column' scope='col'>Merchant ID</th>
		<th id='alias' class='manage-column column-cb check-column' scope='col'>Alias Service Number</th>
		<th id='country' class='manage-column column-cb check-column' scope='col'>Payment methods</th>
		<th id='verifyphone' class='manage-column column-cb check-column' scope='col'>verify phone number</th>
		<th id='affmerchant' class='manage-column column-cb check-column' scope='col'>Coupon support</th>
		<th id='shortcode' class='manage-column column-cb check-column' scope='col'>shortcode</th>
		<th id='cmds' class='manage-column column-cb check-column' scope='col'>&nbsp;</th>
		<th id='null1' class='manage-column column-cb check-column' scope='col'>&nbsp;</th>
		<th id='null2' class='manage-column column-cb check-column' scope='col'>&nbsp;</th>
	</tr>
</tfoot>
<tbody>
<?php

	foreach ($rows as $k => $row) {

if ($row["tc_merchant"]=="")
	continue;

$hascoupon = ($row[tc_coupon_enable_default]=="1")?1:0;

print '
	<tr>
		<td class="column-columnname">
		<input id="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_merchant]' ).'" name="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_merchant]' ).'" value="'.esc_attr( $row[tc_merchant] ).'" size=8 />
		</td>
		<td class="column-columnname">
		<input id="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_alias]' ).'" name="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_alias]' ).'" value="'.esc_attr( $row[tc_alias] ).'" size=8 />
		</td>
		<td class="column-columnname">
		<select id="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_disable_paypal]' ).'" name="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_disable_paypal]' ).'">';
		$pcs = array("0"=>"Paypal and Credit Card","1"=>"Only Paypal","2"=>"Only Credit Card");
		foreach ($pcs as $pk => $pv)
			print '<option '.(($pk==$row[tc_disable_paypal])?"selected=selected":"").' value="'.$pk.'">'.$pv.'</option>';
print		'</select>
		</td>
		<td class="column-columnname">
		<input type=checkbox id="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_doublenum]' ).'" name="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_doublenum]' ).'" '.(($row[tc_doublenum]=="1")?"checked=checked":"").' />
		</td>

		<td class="column-columnname">
		<label for="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_coupon_enable]' ).'">Enable coupon support</label>
		<input type=checkbox id="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_coupon_enable]' ).'" name="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_coupon_enable]' ).'" '.(($row[tc_coupon_enable]=="1")?"checked=checked value='1'":"").' onclick="switchChkValueCouponEdit(this, \''.$k.'\');" />
		<div style="background-color:white;padding:4px;border:1px solid #bebebe;border-radius:4px;display:'.($row[tc_coupon_enable]==1?'block':'none').';" id="tc_coupon_enable_default_box['.$k.']" '.(($row[tc_coupon_enable_default]=="1")?"checked=checked value=1":"").'>
		<input type=checkbox id="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_coupon_enable_default]' ).'" name="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_coupon_enable_default]' ).'" '.(($row[tc_coupon_enable_default]=="1")?"checked=checked value=1":"").' onclick="switchChkValueCouponEdit(this, \''.$k.'\');" />
		<label for="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_coupon_enable_default]' ).'" id=tc_coupon_enable_default_label['.$k.'] >&nbsp;Set predefined coupon</label>
		<input id="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_coupon_default]' ).'" name="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_coupon_default]' ).'" value="'.esc_attr( $row[tc_coupon_default] ).'" size=16 placeholder="* Predefined coupon" style="display:'.($hascoupon?'block':'none').'" '.($hascoupon?'data-required="yes" class="required"':'class=""').' />
		<label for="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_coupon_default_hidden]' ).'" id=tc_coupon_default_hidden_label['.$k.'] style="display:'.($hascoupon?'block':'none').'" >&nbsp;HIde coupon</label>
		<input type=checkbox id="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_coupon_default_hidden]' ).'" name="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_coupon_default_hidden]' ).'" '.(($row[tc_coupon_default_hidden]=="1")?"checked=checked value='1'":"").' style="display:'.($hascoupon?'block':'none').'" onclick="switchChkValueCouponEdit(this, \''.$k.'\');" />
		</div>
		</td>

<!--
		<td class="column-columnname">
		<select id="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_template]' ).'" name="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_template]' ).'" class=narrow>';
		$dets = array("tc_ricaricaweb_cc.tpl" => _("Carta di credito"), "tc_ricaricaweb_paypal.tpl" =>_("Paypal"));
		foreach ($dets as $kd => $det)
			print '<option value="'.$kd.'" '.(($kd==$row[tc_template])?"selected=selected":"").'>'.$det.'</option>';
print		'</select>
		</td>
-->
		<td class="column-columnname">[tcrw id='.$k.']</td>
		<td class="column-columnname"><input type=button class="button-secondary" onclick="switchAdvanced(\'advanced_'.$k.'\')" value="advanced" /><input type=button class="button-secondary" onclick="deleteInstance(\''.$k.'\')" value="delete" /></td>
	</tr>
	<tr id=advanced_'.$k.' style=\'display:none;background-color:#dedede;\'>
		<td class="column-columnname">
		<label for="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_affiliate_merchant]' ).'">aff. merchant ID</label>
		<input id="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_affiliate_merchant]' ).'" name="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_affiliate_merchant]' ).'" value="'.esc_attr( $row[tc_affiliate_merchant] ).'" size=8 />
		</td>
		<td class="column-columnname">
		<label for="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_country]' ).'">Country prefix</label>
		<input id="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_country]' ).'" name="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_country]' ).'" value="'.esc_attr( $row[tc_country] ).'" size=4 />
		</td>
		<td class="column-columnname">
		<label for="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_lng]' ).'">Instance language</label>
		<select id="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_lng]' ).'" name="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_lng]' ).'">';
		$langs = array("ITA","FRA","ENG","SPA","DEU");
		foreach ($langs as $lang)
			print '<option '.(($lang==$row[tc_lng])?"selected=selected":"").' value="'.$lang.'">'.$lang.'</option>';
print		'</select>
		</td>
		<td class="column-columnname">
		<label for="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_usetcjs]' ).'">use Telecash Javascript</label>
		<input type=checkbox id="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_usetcjs]' ).'" name="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_usetcjs]' ).'" '.(($row[tc_usetcjs]=="1")?"checked=checked":"").' />
		</td>
		<td class="column-columnname">
		<label for="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_taglio]' ).'">Refill amounts</label>
		<input id="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_taglio]' ).'" name="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_taglio]' ).'" value="'.esc_attr( $row[tc_taglio] ).'" />
		</td>
		<td class="column-columnname">
		<label for="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_set_phone_credit]' ).'">Apply phone recharge</label>
		<input type=checkbox id="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_set_phone_credit]' ).'" name="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_set_phone_credit]' ).'" '.(($row[tc_set_phone_credit]=="1")?"checked=checked":"").' />
		</td>
		<td class="column-columnname">
		<label for="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_set_order_detail]' ).'">Override item detail</label>
		<select id="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_set_order_detail]' ).'" name="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_set_order_detail]' ).'" class=narrow>';
		$dets = array("0" => _("Service recharge"), "1" =>_("Recharge service by N minutes"), "2" => _("Recharge service XXX by N minutes"), "3" => _("Custom"));
		foreach ($dets as $kd => $det)
			print '<option '.(($kd==$row[tc_set_order_detail])?"selected=selected":"").' value="'.$kd.'">'.$det.'</option>';
print		'</select>
		</td>
	</tr>
	<tr id=advanced_'.$k.'_2 style=\'display:none;background-color:#dedede;\'>
		<td class="column-columnname">
		<label for="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_set_order_item]' ).'">Override item description</label>
		<input id="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_set_order_item]' ).'" name="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_set_order_item]' ).'" value="'.esc_attr( $row[tc_set_order_item] ).'" />
		</td>
		<td class="column-columnname">
		<label for="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_require_customer_email]' ).'">Require customer email</label>
		<input type=checkbox id="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_require_customer_email]' ).'" name="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_require_customer_email]' ).'" '.(($row[tc_require_customer_email]=="1")?"checked=checked":"").' />
		</td>
		<td class="column-columnname">
		<label for="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_form_layout]' ).'">Payment form layout</label>
		<select id="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_form_layout]' ).'" name="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_form_layout]' ).'">';
		for ($fl=1;$fl<=12;$fl++)
			print '<option '.(($fl==$row[tc_form_layout])?"selected=selected":"").' value="'.$fl.'">'.$fl.'</option>';
print		'</select>
		</td>
		<td class="column-columnname">
		<label for="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_page_background_color]' ).'">Page background color (#XXXXXX)</label>
		<input id="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_page_background_color]' ).'" name="'.esc_attr( 'tcrw_settings[instances]['.$k.'][tc_page_background_color]' ).'" value="'.esc_attr( $row[tc_page_background_color] ).'" size=8 />
		</td>
	</tr>';

	}
?>
</tbody>
</table>

<?php } ?>

<?php
if ( 'tc_translations' == $field['label_for'] ) {

$activelangs = array("it","en","es","fr","de");
$savedstrings = $settings['translations'];
?>
<table class='widefat fixed'>
<thead>
	<tr>
		<th id='merchant' class='manage-column column-cb check-column' scope='col'>lang</th>
		<th id='alias' class='manage-column column-cb check-column' scope='col'>your phone number</th>
		<th id='alias' class='manage-column column-cb check-column' scope='col'>repeat your phone number</th>
		<th id='country' class='manage-column column-cb check-column' scope='col'>your email address</th>
		<th id='lng' class='manage-column column-cb check-column' scope='col'>pay</th>
		<th id='shortcode' class='manage-column column-cb check-column' scope='col'>payment succesfully completed</th>
		<th id='cmds' class='manage-column column-cb check-column' scope='col'>error during payment process</th>
		<th id='cpns' class='manage-column column-cb check-column' scope='col'>insert a coupon code if you have one</th>
	</tr>
</thead>
<tfoot>
	<tr>
		<th id='merchant' class='manage-column column-cb check-column' scope='col'>lang</th>
		<th id='alias' class='manage-column column-cb check-column' scope='col'>your phone number</th>
		<th id='alias' class='manage-column column-cb check-column' scope='col'>repeat your phone number</th>
		<th id='country' class='manage-column column-cb check-column' scope='col'>your email address</th>
		<th id='lng' class='manage-column column-cb check-column' scope='col'>pay</th>
		<th id='shortcode' class='manage-column column-cb check-column' scope='col'>payment succesfully completed</th>
		<th id='cmds' class='manage-column column-cb check-column' scope='col'>error during payment process</th>
		<th id='cpns' class='manage-column column-cb check-column' scope='col'>insert a coupon code if you have one</th>
	</tr>
</tfoot>
<tbody>
<?php
foreach ($activelangs as $lang) {
?>
	<tr>
		<td class="column-columnname">
		<strong>Lang: <?=$lang;?></strong>
		</td>
		<td class="column-columnname">
		<input id="<?=esc_attr( 'tcrw_settings[translations]['.$lang.'][tc_string_yourphonenumber]' );?>" name="<?=esc_attr( 'tcrw_settings[translations]['.$lang.'][tc_string_yourphonenumber]' );?>" value="<?=$savedstrings[$lang][tc_string_yourphonenumber];?>" size=12 />
		</td>
		<td class="column-columnname">
		<input id="<?=esc_attr( 'tcrw_settings[translations]['.$lang.'][tc_string_yourphonenumber2]' );?>" name="<?=esc_attr( 'tcrw_settings[translations]['.$lang.'][tc_string_yourphonenumber2]' );?>" value="<?=$savedstrings[$lang][tc_string_yourphonenumber2];?>" size=12 />
		</td>
		<td class="column-columnname">
		<input id="<?=esc_attr( 'tcrw_settings[translations]['.$lang.'][tc_string_youremail]' );?>" name="<?=esc_attr( 'tcrw_settings[translations]['.$lang.'][tc_string_youremail]' );?>" value="<?=$savedstrings[$lang][tc_string_youremail];?>" size=12 />
		</td>
		<td class="column-columnname">
		<input id="<?=esc_attr( 'tcrw_settings[translations]['.$lang.'][tc_string_pay]' );?>" name="<?=esc_attr( 'tcrw_settings[translations]['.$lang.'][tc_string_pay]' );?>" value="<?=$savedstrings[$lang][tc_string_pay];?>" size=12 />
		</td>
		<td class="column-columnname">
		<input id="<?=esc_attr( 'tcrw_settings[translations]['.$lang.'][tc_string_cancel]' );?>" name="<?=esc_attr( 'tcrw_settings[translations]['.$lang.'][tc_string_cancel]' );?>" value="<?=$savedstrings[$lang][tc_string_cancel];?>" size=12 />
		</td>
		<td class="column-columnname">
		<input id="<?=esc_attr( 'tcrw_settings[translations]['.$lang.'][tc_string_paymentok]' );?>" name="<?=esc_attr( 'tcrw_settings[translations]['.$lang.'][tc_string_paymentok]' );?>" value="<?=$savedstrings[$lang][tc_string_paymentok];?>" size=12 />
		</td>
		<td class="column-columnname">
		<input id="<?=esc_attr( 'tcrw_settings[translations]['.$lang.'][tc_string_paymenterr]' );?>" name="<?=esc_attr( 'tcrw_settings[translations]['.$lang.'][tc_string_paymenterr]' );?>" value="<?=$savedstrings[$lang][tc_string_paymenterr];?>" size=12 />
		</td>
		<td class="column-columnname">
		<input id="<?=esc_attr( 'tcrw_settings[translations]['.$lang.'][tc_string_insertcoupon]' );?>" name="<?=esc_attr( 'tcrw_settings[translations]['.$lang.'][tc_string_insertcoupon]' );?>" value="<?=$savedstrings[$lang][tc_string_insertcoupon];?>" size=12 />
		</td>
	</tr>
<?php } ?>
</tbody>
</table>
<?php } ?>
