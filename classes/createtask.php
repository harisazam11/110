<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $user = $_POST['t-user'];
    $deadline = $_POST['t-deadline'];
    $name = $_POST['t-name'];
    $project_id = $_POST['t-pid'];
    $uid = explode(",", $user)[0];
    $umail = explode(",", $user)[1];
    include('config.php');
    
    $sql = "INSERT INTO tasks (task_name,project_id, assigned_to,user_email,status, due_date, time_required, time_spent,timer)
    VALUES ('$name', '$project_id', '$uid','$umail', 'To Do','$deadline','0','0','00:00:00')";
    $result = $conn->query($sql);
    if ($result) {
    // Get the project ID assigned to the newly inserted row
    $taskId = $conn->insert_id;
    $sql = "select project_name from projects where project_id = $project_id";
    $rs= $conn->query($sql);

    //insert data in Notification Table
    $notification_text = "You are Assigned a Task: ".$name." under Project: ".$rs->fetch_assoc()['project_name']." ";
    $sql = "Insert into notifications (not_text,user_id,user_email,project_id,task_id)
      values('$notification_text',$uid,'$umail',$project_id,$taskId)";
    $rs= $conn->query($sql);

    //update file path

    // Update profile picture
    if ($_FILES['t-file']['name'] !== '') {
        $file = $_FILES['t-file'];
        $fileName = $file['name'];
    $fileNameAr= explode(".", $fileName);
    $extension = end($fileNameAr);
    $ext = strtolower($extension);
   // echo "<script type= 'text/javascript'> alert(".$fileName.")</script>";
   
    //if ($ext == "jpg" || $ext == "jpeg" || $ext == "png") 
    
        
        //print_r($file['size']);

      //  if ($file['size'] > (1024 * 2)) 
      
                
                $uniqueImageName = "/project/docs/pp/".time()."_".$file['name'];
              //  echo "<script type= 'text/javascript'> alert(".$uniqueImageName.")</script>";
                $uploaded=move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT'].$uniqueImageName);
            //    echo "<script type= 'text/javascript'> alert(".$_SERVER['DOCUMENT_ROOT'].$uniqueImageName.")</script>";
                
                if ($uploaded==TRUE){

                    $updatePictureSql = "UPDATE tasks SET file = '$uniqueImageName' WHERE task_id = $taskId";

                    if ($conn->query($updatePictureSql) === TRUE) {
                        header("Location: ../tasks.php?pid=$project_id");
                    } else {
                        echo "Error uploading File: " . $conn->error;
                    }
                }
                else {
                    echo "Error uploading File: " . $fileError;
                }
  }
    $conn->close();
    header("location: ../tasks.php?pid=$project_id");
    }
    else{
        $conn->close();
        header("location: ../tasks.php?pid=$project_id");
    }
}
?>