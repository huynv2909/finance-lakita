<div class="container-fluid">
   <div class="filter-box" <?php if (!$this->input->get()): ?>
      style="display: none";
   <?php endif; ?>>
      <div class="col-md-4 col-lg-3">
         <p class="text-center">Phương thức:</p>
         <select id="fil-method" class="form-control filter-field" name=""
         <?php if (null !== $this->input->get('method')): ?>
            style="background-color: antiquewhite;"
         <?php endif; ?>
         >
            <option value="0" class="hidden">(Lựa chọn)</option>
            <?php foreach ($methods as $item): ?>
               <option value="<?php echo $item->id; ?>" <?php if ($item->id == $this->input->get('method')) echo 'selected'; ?> ><?php echo $item->name . " : " . $item->description; ?></option>
            <?php endforeach ?>
         </select>
      </div>
      <div class="col-md-4 col-lg-3">
         <p class="text-center">Qua:</p>
         <select id="fil-provider" class="form-control filter-field" name=""
         <?php if (null !== $this->input->get('provider')): ?>
            style="background-color: antiquewhite;"
         <?php endif; ?>
         >
            <option value="0" class="hidden">(Lựa chọn)</option>
            <?php foreach ($providers as $item): ?>
               <option value="<?php echo $item->id; ?>" <?php if ($item->id == $this->input->get('provider')) echo 'selected'; ?> ><?php echo $item->name . " : " . $item->description; ?></option>
            <?php endforeach ?>
         </select>
      </div>
      <div class="col-md-4 col-lg-3">
         <p class="text-center">Loại chứng từ:</p>
         <select id="fil-voucher_type" class="form-control filter-field" name=""
         <?php if (null !== $this->input->get('voucher_type')): ?>
            style="background-color: antiquewhite;"
         <?php endif; ?>
         >
            <option value="0" class="hidden">(Lựa chọn)</option>
            <?php foreach ($types as $item): ?>
               <option value="<?php echo $item->id; ?>" <?php if ($item->id == $this->input->get('voucher_type')) echo 'selected'; ?> ><?php echo $item->code . " (" . $item->name . ")"; ?></option>
            <?php endforeach ?>
         </select>
      </div>
      <div class="col-md-4 col-lg-3">
         <button type="button" name="button" class="btn btn-success" id="lets-filter"><i class="fa fa-fw" aria-hidden="true" title="Lọc ngay"></i> Lọc ngay</button>
         <a id="reset-filter-link" href="<?php echo $this->routes['voucher_approve']; ?>" class="text-center" style="display: inherit;"><i class="fa fa-fw" aria-hidden="true" title="Bỏ lọc"></i> Bỏ lọc</a>
      </div>
      <div class="clearfix"></div>
   </div>

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
   <form action="" method="post">
     <table class="table" id="new-vouchers">
       <thead>
         <tr>
           <th class="col-xs-9 col-md-10 text-center">Thông tin</th>
           <th class="col-xs-3 col-md-2 text-center">
              <input type="submit" class="btn btn-success" value="Duyệt hết">
              <input type="submit" class="btn btn-danger" value="Xóa hết">
              <input type="hidden" name="action" id="action" value="1">
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
                     <select class="info-100" id="course_<?php echo $vc->id; ?>" name="course_<?php echo $vc->id; ?>">
                        <option value="0">(Lựa chọn)</option>
                        <?php $parts = explode('-', $vc->content); $course_name = $parts[5]; ?>
                        <?php foreach ($courses as $course): ?>
                           <option value="<?php echo $course->id; ?>" <?php if ($course->name == $course_name) echo "selected"; ?>><?php echo $course->name; ?></option>
                        <?php endforeach; ?>
                     </select>
                  </div>
                  <div class="col-md-4">
                     <input class="info-30" type="text" id="value_<?php echo $vc->id; ?>" name="value_<?php echo $vc->id; ?>" value="<?php echo number_format($vc->value, 0, ",", ".") ?>">
                     <input class="info-70" type="date" id="tot_<?php echo $vc->id; ?>" name="tot_<?php echo $vc->id; ?>" value="<?php echo $vc->TOT; ?>">

                     <span>VAT: <input type="checkbox" class="have-vat" data-id="<?php echo $vc->id; ?>" id="vat_<?php echo $vc->id; ?>" name="vat_<?php echo $vc->id; ?>" value=""></span>
                     <input class="info-25" type="number" id="vat_value_<?php echo $vc->id; ?>" name="vat_value_<?php echo $vc->id; ?>" min="0" value="<?php echo round($vc->value/11); ?>" disabled>

                     <span>COD: <input type="checkbox" class="have-cod" data-id="<?php echo $vc->id; ?>" id="cod_<?php echo $vc->id; ?>" name="cod_<?php echo $vc->id; ?>" value=""></span>
                     <input class="info-25" type="number" id="cod_value_<?php echo $vc->id; ?>" name="cod_value_<?php echo $vc->id; ?>" min="0" value="30000" disabled>

                     <select class="info-100" id="executor_<?php echo $vc->id; ?>" name="executor_<?php echo $vc->id; ?>">
                        <?php foreach ($users as $user): ?>
                           <option value="<?php echo $user->id; ?>" <?php if ($user->id == 6) echo "selected"; ?>><?php echo $user->name; ?></option>
                        <?php endforeach; ?>
                     </select>
                  </div>
                  <div class="col-md-4">
                     <select class="info-100" id="method_<?php echo $vc->id; ?>" name="method_<?php echo $vc->id; ?>">
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

                     <span title="<?php echo $vc->crm_note; ?>">Ghi chú từ CRM</span>

                  </div>
               </div>
               <input type="hidden" name="choosen_<?php echo $vc->id; ?>" value="1">

            </td>
            <td class="text-center">
               <button type="button" class="btn btn-info btn-circle approve" data-id="<?php echo $vc->id; ?>" title="Duyệt"><i class="fa fa-check"></i></button>
               <button type="button" class="btn btn-warning btn-circle deny" data-id="<?php echo $vc->id; ?>" title="Xóa"><i class="fa fa-times"></i></button>
            </td>
         </tr>
         <?php endforeach; ?>
       </tbody>
     </table>
   </form>

   <input type="hidden" id="url-approve-one" value="<?php echo $this->routes['voucher_approveone']; ?>">
   <input type="hidden" id="url-deny-one" value="<?php echo $this->routes['voucher_denyone']; ?>">
<?php else: ?>
   <h3 class="text-center">Các chứng từ đã được duyệt hết!</h3>
<?php endif; ?>
</div>
