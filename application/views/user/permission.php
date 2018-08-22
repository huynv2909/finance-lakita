<form method="post">
   <?php foreach ($roles as $role): ?>
      <div class="row role-area">
         <div class="row">
            <h4 class="text-center"><?php echo $role->role; ?></h4>
         </div>
         <?php foreach ($operations as $group => $operation): ?>
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2">
               <table class="table-custom">
                  <colgroup class=col-set-width>
                     <col>
                     <col>
                  </colgroup>
                  <tr>
                     <td colspan="2" class="text-center"><strong><?php echo $group; ?></strong></td>
                  </tr>
                  <?php foreach ($operation as $action): ?>
                     <tr>
                        <td><?php echo $action['description']; ?></td>
                        <td class="text-center"><input type="checkbox" class="check_permission" name="<?php echo $action['name'] . "_" . $role->id; ?>" value="<?php echo $action['name']; ?>" data-id="<?php echo $role->id; ?>" <?php if (in_array($action['name'], $role->permission)) echo 'checked'; ?> /></td>
                     </tr>
                  <?php endforeach; ?>
               </table>
            </div>
         <?php endforeach; ?>
      </div>
   <?php endforeach; ?>

   <input type="hidden" name="have_changed" id="have_changed" value="">

   <input type="submit" name="ok" value="Lưu thay đổi" class="btn btn-success pull-right" id="update-btn" disabled>
   <div class="clearfix"></div>
</form>
