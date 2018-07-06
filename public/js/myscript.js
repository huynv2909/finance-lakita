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

	if ($('#have-a-new-voucher-add').length && $('#have-a-new-voucher-add').val() != '') {
		var url = $('#have-a-new-voucher-add').data('url');

		setTimeout(function(){
			$.confirm({
				 icon: 'fa fa-warning',
			    title: 'Nhập bút toán?',
			    content: 'Ghi nhận thành công chứng từ mới, Bạn có muốn nhập bút toán cho chứng từ mới không?',
				 theme: 'material',
				 type: 'green',
			    buttons: {
			        Ok: {
			            text: 'Nhập',
			            btnClass: 'btn-green',
			            keys: ['enter'],
			            action: function(){
			                window.location.href = url;
			            }
			        },
					  later: {
						  text: 'Để sau',
						  keys: ['esc'],
						  action: function(){
						  }
					  }
			    }
			});
		}, 1500);

	}

	// Voucher type
	$('#code').keyup(function(){
		$('.danger').removeClass('hidden').addClass('hidden');
		$('.success').removeClass('hidden').addClass('hidden');
		var str = $(this).val();
		if (str != '') {
			$('.checking').removeClass('hidden');
			var code_arr = $('#list_code').val().split(',');
			setTimeout(function(){
				if ($.inArray(str, code_arr) == -1 && $.trim(str) != '') {
					$('.danger').removeClass('hidden').addClass('hidden');
					$('.checking').addClass('hidden');
					$('.success').removeClass('hidden');
					$('#code').data('ok', '1');
				} else {
					$('.success').removeClass('hidden').addClass('hidden');
					$('.checking').addClass('hidden');
					$('.danger').removeClass('hidden');
					$('#code').data('ok', '0');
				}
			},400);
		} else {
			$('#code').data('ok', '0');
			$('.danger').removeClass('hidden').addClass('hidden');
			$('.success').removeClass('hidden').addClass('hidden');
		}
	});


	// >.< because when del too fast
	$('#code').click(function(){
		setInterval(function(){
			if ($('#code').val() == '') {
				$('.danger').removeClass('hidden').addClass('hidden');
				$('.success').removeClass('hidden').addClass('hidden');
			}
			if ($('.success').is(':hidden')) {
				$('#add-new-type-btn').prop('disabled', true);
			}
		},300);
	});

	// Check to enable add new voucher type btn
	$('#code, #name').keyup(function(){
		console.log($('#code').data('ok'), $.trim($('#name').val()));
		if ($('#code').data('ok') != '0' && $.trim($('#name').val()) != '') {
			$('#add-new-type-btn').prop('disabled', false);
		} else {
			$('#add-new-type-btn').prop('disabled', true);
		}
	});

	$(document).on("click", ".voucher-row", function(){
		var url = $(this).data('url');
		var id = $(this).data('id');

		$.ajax({
			url : url,
			method : "post",
			data : {
				id : id
			},
			success : function(result) {
				$('.data-insert').html(result);
				$('#view-modal').modal('show');
			}
		});
	});

	$('#voucher-type').change(function(){
		var code = $('#voucher-type :selected').text().substring(0,2);
		if (code == 'PT') {
			$('#income').val('1');
		} else {
			$('#income').val('0');
		}
	});

	$('#voucher-choose').change(function(){
		var id = $(this).val();
		var url = $(this).data('url');

		if (id != 0) {
			$('#act-add-btn').prop('disabled', false);
			$('#act-choose').prop('disabled', false);

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
					if (result.act.length == 1) {
						$('#act-choose').val(result.act[0].id);
						$('#act-choose').trigger("change");
					}
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
			$('#act-choose').prop('disabled', true);
		}

		$('.contain-act-info').html('<h2 class="empty-info">(Hãy lựa chọn bút toán)</h2>');

		var table = $('#distribution_table').DataTable();
		table.row().remove().draw();

		$('#distribute-btn').prop('disabled', true);

	});

	$('#act-add-btn').click(function(){
		$(this).prop('disabled', true);
		var url = $(this).data('url');

		$.ajax({
			url : url,
			dataType : 'json',
			success : function(result) {
				var row = [];

				for(var i in result) {
					row.push(result[i]);
				}

				$('#act_table').DataTable().row.add(row).draw();
			}
		});

	});

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
				var table = $('#act_table').DataTable();
				var form_row = $('.contain-act-row tr:last-child');
				table.row(form_row).remove().draw();
				$('#act-add-btn').prop('disabled', false);
				if (result.success) {
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

	// When add accounting entry by  get method
	if ($('#set-voucher').length && $('#set-voucher').val()) {
		var id_arr = $('#list_id_voucher').val().split(',');
		var id = $('#set-voucher').val();

		if (id_arr.includes(id)) {
			$('#voucher-choose').val(id);
			$('#voucher-choose').trigger("change");
		}
	}

	// Distribution Fill site
	$('#act-choose').change(function(){
		var id = $(this).val();
		var url = $(this).data('url');

		if (id != 0) {
			$('#distribute-btn').prop('disabled', false);
			$('#distribute-update-btn').data('id', id);

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
					$('#tot').val(result.tot);
					$('#toa').val(result.toa);

					var table = $('#distribution_table').DataTable();
					table.row().remove().draw();
					for (var i = 0; i < result.distributes.length; i++) {
						table.row.add([result.distributes[i]['dimensional_id'],convertToCurrency(result.distributes[i]['value']) + ' đ',result.distributes[i]['content']]).draw();
					}

					var val = "";
					for (var i = 0; i < result.dimensionals.length; i++) {
						var temp = result.dimensionals[i].id + "," + result.dimensionals[i].code + "," +  result.dimensionals[i].name + ".";
						val += temp;
					}
					$('#dimension').val(val);
				},
				complete : function(){
					$('.load-info').css('display', 'none');
				}
			});

		} else {
			$('.contain-act-info').html('<h2 class="empty-info">(Hãy lựa chọn bút toán)</h2>');

			var table = $('#distribution_table').DataTable();
			table.row().remove().draw();

			$('#distribute-btn').prop('disabled', true);
		}
	});

	$('#distribute-btn').click(function(){

		$(this).prop('disabled', true);
		var url = $(this).data('url');

		$.ajax({
			url : url,
			dataType : 'json',
			success : function(result) {
				var row = [];

				for(var i in result) {
					row.push(result[i]);
				}

				$('#distribution_table').DataTable().row.add(row).draw();
			}
		});

	});

	$('#distribute-update-btn').click(function(){
		var data = {
			'entry_id' : $(this).data('id'),
			'dimen_id' : $('#dimension').val(),
			'TOT' : $('#tot').val(),
			'TOA' : $('#toa').val(),
			'value' : $('#value').val(),
			'content' : $('#content').val()
		};
		var url = $(this).data('url');
		$.ajax({
			url : url,
			method : "POST",
			dataType : "json",
			data : data,
			beforeSend: function() {
				$('.load-info-act').css('display', 'flex');
			},
			success : function(result) {
				$('.alert').html(result.message);
				var table = $('#distribution_table').DataTable();
				var form_row = $('.contain-distribution-row tr:last-child');
				table.row(form_row).remove().draw();
				$('#distribute-btn').prop('disabled', false);
				if (result.success) {
					$('#distribution_table').DataTable().row.add([data.dimen_id,data.value,data.content]).draw();

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

	// When change, check valid input
	$(document).on("change", "#voucher-type, #executor, #TOA, #value, #debit_acc, #credit_acc", checkToEnableOk);
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

	if ($('#voucher-type').val() == 0) {
		flag = false;
	}

	if ($('#executor').val() == 0) {
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
		$('#distribute-update-btn').prop('disabled', false);
		$('#voucher-done').prop('disabled', false);
	}
	else {
		$('#update-act-btn').prop('disabled', true);
		$('#distribute-update-btn').prop('disabled', true);
		$('#voucher-done').prop('disabled', true);
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
