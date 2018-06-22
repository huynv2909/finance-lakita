<?php if (isset($act_type) && !empty($act_type)) { ?>
<div class="act-item" id="act-item-<?php echo $act_type->id; ?>">
   <table>
      <tr>
         <td class="rm-col">
            <i class="fa fa-fw rm-icon" data-id="<?php echo $act_type->id; ?>" aria-hidden="true" title="Loại bỏ"></i>
         </td>
         <td class="name-col">
            <?php if ($act_type->income == 1): ?>
               <div class="in-div">
                  Thu
               </div>
            <?php else: ?>
               <div class="out-div">
                  Chi
               </div>
            <?php endif; ?>

            <span title="<?php echo $act_type->note; ?>"><?php echo $act_type->description; ?></span>
         </td>
         <td class="default-col">
            <span title="Tỉ lệ mặc định">
               <?php
                  echo format_default_value($act_type->default_value);
                ?>
            </span>
         </td>
      </tr>
   </table>
</div>
<?php } ?>
