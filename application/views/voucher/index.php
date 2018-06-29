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
