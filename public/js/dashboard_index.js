$(document).ready(function(){
   $('#date_choose').change(function(){
      var choose = $(this).val();
      var today = new Date();
      var dd = today.getDate();
      var mm = today.getMonth() + 1;
      var yyyy = today.getFullYear();
      var url = $('#dashboard_url').val();

      if (choose != '0') {
         location.href = url + '?date_range=' + choose.toString();
      } else {
         $.confirm({
             title: 'Tùy chỉnh:',
             theme: 'material',
             content: '' +
             '<form method="get">' +
             '<div class="form-group">' +
             '<label>Từ</label>' +
             '<input id="from" type="date" placeholder="Từ" class="name form-control" required />' +
             '</div>' +
             '<div class="form-group">' +
             '<label>Đến</label>' +
             '<input id="to" type="date" placeholder="Đến" class="name form-control" required />' +
             '</div>' +
             '</form>',
             buttons: {
                 formSubmit: {
                     text: 'Ok',
                     btnClass: 'btn-green',
                     action: function () {
                         var from = this.$content.find('#from').val();
                         var to = this.$content.find('#to').val();

                         location.href = url + '?from=' + from + '&to=' + to;
                     }
                 },
                 cancel: function () {
                     //close
                 },
             }
         });
      }

   });

   $(document).on("click", "#refresh-btn", function(){
      $('#date_choose').trigger('change');
   });

});
