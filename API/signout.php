<?php 
	if(!isset($_POST['session']) || !isset($_POST['userId'])){
		exit;
	}
	
	include('connection.php');
	
	$session = $_POST['session'];
	$userId = $_POST['userId'];
	$logout = $db->prepare("Call logout(:userId,:cookie)");
	$logout -> bindValue(':cookie',$session);
	$logout -> bindValue(':userId',$userId);
	$logout -> execute();

?>