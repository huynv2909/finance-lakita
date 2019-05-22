$(document).ready(function(){

   $(document).on("click", ".log-row", function(){
		var url = $(this).data('url');
		var id = $(this).data('id');
      var model = $(this).data('model');

		$.ajax({
			url : url,
			method : "post",
			data : {
				id : id,
            model : model
			},
         beforeSend: function() {
            $('#root-waiting').css('display', 'flex');
         },
			success : function(result) {
				$('.data-insert').html(result);
				$('#view-modal').modal('show');
			},
         complete: function() {
            $('#root-waiting').css('display', 'none');
         }
		});
	});

});
