<style type="text/css" media="screen">
   td.details-control {
   background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
   cursor: pointer;
   }
   tr.shown td.details-control {
   background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
   }    
</style>
<div class="white-area-content">
   <div class="db-header clearfix">
      <div class="page-header-title"> <span class="glyphicon glyphicon-user"></span> Orders
      </div>
   </div>
   <p>Below you can view orders for the site below.</p>
   <hr>
   <div class="table-responsive">
      <table id="example" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
         <thead>
            <tr>
               <th></th>
               <td>ID</td>
               <td>WaybillNo</td>
               <td>SendCompany</td>
               <td>FullAddress</td>
               <!-- <td>RecAdd1</td>
               <td>RecAdd2</td>
               <td>RecAdd3</td>
               <td>RecAdd4</td>
               <td>RecAdd5</td> -->
               <td>OrderStatus</td>
               <td>OrderCreated</td>
               <td>OrderModified</td>
               <th>Action</th>
            </tr>
         </thead>
         <tfoot>
            <tr>
               <th></th>
               <td>ID</td>
               <td>WaybillNo</td>
               <td>SendCompany</td>
               <td>FullAddress</td>
               <!-- <td>RecAdd1</td>
               <td>RecAdd2</td>
               <td>RecAdd3</td>
               <td>RecAdd4</td>
               <td>RecAdd5</td> -->
               <td>OrderStatus</td>
               <td>OrderCreated</td>
               <td>OrderModified</td>
               <th>Action</th>
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
               <i aria-hidden="true" class="ki ki-close"></i>
               </button>
            </div>
            <form name="edit_order" id="frmPost" action="" method="post" enctype="multipart/form-data" data-redirect-url=""  onsubmit="return false;">
               <input type="hidden" name="id"  value="">
               <div class="modal-body">
                  <div class="form-group">
                     <label for="bs">Brand*</label>
                     <input type="text" class="form-control form-control-solid" name="name" id="name" value="" placeholder="Brand" required="required">
                  </div>
                  <div class="form-group">
                     <label for="bs">Brand Type*</label>
                     <select name="brand_type" class="form-control form-control-solid" id="brand_type"required>
                        <option value="">Select..</option>
                        <option value="0">Normal</option>
                        <option value="1">Premium</option>
                     </select>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>
<script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script>
   /* Formatting function for row details - modify as you need */
   function format ( d ) {
      console.log(d);
       // `d` is the original data object for the row
       return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
           '<tr>'+
               '<td>RecAdd1:</td>'+
               '<td>'+d[9]+'</td>'+
           '</tr>'+
           '<tr>'+
               '<td>RecAdd2:</td>'+
               '<td>'+d[10]+'</td>'+
           '</tr>'+
           '<tr>'+
               '<td>RecAdd3:</td>'+
               '<td>'+d[11]+'</td>'+
           '</tr>'+
           '<tr>'+
               '<td>RecAdd4:</td>'+
               '<td>'+d[12]+'</td>'+
           '</tr>'+
           '<tr>'+
               '<td>RecAdd5:</td>'+
               '<td>'+d[13]+'</td>'+
           '</tr>'+
       '</table>';
   }
   
   var editor; // use a global for the submit and return data rendering in the examples
    
   $(document).ready(function() {
      
    
      /* $('#example').on( 'click', 'tbody td:not(:first-child)', function (e) {
           editor.inline( this, {
               submit: 'allIfChanged'
           } );
       } );
    */
       var table =$('#example').DataTable( {
           dom: "Bfrtip",
           "ajax": {
               url: "<?php echo site_url("orders/orders_page/0") ?>",
               type: 'GET',
               data: function(d) {
                   d.search_type = $('#search_type').val();
               }
           },
           columns: [
               {
                   "className":      'details-control',
                   "orderable":      false,
                   "data":           null,
                   "defaultContent": ''
               },
               null,
               null,
               null,
               null,
               /*null,
               null,
               null,
               null,
               null,*/
               null,
               null,
               null,
               null
               //{ data: "salary", render: $.fn.dataTable.render.number( ',', '.', 0, '$' ) }
           ],
           order: [ 1, 'asc' ],
           select: {
               style:    'os',
               selector: 'td:first-child'
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
   
   
       $('body').on('click', '.edit-order', function () {
           
           var id = $(this).data('id');
           /*var name = $(this).data('name');
           var brand_type = $(this).data('brand_type');
           
           $('input[name="id"]').val(id);
           $('input[name="name"]').val(name);
           $('#brand_type').val(brand_type);*/
           $('#edit_order').modal('show');
       });
   
   
   } );
</script>