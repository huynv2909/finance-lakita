<div class="container-fluid">
<?php if (count($vc_news) > 0): ?>
   <div class="row">
      <h4 class="pull-left">Hệ thống còn <span id="remaining"><?php echo count($vc_news); ?></span> chứng từ cần xét duyệt</h4>
      <?php if ($this->input->get()): ?>
         <i class="fa fa-fw fa-2x pull-right slide-filter" data-hidden="0" aria-hidden="true" title="Hide"></i>
      <?php else: ?>
         <i class="fa fa-fw fa-2x pull-right slide-filter" data-hidden="1" aria-hidden="true" title="Lọc"></i>
      <?php endif; ?>
   </div>
   <div class="clearfix"></div>
   <input type="hidden" name="action" id="action-index" value="1">
   <input type="hidden" name="allowed" id="allowed-check" value="0">
     <table class="table" id="new-vouchers">
       <thead>
         <tr>
           <th class="col-xs-9 col-md-10 text-center">Thông tin</th>
           <th class="col-xs-3 col-md-2 text-center">
              <input type="button" class="btn btn-success approve-multiple" value="Duyệt hết">
              <input type="button" class="btn btn-danger deny-multiple" value="Xóa hết">
              <input type="button" class="btn btn-success confirm-action" value="Xác nhận">
              <input type="button" class="btn btn-danger cancel-action" value="Hủy">
           </th>
         </tr>
       </thead>
       <tbody>
          <?php $i = 0; ?>
          <?php foreach ($vc_news as $vc): ?>
             <?php $i++; ?>
         <tr id="row-<?php echo $vc->id; ?>" style="background-color: <?php if ($i % 2 == 0) echo 'cornsilk'; else echo 'antiquewhite'; ?>;" >
            <td>
               <div class="row">
                  <div class="col-md-4">
                     <select class="info-100" id="type_<?php echo $vc->id; ?>" name="type_<?php echo $vc->id; ?>">
                        <?php foreach ($types as $type): ?>
                           <option value="<?php echo $type->id; ?>" <?php if ($type->id == $vc->type_id) echo "selected"; ?>><?php echo $type->name; ?></option>
                        <?php endforeach; ?>
                     </select>
                     <textarea id="content_<?php echo $vc->id; ?>" name="content_<?php echo $vc->id; ?>" rows="3" class="info-100"><?php echo $vc->content; ?></textarea>
                  </div>
                  <div class="col-md-4">
                     <input class="info-30" type="text" id="value_<?php echo $vc->id; ?>" name="value_<?php echo $vc->id; ?>" value="<?php echo number_format($vc->value, 0, ",", ".") ?>">
                     <input class="info-70" type="date" id="tot_<?php echo $vc->id; ?>" name="tot_<?php echo $vc->id; ?>" value="<?php echo $vc->TOT; ?>">

                     <select class="info-100" id="executor_<?php echo $vc->id; ?>" name="executor_<?php echo $vc->id; ?>">
                        <?php foreach ($users as $user): ?>
                           <option value="<?php echo $user->id; ?>" <?php if ($user->id == 6) echo "selected"; ?>><?php echo $user->name; ?></option>
                        <?php endforeach; ?>
                     </select>
                  </div>
                  <div class="col-md-4">
                     <select class="info-100 method" id="method_<?php echo $vc->id; ?>" name="method_<?php echo $vc->id; ?>" data-id="<?php echo $vc->id; ?>" data-url="<?php echo $this->routes['provider_listbymethodid']; ?>">
                        <?php foreach ($methods as $method): ?>
                           <option value="<?php echo $method->id; ?>" <?php if ($method->id == $vc->method) echo "selected"; ?>><?php echo $method->name; ?></option>
                        <?php endforeach; ?>
                     </select>
                     <select class="info-100" id="provider_<?php echo $vc->id; ?>" name="provider_<?php echo $vc->id; ?>">
                        <?php foreach ($providers as $provider): ?>
                           <option value="<?php echo $provider->id; ?>" <?php if ($provider->id == $vc->provider) echo "selected"; ?>><?php echo $provider->name; ?></option>
                        <?php endforeach; ?>
                     </select>
                     <p>Tự động phân bổ: <input type="checkbox" id="auto_<?php echo $vc->id; ?>" name="auto_<?php echo $vc->id; ?>" value="" checked></p>

                  </div>
               </div>
               <input type="hidden" name="choosen_<?php echo $vc->id; ?>" value="1">

            </td>
            <td class="text-center">
               <button type="button" class="btn btn-info btn-circle approve" id="approve_<?php echo $vc->id; ?>" data-id="<?php echo $vc->id; ?>" title="Duyệt"><i class="fa fa-check"></i></button>
               <button type="button" class="btn btn-warning btn-circle deny" id="deny_<?php echo $vc->id; ?>" data-id="<?php echo $vc->id; ?>" title="Xóa"><i class="fa fa-times"></i></button>
               <input type="checkbox" class="choose_check" name="chosen" value="" data-id="<?php echo $vc->id; ?>" checked>
            </td>
         </tr>
         <?php endforeach; ?>
       </tbody>
     </table>

   <input type="hidden" id="url-approve-one" value="<?php echo $this->routes['voucher_approveone2']; ?>">
   <input type="hidden" id="url-deny-one" value="<?php echo $this->routes['voucher_denyone']; ?>">
<?php else: ?>
   <h3 class="text-center">Các chứng từ đã được duyệt hết!</h3>
<?php endif; ?>
</div>
