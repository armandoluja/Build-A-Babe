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
$userIdFrom = $_POST['userId'];
$userIdTo = $_POST['userIdTo'];
$content = $_POST['content'];

if($userIdFrom == $userIdTo){
    //cannot send message to yourself
    echo '{"error": true}';
	exit;
}

$chatId = getChat($userIdFrom, $userIdTo, $db);





try {
   sendMessage($chatId, $userIdFrom, $userIdTo, $content, $db);
} catch (Exception $e) {
   echo '{"error": true}';
    exit;
}
echo '{"error": false}';
    exit;


    function sendMessage($chatId, $userIdFrom, $userIdTo, $content, $db){
        $q3 = $db -> prepare("Call sendMessage(:chatId, :senderId, :receiverId, :content)");
        $q3 -> bindValue(':chatId', $userIdFrom);
        $q3 -> bindValue(':senderId', $userIdFrom);
        $q3 -> bindValue(':receiverId', $userIdTo);
        $q3 -> bindValue(':content', $content);
        $q3 -> execute();
        $q3->closeCursor();
    }

    function getChat($userIdFrom, $userIdTo, $db){
        $q1 = $db -> prepare("Call getChat(:userIdFrom, :userIdTo)");
        $q1 -> bindValue(':userIdFrom', $userIdFrom);
        $q1 -> bindValue(':userIdTo', $userIdTo);
        $q1 -> execute();
        $rowC = $q1 -> rowCount();
        
        if($rowC > 1){
            $q1->closeCursor();
         //We messed up, chat has a duplicate row 
            exit;
        }
        else if($rowC != 1){
            $q1->closeCursor();
            //Chat does not exist, lets make one!
            if($userIdFrom < $userIdTo)
                return createChat($userIdFrom, $userIdTo, $db);
            else
                return createChat($userIdTo, $userIdFrom, $db);
        }

        $row = $q1 -> fetch(PDO::FETCH_ASSOC);
        $q1->closeCursor();
        return $row["chatId"];
        
    }


    function createChat($userId1, $userId2, $db){
        $q2 = $db -> prepare("Call createChat(:userId1, :userId2)");
        $q2 -> bindValue(':userId1', $userId1);
        $q2 -> bindValue(':userId2', $userId2);
        $q2 -> execute();
        $q2->closeCursor();
        return getChat($userIdFrom, $userIdTo, $db);
    }
?>