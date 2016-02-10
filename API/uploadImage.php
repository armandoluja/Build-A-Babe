<?php
include ('connection.php');
$maxFileSize = 100000;
if (isset($_FILES['file']['type']) && isset($_POST['userId']) && isset($_POST['session'])) {

	$userId = $_POST['userId'];
	$session = $_POST['session'];
	$userId = filter_var($userId, FILTER_SANITIZE_NUMBER_INT);
	$session = filter_var($session, FILTER_SANITIZE_STRING);

	//Check if valid login
	$q1 = $db -> prepare("Call loginCheck(:cookie, :userId)");
	$q1 -> bindValue(':cookie', $session);
	$q1 -> bindValue(':userId', $userId);
	$q1 -> execute();
	$rowC = $q1 -> rowCount();
	$q1 -> closeCursor();
	if ($rowC != 1) {
		echo "invalid login";
		exit ;
	}

	$validextensions = array("jpeg", "jpg", "png");
	$temporary = explode(".", $_FILES['file']['name']);
	$file_extension = end($temporary);
	$file_extension = strtolower($file_extension);

	if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")) && ($_FILES["file"]["size"] < $maxFileSize) && in_array($file_extension, $validextensions)) {
		// valid file type,size,extension
		// proceed
		if ($_FILES['file']['error'] > 0) {
			echo "error uploading file";
			exit ;
			//error uploading file
		}

		$newImageId = createPicId($db, $userId);

		if (file_exists("../img/" . $newImageId)) {
			echo "file already exists";
			exit ;
			//file already exists
		} else {
			$sourcePath = $_FILES['file']['tmp_name'];
			// store sourcepath
			$targetPath = "../img/" . $newImageId;
			// copy($sourcePath, $targetPath.'.jpg');
			
			if (convertImage($sourcePath, $targetPath, 80) == 0) {
				echo "made it here";
				move_uploaded_file($sourcePath, $targetPath);
			}

			if (isset($_POST['setAsProfilePic'])) {
				if ($_POST['setAsProfilePic']) {
					setProfilePic($db, $userId, $newImageId);
					echo "set as profile pic";
				}
			}
		}
	}
	exit ;
} else {
	// invalid file size or type
	echo "invalid file size or type";
	exit ;
}

function setProfilePic($connection, $userId, $imageId) {
	$setProfilePic = $connection -> prepare("Call setProfilePictureId(:userId,:picId)");
	$setProfilePic -> bindValue('userId', $userId);
	$setProfilePic -> bindValue('picId', $imageId);
	$setProfilePic -> execute();
}

/**
 * insert into image table, get the id, store it
 */
function createPicId($connection, $userId) {
	$createId = $connection -> prepare("Call addPicture(:userId)");
	$createId -> bindValue('userId', $userId);
	$createId -> execute();
	$createId -> closeCursor();

	$getImage = $connection -> prepare("Call getNewestPic(:userId)");
	$getImage -> bindValue('userId', $userId);
	$getImage -> execute();
	$newImageId;
	if ($getImage -> rowCount() < 1) {
		echo "failed create pic id";
		exit ;
		// failed to generate an id with the previous query
	} else {
		$newImageId = $getImage -> fetch();
		$newImageId = $newImageId['imageId'];
		return $newImageId;
	}
}

function convertImage($originalImage, $outputImage, $quality) {
	// jpg, png, gif or bmp?
	$exploded = explode('.', $originalImage);
	$ext = $exploded[count($exploded) - 1];
	$ext = strtolower($ext);

	if (preg_match('/jpg|jpeg/i', $ext)) {
		$imageTmp = imagecreatefromjpeg($originalImage);
	} else if (preg_match('/png/i', $ext)) {
		$imageTmp = imagecreatefrompng($originalImage);
	} else if (preg_match('/gif/i', $ext)) {
		$imageTmp = imagecreatefromgif($originalImage);
	} else if (preg_match('/bmp/i', $ext)) {
		$imageTmp = imagecreatefrombmp($originalImage);
	} else {
		return 0;
	}
	// quality is a value from 0 (worst) to 100 (best)
	imagejpeg($imageTmp, $outputImage, $quality);
	imagedestroy($imageTmp);
	return 1;
}
?>