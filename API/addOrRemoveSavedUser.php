<?php
include ('connection.php');
if (isset($_POST['session']) && isset($_POST['userId'])) {
	$session = $_POST['session'];
	$userId = $_POST['userId'];

	//Check that request is from a valid login
	$q1 = $db -> prepare("Call loginCheck(:cookie, :userId)");
	$q1 -> bindValue(':cookie', $session);
	$q1 -> bindValue(':userId', $userId);
	$q1 -> execute();
	$rowC = $q1 -> rowCount();
	$q1->closeCursor();
	if ($rowC != 1) {
		//invalid login
		echo '{"error": true}';
		exit;
	}
} else {
	echo '{"error": true}';
	exit;
}

// TODO sanitize input
$userId = $_POST['userId'];
$savedId = $_POST['$savedId'];



//check to see if user has other user saved
$q2 = $db -> prepare("Call isUserSaved(:userId, :savedId)");
	$q2 -> bindValue(':userId', $userId);
    $q2 -> bindValue(':savedId', $savedId);
	$q2 -> execute();
	$savedUserCount = $q2 -> rowCount();

    if($savedUserCount > 1){
        //we messed up
        echo '{"error": true}';
        exit;
    }
    
    if($savedUserCount == 1){
        //user is saved so remove from saved_user
        removeSaved($userId, $savedId, $db);
    }else{
        //user is not saved so add into saved_user
        addSaved($userId, $savedId, $db);
    }
    exit;






function removeSaved($userId, $savedId, $db){
    

    
    
    //print out that the user was removed
}





function addSaved($userId, $savedId, $db){

    //print out that the user was added
}





?>