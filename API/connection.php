<?php
$db;
try {
	//For armando
	$db = new PDO("mysql:host=localhost;dbname=buildababe", "root", "lujaSQLdb");
	// $db = new mysqli("localhost", "root", "lujaSQLdb", "buildababe");
	// if ($db -> connect_errno) {
		// echo "Failed to connect to MySQL: (" . $db -> connect_errno . ") " . $db -> connect_error;
	// }
} catch(Exception $e) {
	try {
		//For jack and carli
		$db = new PDO("mysql:host=localhost;dbname=buildababe", "root", "");
	} catch(exception $e) {
		echo "Failed to connect to server, please try again.";
		exit ;
	}
}
//use this one wwwuser
// $db = new PDO("mysql:host=localhost;dbname=lujasaa", "lujasaa", "abcde");
?>