<div class="row">
   <div class="col-xs-2">
      <label for="voucher-choose">Chọn chứng từ:</label>
   </div>
   <div class="col-xs-10">
      <select name="voucher-choose" id="voucher-choose" class="choose-box" data-url="<?php echo base_url('Voucher/show_info'); ?>">
         <option value="0" selected class="hidden">(Lựa chọn chứng từ)</option>
         <?php foreach ($vouchers as $voucher): ?>
            <option value="<?php echo $voucher->id; ?>"><?php echo $voucher->TOT . " : " . $voucher->content; ?></option>
         <?php endforeach; ?>
      </select>
   </div>
</div>

<h5>Thông tin chứng từ:</h5>
<div class="info-box" id="voucher-box">
   <div class="contain-voucher-info">
      <h2 class="empty-info">(Hãy lựa chọn chứng từ)</h2>
         <!-- Load by ajax -->
   </div>
   <div class="load-info">
      <i class="fa fa-fw fa-3x fa-spin waiting" aria-hidden="true" title="Copy to use circle-o-notch"></i>
      <i class="fa fa-fw fa-3x success hidden" aria-hidden="true" title="Success"></i>
   </div>
</div>

<hr>

<h5><strong>Bút toán đã nhập:</strong></h5>
<div class="row log-box">
	<div class="col-sm-12">
		<table class="table table-hover dataTable no-footer log-table" id="act_table" role="grid" aria-describedby="voucher_table_info" border="1">
			<thead>
					<tr role="row">
						<th class="sorting" tabindex="0" aria-controls="act_table" rowspan="1" colspan="1" aria-label="Time on action: activate to sort column ascending" style="width: 12%;">TOA</th>
						<th class="sorting" tabindex="0" aria-controls="act_table" rowspan="1" colspan="1" aria-label="Content: activate to sort column ascending" style="width: 20%;">Nội dung</th>
						<th class="sorting" tabindex="0" aria-controls="act_table" rowspan="1" colspan="1" aria-label="Value: activate to sort column ascending" style="width: 14%;">Số tiền</th>
						<th class="sorting" tabindex="0" aria-controls="act_table" rowspan="1" colspan="1" aria-label="Debit ID: activate to sort column ascending" style="width: 28%;">TK nợ</th>
						<th class="sorting" tabindex="0" aria-controls="act_table" rowspan="1" colspan="1" aria-label="Credit ID: activate to sort column ascending" style="width: 12%;">TK có</th>
					</tr>
			</thead>
			<tbody class="contain-act-row">
            <tr role="row">
					 <td colspan="5"><h5 class="empty-info">(Hãy lựa chọn chứng từ)</h5></td>
                <td style="display:none;"></td>
                <td style="display:none;"></td>
                <td style="display:none;"></td>
                <td style="display:none;"></td>
				</tr>
	       </tbody>
		</table>
      <script>
          $(document).ready(function() {
              $('#act_table').DataTable({
                      responsive: true,
                      "columns" : [
                        { "width" : "15%" },
                        { "width" : "50%" },
                        { "width" : "15%" },
                        { "width" : "10%" },
                        { "width" : "10%" }
                     ],
                      "order" : [[0, 'asc']]
              });
          });
      </script>
   </div>
   <div class="load-info load-info-act">
      <i class="fa fa-fw fa-3x fa-spin waiting" aria-hidden="true" title="Copy to use circle-o-notch"></i>
      <i class="fa fa-fw fa-3x success hidden" aria-hidden="true" title="Success"></i>
   </div>
</div>
<input type="hidden" name="voucher_id" value="" id="voucher_id">
<input type="hidden" name="TOT" value="" id="TOT">
<button type="button" class="btn btn-primary" id="act-add-btn" title="Thêm loại chứng từ mới" data-url="<?php echo base_url('AccountingEntry/load_form'); ?>" disabled>
  <i class="fa fa-fw" aria-hidden="true" title="Thêm bút toán"></i> Thêm bút toán
</button>
<button type="button" class="btn btn-success pull-right" id="update-act-btn" title="Lưu lại các thay đổi" data-url="<?php echo base_url('AccountingEntry/create'); ?>" disabled>
  <i class="fa fa-check" title="Lưu thay đổi"></i> Cập nhật
</button>
<div class="clearfix"></div>

<!-- if have voucher -->
<input type="hidden" id="list_id_voucher" value="<?php
   foreach ($vouchers as $item) {
      echo $item->id . ",";
   }
 ?>">
<input type="hidden" id="set-voucher" value="<?php if (isset($set_voucher) && $set_voucher) echo $set_voucher; ?>">
