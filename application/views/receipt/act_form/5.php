<!-- View for "Ghi nhan chi" -->
<div class="row row-tr" id="row-<?php echo $sequence; ?>">
   <?php $this->load->view('receipt/act_form/close'); ?>
   <?php $this->load->view('receipt/act_form/hidden_input'); ?>
   <?php $this->load->view('receipt/act_form/income'); ?>
   <?php $this->load->view('receipt/act_form/value_field'); ?>
   <?php $this->load->view('receipt/act_form/note_field'); ?>
   <?php $this->load->view('receipt/act_form/tot-toa_field'); ?>
</div>
