<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('head'); ?>
    <body>
        <div id="wrapper">

            <?php $this->load->view('navigation'); ?>

            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $title; ?></h1>
                        <p class="alert <?php
                           $have = false;
                           if (isset($message_errors) && $message_errors) {
                              echo 'alert-danger';
                              $have = true;
                           }
                           if (isset($message_success) && $message_success) {
                              echo 'alert-success';
                              $have = true;
                           }
                        ?>"><?php
                           if (isset($message_errors) && $message_errors) {
                              echo $message_errors;
                           }
                           if (isset($message_success) && $message_success) {
                              echo $message_success;
                           }
                           ?></p>
                           <input type="hidden" id="have-notify" value="<?php echo $have; ?>">
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <?php $this->load->view($template); ?>
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

    </body>
</html>
