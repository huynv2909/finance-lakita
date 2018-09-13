<?php if (isset($accounting_entries) && $accounting_entries): ?>
   <?php foreach ($accounting_entries as $item): ?>
   <div class="row bd">
      <div class="col-md-4">
         <table class="table table-hover more">
            <tbody>
               <tr>
                  <td class="text-right"><strong>TOA:</strong></td>
                  <td><?php echo $item->TOA; ?></td>
               </tr>
               <tr>
                  <td class="text-center" colspan="2">
                     <?php if (!$item->completed): ?>
                        <a href="<?php echo $this->routes['distribution_create'] . '?act_id=' . $item->id; ?>" title="Đến phân bổ"><i class="fa fa-fw warning" aria-hidden="true" title="Đến phân bổ"></i></a>
                     <?php endif; ?>
                  </td>
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
                  <td class="text-right"><strong>Nội dung:</strong></td>
                  <td><?php if (!empty($item->content)) echo $item->content; else echo '(trống)' ?></td>
               </tr>
            </tbody>
         </table>
      </div>
      <div class="col-md-4">
         <table class="table table-hover more">
            <tbody>
               <tr>
                  <td class="text-right"><strong>TK nợ:</strong></td>
                  <td><?php echo $item->debit_acc; ?></td>
               </tr>
               <tr>
                  <td class="text-right"><strong>TK có:</strong></td>
                  <td><?php echo $item->credit_acc; ?></td>
               </tr>
            </tbody>
         </table>
      </div>
   </div>
   <hr>
   <?php endforeach; ?>
<?php else: ?>
   <h4 class="text-center">(Chưa có bút toán)</h4>
   <h5 class="text-center"><a href="<?php echo $this->routes['accountingentry_create'] . '?voucher_id=' . $voucher->id; ?>">Cập nhật bút toán<i class="fa fa-fw" aria-hidden="true" title="Cập nhật bút toán"></i></a></h5>
<?php endif; ?>
