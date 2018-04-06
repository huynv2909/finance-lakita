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
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <?php $this->load->view($templete); ?>
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

        <!-- Custom Theme JavaScript -->
        <script src="<?php echo public_url(); ?>js/startmin.js"></script>

        <!-- My Js file -->
        <script type="text/javascript" src="<?php echo public_url(); ?>js/myscript.js"></script>

    </body>
</html>
