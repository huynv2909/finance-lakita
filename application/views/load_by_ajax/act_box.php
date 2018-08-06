<?php if (isset($info) && $info): ?>
   <div class="col-md-4">
      <div class="row">
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
      <div class="row">
         <table>
            <colgroup class="row-50-50">
                <col>
                <col>
            </colgroup>
            <tbody>
               <tr>
                  <td>Nội dung:</td>
                  <td><?php echo $info->content; ?> </td>
               </tr>
            </tbody>
         </table>
      </div>
   </div>
   <div class="col-md-4">
      <div class="row">
         <table>
            <colgroup class="row-50-50">
                <col>
                <col>
            </colgroup>
            <tbody>
               <tr>
                  <td>TK nợ:</td>
                  <td><?php echo $info->debit_acc; ?></td>
               </tr>
            </tbody>
         </table>
      </div>
      <div class="row">
         <table>
            <colgroup class="row-50-50">
                <col>
                <col>
            </colgroup>
            <tbody>
               <tr>
                  <td>TK co:</td>
                  <td><?php echo $info->credit_acc; ?></td>
               </tr>
            </tbody>
         </table>
      </div>
   </div>
   <div class="col-md-4">
      <div class="row">
         <table>
            <colgroup class="row-50-50">
                <col>
                <col>
            </colgroup>
            <tbody>
               <tr>
                  <td>Ngày Phát sinh (TOT):</td>
                  <td><?php echo $info->TOT; ?></td>
               </tr>
            </tbody>
         </table>
      </div>
      <div class="row">
         <table>
            <colgroup class="row-50-50">
                <col>
                <col>
            </colgroup>
            <tbody>
               <tr>
                  <td>Ngày thực hiện (TOA):</td>
                  <td><?php echo $info->TOA; ?></td>
               </tr>
            </tbody>
         </table>
      </div>
   </div>
   <div class="clearfix"></div>
<?php else: ?>
   <h2 class="empty-info">(Không có thông tin)</h2>
<?php endif; ?>
