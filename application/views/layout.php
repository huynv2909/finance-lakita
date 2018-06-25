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

        <?php $this->load->view('javascript_import'); ?>

    </body>
</html>
