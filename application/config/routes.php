<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes with
| underscores in the controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['nhap-chung-tu.html']                              = 'Voucher/create';
$route['chung-tu.html']                                   = 'Voucher/index';
$route['sua-chung-tu.html']                               = 'Voucher/edit';
$route['xoa-chung-tu.html']                               = 'Voucher/delete';
$route['but-toan.html']                                   = 'AccountingEntry/index';
$route['nhap-but-toan.html']                              = 'AccountingEntry/create';
$route['sua-but-toan.html']                               = 'AccountingEntry/edit';
$route['xoa-but-toan.html']                               = 'AccountingEntry/delete';
$route['dong-y-sua.html']                                 = 'AccountingEntry/editSubmit';
$route['da-phan-bo.html']                                 = 'AccountingEntry/viewMore';
$route['loai-chung-tu.html']                              = 'VoucherType/index';
$route['them-loai-chung-tu.html']                         = 'VoucherType/create';
$route['chieu-quan-tri.html']                             = 'Dimension/index';
$route['tao-chieu-quan-tri.html']                         = 'Dimension/create';
$route['sua-chieu-quan-tri.html']                         = 'Dimension/edit';
$route['xoa-chieu-quan-tri.html']                         = 'Dimension/delete';
$route['thiet-lap.html']                                  = 'Config/index';
$route['quan-tri-nguoi-dung.html']                        = 'User/manager';
$route['tai-khoan.html']                                  = 'User/index';
$route['show-info-act.html']                              = 'AccountingEntry/showInfo';
$route['load-form-act.html']                              = 'AccountingEntry/loadForm';
$route['get-voucher-act.html']                            = 'AccountingEntry/getVoucher';
$route['dashboard.html']                                  = 'Dashboard/index';
$route['get-detail-dimen.html']                           = 'Dimension/getDetail';
$route['chi-tiet-chieu-phan-bo.html']                     = 'DimensionDetail/index';
$route['xoa-chi-tiet.html']                               = 'DimensionDetail/delete';
$route['change-status-dimendetail.html']                  = 'DimensionDetail/changeStatus';
$route['get-all-dimendetail.html']                        = 'DimensionDetail/listAll';
$route['khoa-hoc.html']                                   = 'DimensionDetail/coursesManager';
$route['phan-bo-but-toan.html']                           = 'Distribution/create';
$route['load-form-distri.html']                           = 'Distribution/loadForm';
$route['logout.html']                                     = 'Logout/index';
$route['access-denied.html']                              = 'Redirect/accessDenied';
$route['permission.html']                                 = 'User/permission';
$route['show-info-voucher.html']                          = 'Voucher/showInfo';
$route['view-more-voucher.html']                          = 'Voucher/viewMore';
$route['get-default-system.html']                         = 'Voucher/getDefaultSys';
$route['phan-bo-dong-thoi.html']                          = 'Voucher/distributionOneTime';
$route['change-status-voucher-type.html']                 = 'VoucherType/changeStatus';
$route['xoa-loai-chung-tu.html']                          = 'VoucherType/delete';
$route['thiet-lap-mac-dinh-cho-chung-tu.html']            = 'VoucherType/setDefault';
$route['login.html']                                      = 'Login/index';
$route['bao-cao-hoat-dong-tai-chinh.html']                = 'Report/financeActivity';
$route['nha-cung-cap-dich-vu.html']                       = 'Provider/listByMethodId';
$route['upload-by-files.html']                            = 'Voucher/createByFiles';
$route['duyet-chung-tu.html']                             = 'Voucher/approve';
$route['xoa-1.html']                                      = 'Voucher/denyone';
$route['duyet.html']                                      = 'Voucher/approveOne';
$route['bao-cao-khoa-hoc.html']                           = 'Report/coursesReport';
$route['xem-du-lieu.html']                                = 'Report/viewData';
