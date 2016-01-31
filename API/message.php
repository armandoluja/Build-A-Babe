<?php
include('connection.php');
include('logincheck.php');
include('utils.php');

if(!isset($_POST['action'])){
	echo '{"error":true}';
	exit;
}

//TODO Sanitize input
$action = $_POST['action'];

if($action = "getMessages"){
	/*
	$q1 = $db -> prepare('Select * from CHAT where username = ?');
	$availablePrep -> execute(array($username));
	
	if($availablePrep -> rowCount() < 1){
		//query failed to execute
		echo '{"error": true, "err_pos": 2, "err_message": "query failed"}';
		exit;
	}
	
	$availableFetch = $availablePrep -> fetch();
	$numberOfUsersWithThatUsername = $availableFetch['numFound'];
	*/
	
}


?>