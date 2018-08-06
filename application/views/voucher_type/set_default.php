<div class="row table-reponsive">
<form class="" method="post">
   <input type="hidden" id="list_changed" name="list_changed" value="">
   <table id="default-type-table" border="1" class="table">
      <thead>
         <tr>
            <th class="text-center" style="width: 20%;">Loại chứng từ:</th>
            <th class="text-center" style="width: 50%;">Cây phân bổ:</th>
            <th class="text-center" style="width: 15%;">TK nợ:</th>
            <th class="text-center" style="width: 15%;">TK có:</th>
         </tr>
      </thead>
      <tbody>
         <?php foreach ($types as $type): ?>
            <tr>
               <td>
                  <?php echo $type->name; ?>
                  <input type="hidden" name="changed_<?php echo $type->id; ?>" id="changed_<?php echo $type->id; ?>" value="0">
               </td>
               <td>
                  <select name="first_dimen_<?php echo $type->id; ?>" class="first_dimen" data-old="<?php echo $type->first_dimen; ?>" data-id="<?php echo $type->id; ?>">
                     <option value="0" class="hidden">(Chưa chọn)</option>
                     <?php foreach ($trees as $tree): ?>
                        <option value="<?php echo $tree['id']; ?>" <?php if ($tree['id'] == $type->first_dimen) echo 'selected'; ?>><?php echo $tree['text']; ?></option>
                     <?php endforeach; ?>
                  </select>
               </td>
               <td>
                  <select name="debit_def_<?php echo $type->id; ?>" class="debit_def" data-old="<?php echo $type->debit_def; ?>" data-id="<?php echo $type->id; ?>">
                     <option value="0" class="hidden">(Chưa chọn)</option>
                     <?php foreach ($system_acc as $act): ?>
                        <option value="<?php echo $act->number; ?>" <?php if ($act->number == $type->debit_def) echo 'selected'; ?>><?php echo $act->number . ' : ' . $act->description; ?></option>
                     <?php endforeach; ?>
                  </select>
               </td>
               <td>
                  <select name="credit_def_<?php echo $type->id; ?>" class="credit_def" data-old="<?php echo $type->credit_def; ?>" data-id="<?php echo $type->id; ?>">
                     <option value="0" class="hidden">(Chưa chọn)</option>
                     <?php foreach ($system_acc as $act): ?>
                        <option value="<?php echo $act->number; ?>" <?php if ($act->number == $type->credit_def) echo 'selected'; ?>><?php echo $act->number . ' : ' . $act->description; ?></option>
                     <?php endforeach; ?>
                  </select>
               </td>
            </tr>
         <?php endforeach; ?>
      </tbody>
   </table>
   <input type="submit" name="update" id="save_changed" value="Lưu lại" class="btn btn-success" disabled>
</form>
</div>
