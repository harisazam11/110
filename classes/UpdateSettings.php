<?php
    session_start();
    include('config.php');
    // Get the user ID from the session
    $uid = $_SESSION['user_id'];

    // Retrieve user data from the database
    $sql = "SELECT * FROM register WHERE user_id = $uid";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $uuser = $row['username'];
        $upass = $row['password'];
        $picture = $row['picture'];
    } else {
        echo "User not found.";
        exit();
    }

    // Update user data
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Update username and password
        $newUsername = $_POST['u-user'];
        $newPassword = $_POST['u-pass'];

        $updateSql = "UPDATE register SET username = '$newUsername', password = '$newPassword' WHERE user_id = $uid";

        if ($conn->query($updateSql) === TRUE) {
            echo ".";
        } else {
            echo "Error updating user data: " . $conn->error;
        }

        // Update profile picture
        if ($_FILES['picturee']['name'] != '') {
            $file = $_FILES['picturee'];
            $fileName = $file['name'];
		$fileNameAr= explode(".", $fileName);
		$extension = end($fileNameAr);
		$ext = strtolower($extension);
       // echo "<script type= 'text/javascript'> alert(".$fileName.")</script>";
       
		if ($ext == "jpg" || $ext == "jpeg" || $ext == "png") {
			
			//print_r($file['size']);

			if ($file['size'] > (1024 * 2)) {
				    
					$uniqueImageName = "/project/images/pp/".time()."_".$file['name'];
                  //  echo "<script type= 'text/javascript'> alert(".$uniqueImageName.")</script>";
                    $uploaded=move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT'].$uniqueImageName);
                //    echo "<script type= 'text/javascript'> alert(".$_SERVER['DOCUMENT_ROOT'].$uniqueImageName.")</script>";
                    
                    if ($uploaded==TRUE){
                        $updatePictureSql = "UPDATE register SET picture = '$uniqueImageName' WHERE user_id = $uid";

                        if ($conn->query($updatePictureSql) === TRUE) {
                            header("Location: ../settings.php");
                        } else {
                            echo "Error updating profile picture: " . $conn->error;
                        }
                    }
                }
            }

        } else
         {
                echo "Error uploading profile picture: " . $fileError;
            }
        
    
        header("Location: ../settings.php");
    }

?>
