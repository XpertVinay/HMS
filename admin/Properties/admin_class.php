<?php
session_start();
ini_set('display_errors', 1);
require_once("../../Includes/Database.php");
require_once("../../Includes/config.php");

Class Action {
	private $db;
    private $con;

	public function __construct() {
        $this->db = Database::getInstance();
		$this->con = $this->db->getConnection();
	}
	function __destruct() {
	    // Database closes connection automatically or singleton keeps it alive
	}

	function save_property(){
		extract($_POST);
		$org_id = ACTIVE_ORG_ID;
		$data = " address = '$address' ";
		$data .= ", type = '$type' ";
		
		if(empty($owner_id)){
		    $data .= ", owner_id = NULL ";
		} else {
		    $data .= ", owner_id = '$owner_id' ";
		}
		
		if(empty($resident_id)){
		    $data .= ", resident_id = NULL ";
		} else {
		    $data .= ", resident_id = '$resident_id' ";
		}
		
		$data .= ", organization_id = '$org_id' ";

		if(empty($id)){
			$save = $this->con->query("INSERT INTO property set ".$data);
		}else{
			$save = $this->con->query("UPDATE property set ".$data." where id = ".$id);
		}
		if($save)
			return 1;
		return 0;
	}

	function delete_property(){
		extract($_POST);
		$delete = $this->con->query("DELETE FROM property where id = ".$id);
		if($delete)
			return 1;
		return 0;
	}
}