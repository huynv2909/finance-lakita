<!-- View for "Ghi nhan chi" -->
<div class="row row-tr" id="row-<?php echo $sequence; ?>">
   <h5>Bút toán <?php echo $sequence; ?></h5>
   <?php $data['type_tr'] = 'gnc'; ?>
   <?php $this->load->view('receipt/transaction_form/value_field', $data); ?>
   <?php $this->load->view('receipt/transaction_form/note_field', $data); ?>
   <?php $this->load->view('receipt/transaction_form/tot-toa_field', $data); ?>
</div>
