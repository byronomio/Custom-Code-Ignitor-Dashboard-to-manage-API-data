<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <title>New Password - WooDash</title>
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
                                 <h5 class="text-primary"><?php echo lang("ctn_185") ?></h5>
                                 <p class="text-muted"><?php echo lang("ctn_186") ?>.</p>
                              </div>

                              <?php $gl = $this->session->flashdata('globalmsg'); ?>

                             <?php if(!empty($gl)) :?>

                               <div class="alert alert-success"><b><span class="glyphicon glyphicon-ok"></span></b> <?php echo $this->session->flashdata('globalmsg') ?></div> 

                             <?php endif; ?>


                              <div class="mt-4">
                                 <?php echo form_open(site_url("login/resetpw_pro/" . $token . "/" . $userid)) ?>
                                    <div class="form-group">
                                       <label for="username"><?php echo lang("ctn_187") ?></label>
                                       <input type="password" class="form-control"  id="password-in" name="npassword" placeholder='<?php echo lang("ctn_187") ?>'>
                                    </div>

                                    <div class="form-group">
                                       <label for="username"><?php echo lang("ctn_188") ?></label>
                                       <input type="password" class="form-control"  id="password-in" name="npassword2" placeholder='<?php echo lang("ctn_188") ?>'>
                                    </div>
                                    
                                    <div class="mt-3">
                                       <button class="btn btn-primary btn-block waves-effect waves-light" type="submit"><?php echo lang("ctn_185") ?></button>
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
  
      </script>


   </body>
</html>