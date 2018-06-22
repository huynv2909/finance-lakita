<div class="panel panel-default">
    <!-- /.panel-heading -->
    <div class="panel-body">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#recreipt-tab" data-toggle="tab" aria-expanded="true">Các loại chứng từ</a>
            </li>
            <li class=""><a href="#accounting-entry-list" data-toggle="tab" aria-expanded="false">Bút toán</a>
            </li>
        </ul>
        <!-- Some data hidden -->
        <input type="hidden" name="url-ajax" id="url-ajax" value="<?php echo base_url('Receipt/load_act_type'); ?>">

        <!-- Tab panes -->
        <div class="tab-content pos-rel">
            <div role="tabpanel"  class="tab-pane fade active in" id="recreipt-tab">
                  <div class="panel panel-primary" id="panel-receipt">
                     <div class="panel-heading">
                        <h3 class="panel-title text-center">Chứng từ</h3>
                    </div>
                     <div class="panel-body">
                        <?php if (isset($receipt_types) && !empty($receipt_types)): ?>
                           <?php foreach ($receipt_types as $type): ?>
                              <div class="receipt-item" data-id="<?php echo $type->id; ?>" data-chosen="0">
                                 <?php if ($type->income == 1): ?>
                                    <div class="in-div">
                                       Thu
                                    </div>
                                 <?php else: ?>
                                    <div class="out-div">
                                       Chi
                                    </div>
                                 <?php endif; ?>
                                 <span class="name-receipt" title="<?php echo $type->code; ?>"><?php echo $type->name; ?></span>
                                 <label class="switch">
                                   <input type="checkbox" class="active-check"
                                       <?php
                                          if ($type->active) {
                                             echo "checked";
                                          }
                                          else {
                                             echo 'value="off"';
                                          }
                                       ?>
                                   >
                                   <span class="slider round">
                                      <span class="status-text" title="Status">Active</span>
                                   </span>
                                 </label>
                                 <i class="fa fa-fw pull-right edit-icon" aria-hidden="true" title="Chỉnh sửa"></i>
                                 <div class="clearfix"></div>
                              </div>
                           <?php endforeach; ?>
                        <?php endif; ?>
                     </div>
                    <div class="panel-footer">
                       <button type="button" class="btn btn-success pull-right" title="Lưu thay đổi" disabled>
                          <i class="fa fa-check" title="Lưu thay đổi"></i> Lưu thay đổi
                       </button>
                       <div class="clearfix"></div>
                    </div>
                  </div>

                  <div class="panel panel-info" id="panel-act">
                     <div class="panel-heading">
                        <h3 class="panel-title text-center">Bút toán tương ứng</h3>
                    </div>
                     <div class="panel-body" id="act-load">
                        <h3 class="text-center deep-note">(Hãy lựa chọn chứng từ)</h3>
                        <!-- Load by ajax -->
                     </div>
                    <div class="panel-footer">
                       <select id="act-to-add" name="act-to-add" disabled>
                          <option value="0" selected>(Thêm bút toán)</option>
                          <?php foreach ($act_entry_types as $item): ?>
                             <option value="<?php echo $item->id; ?>" data-default_value="<?php echo format_default_value($item->default_value); ?>" data-income="<?php echo $item->income; ?>" data-note="<?php echo $item->note; ?>"><?php echo $item->description; ?></option>
                          <?php endforeach; ?>
                       </select>
                       <button type="button" class="btn btn-primary" title="Thêm" id="act-add-btn" data-url="<?php echo base_url('Receipt/load_act_type_info'); ?>" disabled>
                          <i class="fa fa-fw" aria-hidden="true" title="Thêm"></i>
                       </button>
                       <button type="button" class="btn btn-success pull-right shake shake-constant" id="act-update-btn" title="Lưu thay đổi" disabled>
                          <i class="fa fa-check" title="Lưu thay đổi"></i>
                       </button>
                       <div class="clearfix"></div>
                    </div>
                  </div>
                  <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="accounting-entry-list">

            </div>
            <div class="wait-ajax" id="wait-choose-act">
               <i class="fas fa-circle-notch fa-spin fa-5x"></i>
            </div>
        </div>
    </div>
    <!-- /.panel-body -->
</div>
