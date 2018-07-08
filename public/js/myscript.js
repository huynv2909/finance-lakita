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
					if ($.trim($('#name').val()) != '') {
						$('#add-new-type-btn').prop('disabled', false);
					} else {
						$('#add-new-type-btn').prop('disabled', true);
					}
				} else {
					$('.success').removeClass('hidden').addClass('hidden');
					$('.checking').addClass('hidden');
					$('.danger').removeClass('hidden');
					$('#code').data('ok', '0');
					$('#add-new-type-btn').prop('disabled', true);
				}
			},300);
		} else {
			$('#code').data('ok', '0');
			$('.danger').removeClass('hidden').addClass('hidden');
			$('.success').removeClass('hidden').addClass('hidden');
			$('#add-new-type-btn').prop('disabled', true);
		}
	});


	// >.< because when del too fast
	$('#code').click(function(){
		setInterval(function(){
			if ($('#code').val() == '') {
				$('.danger').removeClass('hidden').addClass('hidden');
				$('.success').removeClass('hidden').addClass('hidden');
			}
		},300);
	});

	// Check to enable add new voucher type btn
	$('#name').keyup(function(){
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
						var temp = result.dimensionals[i].id + "~" + result.dimensionals[i].code + "~" +  result.dimensionals[i].name + "|";
						val += temp;
					}
					$('#dimension-list').val(val);
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
				var form_row = $('.form-cell').parent().parent();
				table.row(form_row).remove().draw();
				$('#distribute-btn').prop('disabled', false);
				if (result.success) {
					$('#distribution_table').DataTable().row.add([dimenIdToName(data.dimen_id),data.value,data.content]).draw();

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


	// Active a type
	$(document).on("click", ".exchange-btn", function(){
		var id = $(this).data('id');
		var url = $(this).data('url');
		var active = $(this).data('active');

		var current_tag = $(this);

		$.confirm({
			 icon: 'fa fa-exchange',
			 title: 'Chuyển trạng thái?',
			 content: 'Tiếp tục?',
			 theme: 'material',
			 type: 'yellow',
			 buttons: {
				  Ok: {
						text: 'Ok',
						btnClass: 'btn-green',
						keys: ['enter'],
						action: function(){
							 $.ajax({
								 url : url,
								 method : "POST",
								 data : {
									 id : id,
									 active : active
								 },
								 success : function(result) {
									 console.log(result);
									 if (active == 1) {
	 									current_tag.data('active', '0');
	 									current_tag.html('');
	 									current_tag.removeClass('active-color');
	 								 } else {
	 									current_tag.data('active', '1');
	 									current_tag.html('');
	 									current_tag.addClass('active-color');
	 								}
								 }
							 });
						}
				  },
				  later: {
					  text: 'Hủy',
					  keys: ['esc'],
					  action: function(){
					  }
				  }
			 }
		});

	});

	$(document).on("click", ".del-type-btn", function(){
		var id = $(this).data('id');
		var url = $(this).data('url');

		$.confirm({
			 icon: 'fa fa-remove',
			 title: 'Xóa?',
			 content: 'Hãy chắc chắn rằng mã chưa từng được sử dụng!',
			 theme: 'material',
			 type: 'red',
			 buttons: {
				  Ok: {
						text: 'Ok',
						btnClass: 'btn-green',
						keys: ['enter'],
						action: function(){
							 $.ajax({
								 url : url,
								 method : "POST",
								 dataType : "JSON",
								 data : {
									 id : id
								 },
								 success : function(result) {
									 if (result.success) {
									 	 var table = $('#voucher_types_table').DataTable();
						 				 var row = $('#type-' + id.toString());
										 var old_code = $(row).children('td:first-child').html();
						 				 table.row(row).remove().draw();

										 $('#list_code').val($('#list_code').val().replace(old_code + ",",''));
										 // console.log(result.message);
									 } else {
										 $.alert(result.message);
									 }
								 }
							 });
						}
				  },
				  cancel: {
					  text: 'Hủy',
					  keys: ['esc'],
					  action: function(){
					  }
				  }
			 }
		});

	});

	//  CHECK DEBIT vs CREDIT
});

$('#tot').change(function() {

	if ($('#toa').val() > $('#tot').val()) {
		$('#toa').val($(this).val());
	}
	$('#toa').attr('max', $(this).val());
});

function dimenIdToName($dimen_id) {
	var dimen_arr = $('#dimension-list').val().split('|');
	var response = '';

	for (var i = 0; i < dimen_arr.length; i++) {
		var attr_arr = dimen_arr[i].split('~');
		if (attr_arr[0] == $dimen_id) {
			response = attr_arr[1] + " : " + attr_arr[2];
			break;
		}
	}

	return response;
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
