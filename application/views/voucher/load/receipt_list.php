<?php if (isset($receipt_types) && !empty($receipt_types)): ?>
   <?php foreach ($receipt_types as $type): ?>
      <div class="receipt-item" data-active_ori="<?php echo ($type->active)?'on':'off'; ?>" data-id="<?php echo $type->id; ?>" data-chosen="0">
         <?php if ($type->income == 1): ?>
            <div class="in-div">
               Thu
            </div>
         <?php else: ?>
            <div class="out-div">
               Chi
            </div>
         <?php endif; ?>
         <span class="name-receipt click-hide" title="<?php echo $type->code; ?>"><?php echo $type->name; ?></span>
         <input type="text" class="edit-name-box click-show" id="txt-edit-name-<?php echo $type->id; ?>" value="<?php echo $type->name; ?>">
         <button type="button" class="btn btn-info btn-circle click-show save-name" data-id="<?php echo $type->id; ?>" data-url="<?php echo base_url('Receipt/update_name'); ?>" data-name_ori="<?php echo $type->name; ?>" title="Lưu lại"><i class="fa fa-check"></i></button>
         <button type="button" class="btn btn-danger btn-circle click-show delete-type" data-id="<?php echo $type->id; ?>" data-url="<?php echo base_url('Receipt/delete_type'); ?>" title="Xóa"><i class="fa fa-times"></i></button>
         <label class="switch click-hide">
          <input type="checkbox" class="active-check"
               <?php
                  if ($type->active) {
                     echo "checked";
                  }
                  else {
                     echo 'value="off"';
                  }
               ?>
          >
          <span class="slider round">
             <span class="status-text" title="Status">Active</span>
          </span>
         </label>
         <i class="fa fa-fw pull-right edit-icon click-hide" aria-hidden="true" title="Chỉnh sửa"></i>
         <div class="clearfix"></div>
      </div>
   <?php endforeach; ?>
<?php endif; ?>
