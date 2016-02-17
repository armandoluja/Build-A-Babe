<?php
include ('connection.php');

if (isset($_COOKIE['session']) && isset($_COOKIE['userId'])) {
	// Do not modify the comment below ..
	// loginCheck(cookie,userId) returns the userId if OK or nothing if not OK
	$session = $_COOKIE['session'];
	$userId = $_COOKIE['userId'];
    $session = filter_var($session, FILTER_SANITIZE_STRING);
    $userId = filter_var($userId, FILTER_SANITIZE_STRING);

	$q1 = $db->prepare("Call loginCheck(:cookie, :userId)");
	$q1 -> bindValue(':cookie',$session);
	$q1 -> bindValue(':userId',$userId);
	$q1 -> execute();

	if ($q1 -> rowCount() != 1) {
		//no user exists for that userId and session, or more than 1? log out
		header("Location: ./");
		exit;
	}
}else{
	//there is not session cookie or user id cookie
	header("Location: ./");
	exit;
}
?>