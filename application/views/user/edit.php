<form id="edit-act-form" action="<?php echo $this->routes['user_editsubmit']; ?>" method="post">
   <input type="hidden" name="id" value="<?php echo $info->id; ?>">
   <div class="col-md-4 col-xs-12 col-sm-6">
      <div class="form-group">
         <label for="name">Tên:</label>
         <input type="text" id="name" class="form-control" name="name" value="<?php echo $info->name; ?>">
      </div>
   </div>
   <div class="col-md-4 col-xs-12 col-sm-6">
      <div class="form-group">
         <label for="permission">Vai trò</label>
         <select class="form-control" name="permission" id="permission">
            <option value="1" <?php if ($info->permission == 1) echo "selected"; ?>>ROOT MANAGER</option>
            <option value="2" <?php if ($info->permission == 2) echo "selected"; ?>>ACCOUNTANT MANAGER</option>
            <option value="3" <?php if ($info->permission == 3) echo "selected"; ?>>ACCOUNTANT</option>
         </select>
      </div>
   </div>
   <div class="col-md-4 col-xs-12 col-sm-6">
      <div class="form-group">
         <label for="password">Mật khẩu:</label>
         <input type="text" id="password" class="form-control" name="password" value="********" disabled>
      </div>
      <span>Lấy lại mật khẩu <input type="checkbox" id="change-password" name="change" value="1"></span>
   </div>
   <div class="clearfix"></div>
</form>
