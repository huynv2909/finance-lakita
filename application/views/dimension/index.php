<form class="form-horizontal" method="post" id="dimension-form" action="<?php echo base_url('Dimension/create'); ?>">
	<div class="row">
		<div class="col-md-6">
         <div class="form-group">
				 <label for="dimension_code" class="col-xs-3 control-label text-right"><span class="text-danger">(*)</span> Mã:</label>
				 <div class="col-xs-7">
						<input type="text" name="code" class="form-control" id="dimension_code" placeholder="Mã chiều:" data-ok="0" value="<?php echo set_value('code'); ?>">
						<div class="text-danger"><?php echo form_error('code'); ?></div>
				 </div>
             <div class="col-xs-2 padding-0">
               <i class="fa fa-fw fa-2x fa-spin checking hidden" aria-hidden="true" title="loading..."></i>
               <i class="fa fa-fw fa-2x success hidden" aria-hidden="true" title="Ok!"></i>
               <i class="fa fa-fw fa-2x danger hidden" aria-hidden="true" title="Invalid!"></i>
            </div>
			</div>
         <div class="form-group">
				 <label for="name" class="col-xs-3 control-label text-right"><span class="text-danger">(*)</span> Tên chiều:</label>
				 <div class="col-xs-9">
					<textarea name="name" class="form-control" id="dimension_name"><?php echo set_value('name'); ?></textarea>
					<div class="text-danger"><?php echo form_error('name'); ?></div>
				 </div>
			</div>
         <div class="form-group">
				 <label for="note" class="col-xs-3 control-label text-right">Ghi chú:</label>
				 <div class="col-xs-9">
					<textarea name="note" class="form-control" id="note"><?php echo set_value('note'); ?></textarea>
					<div class="text-danger"><?php echo form_error('note'); ?></div>
				 </div>
			</div>
		</div>
		<div class="col-md-6">
         <div class="form-group">
				 <label for="parent-dimen" class="col-xs-3 control-label text-right"> Chiều cha:</label>
				 <div class="col-xs-9">
						<select class="form-control" id="parent-dimen" name="parent_id">
							<option value="0">(Chọn chiều cha)</option>
							<?php foreach ($dimensions as $item): ?>
							<option value="<?php echo $item->id; ?>" <?php if ($item->id == set_value('parent_id')) echo 'selected'; ?> ><?php echo $item->code . " : " . $item->name; ?></option>
							<?php endforeach ?>
					</select>
					<div class="text-danger"><?php echo form_error('parent_id'); ?></div>
				 </div>
			</div>
         <div class="row">
            <div class="col-xs-6">
               <div class="form-group">
      				 <label for="layer" class="col-xs-6 control-label text-right"><span class="text-danger">(*)</span> Tầng:</label>
      				 <div class="col-xs-6">
      						<input type="number" name="layer" class="form-control" id="layer" placeholder="Tầng quản trị" value="<?php echo set_value('layer'); ?>">
      						<div class="text-danger"><?php echo form_error('layer'); ?></div>
      				 </div>
      			</div>
            </div>
            <div class="col-xs-6">
               <div class="form-group">
      				 <label for="sequence" class="col-xs-5 col-md-6 control-label text-right"><span class="text-danger">(*)</span> Thứ tự:</label>
      				 <div class="col-xs-7 col-md-6">
      						<input type="number" name="sequence" class="form-control" id="sequence" placeholder="Thứ tự hiển thị:" value="<?php echo set_value('sequence'); ?>">
      						<div class="text-danger"><?php echo form_error('sequence'); ?></div>
      				 </div>
      			</div>
            </div>
         </div>
         <div class="form-group">
      		 <div class="col-xs-9 col-xs-offset-3 col-sm-6 col-sm-offset-4 col-lg-6">
      			<input class="form-control btn btn-success" type="submit" id="dimension-done" value="Xác nhận" disabled>
      		 </div>
      	</div>
		</div>
	</div>

</form>

<div class="row">
	<h5 class="pull-left"><strong>Các chiều quản trị:</strong></h5>
	<!-- <i class="fa fa-fw fa-2x pull-right hidden" aria-hidden="true" title="Copy to use chevron-down"></i> -->
	<i class="fa fa-fw fa-2x pull-right slide-add-voucher" data-hidden="0" aria-hidden="true" title="Hide"></i>
	<div class="clearfix"></div>
</div>

<div class="row log-box">
	<div class="col-sm-12">
		<table class="table table-hover dataTable no-footer log-table" id="dimension_table" role="grid" aria-describedby="dimension_table_info" border="1">
			<thead>
					<tr role="row">
						<th class="sorting" tabindex="0" aria-controls="dimension_table" rowspan="1" colspan="1" aria-label="Code: activate to sort column ascending">Mã</th>
						<th class="sorting" tabindex="0" aria-controls="dimension_table" rowspan="1" colspan="1" aria-label="Name type: activate to sort column ascending">Tên chiều</th>
						<th class="sorting" tabindex="0" aria-controls="dimension_table" rowspan="1" colspan="1" aria-label="Parent dimension: activate to sort column ascending">Chiều cha</th>
						<th class="sorting" tabindex="0" aria-controls="dimension_table" rowspan="1" colspan="1" aria-label="Note: activate to sort column ascending">Ghi chú</th>
                  <th class="sorting" tabindex="0" aria-controls="dimension_table" rowspan="1" colspan="1" aria-label="Layer: activate to sort column ascending">Tầng</th>
						<th class="sorting" tabindex="0" aria-controls="dimension_table" rowspan="1" colspan="1" aria-label="Sequence: activate to sort column ascending">Thứ tự</th>

					</tr>
			</thead>
			<tbody>
				<?php foreach ($dimensions as $item): ?>
					<tr role="row" data-url="<?php echo base_url('Dimension/view_more'); ?>" data-id="<?php echo $item->id; ?>" class="dimen-row">
						 <td><?php echo $item->code; ?></td>
						 <td><?php echo $item->name; ?></td>
						 <td>
							 <?php
								foreach ($dimensions as $parent) {
									if ($item->parent_id == $parent->id) {
										echo $parent->code;
										break;
									}
								}
							  ?>
						 </td>
						 <td><?php echo $item->note; ?></td>
						 <td class="text-center"><?php echo $item->layer; ?></td>
                   <td class="text-center"><?php echo $item->sequence; ?></td>
					</tr>
				<?php endforeach; ?>
			  </tbody>
		</table>
		<script type="text/javascript">
			$('#dimension_table').DataTable({
					  responsive: true,
                 "columns" : [
                   { "width" : "15%" },
                   { "width" : "30%" },
                   { "width" : "15%" },
                   { "width" : "20%" },
                   { "width" : "10%" },
                   { "width" : "10%" }
                 ],
					  "order" : [[4, 'desc']]
			});
		</script>
	</div>
</div>

<div class="modal fade" id="view-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content data-insert">
      <!-- insert by ajax -->
    </div>
  </div>
</div>


<input type="hidden" id="list-dimen-code" value="<?php
   $str = "";
   foreach ($dimensions as $dimen) {
      $str .= $dimen->code . ",";
   }
   echo $str;
?>">
