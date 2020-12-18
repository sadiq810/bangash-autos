jQuery(document).ready(function($) {
	// $('[data-fancybox]').fancybox();
	$(document).on('click', '.callforprice', function() {
		var url = $(this).data('src');
		$.fancybox(
	    {
	    	'width': 800,
	    	'height': 440,
	        'href' : url,
	        'type' : 'ajax',
	        'autoScale': false,
	        'autoSize' : false,
	        'scrolling': 'auto'
	    });
	})
})

function sendData(product_id) {
	$.ajax({
		type: 'POST',
		dataType: "json",
		headers: { "cache-control": "no-cache" },
		data: {
			isAjax: 1,
			product_id: product_id,
			name: jQuery('#call_for_price_contact_name_'+product_id).val(),
			email: jQuery('#call_for_price_contact_email_'+product_id).val(),
			number: jQuery('#call_for_price_telephone_'+product_id).val(),
			country: jQuery('#call_for_price_country_'+product_id).val(),
			message: jQuery('#call_for_price_comment_'+product_id).val()
		},
		url: 'index.php?route=extension/module/so_call_for_price/sendData',
		beforeSend: function(){
			$('#ajax-loader-'+product_id).fadeIn();
			$('#content-send-'+product_id).hide();
			$('#call_for_price_success_'+product_id).html('').hide();
			$('#call_for_price_error_'+product_id).html('').hide();
		},
		success: function(data){
			if (data.status == 1) {
				$('#ajax-loader-'+product_id).hide();
				$('#content-send-'+product_id).show();
				$('#call_for_price_error_'+product_id).html('');
				$('#call_for_price_success_'+product_id).append(data.success).show();
				setTimeout(function(){$.fancybox.close()}, 3000);
				$('#ajax-form-'+product_id).each(function(){
					this.reset();
				});
				location.reload();
			}
			else if (data.status == 2) {
				$('#call_for_price_error_'+product_id).append(data.error).show();
				$('#ajax-loader-'+product_id).hide();
				$('#content-send-'+product_id).fadeIn();
			}
			else {
				$.each(data.errors, function(index, errors) {
					switch (errors.code)
					{
						case 701:
								$('#call_for_price_contact_name_'+product_id).val('');
								$('#call_for_price_contact_name_'+product_id).parent().removeClass('form-ok').addClass('form-error');
								$('#call_for_price_contact_name_'+product_id).attr("placeholder", errors.error);
							break;
						case 702:
								$('#call_for_price_contact_email_'+product_id).val('');
								$('#call_for_price_contact_email_'+product_id).parent().removeClass('form-ok').addClass('form-error');
								$('#call_for_price_contact_email_'+product_id).attr("placeholder", errors.error);
							break;
						case 703:
								$('#call_for_price_telephone_'+product_id).val('');
								$('#call_for_price_telephone_'+product_id).parent().removeClass('form-ok').addClass('form-error');
								$('#call_for_price_telephone_'+product_id).attr("placeholder", errors.error);
							break;
						case 704:
								$('#call_for_price_country_'+product_id).val('');
								$('#call_for_price_country_'+product_id).parent().removeClass('form-ok').addClass('form-error');
							break;
						case 705:
								$('#call_for_price_comment_'+product_id).val('');
								$('#call_for_price_comment_'+product_id).parent().removeClass('form-ok').addClass('form-error');
								$('#call_for_price_comment_'+product_id).attr("placeholder", errors.error);
							break;
						case 404:
								$('#div-error-'+product_id).append(errors.error);
								$('#div-error-'+product_id).show();
							break;
					}
				});
				
				$('#ajax-loader-'+product_id).hide();
				$('#content-send-'+product_id).fadeIn();
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			$('#call_for_price_error_'+product_id).append('Please try again.').show();
			$('#ajax-loader-'+product_id).hide();
			$('#content-send-'+product_id).fadeIn();
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	})
}