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
      <input type="hidden" id="report_url" value="<?php echo base_url('bao-cao-phuong-thuc-thanh-toan.html'); ?>">
   </div>
</div>
<div class="row">
  <div class="col-md-6" id="total_amount" style="background-color: #fff;">
    <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    var h = $('#total_amount').width();

    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Phương thức', 'Số lượng'],
        <?php foreach ($total_amount as $method): ?>
           ['<?php echo $method->name; ?>',<?php echo $method->amount; ?>],
        <?php endforeach; ?>
      ]);

      var options = {
        title: 'Tổng số lượng',
        is3D: true,
        width: h,
        height: 0.6*h
      };

      var chart = new google.visualization.PieChart(document.getElementById('total_amount'));

      chart.draw(data, options);
    }
  </script>
  </div>

  <div class="col-md-6">
    <div id="income_amount" style="background-color: #fff;">
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Phương thức', 'Số lượng'],
          <?php foreach ($income_amount as $method): ?>
             ['<?php echo $method->name; ?>',<?php echo $method->amount; ?>],
          <?php endforeach; ?>
        ]);

        var options = {
          title: 'Phiếu thu',
          is3D: true,
          height: 0.6*h/2
        };

        var chart = new google.visualization.PieChart(document.getElementById('income_amount'));

        chart.draw(data, options);
      }
    </script>
  </div>

  <div id="expenses_amount" style="background-color: #fff;">
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Phương thức', 'Số lượng'],
          <?php foreach ($expenses_amount as $method): ?>
             ['<?php echo $method->name; ?>',<?php echo $method->amount; ?>],
          <?php endforeach; ?>
        ]);

        var options = {
          title: 'Phiếu chi',
          is3D: true,
          height: 0.6*h/2
        };

        var chart = new google.visualization.PieChart(document.getElementById('expenses_amount'));

        chart.draw(data, options);
      }
    </script>
  </div>

  </div>
</div>
<div class="row" style="margin-top: 15px;">
  <div class="col-md-6" id="total_value" style="background-color: #fff;">
    <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Phương thức', 'Lượng tiền'],
        <?php foreach ($total_value as $method): ?>
           ['<?php echo $method->name; ?>',<?php echo $method->val; ?>],
        <?php endforeach; ?>
      ]);

      var options = {
        title: 'Tổng lượng tiền',
        is3D: true,
        width: h,
        height: 0.6*h
      };

      var chart = new google.visualization.PieChart(document.getElementById('total_value'));

      chart.draw(data, options);
    }
  </script>
  </div>

  <div class="col-md-6">
    <div id="income_value" style="background-color: #fff;">
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Phương thức', 'Tổng lượng tiền'],
          <?php foreach ($income_value as $method): ?>
             ['<?php echo $method->name; ?>',<?php echo $method->val; ?>],
          <?php endforeach; ?>
        ]);

        var options = {
          title: 'Phiếu thu',
          is3D: true,
          height: 0.6*h/2
        };

        var chart = new google.visualization.PieChart(document.getElementById('income_value'));

        chart.draw(data, options);
      }
    </script>
  </div>

  <div id="expenses_value" style="background-color: #fff;">
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Phương thức', 'Tổng lượng tiền'],
          <?php foreach ($expenses_value as $method): ?>
             ['<?php echo $method->name; ?>',<?php echo $method->val; ?>],
          <?php endforeach; ?>
        ]);

        var options = {
          title: 'Phiếu chi',
          is3D: true,
          height: 0.6*h/2
        };

        var chart = new google.visualization.PieChart(document.getElementById('expenses_value'));

        chart.draw(data, options);
      }
    </script>
  </div>

  </div>
</div>

<div class="row" style="margin-top: 15px;">
  <div id="amount_vouchers"></div>
  <script type="text/javascript">
      google.charts.load("current", {packages:['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Genre',<?php foreach ($methods as $method): ?>
            '<?php echo $method->name; ?>',
          <?php endforeach; ?>{ role: 'annotation' }],
          <?php foreach ($amount_array as $point): ?>
            ['<?php echo $point['month'] . "/" . $point['year']; ?>',
              <?php foreach ($methods as $method): ?>
                <?php echo valueInPointTime($method->name, $point['amount']); ?>,
              <?php endforeach; ?>
            ''],
          <?php endforeach; ?>
         ]);

        var options = {
           height: 500,
           legend: { position: 'top', maxLines: 3 },
           bar: { groupWidth: '75%' },
           isStacked: true
        };
        var chart = new google.visualization.ColumnChart(document.getElementById("amount_vouchers"));
        chart.draw(data, options);
      }
    </script>
</div>
