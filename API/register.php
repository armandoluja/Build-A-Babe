<?php

include('connection.php');
include('utils.php');
//set rules for db to validate the username and password on the server side
if (isset($_POST['username']) && strlen($_POST['username']) >= $MIN_USERNAME_LENGTH &&
	isset($_POST['password']) && strlen($_POST['password']) >= $MIN_PASSWORD_LENGTH) {

	$username = $_POST['username'];
	$password = $_POST['password'];
	$pattern = '^[a-zA-Z0-9._]{3,20}$^';

	if(!preg_match($pattern, $username)){
		echo '{"error": true, "err_pos": 1}';//todo, add a err_message
		exit;
	}
	
	//check if username taken
	$availablePrep = $db -> prepare('Select count(username) as numFound from LOGIN where username = ?');
	$availablePrep -> execute(array($username));
	
	if($availablePrep -> rowCount() < 1){
		//query failed to execute
		echo '{"error": true, "err_pos": 2, "err_message": "query failed"}';
		exit;
	}
	
	$availableFetch = $availablePrep -> fetch();
	$numberOfUsersWithThatUsername = $availableFetch['numFound'];
	
	if($numberOfUsersWithThatUsername > 0){
		//username is already taken
		echo '{"error": true, "err_pos": 3,"err_message": "Username is already taken."}';// TODO: tell .js that username is taken 
		exit;
	}
	
	//TODO: add more password checks? other than length
	//salt 
	$salt = generateRandomString($SALT_LENGTH);
	$calculatedPassword = sha1($password.$salt);
	
	$registerUserPrep = $db -> prepare('INSERT into LOGIN (username, password, salt) values (?, ?, ?)');
	$execResult = $registerUserPrep -> execute(array($username, $calculatedPassword,$salt));
	
	if($execResult != 1){
		//insert failed?
		echo '{"error": true, "err_pos": 4}';
		exit;
	}
	//success
	echo '{"error": false}';
} else {
	echo '{"error": true, "err_pos": 5}';
}
?>