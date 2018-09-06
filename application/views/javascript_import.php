<!-- jQuery -->
<script src="<?php echo public_url(); ?>js/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?php echo public_url(); ?>js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript ??? -->
<script src="<?php echo public_url(); ?>js/metisMenu.min.js"></script>

<!-- Google charts -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<!-- DataTables JavaScript -->
<script src="<?php echo public_url(); ?>js/dataTables/jquery.dataTables.min.js"></script>
<script src="<?php echo public_url(); ?>js/dataTables/dataTables.bootstrap.min.js"></script>

<!-- Custom Theme JavaScript ??? -->
<script src="<?php echo public_url(); ?>js/startmin.js"></script>

<!-- My Js file -->
<!-- <script type="text/javascript" src="<?php echo public_url(); ?>js/myscript.js"></script> -->
<script type="text/javascript" src="<?php echo public_url(); ?>js/common.js"></script>
<?php if (isset($js_files) && $js_files): ?>
   <?php foreach ($js_files as $js_name): ?>
      <script type="text/javascript" src="<?php echo public_url(); ?>js/<?php echo $js_name; ?>.js"></script>
   <?php endforeach; ?>
<?php endif; ?>

<!-- Confirm jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
