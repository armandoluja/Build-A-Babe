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
	//hashing here
	// and here
	// and here too
	// and probly here
	// maybe done here
	//for sure done here
	//hashed af
	
	$getExistsPrep = $db -> prepare('Select count(username) as numFound from LOGIN where username = ? and password = ?');
	$getExistsPrep -> execute(array($username, $calculatedPassword));
	
	if($getExistsPrep->rowCount()< 1){
		echo '{"error": true, "err_pos": 2}';
		exit;
	}
	
	$numFoundFetch = $getExistsPrep -> fetch();
	$numFound = $numFoundFetch['numFound'];
	
	if($numFound == 0){
		echo '{"error": true, "err_pos": 3}';
		exit;
	}
	
	$generatedCookie = generateRandomString($COOKIE_LENGTH);
	$updatePrep = $db -> prepare('Update LOGIN set session_cookie = ? Where username = ?');
	$updatePrep -> execute(array($generatedCookie, $username));
	
		
	echo '{"error": false, "cookie":"'.$generatedCookie.'"}';
} else {
	echo '{"error": true, "err_pos": 4}';
}
?>