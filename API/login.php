<?php

include('connection.php');
include('utils.php');
if (isset($_POST['username']) && strlen($_POST['username']) > 0 && 
	isset($_POST['password']) && strlen($_POST['password']) > 0) {
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	$username = filter_var($username, FILTER_SANITIZE_STRING);
	$password = filter_var($password, FILTER_SANITIZE_STRING);
	
	$getSaltPrep = $db -> prepare('Call getSalt(:userN)');
	$getSaltPrep -> bindValue('userN', $username);
	$getSaltPrep -> execute();
	if($getSaltPrep->rowCount() < 1){
		echo '{"error": true, "err_pos": 1}';
		exit;
	}
	
	$saltFetch = $getSaltPrep -> fetch();
	$getSaltPrep -> closeCursor();// IMPORTANT----------------
	$salt = $saltFetch['salt'];
	$calculatedPassword = sha1($password.$salt);
	
	$getExistsPrep = $db -> prepare('Call getUserId(:userN, :passW)');
	$getExistsPrep -> bindValue('userN', $username);
	$getExistsPrep -> bindValue('passW', $calculatedPassword);
	$getExistsPrep -> execute();
	
	if($getExistsPrep->rowCount() < 1){
		echo '{"error": true, "err_pos": 2}';
		exit;
	}
	
	if($getExistsPrep->rowCount() > 1){
		echo '{"error": true, "err_pos": 3}';
		exit;
	}

	$numFoundFetch = $getExistsPrep -> fetch();
	$getExistsPrep -> closeCursor();//IMPORTANT-----------------
	$userId = $numFoundFetch['id'];
	
	$generatedCookie = generateRandomString($COOKIE_LENGTH);
	
	$updatePrep = $db -> prepare('Call loginUpdate(:cookie,:userN)');
	$updatePrep -> bindValue('cookie',$generatedCookie);
	$updatePrep -> bindValue('userN',$username);
	$updatePrep -> execute();
	$updatePrep -> closeCursor();// IMPORTANT--------------
		
	echo '{"error": false, "cookie":"'.$generatedCookie.'", "userId":"'.$userId.'"}';
} else {
	echo '{"error": true, "err_pos": 4}';
}
?>