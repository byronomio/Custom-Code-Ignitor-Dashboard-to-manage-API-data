<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <title>Login - WooDash</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta content="" name="description" />
      <!-- Bootstrap -->
      <link href="<?php echo base_url();?>bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
      <link href="<?php echo base_url();?>bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
      <!-- Styles -->
      <link href="<?php echo base_url();?>styles/login.css?t<?php echo time(); ?>" rel="stylesheet" type="text/css">
      <link href="<?php echo base_url();?>styles/elements.css" rel="stylesheet" type="text/css">
      <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,500,600,700' rel='stylesheet' type='text/css'>
      <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
      <!-- Favicon: http://realfavicongenerator.net -->
      <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url() ?>images/favicon/apple-touch-icon.png">
      <link rel="icon" type="image/png" href="<?php echo base_url() ?>images/favicon/favicon-32x32.png" sizes="32x32">
      <link rel="icon" type="image/png" href="<?php echo base_url() ?>images/favicon/favicon-16x16.png" sizes="16x16">
      <link rel="manifest" href="<?php echo base_url() ?>images/favicon/manifest.json">
      <link rel="mask-icon" href="<?php echo base_url() ?>images/favicon/safari-pinned-tab.svg" color="#5bbad5">
      <meta name="theme-color" content="#ffffff">
   </head>
   <body class="auth-body-bg">
      <div>
         <div class="container-fluid p-0">
            <div class="row no-gutters">
               <!-- end col -->
               <div class="col-lg-3">
                  <div class="auth-full-page-content p-md-5 p-4">
                     <div class="w-100">
                        <div class="d-flex flex-column h-100">
                           <div class="brand-logo">
                              <a href="/" class="d-block auth-logo">
                              <?php echo $this->settings->info->site_name ?>
                              </a>
                           </div>
                           <div class="my-auto login-block">
                              <div class="pb-2">
                                 <h5 class="text-primary">Welcome Back !</h5>
                                 <p class="text-muted">Sign in to continue to <?php echo $this->settings->info->site_name ?>.</p>
                              </div>

                              <?php 
                              $gl = $this->session->flashdata('globalmsg'); ?>
                              <?php if(!empty($gl)) :?>
                              <div class="alert alert-success"><b><span class="glyphicon glyphicon-ok"></span></b> <?php echo $this->session->flashdata('globalmsg') ?></div>
                              <?php endif; ?>


                              <div class="mt-4">
                                 <!-- <form action="<?php echo base_url('login/pro'); ?>" id="login_form" class="login-form"> -->
                                 <?php if(isset($_GET['redirect'])) : ?>
                                 <?php echo form_open(site_url("login/pro/" . urlencode($_GET['redirect'])), array("id" => "login_form")) ?>
                                 <?php else : ?>
                                 <?php echo form_open(site_url("login/pro"), array("id" => "login_form")) ?> 
                                 <?php endif; ?>
                                 
                                    <div class="form-group">
                                       <label for="username">Email or Username</label>
                                       <input type="email"  name="email" class="form-control" id="email" placeholder="Enter Email or Username">
                                    </div>
                                    <div class="form-group">
                                       <label for="userpassword">Password</label>
                                       <input type="password"  name="pass" class="form-control" id="userpassword" placeholder="Enter password">
                                    </div>
                                    <!-- <div class="custom-control custom-checkbox">
                                       <input type="checkbox" class="custom-control-input" id="auth-remember-check">
                                       <label class="custom-control-label" for="auth-remember-check">Remember me</label>
                                       </div> -->
                                    <div class="mt-3">
                                       <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Log In</button>

                                       <div class="float-left mt-1">
                                          <a href="<?php echo site_url('login/forgotpw') ?>" class="text-muted">Forgot password?</a>
                                       </div>

                                    </div>
                                 </form>
                              </div>
                           </div>
                           <div class="footer-block text-center text-muted">
                              <p class="mb-0">
                                 © <script>document.write(new Date().getFullYear())</script> <?php echo $this->settings->info->site_name ?>. Crafted with <i class="mdi mdi-heart text-danger"></i> by <?php echo $this->settings->info->site_name ?>
                              </p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- end col -->
               <div class="col-lg-9 p-0">
                  <div class="auth-full-bg pt-lg-5 p-4">
                     <div class="w-100">
                        <div class="bg-overlay"></div>
                        <div class="d-flex h-100 flex-column">
                           <!-- <div class="content-block">
                              <div class="row justify-content-center">
                                 <div class="col-lg-12">
                                    <div class="text-center">
                                       <h4 class="mb-3"><i class="bx bxs-quote-alt-left text-primary h1 align-middle mr-3"></i><span class="text-primary">5k</span>+ Satisfied clients</h4>
                                       
                                       <div class="text-box">
                                          <p>
                                             " Fantastic theme with a ton of options. If you just want the HTML to integrate with your project, then this is the package. You can find the files in the 'dist' folder...no need to install git and all the other stuff the documentation talks about. "
                                          </p>
                                          <h5>ABS 16161</h5>
                                          <p>- Username </p>
                                       </div>
                              
                                    </div>
                                 </div>
                              </div>
                              </div> -->
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- end row -->
         </div>
         <!-- end container-fluid -->
      </div>
      <!-- SCRIPTS -->
      <script type="text/javascript">
         var global_base_url = "<?php echo site_url('/') ?>";
         
      </script>
      <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
      <script src="<?php echo base_url();?>bootstrap/js/bootstrap.min.js"></script>
      <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
      
      <script type="text/javascript">
  $(document).ready(function() {
    var form = "login_form";
    $('#'+form + ' input').on("focus", function(e) {
      clearerrors();
    });
    $('#'+form).on("submit", function(e) {

      e.preventDefault();
      // Ajax check
      var data = $(this).serialize();
      $.ajax({
        url : global_base_url + "login/ajax_check_login",
        type : 'POST',
        data : {
          formData : data,
          '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash() ?>'
        },
        dataType: 'JSON',
        success: function(data) {
          if(data.error) {
            $('#'+form).prepend('<div class="form-error">'+data.error_msg+'</div>');
          }
          if(data.success) {
            // allow form submit
            $('#'+form+ ' input[type="submit"]').val("Logging In ...");
            $('#'+form).unbind('submit').submit();
          }
          if(data.field_errors) {
            var errors = data.fieldErrors;
            console.log(errors);
            for (var property in errors) {
                if (errors.hasOwnProperty(property)) {
                    // Find form name
                    var field_name = '#' + form + ' input[name="'+property+'"]';
                    $(field_name).addClass("errorField");
                    // Get input group of field
                    $('#'+form).prepend('<div class="form-error">'+errors[property]+'</div>');
                    

                }
            }
          }
        }
      });

      return false;


    });
  });

  function clearerrors() 
  {
    console.log("Called");
    $('.form-error').remove();
    $('.errorField').removeClass('errorField');
  }
</script>


   </body>
</html>