<?php
include ('connection.php');

$userId = $_GET['id'];
$userId = filter_var($userId, FILTER_SANITIZE_STRING);

$q2 = $db -> prepare("select profilePicId from profile where profile.id = :userId");
	$q2 -> bindValue(':userId', $userId);
	$q2 -> execute();
    $rowC = $q2 -> rowCount();
    if($rowC == 1){
        $row = $q2 -> fetch(PDO::FETCH_ASSOC);
        if($row['profilePicId']==null){
            echo 'null';
            exit; 
        }
        echo "img/".$row['profilePicId'];
	       $q2->closeCursor();
    }
    else{
        echo 'null';
        exit; 
    }
	
    
	
?>