<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('head', $this->data); ?>
    <body>
        <div id="wrapper">

            <?php $this->load->view('navigation', $this->data); ?>

            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $title; ?></h1>
                        <?php if (isset($message_errors) && $message_errors) {
                          echo '<p class="alert alert-danger">' . $message_errors . '</p>';
                        } ?>
                        <?php if (isset($message_success) && $message_success) {
                          echo '<p class="alert alert-success">' . $message_success . '</p>';
                        } ?>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <?php $this->load->view($template); ?>
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

        <!-- jQuery -->
        <script src="<?php echo public_url(); ?>js/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="<?php echo public_url(); ?>js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="<?php echo public_url(); ?>js/metisMenu.min.js"></script>

        <?php if ($active == "dashboard"): ?>
            <!-- Morris Charts JavaScript -->
            <script src="<?php echo public_url(); ?>js/raphael.min.js"></script>
            <script src="<?php echo public_url(); ?>js/morris.min.js"></script>
            <script src="<?php echo public_url(); ?>js/morris-data.js"></script>
        <?php endif ?>

        <!-- DataTables JavaScript -->
        <script src="<?php echo public_url(); ?>js/dataTables/jquery.dataTables.min.js"></script>
        <script src="<?php echo public_url(); ?>js/dataTables/dataTables.bootstrap.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="<?php echo public_url(); ?>js/startmin.js"></script>

        <!-- Page-Level Demo Scripts - Tables - Use for reference -->
        <script>
            $(document).ready(function() {
                $('#dataTables-example').DataTable({
                        responsive: true,
                        "order" : [[0, 'desc'], [5, 'desc']]
                });
            });
        </script>

        <!-- My Js file -->
        <script type="text/javascript" src="<?php echo public_url(); ?>js/myscript.js"></script>

    </body>
</html>
