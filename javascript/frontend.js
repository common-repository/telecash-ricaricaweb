var switchRadio = function(rname,selobj) {
	selobj.checked = 'checked';
	jQuery('#'+selobj.id+'.paypal').parent().removeClass('checked');
	jQuery('#'+selobj.id+'.paypal').parent().removeClass('tc_error');
	jQuery('#'+selobj.id+'.creditcard').parent().removeClass('checked');
	jQuery('#'+selobj.id+'.creditcard').parent().removeClass('tc_error');
	jQuery('#'+selobj.id+'.'+selobj.className).parent().addClass('checked');

}

var checkStartPay = function() {
	var err = '';
	if (jQuery('input[id=tc_ani]').val().length==0) {
		err+='.';
		jQuery('input[id=tc_ani]').addClass('tc_error');
	} else if (jQuery('input[id=anicheck]').val()+""!="undefined") {
		if (jQuery('input[id=tc_ani]').val()!=jQuery('input[id=anicheck]').val()) {
			err+='.';
			jQuery('input[id=anicheck]').addClass('tc_error');
		}
	} else {
		jQuery('input[id=tc_ani]').removeClass('tc_error');
	}
	if (jQuery('input[id=tc_disable_paypal]').attr('type')=='radio') {
		if (!jQuery('input[id=tc_disable_paypal]:checked').is(':checked')) {
			err+='.';
			jQuery('input[id=tc_disable_paypal]').parent().addClass('tc_error');
		}
	}else{
		jQuery('input[id=tc_disable_paypal]').parent().removeClass('tc_error');
	}
	return err.length==0;
}

