<?php
include ('connection.php');

if (!isset($_POST['userId']) || !isset($_POST['session'])) {
	echo '{"error":true}';
	exit ;
}

$userId = $_POST['userId'];
$session = $_POST['session'];
$session = filter_var($session, FILTER_SANITIZE_STRING);
$userId = filter_var($userId, FILTER_SANITIZE_STRING);

$q1 = $db -> prepare("Call loginCheck(:cookie, :userId)");
$q1 -> bindValue(':cookie', $session);
$q1 -> bindValue(':userId', $userId);
$q1 -> execute();

if ($q1 -> rowCount() < 1) {
	//no user exists for that userId and session
	echo '{"error": true}';
	exit ;
}

$qFetch = $q1 -> fetch();
$username = $qFetch['username'];

echo '{"error": false, "username":"' . $username . '"}';
?>