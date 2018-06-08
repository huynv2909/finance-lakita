<div class="col-md-4">
   <div class="form-group">
       <label for="value-<?php if (isset($sequence)) echo $sequence; ?>" class="col-sm-3 control-label"><span class="text-danger">(*)</span> Số tiền</label>
       <div class="col-sm-9">
            <input onkeyup="oneDot(this)" data-default="<?php
               if (isset($info_tr) && !empty($info_tr->default_value)) {
                  $val = explode('/', str_replace(array("m", "k"), array(M, k), $info_tr->default_value)); echo str_replace(array("m", "k"), array(M, k), $info_tr->default_value); }
            ?>" type="text" name="value-<?php if (isset($sequence)) echo $sequence; ?>" class="form-control value">
            <div class="text-danger"></div>
       </div>
   </div>
</div>
