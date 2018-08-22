<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand" href="<?php echo base_url(); ?>">
           Lakita Finance 2018
        </a>
    </div>

    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>

    <ul class="nav navbar-nav navbar-left navbar-top-links">
        <li><a href="https://lakita.vn/"><i class="fa fa-home fa-fw"></i> Website</a></li>
    </ul>

    <ul class="nav navbar-right navbar-top-links">
        <li class="dropdown navbar-inverse">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-bell fa-fw"></i> <b class="caret"></b>
            </a>
            <ul class="dropdown-menu dropdown-alerts">
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-comment fa-fw"></i> New Comment
                            <span class="pull-right text-muted small">4 minutes ago</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                            <span class="pull-right text-muted small">12 minutes ago</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-envelope fa-fw"></i> Message Sent
                            <span class="pull-right text-muted small">4 minutes ago</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-tasks fa-fw"></i> New Task
                            <span class="pull-right text-muted small">4 minutes ago</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-upload fa-fw"></i> Server Rebooted
                            <span class="pull-right text-muted small">4 minutes ago</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a class="text-center" href="#">
                        <strong>See All Alerts</strong>
                        <i class="fa fa-angle-right"></i>
                    </a>
                </li>
            </ul>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i><?php echo $this->user->name; ?><b class="caret"></b>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                </li>
                <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                </li>
                <li class="divider"></li>
                <li><a href="<?php echo base_url('logout'); ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li class="sidebar-search">
                    <div class="input-group custom-search-form">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                    </span>
                    </div>
                    <!-- /input-group -->
                </li>

                <?php foreach ($this->navbar as $name => $catalog): ?>
                   <?php if (count($catalog) == 1): ?>
                      <li>
                          <a href="<?php echo $catalog[0]['link']; ?>" ><?php echo $catalog[0]['icon'] . " " . $catalog[0]['description']; ?></a>
                      </li>
                   <?php else: ?>
                      <li>
                         <a href="#"><?php
                              if ($name == 'voucher') {
                                 echo '<i class="fa fa-file-text-o fa-fw"></i> Hóa đơn/Chứng từ';
                              }
                              if ($name == 'accountingentry') {
                                 echo '<i class="fa fa-file-text-o fa-fw"></i> Bút toán';
                              }
                              if ($name == 'vouchertype') {
                                 echo '<i class="fa fa-fw" aria-hidden="true" title="Loại chứng từ"></i> Loại chứng từ';
                              }
                              if ($name == 'dimension') {
                                 echo '<i class="fa fa-fw" aria-hidden="true" title="Chiều quản trị"></i> Chiều quản trị';
                              }
                              if ($name == 'config') {
                                 echo '<i class="fa fa-wrench fa-fw"></i> Thiết lập';
                              }
                              if ($name == 'dashboard') {
                                 echo '<i class="fa fa-fw" aria-hidden="true" title="Dashboard"></i> Dashboard';
                              }
                              if ($name == 'dimensiondetail') {
                                 echo '<i class="fa fa-sitemap fa-fw"></i> Chi tiết chiều quản trị';
                              }
                              if ($name == 'distribution') {
                                 echo '<i class="fa fa-fw" aria-hidden="true" title="Phân bổ bút toán"></i> Phân bổ bút toán';
                              }
                              if ($name == 'user') {
                                 echo '<i class="fa fa-fw" aria-hidden="true" title="Thành viên"></i> Thành viên';
                              }
                          ?><span class="fa arrow"></span></a>
                         <ul class="nav nav-second-level">
                            <?php foreach ($catalog as $sub_catalog): ?>
                               <li>
                                  <a href="<?php echo $sub_catalog['link']; ?>"><?php echo $sub_catalog['description']; ?></a>
                               </li>
                            <?php endforeach; ?>
                         </ul>
                      </li>
                   <?php endif; ?>
                <?php endforeach; ?>


                <li>
                    <a href="<?php echo base_url('GetResponsesPBI/showReport'); ?>"><i class="fa fa-bar-chart-o fa-fw"></i> Báo cáo</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-edit fa-fw"></i> Forms</a>
                </li>

                <li>
                    <a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="#">Second Level Item</a>
                        </li>
                        <li>
                            <a href="#">Second Level Item</a>
                        </li>
                        <li>
                            <a href="#">Third Level <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li>
                                    <a href="#">Third Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Third Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Third Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Third Level Item</a>
                                </li>
                            </ul>
                            <!-- /.nav-third-level -->
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa fa-files-o fa-fw"></i> Sample Pages<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="#">Blank Page</a>
                        </li>
                        <li>
                            <a href="#">Login Page</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
            </ul>
        </div>
    </div>
</nav>
