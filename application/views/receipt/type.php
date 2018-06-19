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

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel"  class="tab-pane fade active in" id="recreipt-tab">
                  <div class="panel panel-primary" id="panel-receipt">
                     <div class="panel-heading">
                        <h3 class="panel-title text-center">Chứng từ</h3>
                    </div>
                     <div class="panel-body">
                        <?php if (isset($receipt_types) && !empty($receipt_types)): ?>
                           <?php foreach ($receipt_types as $type): ?>
                              <div class="receipt-item">
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
                                 <label class="switch">
                                   <input type="checkbox" class="income-check"
                                       <?php
                                          if ($type->income) {
                                             echo "checked";
                                          }
                                          else {
                                             echo 'value="off"';
                                          }
                                       ?>
                                   >
                                   <span class="slider slider-cus round">
                                      <span class="status-text in-out" title="
                                          <?php
                                             if ($type->income) {
                                                echo "Thu";
                                             }
                                             else {
                                                echo "Chi";
                                             }
                                          ?>
                                      "><?php
                                         if ($type->income) {
                                            echo "Thu";
                                         }
                                         else {
                                            echo "Chi";
                                         }
                                      ?></span>
                                   </span>
                                 </label>
                                 <div class="clearfix"></div>
                              </div>
                           <?php endforeach; ?>
                        <?php endif; ?>
                     </div>
                    <div class="panel-footer">
                       Panel footer
                    </div>
                  </div>
                  <!-- <select id="rc-list" name="">
                     <option value="">Phiếu thu các khóa học từ COD</option>
                     <option value="">Phiếu chi ứng tiền</option>
                     <option value="">Phiếu chi văn phòng</option>
                     <option value="">Phiếu thu các khóa học từ chuyển khoản</option>
                     <option value="">Phiếu chi sinh hoạt chung</option>
                  </select> -->
                  <div class="panel panel-info" id="panel-act">
                     <div class="panel-heading">
                        <h3 class="panel-title text-center">Bút toán tương ứng</h3>
                    </div>
                     <div class="panel-body">
                        Panel content
                     </div>
                    <div class="panel-footer">
                       Panel footer
                    </div>
                  </div>
                  <div class="clearfix"></div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="accounting-entry-list">
               DDM
            </div>
        </div>
    </div>
    <!-- /.panel-body -->
</div>
