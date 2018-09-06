<div class="row">
   <form class="form-horizontal" method="post" id="type-form">
      <div class="col-xs-4 col-md-3">
         <div class="form-group">
            <label for="code" class="col-md-4 control-label padding-lr-10-5">Đầu mã</label>
            <div class="col-xs-10 col-md-7 padding-lr-10-5">
               <input type="text" name="code" id="code" class="form-control" data-ok="0" data-other_ok="0" value="" placeholder="Mã loại chứng từ">
            </div>
            <div class="col-xs-2 col-md-1 padding-0 centering-parent height-34">
               <i class="fa fa-fw fa-2x fa-spin checking hidden" aria-hidden="true" title="loading..."></i>
               <i class="fa fa-fw fa-2x success hidden" aria-hidden="true" title="Ok!"></i>
               <i class="fa fa-fw fa-2x danger hidden" aria-hidden="true" title="Invalid!"></i>
            </div>
         </div>
      </div>
      <div class="col-xs-8 col-md-5 col-lg-6">
         <div class="form-group">
            <label for="name" class="col-md-2 col-lg-1 control-label">Tên</label>
            <div class="col-md-10 col-lg-11">
               <textarea name="name" rows="1" class="form-control" id="name" placeholder="Tên chứng từ"></textarea>
            </div>
         </div>
      </div>
      <div class="col-xs-4 col-xs-6 col-md-2 col-lg-2">
         <div class="form-group">
            <div class="col-xs-12">
               <select class="form-control" name="income">
                  <option value="0">Phiếu chi</option>
                  <option value="1">Phiếu thu</option>
               </select>
            </div>
         </div>
      </div>
      <div class="col-xs-3 col-xs-push-3 col-xs-6 col-md-2 col-md-push-0 col-lg-1">
         <div class="form-group">
            <input type="submit" name="Ok" class="form-control btn btn-success height-34" id="add-new-type-btn" value="Thêm" disabled>
         </div>
      </div>
      <div class="clearfix"></div>
   </form>
</div>
<input type="hidden" id="list_code" value="<?php
   if (isset($list_types) && $list_types) {
      $str = '';
      foreach ($list_types as $type) {
         $str .= $type->code . ",";
      }
      echo $str;
   }
 ?>">
 <h5></h5>
<div class="row log-box">
   <div class="col-sm-12">
		<table class="table table-hover dataTable no-footer log-table" id="voucher_types_table" role="grid" aria-describedby="voucher_types_table_info" border="1">
			<thead>
					<tr role="row">
						<th class="sorting text-center" tabindex="0" aria-controls="voucher_types_table" rowspan="1" colspan="1" aria-label="Code: activate to sort column ascending" >Đầu mã</th>
						<th class="sorting text-center" tabindex="0" aria-controls="voucher_types_table" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" >Tên gọi</th>
						<th class="sorting text-center" tabindex="0" aria-controls="voucher_types_table" rowspan="1" colspan="1" aria-label="Type: activate to sort column ascending" >Loại</th>
						<th class="sorting text-center" tabindex="0" aria-controls="voucher_types_table" rowspan="1" colspan="1" aria-label="Option: activate to sort column ascending" >Thao tác</th>
					</tr>
			</thead>
			<tbody>
            <?php if (isset($list_types) && $list_types): ?>
   				<?php foreach ($list_types as $item): ?>
   					<tr role="row" id="type-<?php echo $item->id; ?>" data-url="<?php echo $this->routes['voucher_viewmore']; ?>" data-id="<?php echo $item->id; ?>" class="type-row">
   						 <td><?php echo $item->code; ?></td>
   						 <td><?php echo $item->name; ?></td>
   						 <td class="text-center">
   							 <?php
   								if ($item->income == 1) {
                              echo "Phiếu thu";
                           } else {
                              echo "Phiếu chi";
                           }
   							  ?>
   						 </td>
   						 <td class="text-center">
                        <?php if ($item->active == 1): ?>
                           <i class="fa fa-fw fa-2x vertical-middle active-color exchange-btn" data-url="<?php echo $this->routes['vouchertype_changestatus']; ?>" data-id="<?php echo $item->id; ?>" data-active="<?php echo $item->active; ?>" aria-hidden="true" title="Click to change!"></i>
                        <?php else: ?>
                           <i class="fa fa-fw fa-2x vertical-middle exchange-btn" data-url="<?php echo $this->routes['vouchertype_changestatus']; ?>" data-id="<?php echo $item->id; ?>" data-active="<?php echo $item->active; ?>" aria-hidden="true" title="Click to change!"></i>
                        <?php endif; ?>

                         <button type="button" class="btn btn-circle del-btn" data-url="<?php echo $this->routes['vouchertype_delete']; ?>" data-id="<?php echo $item->id; ?>"><i class="fa fa-times"></i></button>
                      </td>
   					</tr>
   				<?php endforeach; ?>
            <?php endif; ?>
			  </tbody>
		</table>
		<script type="text/javascript">
			$('#voucher_types_table').DataTable({
					  responsive: true,
                 "order" : [[3, 'desc']],
                 "columns" : [
                    { "width" : "20%" },
                    { "width" : "45%" },
                    { "width" : "20%" },
                    { "width" : "15%" }
                 ]
			});

         // Fix 2 column
         // new $.fn.dataTable.FixedColumns(table ,{
         //      leftColumns: 2
         //  });
		</script>
	</div>
</div>
