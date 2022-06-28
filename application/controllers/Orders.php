<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class orders extends CI_Controller 
{

	public function __construct() 
	{
		parent::__construct();
		$this->load->model("order_model");

		if(!$this->user->loggedin) $this->template->error(lang("error_1"));
		
		$this->template->loadData("activeLink", 
			array("orders" => array("general" => 1)));

		// If the order does not have premium. 
		// -1 means they have unlimited premium
		if($this->settings->info->global_premium && 
			($this->order->info->premium_time != -1 && 
				$this->order->info->premium_time < time()) ) {
			$this->session->set_flashdata("globalmsg", lang("success_29"));
			redirect(site_url("funds/plans"));
		}
	}

	public function index($type=0) 
	{
		$type = intval($type);
		$company_options =  $this->order_model->company_options();

		$completed_order_count = $this->order_model->get_count_order_by_status('completed');
		$shipped_order_count = $this->order_model->get_count_order_by_status('shipped');
		$processing_order_count = $this->order_model->get_count_order_by_status('processing');
		$pending_order_count = $this->order_model->get_count_order_by_status('pending');
		$on_hold_order_count = $this->order_model->get_count_order_by_status('on-hold');
		$cancelled_order_count = $this->order_model->get_count_order_by_status('cancelled');
		$refunded_order_count = $this->order_model->get_count_order_by_status('refunded');
		$failed_order_count = $this->order_model->get_count_order_by_status('failed');

		$order_status = array('completed', 'shipped', 'processing', 'pending', 'on-hold', 'cancelled', 'refunded', 'failed');


		$this->template->loadContent("orders/index.php", array(
			"type" => $type,
			"order_status" => $order_status,
			"company_options" => $company_options,
			"completed_order_count" => $completed_order_count,
			"shipped_order_count" => $shipped_order_count,
			"processing_order_count" => $processing_order_count,
			"pending_order_count" => $pending_order_count,
			"on_hold_order_count" => $on_hold_order_count,
			"cancelled_order_count" => $cancelled_order_count,
			"refunded_order_count" => $refunded_order_count,
			"failed_order_count" => $failed_order_count,
			)
		);
	}


	public function overview() 
	{
		$access_company_orders =  $this->order_model->access_company_orders();
		
		$order_status = array('completed', 'shipped', 'processing', 'pending', 'on-hold', 'cancelled', 'refunded', 'failed');
		$status_class = array('info', 'warning', 'success', 'orange', 'orange', 'danger', 'default', 'danger');
		$this->template->loadContent("orders/overview.php", array(
			"access_company_orders" => $access_company_orders,
			"order_status" => $order_status,
			"status_class" => $status_class
		));
	}


	public function export_csv(){
		$query = $this->order_model->export_csv_orders();
		

		$row_builder = array();
		foreach ($query->result() as $row) {

			if($row->OrderItems == ""){
				$sku = "";
				$product_name = "";

				$row_builder[] = array($row->WaybillNo, $row->Company, $sku, $product_name, $row->TotQTY, $row->OrderTotal, $row->OrderDiscountTotal, $row->OrderShippingTotal, $row->OrderTotal, $row->WayBill);
			}else{

				$replace_own_patter = str_replace(" ", "~", $row->OrderItems);

				if (strpos($replace_own_patter, '~,~') !== false) {
				    
				    $multi_items = explode('~,~', $replace_own_patter);

				    $o_sku = explode(',', $multi_items[0]);
				    $sku = $o_sku[0];
					$product_name = str_replace("~", " ", $o_sku[1]);
					$qty = 	str_replace("~", " ", $o_sku[2]);
					$price = str_replace("~", " ", $o_sku[3]);


				    $row_builder[] = array($row->WaybillNo, $row->Company,$sku, $product_name, $qty, $price, $row->OrderDiscountTotal, $row->OrderShippingTotal, $row->OrderTotal, $row->WayBill);

				    foreach ($multi_items as $key_items => $value) {
				    	if($key_items != 0){

				    		$o_sku = explode(',', $value);
							$sku = $o_sku[0];
							$product_name = str_replace("~", " ", $o_sku[1]);
							$qty = 	str_replace("~", " ", $o_sku[2]);
							$price = str_replace("~", " ", $o_sku[3]);		    	
				    	
				    		$row_builder[] = array($row->WaybillNo, $row->Company,$sku, $product_name, $qty, $price, '', '', '', $row->WayBill);
				    	}
				    }


				}else{

					$o_sku = explode(',', $row->OrderItems);
					$sku = $o_sku[0];
					$product_name = $o_sku[1];
					$qty = $o_sku[2];	
					$price = $o_sku[3];		

					$row_builder[] = array($row->WaybillNo, $row->Company,$sku, $product_name, $qty, $price, $row->OrderDiscountTotal, $row->OrderShippingTotal, $row->OrderTotal, $row->WayBill);

				}
			}

		}


		header("Content-type: application/csv");
		header("Content-Disposition: attachment; filename=\"order-export-".date('y-m-d h:m:s').".csv\"");
		header("Pragma: no-cache");
		header("Expires: 0");

		$handle = fopen('php://output', 'w');
		fputcsv($handle, array("wabillnumber", "company","sku","productname", "quantity", "price", "discount", "shipping", "total", "waybill"));
		//$cnt=1;

		foreach ($row_builder as $key => $value) {
			$data_array=array($value[0], $value[1], $value[2], $value[3], $value[4], $value[5], $value[6], $value[7], $value[8], $value[9]);
			fputcsv($handle, $data_array);
		}
		fclose($handle);
		exit;

		//echo "<pre>";
		//echo print_r($row_builder);
		//exit;
	}


	

	public function orders_page($type=0) 
	{
		$this->load->library("datatables");

		$this->datatables->set_default_order("dawnwingapi.OrderModified", "desc");

		// Set page ordering options that can be used
		$this->datatables->ordering(
				array(
				 0 => array(
				 	"dawnwingapi.id" => 0
				 ),
				 1 => array(
				 	"dawnwingapi.id" => 0
				 ),
				 2 => array(
				 	"dawnwingapi.WaybillNo" => 0
				 ),
				 3 => array(
				 	"dawnwingapi.Company" => 0
				 ),
				 4 => array(
				 	"dawnwingapi.RecAdd1" => 0
				 ),
				 5 => array(
				 	"dawnwingapi.OrderStatus" => 0
				 ),
				 6 => array(
				 	"dawnwingapi.OrderModified" => 0
				 )
			)
		);

		if($type == 0) {

			$this->datatables->set_total_rows(
				$this->order_model
					->get_total_orders_count()
			);
			$orders = $this->order_model->get_orders($this->datatables);
		} else {
			$this->datatables->set_total_rows(
				$this->order_model
					->get_total_orders_online_count()
			);
			$orders = $this->order_model->get_orders_online($this->datatables);
		}

		/*echo '<pre>';
		print_r($orders);*/
		$generate_waybill = $download_pdf = $packing_slip = "";
		foreach($orders->result() as $r) {
			
			if($r->WaybillNo != "" && $r->Waybill == ""){
				$generate_waybill = "<a target='_blank' class='btn btn-danger btn-xs' title='Generate Waybill' data-toggle='tooltip' data-placement='bottom' data-original-title='Generate Waybill' href='https://wooapi.co.za/stuff/todo?WaybillNo=".$r->WaybillNo."'> <span class='glyphicon glyphicon-random'></span></a>";	
			}else{
				$generate_waybill = "";
			}
			
			if($r->Waybill != ""){
				$download_pdf =  "<a target='_blank' class='btn btn-success btn-xs' title='Download Pdf' data-toggle='tooltip' data-placement='bottom' data-original-title='Download Pdf' href='".$r->Waybill."'> <span class='glyphicon glyphicon-download-alt'></span></a>";
			}else{
				$download_pdf = "";
			}

			$packing_slip = "<a class='btn btn-warning btn-xs btn-package-slip' title='Packing Slip' data-toggle='tooltip' data-placement='bottom' data-original-title='Packing Slip' href='".base_url('orders/packing_slip/'.$r->id)."'> <span class='glyphicon glyphicon-file'></span></a>";

			if($r->OrderItems != null){

				$order_item_row = "";
				$replace_own_patter = str_replace(" ", "~", $r->OrderItems);
				if (strpos($replace_own_patter, '~,~') !== false) {
				    
				    $multi_items = explode('~,~', $replace_own_patter);
					$o_sku = explode(',', $multi_items[0]);
				    $sku = $o_sku[0];
					$product_name = str_replace("~", " ", $o_sku[1]);
					$qty = 	str_replace("~", " ", $o_sku[2]);
					$price = str_replace("~", " ", $o_sku[3]);

					$order_item_row .= "<tr>
					    <td>".$sku."</td>
					    <td>".$product_name."</td>
					    <td>".$qty."</td>
					    <td>".$price."</td>
					</tr>";

					foreach ($multi_items as $key_items => $value) {
				    	if($key_items != 0){

				    		$o_sku = explode(',', $value);
							$sku = $o_sku[0];
							$product_name = str_replace("~", " ", $o_sku[1]);
							$qty = 	str_replace("~", " ", $o_sku[2]);
							$price = str_replace("~", " ", $o_sku[3]);		    	
				    		
				    		$order_item_row .= "<tr>
							    <td>".$sku."</td>
							    <td>".$product_name."</td>
							    <td>".$qty."</td>
							    <td>".$price."</td>
							</tr>";
				    		
				    	}
				    }


				}else{

					$o_sku = explode(',', $r->OrderItems);
					$sku = $o_sku[0];
					$product_name = $o_sku[1];
					$qty = $o_sku[2];	
					$price = $o_sku[3];

					$order_item_row .= "<tr>
					    <td>".$sku."</td>
					    <td>".$product_name."</td>
					    <td>".$qty."</td>
					    <td>".$price."</td>
					</tr>";
				}

				$orderItems = "<table class='order-items'>".$order_item_row."</table>";


			}else{
				$orderItems = "";
			}



			$this->datatables->data[] = array(
				'',
				'<input type="checkbox" name="data_id[]" class="dt-checkboxes" autocomplete="off" value="'.$r->id.'">',
				//$r->id,
				//$this->common->get_user_display(array("username" => $r->username, "avatar" => $r->avatar, "online_timestamp" => $r->online_timestamp, "first_name" => $r->password, "last_name" => $r->last_name)),
				$r->WaybillNo,
				$r->Company,
				/*$r->SendCompany,*/
				$r->RecAdd1.', '.$r->RecAdd2.', '.$r->RecAdd3.', '.$r->RecAdd4.', '.$r->RecAdd5,
				'<span class="order-'.$r->OrderStatus.'">'.$r->OrderStatus.'</span>',
				/*$r->OrderCreated,*/
				$r->OrderModified,
				
				'<div><a href="javascript:;" class="btn btn-warning btn-xs edit-order" title="" data-toggle="tooltip" data-placement="bottom" data-original-title="Edit" data-id="'.$r->id.'"
				data-RecAdd1="'.$r->RecAdd1.'"
				data-RecAdd2="'.$r->RecAdd2.'"
				data-RecAdd3="'.$r->RecAdd3.'"
				data-RecAdd4="'.$r->RecAdd4.'"
				data-RecAdd5="'.$r->RecAdd5.'"
				data-RecContactPerson="'.$r->RecContactPerson.'"
				data-RecCell="'.$r->RecCell.'"
				data-RecWorkTel="'.$r->RecWorkTel.'"
				data-OrderStatus="'.$r->OrderStatus.'"
				class="edit-order"><span class="glyphicon glyphicon-cog"></span></a>&nbsp;
				'.$generate_waybill.$download_pdf.$packing_slip.'
				

				</div>',
				'<span>'.$r->RecAdd1.'</span>',
				'<span>'.$r->RecAdd2.'</span>',
				'<span>'.$r->RecAdd3.'</span>',
				'<span>'.$r->RecAdd4.'</span>',
				'<span>'.$r->RecAdd5.'</span>',
				'<span>'.$r->RecContactPerson.'</span>',
				'<span>'.$r->RecCell.'</span>',
				'<span>'.$r->ServiceType.'</span>',
				($r->OrderShippingTotal == null) ? '' : '<span>'.$r->OrderShippingTotal.'</span>',
				($r->OrderTotal == null) ? '' : '<span>'.$r->OrderTotal.'</span>',
				($r->OrderPaymentMethodTitle == null) ? '' : '<span>'.$r->OrderPaymentMethodTitle.'</span>',
				$orderItems
				//($r->OrderItems == null) ? '' : $r->OrderItems,

				//$this->common->get_user_role($r),
				//date($this->settings->info->date_format, $r->joined),
			);
		}
		echo json_encode($this->datatables->process());
	}

	public function search() 
	{

		$search = $this->common->nohtml($this->input->post("search"));

		if(empty($search)) $this->template->error(lang("error_49"));

		$orders = $this->order_model->get_orders_by_search($search);
		if($orders->num_rows() == 0) $this->template->error(lang("error_50"));

		$this->template->loadContent("orders/search.php", array(
			"orders" => $orders,
			"search" => $search
			)
		);
	}


	public function edit(){
			
		$fields = $this->input->get();
		$validation = true;
		foreach ($fields as $key => $value) {
			if($value == ""){
				$validation = false;
				break;
			}
		}

		if($validation){
			
			$update_order = $this->order_model->update_order($fields);

			$response = array(
                'status' => 'success',
                'message' => "Record has been update successfully."
            );
		}else{
			$response = array(
                'status' => 'error',
                'message' => 'Please input required field.'
            );
		}

		$this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));

	}


	public function multiple_edit(){
			
		$fields = $this->input->get();
		$validation = true;
		foreach ($fields as $key => $value) {
			if($value == ""){
				$validation = false;
				break;
			}
		}

		if($validation){
			
			$update_order = $this->order_model->update_multiple_order($fields);
			$response = array(
                'status' => 'success',
                'message' => "Record has been update successfully."
            );

		}else{
			$response = array(
                'status' => 'error',
                'message' => 'Please input required field.'
            );
		}

		$this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));

	}

	public function get_status_wise_count(){

		$completed_order_count = $this->order_model->get_count_order_by_status('completed');
		$shipped_order_count = $this->order_model->get_count_order_by_status('shipped');
		$processing_order_count = $this->order_model->get_count_order_by_status('processing');
		$pending_order_count = $this->order_model->get_count_order_by_status('pending');
		$on_hold_order_count = $this->order_model->get_count_order_by_status('on-hold');
		$cancelled_order_count = $this->order_model->get_count_order_by_status('cancelled');
		$refunded_order_count = $this->order_model->get_count_order_by_status('refunded');
		$failed_order_count = $this->order_model->get_count_order_by_status('failed');


		$response = array(
			"completed" => $completed_order_count.' Completed',
			"shipped" => $shipped_order_count.' Shipped',
			"processing" => $processing_order_count.' Processing',
			"pending" => $pending_order_count.' Pending',
			"on_hold" => $on_hold_order_count.' On-Hold',
			"cancelled" => $cancelled_order_count.' Cancelled',
			"refunded" => $refunded_order_count.' Refunded',
			"failed" => $failed_order_count.' Failed',
		);

		$this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));

	}



	public function generate_waybill(){
		$ids = $this->input->get('ids');
		$ids = explode(',', $ids);
		foreach ($ids as $key => $id) {
			$this->order_model->generate_waybill($id);
		}
		return true;
	}



	public function packing_slip($id){
		include_once APPPATH.'/third_party/mpdf/vendor/autoload.php';

		$pdf_name = "packing-slip-".$id.".pdf";
		$order = $this->db->where('id', $id)->get('dawnwingapi')->row();
		$site_detail = $this->db->where('sitedomain', $order->Company)->get('sitedetails')->row();

		$data['order'] = $order;
		$data['site_detail'] = $site_detail;

		$html = $this->load->view('orders/packing_slip.php', $data, true);
		$mpdf = new \Mpdf\Mpdf();
		$mpdf->WriteHTML($html);
		$mpdf->Output($pdf_name, 'D');
		//$mpdf->Output();


		//return $this->load->view('orders/packing_slip.php', $data);
	}
	


	

}

?>