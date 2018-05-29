<div class="col-md-4">
   <div class="form-group">
       <label for="tot-<?php if (isset($type_tr)) echo $type_tr; ?>" class="col-sm-3 control-label" title="Ngày phát sinh giao dịch"><span class="text-danger">(*)</span> TOT</label>
       <div class="col-sm-9">
         <input type="date" class="form-control tot" name="tot-<?php if (isset($type_tr)) echo $type_tr; ?>" max="<?php echo date('Y-m-d'); ?>">
         <div class="text-danger"></div>
       </div>
   </div>
   <div class="form-group">
       <label for="toa-<?php if (isset($type_tr)) echo $type_tr; ?>" class="col-sm-3 control-label" title="Ngày thực hiện giao dịch"><span class="text-danger">(*)</span> TOA</label>
       <div class="col-sm-9">
         <input type="date" class="form-control toa" name="toa-<?php if (isset($type_tr)) echo $type_tr; ?>" max="<?php echo date('Y-m-d'); ?>">
         <div class="text-danger"></div>
       </div>
   </div>
</div>
