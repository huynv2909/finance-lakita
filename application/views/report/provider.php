<div class="row">
  <form class="form-horizontal" method="post" id="type-form">
     <div class="col-xs-12 col-md-6">
       <div class="col-xs-6 padding-0">
         <div class="form-group">
            <label for="code" class="col-md-3 control-label padding-lr-10-5">Từ:</label>
            <div class="col-md-9 padding-lr-10-5">
               <input type="date" name="from" id="code" class="form-control" value="<?php echo $from_chosen; ?>">
            </div>
          </div>
       </div>
       <div class="col-xs-6 padding-0">
         <div class="form-group">
            <label for="code" class="col-md-3 control-label padding-lr-10-5">Đến:</label>
            <div class="col-md-9 padding-lr-10-5">
               <input type="date" name="to" id="code" class="form-control" value="<?php echo $to_chosen; ?>">
            </div>
          </div>
       </div>
       <div class="clearfix"></div>
     </div>
     <div class="col-xs-6 col-md-3 padding-0">
        <div class="form-group">
           <label for="name" class="col-md-5 control-label">Phương thức</label>
           <div class="col-md-7 padding-lr-10-5">
             <select class="form-control" name="method">
               <?php foreach ($methods as $method): ?>
                 <option value="<?php echo $method->id; ?>" <?php if ($method_chosen == $method->id) echo "selected"; ?>><?php echo $method->name; ?></option>
               <?php endforeach; ?>
             </select>
           </div>
        </div>
     </div>
     <div class="col-xs-6 col-md-3">
        <div class="form-group">
           <input type="submit" name="Ok" class="form-control btn btn-success height-34" id="add-new-type-btn" value="Chọn">
        </div>
     </div>
     <div class="clearfix"></div>
  </form>
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
          title: 'Lượng thu',
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
          title: 'Lượng chi',
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
          ['Genre',<?php foreach ($providers as $provider): ?>
            '<?php echo $provider->name; ?>',
          <?php endforeach; ?>{ role: 'annotation' }],
          <?php foreach ($amount_array as $point): ?>
            ['<?php echo $point['month'] . "/" . $point['year']; ?>',
              <?php foreach ($providers as $provider): ?>
                <?php echo valueInPointTime($provider->name, $point['amount']); ?>,
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
