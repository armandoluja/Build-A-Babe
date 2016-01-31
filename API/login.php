<?php

include('connection.php');
include('utils.php');
if (isset($_POST['username']) && strlen($_POST['username']) > 0 && 
	isset($_POST['password']) && strlen($_POST['password']) > 0) {
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	$getSaltPrep = $db -> prepare('Select salt from LOGIN where username = ?');
	$getSaltPrep -> execute(array($username));
	
	if($getSaltPrep->rowCount() < 1){
		echo '{"error": true, "err_pos": 1}';
		exit;
	}
	
	$saltFetch = $getSaltPrep -> fetch();
	$salt = $saltFetch['salt'];
	$calculatedPassword = sha1($password.$salt);
	//hashed
	
	$getExistsPrep = $db -> prepare('Select id from LOGIN where username = ? and password = ?');
	$getExistsPrep -> execute(array($username, $calculatedPassword));
	
	if($getExistsPrep->rowCount() < 1){
		echo '{"error": true, "err_pos": 2}';
		exit;
	}
	
	if($getExistsPrep->rowCount() > 1){
		echo '{"error": true, "err_pos": 3}';
		exit;
	}
	
	
	$numFoundFetch = $getExistsPrep -> fetch();
	$userId = $numFoundFetch['id'];
	
	
	$generatedCookie = generateRandomString($COOKIE_LENGTH);
	$updatePrep = $db -> prepare('Update LOGIN set session_cookie = ? Where username = ?');
	$updatePrep -> execute(array($generatedCookie, $username));
	
		
	echo '{"error": false, "cookie":"'.$generatedCookie.'", "userId":"'.$userId.'"}';
} else {
	echo '{"error": true, "err_pos": 4}';
}
?>