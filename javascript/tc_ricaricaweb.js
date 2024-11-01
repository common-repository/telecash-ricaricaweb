function tcrwWrapper( $ ) {
	var tcrw = {

		/**
		 * Main entry point
		 */
		init: function () {
			tcrw.prefix      = 'tcrw_';
			tcrw.templateURL = $( '#template-url' ).val();
			tcrw.ajaxPostURL = $( '#ajax-post-url' ).val();

			tcrw.registerEventHandlers();
		},

		/**
		 * Registers event handlers
		 */
		registerEventHandlers: function () {
			$( '#example-container' ).children( 'a' ).click( tcrw.exampleHandler );
		},

		/**
		 * Example event handler
		 *
		 * @param object event
		 */
		exampleHandler: function ( event ) {
			alert( $( this ).attr( 'href' ) );

			event.preventDefault();
		}
	}; // end tcrw

	$( document ).ready( tcrw.init );

} // end tcrwWrapper()

tcrwWrapper( jQuery );

var addInstance = function() {

        var rbase = "?page=telecash&tab=instances";
        var vars = ["add_tc_merchant","add_tc_alias","add_tc_disable_paypal","add_tc_country","add_tc_lng","add_tc_usetcjs","add_tc_taglio","add_tc_set_phone_credit","add_tc_set_order_detail","add_tc_set_order_item","add_tc_require_customer_email","add_page_background_color","add_tc_doublenum","add_tc_coupon_enable","add_tc_coupon_enable_default","add_tc_coupon_default","add_tc_coupon_default_hidden","add_tc_form_layout"];
        var rvars = ["add_tc_merchant"];
	if (document.getElementById("add_tc_coupon_enable_default").value=="1") {
		rvars.push("add_tc_coupon_default");
	}
	var errors = 0;
	var params = {};
		for (i=0;i<vars.length;i++) {
			if (document.getElementById(vars[i]).value==""&&rvars.indexOf(vars[i])!=-1) {
				errors++;
			}
			eval("params."+vars[i]+" = '"+document.getElementById(vars[i]).value+"'");
		}
		if (errors==0) {
			post(rbase, params, "post");
		} else {
			alert("Please, fill all required fields.");
		}

}

function deleteInstance(k) {

	if (confirm('Proceed deleting the instance?')) {

		document.getElementById('tcrw_settings[instances]['+k+'][tc_merchant]').value='';
		document.getElementById('tcrw_settings[instances]['+k+'][tc_alias]').value='';
		document.getElementById('submit').click();

	}

}

function post(path, params, method) {

    method = method || "post";

    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
         }
    }

    document.body.appendChild(form);
    form.submit();
}

switchChkValue = function(chk) {

	if (chk.value==1) {
		chk.value=0;
	} else {
		chk.value=1;
	}

}

switchChkValueCouponAdd = function(chk) {

	if (chk.value==1) {
		chk.value=0;
		if (chk.name=='add_tc_coupon_enable') {
			document.getElementById('add_tc_coupon_enable_default').value=0;
			document.getElementById('add_tc_coupon_enable_default').checked=false;
			document.getElementById('add_tc_coupon_enable_default').style.display='none';
			document.getElementById('add_tc_coupon_enable_default_label').style.display='none';
			document.getElementById('add_tc_coupon_default').style.display='none';
			document.getElementById('add_tc_coupon_enable_default_box').style.display='none';
		}
		if (chk.name=='add_tc_coupon_enable_default') {
			document.getElementById('add_tc_coupon_default').style.display= 'none';
			document.getElementById('add_tc_coupon_default_hidden').style.display='none';
			document.getElementById('add_tc_coupon_default_hidden_label').style.display='none';
		}
		if (chk.name=='add_tc_coupon_default_hidden') {
			document.getElementById('add_tc_coupon_default_hidden').value=0;
		}
	} else {
		chk.value=1;
		if (chk.name=='add_tc_coupon_enable') {
			document.getElementById('add_tc_coupon_enable_default').value=0;
			document.getElementById('add_tc_coupon_enable_default').checked=false;
			document.getElementById('add_tc_coupon_enable_default_label').style.display='block';
			document.getElementById('add_tc_coupon_enable_default').style.display='block';
			document.getElementById('add_tc_coupon_enable_default_box').style.display='block';
		}
		if (chk.name=='add_tc_coupon_enable_default') {
			document.getElementById('add_tc_coupon_default').style.display= 'block';
			document.getElementById('add_tc_coupon_default_hidden').style.display='block';
			document.getElementById('add_tc_coupon_default_hidden_label').style.display='block';
		}
		if (chk.name=='add_tc_coupon_default_hidden') {
			document.getElementById('add_tc_coupon_default_hidden').value=1;
		}
	}

}

switchChkValueCouponEdit = function(chk,iid) {

	if (chk.value==1) {
		chk.value=0;
		if (chk.name=='tcrw_settings[instances]['+iid+'][tc_coupon_enable]') {
			document.getElementById('tcrw_settings[instances]['+iid+'][tc_coupon_enable_default]').value=0;
			document.getElementById('tcrw_settings[instances]['+iid+'][tc_coupon_enable_default]').checked=false;
			document.getElementById('tcrw_settings[instances]['+iid+'][tc_coupon_enable_default]').style.display='none';
			document.getElementById('tc_coupon_enable_default_label['+iid+']').style.display='none';
			document.getElementById('tcrw_settings[instances]['+iid+'][tc_coupon_default]').style.display='none';
			document.getElementById('tc_coupon_enable_default_box['+iid+']').style.display='none';
			document.getElementById('tcrw_settings[instances]['+iid+'][tc_coupon_default]').dataset.required='no';
		}
		if (chk.name=='tcrw_settings[instances]['+iid+'][tc_coupon_enable_default]') {
			document.getElementById('tcrw_settings[instances]['+iid+'][tc_coupon_default]').style.display= 'none';
			document.getElementById('tcrw_settings[instances]['+iid+'][tc_coupon_default]').dataset.required='no';
			document.getElementById('tcrw_settings[instances]['+iid+'][tc_coupon_default]').className='';
			document.getElementById('tcrw_settings[instances]['+iid+'][tc_coupon_default_hidden]').style.display='none';
			document.getElementById('tc_coupon_default_hidden_label['+iid+']').style.display='none';
		}
		if (chk.name=='tcrw_settings[instances]['+iid+'][tc_coupon_default_hidden]') {
			document.getElementById('tcrw_settings[instances]['+iid+'][tc_coupon_default_hidden]').value=0;
		}
	} else {
		chk.value=1;
		if (chk.name=='tcrw_settings[instances]['+iid+'][tc_coupon_enable]') {
			document.getElementById('tcrw_settings[instances]['+iid+'][tc_coupon_enable_default]').value=0;
			document.getElementById('tcrw_settings[instances]['+iid+'][tc_coupon_enable_default]').checked=false;
			document.getElementById('tcrw_settings[instances]['+iid+'][tc_coupon_enable_default]').style.display='block';
			document.getElementById('tc_coupon_enable_default_label['+iid+']').style.display='block';
			document.getElementById('tcrw_settings[instances]['+iid+'][tc_coupon_default]').style.display='none';
			document.getElementById('tc_coupon_enable_default_box['+iid+']').style.display='block';
		}
		if (chk.name=='tcrw_settings[instances]['+iid+'][tc_coupon_enable_default]') {
			document.getElementById('tcrw_settings[instances]['+iid+'][tc_coupon_default]').style.display= 'block';
			document.getElementById('tcrw_settings[instances]['+iid+'][tc_coupon_default]').dataset.required='yes';
			document.getElementById('tcrw_settings[instances]['+iid+'][tc_coupon_default]').className='required';
			document.getElementById('tcrw_settings[instances]['+iid+'][tc_coupon_default_hidden]').style.display='block';
			document.getElementById('tc_coupon_default_hidden_label['+iid+']').style.display='block';
		}
		if (chk.name=='tcrw_settings[instances]['+iid+'][tc_coupon_default_hidden]') {
			document.getElementById('tcrw_settings[instances]['+iid+'][tc_coupon_default_hidden]').value=1;
		}
	}

}

checkSave = function(mform) {

	var elements = mform.elements;
	var err = 0;
	for (var i=0, element; element = elements[i++];) {
		if (element.dataset.required=='yes'&&element.value=='') {
			++err;
		}
	}
	return err==0;

}


toggleDiv = function(d) {
	jQuery(d).toggle();
}

switchAdvanced = function(d) {
	var wind = document.getElementById(d);
	var wind2 = document.getElementById(d+'_2');
	if (wind.style.display == 'none') {
		wind.style.display = 'table-row';
		wind.style.visibility = 'visible';
		wind2.style.display = 'table-row';
		wind2.style.visibility = 'visible';
	}else{
		wind.style.display = 'none';
		wind.style.visibility = 'hidden';
		wind2.style.display = 'none';
		wind2.style.visibility = 'hidden';
	}
}
