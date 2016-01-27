<?php
$COOKIE_LENGTH = 40;
include('connection.php');
if (isset($_POST['username']) && strlen($_POST['username']) > 0 && 
	isset($_POST['password']) && strlen($_POST['password']) > 0) {
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	$getSaltPrep = $db -> prepare('Select salt from LOGIN where username = ?');
	$getSaltPrep -> execute(array($username));
	
	if($getSaltPrep->rowCount() < 1){
		echo '{"error": true, "err_pos": 1}';
		exit;
	}
	
	$saltFetch = $getSaltPrep -> fetch();
	$salt = $saltFetch['salt'];
	$calculatedPassword = sha1($password.$salt);
	//hashing here
	// and here
	// and here too
	// and probly here
	// maybe done here
	//for sure done here
	//hashed af
	
	$getExistsPrep = $db -> prepare('Select count(username) as numFound from LOGIN where username = ? and password = ?');
	$getExistsPrep -> execute(array($username, $calculatedPassword));
	
	if($getExistsPrep->rowCount()< 1){
		echo '{"error": true, "err_pos": 2}';
		exit;
	}
	
	$numFoundFetch = $getExistsPrep -> fetch();
	$numFound = $numFoundFetch['numFound'];
	
	if($numFound == 0){
		echo '{"error": true, "err_pos": 3}';
		exit;
	}
	
	$generatedCookie = generateCookie($COOKIE_LENGTH);
	$updatePrep = $db -> prepare('Update LOGIN set session_cookie = ? Where username = ?');
	$updatePrep -> execute(array($generatedCookie, $username));
	
		
	echo '{"error": false, "cookie":"'.$generatedCookie.'"}';
} else {
	echo '{"error": true, "err_pos": 4}';
}

function generateCookie($length)
{
	$valid_chars = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPLAKSJDHFGNBMVCXZ1524367890";
    // start with an empty random string
    $random_string = "";

    // count the number of chars in the valid chars string so we know how many choices we have
    $num_valid_chars = strlen($valid_chars);

    // repeat the steps until we've created a string of the right length
    for ($i = 0; $i < $length; $i++)
    {
        // pick a random number from 1 up to the number of valid chars
        $random_pick = mt_rand(1, $num_valid_chars);

        // take the random character out of the string of valid chars
        // subtract 1 from $random_pick because strings are indexed starting at 0, and we started picking at 1
        $random_char = $valid_chars[$random_pick-1];

        // add the randomly-chosen char onto the end of our string so far
        $random_string .= $random_char;
    }

    // return our finished random string
    return $random_string;
}
?>