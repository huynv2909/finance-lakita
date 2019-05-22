<div class="row">
   <div class="col-md-6">
      <form id="add-form" method="post">
         <div class="col-xs-12 col-sm-6">
            <div class="form-group">
               <label for="name">Tên:</label>
               <input type="text" id="name" class="form-control" name="name" value="">
            </div>
         </div>
         <div class="col-xs-12 col-sm-6">
            <div class="form-group">
               <label for="permission">Vai trò</label>
               <select class="form-control" name="permission" id="permission">
                  <option value="1">ROOT MANAGER</option>
                  <option value="2">ACCOUNTANT MANAGER</option>
                  <option value="3" selected>ACCOUNTANT</option>
               </select>
            </div>
         </div>
         <div class="col-xs-12 col-sm-6">
            <div class="form-group">
               <label for="username">Tài khoản:</label>
               <input type="text" id="username" class="form-control" name="username" value="">
            </div>
         </div>
         <div class="col-xs-12 col-sm-6">
            <div class="form-group">
               <label for="password">Mật khẩu:</label>
               <input type="text" id="password" class="form-control" name="password" value="">
            </div>
         </div>

         <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
            <input type="submit" name="submit" class="btn btn-success" value="Thêm" style="width: 100%;">
         </div>
         <div class="clearfix"></div>
      </form>

   </div>
   <div class="col-md-6">
      <div class="table-responsive">
         <table class="table table-striped table-bordered table-hover" style="background-color: aliceblue;">
            <thead>
               <tr>
                  <th>Tên</th>
                  <th>Username</th>
                  <th>Vai trò</th>
                  <th></th>
               </tr>
            </thead>
            <tbody>
               <?php if (isset($users) && count($users) > 0): ?>
                  <?php foreach ($users as $user): ?>
                     <tr id="row-<?php echo $user->id; ?>">
                        <td><?php echo $user->name; ?></td>
                        <td><?php echo $user->username; ?></td>
                        <td><?php
                           if ($user->permission == 1) {
                              echo "ROOT MANAGER";
                           }
                           if ($user->permission == 2) {
                              echo "ACCOUNTANT MANAGER";
                           }
                           if ($user->permission == 3) {
                              echo "ACCOUNTANT";
                           }
                         ?></td>
                         <td class="text-center">
   							 	 <button type="button" class="btn btn-circle edit-btn" data-url="<?php echo $this->routes['user_edit']; ?>" data-id="<?php echo $user->id; ?>"><i class="fa fa-fw" aria-hidden="true" title="Chỉnh sửa"></i></button>
   								 <button type="button" class="btn btn-circle del-btn" data-url="<?php echo $this->routes['user_delete']; ?>" data-id="<?php echo $user->id; ?>"><i class="fa fa-times"></i></button>
   							 </td>
                     </tr>
                  <?php endforeach; ?>
               <?php endif; ?>
            </tbody>
         </table>
      </div>
   </div>

</div>
