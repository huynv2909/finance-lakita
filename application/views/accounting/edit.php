<form id="edit-act-form" action="<?php echo $this->routes['accountingentry_editsubmit']; ?>" method="post">
   <input type="hidden" name="id" value="<?php echo $act_detail->id; ?>">
   <div class="col-md-4 col-xs-12 col-sm-6">
      <div class="form-group">
         <label for="content">Nội dung:</label>
         <textarea id="content" class="form-control" name="content" rows="2"><?php echo $act_detail->content; ?></textarea>
      </div>
   </div>
   <div class="col-md-4 col-xs-12 col-sm-6">
      <div class="form-group">
         <label for="value">Giá trị:</label>
         <input class="form-control" id="value" name="value" onkeyup="oneDot(this)" type="text" value="<?php echo number_format($act_detail->value, 0, ",", "."); ?>">
      </div>
      <div class="form-group">
         <label for="value">TOA:</label>
         <input class="form-control" id="TOA" name="toa" type="date" value="<?php echo $act_detail->TOA; ?>">
      </div>
   </div>
   <div class="form-group col-md-4 col-xs-12 col-sm-6">
      <div class="form-group">
         <label for="debit_acc">TK nợ:</label>
         <select class="form-control" name="debit_acc" id="debit_acc">
	         <option value="0" class="hidden">(Lựa chọn)</option>
            <?php foreach ($act_system as $one): ?>
               <option value="<?php echo $one->number; ?>" <?php if ($one->number == $act_detail->debit_acc) echo "selected"; ?>><?php echo $one->number . " : " . $one->description; ?></option>
            <?php endforeach; ?>
			</select>
      </div>
      <div class="form-group">
         <label for="credit_acc">TK có:</label>
         <select class="form-control" name="credit_acc" id="credit_acc">
	         <option value="0" class="hidden">(Lựa chọn)</option>
            <?php foreach ($act_system as $one): ?>
               <option value="<?php echo $one->number; ?>" <?php if ($one->number == $act_detail->credit_acc) echo "selected"; ?>><?php echo $one->number . " : " . $one->description; ?></option>
            <?php endforeach; ?>
			</select>
      </div>
   </div>
   <div class="clearfix"></div>
</form>
