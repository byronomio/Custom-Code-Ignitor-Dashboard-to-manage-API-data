<style type="text/css" media="screen">
   .order-page td.details-control {
   background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
   cursor: pointer;
   }
   .order-page tr.shown td.details-control {
   background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
   }    
   .order-page .gocover{
    width: 20px;
    display: none;
   }
   .order-page #example_filter{
    display: none;
   }
   .order-page #example .details-control{
    padding:15px;
   }
   .order-page #example .dt-checkboxes, #example .dt-checkboxes-switch{
    margin: 5px;
   }
   .order-page .btn-order-update{
    float: right;
    display: none;
   }
   .order-page .order-subtitle{
    padding-bottom: 5px;
   }
   .order-page .close .glyphicon-remove{
    color: #FFFFFF;
    position: absolute;
    top: 10px;
    right: 10px;
   }
   .order-page .db-header-extra{
    width: 50%;
   }
   .order-page .db-header-extra .form-group{
    float:right;
   }
   .order-page .width-expand{
    width: 220px;
   }
   .order-page select option{
    color:#000;
   }
   .order-page .order-items td, th {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 5px 10px;
    }

  .order-page table.order-items  {
    border-collapse: collapse;
    border: 1px solid #ddd;
  }
  .order-page .order-status-count-block{
    margin-bottom: 14px;
  }
  .order-page .btn-status-count span{
    margin-right: 10px;
    cursor: pointer;
  }
  

</style>




<div class="white-area-content order-page">
   <div class="db-header clearfix">
      <div class="page-header-title"> <span class="glyphicon glyphicon-home"></span> Orders
      </div>

      <div class="db-header-extra form-inline">
         <div class="form-group has-feedback no-margin">

            <div class="input-group width-expand">
              <input type="text" name="dates" id="from_to_date" class="form-control input-sm" placeholder="Order from & to date...">
            </div>

            <div class="input-group">
               
               <!-- <input type="text" name="dates" id="dates" class="form-control input-sm" placeholder="Search ..."> -->

               <input type="text" class="form-control input-sm" placeholder="Search ..." id="form-search-input">

               <div class="input-group-btn">
                  <input type="hidden" id="search_type" value="0">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
               </div>
               <!-- /btn-group -->
            </div>
         </div>
      </div>

   </div>
   <ol class="breadcrumb">
    <li><a href="<?php echo site_url('/'); ?>">Home</a></li>
    <li class="active">Orders</li>
   </ol>
   <div class="row">
      <div class="col-md-7">
           <p class="order-subtitle">Below you can view orders for the site below.</p>
      </div>
      <div class="col-md-5">
        
        <div>
          <button type="button" class="btn btn-primary btn-export-csv float-right"><span class="glyphicon glyphicon-paperclip" data-action="<?php echo base_url('/orders/export_csv'); ?>"></span> Export to CSV</button>
        </div>
        
        <div>
          <button type="button" class="btn btn-primary btn-order-update" data-toggle="modal" data-target="#update_order_status"><span class="glyphicon glyphicon-cog"></span> Update Order Status</button>
        </div>

      </div>
   </div>

   <hr>

   <div class="row order-status-count-block">
     <div class="col-md-12">
       <div class="btn-status-count">
         <span class="order-completed" data-type="completed"><?php echo $completed_order_count; ?> Completed</span>
         <span class="order-shipped" data-type="shipped"><?php echo $shipped_order_count; ?> Shipped</span>
         <span class="order-processing" data-type="processing"><?php echo $processing_order_count; ?> Processing</span>
         <span class="order-pending" data-type="pending"><?php echo $pending_order_count; ?> Pending</span>
         <span class="order-on-hold" data-type="on-hold"><?php echo $on_hold_order_count; ?> On-Hold</span>
         <span class="order-cancelled" data-type="cancelled"><?php echo $cancelled_order_count; ?> Cancelled</span>
         <span class="order-refunded" data-type="refunded"><?php echo $refunded_order_count; ?> Refunded</span>
         <span class="order-failed" data-type="failed"><?php echo $failed_order_count; ?> Failed</span>
       </div>
     </div>
   </div>

   <div class="table-responsive">
      <table id="example" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
         <thead>
            <tr class="table-header">
               <th style="width: 30px;"></th>
               <th><input type="checkbox" name="switch-checkbox" class="dt-checkboxes-switch" autocomplete="off"></th>
               <!-- <td>ID</td> -->
               <td>WaybillNo</td>
               <td>Company</td>
               <!-- <td>SendCompany</td> -->
               <td>FullAddress</td>
               <td>OrderStatus</td>
               <!--  <td>OrderCreated</td> -->
               <td>OrderModified</td>
               <th style="width: 80px" >Action</th>
            </tr>
         </thead>
         <tfoot>
            <tr>
               <th style="width: 30px;"></th>
               <th></th>
               <td>WaybillNo</td>
               <td>Company</td>
               <!-- <td>SendCompany</td> -->
               <td>FullAddress</td>
               
               <td>OrderStatus</td>
               <!-- <td>OrderCreated</td> -->
               <td>OrderModified</td>
               <th style="width:80px;">Action</th>
            </tr>
         </tfoot>
        
      </table>
   </div>
   <div id="edit_order" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title" id="myModalLabel"><i class="la la-bank text-primary"></i> Edit Order</h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true" class="glyphicon glyphicon-remove"></span>
               </button>
            </div>
            <form name="edit_order" id="frmPost" action="<?php echo base_url()?>orders/edit" method="post" enctype="multipart/form-data" data-redirect-url=""  onsubmit="return false;">
               <input type="hidden" name="id"  value="">
               <div class="modal-body">

                <div class="row">
                  <div class="col-md-6">

                    <div class="form-group">
                       <label for="bs">RecAdd1*</label>
                       <input type="text" class="form-control form-control-solid" name="RecAdd1" id="RecAdd1" value="" placeholder="RecAdd1" required >
                    </div>
                    
                  </div>
                  <div class="col-md-6">
                    
                    <div class="form-group">
                     <label for="bs">RecAdd2*</label>
                     <input type="text" class="form-control form-control-solid" name="RecAdd2" id="RecAdd2" value="" placeholder="RecAdd2" required >
                    </div>

                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                       <label for="bs">RecAdd3*</label>
                       <input type="text" class="form-control form-control-solid" name="RecAdd3" id="RecAdd3" value="" placeholder="RecAdd3" required >
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                     <label for="bs">RecAdd4*</label>
                     <input type="text" class="form-control form-control-solid" name="RecAdd4" id="RecAdd4" value="" placeholder="RecAdd4" required >
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                       <label for="bs">RecAdd5*</label>
                       <input type="text" class="form-control form-control-solid" name="RecAdd5" id="RecAdd5" value="" placeholder="RecAdd5" required >
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                       <label for="bs">RecContactPerson*</label>
                       <input type="text" class="form-control form-control-solid" name="RecContactPerson" id="RecContactPerson" value="" placeholder="RecContactPerson" required >
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                       <label for="bs">RecWorkTel*</label>
                       <input type="text" class="form-control form-control-solid" name="RecWorkTel" id="RecWorkTel" value="" placeholder="RecWorkTel" required >
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                       <label for="bs">RecCell*</label>
                       <input type="text" class="form-control form-control-solid" name="RecCell" id="RecCell" value="" placeholder="RecCell" required >
                    </div>
                  </div>
                </div>   
                <div class="form-group">
                   <label for="bs">OrderStatus*</label>
                   <select name="OrderStatus" class="form-control form-control-solid" id="OrderStatus"required>
                      <option value="">Select..</option>
                      <option value="completed">Completed</option>
                      <option value="shipped">Shipped</option>
                      <option value="processing">Processing</option>
                      <option value="pending">Pending</option>
                      <option value="on-hold">On-Hold</option>
                      <option value="cancelled">Cancelled</option>
                      <option value="refunded">Refunded</option>
                      <option value="failed">Failed</option>
                   </select>
                </div>

                <div class="form-group">
                  <div class="text-danger" id="message"></div>
                </div>

               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-primary btn-update">
                    <img src="<?php echo base_url()?>images/loader.gif" class="gocover">
                  Update</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               </div>
            </form>
         </div>
      </div>
   </div>

   <div id="update_order_status" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title" id="myModalLabel"><i class="la la-bank text-primary"></i> Edit Order Status</h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true" class="glyphicon glyphicon-remove"></span>
               </button>
            </div>
            <form name="update_order_status" id="frmPostMultipleOrderStatus" action="<?php echo base_url()?>orders/multiple_edit" method="post" enctype="multipart/form-data" data-redirect-url=""  onsubmit="return false;">
               <input type="hidden" name="ids"  value="">
               <div class="modal-body">
                  <div class="form-group">
                     <label for="bs">OrderStatus*</label>
                     <select name="MultipleOrderStatus" class="form-control form-control-solid" id="MultipleOrderStatus" required>
                        <option value="">Select..</option>
                        <option value="completed">Completed</option>
                        <option value="shipped">Shipped</option>
                        <option value="processing">Processing</option>
                        <option value="pending">Pending</option>
                        <option value="on-hold">On-Hold</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="refunded">Refunded</option>
                        <option value="failed">Failed</option>
                     </select>
                  </div>

                  <div class="form-group">
                    <div class="text-danger" id="multiple-order-form-message"></div>
                  </div>

               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-primary btn-order-update-status">
                  Update</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               </div>
            </form>
         </div>
      </div>
   </div>

</div>
<!-- <script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>
<script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js" type="text/javascript"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.22/sorting/datetime-moment.js" type="text/javascript"></script>
--> 

<script>


   /* Formatting function for row details - modify as you need */
   function format ( d ) {
      // `d` is the original data object for the row
       return '<table cellpadding="5" cellspacing="0" border="0" style="width: 100%;">'+
           '<tr>'+
               '<td>RecAdd1:</td>'+
               '<td>'+d[8]+'</td>'+
           '</tr>'+
           '<tr>'+
               '<td>RecAdd2:</td>'+
               '<td>'+d[9]+'</td>'+
           '</tr>'+
           '<tr>'+
               '<td>RecAdd3:</td>'+
               '<td>'+d[10]+'</td>'+
           '</tr>'+
           '<tr>'+
               '<td>RecAdd4:</td>'+
               '<td>'+d[11]+'</td>'+
           '</tr>'+
           '<tr>'+
               '<td>RecAdd5:</td>'+
               '<td>'+d[12]+'</td>'+
           '</tr>'+
           '<tr>'+
               '<td>RecContactPerson:</td>'+
               '<td>'+d[13]+'</td>'+
           '</tr>'+
           '<tr>'+
               '<td>RecCell:</td>'+
               '<td>'+d[14]+'</td>'+
           '</tr>'+
           '<tr>'+
               '<td>ServiceType:</td>'+
               '<td>'+d[15]+'</td>'+
           '</tr>'+
           '<tr>'+
               '<td>OrderShippingTotal:</td>'+
               '<td>'+d[16]+'</td>'+
           '</tr>'+
           '<tr>'+
               '<td>OrderTotal:</td>'+
               '<td>'+d[17]+'</td>'+
           '</tr>'+
           '<tr>'+
               '<td>OrderPaymentMethodTitle:</td>'+
               '<td>'+d[18]+'</td>'+
           '</tr>'+
           '<tr>'+
               '<td>OrderItems:</td>'+
               '<td>'+d[19]+'</td>'+
           '</tr>'+
           
       '</table>';
   }
   
   $(function (){

      $('[data-toggle="tooltip"]').tooltip();

      $('.gocover').show();

       //$.fn.dataTable.moment('YYYY-MM-DD HH:mm:ss');

       var table = $('#example').DataTable( {
          /*"dom": "Bfrtip",*/
          "dom" : "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
          "pagingType" : "full_numbers",
          "pageLength" : 15,
          "serverSide": true,
          "orderMulti": false,
          
          "ajax": {
               url: "<?php echo site_url("orders/orders_page/0") ?>",
               type: 'GET',
               data: function(d) {
                  d.search_type = $('#search_type').val();
                  d.order_created_date_range = $('#from_to_date').val();
               }
           },
            
            columnDefs: [
              { orderable: false, targets: 1 }
            ],
           //columnDefs: [ { type: 'date', 'targets': 7 } ],
           columns: [
               {
                   "className":      'details-control',
                   "orderable":      false,
                   "data":           null,
                   "defaultContent": '',
               },
               null,
               null,
               null,
               null,
               null,
               null,
               null,
               /*null,
               null,*/
               //{ data: "salary", render: $.fn.dataTable.render.number( ',', '.', 0, '$' ) }
           ],
           order: [[ 6, "desc" ]],
           //"columnDefs" : [{"targets":7, "type":"date-eu"}],
           select: {
               style:    'os',
               selector: 'td:first-child'
           },
            drawCallback: function(settings, json) {
              $('[data-toggle="tooltip"]').tooltip();
            },
            initComplete: function (row, data, dataIndex) {
              //console.log(data.data[0][20]);
              this.api().columns([3, 5]).every( function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on('change', function () {
                        var val = $(this).val(); 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );

                    // 3 Company, 5 Order Status
                    if(column[0][0] == 3){
                        select.append('<?php echo $company_options; ?>');

                        var site = getUrlParameter('site');
                        if(site != undefined || site != ""){
                          $('#example select:eq(0) option[value="'+site+'"]').prop("selected", true);
                        }

                    }

                    if(column[0][0] == 5){
                      var status = getUrlParameter('status');

                      var completed_selected = (status=='completed') ? "selected" : "";
                      select.append('<option value="completed" '+completed_selected+'>Completed</option>');  
                      var shipped_selected = (status=='shipped') ? "selected" : "";
                      select.append('<option value="shipped" '+shipped_selected+'>Shipped</option>');
                      
                      var processing_selected = (status=='processing') ? "selected" : "";
                      select.append('<option value="processing" '+processing_selected+'>Processing</option>');
                      
                      var pending_selected = (status=='pending') ? "selected" : "";
                      select.append('<option value="pending" '+pending_selected+'>Pending</option>');

                      var on_hold_selected = (status=='on-hold') ? "selected" : "";
                      select.append('<option value="on-hold" '+on_hold_selected+'>On-Hold</option>');  
                      
                      var cancelled_selected = (status=='cancelled') ? "selected" : "";
                      select.append('<option value="cancelled" '+cancelled_selected+'>Cancelled</option>');

                      var refunded_selected = (status=='refunded') ? "selected" : "";  
                      select.append('<option value="refunded" '+refunded_selected+'>Refunded</option>'); 

                      var failed_selected = (status=='failed') ? "selected" : "";  
                      select.append('<option value="failed" '+failed_selected+'>Failed</option>'); 

                    }
                  
                    

                /*column.data().unique().sort().each( function ( d, j ) {
                  if(d != ""){
                    select.append( '<option value="'+d+'">'+d+'</option>' )  
                  }
                });*/
              });

            }

       } );
   
       // Add event listener for opening and closing details
       $('#example tbody').on('click', 'td.details-control', function () {
           var tr = $(this).closest('tr');
           var row = table.row( tr );
    
           if ( row.child.isShown() ) {
               // This row is already open - close it
               row.child.hide();
               tr.removeClass('shown');
           }
           else {
               // Open this row
               row.child( format(row.data()) ).show();
               tr.addClass('shown');
           }
       } );
    
        
        $('body').on('keyup', '#form-search-input', function () {
              table.search($(this).val()).draw();
        })

   
        $('body').on('click', '.edit-order', function () {
           
           var id = $(this).data('id');
           var RecAdd1 = $(this).data('recadd1');
           var RecAdd2 = $(this).data('recadd2');
           var RecAdd3 = $(this).data('recadd3');
           var RecAdd4 = $(this).data('recadd4');
           var RecAdd5 = $(this).data('recadd5');
           var RecContactPerson = $(this).data('reccontactperson');
           var RecCell = $(this).data('reccell');
           var RecWorkTel = $(this).data('recworktel');
           var OrderStatus = $(this).data('orderstatus');
           
           $('input[name="id"]').val(id);
           $('input[name="RecAdd1"]').val(RecAdd1);
           $('input[name="RecAdd2"]').val(RecAdd2);
           $('input[name="RecAdd3"]').val(RecAdd3);
           $('input[name="RecAdd4"]').val(RecAdd4);
           $('input[name="RecAdd5"]').val(RecAdd5);
           $('input[name="RecContactPerson"]').val(RecContactPerson);
           $('input[name="RecCell"]').val(RecCell);
           $('input[name="RecWorkTel"]').val(RecWorkTel);
           $('select[name="OrderStatus"] option[value="'+OrderStatus+'"]').attr('selected', 'selected');
           $('#edit_order').modal('show');
           $('.gocover').hide();
        });


        $('body').on('click', '.btn-update', function () {

          $('.gocover').show();  
          $('#message').html('');
          var action_url = $('#frmPost').attr('action');

            $.ajax({
                  url: action_url,
                  type: "GET",
                  data: $('#frmPost').serialize(),
                  contentType: false,
                  cache: false,
                  processData: false,
                  success: function (res) {
                      //$('.gocover').hide();  
                      var message = res.message;
                      var status = res.status;
                      var host = window.location.protocol+'//'+window.location.hostname+'/';

                      if(status == "error"){
                        $('#message').html(message);
                      }else{
                        $('#edit_order').modal('hide');
                        //location.reload();
                      }
                      $('.gocover').hide();
                      table.draw();
                      $.getJSON(host+"cron/cronjobs_for_order_update", function(result){
                          //console.log(result);
                      });
                  }
            });
        });


        $('body').on('click', '.dt-checkboxes', function () {
            var checked = $(this).attr("checked");
            if(checked == "checked"){
              $(this).removeAttr('checked');
            }else{
              $(this).attr("checked", "checked");
            }

            var ids = $('.dt-checkboxes:checked').map(function() {
                return this.value;
            }).get().join();
            if(ids == ""){
              $('input[name="ids"]').val('');
              $('.btn-order-update').hide();
            }else{
              $('input[name="ids"]').val(ids);
              $('.btn-order-update').show();
            }
        });


        $('body').on('click', '.btn-order-update-status', function () {

            var action_url = $('#frmPostMultipleOrderStatus').attr('action');
            $('#multiple-order-form-message').html('');
            $.ajax({
                  url: action_url,
                  type: "GET",
                  data: $('#frmPostMultipleOrderStatus').serialize(),
                  contentType: false,
                  cache: false,
                  processData: false,
                  success: function (res) {
                      var message = res.message;
                      var status = res.status;
                      var host = window.location.protocol+'//'+window.location.hostname+'/';

                      if(status == "error"){
                        $('#multiple-order-form-message').html(message);
                      }else{
                        $('#update_order_status').modal('hide');
                      }
                      
                      table.draw();
                      $.getJSON(host+"cron/cronjobs_for_order_update", function(result){
                          //console.log(result);
                      });
                  }
            });

        });


        $('body').on('click', '.btn-export-csv', function () {
            var company = $('#example select:eq(0)').val();
            var status = $('#example select:eq(1)').val();
            var keyword = $('#form-search-input').val();
            var order_created_date_range = $('#from_to_date').val();
            var host = window.location.protocol+'//'+window.location.hostname+'/';
            
            var url = host+'orders/export_csv?company='+company+'&status='+status+'&keyword='+keyword+'&order_created_date_range='+order_created_date_range;
            window.location.href = url;

        });


        $('#from_to_date').daterangepicker({
            autoUpdateInput: false,
            opens:'left',
            //autoApply:true,
            locale: {
              format: 'YYYY-MM-DD'
            }
          },function(start, end, label) {
            $('#from_to_date').val(start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            table.draw();
        });

        $('#from_to_date').on('cancel.daterangepicker', function(ev, picker) {
          //do something, like clearing an input
          $('#from_to_date').val('');
        });

        var site = getUrlParameter('site');
        if(site != undefined){
          $('#example select:eq(0) option[value="'+site+'"]').prop("selected", true);
          table.columns(3).search('^'+site+'$').draw();
        }

        var status = getUrlParameter('status');
        if(status != undefined){
          $('span.order-'+status).addClass('active');
          table.columns(5).search('^'+status+'$').draw();
        }

        $('.btn-status-count span').click(function(){
          var status = $(this).attr('data-type');
          if ($('.order-'+status+'.active').length) {
            $('.btn-status-count span').removeClass('active');
            $('#example select:eq(1) option[value=""]').prop("selected", true);
            table.columns(5).search('').draw();
          }else{

            $('.btn-status-count span').removeClass('active');
            $(this).addClass('active');
            $('#example select:eq(1) option[value="'+status+'"]').prop("selected", true);
            table.columns(5).search('^'+status+'$').draw();

          }
        })

    
       

   
   } );



$(document).ready(function() {
  $('[data-toggle="tooltip"]').tooltip();


  $('.dt-checkboxes-switch').change(function(){
    $('.dt-checkboxes').trigger('click');
  });

});


var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};



</script>