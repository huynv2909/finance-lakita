;(function($) {
   $.fn.fixMe = function() {
      return this.each(function() {
         var $this = $(this),
            $t_fixed;
         function init() {
            $t_fixed = $this.clone();
            $t_fixed.find("tbody").remove().end().addClass("fixed").insertBefore($this);
            resizeFixed();
         }
         function resizeFixed() {
            $t_fixed.find("th").each(function(index) {
               $(this).css("width",$this.find("th").eq(index).outerWidth()+"px");
            });
         }
         function scrollFixed() {
            var offset = $(this).scrollTop(),
            tableOffsetTop = $this.offset().top,
            tableOffsetBottom = tableOffsetTop + $this.height() - $this.find("thead").height();
            if(offset < tableOffsetTop || offset > tableOffsetBottom)
               $t_fixed.css('display', 'none');
            else if(offset >= tableOffsetTop && offset <= tableOffsetBottom && $t_fixed.is(":hidden"))
            {
               $t_fixed.css('width', $this.width());
               $t_fixed.addClass('hide-scrollbar');
               $t_fixed.css('display', 'block');
            }


         }
         $(window).resize(resizeFixed);
         $(window).scroll(scrollFixed);
         init();
      });
   };
})(jQuery);


$(document).ready(function(){
   $("#new-vouchers").fixMe();

   $('.have-cod').change(function(){
      var id = $(this).data('id');
      if ($(this).is(":checked")) {
         $('#cod_value_' + id).attr('disabled', false);
      } else {
         $('#cod_value_' + id).attr('disabled', true);
      }
   });

   $('.have-vat').change(function(){
      var id = $(this).data('id');
      if ($(this).is(":checked")) {
         $('#vat_value_' + id).attr('disabled', false);
      } else {
         $('#vat_value_' + id).attr('disabled', true);
      }
   });

   $('.approve').click(function(){
      $(this).prop('disabled', true);
      $(this).parent().children('.deny').prop('disabled', true);
      var url = $('#url-approve-one').val();
      var id = $(this).data('id');
      var have_cod = 0;
      var have_vat = 0;
      var have_auto = 1;

      if ($('#cod_' + id).is(":checked")) {
         have_cod = 1;
      } else {
         have_cod = 0;
      }

      if ($('#vat_' + id).is(":checked")) {
         have_vat = 1;
      } else {
         have_vat = 0;
      }

      if ($('#auto_' + id).is(":checked")) {
         have_auto = 1;
      } else {
         have_auto = 0;
      }

      $.ajax({
         url : url,
         method : "post",
         data : {
            id : id,
            type_id : $('#type_' + id).val(),
            content : $('#content_' + id).val(),
            course : $('#course_' + id).val(),
            value : $('#value_' + id).val(),
            vat : have_vat,
            vat_value : $('#vat_value_' + id).val(),
            cod : have_cod,
            cod_value : $('#cod_value_' + id).val(),
            tot : $('#tot_' + id).val(),
            executor : $('#executor_' + id).val(),
            method : $('#method_' + id).val(),
            provider : $('#provider_' + id).val(),
            auto : have_auto
         },
         beforeSend: function() {
            $('#root-waiting').css('display', 'flex');
         },
         success : function(result) {
            $('#remaining').html(parseInt($('#remaining').html()) - 1);

            $('#row-' + id).slideUp(1000);
            $('.alert').html(result);
            $('.alert').addClass('alert-success');

            $('.alert').fadeIn();
				setTimeout(function(){
					$('.alert').fadeOut();
					$('.alert').removeClass('alert-success alert-danger');
				}, 4000);
         },
         complete: function() {
            $('#root-waiting').css('display', 'none');
         }
      });

   });

   $('.deny').click(function(){
      $(this).prop('disabled', true);
      $(this).parent().children('.approve').prop('disabled', true);

      var url = $('#url-deny-one').val();
      var id = $(this).data('id');

      $.confirm({
			 icon: 'fa fa-remove',
			 title: 'Xóa?',
			 content: 'Bạn có chắc rằng sẽ xóa hoàn toàn chứng từ này?',
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
                        method : "post",
                        data : {
                           id : id
                        },
                        beforeSend: function() {
                           $('#root-waiting').css('display', 'flex');
                        },
                        success : function(result) {
                           $('#remaining').html(parseInt($('#remaining').html()) - 1);

                           $('#row-' + id).slideUp(1000);
                           $('.alert').html(result);
                           $('.alert').addClass('alert-success');

                           $('.alert').fadeIn();
                          setTimeout(function(){
                             $('.alert').fadeOut();
                             $('.alert').removeClass('alert-success alert-danger');
                          }, 4000);
                        },
                        complete: function() {
                           $('#root-waiting').css('display', 'none');
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

   $('.slide-filter').click(function(){
		var invisible = $(this).data('hidden');

		if (invisible == '0') {
			$('.filter-box').slideUp();
			$(this).html('');
			$(this).data('hidden', 1);
		} else {
			$('.filter-box').slideDown();
			$(this).html('');
			$(this).data('hidden', 0);
		}

	});

   $('#lets-filter').click(function(){
      var extension = '?';
      var flag = false;

      if ($('#fil-from').val() != '') {
         flag = true;
         extension += 'from=' + $('#fil-from').val() + '&';
      }

      if ($('#fil-to').val() != '') {
         flag = true;
         extension += 'to=' + $('#fil-to').val() + '&';
      }

      if ($('#fil-method').val() != '0') {
         flag = true;
         extension += 'method=' + $('#fil-method').val() + '&';
      }

      if ($('#fil-provider').val() != '0') {
         flag = true;
         extension += 'provider=' + $('#fil-provider').val() + '&';
      }

      if ($('#fil-voucher_type').val() != '0') {
         flag = true;
         extension += 'voucher_type=' + $('#fil-voucher_type').val() + '&';
      }

      if (flag) {
         window.location.href = $('#reset-filter-link').prop('href') + extension;
      }


   });

   $('.filter-field').change(function(){
      if ($(this).val() != '' && $(this).val() != '0') {
         $(this).css('background-color', 'antiquewhite');
      } else {
         $(this).css('background-color', '#fff');
      }
   });

   $('select.info-100').each(function() {
     if ($(this).val() == '0') {
       $(this).css({"background-color": "indianred", "color": "#fff"});
     }
   });

   $('select.info-100').change(function() {
     if ($(this).val() == '0') {
       $(this).css({"background-color": "indianred", "color": "#fff"});
     } else {
       $(this).css({"background-color": "buttonface", "color": "inherit"});
     }
   });

   $('.method').change(function(){
      var id = $(this).val();
      var id_item = $(this).data('id');
      var url = $(this).data('url');

      $.ajax({
         url: url,
         method : "POST",
         dataType : "JSON",
         data : {
            id : id
         },
         success : function(result){
            var html = '<option value="0">Chưa xác định</option>';
            for (var i = 0; i < result.length; i++) {
               html += '<option value="' + result[i]['id'] + '">' + result[i]['name'] + ' : ' + result[i]['description'] + '</option>'
            }

            $('#provider_' + id_item).html(html);
            $('#provider').prop('disabled', false);

         }
      })
   });

   $('.approve-multiple').click(function(){
     $('.approve-multiple').css('display', 'none');
     $('.deny-multiple').css('display', 'none');
     $('.approve').css('display', 'none');
     $('.deny').css('display', 'none');

     $('#allowed-check').val("1");
     $('#action-index').val("1");

     $('.confirm-action').css('display', 'inline-block');
     $('.cancel-action').css('display', 'inline-block');
     $('.choose_check').css('display', 'inline-block');
   });

   $('.deny-multiple').click(function(){
     $('.approve-multiple').css('display', 'none');
     $('.deny-multiple').css('display', 'none');
     $('.approve').css('display', 'none');
     $('.deny').css('display', 'none');

     $('#allowed-check').val("1");
     $('#action-index').val("0");

     $('.confirm-action').css('display', 'inline-block');
     $('.cancel-action').css('display', 'inline-block');
     $('.choose_check').css('display', 'inline-block');
   });


   $('.cancel-action').click(function(){
     $('.confirm-action').css('display', 'none');
     $('.cancel-action').css('display', 'none');
     $('.choose_check').css('display', 'none');

     $('#allowed-check').val("0");

     $('.approve-multiple').css('display', 'inline-block');
     $('.deny-multiple').css('display', 'inline-block');
     $('.approve').css('display', 'inline-block');
     $('.deny').css('display', 'inline-block');
   });

   $('.confirm-action').click(function(){

     // Approve all
     if ($('#allowed-check').val() == "1" && $('#action-index').val() == "1") {
       var time = 500;
       $('.choose_check:checked').each(function(index){
         var chosen_checkbox = $(this);
         setTimeout(function(){
           $('#approve_' + chosen_checkbox.data('id')).trigger( "click" );
         }, time);

         time += 500;
       });
     }

     // Delete all
     if ($('#allowed-check').val() == "1" && $('#action-index').val() == "0") {
       var time = 500;
       $('.choose_check:checked').each(function(index){
         var chosen_checkbox = $(this);
         setTimeout(function(){
           $('#deny_' + chosen_checkbox.data('id')).trigger( "click" );
         }, time);

         time += 500;
       });
     }

     $('.confirm-action').css('display', 'none');
     $('.cancel-action').css('display', 'none');
     $('.choose_check').css('display', 'none');

     $('#allowed-check').val("0");
     $('.choose_check').prop('checked', true);

     $('.approve-multiple').css('display', 'inline-block');
     $('.deny-multiple').css('display', 'inline-block');
     $('.approve').css('display', 'inline-block');
     $('.deny').css('display', 'inline-block');
   });

});
