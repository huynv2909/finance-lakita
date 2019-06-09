<?php $confs = json_decode($configs); $total = 0; ?>
<form class="form-horizontal" method="post" id="voucher-form" action="<?php echo $this->routes['voucher_create']; ?>" <?php if ($this->input->get()): ?>
	style="display: none";
<?php endif; ?>>
	<div class="row">
		<div class="col-md-8">
			<div class="form-group">
				 <label for="voucher-type" class="col-xs-3 control-label text-right"><span class="text-danger">(*)</span> Loại chứng từ</label>
				 <div class="col-xs-9">
					<select class="form-control" id="voucher-type" name="voucher_type" data-url="<?php echo $this->routes['voucher_getdefaultsys']; ?>">
						<option value="0" class="hidden">(Chọn loại chứng từ)</option>
						<optgroup label="Phiếu thu">
							<?php foreach ($voucher_type as $item): ?>
								<?php if ($item->income == 1): ?>
									<option value="<?php echo $item->id; ?>" <?php if ($item->id == $this->input->post('voucher_type')) echo 'selected'; ?> ><?php echo $item->code . " (" . $item->name . ")"; ?></option>
								<?php endif; ?>
							<?php endforeach ?>
						</optgroup>

						<optgroup label="Phiếu chi">
							<?php foreach ($voucher_type as $item): ?>
								<?php if ($item->income == 0): ?>
									<option value="<?php echo $item->id; ?>" <?php if ($item->id == $this->input->post('voucher_type')) echo 'selected'; ?> ><?php echo $item->code . " (" . $item->name . ")";?></option>
								<?php endif; ?>
							<?php endforeach ?>
						</optgroup>
					</select>
					<div class="text-danger"><?php echo form_error('voucher_type'); ?></div>
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
				 <div class="col-xs-6">
						<input onkeyup="oneDot(this)" type="text" name="value" class="form-control" id="value" value="<?php echo set_value('value'); ?>">
						<div class="text-danger" id="text-danger-value"><?php echo form_error('value'); ?></div>
				 </div>
				 <div class="col-xs-3">
				 		<p id="remaining-amount"></p>
				 </div>
			</div>
			<div class="form-group contain-detail" id="contain-detail-income">
				 <div class="col-xs-9 col-xs-offset-3">
					<table class="acc-fill-table">
						<thead>
							<tr>
								<th style="width: 35%; text-align: center;">Sản phẩm:</th>
								<th style="width: 10%; text-align: center;">Đơn giá:</th>
								<th style="width: 5%; text-align: center;">Số lượng</th>
								<th style="width: 16%; text-align: center;">Số tiền:</th>
								<th style="width: 15%; text-align: center;">TOA:</th>
								<th style="width: 7%; text-align: center;">TK nợ:</th>
								<th style="width: 7%; text-align: center;">TK Có:</th>
								<th style="width: 5%; text-align: center;"></th>
							</tr>
						</thead>
						<tbody>
							<tr class="last-sub-row sub-row" id="sub-row-1" data-number="1">
								<td>
									<select class="sub_course" name="course_1" id="course_1">
										<option value="0" selected class="hidden">(Lựa chọn)</option>
										<?php foreach ($courses as $course): ?>
											<option value="<?php echo $course->id; ?>"><?php echo $course->name . " : " . $course->note; ?></option>
										<?php endforeach; ?>
									</select>
								</td>
								<td>
									<input class="unit_price" type="text" onkeyup="oneDot(this)" id="unit_price_1" data-item="1" value="">
								</td>
								<td>
									<input class="amount text-center" type="number" id="amount_1" value="1" min="1" data-item="1">
								</td>
								<td>
									<input class="sub_value" type="text" onkeyup="oneDot(this)"  name="value_1" id="value_1" value="" data-alive="1" readonly="readonly">
								</td>
								<td>
									<input class="sub_toa" type="date" name="toa_1" id="toa_1" value="<?php echo date('Y-m-d'); ?>" data-alive="1">
								</td>
								<td>
									<select class="sub_debit" name="debit_1" id="debit_1">
										<option value="0" class="hidden">(Lựa chọn)</option>
										<?php foreach ($system_acc as $acc): ?>
											<option value="<?php echo $acc->number; ?>"><?php echo $acc->number . " : " . $acc->description; ?></option>
										<?php endforeach; ?>
									</select>
								</td>
								<td>
									<select class="sub_credit" name="credit_1" id="credit_1">
										<option value="0" class="hidden">(Lựa chọn)</option>
										<?php foreach ($system_acc as $acc): ?>
											<option value="<?php echo $acc->number; ?>" ><?php echo $acc->number . " : " . $acc->description; ?></option>
										<?php endforeach; ?>
									</select>
								</td>
								<td class="text-center">
									<input type="hidden" name="confirm_1" id="confirm_1" value="1">
									<i class="fa fa-fw delete_sub" data-number="1" aria-hidden="true" title="Loại bỏ"></i>
								</td>
							</tr>
						</tbody>
					</table>

					<p id="tax-text"><input type="checkbox" name="vat_check" value="1" <?php if ($confs->AUTO_VAT_TAX == 1) echo 'checked'; ?>> Đã bao gồm <input type="number" class="input-transparent text-center" name="tax_value" value="<?php echo $confs->VAT; ?>" min="0" max="100"> % thuế</p>
					<input type="hidden" name="debit_tax" value="111">
					<input type="hidden" name="credit_tax" value="3331">
				 </div>
			</div>
			<div class="form-group contain-detail" id="contain-detail-out">
				 <div class="col-xs-8 col-xs-offset-4">
					<table class="acc-fill-table">
						<thead>
							<tr>
								<th style="width: 35%; text-align: center;">Thuộc chiều:</th>
								<th style="width: 20%; text-align: center;">Số tiền:</th>
								<th style="width: 20%; text-align: center;">TOA:</th>
								<th style="width: 10%; text-align: center;">TK nợ:</th>
								<th style="width: 10%; text-align: center;">TK Có:</th>
								<th style="width: 5%; text-align: center;"></th>
							</tr>
						</thead>
						<tbody>
							<tr class="last-sub-out-row sub-out-row" id="sub-out-row-1">
								<td>
									<select class="sub_out_dimen" name="dimen_out_1" id="dimen_out_1">
										<option value="0" class="hidden">(Lựa chọn)</option>
										<?php foreach ($dimens as $dimen): ?>
											<option value="<?php echo $dimen->id; ?>"><?php echo $dimen->name; ?></option>
										<?php endforeach; ?>
									</select>
								</td>
								<td>
									<input class="sub_out_value" type="text" onkeyup="oneDot(this)"  name="value_out_1" id="value_out_1" value="" data-alive="1">
								</td>
								<td>
									<input class="sub_out_toa" type="date" name="toa_out_1" id="toa_out_1" value="<?php echo date('Y-m-d'); ?>" data-alive="1">
								</td>
								<td>
									<select class="sub_out_debit" name="debit_out_1" id="debit_out_1">
										<option value="0" class="hidden">(Lựa chọn)</option>
										<?php foreach ($system_acc as $acc): ?>
											<option value="<?php echo $acc->number; ?>"><?php echo $acc->number . " : " . $acc->description; ?></option>
										<?php endforeach; ?>
									</select>
								</td>
								<td>
									<select class="sub_out_credit" name="credit_out_1" id="credit_out_1">
										<option value="0" class="hidden">(Lựa chọn)</option>
										<?php foreach ($system_acc as $acc): ?>
											<option value="<?php echo $acc->number; ?>" ><?php echo $acc->number . " : " . $acc->description; ?></option>
										<?php endforeach; ?>
									</select>
								</td>
								<td class="text-center">
									<input type="hidden" name="confirm_out_1" id="confirm_out_1" value="1">
									<i class="fa fa-fw delete_out_sub" data-number="1" aria-hidden="true" title="Loại bỏ"></i>
								</td>
							</tr>
						</tbody>
					</table>
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
						<option value="0" class="hidden">(Lựa chọn)</option>
						<?php foreach ($employees as $item): ?>
							<option value="<?php echo $item->id; ?>" <?php if ($item->id == $this->input->post('executor')) echo 'selected'; ?> ><?php echo $item->name; ?></option>
						<?php endforeach ?>
					</select>
				 </div>
				 <div class="col-xs-3 col-xs-push-1">
					<select class="form-control" name="income" id="income" >
						<option value="0" selected>Phiếu Chi</option>
						<option value="1">Phiếu Thu</option>
					</select>
				 </div>
			</div>
			<div class="form-group">
				 <label for="method" class="col-xs-3 control-label text-right"><span class="text-danger">(*)</span> Hình thức</label>
				 <div class="col-xs-4">
					<select class="form-control" name="method" id="method" data-url="<?php echo $this->routes['provider_listbymethodid']; ?>">
						<option value="0" class="hidden">(Lựa chọn)</option>
						<?php foreach ($methods as $item): ?>
							<option value="<?php echo $item->id; ?>" <?php if ($item->id == $this->input->post('method')) echo 'selected'; ?> ><?php echo $item->name . " : " . $item->description; ?></option>
						<?php endforeach ?>
					</select>
				 </div>
				 <label for="provider" class="col-xs-1 col-xs-offset-1 text-right padding-0" style="padding-top: 7px;"><span class="text-danger">(*)</span> Qua</label>
				 <div class="col-xs-3">
					<select class="form-control" name="provider" id="provider" disabled>
						<option value="0" class="hidden" selected>(Lựa chọn)</option>
					</select>
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
			<div class="form-group">
				<div class="col-xs-8 col-sm-6 col-md-8 col-lg-7 col-xs-offset-4 col-sm-offset-6 col-md-offset-4 col-lg-offset-5">
					<p class="pull-right remind">Tự động hoàn thành bút toán:
						<?php if ($confs->AUTO_DISTRIBUTION == 1): ?>
							<a href="<?php echo $this->routes['config_index']; ?>"><span style="color:green;">Bật</span></a>
						<?php else: ?>
							<a href="<?php echo $this->routes['config_index']; ?>"><span style="color:red;">Tắt</span></a>
						<?php endif; ?>

					</p>
				</div>
			</div>
		</div>
	</div>
	<div class="form-group">
		 <div class="col-sm-6 col-sm-offset-3">
			 <input type="hidden" name="count_sub" id="count_sub" value="1" data-used="0">
			 <input type="hidden" name="count_sub_out" id="count_sub_out" value="1" data-used="0">
			 <input type="hidden" id="auto_distribution" name="auto_distribution" value="<?php echo $confs->AUTO_DISTRIBUTION; ?>">
			<input class="form-control btn btn-success" type="submit" id="voucher-done" value="Xác nhận" disabled>
		 </div>
	</div>
</form>

<form method="post" enctype="multipart/form-data" class="file-form" action="<?php echo $this->routes['voucher_createbyfiles']; ?>" <?php if ($this->input->get()): ?>
	style="display: none";
<?php endif; ?>>
	<label for="files">Thêm từ file</label>
	<input type="file" name="files" accept=".csv, .xlsx, .xls" id="voucher-files">
	<input type="hidden" name="type" id="type" value="">
	<input type="submit" class="btn btn-warning btn-sm" name="ok" id="upload-btn" value="Thêm" style="margin-top: 4px;" disabled>
</form>

<div class="row">
	<h5 class="pull-left">
		<strong>Chứng từ đã nhập:</strong>
		<?php if ($amount_uncompleted > 0): ?>
			(Còn <a href="<?php echo $this->routes['voucher_create'] . '?uncompleted=1'; ?>"><span id="uncompleted_amount"><?php echo $amount_uncompleted; ?></span> chứng từ</a> chưa hoàn thành)
			<?php if (!$get_uncompleted): ?>
				<a href="<?php echo $this->routes['voucher_distributiononetime']; ?>">Tự động hoàn thành<i class="fa fa-fw" aria-hidden="true" title="Tự động hoàn thành"></i></a>
			<?php endif; ?>
		<?php endif; ?>
	</h5>
	<?php if ($this->input->get()): ?>
		<i class="fa fa-fw fa-2x pull-right slide-form" aria-hidden="true" title="Show"></i>
	<?php else: ?>
		<i class="fa fa-fw fa-2x pull-right slide-form" data-hidden="0" aria-hidden="true" title="Hide"></i>
	<?php endif; ?>
	<div class="clearfix"></div>
</div>

<div class="row log-box">
	<div class="col-sm-12">
		<div class="filter-box" <?php if (!$this->input->get()): ?>
			style="display: none";
		<?php endif; ?>>
			<div class="col-md-4 col-lg-3">
				<p class="text-center">TOT</p>
				<div class="filter-subbox">
					<label for="from">Từ:</label>
					<input id="fil-from" class="form-control filter-field" type="date" name="from" value="<?php if (null !== $this->input->get('from')) echo $this->input->get('from'); ?>"
					<?php if (null !== $this->input->get('from')): ?>
						style="background-color: antiquewhite;"
					<?php endif; ?>
					>
					<label for="to">Đến:</label>
					<input id="fil-to" class="form-control filter-field" type="date" name="to" value="<?php if (null !== $this->input->get('to')) echo $this->input->get('to'); ?>"
					<?php if (null !== $this->input->get('to')): ?>
						style="background-color: antiquewhite;"
					<?php endif; ?>
					>
				</div>
			</div>
			<div class="col-md-4 col-lg-3">
				<p class="text-center">Phương thức:</p>
				<select id="fil-method" class="form-control filter-field" name=""
				<?php if (null !== $this->input->get('method')): ?>
					style="background-color: antiquewhite;"
				<?php endif; ?>
				>
					<option value="0" class="hidden">(Lựa chọn)</option>
					<?php foreach ($methods as $item): ?>
						<option value="<?php echo $item->id; ?>" <?php if ($item->id == $this->input->get('method')) echo 'selected'; ?> ><?php echo $item->name . " : " . $item->description; ?></option>
					<?php endforeach ?>
				</select>
			</div>
			<div class="col-md-4 col-lg-3">
				<p class="text-center">Qua:</p>
				<select id="fil-provider" class="form-control filter-field" name=""
				<?php if (null !== $this->input->get('provider')): ?>
					style="background-color: antiquewhite;"
				<?php endif; ?>
				>
					<option value="0" class="hidden">(Lựa chọn)</option>
					<?php foreach ($providers as $item): ?>
						<option value="<?php echo $item->id; ?>" <?php if ($item->id == $this->input->get('provider')) echo 'selected'; ?> ><?php echo $item->name . " : " . $item->description; ?></option>
					<?php endforeach ?>
				</select>
			</div>
			<div class="col-md-4 col-lg-3">
				<p class="text-center">Loại chứng từ:</p>
				<select id="fil-voucher_type" class="form-control filter-field" name=""
				<?php if (null !== $this->input->get('voucher_type')): ?>
					style="background-color: antiquewhite;"
				<?php endif; ?>
				>
					<option value="0" class="hidden">(Lựa chọn)</option>
					<optgroup label="Phiếu thu">
						<?php foreach ($voucher_type as $item): ?>
							<?php if ($item->income == 1): ?>
								<option value="<?php echo $item->id; ?>" <?php if ($item->id == $this->input->post('voucher_type')) echo 'selected'; ?> ><?php echo $item->code . " (" . $item->name . ")"; ?></option>
							<?php endif; ?>
						<?php endforeach ?>
					</optgroup>

					<optgroup label="Phiếu chi">
						<?php foreach ($voucher_type as $item): ?>
							<?php if ($item->income == 0): ?>
								<option value="<?php echo $item->id; ?>" <?php if ($item->id == $this->input->post('voucher_type')) echo 'selected'; ?> ><?php echo $item->code . " (" . $item->name . ")";?></option>
							<?php endif; ?>
						<?php endforeach ?>
					</optgroup>
				</select>
			</div>
			<div class="col-md-4 col-lg-3">
				<p class="text-center">Thực hiện:</p>
				<select id="fil-executor" class="form-control filter-field" name=""
				<?php if (null !== $this->input->get('executor')): ?>
					style="background-color: antiquewhite;"
				<?php endif; ?>
				>
					<option value="0" class="hidden">(Lựa chọn)</option>
					<?php foreach ($employees as $item): ?>
						<option value="<?php echo $item->id; ?>" <?php if ($item->id == $this->input->get('executor')) echo 'selected'; ?> ><?php echo $item->name; ?></option>
					<?php endforeach ?>
				</select>
			</div>
			<div class="col-md-4 col-lg-3">
				<p class="text-center filter-field">Loại:</p>
				<select id="fil-income" class="form-control filter-field" name=""
				<?php if (null !== $this->input->get('income')): ?>
					style="background-color: antiquewhite;"
				<?php endif; ?>
				>
					<option value="0" class="hidden">(Lựa chọn)</option>
					<option value="1" <?php if ($this->input->get('income') == '0') echo 'selected'; ?>>Phiếu chi</option>
					<option value="2" <?php if ($this->input->get('income') == '1') echo 'selected'; ?>>Phiếu thu</option>
				</select>
			</div>
			<div class="col-md-4 col-lg-3">
				<button type="button" name="button" class="btn btn-success" id="lets-filter"><i class="fa fa-fw" aria-hidden="true" title="Lọc ngay"></i> Lọc ngay</button>
				<a id="reset-filter-link" href="<?php echo $this->routes['voucher_create']; ?>" class="text-center" style="display: inherit;"><i class="fa fa-fw" aria-hidden="true" title="Bỏ lọc"></i> Bỏ lọc</a>
			</div>
			<div class="col-md-4 col-lg-3">
				<p class="text-center">Được duyệt:</p>
				<select id="fil-auto" class="form-control filter-field" name=""
				<?php if (null !== $this->input->get('auto')): ?>
					style="background-color: antiquewhite;"
				<?php endif; ?>
				>
					<option value="0">Tất cả</option>
					<option value="1" <?php if ($this->input->get('auto') == '1') echo 'selected'; ?>>Được thêm tự động</option>
					<option value="2" <?php if ($this->input->get('auto') == '2') echo 'selected'; ?>>Thêm thủ công</option>
				</select>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="row">
			<?php if ($this->input->get()): ?>
				<h4 class="pull-left">Tổng số: <span id="total-money"></span> đ</h4>
				<i class="fa fa-fw fa-2x pull-right slide-filter" data-hidden="0" aria-hidden="true" title="Hide"></i>
			<?php else: ?>
				<i class="fa fa-fw fa-2x pull-right slide-filter" data-hidden="1" aria-hidden="true" title="Lọc"></i>
			<?php endif; ?>
			<div class="clearfix"></div>
		</div>

	</div>
	<div class="col-sm-12">
		<table class="table table-hover dataTable no-footer log-table" id="voucher_table" role="grid" aria-describedby="voucher_table_info" border="1">
			<thead>
					<tr role="row">
						<th class="sorting" tabindex="0" aria-controls="voucher_table" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending">Thời gian</th>
						<th class="sorting" tabindex="0" aria-controls="voucher_table" rowspan="1" colspan="1" aria-label="Reiceipt type: activate to sort column ascending">Loại chứng từ</th>
						<th class="sorting" tabindex="0" aria-controls="voucher_table" rowspan="1" colspan="1" aria-label="Value: activate to sort column ascending">Số tiền</th>
						<th class="sorting" tabindex="0" aria-controls="voucher_table" rowspan="1" colspan="1" aria-label="Content: activate to sort column ascending">Nội dung</th>
						<th class="sorting" tabindex="0" aria-controls="voucher_table" rowspan="1" colspan="1" aria-label="Executor: activate to sort column ascending">Người giao dịch</th>
						<th class="sorting" tabindex="0" aria-controls="voucher_table" rowspan="1" colspan="1" aria-label="Time on transaction: activate to sort column ascending">TOT</th>
						<?php if (in_array('voucher_delete', explode(',', $this->role->permission_list))): ?>
							<th tabindex="0" aria-controls="voucher_table" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Thao tác</th>
						<?php endif; ?>
					</tr>
			</thead>
			<tbody>
				<?php if (isset($vouchers) && $vouchers): ?>
				<?php foreach ($vouchers as $item): ?>
					<?php if ($get_uncompleted || !$item->completed): ?>
					<tr role="row" id="row-<?php echo $item->id; ?>" data-url="<?php echo $this->routes['voucher_viewmore']; ?>" data-id="<?php echo $item->id; ?>" class="voucher-row <?php if ($item->income == 1) echo 'success'; ?>">
						 <td class="text-center"><?php echo $item->date; ?></td>
						 <td>
							 <?php
								foreach ($voucher_type as $type) {
									if ($item->type_id == $type->id) {
										echo $type->name;
										break;
									}
								}
							  ?>
						 </td>
						 <td class="text-right">
							 <?php if (!$item->completed): ?>
								 <a href="<?php echo $this->routes['accountingentry_create'] . '?voucher_id=' . $item->id; ?>" title="Đến nhập bút toán"><i class="fa fa-fw warning" aria-hidden="true" title="Đến nhập bút toán"></i></a>
							 <?php endif; ?>
							 <?php
						 		echo number_format($item->value, 0, ",", ".") . " đ";
								$total += $item->value;
							?>
						 </td>
						 <td><?php echo $item->content; ?></td>
						 <td class="text-center">
							 <?php
								foreach ($employees as $user) {
									if ($item->executor == $user->id) {
										echo $user->name;
										break;
									}
								}
							  ?>
						 </td>
						 <td class="text-center"><?php echo $item->TOT; ?></td>
						 <?php if (in_array('voucher_delete', explode(',', $this->role->permission_list))): ?>
						 	<td class="text-center"><button type="button" class="btn btn-circle del-btn" title="Xóa" data-url="<?php echo $this->routes['voucher_delete']; ?>" data-id="<?php echo $item->id; ?>"><i class="fa fa-times"></i></button></td>
						<?php endif; ?>
					</tr>
					<?php endif; ?>
				<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
		<script type="text/javascript">
			$('#voucher_table').DataTable({
					  responsive: true,
					  "columns" : [
						 { "width" : "13%" },
						 { "width" : "20%" },
						 { "width" : "12%" },
						 { "width" : "32%" },
						 { "width" : "8%" },
						 { "width" : "10%" }
					 ],
					  "order" : [[0, 'desc'], [5, 'desc']]
			});

			$('#total-money').html(convertToCurrency('<?php echo $total; ?>'));
		</script>
	</div>
</div>

<?php if (!$this->input->get()): ?>
<div class="alert-warning">
	<strong>Lưu ý: </strong>Để tăng tốc độ tải trang, bảng trên giới hạn <?php echo $limit_loading; ?> chứng từ gần nhất, bạn có thể <a href="<?php echo $this->routes['config_index']; ?>">điều chỉnh</a>!
</div>
<?php endif; ?>

<input type="hidden" id="distribution_popup" value="<?php echo $confs->NOTIFY_REDIRECT_TO_ACCOUNTING; ?>">
<!-- have new voucher added -->
<input type="hidden" id="have-a-new-voucher-add" data-url="<?php echo $this->routes['accountingentry_create'] . '?voucher_id=' . $latest_voucher_id; ?>" value="<?php if (isset($latest_voucher_id) && $latest_voucher_id) echo $latest_voucher_id; ?>">

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
