<?php foreach ($accounting_entries as $item): ?>
<div class="row bd">
   <div class="col-md-4">
      <table class="table table-hover more">
         <tbody>
            <tr>
               <td class="text-right"><strong>TOT:</strong></td>
               <td><?php echo $item->TOT; ?></td>
            </tr>
            <tr>
               <td class="text-right"><strong>TOA:</strong></td>
               <td><?php echo $item->TOA; ?></td>
            </tr>
         </tbody>
      </table>
   </div>
   <div class="col-md-4">
      <table class="table table-hover more">
         <tbody>
            <tr>
               <td class="text-right"><strong>Giá trị:</strong></td>
               <td><?php echo number_format($item->value, 0, ",", "."); ?></td>
            </tr>
            <tr>
               <td class="text-right"><strong>Ghi chú:</strong></td>
               <td><?php if (!empty($item->note)) echo $item->note; else echo '(trống)' ?></td>
            </tr>
         </tbody>
      </table>
   </div>
   <div class="col-md-4">
      <table class="table table-hover more">
         <tbody>
            <tr>
               <td class="text-right"><strong>TK nợ:</strong></td>
               <td><?php echo $item->TK_no; ?></td>
            </tr>
            <tr>
               <td class="text-right"><strong>TK có:</strong></td>
               <td><?php echo $item->TK_co; ?></td>
            </tr>
            <tr>
               <td colspan="2" class="text-center">
                  <?php if ($item->income == 1): ?>
                     <div class="in-div">
                        Thu
                     </div>
                  <?php else: ?>
                     <div class="out-div">
                        Chi
                     </div>
                  <?php endif; ?>
               </td>
            </tr>
         </tbody>
      </table>
   </div>
</div>
<hr>
<?php endforeach; ?>
