<div class="panel panel-default">
    <div class="panel-heading">
        Danh sách toàn bộ chứng từ
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
        <div class="dataTable_wrapper">
            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
               <div class="row">
                  <div class="col-sm-12">
                     <table class="table table-hover dataTable no-footer" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info">
                        <thead>
                              <tr role="row">
                                 <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="Time on transaction: activate to sort column ascending" style="width: 12%;">TOT</th>
                                 <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="Reiceipt type: activate to sort column ascending" style="width: 20%;">Loại chứng từ</th>
                                 <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="Value: activate to sort column ascending" style="width: 14%;">Số tiền</th>
                                 <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="Content: activate to sort column ascending" style="width: 28%;">Nội dung</th>
                                 <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="Executor: activate to sort column ascending" style="width: 14%;">Người giao dịch</th>
                                 <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="Time on action: activate to sort column ascending" style="width: 12%;">TOA</th>
                              </tr>
                        </thead>
                        <tbody>
                           <?php foreach ($receipts as $item): ?>
                              <tr role="row" data-url="<?php echo base_url('Receipt/view_more'); ?>" data-id="<?php echo $item->id; ?>" class="re-row <?php if ($item->income == 1) echo 'success'; ?>">
                                  <td><?php echo $item->TOT; ?></td>
                                  <td>
                                     <?php
                                       foreach ($receipt_types as $type) {
                                          if ($item->type_id == $type->id) {
                                             echo $type->name;
                                             break;
                                          }
                                       }
                                      ?>
                                  </td>
                                  <td><?php echo number_format($item->value, 0, ",", "."); ?></td>
                                  <td><?php echo $item->content; ?></td>
                                  <td>
                                     <?php
                                       foreach ($users as $user) {
                                          if ($item->executor == $user->id) {
                                             echo $user->name;
                                             break;
                                          }
                                       }
                                      ?>
                                  </td>
                                  <td><?php echo $item->TOA; ?></td>
                              </tr>
                           <?php endforeach; ?>
                              <tr class="gradeA odd" role="row">
                                 <td class="">00</td>
                                 <td class="sorting_1">Seamonkey 1.1</td>
                                 <td class="">Win 98+ / OSX.2+</td>
                                 <td class="center">1.8</td>
                                 <td class="center">A</td>
                                 <td class="center">A</td>
                             </tr>
                             <tr class="gradeA even" role="row">
                                 <td class="">00</td>
                                 <td class="sorting_1">Safari 3.0</td>
                                 <td class="">OSX.4+</td>
                                 <td class="center">522.1</td>
                                 <td class="center">A</td>
                                 <td class="center">A</td>
                             </tr>
                             <tr class="gradeA odd" role="row">
                                 <td class="">00</td>
                                 <td class="sorting_1">Safari 2.0</td>
                                 <td class="">OSX.4+</td>
                                 <td class="center">419.3</td>
                                 <td class="center">419.3</td>
                                 <td class="center">A</td>
                             </tr>
                             <tr class="gradeA even" role="row">
                                 <td class="">00</td>
                                 <td class="sorting_1">Safari 1.3</td>
                                 <td class="">OSX.3</td>
                                 <td class="center">312.8</td>
                                 <td class="center">A</td>
                                 <td class="center">A</td>
                             </tr>
                             <tr class="gradeA odd" role="row">
                                 <td class="">00</td>
                                 <td class="sorting_1">Safari 1.2</td>
                                 <td class="">OSX.3</td>
                                 <td class="center">125.5</td>
                                 <td class="center">A</td>
                                 <td class="center">A</td>
                             </tr>
                             <tr class="gradeA even" role="row">
                                 <td class="">00</td>
                                 <td class="sorting_1">S60</td>
                                 <td class="">S60</td>
                                 <td class="center">413</td>
                                 <td class="center">A</td>
                                 <td class="center">A</td>
                             </tr>
                             <tr class="gradeC odd" role="row">
                                 <td class="">00</td>
                                 <td class="sorting_1">PSP browser</td>
                                 <td class="">PSP</td>
                                 <td class="center">-</td>
                                 <td class="center">C</td>
                                 <td class="center">C</td>
                             </tr>
                             <tr class="gradeA even" role="row">
                                 <td class="">00</td>
                                 <td class="sorting_1">Opera for Wii</td>
                                 <td class="">Wii</td>
                                 <td class="center">-</td>
                                 <td class="center">A</td>
                                 <td class="center">A</td>
                             </tr>
                             <tr class="gradeA odd" role="row">
                                 <td class="">00</td>
                                 <td class="sorting_1">Opera 9.5</td>
                                 <td class="">Win 88+ / OSX.3+</td>
                                 <td class="center">-</td>
                                 <td class="center">A</td>
                                 <td class="center">A</td>
                             </tr>
                             <tr class="gradeA even" role="row">
                                 <td>00</td>
                                 <td>Opera 9.2</td>
                                 <td>Win 88+ / OSX.3+</td>
                                 <td>-</td>
                                 <td>A</td>
                                 <td>A</td>
                             </tr>
                             <tr role="row">
                                 <td>0000</td>
                                 <td>Firefox 60</td>
                                 <td>Ubuntu</td>
                                 <td>-</td>
                                 <td>A</td>
                                 <td>A</td>
                             </tr>
                          </tbody>
                     </table>
                  </div>
               </div>
            </div>
        </div>
    </div>
    <!-- /.panel-body -->
    <!-- Large modal -->
   <div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
     <div class="modal-dialog modal-lg" role="document">
       <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Xem chi tiết</h4>
            </div>
            <div class="modal-body" id="data-insert">
               <!-- insert by ajax -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
       </div>
     </div>
   </div>
</div>
