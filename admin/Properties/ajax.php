<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();

if($action == 'save_property'){
	$save = $crud->save_property();
	if($save)
		echo $save;
}
if($action == 'delete_property'){
	$save = $crud->delete_property();
	if($save)
		echo $save;
}
ob_end_flush();
?>