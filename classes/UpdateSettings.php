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
        if ($_FILES['picture']['name'] !== '') {
            $file = $_FILES['picture'];
            $fileName = $file['name'];
            $fileTmpName = $file['tmp_name'];
            $fileError = $file['error'];

            // Check for file upload errors
            if ($fileError === 0) {
                $destination = 'images/pp/' . $fileName;
                move_uploaded_file($fileTmpName, $destination);

                $updatePictureSql = "UPDATE register SET picture = '$destination' WHERE user_id = $uid";

                if ($conn->query($updatePictureSql) === TRUE) {
                    header("Location: ../settings.php");
                } else {
                    echo "Error updating profile picture: " . $conn->error;
                }
            } else {
                echo "Error uploading profile picture: " . $fileError;
            }
        }
        header("Location: ../settings.php");
    }
?>
