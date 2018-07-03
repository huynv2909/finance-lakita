// Thêm chứng từ
// BEGIN
// -------------------------------------------------------------------------
$(document).ready(function(){
	if ($('#have-notify').val() == '1') {
		$('.alert').fadeIn();
		setTimeout(function(){
			$('.alert').fadeOut();
		}, 3000);
	}

	$('#voucher-choose').change(function(){
		var id = $(this).val();
		var url = $(this).data('url');

		if (id != 0) {
			$('#act-add-btn').prop('disabled', false);

			// Set id chosen
			$('#act-add-btn').data('id', id);

			$.ajax({
				method: "POST",
				url: url,
				dataType: "JSON",
				data: {
					id : id
				},
				beforeSend: function() {
					$('.load-info').css('display', 'flex');
				},
				success: function(result) {
					$('.contain-voucher-info').html(result.voucher);
					$('#voucher_id').val(result.voucher_id);
					$('#TOT').val(result.TOT);

					var table = $('#act_table').DataTable();
					table.row().remove().draw();
					var html = '<option value="0">(Chọn bút toán)</option>';
					for (var i = 0; i < result.act.length; i++) {
						table.row.add([result.act[i].TOA,result.act[i].content,convertToCurrency(result.act[i].value) + ' đ',result.act[i].debit_acc,result.act[i].credit_acc]).draw();
						// Only distribution
						html += '<option value="' + result.act[i].id + '">' + result.act[i].TOT + ':' + result.act[i].content + ':' + convertToCurrency(result.act[i].value) + '</option>';
					}
					$('#act-choose').html(html);
				},
				complete: function() {
					$('.load-info').css('display', 'none');
				}
			});

		} else {
			$('.contain-voucher-info').html('<h2 class="empty-info">(Hãy lựa chọn chứng từ)</h2>');

			var table = $('#act_table').DataTable();
			table.row().remove().draw();

			$('#act-add-btn').prop('disabled', true);
		}

	});

	$('#act-add-btn').click(function(){
		$(this).prop('disabled', true);
		var id = $(this).data('id');
		var url = $(this).data('url');


		$('#act_table').DataTable().row.add([
			'<input id="TOA" type="date" name="TOA" value="" style="width:100%; line-height: normal;">',
			'<textarea id="content" name="content" rows="2" style="width: 100%;"></textarea>',
			'<input id="value" onkeyup="oneDot(this)" type="text" name="value" value="" style="width:100%;">',
			'<input id="debit_acc" type="number" name="debit_acc" value="" style="width:100%;">',
			'<input id="credit_acc" type="number" name="credit_acc" value="" style="width:100%;">'
		]).draw();

		$('#update-act-btn').click(function(){
			var data = {
				'voucher_id' : $('#voucher_id').val(),
				'TOT' : $('#TOT').val(),
				'TOA' : $('#TOA').val(),
				'value' : $('#value').val(),
				'debit_acc' : $('#debit_acc').val(),
				'credit_acc' : $('#credit_acc').val(),
				'content' : $('#content').val()
			};
			var url = $(this).data('url');

			$.ajax({
				url : url,
				method : "POST",
				dataType : "JSON",
				data : data,
				beforeSend: function() {
					$('.load-info-act').css('display', 'flex');
				},
				success : function(result) {
					$('.alert').html(result.message);
					if (result.success) {
						var table = $('#act_table').DataTable();
						var form_row = $('.contain-act-row').children()[0];
						table.row(form_row).remove().draw();
						$('#act-add-btn').prop('disabled', false);

						$('#act_table').DataTable().row.add([data.TOA,data.content,data.value,data.debit_acc,data.credit_acc]).draw();

						$('.alert').addClass('alert-success');
					} else {
						$('.alert').addClass('alert-danger');
					}

					$('.alert').fadeIn();
					setTimeout(function(){
						$('.alert').fadeOut();
						$('.alert').removeClass('alert-success alert-danger');
					}, 3000);
				},
				complete: function() {
					$('.load-info-act').css('display', 'none');
				}
			});

		});


	});

	// Distribution Fill site
	$('#act-choose').change(function(){
		var id = $(this).val();
		var url = $(this).data('url');

		if (id != 0) {
			$('#distribute-btn').prop('disabled', false);

			$.ajax({
				url : url,
				method : "POST",
				dataType : "json",
				data : {
					id : id
				},
				beforeSend : function(){
					$('.load-info').css('display', 'flex');
				},
				success : function(result){
					$('.contain-act-info').html(result.act);

					var table = $('#distribution_table').DataTable();
					table.row().remove().draw();
					for (var i = 0; i < result.distributes.length; i++) {
						table.row.add([result.distributes[i]['dimensional_id'],convertToCurrency(result.distributes[i]['value']) + ' đ',result.distributes[i]['content']]).draw();
					}
				},
				complete : function(){
					$('.load-info').css('display', 'none');
				}
			});

		} else {
			$('#distribute-btn').prop('disabled', true);
		}
	});

	// When change, check valid input
	$(document).on("change", "#TOA, #value, #debit_acc, #credit_acc", checkToEnableOk);
	$(document).on("keyup", "#value, #debit_acc, #credit_acc", checkToEnableOk);

	//  CHECK DEBIT vs CREDIT
});

$('#tot').change(function() {

	if ($('#toa').val() > $('#tot').val()) {
		$('#toa').val($(this).val());
	}
	$('#toa').attr('max', $(this).val());
});


function showSuccess() {
	$('.load-info-act').children('.waiting').css('display', 'none');
	$('.load-info-act').children('.success').css('display', 'inline-block');
}

function resetSuccess() {
	$('.load-info-act').css('display', 'none');
	$('.load-info-act').children('.success').css('display', 'none');
	$('.load-info-act').children('.waiting').css('display', 'inline-block');
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

	var str_value = $('#value').val();
	if ($.trim(str_value) == '') {
		flag = false;
	}
	str_value = str_value.split('.').join('');
	if (!$.isNumeric(str_value)) {
		flag = false;
	}
	if ($('#TOA').val() == '') {
		flag = false;
	}
	if ($('#debit_acc').val() == '') {
		flag = false;
	}
	if ($('#credit_acc').val() == '') {
		flag = false;
	}

	if (flag) {
		$('#update-act-btn').prop('disabled', false);
	}
	else {
		$('#update-act-btn').prop('disabled', true);
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
