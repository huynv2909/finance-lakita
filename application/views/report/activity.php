<!-- Filter -->
<form method="get" class="report-filter">
   <div class="row">
      <div class="col-sm-4 col-lg-2">
        <div class="form-group">
          <label for="from">Từ:</label>
          <input type="date" class="form-control" name="from" value="<?php echo $from; ?>">
        </div>
        <div class="form-group">
          <label for="to">Đến:</label>
          <input type="date" class="form-control" name="to" value="<?php echo $to; ?>">
        </div>
      </div>
      <div class="col-sm-4 col-lg-2">
         <div class="form-group">
           <label for="by">Theo:</label>
           <select class="form-control" name="by">
              <option value="1">Năm</option>
              <option value="2" selected>Tháng</option>
              <option value="3">Ngày</option>
           </select>
         </div>
      </div>
   </div>
   <div class="row">
      <button type="submit" class="btn btn-primary centering"><i class="fa fa-fw" aria-hidden="true" title="Lọc"></i> Lọc</button>
      <a href="<?php echo $this->routes['report_financeactivity'] ?>" class="text-center" style="display: inherit; margin-top: 10px;"> Mặc định</a>
   </div>
</form>

<div class="row">
   <h5 class="pull-left">Thống kê từ: <strong><?php echo $from; ?></strong> đến <strong><?php echo $to; ?></strong> </h5>
   <i class="fa fa-fw fa-2x pull-right slide-form" data-hidden="1" aria-hidden="true" title="Lọc nâng cao"></i>
</div>

<div class="col-lg-3 padding-0 custom-table">
   <table border="1" class="catalog-table">
      <thead>
         <tr height="63">
            <?php for ($i=1; $i <= $number_layer; $i++) { ?>
               <th rowspan="2" class="padding-left-10">Tầng <?php echo $i; ?></th>
            <?php } ?>
         </tr>
      </thead>
      <tbody>
         <?php foreach ($data_compilation as $row): ?>
            <tr height="52">
               <?php if ($row['layer'] == 1): ?>
                  <td colspan="<?php echo $number_layer; ?>" class="padding-left-10"><?php echo $row['name']; ?></td>
               <?php else: ?>
                  <td colspan="<?php echo ($row['layer'] - 1); ?>" class="padding-left-10">&nbsp;</td>
                  <td colspan="<?php echo ($number_layer - $row['layer'] + 1); ?>" class="padding-left-10"><?php echo $row['name']; ?></td>
               <?php endif; ?>
            </tr>
         <?php endforeach; ?>
      </tbody>
   </table>
</div>

<div class="col-lg-7 padding-0">
   <table border="1" class="report" data-fl-scrolls>
   <thead>
      <tr height="30">
         <?php for ($i=1; $i <= $number_layer; $i++) { ?>
            <th rowspan="2" class="custom-td">Tầng <?php echo $i; ?></th>
         <?php } ?>

         <?php foreach ($date_range as $date => $date_info): ?>
            <th colspan="2" class="data-column"><?php echo $date; ?></th>
         <?php endforeach; ?>

         <th colspan="2" class="data-column custom-td text-center">Tổng các chiều</th>
      </tr>
      <tr height="30">
         <?php foreach ($date_range as $date => $date_info): ?>
            <th>TOT</th>
            <th>TOA</th>
         <?php endforeach; ?>

         <th class="custom-td">TOT</th>
         <th class="custom-td">TOA</th>
      </tr>
   </thead>
   <tbody>
      <?php foreach ($data_compilation as $row): ?>
         <tr height="52">
            <?php if ($row['layer'] == 1): ?>
               <td colspan="<?php echo $number_layer; ?>" class="custom-td"><?php echo $row['name']; ?></td>
            <?php else: ?>
               <td colspan="<?php echo ($row['layer'] - 1); ?>" class="custom-td">&nbsp;</td>
               <td colspan="<?php echo ($number_layer - $row['layer'] + 1); ?>" class="custom-td"><?php echo $row['name']; ?></td>
            <?php endif; ?>

            <?php foreach ($row['data'] as $value): ?>
               <td class="data text-center"><?php if ($value['tot_value']) echo number_format($value['tot_value'], 0, ",", "."); else echo "-"; ?></td>
               <td class="data text-center"><?php if ($value['toa_value']) echo number_format($value['toa_value'], 0, ",", "."); else echo "-"; ?></td>
            <?php endforeach; ?>

            <td class="data-compile text-center custom-td"><?php echo number_format($row['total_tot'], 0, ",", "."); ?></td>
            <td class="data-compile text-center custom-td"><?php echo number_format($row['total_toa'], 0, ",", "."); ?></td>
         </tr>
      <?php endforeach; ?>
   </tbody>
</table>
</div>

<div class="col-lg-2 padding-0 custom-table">
   <table border="1">
      <thead>
         <tr height="31">
            <th colspan="2" class="data-column text-center">Tổng các chiều</th>
         </tr>
         <tr height="32">
            <th class="text-center">TOT</th>
            <th class="text-center">TOA</th>
         </tr>
      </thead>
      <tbody>
         <?php foreach ($data_compilation as $row): ?>
            <tr height="52">
               <td class="data-compile text-center"><?php echo number_format($row['total_tot'], 0, ",", "."); ?></td>
               <td class="data-compile text-center"><?php echo number_format($row['total_toa'], 0, ",", "."); ?></td>
            </tr>
         <?php endforeach; ?>
      </tbody>
   </table>
</div>
<div class="clearfix"></div>

<input type="hidden" id="height-table" value="">
