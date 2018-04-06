<form class="form-horizontal" method="post">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
			    <label for="receipt-type" class="col-sm-3 control-label"><span class="text-danger">(*)</span> Loại chứng từ</label>
			    <div class="col-sm-9">
			      	<select class="form-control" id="receipt-type" name="receipt_type">
			      		<?php foreach ($receipt_type as $item): ?>
			    			<option value="<?php echo $item->id; ?>" ><?php echo $item->code . " (" . $item->name . ")"; ?></option>
			      		<?php endforeach ?>
			    	</select>
			    </div>
		  	</div>
		  	<div class="form-group">
			    <label for="receipt-code" class="col-sm-3 control-label">Mã chứng từ</label>
			    <div class="col-sm-9">
			      	<input type="text" class="form-control" id="receipt-code" placeholder="Mã chứng từ">
			      	<div class="checkbox">
                        <label>
                            <input id="auto-receipt-id" type="checkbox" value="">Tự động
                        </label>
                    </div>
			    </div>
		  	</div>
		  	<div class="form-group">
			    <label for="value" class="col-sm-3 control-label"><span class="text-danger">(*)</span> Số tiền</label>
			    <div class="col-sm-9">
			      	<input type="number" name="value" class="form-control" id="value" min="100" step="100">
			    </div>
		  	</div>
		  	<div class="form-group">
			    <label for="content" class="col-sm-3 control-label">Nội dung</label>
			    <div class="col-sm-9">
			    	<textarea class="form-control" id="content"></textarea>
			    </div>
		  	</div>
		  	<div class="form-group">
			    <label for="executor" class="col-sm-3 control-label"><span class="text-danger">(*)</span> Người giao dịch</label>
			    <div class="col-sm-9">
			    	<select class="form-control" name="executor" id="executor">
			    		<option></option>
			    		<?php foreach ($employees as $item): ?>
			    			<option value="<?php echo $item->id; ?>"><?php echo $item->name; ?></option>
			    		<?php endforeach ?>
			    	</select>
			    </div>
		  	</div>
		</div>
		<div class="col-md-6">
		  	<div class="form-group">
			    <label for="tot" class="col-sm-3 control-label" title="Ngày phát sinh giao dịch"><span class="text-danger">(*)</span> TOT</label>
			    <div class="col-sm-9">
			    	<input type="date" class="form-control" name="tot" id="tot" value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>">
			    </div>
		  	</div>
		  	<div class="form-group">
			    <label for="toa" class="col-sm-3 control-label" title="Ngày thực hiện giao dịch"><span class="text-danger">(*)</span> TOA</label>
			    <div class="col-sm-9">
			    	<input type="date" class="form-control"name="toa"  id="toa" value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>">
			    </div>
		  	</div>
			<div class="form-group">
			    <label for="date" class="col-sm-3 control-label"><span class="text-danger">(*)</span> Ngày lập</label>
			    <div class="col-sm-9">
			    	<input type="date" class="form-control" name="date" id="date" placeholder="Ngày lập" value="<?php echo date('Y-m-d'); ?>">
			    </div>
		  	</div>
		</div>
	</div>
	<div class="form-group">
	    <div class="col-sm-6 col-sm-offset-3">
	    	<input type="submit" class="form-control btn btn-success" id="ok" value="OK">
	    </div>
  	</div>
</form>