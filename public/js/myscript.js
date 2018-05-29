$('#tot').change(function() {

	if ($('#toa').val() > $('#tot').val()) {
		$('#toa').val($(this).val());
	}
	$('#toa').attr('max', $(this).val());
});

// effect create receipt
$('#receipt-done, #move-right').on("click", function() {
	$('#move-right').hide();
	$('#move-left').show();
	$('#transaction-title').show();
	$('#receipt-title').hide();

	$('.receipt')
		.animate({
			'left': '-' + $('.receipt').outerWidth() + 'px',
			'opacity': '0'
		}, 700);
	$('.transaction')
		.show()
		.css({
			'right': '-' + $('.transaction').outerWidth() + 'px'
		})
		.animate({
      	right: '0px'
	}, 700);

	// Fill value into transaction
	$('.value').val('');
	var total = parseInt($('#value').val().split('.').join(''));
	var value_tags = $('.value');
	var sub = 0;

	for (var i = 0; i < value_tags.length; i++) {
		if ($(value_tags[i]).data('default') != '') {
			var ratio = $(value_tags[i]).data('default');
			if ($.isNumeric(ratio)) {
				var value = ratio * total;
				sub += value;
				$(value_tags[i]).val(convertToCurrency(value.toString()));
			}
			else {
				if (ratio.indexOf('/1tr') != -1) {
					var def = parseInt(ratio.replace("/1tr", ""));
					var value = Math.ceil(total/1000000*def);
					sub += value;
					$(value_tags[i]).val(convertToCurrency(value.toString()));
				}
			}
		}
	}

	var empty_value = $('.value').filter(function() { return $(this).val() == ""; });
	$(empty_value[0]).val(convertToCurrency(total.toString()));
	for (var i = 1; i < empty_value.length; i++) {
		$(empty_value[i]).val('0');
	}

});

$('#move-left').on("click", function() {
	$('#move-left').hide();
	$('#move-right').show();
	$('#transaction-title').hide();
	$('#receipt-title').show();

	$('.transaction')
		.animate({
			'right': '-' + $('.receipt').outerWidth() + 'px'
		}, 700)
		.css('display', 'none');
	$('.receipt')
		.animate({
      	left: '0px',
			opacity: '1'
	}, 700);
});

$('#receipt-type, #value, #executor, #tot, #toa, #date').change(function() {
	var flag = true;
	if ($('#receipt-type').val() == '') {
		flag = false;
	}
	if ($.trim($('#value').val()) == '') {
		flag = false;
	}
	if ($('#executor').val() == '') {
		flag = false;
	}
	if ($('#tot').val() == '') {
		flag = false;
	}
	if ($('#toa').val() == '') {
		flag = false;
	}
	if ($('#date').val() == '') {
		flag = false;
	}
	if (flag) {
		$('#receipt-done').prop('disabled', false);
		$('#move-right').prop('disabled', false);
		$('#move-right').css('color', '#5cb85c');
		$('#move-right').hover(function(){$('#move-right').css('color', 'green')}, function(){$('#move-right').css('color', '#5cb85c')})
	}
	else {
		$('#receipt-done').prop('disabled', true);
		$('#move-right').prop('disabled', true);
		$('#move-right').css('color', '#e7e7e7');
		$('#move-right').hover(function(){$('#move-right').css('color', '#e7e7e7')})
	}
});
// end effect create receipt

// Ajax load transaction
$('#receipt-type').change(function(){
	var url = $(this).data('url');

	$.ajax({
		url : url,
		method : "post",
		data : {
			id : $(this).val()
		},
		success : function(result) {
			$('.transaction').html(result);
		}
	});
});



function oneDot(input) {
  var value = input.value,
      value = value.split('.').join('');

  if (value.length > 3) {
  	var count = Math.floor((value.length - 1)/3);
  	var arr = [];
  	for (i = count; i > 0; i--) {
  		arr.push(value.substring(0, value.length - 3*i));
  		value = value.slice(value.length - 3*i)
  	}
  	arr.push(value);
  	var str = arr[0];
  	for (i = 1; i < arr.length; i++) {
  		str = str + '.' + arr[i];
  	}
    	value = str;
  }

  input.value = value;
}

function convertToCurrency(value)
{
	if (value.length > 3) {
   	var count = Math.floor((value.length - 1)/3);
   	var arr = [];
   	for (i = count; i > 0; i--) {
   		arr.push(value.substring(0, value.length - 3*i));
   		value = value.slice(value.length - 3*i)
   	}
   	arr.push(value);
   	var str = arr[0];
   	for (i = 1; i < arr.length; i++) {
   		str = str + '.' + arr[i];
   	}
     	value = str;
   }

	return value;
}
