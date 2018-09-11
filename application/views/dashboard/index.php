<div class="row">
   <div class="col-xs-12">
      <h4>Số liệu: <select id="date_choose" class="input-transparent" name="date_range">
         <option value="1" <?php if ($date_range == 1) echo 'selected'; ?>>Tháng này</option>
         <option value="2" <?php if ($date_range == 2) echo 'selected'; ?>>Tháng trước</option>
         <option value="3" <?php if ($date_range == 3) echo 'selected'; ?>>Năm nay</option>
         <option value="0" <?php if ($date_range == 0) echo 'selected'; ?>>Tùy chỉnh</option>
      </select> từ <i><?php echo $min_date; ?></i> đến <i><?php echo $max_date; ?></i></i></h4>
      <input type="hidden" id="dashboard_url" value="<?php echo base_url('dashboard.html'); ?>">
   </div>
</div>
<!-- /.row -->
<div class="row">
   <div class="col-lg-3">
      <div class="panel panel-primary">
          <div class="panel-heading">
             <div id="revenue_gauge" style="width: 100%; height: 100%;"></div>
             <script type="text/javascript">
                google.charts.load('current', {'packages':['gauge']});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {

                    var data = google.visualization.arrayToDataTable([
                     ['Label', 'Value'],
                     ['Revenue', <?php echo round($revenue/$kpi*100); ?>]
                    ]);

                    var options = {
                       height: 200,
                      redFrom: 0, redTo: 50,
                     yellowFrom:50, yellowTo: 80,
                     greenFrom:80, greenTo: 100,
                     minorTicks: 5
                    };

                    var chart = new google.visualization.Gauge(document.getElementById('revenue_gauge'));

                    chart.draw(data, options);
                }
             </script>
          </div>
          <a href="#">
             <div class="panel-footer">
                  <span class="pull-left">Doanh thu: <?php echo round($revenue/1000000, 2); ?>M / <?php echo round($kpi/1000000, 2); ?>M</span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                  <div class="clearfix"></div>
             </div>
          </a>
      </div>

      <div id="distribution_layer_1" style="width: 100%; height: 100%;"></div>
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
          height: 270
        };

        var chart = new google.visualization.PieChart(document.getElementById('distribution_layer_1'));

        chart.draw(data, options);
      }
    </script>
   </div>
   <div class="col-lg-9">
      <div class="row">
         <div class="col-lg-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-fw fa-5x" aria-hidden="true" title="Lợi nhuận"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo number_format($profit, 0, ",", ".") . ' đ'; ?></div>
                            <div>Profit!</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">Lợi nhuận</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
         </div>
         <div class="col-lg-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                   <div class="row">
                       <div class="col-xs-3">
                           <i class="fa fa-file-text-o fa-fw fa-5x" title="Chứng từ mới"></i>
                       </div>
                       <div class="col-xs-9 text-right">
                           <div class="huge"><?php echo $new_records; ?></div>
                           <div>New Records!</div>
                       </div>
                   </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">Số chứng từ mới</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
         </div>
         <div class="col-lg-12">
            <div id="revenue_trend"></div>
            <script type="text/javascript">
                google.charts.load("current", {packages:['corechart']});
                google.charts.setOnLoadCallback(drawChart);
                function drawChart() {
                   var data = new google.visualization.DataTable();
                   data.addColumn('date', 'Timeline');
                   data.addColumn('number', 'Revenue');

                   data.addRows([
                      <?php foreach ($revenue_by_month as $point): ?>
                         [new Date(<?php echo $point['year'] ?>, <?php echo $point['month'] - 1 ?>), <?php echo $point['revenue'] ?>],
                      <?php endforeach; ?>
                  ]);

                  var options = {
                     height: 400,
                    title: 'Doanh thu và xu hướng',
                    chartArea: {width: '70%'},
                    hAxis: {
                      title: 'Dòng thời gian'
                    },
                    vAxis: {
                      title: 'Doanh thu',
                      format: 'short'
                   },
                   trendlines: {
                      0: {
                        type: 'linear',
                        color: '#fc7400',
                        lineWidth: 2,
                        opacity: 1,
                        showR2: true
                      }
                   },
                   colors : ['#21aeb2']
                  };
                  var chart = new google.visualization.ColumnChart(document.getElementById("revenue_trend"));
                  chart.draw(data, options);
                }
              </script>
         </div>

         <div class="col-lg-12">
            <div id="product_ratio_tree" style="width: 100%; height: 100%;"></div>
            <script type="text/javascript">
               google.charts.load('current', {'packages':['treemap']});
               google.charts.setOnLoadCallback(drawChart);
               function drawChart() {
                 var data = google.visualization.arrayToDataTable([
                   ['Sản Phẩm', 'Nhóm', 'Doanh thu'],
                   ['Product',    null,                 0],
                   <?php foreach ($trees as $key => $value): ?>
                      ['<?php echo $key; ?>','<?php echo $value['parent_name']; ?>',<?php echo $value['value']; ?>],
                   <?php endforeach; ?>
                 ]);

                 tree = new google.visualization.TreeMap(document.getElementById('product_ratio_tree'));

                 tree.draw(data, {
                   minColor: '#e60000',
                   midColor: '#ed8910',
                   maxColor: '#09e5d3',
                   headerHeight: 20,
                   fontColor: 'white',
                   showScale: true,
                   generateTooltip: showStaticTooltip
                 });

                 function showStaticTooltip(row, size, value) {
                   return '<div style="background:#fd9; padding:10px; border-style:solid">' +
                          convertToCurrency(size.toString()) + ' VND</div>';
                 }

               }
             </script>
         </div>

      </div>
   </div>
</div>
<!-- /.row -->
