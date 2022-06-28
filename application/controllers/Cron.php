<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller 
{

	public function __construct() 
	{
		parent::__construct();
		$this->load->model("user_model");

	}

	public function count_online() 
	{
		$count = $this->user_model->get_online_count();
		$this->db->where("ID", 1)->update("site_settings", array("currently_online" => $count));
		exit();
	}

	public function cronjobs_for_order_update(){
		
		$query = $this->db->get_where('order_update_crons', array('updated_at' => null));
		
		if($query->num_rows() == 0){
			echo "Order update record not found in our database.";
		}

		$json_response = array();
		foreach($query->result() as $row){
    		$order_id =  $row->order_id;

    		$this->db->where('id', $order_id);
			$order = $this->db->get('dawnwingapi')->row();
    		$sitedomain = $order->Company;
    		$site_info = $this->db->where('sitedomain', $sitedomain)->get('sitedetails')->row();
    		$api_username = $site_info->api_username;
    		$api_password = $site_info->api_password;
    	
		 	// setup the data which has to be sent//
		 	$data = [
			 	'status' => $order->OrderStatus,
			 	//'date_modified' => date('Y-m-d H:i:s'),
			 	'billing' => array(
			 			'address_1' => $order->RecAdd1,
			 			'address_2' => $order->RecAdd2,
			 			'city' => $order->RecAdd3,
			 			'state' => $order->RecAdd4,
			 			'postcode' => $order->RecAdd5,
			 			'phone' => $order->RecCell	 		
			 		),
			 	'shipping' => array(
			 			'address_1' => $order->RecAdd1,
			 			'address_2' => $order->RecAdd2,
			 			'city' => $order->RecAdd3,
			 			'state' => $order->RecAdd4,
			 			'postcode' => $order->RecAdd5	 		
			 		)
		 	];
	 
			// send API request via cURL
			$ch = curl_init();
		 
		 
			curl_setopt($ch, CURLOPT_URL, $sitedomain . '/wp-json/wc/v3/orders/' . $order_id . '?consumer_key=' . $api_username . '&consumer_secret=' . $api_password);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
			$response = curl_exec($ch);

			curl_close($ch);

			$json_response[] = $response;

			$update_row = $this->db->where('id', $row->id)->update('order_update_crons', array('updated_at' => date('Y-m-d H:i:s') ));
			
    	}
    	echo  json_encode($json_response);
	}

}

?>