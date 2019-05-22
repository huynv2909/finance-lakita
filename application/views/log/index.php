<div class="row">
   <table class="table table-hover dataTable no-footer log-table" id="log_table" role="grid" aria-describedby="log_table_info" border="1">
      <thead>
            <tr role="row">
               <th class="sorting" tabindex="0" aria-controls="voucher_table" rowspan="1" colspan="1" aria-label="Time: activate to sort column ascending">Thời gian</th>
               <th class="sorting" tabindex="0" aria-controls="voucher_table" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Hành động</th>
               <th class="sorting" tabindex="0" aria-controls="voucher_table" rowspan="1" colspan="1" aria-label="Info: activate to sort column ascending">Thông tin</th>
               <th class="sorting" tabindex="0" aria-controls="voucher_table" rowspan="1" colspan="1" aria-label="User: activate to sort column ascending">Thực hiện</th>
            </tr>
      </thead>
      <tbody>
         <?php if (isset($logs) && $logs): ?>
         <?php foreach ($logs as $item): ?>
            <tr role="row" id="row-<?php echo $item->id; ?>" data-url="<?php echo $this->routes['log_viewmore']; ?>" data-id="<?php echo $item->row_id; ?>" data-model="<?php echo $item->entity; ?>" class="log-row">
                <td class="text-center"><?php echo $item->time; ?></td>
                <td><?php echo $item->description; ?></td>
                <td><?php echo $item->info; ?></td>
                <td class="text-center">
                   <?php
                     foreach ($users as $user) {
                        if ($item->user_id == $user->id) {
                           echo $user->name;
                           break;
                        }
                     }
                    ?>
                </td>
            </tr>
         <?php endforeach; ?>
         <?php endif; ?>
      </tbody>
   </table>

   <div class="alert-warning">
   	<strong>Lưu ý: </strong>Để tăng tốc độ tải trang, bảng trên giới hạn <?php echo $limit_loading; ?> bản ghi gần nhất, bạn có thể <a href="<?php echo $this->routes['config_index']; ?>">điều chỉnh</a>!
   </div>

   <script type="text/javascript">
      $('#log_table').DataTable({
              responsive: true,
              "columns" : [
                { "width" : "15%" },
                { "width" : "20%" },
                { "width" : "55%" },
                { "width" : "10%" }
             ],
              "order" : [[0, 'desc']]
      });
   </script>
</div>

<div class="modal fade" id="view-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
		 <div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  <h4 class="modal-title">Chi tiết</h4>
	   </div>
	   <div class="modal-body data-insert">
		  <!-- insert by ajax -->
	   </div>
	   <div class="modal-footer">
		  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	   </div>

    </div>
  </div>
</div>
