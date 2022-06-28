<div class="white-area-content">
   <div class="db-header clearfix">
      <div class="page-header-title"> <span class="glyphicon glyphicon-user"></span> <?php echo lang("ctn_1") ?></div>
      <div class="db-header-extra">
      </div>
   </div>
   <ol class="breadcrumb">
      <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_1") ?></a></li>
      <li><a href="<?php echo site_url("admin") ?>"><?php echo lang("ctn_1") ?></a></li>
      <li><a href="<?php echo site_url("admin/user_groups") ?>"><?php echo lang("ctn_15") ?></a></li>
      <li class="active"><?php echo lang("ctn_16") ?></li>
   </ol>
   <p><?php echo lang("ctn_17") ?></p>
   <hr>
   <div class="panel panel-default">
      <div class="panel-body">
         <?php echo form_open(site_url("admin/edit_group_pro/" . $group->ID), array("class" => "form-horizontal")) ?>
         <div class="form-group">
            <label for="email-in" class="col-md-3 label-heading"><?php echo lang("ctn_18") ?></label>
            <div class="col-md-9">
               <input type="text" class="form-control" id="email-in" name="name" value="<?php echo $group->name ?>">
            </div>
         </div>
         <div class="form-group">
            <label for="email-in" class="col-md-3 label-heading"><?php echo lang("ctn_19") ?></label>
            <div class="col-md-9">
               <input type="checkbox" name="default_group" value="1" <?php if($group->default) echo "checked" ?>>
               <span class="help-block"><?php echo lang("ctn_20") ?></span>
            </div>
         </div>

         <div class="form-group">
            <label for="username-in" class="col-md-3 label-heading">Access Company Orders </label>
            <div class="col-md-9">
               
               <div class="company-block">
                  <?php
                  $raw_company_list = $group->access_company_orders;
                  $array_company_list = explode(',', $raw_company_list);
                  foreach ($company_list as $key => $value) {

                     if(in_array($value->SendCompany, $array_company_list)){
                        $checked = "checked='checked'";
                     }else{
                        $checked = "";
                     }


                     echo '<div><input type="checkbox" name="company_list[]" '.$checked.' value="'.$value->SendCompany.'"> '.$value->SendCompany.'</div>';
                  }
                  ?>
               </div>
            </div>
         </div>


         <input type="submit" class="form-control btn btn-primary" value="<?php echo lang("ctn_13") ?>" />
         <?php echo form_close() ?>
      </div>
   </div>
</div>