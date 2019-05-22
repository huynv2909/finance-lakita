<!-- <div class="row">
   <div class="col-xs-12">
      <h4>Số liệu: <select id="date_choose" class="input-transparent" name="date_range">
         <option value="4" <?php if ($date_range == 4) echo 'selected'; ?>>Hôm nay</option>
         <option value="1" <?php if ($date_range == 1) echo 'selected'; ?>>Tháng này</option>
         <option value="0" <?php if ($date_range == 0) echo 'selected'; ?>>Tùy chỉnh</option>
      </select> từ <i><?php echo $min_date; ?></i> đến <i><?php echo $max_date; ?></i></i><?php
         if ($this->input->get('from')) {
            echo '<i id="refresh-btn" class="fa fa-fw" aria-hidden="true" title="Refresh"></i>';
         }
       ?></h4>
      <input type="hidden" id="dashboard_url" value="<?php echo base_url('dashboard.html'); ?>">
   </div>
</div> -->

<div class="row">
   <div class="col-md-4">
      <div class="panel panel-green">
          <div class="panel-heading">
              Số chứng từ được thêm tự động mới
          </div>
          <div class="panel-body">
             <?php if ($unapproved > 0): ?>
                <p>Hệ thống còn <span style="font-weight: bold;"><?php echo $unapproved; ?></span> chứng từ cần xét duyệt.</p>
             <?php else: ?>
                <p>Các chứng từ đã được duyệt hết!</p>
             <?php endif; ?>

          </div>
          <div class="panel-footer">
             <a href="<?php echo $this->routes['voucher_approve']; ?>">Đi đến duyệt<i class="fa fa-fw" aria-hidden="true" title="Đi đến duyệt"></i></a>
          </div>
      </div>
      <!-- /.col-lg-4 -->
  </div>
</div>
