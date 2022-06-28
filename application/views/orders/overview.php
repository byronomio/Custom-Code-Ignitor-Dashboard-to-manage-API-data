
<style type="text/css" media="screen">
   .order-overview-page .card {
   margin-bottom: 24px;
   -webkit-box-shadow: 0 0.75rem 1.5rem rgba(18,38,63,.03);
   box-shadow: 0 0.75rem 1.5rem rgba(18,38,63,.03);
   }
   .order-overview-page .circle-icon {
   background: #556ee6;
   padding: 12px;
   border-radius: 50%;
   color: #FFF;
   font-size: 22px;
   }

   .order-overview-page .media-heading{
      font-size: 14px;
      font-weight: 600;
      margin: 0;
      margin-top: 12px;
      color: #FFF;
   }
   

   .order-overview-page .media-body span{
      color: #FFF;
      font-size: 14px;
   }
   .order-overview-page .card-body{
   -webkit-box-flex: 1;
   -ms-flex: 1 1 auto;
   flex: 1 1 auto;
   min-height: 1px;
   padding: 1.5rem;
   background: #2a3042;
   border-radius: 4px;
   }
   
   .order-overview-page .table-responsive{
   margin-top: 10px;
   }
   .order-overview-page .table td, .order-overview-page .table th {
   padding: 0.40rem;
   vertical-align: top;
   border-top: 1px solid #eff2f7;
   color: #FFF;
   }
   .order-overview-page .table {
   margin-bottom: 0px;
   }
   .order-overview-page .table td p{
   margin: 0px;  
   }
   .order-overview-page .table td h5{
   font-size: 14px;
   font-weight: 600;
   text-align: right;
   }
   .order-overview-page .progress {
   height: 5px;
   margin-bottom: 0px;
   }
   .progress-bar-default {
       background-color: #777;
   }
   .progress-bar-orange{
      background-color: orange;  
   }
    .progress-bar-default{
      background-color: grey;  
   }
   .order-overview-page .page-header-title{
      color: #FFF;
      padding-bottom: 5px;
   }
   .order-overview-page p a{
      color: #FFF;
   }
   .order-overview-page p a:hover{
      text-decoration: none;
      color: #d7d5d9;
   }
   .order-overview-page .page-header-link{
      color: #FFF;
   }
</style>
<div class="order-overview-page">
      
   <?php 
   if($access_company_orders != ""){

      $CI =& get_instance();
      $CI->load->model('Order_model');

      $send_company_list = explode(',', $access_company_orders);
      foreach ($send_company_list as $key => $send_company) {
      $company_list = $CI->Order_model->company_list($send_company);
      if(count($company_list) != 0){

         echo '
         <div class="db-header clearfix">
            <div class="page-header-title"> 
               <a class="page-header-link" href="'.base_url('orders?send-company='.$send_company).'">'.$send_company.'</a>
            </div>
         </div>';

         echo '<div class="row">';
         
            foreach ($company_list as $key_company => $row) {
               
               $total_orders = $row->total;

               echo
               '<div class="col-md-3 col-sm-3 col-lg-3">
                     <div class="card">
                        <div class="card-body">
                           <div class="card-title">
                              <div class="media">
                                 <div class="media-body">
                                    <h4 class="media-heading">'.$row->Company.'</h4>
                                    <span>Total Orders : '.$total_orders.'</span>
                                 </div>
                              </div>
                              <div class="table-responsive">
                                 <table class="table table-centered table-nowrap">
                                    <tbody>';

                                    foreach ($order_status as $key_status => $status) {
                                       
                                       $order_count = $CI->Order_model->count_overview_orders($send_company, $row->Company, $status);

                                       $new_width = ($order_count * 100) / $total_orders;

                                       echo '
                                       <tr>
                                          <td style="width: 30%">
                                             <p class="mb-0 '.$status.'"><a href="'.base_url('orders?site='.$row->Company.'&status='.$status).'">'.ucfirst($status).'</a></p>
                                          </td>
                                          <td style="width: 25%">
                                             <h5 class="mb-0 '.$status.'-order-count">'.number_format($order_count).'</h5>
                                          </td>
                                       </tr>';
                                    }


                              echo  '</tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
               </div>';



            }
         echo '</div>';



      }
      
   }
      
   }

   
   ?>
      



  

   
</div>
