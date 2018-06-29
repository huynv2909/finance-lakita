<h5>
   Bút toán <?php echo $sequence; ?>
   <select class="form-control income" name="income-<?php echo $sequence; ?>"
      <?php
         if (isset($info_tr) && $info_tr->income == 1) echo 'style="background-color: #9aeaa8"';
         else echo 'style="background-color: #fdd600"';
       ?>
       >
       <?php if (isset($info_tr)) { ?>
         <option value="0" <?php if ($info_tr->income == 0) echo 'selected'; ?>>Chi</option>
         <option value="1" <?php if ($info_tr->income == 1) echo 'selected'; ?>>Thu</option>
      <?php } else { ?>
         <option value="0" selected >Chi</option>
      <?php } ?>
   </select>
</h5>
