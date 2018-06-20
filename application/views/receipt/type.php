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
        <div class="tab-content pos-rel">
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

                  <div class="panel panel-info" id="panel-act">
                     <div class="panel-heading">
                        <h3 class="panel-title text-center">Bút toán tương ứng</h3>
                    </div>
                     <div class="panel-body">
                        <div class="act-item">
                           <table>
                              <tr>
                                 <td class="check-col">
                                    <input type="checkbox" name="act-choose" value="">
                                 </td>
                                 <td class="name-col">
                                    <div class="out-div">
                                       Chi
                                    </div>
                                    <span>Thue gia tri gia tang</span>
                                 </td>
                                 <td class="default-col">
                                    <span>10%</span>
                                 </td>
                              </tr>
                           </table>
                        </div>
                        <div class="act-item">
                           <table>
                              <tr>
                                 <td class="check-col">
                                    <input type="checkbox" name="act-choose" value="">
                                 </td>
                                 <td class="name-col">
                                    <div class="in-div">
                                       Thu
                                    </div>
                                    <span>Ghi nhan doanh thu</span>
                                 </td>
                                 <td class="default-col">
                                    <span>100%</span>
                                 </td>
                              </tr>
                           </table>
                        </div>
                        <div class="act-item">
                           <table>
                              <tr>
                                 <td class="check-col">
                                    <input type="checkbox" name="act-choose" value="">
                                 </td>
                                 <td class="name-col">
                                    <div class="out-div">
                                       Chi
                                    </div>
                                    <span>Chi phí COD</span>
                                 </td>
                                 <td>
                                    <span>30.000/295.000</span>
                                 </td>
                              </tr>
                           </table>
                        </div>
                     </div>
                    <div class="panel-footer">
                       Panel footer
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
