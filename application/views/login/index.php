<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('head', $this->data); ?>
    <style media="screen">
    html, body {
         margin: 0;
         height: 100%;
         }

      body {
         background-image: url('<?php echo base_url('public/banking-business.jpg'); ?>');
         background-size: cover;
         background-position: center;
      }
    </style>
    <body id="body">
      <div id="particle" style="height: 100%; width: 100%; background: rgba(0,0,0,0.5); position: absolute;">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Đăng nhập</h3>
                        </div>
                        <div class="panel-body">
                            <?php if (isset($message) && $message): ?>
                                <p class="alert alert-danger">
                                    <?php echo $message; ?>
                                </p>
                            <?php endif ?>
                            <form role="form" method="post">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Username" name="username" type="text" autofocus value="<?php echo set_value('username'); ?>" >
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input name="remember" type="checkbox">Remember Me
                                        </label>
                                    </div>
                                    <!-- Change this to a button or input when using this as a form -->
                                    <input type="submit" value="Login" class="btn btn-lg btn-success btn-block">
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery -->
        <script src="<?php echo public_url(); ?>/js/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="<?php echo public_url(); ?>/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="<?php echo public_url(); ?>/js/metisMenu.min.js"></script>

        <script src="<?php echo public_url(); ?>/js/particles.js-master/particles.js"></script>

        <script type="text/javascript">
          particlesJS.load('particle', '<?php echo public_url(); ?>/js/particles.js-master/demo/particles.json', function() {
            console.log('callback - particles.js config loaded');
            });
        </script>

    </body>
</html>
