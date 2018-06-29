<div class="row">
   <div class="col-xs-2">
      <label for="voucher-choose">Chọn chứng từ:</label>
   </div>
   <div class="col-xs-10">
      <select name="voucher-choose" id="voucher-choose" class="choose-box">
         <option value="">25/06/2018:Thưởng HảiHD hoàn thành nhiệm vụ</option>
         <option value="">21/06/2018:Mua but da</option>
         <option value="">13/06/2018:Nhận tiền từ VNpost</option>
         <option value="">05/05/2018:Ứng trước cho in phong bì</option>
         <option value="">02/05/2018:Lương tháng 4 của HuyNV</option>
      </select>
   </div>
</div>

<h5>Thông tin chứng từ:</h5>
<div class="info-box" id="voucher-box">
   <div class="col-xs-12 col-md-4 pull-right">
      <table class="date-col">
         <colgroup class="row-50-50">
             <col>
             <col>
         </colgroup>
         <tr>
            <td>Ngày tạo:</td>
            <td>28/11/2018</td>
         </tr>
         <tr>
            <td>Ngày Phát sinh (TOT):</td>
            <td>28/11/2018</td>
         </tr>
         <tr>
            <td>Ngày thực hiện (TOA):</td>
            <td>28/11/2018</td>
         </tr>
         <tr>
            <td>Người lập:</td>
            <td>Nguyễn Văn Huy</td>
         </tr>
         <tr>
            <td>Loại:</td>
            <td>Phiếu thu</td>
         </tr>
      </table>
   </div>
   <div class="col-xs-12 col-md-8 pull-left">
      <div class="row">
         <div class="col-md-6">
            <table>
               <colgroup class="row-50-50">
                   <col>
                   <col>
               </colgroup>
               <tbody>
                  <tr>
                     <td>ID:</td>
                     <td>PTCOD1023143231</td>
                  </tr>
               </tbody>
            </table>
         </div>
         <div class="col-md-6">
            <table>
               <colgroup class="row-50-50">
                   <col>
                   <col>
               </colgroup>
               <tbody>
                  <tr>
                     <td>Mã CT:</td>
                     <td>(Trống)</td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <div class="row">
         <table>
            <colgroup class="row-25-50">
                <col>
                <col>
            </colgroup>
            <tbody>
               <tr>
                  <td>Loại chứng từ:</td>
                  <td>Phiếu thu từ tiền khóa học từ COD</td>
               </tr>
            </tbody>
         </table>
      </div>
      <div class="row">
         <div class="col-md-6">
            <table>
               <colgroup class="row-50-50">
                   <col>
                   <col>
               </colgroup>
               <tbody>
                  <tr>
                     <td>Số tiền:</td>
                     <td>2.500.000 đ</td>
                  </tr>
               </tbody>
            </table>
         </div>
         <div class="col-md-6">
            <table>
               <colgroup class="row-50-50">
                   <col>
                   <col>
               </colgroup>
               <tbody>
                  <tr>
                     <td>Người giao dịch:</td>
                     <td>Nguyễn Ngọc Công</td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <div class="row">
         <table>
            <colgroup class="row-25-50">
                <col>
                <col>
            </colgroup>
            <tbody>
               <tr>
                  <td>Nội dung:</td>
                  <td>Thu tiền khóa KT240 1 nửa từ 20/11 đến 27/11, đã nhân tiền mặt</td>
               </tr>
            </tbody>
         </table>
      </div>
      <div class="row">
         <table>
            <colgroup class="row-25-50">
                <col>
                <col>
            </colgroup>
            <tbody>
               <tr>
                  <td>Ghi chú:</td>
                  <td>(Trống)</td>
               </tr>
            </tbody>
         </table>
      </div>
   </div>
   <div class="clearfix"></div>
</div>

<hr>

<h5><strong>Bút toán đã nhập:</strong></h5>
<div class="row log-table">
	<div class="col-sm-12">
		<table class="table table-hover dataTable no-footer" id="act_table" role="grid" aria-describedby="voucher_table_info" border="1">
			<thead>
					<tr role="row">
						<th class="sorting" tabindex="0" aria-controls="act_table" rowspan="1" colspan="1" aria-label="Time on action: activate to sort column ascending" style="width: 12%;">TOA</th>
						<th class="sorting" tabindex="0" aria-controls="act_table" rowspan="1" colspan="1" aria-label="Content: activate to sort column ascending" style="width: 20%;">Nội dung</th>
						<th class="sorting" tabindex="0" aria-controls="act_table" rowspan="1" colspan="1" aria-label="Value: activate to sort column ascending" style="width: 14%;">Số tiền</th>
						<th class="sorting" tabindex="0" aria-controls="act_table" rowspan="1" colspan="1" aria-label="Debit ID: activate to sort column ascending" style="width: 28%;">TK nợ</th>
						<th class="sorting" tabindex="0" aria-controls="act_table" rowspan="1" colspan="1" aria-label="Credit ID: activate to sort column ascending" style="width: 12%;">TK có</th>
					</tr>
			</thead>
			<tbody>
            <tr role="row">
					 <td>2018-06-23</td>
					 <td>Giao dich ngay 23</td>
					 <td>40.000</td>
					 <td>111</td>
					 <td>132</td>
				</tr>
            <tr role="row">
					 <td>2018-06-24</td>
					 <td>Giao dich ngay 24</td>
					 <td>100.000</td>
					 <td>111</td>
					 <td>122</td>
				</tr>
	       </tbody>
		</table>
      <script>
          $(document).ready(function() {
              $('#act_table').DataTable({
                      responsive: true,
                      "order" : [[0, 'asc']]
              });
          });
      </script>
   </div>
</div>
<button type="button" class="btn btn-primary" id="type-add-btn" title="Thêm loại chứng từ mới" data-url="<?php echo base_url('Receipt/create_type_receipt'); ?>" >
  <i class="fa fa-fw" aria-hidden="true" title="Thêm bút toán"></i> Thêm bút toán
</button>
<button type="button" class="btn btn-success pull-right" id="status-change-btn" title="Lưu lại các thay đổi" data-url="<?php echo base_url('Receipt/change_status'); ?>" data-url_load="<?php echo base_url('Receipt/load_new_status'); ?>" disabled>
  <i class="fa fa-check" title="Lưu thay đổi"></i> Cập nhật
</button>
<div class="clearfix"></div>
