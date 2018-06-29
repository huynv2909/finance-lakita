<form class="form-horizontal" method="post">
	<div class="row">
		<div class="col-md-8">
			<div class="form-group">
				 <label for="receipt-type" class="col-xs-3 control-label text-right"><span class="text-danger">(*)</span> Loại chứng từ</label>
				 <div class="col-xs-9">
						<select class="form-control" id="receipt-type" name="receipt_type" data-url="<?php echo base_url(); ?>Receipt/load_form">
							<option></option>
							<?php foreach ($receipt_type as $item): ?>
							<option value="<?php echo $item->id; ?>" <?php if ($item->id == $this->input->post('receipt_type')) echo 'selected'; ?> ><?php echo $item->code . " (" . $item->name . ")"; ?></option>
							<?php endforeach ?>
					</select>
					<div class="text-danger"><?php echo form_error('receipt_type'); ?></div>
				 </div>
			</div>
			<div class="form-group">
				 <label for="code-real" class="col-xs-3 control-label text-right">Mã chứng từ</label>
				 <div class="col-xs-9">
						<input type="text" name="code_real" class="form-control" id="code-real" placeholder="Mã chứng từ (thực tế nếu có)" value="<?php echo set_value('code_real'); ?>">
						<div class="text-danger"><?php echo form_error('code_real'); ?></div>
				 </div>
			</div>
			<div class="form-group">
				 <label for="value" class="col-xs-3 control-label text-right"><span class="text-danger">(*)</span> Số tiền</label>
				 <div class="col-xs-9">
						<input onkeyup="oneDot(this)" type="text" name="value" class="form-control" id="value" value="<?php echo set_value('value'); ?>">
						<div class="text-danger" id="text-danger-value"><?php echo form_error('value'); ?></div>
				 </div>
			</div>
			<div class="form-group">
				 <label for="content" class="col-xs-3 control-label text-right">Nội dung</label>
				 <div class="col-xs-9">
					<textarea name="content" class="form-control" id="content"><?php echo set_value('content'); ?></textarea>
					<div class="text-danger"><?php echo form_error('content'); ?></div>
				 </div>
			</div>
			<div class="form-group">
				 <label for="executor" class="col-xs-3 control-label text-right"><span class="text-danger">(*)</span> Người giao dịch</label>
				 <div class="col-xs-5">
					<select class="form-control" name="executor" id="executor" >
						<option></option>
						<?php foreach ($employees as $item): ?>
							<option value="<?php echo $item->id; ?>" <?php if ($item->id == $this->input->post('executor')) echo 'selected'; ?> ><?php echo $item->name; ?></option>
						<?php endforeach ?>
					</select>
					<div class="text-danger"><?php echo form_error('executor'); ?></div>
				 </div>
				 <div class="col-xs-3 col-xs-push-1">
					<select class="form-control" name="income" id="income" >
						<option value="0" selected>Phiếu Chi</option>
						<option value="1">Phiếu Thu</option>
					</select>
					<div class="text-danger"><?php echo form_error('income'); ?></div>
				 </div>
			</div>
			<div class="form-group">
				 <label for="note" class="col-xs-3 control-label text-right">Ghi chú</label>
				 <div class="col-xs-9">
					<textarea name="note" class="form-control" id="note"><?php echo set_value('note'); ?></textarea>
					<div class="text-danger"><?php echo form_error('note'); ?></div>
				 </div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				 <label for="tot" class="col-xs-4 col-sm-6 col-md-4 col-lg-5 control-label text-right" title="Ngày phát sinh giao dịch"><span class="text-danger">(*)</span> TOT</label>
				 <div class="col-xs-8 col-sm-6 col-md-8 col-lg-7">
					<input type="date" class="form-control" name="tot" id="tot" value="<?php if (empty(set_value('tot'))) { echo date('Y-m-d'); } else echo set_value('tot'); ?>" max="<?php echo date('Y-m-d'); ?>">
					<div class="text-danger"><?php echo form_error('tot'); ?></div>
				 </div>
			</div>
			<div class="form-group">
				 <label for="toa" class="col-xs-4 col-sm-6 col-md-4 col-lg-5 control-label text-right" title="Ngày thực hiện giao dịch"> TOA</label>
				 <div class="col-xs-8 col-sm-6 col-md-8 col-lg-7">
					<input type="date" class="form-control" name="toa"  id="toa" value="<?php if (empty(set_value('toa'))) { echo date('Y-m-d'); } else echo set_value('toa'); ?>" max="<?php echo date('Y-m-d'); ?>">
					<div class="text-danger"><?php echo form_error('toa'); ?></div>
				 </div>
			</div>
		</div>
	</div>
	<div class="form-group">
		 <div class="col-sm-6 col-sm-offset-3">
			<input class="form-control btn btn-success" type="submit" id="receipt-done" value="Xác nhận">
		 </div>
	</div>
</form>

<h5><strong>Chứng từ đã nhập:</strong></h5>
<div class="row log-table">
	<div class="col-sm-12">
		<table class="table table-hover dataTable no-footer" id="voucher_table" role="grid" aria-describedby="voucher_table_info" border="1">
			<thead>
					<tr role="row">
						<th class="sorting" tabindex="0" aria-controls="voucher_table" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 12%;">Thời gian</th>
						<th class="sorting" tabindex="0" aria-controls="voucher_table" rowspan="1" colspan="1" aria-label="Reiceipt type: activate to sort column ascending" style="width: 20%;">Loại chứng từ</th>
						<th class="sorting" tabindex="0" aria-controls="voucher_table" rowspan="1" colspan="1" aria-label="Value: activate to sort column ascending" style="width: 14%;">Số tiền</th>
						<th class="sorting" tabindex="0" aria-controls="voucher_table" rowspan="1" colspan="1" aria-label="Content: activate to sort column ascending" style="width: 28%;">Nội dung</th>
						<th class="sorting" tabindex="0" aria-controls="voucher_table" rowspan="1" colspan="1" aria-label="Executor: activate to sort column ascending" style="width: 14%;">Người giao dịch</th>
						<th class="sorting" tabindex="0" aria-controls="voucher_table" rowspan="1" colspan="1" aria-label="Time on action: activate to sort column ascending" style="width: 12%;">TOA</th>
					</tr>
			</thead>
			<tbody>
				<?php foreach ($vouchers as $item): ?>
					<tr role="row" data-url="<?php echo base_url('Receipt/view_more'); ?>" data-id="<?php echo $item->id; ?>" class="re-row <?php if ($item->income == 1) echo 'success'; ?>">
						 <td><?php echo $item->date; ?></td>
						 <td>
							 <?php
								foreach ($receipt_type as $type) {
									if ($item->type_id == $type->id) {
										echo $type->name;
										break;
									}
								}
							  ?>
						 </td>
						 <td><?php echo number_format($item->value, 0, ",", "."); ?></td>
						 <td><?php echo $item->content; ?></td>
						 <td>
							 <?php
								foreach ($employees as $user) {
									if ($item->executor == $user->id) {
										echo $user->name;
										break;
									}
								}
							  ?>
						 </td>
						 <td><?php echo $item->TOT; ?></td>
					</tr>
				<?php endforeach; ?>
			  </tbody>
		</table>
	</div>
</div>
