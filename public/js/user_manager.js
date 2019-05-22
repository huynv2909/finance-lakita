$(document).on("click", ".del-btn", function(){
   var id = $(this).data('id');
   var url = $(this).data('url');
   var current_btn = $(this);

   $.confirm({
       icon: 'fa fa-remove',
       title: 'Xóa?',
       content: 'Xóa bỏ người dùng?!',
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
                            $('#row-' + id.toString()).fadeOut();

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


$(document).on("change", "#change-password", function(){
   if ($('#change-password').is(":checked")) {
      $('#password').val('');
      $('#password').prop('disabled', false);
      $('#password').focus();
   } else {
      $('#password').val('********');
      $('#password').prop('disabled', true);
   }
});

$(document).on("click", ".edit-btn", function(){
   var id = $(this).data('id');
   var url = $(this).data('url');
   var current_btn = $(this);

   $.confirm({
      columnClass: 'large',
      theme: 'material',
      title: 'Thay đổi thông tin tài khoản:',
      closeIcon: true,
      type: 'orange',
      typeAnimated: true,
      buttons: {
        ok: {
           text: 'Cập nhật',
           btnClass: 'btn-orange update-submit',
           action: function () {
               $('#edit-act-form').trigger("submit");
           }
        },
        cancel: {
            text: 'Hủy'
        }
      },
       content: function(){
           var self = this;
           return $.ajax({
               url: url,
               method: 'post',
               dataType: 'text',
               data: {
                  id : id
               }
           }).done(function (response) {
               self.setContentAppend(response);
           }).fail(function(){
               self.setContentAppend('<div>Fail!</div>');
           });
       }
   });

});
