<!-- View for "Ghi nhan doanh thu" -->
<div class="row row-tr" id="row-<?php echo $sequence; ?>">
   <?php $this->load->view('receipt/transaction_form/close'); ?>
   <?php $this->load->view('receipt/transaction_form/hidden_input'); ?>
   <h5>Bút toán <?php echo $sequence; ?></h5>
   <?php $this->load->view('receipt/transaction_form/value_field'); ?>
   <?php $this->load->view('receipt/transaction_form/note_field'); ?>
   <?php $this->load->view('receipt/transaction_form/tot-toa_field'); ?>
</div>
