<div class="col-md-4">
   <div class="form-group">
       <label for="note-<?php if (isset($sequence)) echo $sequence; ?>" class="col-sm-3 control-label">Ghi chú</label>
       <div class="col-sm-9">
         <textarea name="note-<?php if (isset($sequence)) echo $sequence; ?>" class="form-control note"><?php if (isset($info_tr)) echo trim($info_tr->description) . ": " . trim($info_tr->note); ?></textarea>
       </div>
   </div>
</div>
