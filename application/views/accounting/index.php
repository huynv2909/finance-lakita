<div class="row log-box">
	<div class="col-sm-12">
		<table class="table table-hover dataTable no-footer log-table" id="accounting_table" role="grid" aria-describedby="accounting_table_info" border="1">
			<thead>
					<tr role="row">
						<th class="sorting" tabindex="0" aria-controls="voucher_table" rowspan="1" colspan="1" aria-label="Reiceipt: activate to sort column ascending">Chứng từ gốc</th>
                  <th class="sorting" tabindex="0" aria-controls="voucher_table" rowspan="1" colspan="1" aria-label="Time on action: activate to sort column ascending">TOA</th>
						<th class="sorting" tabindex="0" aria-controls="voucher_table" rowspan="1" colspan="1" aria-label="Value: activate to sort column ascending">Số tiền</th>
						<th class="sorting" tabindex="0" aria-controls="voucher_table" rowspan="1" colspan="1" aria-label="Content: activate to sort column ascending">Nội dung</th>
						<?php if (in_array('accountingentry_delete', explode(',', $this->role->permission_list))): ?>
							<th class="sorting" tabindex="0" aria-controls="voucher_table" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Thao tác</th>
						<?php endif; ?>
					</tr>
			</thead>
			<tbody>
				<?php foreach ($entries as $item): ?>
					<tr role="row" id="row-<?php echo $item->id; ?>" data-url="<?php echo $this->routes['voucher_viewmore']; ?>" data-id="<?php echo $item->id; ?>">
						 <td class="text-center"><span class="voucher-id" data-url="<?php echo $this->routes['voucher_viewmore']; ?>" data-id="<?php echo $item->voucher_id; ?>"><?php echo $item->code; ?></span></td>
                   <td><?php echo $item->TOA; ?></td>
						 <td>
							 <?php
						 		echo number_format($item->value, 0, ",", ".") . " đ";
							?>
							<!-- <?php if (!$item->completed): ?>
								<a href="<?php echo $this->routes['accountingentry_create'] . '?voucher_id=' . $item->id; ?>" title="Đến nhập bút toán"><i class="fa fa-fw warning" aria-hidden="true" title="Đến nhập bút toán"></i></a>
							<?php endif; ?> -->
						 </td>
						 <td><?php echo $item->content; ?></td>
						 <?php if (in_array('accountingentry_delete', explode(',', $this->role->permission_list))): ?>
							 <td class="text-center">
							 	 <button type="button" class="btn btn-circle edit-btn" data-url="<?php echo $this->routes['accountingentry_edit']; ?>" data-id="<?php echo $item->id; ?>"><i class="fa fa-fw" aria-hidden="true" title="Chỉnh sửa"></i></button>
								 <button type="button" class="btn btn-circle del-btn" data-url="<?php echo $this->routes['accountingentry_delete']; ?>" data-id="<?php echo $item->id; ?>"><i class="fa fa-times"></i></button>
							 </td>
					    <?php endif; ?>
					</tr>
				<?php endforeach; ?>
			  </tbody>
		</table>
		<script type="text/javascript">
			$('#accounting_table').DataTable({
					  responsive: true
			});
		</script>
	</div>
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
