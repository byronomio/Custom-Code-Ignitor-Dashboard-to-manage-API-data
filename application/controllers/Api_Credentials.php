<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class api_credentials extends CI_Controller 
{

	public function __construct() 
	{
		parent::__construct();
		$this->load->model("api_credential_model");

		if(!$this->user->loggedin) $this->template->error(lang("error_1"));
		
		$this->template->loadData("activeLink", 
			array("api_credentials" => array("general" => 1)));

		// If the api_credential does not have premium. 
		// -1 means they have unlimited premium
		if($this->settings->info->global_premium && 
			($this->api_credential->info->premium_time != -1 && 
				$this->api_credential->info->premium_time < time()) ) {
			$this->session->set_flashdata("globalmsg", lang("success_29"));
			redirect(site_url("funds/plans"));
		}
	}

	public function index($type=0) 
	{
		$type = intval($type);
		$this->template->loadContent("api_credentials/index.php", array(
			"type" => $type
			)
		);
	}

	public function api_credentials_page($type=0) 
	{
		$this->load->library("datatables");

		$this->datatables->set_default_api_credential("dawnwingapi.id", "desc");

		// Set page api_credentialing options that can be used
		$this->datatables->api_credentialing(
			
				array(
				 0 => array(
				 	"dawnwingapi.id" => 0
				 ),
				 1 => array(
				 	"dawnwingapi.WaybillNo" => 0
				 ),
				 2 => array(
				 	"dawnwingapi.SendCompany" => 0
				 ),
				 3 => array(
				 	"dawnwingapi.RecAdd1" => 0
				 ),
				 4 => array(
				 	"dawnwingapi.RecAdd2" => 0
				 ),
				 5 => array(
				 	"dawnwingapi.RecAdd3" => 0
				 ),
				 6 => array(
				 	"dawnwingapi.RecAdd4" => 0
				 ),
				 7 => array(
				 	"dawnwingapi.RecAdd5" => 0
				 ),
				 8 => array(
				 	"dawnwingapi.api_credentialstatus" => 0
				 ),
				 9 => array(
				 	"dawnwingapi.api_credentialCreated" => 0
				 ),
				 10 => array(
				 	"dawnwingapi.api_credentialModified" => 0
				 )
			)
		);

		if($type == 0) {
			$this->datatables->set_total_rows(
				$this->api_credential_model
					->get_total_api_credentials_count()
			);
			$api_credentials = $this->api_credential_model->get_api_credentials($this->datatables);
		} else {
			$this->datatables->set_total_rows(
				$this->api_credential_model
					->get_total_api_credentials_online_count()
			);
			$api_credentials = $this->api_credential_model->get_api_credentials_online($this->datatables);
		}

		foreach($api_credentials->result() as $r) {
		




			$this->datatables->data[] = array(
				$r->id,
				//$this->common->get_user_display(array("username" => $r->username, "avatar" => $r->avatar, "online_timestamp" => $r->online_timestamp, "first_name" => $r->password, "last_name" => $r->last_name)),
				$r->WaybillNo,
				$r->SendCompany,
				$r->RecAdd1,
				$r->RecAdd2,
				$r->RecAdd3,
				$r->RecAdd4,
				$r->RecAdd5,
				$r->api_credentialstatus,
				$r->api_credentialCreated,
				$r->api_credentialModified,
				
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

		$api_credentials = $this->api_credential_model->get_api_credentials_by_search($search);
		if($api_credentials->num_rows() == 0) $this->template->error(lang("error_50"));

		$this->template->loadContent("api_credentials/search.php", array(
			"api_credentials" => $api_credentials,
			"search" => $search
			)
		);
	}

}

?>