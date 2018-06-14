<h5>
   Bút toán <?php echo $sequence; ?>
   <select class="form-control income" name="income-<?php echo $sequence; ?>"
      <?php
         if ($info_tr->income == 0) echo 'style="background-color: #fdd600"';
         else echo 'style="background-color: #9aeaa8"';
       ?>
       >
      <option value="0" <?php if ($info_tr->income == 0) echo 'selected'; ?>>Chi</option>
      <option value="1" <?php if ($info_tr->income == 1) echo 'selected'; ?>>Thu</option>
   </select>
</h5>
