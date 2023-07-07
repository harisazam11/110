<?php include "templates/header.php"; ?>
<?php include "templates/sidebar.php"; ?>
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
                echo ".";
            } else {
                echo "Error updating profile picture: " . $conn->error;
            }
        } else {
            echo "Error uploading profile picture: " . $fileError;
        }
    }
}
?>


  
<div class="container">
    <h3 class="page-title">General Settings</h3>
     <div class="title">

<div class="form-container">  
    <form method="POST" enctype="multipart/form-data"  class="create-form">
      
    <?php if ($picture !== null): ?>
        <img src="<?php echo $picture; ?>" alt="Profile Picture"  width="300" >
    <?php else: ?>
        <p>No profile picture available.</p>
    <?php endif; ?><br>

     <input type="file" name="picture" class="input" ><br>
     Username <input type="text" name="username" value="<?php echo $username; ?>" class="input" ><br>
      Password  <input type="password" name="password" value="<?php echo $password; ?>"  class="input" ><br>
     <input type="Submit" value="Update" class="input"  />

    </form> </div>
</div>
</div>
</body>
</html>
