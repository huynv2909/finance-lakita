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
                  <input type="hidden" name="have-change" value="0" id="have-change">
                  <div class="panel panel-primary" id="panel-receipt">
                     <div class="panel-heading">
                        <h3 class="panel-title text-center">Chứng từ</h3>
                    </div>
                     <div class="panel-body" id="list-receipt">
                        <!-- have load by ajax -->
                        <?php $this->load->view('receipt/load/receipt_list'); ?>
                     </div>
                    <div class="panel-footer">
                       <button type="button" class="btn btn-primary" id="type-add-btn" title="Thêm loại chứng từ mới" data-url="<?php echo base_url('Receipt/create_type_receipt'); ?>" >
                          <i class="fa fa-fw" aria-hidden="true" title="Thêm mới"></i> Thêm mới
                       </button>
                       <button type="button" class="btn btn-success pull-right" id="status-change-btn" title="Lưu lại các thay đổi" data-url="<?php echo base_url('Receipt/change_status'); ?>" data-url_load="<?php echo base_url('Receipt/load_new_status'); ?>" disabled>
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
                       <button type="button" class="btn btn-success pull-right shake shake-constant" data-url="<?php echo base_url('Receipt/update_list_act'); ?>" id="act-update-btn" title="Lưu thay đổi" disabled>
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
               <i class="fas fa-circle-notch fa-spin fa-5x wait"></i>
               <i class="fa fa-fw fa-5x success" aria-hidden="true" title="Success"></i>
            </div>
        </div>
    </div>
    <!-- /.panel-body -->
</div>
