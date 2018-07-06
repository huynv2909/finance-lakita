<div class="row">
   <form class="form-horizontal" method="post" id="type-form">
      <div class="col-xs-4 col-md-3">
         <div class="form-group">
            <label for="code" class="col-md-4 control-label padding-lr-10-5">Đầu mã</label>
            <div class="col-xs-10 col-md-7 padding-lr-10-5">
               <input type="text" name="code" id="code" class="form-control" data-ok="0" value="" placeholder="Mã loại chứng từ">
            </div>
            <div class="col-xs-2 col-md-1 padding-0 centering-parent height-34">
               <i class="fa fa-fw fa-2x fa-spin checking hidden" aria-hidden="true" title="loading..."></i>
               <i class="fa fa-fw fa-2x success hidden" aria-hidden="true" title="Ok!"></i>
               <i class="fa fa-fw fa-2x danger hidden" aria-hidden="true" title="Invalid!"></i>
            </div>
         </div>
      </div>
      <div class="col-xs-8 col-md-5 col-lg-6">
         <div class="form-group">
            <label for="name" class="col-md-2 col-lg-1 control-label">Tên</label>
            <div class="col-md-10 col-lg-11">
               <textarea name="name" rows="1" class="form-control" id="name" placeholder="Tên chứng từ"></textarea>
            </div>
         </div>
      </div>
      <div class="col-xs-4 col-xs-6 col-md-2 col-lg-2">
         <div class="form-group">
            <div class="col-xs-12">
               <select class="form-control" name="income">
                  <option value="0">Phiếu chi</option>
                  <option value="1">Phiếu thu</option>
               </select>
            </div>
         </div>
      </div>
      <div class="col-xs-3 col-xs-push-3 col-xs-6 col-md-2 col-md-push-0 col-lg-1">
         <div class="form-group">
            <input type="submit" name="Ok" class="form-control btn btn-success height-34" id="add-new-type-btn" value="Thêm" disabled>
         </div>
      </div>
      <div class="clearfix"></div>
   </form>
</div>
<input type="hidden" id="list_code" value="<?php
   if (isset($list_types) && $list_types) {
      $str = '';
      foreach ($list_types as $type) {
         $str .= $type->code . ",";
      }
      echo $str;
   }
 ?>">
