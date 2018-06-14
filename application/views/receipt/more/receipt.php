<h4 class="text-center">Chứng từ</h4>
<div class="row bd">
   <div class="col-md-4">
      <table class="table table-hover more">
         <tbody>
            <tr>
               <td class="text-right"><strong>Mã chứng từ:</strong></td>
               <td><?php echo $receipt->code; ?></td>
            </tr>
            <tr>
               <td class="text-right"><strong>Mã thực tế:</strong></td>
               <td><?php if (!empty($receipt->code_real)) echo $receipt->code_real; else echo '(trống)' ?></td>
            </tr>
            <tr>
               <td class="text-right"><strong>Loại chứng từ:</strong></td>
               <td>
                  <?php
                    foreach ($receipt_types as $type) {
                       if ($receipt->type_id == $type->id) {
                          echo $type->name;
                          break;
                       }
                    }
                  ?>
               </td>
            </tr>
            <tr>
               <td class="text-right"><strong>TOT:</strong></td>
               <td><?php echo $receipt->TOT; ?></td>
            </tr>
            <tr>
               <td class="text-right"><strong>TOA:</strong></td>
               <td><?php echo $receipt->TOA; ?></td>
            </tr>
         </tbody>
      </table>
   </div>
   <div class="col-md-4">
      <table class="table table-hover more">
         <tbody>
            <tr>
               <td class="text-right"><strong>Giá trị:</strong></td>
               <td><?php echo number_format($receipt->value, 0, ",", "."); ?></td>
            </tr>
            <tr>
               <td class="text-right"><strong>Nội dung:</strong></td>
               <td><?php echo $receipt->content; ?></td>
            </tr>
            <tr>
               <td class="text-right"><strong>Người giao dịch:</strong></td>
               <td>
                  <?php
                    foreach ($users as $user) {
                       if ($receipt->executor == $user->id) {
                          echo $user->name;
                          break;
                       }
                    }
                  ?>
               </td>
            </tr>
         </tbody>
      </table>
   </div>
   <div class="col-md-4">
      <table class="table table-hover more">
         <tbody>
            <tr>
               <td class="text-right"><strong>Ngày lập:</strong></td>
               <td><?php echo $receipt->date; ?></td>
            </tr>
            <tr>
               <td class="text-right"><strong>Người lập:</strong></td>
               <td>
                  <?php
                    foreach ($users as $user) {
                       if ($receipt->owner == $user->id) {
                          echo $user->name;
                          break;
                       }
                    }
                  ?>
               </td>
            </tr>
            <tr>
               <td class="text-right"><strong>Ghi chú:</strong></td>
               <td><?php if (!empty($receipt->note)) echo $receipt->note; else echo '(trống)' ?></td>
            </tr>
            <tr>
               <td class="text-right"><strong>Loại:</strong></td>
               <td>
                  <?php
                     if ($receipt->income == 1) {
                        echo 'Phiếu thu';
                     }
                     else {
                        echo 'Phiếu chi';
                     }
                  ?>
               </td>
            </tr>
         </tbody>
      </table>
   </div>
</div>
<hr>
<h4 class="text-center">Bút toán tương ứng</h4>
