<!DOCTYPE html>
<html>
   <head>
   </head>
   <body style="font-family: Arial, Helvetica, sans-serif;">
      <div class="container">
         <div class="main" style="padding:15px;">
            <div class="row">
               <div class="col-md-12">
                  <div class="text-center font-weight-bold" style="text-align: center;">
                     <h3>Packing slip</b></h3>
                  </div>
               </div>
            </div>
            <div class="row" style="">
               <div class="col-md-4">
                  <div class="brand-logo text-left">
                     <img src="https://dashboard.wooapi.co.za/images/sitelogos/<?php echo $site_detail->sitelogo;?>" >
                  </div>
               </div>
               <div class="col-md-8"></div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="content text-left" style="margin-bottom: 1.5%;">
                     <span>Email: <?php echo $site_detail->email;?></span><br>
                     <span>Tel: <?php echo $site_detail->phonenumber;?></span>
                  </div>
                  <hr class="large-hr" style="border-top: 5px solid #CCC; color:#ccc; height: 3px;">
               </div>
            </div>
            <div class="row">
               <div style="width: 60%; float:left; background: #FFF;">
                  <span>Shipping Details:</span><br>
                  <span><?php echo $order->RecContactPerson;?></span><br>
                  <span><?php echo $order->RecAdd1;?></span><br>
                  <span><?php echo $order->RecAdd2;?></span><br>
                  <span><?php echo $order->RecAdd3;?></span><br>
                  <span><?php echo $order->RecAdd4;?></span><br>
                  <span><?php echo $order->RecAdd5;?></span><br>
                  <span><?php echo $order->RecCell;?></span><br>
                 
               </div>
               <div style="width: 20%; float:right; background: #eef6ff;">
                  <div style="padding-top: 10px; padding-bottom: 10px;">
                     <span><?php echo $order->WaybillNo;?></span><br>
                     <span><?php echo date("d/m/Y", strtotime($order->OrderCreated));?></span><br>
                  </div>
               </div>
               <div style="width: 20%; background: #eef6ff;">
                  <div style="padding-top: 10px; padding-left: 10px; padding-bottom: 10px;">
                     <span>Order No:</span><br>
                     <span>Order date</span><br>
                  </div>
               </div>
            </div>
            <div style="margin-top:50px; width: 100%;">
               <table style="width: 100%;">
                  <thead>
                     <tr style="background: #609bfd; font-size: 1rem; color:#fff">
                        <!-- <th style="width: 10%;"></th> -->
                        <th style="width: 90%; color: #fff;">Product</th>
                        <th style="width: 10%; color: #fff;">Qty</th>
                     </tr>
                  </thead>
                  <tbody>

                  <?php

                  $order_items = $order->OrderItems;
                  //echo $order_items;

                  if($order_items != null){ 

                  $replace_own_patter = str_replace(" ", "~", $order_items);
                  if (strpos($replace_own_patter, '~,~') !== false) {

                     $multi_items = explode('~,~', $replace_own_patter);
                     
                     foreach ($multi_items as $key_items => $value) {

                     $o_sku = explode(',', $value);
                     $sku = $o_sku[0];
                     $product_name = str_replace("~", " ", $o_sku[1]);
                     $qty =   str_replace("~", " ", $o_sku[2]);
                     $price = str_replace("~", " ", $o_sku[3]);

                     ?>

                     <tr>
                        <td style="width: 90%;">
                           <span><?php echo $product_name; ?></span><br>
                           <span>SKU: <?php echo $sku; ?></span>
                        </td>
                        <td style="width: 10%; text-align: center;">
                           <span style="align-items: center;justify-content: center;"><?php echo $qty; ?></span>
                        </td>
                     </tr>

                  <?php }  } else {


                  $o_sku = explode(',', $order->OrderItems);
                  $sku = $o_sku[0];
                  $product_name = $o_sku[1];
                  $qty = $o_sku[2]; 
                  $price = $o_sku[3];

                  ?>

                   <tr>
                        <td style="width: 90%;">
                           <span><?php echo $product_name; ?></span><br>
                           <span>SKU: <?php echo $sku; ?></span>
                        </td>
                        <td style="width: 10%; text-align: center;">
                           <span style="align-items: center;justify-content: center;"><?php echo $qty; ?></span>
                        </td>
                  </tr>


                  <?php } } ?>

                     
                     <tr>
                        <!-- <td style="width: 10%;text-align: center;">
                        </td> -->
                        <td style="width: 90%;">
                           <?php
                           $service_type = $order->ServiceType;
                           $shipping_total = $order->OrderShippingTotal;
                           if($service_type == "ECON" && $shipping_total != 0){
                              echo '<span>Econo Delivery (3 - 5 Business Days)</span><br>';
                           }

                           if($service_type == "ECON" && $shipping_total == 0){
                              echo '<span>Free Econo Delivery (3 - 5 Business Days)</span><br>';
                           }

                           if($service_type == "ONX"){
                              echo '<span>Express Delivery (2 - 3 Business Days) - Door to Door</span><br>';
                           }
                           ?>
                           <!-- <span>Econo Delivery (3 - 5 Business Days)</span><br> -->
                        </td>
                        <td style="width: 10%;">
                        </td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
      </div>
   </body>
</html>