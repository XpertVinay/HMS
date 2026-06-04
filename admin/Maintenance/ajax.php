<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();

if($action == "save_maintenance"){
	$save = $crud->save_maintenance();
	if($save)
		echo $save;
}
if($action == "delete_maintenance"){
	$save = $crud->delete_maintenance();
	if($save)
		echo $save;
}
if($action == "save_payment"){
	$save = $crud->save_payment();
	if($save)
		echo $save;
}