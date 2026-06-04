<?php
require_once("../../Includes/config.php"); 
require_once("../../Includes/session.php"); 
if ($logged==false) {
	 header("Location:../../login.php");
}
ini_set('display_errors', 1);
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include ("../../Includes/config.php"); 
    
    $this->db = $con;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	

	function save_user(){
		extract($_POST);
		$data = " visitor_name = '$visitor_name', visitor_contact = '$visitor_contact', host_id = '$host_id', purpose = '$purpose' ";
        
        if(isset($status) && !empty($status)) {
            $data .= ", status = '$status' ";
        }
        if(isset($out_time) && !empty($out_time)) {
            $data .= ", out_time = '$out_time' ";
        }
		
		if(empty($id)){
			$save = $this->db->query("INSERT INTO registry set ".$data);
		}else{
			$save = $this->db->query("UPDATE registry set ".$data." where id = ".$id);
		}
		if($save){
			return 1;
		}
	}
    function update_status(){
        extract($_POST);
        $data = " status = '$status' ";
        if ($status == 'Completed') {
            $data .= ", out_time = NOW() ";
        }
        $update = $this->db->query("UPDATE registry set ".$data." where id = ".$id);
        if($update) return 1;
    }
	function delete_user(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM registry where id = ".$id);
		if($delete)
			return 1;
	}									
}