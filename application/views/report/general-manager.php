<div class="row">
   <div class="col-xs-12">
      <h4>Số liệu: <select id="date_choose" class="input-transparent" name="date_range">
         <option value="1" <?php if ($date_range == 1) echo 'selected'; ?>>Tháng này</option>
         <option value="2" <?php if ($date_range == 2) echo 'selected'; ?>>Tháng trước</option>
         <option value="3" <?php if ($date_range == 3) echo 'selected'; ?>>Năm nay</option>
         <option value="0" <?php if ($date_range == 0) echo 'selected'; ?>>Tùy chỉnh</option>
      </select> từ <i><?php echo $min_date; ?></i> đến <i><?php echo $max_date; ?></i></i><?php
         if ($this->input->get('from')) {
            echo '<i id="refresh-btn" class="fa fa-fw" aria-hidden="true" title="Refresh"></i>';
         }
       ?></h4>
      <input type="hidden" id="dashboard_url" value="<?php echo base_url('bao-cao-tong-hop.html'); ?>">
   </div>
</div>

<div class="row">
    <div class="col-md-6" id="revenue_pie" style="background-color: #fff;">
      <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      var h = $('#revenue_pie').width();

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Chiều', 'Chi phí'],
          <?php foreach ($revenue_detail as $dimen => $amount): ?>
             ['<?php echo $dimen; ?>',<?php if ($amount == '') echo "0"; else echo $amount; ?>],
          <?php endforeach; ?>
        ]);

        var options = {
          title: 'Nguồn doanh thu',
          is3D: true,
          width: h,
          height: 0.6*h
        };

        var chart = new google.visualization.PieChart(document.getElementById('revenue_pie'));

        chart.draw(data, options);
      }
    </script>
    </div>
    <div class="col-md-6 info-next-pie" style="background-color: #fff; display: flex; align-items: center;">
      <h2>Tổng doanh thu: <?php echo number_format($revenue, 0, ",", ".") . ' đ'; ?></h2>
    </div>
    <div class="clearfix"></div>
</div>

<div class="row">
    <div class="col-md-6" id="distribution_layer_1" style="background-color: #fff;">
      <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Chiều', 'Chi phí'],
          <?php foreach ($revenue_in_1 as $dimen): ?>
             ['<?php echo $dimen['name']; ?>',<?php echo $dimen['revenue']; ?>],
          <?php endforeach; ?>
        ]);

        var options = {
          title: 'Tỉ lệ phân bổ tiền',
          is3D: true,
          width: h,
          height: 0.6*h
        };

        var chart = new google.visualization.PieChart(document.getElementById('distribution_layer_1'));

        chart.draw(data, options);
      }
    </script>
    </div>
    <div class="col-md-6 info-next-pie" style="background-color: #fff; display: flex; align-items: center;">
      <h2>Tổng chi phí: <?php echo number_format($cost, 0, ",", ".") . ' đ'; ?></h2>
    </div>
    <div class="clearfix"></div>
</div>

<div class="row">
    <div class="col-md-6" id="records-report" style="background-color: #fff;">
      <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Hành động', 'Số lượng'],
          ['Đã duyệt', <?php echo $approved; ?>],
          ['Đã xóa', <?php echo $deleted; ?>],
          ['Chờ duyệt', <?php echo $new_records - $deleted - $approved; ?>]
        ]);

        var options = {
          title: 'Phát sinh chứng từ mới',
          is3D: true,
          width: h,
          height: 0.6*h
        };

        var chart = new google.visualization.PieChart(document.getElementById('records-report'));

        chart.draw(data, options);
      }
    </script>
    </div>
    <div class="col-md-6 info-next-pie" style="background-color: #fff; display: flex; align-items: center;">
      <h2>Tổng số chứng từ mới: <?php echo number_format($new_records, 0, ",", "."); ?></h2>
      <h2>, Chờ duyệt: <?php echo number_format($new_records - $deleted - $approved, 0, ",", "."); ?></h2>
    </div>
    <div class="clearfix"></div>
</div>

<script type="text/javascript">
  // $($($('.info-next-pie').parent()[0]).children()[1]).height(0.6*h);

  $('.info-next-pie').parent().each(function(i, item){
    $($(item).children()[1]).height(0.6*h);
  })
</script>
