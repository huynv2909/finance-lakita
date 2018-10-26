// click to view detail voucher
$(document).on("click", ".voucher-id", function(){
   var url = $(this).data('url');
   var id = $(this).data('id');

   $.ajax({
      url : url,
      method : "post",
      data : {
         id : id
      },
      beforeSend: function() {
         $('#root-waiting').css('display', 'flex');
      },
      success : function(result) {
         $('.title-insert').html('Thông tin chứng từ');
         $('.data-insert').html(result);
         $('#view-modal').modal('show');
      },
      complete: function() {
         $('#root-waiting').css('display', 'none');
      }
   });
});

$(document).on("click", ".value-acc", function(){
   var url = $(this).data('url');
   var id = $(this).data('id');

   $.ajax({
      url : url,
      method : "post",
      data : {
         id : id
      },
      beforeSend: function() {
         $('#root-waiting').css('display', 'flex');
      },
      success : function(result) {
         $('.title-insert').html('Trạng thái phân bổ');
         $('.data-insert').html(result);
         $('#view-modal').modal('show');
      },
      complete: function() {
         $('#root-waiting').css('display', 'none');
      }
   });


});

$(document).on("click", ".del-btn", function(){
   var id = $(this).data('id');
   var url = $(this).data('url');
   var current_btn = $(this);

   $.confirm({
       icon: 'fa fa-remove',
       title: 'Xóa?',
       content: 'Xóa bỏ bút toán?!',
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
                            var table = $('#accounting_table').DataTable();
                            var row = current_btn.parent().parent();
                            table.row(row).remove().draw();

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
