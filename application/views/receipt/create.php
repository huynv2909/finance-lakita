<form class="form-horizontal" method="post">
	<div class="container-both">
		<div class="progress-nav">
			<div class="row">
				<div class="col-xs-4 move">
					<button id="move-left" type="button" name=""><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span></button>
				</div>
				<div class="col-xs-4">
					<h3 id="receipt-title" class="text-center">Thông tin chứng từ</h3>
					<h3 id="act-entry-title"  class="text-center">Ghi nhận bút toán</h3>
				</div>
				<div class="col-xs-4 move text-right">
					<button id="move-right" type="button" name="" disabled><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span></button>
				</div>
			</div>
		</div>
		<div class="receipt">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
					    <label for="receipt-type" class="col-sm-3 control-label"><span class="text-danger">(*)</span> Loại chứng từ</label>
					    <div class="col-sm-9">
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
					    <label for="code-real" class="col-sm-3 control-label">Mã chứng từ</label>
					    <div class="col-sm-9">
					      	<input type="text" name="code_real" class="form-control" id="code-real" placeholder="Mã chứng từ (thực tế nếu có)" value="<?php echo set_value('code_real'); ?>">
					      	<div class="text-danger"><?php echo form_error('code_real'); ?></div>
					    </div>
				  	</div>
				  	<div class="form-group">
					    <label for="value" class="col-sm-3 control-label"><span class="text-danger">(*)</span> Số tiền</label>
					    <div class="col-sm-9">
					      	<input onkeyup="oneDot(this)" type="text" name="value" class="form-control" id="value" value="<?php echo set_value('value'); ?>">
					      	<div class="text-danger"><?php echo form_error('value'); ?></div>
					    </div>
				  	</div>
				  	<div class="form-group">
					    <label for="content" class="col-sm-3 control-label">Nội dung</label>
					    <div class="col-sm-9">
					    	<textarea name="content" class="form-control" id="content"><?php echo set_value('content'); ?></textarea>
					    	<div class="text-danger"><?php echo form_error('content'); ?></div>
					    </div>
				  	</div>
				  	<div class="form-group">
					    <label for="executor" class="col-sm-3 control-label"><span class="text-danger">(*)</span> Người giao dịch</label>
					    <div class="col-sm-9">
					    	<select class="form-control" name="executor" id="executor" >
					    		<option></option>
					    		<?php foreach ($employees as $item): ?>
					    			<option value="<?php echo $item->id; ?>" <?php if ($item->id == $this->input->post('executor')) echo 'selected'; ?> ><?php echo $item->name; ?></option>
					    		<?php endforeach ?>
					    	</select>
					    	<div class="text-danger"><?php echo form_error('executor'); ?></div>
					    </div>
				  	</div>
				  	<div class="form-group">
					    <label for="note" class="col-sm-3 control-label">Ghi chú</label>
					    <div class="col-sm-9">
					    	<textarea name="note" class="form-control" id="note"><?php echo set_value('note'); ?></textarea>
					    	<div class="text-danger"><?php echo form_error('note'); ?></div>
					    </div>
				  	</div>
				</div>
				<div class="col-md-6">
				  	<div class="form-group">
					    <label for="tot" class="col-sm-3 control-label" title="Ngày phát sinh giao dịch"><span class="text-danger">(*)</span> TOT</label>
					    <div class="col-sm-9">
					    	<input type="date" class="form-control" name="tot" id="tot" value="<?php if (empty(set_value('tot'))) { echo date('Y-m-d'); } else echo set_value('tot'); ?>" max="<?php echo date('Y-m-d'); ?>">
					    	<div class="text-danger"><?php echo form_error('tot'); ?></div>
					    </div>
				  	</div>
				  	<div class="form-group">
					    <label for="toa" class="col-sm-3 control-label" title="Ngày thực hiện giao dịch"><span class="text-danger">(*)</span> TOA</label>
					    <div class="col-sm-9">
					    	<input type="date" class="form-control" name="toa"  id="toa" value="<?php if (empty(set_value('toa'))) { echo date('Y-m-d'); } else echo set_value('toa'); ?>" max="<?php echo date('Y-m-d'); ?>">
					    	<div class="text-danger"><?php echo form_error('toa'); ?></div>
					    </div>
				  	</div>
					<div class="form-group">
					    <label for="date" class="col-sm-3 control-label"><span class="text-danger">(*)</span> Ngày lập</label>
					    <div class="col-sm-9">
					    	<input type="date" class="form-control" name="date" id="date" placeholder="Ngày lập" value="<?php echo date('Y-m-d'); ?>">
					    	<div class="text-danger"><?php echo form_error('date'); ?></div>
					    </div>
				  	</div>
					<div class="form-group">
					    <label for="income" class="col-sm-3 control-label"><span class="text-danger">(*)</span> Loại</label>
					    <div class="col-sm-9">
					    	<select class="form-control" name="income" id="income" >
					    		<option value="0" selected>Chi</option>
					    		<option value="1">Thu</option>
					    	</select>
					    	<div class="text-danger"><?php echo form_error('income'); ?></div>
					    </div>
				  	</div>
				</div>
			</div>
			<div class="form-group">
			    <div class="col-sm-6 col-sm-offset-3">
			    	<input class="form-control btn btn-success" type="button" id="receipt-done" disabled value="Xác nhận">
			    </div>
		  	</div>
			<input type="hidden" name="index_max" id="index-max">
		</div>
		<div class="act-entry">
			<!-- Using ajax to insert form -->
		</div>
	</div>
</form>
