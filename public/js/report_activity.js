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

            // console.log(offset);
            // console.log($(window).height() + offset);
            // console.log($($('.catalog-table')[1]).height());
            if ($(window).scrollTop() + $(window).height() - tableOffsetTop < parseInt($('#height-table').val())) {
               $this.css('height', $(window).scrollTop() + $(window).height() - tableOffsetTop);
            } else {
               $this.css('height', parseInt($('#height-table').val()));
            }


         }
         $(window).resize(resizeFixed);
         $(window).scroll(scrollFixed);
         init();
      });
   };
})(jQuery);

function daysInMonth(month, year) {
    return new Date(year, month, 0).getDate();
}

$(document).ready(function(){
   // Why 18? Fuck!
   $('#height-table').val($('.report').height() - 18);
   $("table").fixMe();

   $('.report').scroll(function(){
      $('.report').scrollLeft($(this).scrollLeft());
   });

   $('.cell').hover(function() {
      var column_tag = $(this).data('column');
      var row_tag = $(this).data('row');

      $(this).css({"color": "brown", "font-weight":"bold", "border": "1px solid brown"});

      $('.column-' + column_tag).css("background-color", "aliceblue");
      $('.row-' + row_tag).css("background-color", "aliceblue");

      $('.row-total-' + row_tag).css("background-color", "firebrick");
      $('.row-total-' + row_tag).css("color", "aliceblue");

   }, function() {
      var column_tag = $(this).data('column');
      var row_tag = $(this).data('row');

      $(this).css({"color": "#333", "font-weight":"normal", "border": "1px solid #333"});

      $('.column-' + column_tag).css("background-color", "");
      $('.row-' + row_tag).css("background-color", "");

      $('.row-total-' + row_tag).css("background-color", "");
      $('.row-total-' + row_tag).css("color", "");
   });

   $('.cell').click(function(){
      var column_tag = $(this).data('column');
      var row_tag = $(this).data('row');

      var type = column_tag.substring(0,3);
      var date_point = column_tag.substring(4);

      var from = '';
      var to = '';

      if (date_point.length == 4) {
         from = date_point + '-01-01';
         to = date_point + '-12-31';
      }

      if (date_point.length == 7) {
         var month = date_point.substring(0,2);
         var year = date_point.substring(3);

         from = year + '-' + month + '-01';
         to = year + '-' + month + '-' + daysInMonth(month, year);
      }

      if (date_point.length == 10) {
         from = date_point.substring(6) + '-' + date_point.substring(3,5) + '-' + date_point.substring(0,2);
         to = date_point.substring(6) + '-' + date_point.substring(3,5) + '-' + date_point.substring(0,2);
      }

      var url = $('#url-data').val();

      $.confirm({
         title: "Xem dữ liệu:",
         theme: 'material',
         columnClass: 'col-lg-10 col-lg-offset-1 col-md-8 col-md-offset-2',
          content: function () {
              var self = this;
              return $.ajax({
                  url: url,
                  dataType: 'text',
                  data : {
                     id : row_tag,
                     type : type,
                     from : from,
                     to : to
                  },
                  method: 'post'
              }).done(function (response) {
                  // self.setContent('Description: ' + response.description);
                  self.setContentAppend(response);
                  // self.setTitle(response.name);
              }).fail(function(){
                  self.setContent('Something went wrong.');
              });
          }
      });

   });

});
