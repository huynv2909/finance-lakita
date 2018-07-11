<div class="row">
   <div class="col-xs-2">
      <label for="voucher-choose">Chọn chứng từ:</label>
   </div>
   <div class="col-xs-10">
      <select name="voucher-choose" id="voucher-choose" class="choose-box" data-url="<?php echo base_url('Voucher/show_info'); ?>">
         <option value="0">(Lựa chọn chứng từ)</option>
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

<div class="row">
   <div class="col-xs-2">
      <label for="act-choose">Chọn bút toán:</label>
   </div>
   <div class="col-xs-10">
      <select name="act-choose" id="act-choose" class="choose-box" data-url="<?php echo base_url('AccountingEntry/show_info'); ?>" disabled>
         <!-- Load by ajax -->
      </select>
   </div>
</div>
<h5>Thông tin bút toán:</h5>
<div class="info-box" id="act-box">
   <div class="contain-act-info">
      <h2 class="empty-info">(Hãy lựa chọn bút toán)</h2>
         <!-- Load by ajax -->
   </div>
   <div class="load-info">
      <i class="fa fa-fw fa-3x fa-spin waiting" aria-hidden="true" title="Copy to use circle-o-notch"></i>
      <i class="fa fa-fw fa-3x success hidden" aria-hidden="true" title="Success"></i>
   </div>
</div>

<hr>

<h5><strong>Đã phân bổ:</strong></h5>
<div class="row log-box">
	<div class="col-sm-12">
		<table class="table table-hover dataTable no-footer log-table" id="distribution_table" role="grid" aria-describedby="distribution_table_info" border="1">
			<thead>
					<tr role="row">
						<th class="sorting" tabindex="0" aria-controls="distribution_table" rowspan="1" colspan="1" aria-label="Distributtion dimention: activate to sort column ascending" style="width: 12%;">Chiều phân bổ</th>
						<th class="sorting" tabindex="0" aria-controls="distribution_table" rowspan="1" colspan="1" aria-label="Value: activate to sort column ascending" style="width: 20%;">Số tiền</th>
						<th class="sorting" tabindex="0" aria-controls="distribution_table" rowspan="1" colspan="1" aria-label="Content: activate to sort column ascending" style="width: 14%;">Nội dung</th>
					</tr>
			</thead>
			<tbody class="contain-distribution-row">
            <tr role="row">
					 <td colspan="3"><h5 class="empty-info">(Hãy lựa chọn bút toán)</h5></td>
					 <td style="display:none;"></td>
					 <td style="display:none;"></td>
				</tr>
	       </tbody>
		</table>
      <script>
          $(document).ready(function() {
              $('#distribution_table').DataTable({
                      responsive: true,
                      "columns" : [
                        { "width" : "40%" },
                        { "width" : "20%" },
                        { "width" : "40%" }
                     ],
                      "order" : [[0, 'asc']]
              });
          });
      </script>
   </div>
</div>
<input type="hidden" id="dimension-list" value="">
<input type="hidden" id="tot">
<input type="hidden" id="toa">
<button type="button" class="btn btn-primary" id="distribute-btn" title="Thêm loại chứng từ mới" data-url="<?php echo base_url('Distribution/load_form'); ?>" disabled>
  <i class="fa fa-fw" aria-hidden="true" title="+ Phân bổ mới"></i> Phân bổ
</button>
<button type="button" class="btn btn-success pull-right" id="distribute-update-btn" title="Lưu lại các thay đổi" data-url="<?php echo base_url('Distribution/create'); ?>" disabled>
  <i class="fa fa-check" title="Lưu thay đổi"></i> Cập nhật
</button>
<div class="clearfix"></div>

<input type="hidden" id="have-a-act-id" data-url="<?php echo base_url('AccountingEntry/get_voucher'); ?>" value="<?php if ($this->input->get()) {
   echo $this->input->get('act_id');
} ?>">
