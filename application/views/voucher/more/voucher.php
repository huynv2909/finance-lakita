<h4 class="text-center"><strong>Chứng từ</strong></h4>
<div class="row bd">
   <div class="col-md-4">
      <table class="table table-hover more">
         <tbody>
            <tr>
               <td class="text-right"><strong>Mã chứng từ:</strong></td>
               <td><a href="<?php echo $this->routes['accountingentry_index'] . '?code=' . $voucher->code; ?>"><?php echo $voucher->code; ?></a></td>
            </tr>
            <tr>
               <td class="text-right"><strong>Mã thực tế:</strong></td>
               <td><?php if (!empty($voucher->code_real)) echo $voucher->code_real; else echo '(trống)' ?></td>
            </tr>
            <tr>
               <td class="text-right"><strong>Loại chứng từ:</strong></td>
               <td>
                  <?php
                    foreach ($voucher_types as $type) {
                       if ($voucher->type_id == $type->id) {
                          echo $type->name;
                          break;
                       }
                    }
                  ?>
               </td>
            </tr>
            <tr>
               <td class="text-right"><strong>TOT:</strong></td>
               <td><?php echo $voucher->TOT; ?></td>
            </tr>
            <tr>
               <td class="text-right"><strong>TOA:</strong></td>
               <td><?php if ($voucher->TOA == '0000-00-00') {
                  echo '(Trống)';
               } else {
                  echo $voucher->TOA;
               }  ?></td>
            </tr>
         </tbody>
      </table>
   </div>
   <div class="col-md-4">
      <table class="table table-hover more">
         <tbody>
            <tr>
               <td class="text-right"><strong>Giá trị:</strong></td>
               <td><?php echo number_format($voucher->value, 0, ",", "."); ?> đ</td>
            </tr>
            <tr>
               <td class="text-right"><strong>Nội dung:</strong></td>
               <td><?php echo $voucher->content; ?></td>
            </tr>
            <tr>
               <td class="text-right"><strong>Người giao dịch:</strong></td>
               <td>
                  <?php
                    foreach ($users as $user) {
                       if ($voucher->executor == $user->id) {
                          echo $user->name;
                          break;
                       }
                    }
                  ?>
               </td>
            </tr>
            <tr>
               <td class="text-right"><strong>Hình thức:</strong></td>
               <td>
                  <?php
                    foreach ($methods as $method) {
                       if ($voucher->method == $method->id) {
                          echo $method->name;
                          break;
                       }
                    }
                  ?>
               </td>
            </tr>
            <tr>
               <td class="text-right"><strong>Thông qua:</strong></td>
               <td>
                  <?php
                    foreach ($providers as $provider) {
                       if ($voucher->provider == $provider->id) {
                          echo $provider->name;
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
               <td><?php echo $voucher->date; ?></td>
            </tr>
            <tr>
               <td class="text-right"><strong>Người lập:</strong></td>
               <td>
                  <?php
                    foreach ($users as $user) {
                       if ($voucher->owner == $user->id) {
                          echo $user->name;
                          break;
                       }
                    }
                  ?>
               </td>
            </tr>
            <tr>
               <td class="text-right"><strong>Ghi chú:</strong></td>
               <td><?php if (!empty($voucher->note)) echo $voucher->note; else echo '(trống)' ?></td>
            </tr>
            <tr>
               <td class="text-right"><strong>Loại:</strong></td>
               <td>
                  <?php
                     if ($voucher->income == 1) {
                        echo 'Phiếu thu';
                     }
                     else {
                        echo 'Phiếu chi';
                     }
                  ?>
               </td>
            </tr>
            <tr>
               <td colspan="2" class="text-center">
                  <?php if (!$voucher->completed): ?>
                     <a href="<?php echo $this->routes['accountingentry_create'] . '?voucher_id=' . $voucher->id; ?>" title="Đến nhập bút toán"><i class="fa fa-fw warning" aria-hidden="true" title="Đến nhập bút toán"></i> Chia bút toán</a>
                  <?php endif; ?>
               </td>
            </tr>
         </tbody>
      </table>
   </div>
</div>
<hr>
<h4 class="text-center"><strong>Bút toán tương ứng</strong></h4>
