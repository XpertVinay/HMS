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
		global $con;
		$this->db = $con;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function save_user(){
		extract($_POST);
		$data = " email = '$email' ";
		$data .= ", username = '$username' ";
		if(isset($mobile_number)) $data .= ", mobile_number = '$mobile_number' ";
		if(isset($address)) $data .= ", address = '$address' ";
		$verified = isset($is_rent_agreement_verified_admin) ? 1 : 0;
		$data .= ", is_rent_agreement_verified_admin = '$verified' ";
		
		if(!empty($password))
		    $data .= ", password = '".password_hash($password, PASSWORD_DEFAULT)."' ";
		$chk = $this->db->query("Select * from resident where username = '$username' and id !='$id' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO resident set ".$data);
		}else{
			$save = $this->db->query("UPDATE resident set ".$data." where id = ".$id);
		}
		if($save){
			return 1;
		}
	}
	function delete_user(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM resident where id = ".$id);
		if($delete)
			return 1;
	}									
}