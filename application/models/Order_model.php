<?php

class Order_Model extends CI_Model 
{

	

	

	public function get_total_orders_count() 
	{
		//Permission Company List
		$company_list = $this->access_company_orders();

		$s= $this->db->select("COUNT(*) as num");

		if($_GET["search"]["value"] != "")  
        {   
            $s->like("dawnwingapi.id", $_GET["search"]["value"]);
            $s->or_like("dawnwingapi.WaybillNo", $_GET["search"]["value"]);
            $s->or_like("dawnwingapi.SendCompany", $_GET["search"]["value"]);
            $s->or_like("dawnwingapi.RecAdd1", $_GET["search"]["value"]);
            $s->or_like("dawnwingapi.RecAdd2", $_GET["search"]["value"]);
            $s->or_like("dawnwingapi.RecAdd3", $_GET["search"]["value"]);
            $s->or_like("dawnwingapi.RecAdd4", $_GET["search"]["value"]);
            $s->or_like("dawnwingapi.RecAdd5", $_GET["search"]["value"]);
            $s->or_like("dawnwingapi.RecContactPerson", $_GET["search"]["value"]);
            $s->or_like("dawnwingapi.RecWorkTel", $_GET["search"]["value"]);
            $s->or_like("dawnwingapi.RecCell", $_GET["search"]["value"]);
            $s->or_like("dawnwingapi.ServiceType", $_GET["search"]["value"]);
            $s->or_like("dawnwingapi.OrderShippingTotal", $_GET["search"]["value"]);
            $s->or_like("dawnwingapi.OrderTotal", $_GET["search"]["value"]);
            $s->or_like("dawnwingapi.OrderPaymentMethodTitle", $_GET["search"]["value"]);
            $s->or_like("dawnwingapi.OrderItems", $_GET["search"]["value"]);
            $s->or_like("dawnwingapi.Company", $_GET["search"]["value"]);
            //$s->or_like("dawnwingapi.OrderStatus", $_GET["search"]["value"]);
            $s->or_like("dawnwingapi.OrderCreated", $_GET["search"]["value"]);
            $s->or_like("dawnwingapi.OrderModified", $_GET["search"]["value"]);
        } 


		$order_status = isset($_GET['status']) ? $_GET['status'] : ''; //$_GET['columns'][5]['search']['value'];
    	if($order_status != ""){
    		$column = "dawnwingapi.OrderStatus";
    		//$order_status = substr($order_status, 1, -1);
    		$s->where($column, $order_status);
    	}

    	$company = isset($_GET['company']) ? $_GET['company'] : ''; 
    	if($company != ""){
    		$column = "dawnwingapi.Company";
    		//$company = substr($company, 1, -1);
    		$s->where($column, $company);
    	}
		
		$send_company = isset($_GET['send_company']) ? $_GET['send_company'] : ''; 
		if($send_company != ""){
    		$column = "dawnwingapi.SendCompany";
    		$s->where($column, $send_company);	
    	}

		$order_created_date_range = isset($_GET['order_created_date_range']) ? $_GET['order_created_date_range'] : '';
    	if($order_created_date_range != ""){
    		$order_created = explode(" to ", $order_created_date_range);
			$this->db->where('dawnwingapi.OrderCreated >=', $order_created[0].' 00:00:00');
			$this->db->where('dawnwingapi.OrderCreated <=', $order_created[1].' 24:59:59');
		}

		if($company_list == ""){
			$s->where_in('dawnwingapi.SendCompany', '&n');    		
		}else{
			$company_list = explode(',', $company_list);
			$s->where_in('dawnwingapi.SendCompany', $company_list);    	
		}

		

		$r = $s->get("dawnwingapi")->row();
		if(isset($r->num)) return $r->num;
		return 0;
	}

	public function get_total_members_online_count() 
	{
		$s= $this->db->where("online_timestamp >", time() - 60 * 15)->select("COUNT(*) as num")->get("dawnwingapi");
		$r = $s->row();
		if(isset($r->num)) return $r->num;
		return 0;
	}


	
	public function get_orders($datatable) 
	{	
		//Permission Company List
		$company_list = $this->access_company_orders();

		$datatable->db_order();
		/*$datatable->db_search(array(
			"dawnwingapi.id",
			"dawnwingapi.WaybillNo",
			"dawnwingapi.SendCompany",
			"dawnwingapi.RecAdd1",
			"dawnwingapi.RecAdd2",
			"dawnwingapi.RecAdd3",
			"dawnwingapi.RecAdd4",
			"dawnwingapi.RecAdd5",
			"dawnwingapi.RecContactPerson",
			"dawnwingapi.RecWorkTel",
			"dawnwingapi.RecCell",
			"dawnwingapi.ServiceType",
			"dawnwingapi.OrderShippingTotal",
			"dawnwingapi.OrderTotal",
			"dawnwingapi.OrderPaymentMethodTitle",
			"dawnwingapi.OrderItems",
			"dawnwingapi.Waybill",
			"dawnwingapi.Company",
			"dawnwingapi.OrderStatus",
			"dawnwingapi.OrderCreated",
			"dawnwingapi.OrderModified"),
			true // Cache
		);*/

		$this->db->select("dawnwingapi.id, dawnwingapi.WaybillNo, dawnwingapi.SendCompany, dawnwingapi.RecAdd1, 
			dawnwingapi.RecAdd2,dawnwingapi.RecAdd3, dawnwingapi.RecAdd4, dawnwingapi.RecAdd5, dawnwingapi.RecContactPerson, dawnwingapi.RecWorkTel, dawnwingapi.RecCell, dawnwingapi.ServiceType, dawnwingapi.OrderShippingTotal, dawnwingapi.OrderTotal, dawnwingapi.OrderPaymentMethodTitle, dawnwingapi.OrderItems,  dawnwingapi.OrderStatus, dawnwingapi.OrderCreated, dawnwingapi.OrderModified, dawnwingapi.Waybill, dawnwingapi.Company");
		
		if($_GET["search"]["value"] != "")  
        {   
            $this->db->like("dawnwingapi.id", $_GET["search"]["value"]);
            $this->db->or_like("dawnwingapi.WaybillNo", $_GET["search"]["value"]);
            $this->db->or_like("dawnwingapi.SendCompany", $_GET["search"]["value"]);
            $this->db->or_like("dawnwingapi.RecAdd1", $_GET["search"]["value"]);
            $this->db->or_like("dawnwingapi.RecAdd2", $_GET["search"]["value"]);
            $this->db->or_like("dawnwingapi.RecAdd3", $_GET["search"]["value"]);
            $this->db->or_like("dawnwingapi.RecAdd4", $_GET["search"]["value"]);
            $this->db->or_like("dawnwingapi.RecAdd5", $_GET["search"]["value"]);
            $this->db->or_like("dawnwingapi.RecContactPerson", $_GET["search"]["value"]);
            $this->db->or_like("dawnwingapi.RecWorkTel", $_GET["search"]["value"]);
            $this->db->or_like("dawnwingapi.RecCell", $_GET["search"]["value"]);
            $this->db->or_like("dawnwingapi.ServiceType", $_GET["search"]["value"]);
            $this->db->or_like("dawnwingapi.OrderShippingTotal", $_GET["search"]["value"]);
            $this->db->or_like("dawnwingapi.OrderTotal", $_GET["search"]["value"]);
            $this->db->or_like("dawnwingapi.OrderPaymentMethodTitle", $_GET["search"]["value"]);
            $this->db->or_like("dawnwingapi.OrderItems", $_GET["search"]["value"]);
            $this->db->or_like("dawnwingapi.Company", $_GET["search"]["value"]);
            //$this->db->or_like("dawnwingapi.OrderStatus", $_GET["search"]["value"]);
            $this->db->or_like("dawnwingapi.OrderCreated", $_GET["search"]["value"]);
            $this->db->or_like("dawnwingapi.OrderModified", $_GET["search"]["value"]);
        } 



		$order_status = isset($_GET['status']) ? $_GET['status'] : '';
    	if($order_status != ""){
    		$column = "dawnwingapi.OrderStatus";
    		$this->db->where($column, $order_status);
    	}

    	$company = isset($_GET['company']) ? $_GET['company'] : ''; 
    	if($company != ""){
    		$column = "dawnwingapi.Company";
    		$this->db->where($column, $company);
    	}

    	$send_company = isset($_GET['send_company']) ? $_GET['send_company'] : '';  
		if($send_company != ""){
    		$column = "dawnwingapi.SendCompany";
    		$this->db->where($column, $send_company);	
    	}

    	$order_created_date_range = isset($_GET['order_created_date_range']) ? $_GET['order_created_date_range'] : ''; 
    	if($order_created_date_range != ""){
    		$order_created = explode(" to ", $order_created_date_range);
			$this->db->where('dawnwingapi.OrderCreated >=', $order_created[0].' 00:00:00');
			$this->db->where('dawnwingapi.OrderCreated <=', $order_created[1].' 24:59:59');
		}

    	
    	if($company_list == ""){
			$this->db->where_in('dawnwingapi.SendCompany', '&n');    		
		}else{
			$company_list = explode(',', $company_list);
			$this->db->where_in('dawnwingapi.SendCompany', $company_list);    	
		}

		return $datatable->get("dawnwingapi");
	}

	public function update_order($request){
		$update = $this->db->where('id', $request['id']);
    	$update->update('dawnwingapi', array('RecAdd1' => $request['RecAdd1'], 'RecAdd2' => $request['RecAdd2'], 'RecAdd3' => $request['RecAdd3'], 'RecAdd4' => $request['RecAdd4'], 'RecAdd5' => $request['RecAdd5'], 'RecContactPerson' => $request['RecContactPerson'], 'RecWorkTel' => $request['RecWorkTel'], 'RecCell' => $request['RecCell'], 'OrderStatus' => $request['OrderStatus'], 'OrderModified' => date('Y-m-d H:i:s') ));

    	$cron_data = array(  
        	'order_id'     => $request['id'],  
        	'created_at'  => date('Y-m-d H:i:s'),
        	'updated_at' => null
        );  
        $response = $this->db->insert('order_update_crons',$cron_data); 

		return $response;
	}


	public function update_multiple_order($request){
		$ids = $request['ids'];
		$status = $request['MultipleOrderStatus'];
		$id_list = explode(',', $ids);
		$update = $this->db->where_in('id', $id_list);		
		$update->update('dawnwingapi',array('OrderStatus' => $status, 'OrderModified'=> date('Y-m-d H:i:s') ));

		foreach ($id_list as $key => $order_id) {
			$cron_data = array(  
	        	'order_id'     => $order_id,  
	        	'created_at'  => date('Y-m-d H:i:s'),
	        	'updated_at' => null
	        );  
	        $response = $this->db->insert('order_update_crons',$cron_data); 
		}
		return true;
	}

	public function company_options(){

		$company_list = $this->access_company_orders();
		if($company_list == ""){
			return "";
		}

		$company_list = explode(',', $company_list);
		$query=$this->db->select('Company')->where_in('SendCompany', $company_list)->where('Company !=', '')->group_by('Company')->get('dawnwingapi');
		$options = "";
		foreach ($query->result() as $row)
		{
		    $options .= '<option value="'.$row->Company.'">'.$row->Company.'</option>';
		}
		return $options;
	}

	public function access_company_orders(){
		$this->load->model("user_model");
		$user_id = $this->user->info->ID;
		
		$user_groups = $this->user_model->get_user_groups($user_id);
		if($user_groups->num_rows() == 0){
			return "";
		}

		$company_list = "";
		foreach ($user_groups->result() as $key => $row) {
			$group_id = $row->groupid;
			$query = $this->db->select('access_company_orders')->where('id', $group_id)->where('access_company_orders !=', null)->get('user_groups');
			if($query->num_rows() != 0){
				$query = $query->row();
				$company_list .= $query->access_company_orders.',';	
			}
		}
		if($company_list != ""){
			return rtrim($company_list, ',');
		}else{
			return $company_list;
		}
	}


	public function company_list($send_company){
		$query=$this->db->select('Company, COUNT(Company) as total')->where_in('SendCompany', $send_company)->where('Company !=', '')->group_by('Company')->get('dawnwingapi');
		$options = "";
		return $query->result();
	}


	public function count_overview_orders($send_company, $company, $order_status){

		$s= $this->db->select("COUNT(*) as num");
			$s->where("dawnwingapi.SendCompany", $send_company);
			$s->where("dawnwingapi.Company", $company);
			$s->where("dawnwingapi.OrderStatus", $order_status);
    	
    	$r = $s->get("dawnwingapi")->row();
		if(isset($r->num)) return $r->num;
		return 0;
	}


	public function export_csv_orders(){

		$company_list = $this->access_company_orders();
		$this->db->select("*");

		if($_GET["keyword"] != "")  
        {   
            $this->db->like("id", $_GET["keyword"]);
            $this->db->or_like("WaybillNo", $_GET["keyword"]);
            $this->db->or_like("SendCompany", $_GET["keyword"]);
            $this->db->or_like("RecAdd1", $_GET["keyword"]);
            $this->db->or_like("RecAdd2", $_GET["keyword"]);
            $this->db->or_like("RecAdd3", $_GET["keyword"]);
            $this->db->or_like("RecAdd4", $_GET["keyword"]);
            $this->db->or_like("RecAdd5", $_GET["keyword"]);
            $this->db->or_like("RecContactPerson", $_GET["keyword"]);
            $this->db->or_like("RecWorkTel", $_GET["keyword"]);
            $this->db->or_like("RecCell", $_GET["keyword"]);
            $this->db->or_like("ServiceType", $_GET["keyword"]);
            $this->db->or_like("OrderShippingTotal", $_GET["keyword"]);
            $this->db->or_like("OrderTotal", $_GET["keyword"]);
            $this->db->or_like("OrderPaymentMethodTitle", $_GET["keyword"]);
            $this->db->or_like("OrderItems", $_GET["keyword"]);
            $this->db->or_like("Company", $_GET["keyword"]);
            //$this->db->or_like("OrderStatus", $_GET["keyword"]);
            $this->db->or_like("OrderCreated", $_GET["keyword"]);
            $this->db->or_like("OrderModified", $_GET["keyword"]);
        } 



		$order_status = $_GET['status'];
    	if($order_status != ""){
    		$column = "OrderStatus";
    		$this->db->where($column, $order_status);
    	}

    	$company = $_GET['company'];
    	if($company != ""){
    		$column = "Company";
    		$this->db->where($column, $company);
    	}

		/*$send_company = $_GET['send_company'];
    	if($send_company != ""){
    		$column = "SendCompany";
    		$this->db->where($column, $company);
    	}*/


    	$order_created_date_range = $_GET['order_created_date_range'];
    	if($order_created_date_range != ""){
    		$order_created = explode(" to ", $order_created_date_range);
			$this->db->where('OrderCreated >=', $order_created[0].' 00:00:00');
			$this->db->where('OrderCreated <=', $order_created[1].' 24:59:59');
		}

    	
    	if($company_list == ""){
			$this->db->where_in('SendCompany', '&n');    		
		}else{
			$company_list = explode(',', $company_list);
			$this->db->where_in('SendCompany', $company_list);    	
		}

		return $this->db->get("dawnwingapi");

	}



	public function get_count_order_by_status($order_status) 
	{
		
		//Permission Company List
		$company_list = $this->access_company_orders();

		$s= $this->db->select("COUNT(*) as num");
		
		if($order_status != ""){
    		$column = "dawnwingapi.OrderStatus";
    		$s->where($column, $order_status);
    	}
		
    	if(isset($_GET['site'])){

    		if($_GET['site'] != ""){
    			$column = "dawnwingapi.Company";
    			$s->where($column, $_GET['site']);	
    		}
    	}

    	if(isset($_GET['send_company'])){
    		if($_GET['send_company'] != ""){
    			$column = "dawnwingapi.SendCompany";
    			$s->where($column, $_GET['send_company']);	
    		}
    	}

		if($company_list == ""){
			$s->where_in('dawnwingapi.SendCompany', '&n');    		
		}else{
			$company_list = explode(',', $company_list);
			$s->where_in('dawnwingapi.SendCompany', $company_list);    	
		}

		$r = $s->get("dawnwingapi")->row();
		if(isset($r->num)) return $r->num;
		return 0;
	}


	public function generate_waybill($id){

		$query = $this->db->select("WayBill, WaybillNo")->where('id', $id)->get("dawnwingapi")->row();
		if($query->WayBill == ""){
			$waybill_no = $query->WaybillNo;
			$url = "https://wooapi.co.za/stuff/todo?WaybillNo=".$waybill_no;
			$handle = curl_init();
			// Set the url
			curl_setopt($handle, CURLOPT_URL, $url);
			// Set the result output to be a string.
			curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
 			$output = curl_exec($handle);
			curl_close($handle);
			//var_dump($output);
		}
	}



}

?>