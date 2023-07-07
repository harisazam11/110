<?php
session_start();
include("classes/config.php");



// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Get the user ID from the session
$uid = $_SESSION['user_id'];

// Retrieve user data from the database
$sql = "SELECT * FROM register WHERE user_id = $uid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username = $row['username'];
    $password = $row['password'];
    $picture = $row['picture'];
} else {
    echo "User not found.";
    exit();
}

// Update user data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update username and password
    $newUsername = $_POST['username'];
    $newPassword = $_POST['password'];

    $updateSql = "UPDATE register SET username = '$newUsername', password = '$newPassword' WHERE user_id = $uid";

    if ($conn->query($updateSql) === TRUE) {
        echo "User data updated successfully.";
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
                echo "Profile picture updated successfully.";
            } else {
                echo "Error updating profile picture: " . $conn->error;
            }
        } else {
            echo "Error uploading profile picture: " . $fileError;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        form {
            margin-bottom: 20px;
        }
        form input {
            margin-bottom: 10px;
        }
        img {
            max-width: 200px;
        }
    </style>
</head>
<body>
    <h1>User Profile</h1>
    <form method="POST" enctype="multipart/form-data">
        <label for="username">Username:</label>
        <input type="text" name="username" value="<?php echo $username; ?>"><br>
        <label for="password">Password:</label>
        <input type="password" name="password" value="<?php echo $password; ?>"><br>
        <label for="picture">Profile Picture:</label>
        <input type="file" name="picture"><br>
        <input type="submit" value="Update">
    </form>
    <h2>Profile Picture:</h2>
    <?php if ($picture !== null): ?>
        <img src="<?php echo $picture; ?>" alt="Profile Picture">
    <?php else: ?>
        <p>No profile picture available.</p>
    <?php endif; ?>
</body>
</html>
