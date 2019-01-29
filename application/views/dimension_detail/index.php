<div class="row">
   <form class="form-horizontal">
      <label for="dimension-choose" class="col-xs-3 col-lg-2 control-label text-right">Chi tiết chiều:</label>
      <div class="col-xs-9 col-lg-8">
         <select class="form-control" id="dimension-choose" data-url="<?php echo $this->routes['dimension_getdetail']; ?>">
              <option value="0" class="hidden">(Chọn chiều)</option>
              <?php foreach ($dimensions as $item): ?>
                <option value="<?php echo $item->id; ?>" <?php if ($item->id == set_value('parent_id')) echo 'selected'; ?> ><?php echo $item->code . " : " . $item->name; ?></option>
              <?php endforeach ?>
        </select>
      </div>
   </form>
</div>

<h5><strong>Gồm có:</strong></h5>
<div class="row log-box">
   <div class="col-sm-12">
		<table class="table table-hover dataTable no-footer log-table" id="detail_dimen_table" role="grid" aria-describedby="detail_dimen_table_info" border="1">
			<thead>
					<tr role="row">
						<th class="sorting text-center" tabindex="0" aria-controls="detail_dimen_table" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" >Tên gọi</th>
						<th class="sorting text-center" tabindex="0" aria-controls="detail_dimen_table" rowspan="1" colspan="1" aria-label="Note: activate to sort column ascending" >Ghi chú:</th>
						<th class="sorting text-center" tabindex="0" aria-controls="detail_dimen_table" rowspan="1" colspan="1" aria-label="Parent detail: activate to sort column ascending" >Chi tiết cha:</th>
						<th class="sorting text-center" tabindex="0" aria-controls="detail_dimen_table" rowspan="1" colspan="1" aria-label="Layer: activate to sort column ascending" >Tầng:</th>
						<th class="sorting text-center" tabindex="0" aria-controls="detail_dimen_table" rowspan="1" colspan="1" aria-label="Sequence: activate to sort column ascending" >Thứ tự:</th>
						<th class="sorting text-center" tabindex="0" aria-controls="detail_dimen_table" rowspan="1" colspan="1" aria-label="Option: activate to sort column ascending" >Thao tác</th>
					</tr>
			</thead>
			<tbody>
            <tr>
               <td colspan="7"><h5 class="empty-info">(Hãy lựa chọn chiều)</h5></td>
               <td style="display:none;"></td>
               <td style="display:none;"></td>
               <td style="display:none;"></td>
               <td style="display:none;"></td>
               <td style="display:none;"></td>
            </tr>
			  </tbody>
		</table>
		<script type="text/javascript">
			$('#detail_dimen_table').DataTable({
					  responsive: true,
                 "order" : [[4, 'desc']],
                 "columns" : [
                    { "width" : "21%" },
                    { "width" : "30%" },
                    { "width" : "15%" },
                    { "width" : "17%" },
                    { "width" : "7%" },
                    { "width" : "10%" }
                 ],
                 "order" : [[4, 'asc'], [5, 'desc']]
			});

         // Fix 2 column
         // new $.fn.dataTable.FixedColumns(table ,{
         //      leftColumns: 2
         //  });
		</script>
	</div>
</div>

<input type="hidden" id="dimen_id" value="">
<input type="hidden" id="dimen_code" value="">
<input type="hidden" id="dimen_layer" value="">

<input type="hidden" id="list_parent" value="">

<input type="hidden" value="<?php echo $this->routes['dimensiondetail_create']; ?>" id="url-add">

<button type="button" class="btn btn-primary" id="detail-add-btn" title="Chi tiết mới" data-url="" disabled>
  <i class="fa fa-fw" aria-hidden="true" title="Thêm chi tiết mới"></i> Thêm mới
</button>
