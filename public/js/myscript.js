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
	FillValue();

	// Fill tot & TOA
	$('.tot').val($('#tot').val());
	$('.toa').val($('#toa').val());

	checkToEnableSubmit();

	$('#index-max').val($('.row-tr').length);
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

$(document).on("mouseenter", ".row-tr", function(){
	if ($(".row-tr:visible").length > 1) {
		$(this).children(".close").show();
	}
});
$(document).on("mouseleave", ".row-tr", function(){
	$(this).children(".close").hide();
});

$(document).on("click", ".close", function(){
	$(this).parent().children(".alive").val(false);
	$(this).parent().hide(500);

	// after reduced transaction
	setTimeout(function(){
		$('#count-trans').html($('.row-tr:visible').length);
		FillValue();
	}, 520);
});

$(document).on("click", "#add-trans", function(){

	// after reduced transaction
	$('#count-trans').html(parseInt($('#count-trans').html()) + 1);

	var count_hidden = $('.row-tr:hidden');
	if ($(count_hidden).length > 0) {
		$(count_hidden[0]).children(".alive").val('true');
		$(count_hidden[0]).find(".note").val('');
		$(count_hidden[0]).find(".value").val('');
		$(count_hidden[0]).find(".value").data('default', '');
		$(count_hidden[0]).show();
		return;
	}


	var url = $(this).data('url');
	var count = $('.row-tr').length;

	$.ajax({
		url : url,
		method : "post",
		data : {
			count : count,
			tot : $('#tot').val(),
			toa : $('#toa').val()
		},
		success : function(result) {
			$('#ok-area').before(result);
			$('#index-max').val($('.row-tr').length);
		}
	});

});

// Auto fill last input
// $(document).on("change", ".value", function(){
// 	var value_tags = $('.value:visible').filter(function() { return ($(this).data('default') == "" && $(this).val() == ""); });
// 	if ($(value_tags).length == 1) {
// 		var total = parseInt($('#value').val().split('.').join(''));
// 		var value_fill = total - GetTotalFilled();
// 		if (value_fill >= 0) {
// 			$(value_tags[0]).val(convertToCurrency(value_fill));
// 		}
// 		else {
// 			$(value_tags[0]).val('(Giá trị âm!)');
// 		}
// 	}
// });
// end effect create receipt

// Check full info and enable submit
$(document).on("change", ".tot, .toa", checkToEnableSubmit);

$(document).on("keyup", ".value", checkToEnableSubmit);

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

// Ajax load view receipt
$('.re-row').click(function(){
	var url = $(this).data('url');
	var id = $(this).data('id');

	$.ajax({
		url : url,
		method : "post",
		data : {
			id : id
		},
		success : function(result) {
			$('#data-insert').html(result);
			$('#view-modal').modal('show');
		}
	});
});



function checkToEnableSubmit()
{
	var flag = true;
	// check value
	var empty_value = $('.value:visible').filter(function() { return $.trim($(this).val().toString()) == ""; });
	if (empty_value.length > 0) {
		flag = false;
	}

	var value_tags = $('.value:visible');
	for (var i = 0; i < value_tags.length; i++) {
		if (!$.isNumeric($(value_tags[i]).val().split('.').join(''))) {
			flag = false;
			break;
		}
	}

	var empty_tot = $('.tot:visible').filter(function() { return $(this).val() == ''; });
	if (empty_tot.length > 0) {
		flag = false;
	}

	var empty_toa = $('.toa:visible').filter(function() { return $(this).val() == ''; });
	if (empty_toa.length > 0) {
		flag = false;
	}

	if (flag) {
		$('#ok').prop('disabled', false);
	}
	else {
		$('#ok').prop('disabled', true);
	}
}

function GetTotalFilled()
{
	var value_tags = $('.value:visible').filter(function() { return ($(this).data('default') == "" && $(this).val() != ""); });
	var total = 0;
	for (var i = 0; i < value_tags.length; i++) {
		total += parseInt($(value_tags[i]).val().split('.').join(''));
	}
	return total;
}

function FillValue()
{
	$('.value').val('');
	var total = parseInt($('#value').val().split('.').join(''));
	var value_tags = $('.value:visible');
	if (value_tags.length == 1) {
		$(value_tags[0]).val(convertToCurrency(total.toString()));
		return;
	}
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

	var empty_value = $('.value:visible').filter(function() { return $(this).val() == ""; });
	$(empty_value[0]).val(convertToCurrency(total.toString()));
	for (var i = 1; i < empty_value.length; i++) {
		$(empty_value[i]).val('0');
	}
}

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
