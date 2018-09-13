<h3 class="text-center"><?php echo number_format($entry_info->value, 0, ",", ".") . " đ" ?> : <?php echo $entry_info->content; ?></h3>
<hr>
<?php if (isset($group_dis) && $group_dis): ?>
      <?php foreach ($group_dis as $key => $dimension): ?>
         <div id="<?php echo $key; ?>"></div>
         <script type="text/javascript">
            google.charts.load('current', {packages: ['corechart', 'bar']});
            google.charts.setOnLoadCallback(drawAnnotations);

            function drawAnnotations() {
               var data = google.visualization.arrayToDataTable([
                 ['Dimension',
                  <?php foreach ($dimension as $detail): ?>
                     '<?php echo $detail['detail']; ?>',
                  <?php endforeach; ?>
                  ],
                 ['<?php echo $key; ?>',
                 <?php foreach ($dimension as $detail): ?>
                    <?php echo $detail['value']; ?>,
                 <?php endforeach; ?>
                  ],
               ]);

               var options = {
                  height: 100,
                 bar: { groupWidth: '80%' },
                 isStacked: true
               };
               var chart = new google.visualization.BarChart(document.getElementById('<?php echo $key; ?>'));
               chart.draw(data, options);
            }
         </script>
      <?php endforeach; ?>


      <h5 class="text-center"><a href="<?php echo $this->routes['distribution_create'] . '?act_id=' . $entry_info->id; ?>">Phân bổ thêm<i class="fa fa-fw" aria-hidden="true" title="Phân bổ thêm"></i></a></h5>

   <?php else: ?>
      <h4 class="text-center"><span class="alert-warning">(Chưa phân bổ)</span></h4>
      <h5 class="text-center"><a href="<?php echo $this->routes['distribution_create'] . '?act_id=' . $entry_info->id; ?>">Phân bổ ngay<i class="fa fa-fw" aria-hidden="true" title="Phân bổ ngay"></i></a></h5>
   <?php endif; ?>
