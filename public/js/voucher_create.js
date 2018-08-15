$(document).ready(function(){
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

   // When change type select box
   $('#voucher-type').change(function(){
		var type_id = $(this).val();
		var url = $(this).data('url');

		$.ajax({
			url : url,
			method : "POST",
			dataType : "JSON",
			data : {
				voucher_type_id : type_id
			},
			success : function(result){
				$('#debit_1').val(result.debit_def).change();
				$('#credit_1').val(result.credit_def).change();
				$('#debit_out_1').val(result.debit_def).change();
				$('#credit_out_1').val(result.credit_def).change();
				if (result.income == "1") {
					$('#income').val('1');
					$('#contain-detail-out').slideUp();
					$('#contain-detail-income').slideDown();
					$('#count_sub').data('used', 1);
					$('#count_sub_out').data('used', 0);
				} else {
					$('#dimen_out_1').val(result.first_dimen).change();
					$('#income').val('0');
					$('#contain-detail-income').slideUp();
					$('#contain-detail-out').slideDown();
					$('#count_sub').data('used', 0);
					$('#count_sub_out').data('used', 1);
				}
            updateRemainingAmount();
			}
		});

	});

   // When change sub value of accounting entry
   $(document).on("change", ".sub_value, .sub_course", function(){
		var index_of_last = $('.sub-row:visible').length;
		var count = parseInt($('#count_sub').val());

		var list_sub_tag = $('.sub_value:visible');
		var is_number = true;
		for (var i = 0; i < list_sub_tag.length; i++) {
			if (!$.isNumeric($(list_sub_tag[i]).val().split('.').join(''))) {
				is_number = false;
				break;
			}
		}

		// console.log(index_of_last == count,is_number);
		if (index_of_last <= count && is_number) {
			var value = parseInt($('#value').val().split('.').join(''));
			var total_sub = 0;
			var list_sub_tag = $('.sub_value:visible');
			for (var i = 0; i < list_sub_tag.length; i++) {
				var temp = parseInt($(list_sub_tag[i]).val().split('.').join(''));
				total_sub += temp;
			}

			if (total_sub < value) {
				var new_tag = $('.last-sub-row').clone();
				$(new_tag).find('input:text').val(convertToCurrency((value - total_sub).toString()));
				$(new_tag).insertAfter($('.last-sub-row'));
				var tag_number = count + 1;
				$('#count_sub').val(tag_number);
				$($('.last-sub-row')[0]).removeClass('last-sub-row');
				// Edit properties for new row
				var new_row = $('.last-sub-row')[0];
				// Change ID
				$(new_row).prop('id', "sub-row-" + tag_number.toString());
				$(new_row).data('number',count + 1);
				// edit course
				var course_select = $($($(new_row).children('td')[0]).children('.sub_course'))[0];
				$(course_select).prop('name', 'course_' + tag_number.toString());
				$(course_select).prop('id', 'course_' + tag_number.toString());
				// edit value
				var value_input = $($($(new_row).children('td')[1]).children('.sub_value'))[0];
				$(value_input).prop('name', 'value_' + tag_number.toString());
				$(value_input).prop('id', 'value_' + tag_number.toString());
				// tot value
				var toa_input = $($($(new_row).children('td')[2]).children('.sub_toa'))[0];
				$(toa_input).prop('name', 'toa_' + tag_number.toString());
				$(toa_input).prop('id', 'toa_' + tag_number.toString());
				// edit debit
				var debit_select = $($($(new_row).children('td')[3]).children('.sub_debit'))[0];
				$(debit_select).prop('name', 'debit_' + tag_number.toString());
				$(debit_select).prop('id', 'debit_' + tag_number.toString());
				$(debit_select).val($('.sub_debit').val());
				// edit course
				var credit_select = $($($(new_row).children('td')[4]).children('.sub_credit'))[0];
				$(credit_select).prop('name', 'credit_' + tag_number.toString());
				$(credit_select).prop('id', 'credit_' + tag_number.toString());
				$(credit_select).val($('.sub_credit').val());
				// Edit confirm
				var confirm_input = $($($(new_row).children('td')[5]).children('input'))[0];
				$(confirm_input).prop('name', 'confirm_' + tag_number.toString());
				$(confirm_input).prop('id', 'confirm_' + tag_number.toString());
				// Edit delete
				var delete_i = $($($(new_row).children('td')[5]).children('i'))[0];
				$(delete_i).data('number', tag_number);
			}
		}
      updateRemainingAmount();

	});
	// duplicate for not income ; OUT
	$(document).on("change", ".sub_out_value, .sub_out_dimen", function(){
		// console.log('here');
		// To ensure visible :(
		setTimeout(function(){
			var index_of_last = $('.sub-out-row:visible').length;
			var count = parseInt($('#count_sub_out').val());

			var list_sub_tag = $('.sub_out_value:visible');
			var is_number = true;
			for (var i = 0; i < list_sub_tag.length; i++) {
				if (!$.isNumeric($(list_sub_tag[i]).val().split('.').join(''))) {
					is_number = false;
					break;
				}
			}

			if (index_of_last <= count && is_number) {
				var value = parseInt($('#value').val().split('.').join(''));
				var total_sub = 0;
				var list_sub_tag = $('.sub_out_value:visible');
				for (var i = 0; i < list_sub_tag.length; i++) {
					var temp = parseInt($(list_sub_tag[i]).val().split('.').join(''));
					total_sub += temp;
				}

				if (total_sub < value) {
					var new_tag = $('.last-sub-out-row').clone();
					$(new_tag).find('input:text').val(convertToCurrency((value - total_sub).toString()));
					$(new_tag).insertAfter($('.last-sub-out-row'));
					var tag_number = count + 1;
					$('#count_sub_out').val(tag_number);
					$($('.last-sub-out-row')[0]).removeClass('last-sub-out-row');
					// Edit properties for new row
					var new_row = $('.last-sub-out-row')[0];
					// Change ID
					$(new_row).prop('id', "sub-out-row-" + tag_number.toString());
					$(new_row).data('number',count + 1);
					// edit course
					var dimen_select = $($($(new_row).children('td')[0]).children('.sub_out_dimen'))[0];
					$(dimen_select).prop('name', 'dimen_out_' + tag_number.toString());
					$(dimen_select).prop('id', 'dimen_out_' + tag_number.toString());
					$(dimen_select).val($('.sub_out_dimen').val());
					// edit value
					var value_input = $($($(new_row).children('td')[1]).children('.sub_out_value'))[0];
					$(value_input).prop('name', 'value_out_' + tag_number.toString());
					$(value_input).prop('id', 'value_out_' + tag_number.toString());
					// tot value
					var toa_input = $($($(new_row).children('td')[2]).children('.sub_out_toa'))[0];
					$(toa_input).prop('name', 'toa_out_' + tag_number.toString());
					$(toa_input).prop('id', 'toa_out_' + tag_number.toString());
					// edit debit
					var debit_select = $($($(new_row).children('td')[3]).children('.sub_out_debit'))[0];
					$(debit_select).prop('name', 'debit_out_' + tag_number.toString());
					$(debit_select).prop('id', 'debit_out_' + tag_number.toString());
					$(debit_select).val($('.sub_out_debit').val());
					// edit course
					var credit_select = $($($(new_row).children('td')[4]).children('.sub_out_credit'))[0];
					$(credit_select).prop('name', 'credit_out_' + tag_number.toString());
					$(credit_select).prop('id', 'credit_out_' + tag_number.toString());
					$(credit_select).val($('.sub_out_credit').val());
					// Edit confirm
					var confirm_input = $($($(new_row).children('td')[5]).children('input'))[0];
					$(confirm_input).prop('name', 'confirm_out_' + tag_number.toString());
					$(confirm_input).prop('id', 'confirm_out_' + tag_number.toString());
					// Edit delete
					var delete_i = $($($(new_row).children('td')[5]).children('i'))[0];
					$(delete_i).data('number', tag_number);
				}
			}
         updateRemainingAmount();
		}, 120);

	});

   // click to view detail voucher
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

   // When change, check valid input
	$(document).on("change", "#voucher-type, #executor, #tot, #value, .sub_course, .sub_out_dimen, .sub_value, .sub_out_value", checkToEnableOk);
	// 1
	$(document).on("keyup", "#value", checkToEnableOk);
	// 1
	$('#value').change(function(){
		if ($('#count_sub').val() == 1) {
			if ($.trim($('#value_1').val()) == '') {
				$('#value_1').val($(this).val());
			}
		}

		if ($('#count_sub_out').val() == 1) {
			if ($.trim($('#value_out_1').val()) == '') {
				$('#value_out_1').val($(this).val());
			}
		}

      updateRemainingAmount();

	});

   $(document).on("click", ".delete_sub", function(){
		if ($('.sub-row:visible').length > 1) {
			var number = $(this).data('number');

			$('#sub-row-' + number.toString()).fadeOut(100);
			$('#value_' + number.toString()).data('alive', 0);
			$('#confirm_' + number.toString()).val(0);
         $('#remaining-amount').html(convertToCurrency( (parseInt($('#remaining-amount').html().split('.').join('')) + parseInt($('#value_' + number.toString()).val().split('.').join(''))).toString() ));

			if ($('#sub-row-' + number.toString()).hasClass("last-sub-row")) {

				$('#sub-row-' + number.toString()).removeClass("last-sub-row");
				setTimeout(function(){
					$('.sub-row:visible:last').addClass("last-sub-row");
				},200);
			}

			checkToEnableOk();
		}

	});

	$(document).on("click", ".delete_out_sub", function(){
		if ($('.sub-out-row:visible').length > 1) {
			var number = $(this).data('number');

			$('#sub-out-row-' + number.toString()).fadeOut(100);
			$('#value_out_' + number.toString()).data('alive', 0);
			$('#confirm_out_' + number.toString()).val(0);
         $('#remaining-amount').html(convertToCurrency( (parseInt($('#remaining-amount').html().split('.').join('')) + parseInt($('#value_out_' + number.toString()).val().split('.').join(''))).toString() ));

			if ($('#sub-out-row-' + number.toString()).hasClass("last-sub-out-row")) {

				$('#sub-out-row-' + number.toString()).removeClass("last-sub-out-row");
				setTimeout(function(){
					$('.sub-out-row:visible:last').addClass("last-sub-out-row");
				},200);
			}

			checkToEnableOk();
		}

	});

});

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
	if ($('#tot').val() == '') {
		flag = false;
	}

	if ($('#count_sub').length && $('#count_sub').data('used')) {
		var n = $('#count_sub').val();
		var total = 0;
		for (var i = 1; i <= n; i++) {
			if ($('#confirm_' + i.toString()).val() == 1) {
				if ($('#course_' + i.toString()).val() == 0) {
					flag = false;
					break;
				}

				var value_temp = $('#value_' + i.toString()).val();
				if ($.trim(value_temp) == '' || !$.isNumeric(value_temp.split('.').join(''))) {
					flag = false;
					break;
				} else {
					total += parseInt(value_temp.split('.').join(''));
				}
			}
		}

		if (parseInt(str_value) != total) {
			flag = false;
		}
	}

	if ($('#count_sub_out').length && $('#count_sub_out').data('used')) {
		var n = $('#count_sub_out').val();
		var total = 0;
		for (var i = 1; i <= n; i++) {
			if ($('#confirm_out_' + i.toString()).val() == 1) {
				if ($('#dimen_out_' + i.toString()).val() == 0) {
					flag = false;
					break;
				}

				var value_temp = $('#value_out_' + i.toString()).val();
				if ($.trim(value_temp) == '' || !$.isNumeric(value_temp.split('.').join(''))) {
					flag = false;
					break;
				} else {
					total += parseInt(value_temp.split('.').join(''));
				}
			}
		}

		if (parseInt(str_value) != total) {
			flag = false;
		}
	}

	if (flag) {
		$('#voucher-done').prop('disabled', false);
	}
	else {
		$('#voucher-done').prop('disabled', true);
	}
}

function updateRemainingAmount() {
   setTimeout(function(){
      var total_sub = 0;
      if ($('#count_sub').data('used') == 1) {
         var list_sub = $('.sub_value');
         for (var i = 0; i < list_sub.length; i++) {
            if ($(list_sub[i]).data('alive') == 1) {
               total_sub += parseInt($(list_sub[i]).val().split('.').join(''));
            }
         }
      }

      if ($('#count_sub_out').data('used') == 1) {
         var list_sub = $('.sub_out_value');
         for (var i = 0; i < list_sub.length; i++) {
            if ($(list_sub[i]).data('alive') == 1) {
               total_sub += parseInt($(list_sub[i]).val().split('.').join(''));
            }
         }
      }

      $('#remaining-amount').html(convertToCurrency( (parseInt($('#value').val().split('.').join('')) - total_sub).toString() ));
   },300);
}
