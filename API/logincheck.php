<?php 
include('connection.php');

if(!isset($_POST('userId')) || !isset($_POST('session'))){
	echo '{"error":true}';
	exit;
}

//TODO Sanitize input
$userId = $_POST['userId'];
$session = $_POST['session'];

$q1 = $db -> prepare('Select username from login where id = ? AND session_cookie = ?');
$qPrep -> execute(array($userId, $session));
	
if($qPrep -> rowCount() < 1){
	//no user exists for that userId and session
	echo '{"error": true}';
	exit;
}
	
$qFetch = $qPrep -> fetch();
$username = $qFetch['username'];

echo '{"error": false, "username": "'.$username'."}';
?>