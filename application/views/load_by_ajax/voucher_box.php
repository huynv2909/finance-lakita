<?php if (isset($info) && $info): ?>
   <div class="col-xs-12 col-md-4 pull-right">
      <table class="date-col">
         <colgroup class="row-50-50">
             <col>
             <col>
         </colgroup>
         <tr>
            <td>Ngày tạo:</td>
            <td><?php echo $info->date; ?></td>
         </tr>
         <tr>
            <td>Ngày Phát sinh (TOT):</td>
            <td><?php echo $info->TOT; ?></td>
         </tr>
         <tr>
            <td>Ngày thực hiện (TOA):</td>
            <td><?php if ($info->TOA == '0000-00-00') {
               echo '(Trống)';
            } else {
               echo $info->TOA;
            } ?></td>
         </tr>
         <tr>
            <td>Người lập:</td>
            <td><?php
               foreach ($employees as $employee) {
                  if ($employee->id == $info->owner) {
                     echo $employee->name;
                     break;
                  }
               }
             ?></td>
         </tr>
         <tr>
            <td>Loại:</td>
            <td><?php
               if ($info->income) {
                  echo "Phiếu thu";
               } else {
                  echo "Phiếu chi";
               }
             ?></td>
         </tr>
      </table>
   </div>
   <div class="col-xs-12 col-md-8 pull-left">
      <div class="row">
         <div class="col-md-6">
            <table>
               <colgroup class="row-50-50">
                   <col>
                   <col>
               </colgroup>
               <tbody>
                  <tr>
                     <td>ID:</td>
                     <td><?php echo $info->code; ?></td>
                  </tr>
               </tbody>
            </table>
         </div>
         <div class="col-md-6">
            <table>
               <colgroup class="row-50-50">
                   <col>
                   <col>
               </colgroup>
               <tbody>
                  <tr>
                     <td>Mã CT:</td>
                     <td><?php
                        if (trim($info->code_real != '')) {
                           echo $info->code_real;
                        } else {
                           echo "(Trống)";
                        }
                     ?></td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <div class="row">
         <table>
            <colgroup class="row-25-50">
                <col>
                <col>
            </colgroup>
            <tbody>
               <tr>
                  <td>Loại chứng từ:</td>
                  <td><?php
                     foreach ($types as $type) {
                        if ($type->id == $info->type_id) {
                           echo $type->name;
                           break;
                        }
                     }
                  ?></td>
               </tr>
            </tbody>
         </table>
      </div>
      <div class="row">
         <div class="col-md-6">
            <table>
               <colgroup class="row-50-50">
                   <col>
                   <col>
               </colgroup>
               <tbody>
                  <tr>
                     <td>Số tiền:</td>
                     <td><?php echo number_format($info->value, 0, ",", "."); ?> đ</td>
                  </tr>
               </tbody>
            </table>
         </div>
         <div class="col-md-6">
            <table>
               <colgroup class="row-50-50">
                   <col>
                   <col>
               </colgroup>
               <tbody>
                  <tr>
                     <td>Người giao dịch:</td>
                     <td><?php
                        foreach ($employees as $employee) {
                           if ($employee->id == $info->executor) {
                              echo $employee->name;
                              break;
                           }
                        }
                      ?></td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <div class="row">
         <table>
            <colgroup class="row-25-50">
                <col>
                <col>
            </colgroup>
            <tbody>
               <tr>
                  <td>Nội dung:</td>
                  <td><?php
                     if (trim($info->content) != '') {
                        echo $info->content;
                     } else {
                        echo "(Trống)";
                     }
                   ?></td>
               </tr>
            </tbody>
         </table>
      </div>
      <div class="row">
         <table>
            <colgroup class="row-25-50">
                <col>
                <col>
            </colgroup>
            <tbody>
               <tr>
                  <td>Ghi chú:</td>
                  <td><?php
                     if (trim($info->note) != '') {
                        echo $info->note;
                     } else {
                        echo "(Trống)";
                     }
                   ?></td>
               </tr>
            </tbody>
         </table>
      </div>
   </div>
   <div class="clearfix"></div>
<?php else: ?>
   <h2 class="empty-info">(Không có thông tin)</h2>
<?php endif; ?>
