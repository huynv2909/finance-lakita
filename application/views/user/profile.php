<div class="row">
<table class="table table-striped table-bordered table-hover" style="width: 100%;">
   <thead>
      <tr>
         <th>Tên</th>
         <th>Username</th>
         <th>Vai trò</th>
         <th>Ngày tham gia</th>
      </tr>
   </thead>
   <tbody>
      <tr>
         <td><?php echo $info->name; ?></td>
         <td><?php echo $info->username; ?></td>
         <td><?php
            if ($info->permission == 1) {
               echo "ROOT MANAGER";
            }
            if ($info->permission == 2) {
               echo "ACCOUNTANT MANAGER";
            }
            if ($info->permission == 3) {
               echo "ACCOUNTANT";
            }
          ?></td>
         <td><?php echo $info->created; ?></td>
      </tr>
   </tbody>
</table>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Đổi mật khẩu
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Đổi mật khẩu</h4>
      </div>
      <div class="modal-body">
        <form method="post">
           <input type="hidden" name="id" value="<?php echo $info->id; ?>">
           <div class="form-group">
             <label for="password">Mật khẩu cũ</label>
             <input type="text" class="form-control" name="password" id="password" placeholder="Mật khẩu cũ">
           </div>
           <div class="form-group">
             <label for="new_password">Mật khẩu mới</label>
             <input type="text" class="form-control" name="new_password" id="new_password" placeholder="Mật khẩu mới">
           </div>
           <input type="submit" name="submit" class="btn btn-primary text-right" value="Xác nhận">
           <div class="clearfix">
           </div>
        </form>
      </div>
    </div>
  </div>
</div>

</div>
