<form role="form">
      <input type="hidden" id="list_code_used" value="<?php
         if (isset($list_code) && !empty($list_code)) {
            foreach ($list_code as $item) {
               echo $item->code . ',';
            }
         }
       ?>">
     <div class="form-group">
         <label>Mã chứng từ</label>
         <input class="form-control">
         <p class="help-block">Nhập mã chứng từ không trùng mã chứng từ cũ (vd: PTABC).</p>
     </div>
     <div class="form-group">
         <label>Tên chứng từ</label>
         <textarea class="form-control" rows="3"></textarea>
     </div>
     <div class="form-group">
         <label>Thuộc</label>
         <select class="form-control">
             <option value="0" selected>Chi</option>
             <option value="1">Thu</option>
         </select>
     </div>
 </form>
