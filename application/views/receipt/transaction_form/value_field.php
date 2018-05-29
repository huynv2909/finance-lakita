<div class="col-md-4">
   <div class="form-group">
       <label for="value-<?php if (isset($type_tr)) echo $type_tr; ?>" class="col-sm-3 control-label"><span class="text-danger">(*)</span> Số tiền</label>
       <div class="col-sm-9">
            <input onkeyup="oneDot(this)" data-default="<?php echo $info_tr->default_value; ?>" type="text" name="value-<?php if (isset($type_tr)) echo $type_tr; ?>" class="form-control value">
            <div class="text-danger"></div>
       </div>
   </div>
</div>
