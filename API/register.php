<?php
include('connection.php');
include('utils.php');
//set rules for db to validate the username and password on the server side
if (isset($_POST['username']) && strlen($_POST['username']) >= $MIN_USERNAME_LENGTH &&
	isset($_POST['password']) && strlen($_POST['password']) >= $MIN_PASSWORD_LENGTH &&
	isset($_POST['fName']) && isset($_POST['lName']) && isset($_POST['birthdate']) && isset($_POST['gender'])) {

	$username = $_POST['username'];
	$password = $_POST['password'];
	$fName = $_POST['fName'];
	$lName = $_POST['lName'];
	$birthdate = $_POST['birthdate'];
	$gender = $_POST['gender'];
	
	$username = filter_var($username, FILTER_SANITIZE_STRING);
	$password = filter_var($password, FILTER_SANITIZE_STRING);
	$fName = filter_var($fName, FILTER_SANITIZE_STRING);
	$lName = filter_var($lName, FILTER_SANITIZE_STRING);
	$birthdate = filter_var($birthdate, FILTER_SANITIZE_STRING);
	$gender = filter_var($gender, FILTER_SANITIZE_STRING);
	
	if($fName == "" || $lName == "" || $birthdate == "" || $gender == ""){
		echo '{"error": true, "err_pos": 1}';
		exit;//required
	}
	$pattern = '^[a-zA-Z0-9._]{3,20}$^';
	if(!preg_match($pattern, $username)){
		echo '{"error": true, "err_pos": 2}';//todo, add a err_message
		exit;
	}
	
	
	
	//check if username taken
	$availablePrep = $db -> prepare('Call countUsername(:userN)');
	$availablePrep -> bindValue('userN',$username);
	$availablePrep -> execute();
	
	if($availablePrep -> rowCount() < 1){
		//query failed to execute
		echo '{"error": true, "err_pos": 3, "err_message": "query failed"}';
		$availablePrep -> closeCursor();
		exit;
	}
	
	$availableFetch = $availablePrep -> fetch();
	$availablePrep -> closeCursor();
	$numberOfUsersWithThatUsername = $availableFetch['numFound'];
	if($numberOfUsersWithThatUsername > 0){
		//username is already taken
		echo '{"error": true, "err_pos": 4,"err_message": "Username is already taken."}';// TODO: tell .js that username is taken 
		exit;
	}
	
	//TODO: add more password checks? other than length
	//salt 
	$salt = generateRandomString($SALT_LENGTH);
	$calculatedPassword = sha1($password.$salt);
	
	$registerUserPrep = $db -> prepare('Call registerUser(:userN,:passW,:salt)');
	$registerUserPrep -> bindValue('userN',$username);
	$registerUserPrep -> bindValue('passW',$calculatedPassword);
	$registerUserPrep -> bindValue('salt',$salt);
	$execResult = $registerUserPrep -> execute();
	$registerUserPrep ->closeCursor();
	if($execResult != 1){
		//insert failed?
		echo '{"error": true, "err_pos": 5}';
		exit;
	}
	
	$getUserId = $db -> prepare('Call getUserId(:userN, :passW)');
	$getUserId -> bindValue('userN',$username);
	$getUserId -> bindValue('passW',$calculatedPassword);
	$getUserId -> execute();
	
	if($getUserId->rowCount() != 1){
		$getUserId ->closeCursor();
		echo '{"error": true, "err_pos": 6}';
		exit;
	}
	
	$fetchUserId = $getUserId -> fetch();
	$getUserId ->closeCursor();
	$userId = $fetchUserId['id'];
	
	$query = $db -> prepare("Call setDefaultAttributes(:userId,:fName,:lName,:gender,:birthdate)");
	$query -> bindValue(':userId', $userId);
	$query -> bindValue(':fName', $fName);
	$query -> bindValue(':lName', $lName);
	$query -> bindValue(':gender', $gender);
	$query -> bindValue(':birthdate', $birthdate);
	
	$query ->execute();
	$query ->closeCursor();
	
	//success
	echo '{"error": false}';
} else {
	echo '{"error": true, "err_pos": 5}';
}
?>