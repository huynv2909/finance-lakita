<form class="" method="post">
   <div class="row">
      <div class="col-md-6">
         <table>
            <?php if (isset($configs_db) && $configs_db): ?>
            <?php foreach ($configs_db as $item): ?>
               <tr>
                  <td><label for="<?php echo $item->name; ?>"><?php echo $item->description; ?></label></td>
                  <td>
                     <input type="checkbox" class="margin-left-15 value" name="config_<?php echo $item->id; ?>" data-id="<?php echo $item->id; ?>" id="<?php echo $item->name; ?>" data-old="<?php echo $item->value; ?>" value="1" <?php if ($item->value == 1) echo 'checked'; ?>>
                     <input type="hidden" id="changed_<?php echo $item->id; ?>" value="0">
                  </td>
               </tr>
            <?php endforeach; ?>
            <?php endif; ?>
         </table>
      </div>
      <div class="col-md-6">
         <table>
            <?php if (isset($defaults_db) && $defaults_db): ?>
            <?php foreach ($defaults_db as $item): ?>
               <tr>
                  <td><label for="<?php echo $item->name; ?>"><?php echo $item->description; ?></label></td>
                  <td>
                     <input type="text" class="margin-left-15 padding-left-10 value" name="config_<?php echo $item->id; ?>" id="<?php echo $item->name; ?>" data-id="<?php echo $item->id; ?>" id="<?php echo $item->name; ?>" data-old="<?php echo $item->value; ?>" value="<?php echo $item->value; ?>"> VND
                     <input type="hidden" id="changed_<?php echo $item->id; ?>" value="0">
                  </td>
               </tr>
            <?php endforeach; ?>
            <?php endif; ?>
         </table>
      </div>
   </div>
   <input type="hidden" id="list_changed" name="have_changed" value="">
   <input type="submit" class="btn btn-success" name="ok" value="Thay đổi" id="save_changed">
</form>
