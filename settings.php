<?php
session_start();
include("classes/config.php");

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to login page if not logged in
    exit();
}
?>
<?php include "templates/header.php"; ?>
<?php include "templates/sidebar.php"; ?>


  
<div class="container">
    <h3 class="page-title">General Settings</h3>
     <div class="title">

<div class="form-container">  
    <form action="classes/UpdateSettings.php" method="POST" enctype="multipart/form-data"  class="create-form">
      
    
            <?php
            include('classes/config.php');
            $sql = "select * from register where user_id = ".$_SESSION['user_id'];
            $result = $conn->query($sql);
            $picpath = $result->fetch_assoc()['picture'];
            if($picpath!=null){
              echo  '<img src="'.$picpath.'" alt="" style="width:150px;height:150px; align-items:center;text-align:center;margin-left:30%;border-radius:149px;"/>';
            }
            else{
                echo ' <img src="images/people.svg" alt="" style="width:150px;height:150px; align-items:center;text-align:center;margin-left:30%;border-radius:149px;"/>';
            }
            ?>
            <br>

     <input type="file" name="picture" class="input" ><br>
     Username <input type="text" name="username" value="<?php echo $username; ?>" class="input" ><br>
      Password  <input type="password" name="password" value="<?php echo $password; ?>"  class="input" ><br>
     <input type="Submit" value="Update" class="input"  />

    </form> </div>
</div>
</div>
</body>
</html>
