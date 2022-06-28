<?php

class Api_Credential_Model extends CI_Model 
{

	

	

	public function get_total_api_credentials_count() 
	{
		$s= $this->db->select("COUNT(*) as num")->get("api_credentials");
		$r = $s->row();
		if(isset($r->num)) return $r->num;
		return 0;
	}

	public function get_total_members_online_count() 
	{
		$s= $this->db->where("online_timestamp >", time() - 60 * 15)->select("COUNT(*) as num")->get("api_credentials");
		$r = $s->row();
		if(isset($r->num)) return $r->num;
		return 0;
	}


	
	public function get_api_credentials($datatable) 
	{
		$datatable->db_api_credential();

		$datatable->db_search(array(
			"api_credentials.id",
			"api_credentials.WaybillNo",
			"api_credentials.SendCompany",
			"api_credentials.RecAdd1",
			"api_credentials.RecAdd2",
			"api_credentials.RecAdd3",
			"api_credentials.RecAdd4",
			"api_credentials.RecAdd5",
			"api_credentials.api_credentialStatus",
			"api_credentials.api_credentialCreated",
			"api_credentials.api_credentialModified"),
			true // Cache
		);

		$this->db->select("api_credentials.id, api_credentials.WaybillNo, api_credentials.SendCompany, api_credentials.RecAdd1, 
			api_credentials.RecAdd2,api_credentials.RecAdd3, api_credentials.RecAdd4, api_credentials.RecAdd5, api_credentials.api_credentialStatus, api_credentials.api_credentialCreated, api_credentials.api_credentialModified");
		//->join("user_roles", "user_roles.ID = api_credentials.user_role", 
		//		 	"left outer");
		return $datatable->get("api_credentials");
	}



}

?>