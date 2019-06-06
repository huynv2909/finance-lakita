$(document).ready(function(){
   $('#dimension-choose').change(function(){
		var id = $(this).val();
		var url = $(this).data('url');

		if (id != 0) {
			$('#detail-add-btn').prop('disabled', false);

			$.ajax({
				method: "POST",
				url: url,
				dataType: "JSON",
				data: {
					id : id
				},
            beforeSend: function() {
               $('#root-waiting').css('display', 'flex');
            },
				success: function(result) {
					var table = $('#detail_dimen_table').DataTable();
					table.row().remove().draw();
					for (var i = 0; i < result.details.length; i++) {
						table.row.add([result.details[i]['name'],result.details[i]['note'],result.details[i]['parent_name'],result.details[i]['layer'],result.details[i]['sequence'],result.details[i]['exchange'] + result.details[i]['delete']]).draw();
					}

               $('#dimen_id').val(result.info_dimen['id']);
               $('#dimen_code').val(result.info_dimen['code']);
               $('#dimen_layer').val(result.info_dimen['layer']);

               var html = '';
               for (var i = 0; i < result.list_parent.length; i++) {
                  html += result.list_parent[i]['id'].toString() + '~' + result.list_parent[i]['name'] + '|';
               }
               $('#list_parent').val(html);
				},
            complete: function() {
               $('#root-waiting').css('display', 'none');
            }
			});

		} else {

			var table = $('#detail_dimen_table').DataTable();
			table.row().remove().draw();

			$('#detail-add-btn').prop('disabled', true);
			$('#detail-update-btn').prop('disabled', true);
		}

	});

   $(document).on("click", ".del-btn", function(){
		var id = $(this).data('id');
		var url = $(this).data('url');
		var current_btn = $(this);

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
                            $('.alert').html(result.message);
									 if (result.success) {
									 	 var table = $('#detail_dimen_table').DataTable();
						 				 var row = current_btn.parent().parent();
						 				 table.row(row).remove().draw();

										 $('.alert').addClass('alert-success');
									 } else {
										 $('.alert').addClass('alert-danger');
									 }
                            $('.alert').fadeIn();
                				setTimeout(function(){
                					$('.alert').fadeOut();
                					$('.alert').removeClass('alert-success alert-danger');
                				}, 3000);

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

   $('#detail-add-btn').click(function(){
      var url = $('#url-add').val();

      var html_dimen_id = '<input type="hidden" name="dimen_id" value="' + $('#dimen_id').val() + '">';
      var html_dimen_code = '<input type="hidden" name="dimen_code" value="' + $('#dimen_code').val() + '">';
      var html_dimen_layer = '<input type="hidden" name="dimen_layer" value="' + $('#dimen_layer').val() + '">';
      console.log(html_dimen_layer);

      var list_parent = $('#list_parent').val().split('|');
      var html_parent_start = '<select class="form-control" name="parent_id" disabled="true"><option value="0" selected>Không có</option>';

      if (list_parent.length > 1) {
         html_parent_start = '<select class="form-control" name="parent_id">';
         var option = '<option value="0" class="hidden" selected>Không có</option>';
         for (var i = 0; i < list_parent.length - 1; i++) {
            var temp = list_parent[i].split('~');
            option += '<option value="' + temp[0] + '">' + temp[1] + '</option>';
         }

         html_parent_start += option;
      }

      html_parent_start += '</select>'

      $.confirm({
          columnClass: 'xlarge',
			 title: 'Thêm chi tiết',
			 content: '<form id="form-add" class="form-horizontal" method="post" id="dimension-form" action="' + url + '">' +
          html_dimen_id + html_dimen_code + html_dimen_layer +
          '<div class="col-md-6">' +
          '<div class="form-group">' +
            '<label for="name" class="col-xs-3 control-label text-right"><span class="text-danger">(*)</span> Tên chi tiết:</label>' +
            '<div class="col-xs-9">' +
               '<textarea name="name" class="form-control"></textarea>' +
            '</div>' +
          '</div>' +
          '<div class="form-group">' +
            '<label for="note" class="col-xs-3 control-label text-right">Ghi chú:</label>' +
            '<div class="col-xs-9">' +
               '<textarea name="note" class="form-control"></textarea>' +
            '</div>' +
          '</div>' +
          '</div>' +
          '<div class="col-md-6">' +
          '<div class="form-group">' +
            '<label for="parent-dimen" class="col-xs-3 control-label text-right"> Chiều cha:</label>' +
            '<div class="col-xs-9">' +
                  html_parent_start +
            '</div>' +
          '</div>' +
          '</form>',
			 theme: 'material',
			 type: 'yellow',
			 buttons: {
				  Ok: {
						text: 'Ok',
						btnClass: 'btn-green',
						keys: ['enter'],
						action: function(){
                     $('#form-add').submit();
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

});
