<?php
include ('connection.php');

if (isset($_COOKIE['session']) && isset($_COOKIE['userId'])) {
	$userId = $_COOKIE['userId'];
	$session = $_COOKIE['session'];

	$q1 = $db -> prepare('Select username from login where id = ? AND session_cookie = ?');
	$q1 -> execute(array($userId, $session));

	if ($q1 -> rowCount() != 1) {
		//no user exists for that userId and session
		header("Location: ./");
		exit;
	}
}else{
	//there is not session cookie or user id cookie
	header("Location: ./");
	exit;
}
?>