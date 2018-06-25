// Thêm chứng từ
// BEGIN
// -------------------------------------------------------------------------
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
	$('#act-entry-title').show();
	$('#receipt-title').hide();

	$('.receipt')
		.animate({
			'left': '-' + $('.receipt').outerWidth() + 'px',
			'opacity': '0'
		}, 700);
	$('.act-entry')
		.show()
		.css({
			'right': '-' + $('.act-entry').outerWidth() + 'px'
		})
		.animate({
      	right: '0px'
	}, 700);

	// Fill value into accounting entry
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
	$('#act-entry-title').hide();
	$('#receipt-title').show();

	$('.act-entry')
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

// When change, check valid input
$('#receipt-type, #value, #executor, #tot, #toa, #date').change(checkToEnableOk);

$('#value').keyup(checkToEnableOk);

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

	// after reduced accounting entry
	setTimeout(function(){
		$('#count-trans').html($('.row-tr:visible').length);
		FillValue();
	}, 520);
});

$(document).on("click", "#add-trans", function(){

	// after reduced accounting entry
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


$(document).on("change", ".income, #income", function() {
	if ($(this).val() == 1) {
		$(this).css('background-color', '#9aeaa8');
	}
	else {
		$(this).css('background-color', '#fdd600');
	}
});

// Check full info and enable submit
$(document).on("change", ".tot, .toa", checkToEnableSubmit);

$(document).on("keyup", ".value", checkToEnableSubmit);

$(document).on("keyup", "#value", function() { $('#value-show').html(convertToCurrency($('#value').val().split('.').join(''))); })

// Ajax load accounting entry
$('#receipt-type').change(function(){
	var code = $('#receipt-type :selected').text().substring(0,2);
	if (code == 'PT') {
		$('#income').val('1');
		$('#income').css('background-color', '#9aeaa8');
	}
	else {
		$('#income').val('0');
		$('#income').css('background-color', '#fdd600');
	}

	var url = $(this).data('url');

	$.ajax({
		url : url,
		method : "post",
		data : {
			id : $(this).val()
		},
		success : function(result) {
			$('.act-entry').html(result);
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
// END Thêm chứng từ
// --------------------------------------------------------------------------------------

// BEGIN Receipt type
$(document).on("click", ".slider", function(){
	var text = $(this).children()[0];
	var class_list = $(text).attr("class").split(' ');
	var checkbox = $(this).parent().children('[type=checkbox]')[0];
	if ($(checkbox).val() == 'on') {
		$(checkbox).val('off');
		if ($.inArray('in-out', class_list) == 1) {
			$(text).prop('title', 'Chi');
			$(text).html('Chi');
		}
	}
	else {
		$(checkbox).val('on');
		if ($.inArray('in-out', class_list) == 1) {
			$(text).prop('title', 'Thu');
			$(text).html('Thu');
		}
	}
	$(text).fadeIn();
});

$(document).on("change", ".active-check", function() {
	if (checkHaveChangeActive()) {
		$('#status-change-btn').prop('disabled', false);
		$('#status-change-btn').css({
			'animation': 'shake 5s cubic-bezier(.36,.07,.19,.97) both',
			'transform': 'translate3d(0, 0, 0)',
			'backface-visibility': 'hidden',
			'perspective': '1000px'
		});
		setTimeout(function(){
			$('#status-change-btn').css('animation', 'none');
		},3000);
	} else {
		$('#status-change-btn').prop('disabled', true);
	}

});

$(document).on("click", ".receipt-item", function(){
	// enable list add act
	$('#act-to-add').prop('disabled', false);
	$('#act-update-btn').prop('disabled', true);

	$('.receipt-item').css('background-color', 'aliceblue');
	$('.name-receipt').css({'color': 'black', 'font-weight': 'normal'});
	$('.receipt-item').data('chosen', 0);

	$(this).css('background-color', 'beige');
	$(this).children('.name-receipt').css({'color': 'brown', 'font-weight': 'bold'});
	$(this).data('chosen', 1);

	var url = $('#url-ajax').val();
	var id = $(this).data('id');

	$.ajax({
		method: "POST",
		url: url,
		data: {
			id : id
		},
		beforeSend: function() {
			$('#wait-choose-act').css('display', 'block');
		},
		success: function(result) {
			$('#act-load').html(result);
		},
		complete: function() {
			$('#wait-choose-act').css('display', 'none');
		}
	});
});

$(document).on("click", ".rm-icon", function(){
	// Hide
	var id_item = $(this).data('id');
	$(this).parent().parent().parent().parent().parent().fadeOut();

	// update new list
	var index = $('#list-new').val().split(',').indexOf(id_item.toString());
	var arr = $('#list-new').val().split(',');
	arr.splice(index, 1);
	if (arr.length == 0) {
		$('#act-load').prepend('<h3 class="text-center deep-note">(Trống)</h3>');
	}

	$('#list-new').val(arr.join(','));

	checkToEnableUpdateReceiptType();
});

$('#act-to-add').change(function(){
	if ($(this).val() == 0) {
		$('#act-add-btn').prop('disabled', true);
	} else {
		$('#act-add-btn').prop('disabled', false);
	}
});

$('#act-add-btn').click(function(){
	var url = $(this).data('url');
	var id = $('#act-to-add').val();

	$.ajax({
		method: "POST",
		url: url,
		data: {
			id : id
		},
		beforeSend: function() {
			$('#wait-choose-act').css('display', 'block');
		},
		success: function(result) {
			// update new list
			if ($('#list-new').val() == '') {
				var arr = [];
			}
			else {
				var arr = $('#list-new').val().split(',');
			}
			arr.push(id.toString());
			$('#list-new').val(arr.join(','));

			checkToEnableUpdateReceiptType();

			$('#act-load').append(result);
		},
		complete: function() {
			$('#wait-choose-act').css('display', 'none');
		}
	});
});

// click save button
$('#act-update-btn').click(function(){
	var url = $(this).data('url');

	var element_chosen = $('.receipt-item').filter(function() { return ($(this).data('chosen') == '1'); });
	// when a receipt was chosen
	if ($(element_chosen).length == 1) {
		var list = $('#list-new').val();
		var id = $(element_chosen).data('id');

		$.ajax({
			method: "POST",
			url: url,
			data: {
				id : id,
				list : list
			},
			beforeSend: function() {
				$('#wait-choose-act').css('display', 'block');
			},
			success : function(result) {
				console.log(result);
				$('#list-act-ori').val(list);
				showSuccess();
			},
			complete: function() {
				setTimeout(function(){
					resetSuccess();

					$('#act-update-btn').prop('disabled', true);
				},2000);
			}
		});
	}
});

// Click save change status button
$('#status-change-btn').click(function(){
	$(this).prop('disabled', true);

	var have_change = $('#have-change').val();
	if (have_change !== '0') {
		var url = $(this).data('url');

		var url_load = $(this).data('url_load');

		$.ajax({
			method: "POST",
			url: url,
			data: {
				list_change : have_change
			},
			beforeSend: function() {
				$('#wait-choose-act').css('display', 'block');
			},
			success: function(result) {
				$.ajax({
					method: "POST",
					url: url_load,
					data: {
						'reload' : 1
					},
					success: function(result_load) {
						$('#list-receipt').html(result_load);
						$('#act-load').html('<h3 class="text-center deep-note">(Hãy lựa chọn chứng từ)</h3>');
						$('#act-to-add').prop('disabled', true);
						showSuccess();
					}
				});
			},
			complete: function() {
				setTimeout(function(){
					resetSuccess();

					$('#status-change-btn').prop('disabled', true);
				},2000);
			}
		});
	}
});

$(document).on("click", ".edit-icon", function(){
	resetEditReceiptName();

	// Set current item
	var main_item = $(this).parent();
	$(main_item).children('.click-hide').css('display', 'none');
	$(main_item).children('.click-show').css('display', 'inline-block');
	var text_box = $(main_item).children('.edit-name-box')[0];
	$(text_box).focus();
	var temp = $(text_box).val();
	$(text_box).val('');
	$(text_box).val(temp);
});

$(document).on("click", ".save-name",function(){
	var id = $(this).data('id');
	var main_item = $(this).parent();
	var new_name = $.trim($('#txt-edit-name-' + id.toString()).val());

	if (new_name !== $(this).data('name_ori')) {
		$(this).data('name_ori', new_name);
		var url = $(this).data('url');

		$.ajax({
			method: "POST",
			url: url,
			data: {
				id : id,
				name : new_name
			},
			beforeSend: function() {
				$('#wait-choose-act').css('display', 'block');
			},
			success : function(result) {
				console.log(result);
				$(main_item).children('.name-receipt').html(new_name);
				resetEditReceiptName();
				showSuccess();
			},
			complete: function() {
				setTimeout(function(){
					resetSuccess();

					$('#act-update-btn').prop('disabled', true);
				},2000);
			}
		});
	} else {
		resetEditReceiptName();
	}
});

$(document).on("click", ".delete-type", function(){
	var main_item = $(this).parent();
	console.log(main_item);
	var id = $(this).data('id');
	var url = $(this).data('url');
	$.confirm({
	    title: 'Xóa!',
	    content: 'Chỉ có thể xóa khi không có chứng từ nào cùng loại, Xác nhận xóa dữ liệu?',
	    buttons: {
			 Ok: {
				  btnClass: 'btn-blue',
				  action: function(){
					  $.ajax({
						  method: "POST",
						  url: url,
						  dataType: 'json',
						  data: {
							  id : id
						  },
						  success: function(result){
							  if (result.success) { $(main_item).fadeOut(); }
							  resetEditReceiptName();
							  $.alert({
								    content: result.message,
								});
						  }
					  });
				  }
			 },
			 cancel: function(){
				 resetEditReceiptName();
			 }
	    }
	});
});

$('#type-add-btn').click(function(){
	var url = $(this).data('url');
	$.confirm({
	    content: function () {
	        var self = this;
	        return $.ajax({
	            url: url,
	            method: 'post',
					data: {
						'load' : 1
					},
	        }).done(function (response) {
	            self.setContent(response);
	            // self.setContentAppend('<br>Version: ' + response.version);
	            self.setTitle('Thêm loại chứng từ mới');
	        }).fail(function(){
	            self.setContent('Something went wrong.');
	        });
	    },
		 buttons : {
			 Ok: {
	            text: 'Ok',
	            keys: ['enter'],
					btnClass: 'btn-blue',
	            action: function(){
	                $.alert('Shift or Alt was pressed');
	            }
	        },
	 		 close : {
	 			 specialKey: {
	 				  text: 'Close',
	 				  keys: ['esc'],
	 				  action: function(){
	 						$.alert('A or B was pressed');
	 				  }
	 			 }
	 		 }
		 },
	});
});

function resetEditReceiptName() {
	$('.click-show').css('display', 'none');
	$('.click-hide').css('display', 'inline-block');
}

function showSuccess() {
	$('#wait-choose-act').children('.wait').css('display', 'none');
	$('#wait-choose-act').children('.success').css('display', 'inline-block');
}

function resetSuccess() {
	$('#wait-choose-act').css('display', 'none');
	$('#wait-choose-act').children('.success').css('display', 'none');
	$('#wait-choose-act').children('.wait').css('display', 'inline-block');
}

function checkHaveChangeActive() {
	var list_receipt_item = $('.receipt-item');
	var have_change = false;
	var json_change = {};

	for (var i = 0; i < list_receipt_item.length; i++) {
		var value_each_checkbox = $($($(list_receipt_item[i]).children('.switch')[0]).children('.active-check')[0]).val();
		if ($(list_receipt_item[i]).data('active_ori') !== value_each_checkbox) {
			have_change = true;
			var id_change = $(list_receipt_item[i]).data('id');
			if (value_each_checkbox == 'on') {
				json_change[id_change] = 1;
			} else {
				json_change[id_change] = 0;
			}
		}
	}

	if (have_change) {
		$('#have-change').val(JSON.stringify(json_change));
		return true;
	} else {
		$('#have-change').val('0');
		return false;
	}
}

function checkToEnableUpdateReceiptType() {
	if ($('#list-new').val() !== $('#list-act-ori').val()) {
		$('#act-update-btn').prop('disabled', false);
		$('#act-update-btn').css({
			'animation': 'shake 5s cubic-bezier(.36,.07,.19,.97) both',
			'transform': 'translate3d(0, 0, 0)',
			'backface-visibility': 'hidden',
			'perspective': '1000px'
		});
		setTimeout(function(){
			$('#act-update-btn').css('animation', 'none');
		},3000);
	}
	else {
		$('#act-update-btn').prop('disabled', true);
	}
}

function checkChosenReceipt() {
	var list_choose = $('.receipt-item');
	var flag = false;
	for (var i = 0; i < list_choose.length; i++) {
		if ($(list_choose[i]).data('chosen') == '1') {
			console.log($(list_choose[i]).data('chosen'));
			flag = true;
			break;
		}
	}

	return flag;
}

function checkToEnableOk() {
	var flag = true;
	if ($('#receipt-type').val() == '') {
		flag = false;
	}
	var str_value = $('#value').val();
	if ($.trim(str_value) == '') {
		flag = false;
	}
	str_value = str_value.split('.').join('');
	if (!$.isNumeric(str_value)) {
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
}

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
			var frac = ratio.split('/');
			var value = Math.ceil(total/parseInt(frac[1])*parseInt(frac[0]));
			sub += value;
			$(value_tags[i]).val(convertToCurrency(value.toString()));
		}
	}

	var empty_value = $('.value:visible').filter(function() { return $(this).val() == ""; });
	if ($('#income').val() == 0) {
		$(empty_value[0]).val(convertToCurrency(total.toString()));
	}
	else {
		$(empty_value[0]).val(convertToCurrency((total - sub).toString()));
	}
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
