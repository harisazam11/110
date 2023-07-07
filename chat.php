<?php

session_start();
$loggedInUserId = $_SESSION['user_id'];
?>
<?php include "templates/header.php"; ?>
<?php include "templates/sidebar.php"; ?>


<style type="text/css">

#chat-box {
    margin-left: 210px;
    width: 760px;
  background-color: #4CAF50;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0px 0px 5px #ccc;
    }
#chat-header {
    background-color: #4CAF50;
    color: white;
    height: 60px;
    padding-left: 25px;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
    }
#chat-body {
    padding: 27px;
    height:400px;
    overflow-y: scroll;
    background-color: white;  
}
#chat-footer {
    padding: 6px;
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
    }

#message-input {
    width: 83%;
    padding: 10px;
    border: 2px solid #ccc;
    border-radius: 5px;
    margin-bottom: 10px;
    }
#chat-button1 {
    width: 100px;
    background-color: orange;
    color: white;
    padding: 15px;
    border: none;
    border-radius: 20%;
    cursor: pointer;
    }
</style>

<div class="container" style="float: right; margin-right:0px; "> 
<?php
include("classes/config.php");
$con = $conn;

$id = $_SESSION['user_id'];
$email = $_SESSION['user_name'];
$qry=mysqli_query($con,"SELECT * FROM `register` WHERE email='$email'");
while($row = mysqli_fetch_array($qry)) {
?>
</div>

<div class="form-container" style="padding-top: 0px; margin-top:0px; " >
  <div class="formp" style="background-color: white; padding-top: 20px; margin-top:0px;border-radius: 10px;">  <br> 
  <div  style=" text-align: left;    background-color: #4CAF50; padding-top: 0px; margin-left: 201px;
                margin-right: 200px; border-radius: 13px;"> 
  <div class="iformp" > 
  <div style="float: right; margin-right:0px; color: white; margin-top: 5px;margin-bottom: 5px;"> 
      <a href="userprofile.php?id=<?php echo $row['id']; ?>">
        <b style="font-size: 20px; color: white; "><?php echo $username; ?> &nbsp;</b>
        <img style="border-radius: 50%;" src="upload/profile/<?php echo $row['pp']; ?>" alt="pic" width="50" height="50" ></a>
  </div>
<?php }?>

<div style=" width:140px; float:left;"> 
<div style="color: orange; background-color:white; margin-top:0px; padding-left: 39px; padding-top: 15px; padding-bottom: 12px; width: 210px; border-radius: 10px;">
  <h5 >Provider's Messages</h5></div>
    <div style="margin-top:9px; margin-left: 38px;">

<?php
$sql = "SELECT DISTINCT chat.provider_idc, provider.providername, provider.ppic, provider.provider_id FROM chat JOIN provider ON chat.provider_idc = provider.provider_id 
WHERE user_idc = '$id' ORDER BY mdate ASC";
$result = mysqli_query($con, $sql);
if ($result === false) {
// Handle errors
die("Error: " . mysqli_error($con));
}
if (mysqli_num_rows($result) > 0) {
while ($row = mysqli_fetch_assoc($result)) { ?>

<button class="btn btn-warning" style="margin: 7px; padding: 6px;
border-radius:50%; font-size: 17px;" >
<a  href="umsg.php?provider_id=<?php echo $row['provider_id']; ?>"  onchange="this.form.submit()" >
<img style="border-radius: 50%;" src="provider/upload/servicespics/<?php echo $row['ppic']; ?>" alt="pic" width="50" height="50" > <b> <?php echo $row['providername']; ?></b>
</a>
</button>
  <?php } } ?>
<!--
<?php //echo $row['username'];?> </a>
<span class="input-group-btn">  
<button type="submit" class="btn btn-outline-secondary" class="btn btn-warning">Search</button>
</span> -->  </div> </div>

  <?php
  $provider_id1= $_GET['provider_id'];
  $id = $_SESSION['id'];
  $sql = "SELECT DISTINCT chat.provider_idc, provider.providername, provider.ppic, provider.provider_id FROM chat JOIN provider ON chat.provider_idc = provider.provider_id 
  WHERE provider_idc = '$provider_id1' ORDER BY mdate ASC";
  $result = mysqli_query($con, $sql);
  if ($result === false) {
  // Handle errors
  die("Error: " . mysqli_error($con));
  }
  if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) { 
    ?>

<div id="chat-box"> 
<!-- Chat Header -->
<div id="chat-header">
<div style="float:left; color:white; font-size: 20px; font-weight: 22px;margin-top: 5px;margin-bottom: 5px;">
<span style=""> <a href="serviceview.php?provider_id=<?php echo $row['provider_id']; ?>"  >  
<img style="border-radius: 50%;" src="provider/upload/servicespics/<?php echo $row['ppic']; ?>" alt="pic" width=50 height="50" >  </span>&nbsp;
<span id="recipient-name" style=""> <b style=" color:white;"><?php echo $row['providername']; ?></b></a> </span>
</div>

<?php } } ?> 
</div>
<?php 
// Establish database connection
$con = mysqli_connect("localhost", "root", "", "ihrcc");
// Check if connection was successful
if (mysqli_connect_errno()) {
echo "Failed to connect to MySQL: " . mysqli_connect_error();
exit();
}
$provider_id= $_GET['provider_id'];
$id = $_SESSION['id'];
$sql = "SELECT c.*, u.username, u.id, u.pp,
p.provider_id, p.providername,p.ppic FROM chat c
JOIN uusers u ON c.user_idc = u.id
JOIN provider p ON c.provider_idc = p.provider_id
WHERE (c.user_idc = '$id' AND c.provider_idc = '$provider_id')
ORDER BY c.mdate ASC";
$result = mysqli_query($con, $sql);

// Check if query was executed successfully
if ($result) {
// Display chat messages in chat box div
echo "<div id='chat-body'>";
while ($row = mysqli_fetch_array($result)) {

$name=$row['sendername'];

$message = $row['message'];
$mdate = date('d M Y h:i A', strtotime($row['mdate']));
echo "<div class='message'>";
?>

<?php

echo "<span class='sender'><b style='color:green;'><br>$name</b></span>";
echo "<span class='message' style='color:black; float-size:19px;'>: $message </span>";
echo "<span class='timestamp' style='font-size:10px; float:right; padding-top:4px'>$mdate<br><br></span>";

echo "</div>";
}
echo "</div>";
} else {
// Display error message
echo "Failed to execute query: " . mysqli_error($con);
}

// Close database connection
mysqli_close($con);
?>



<div id="chat-footer">
<form action="php/chatu.php" method="post">
<input type="hidden" name="user_idc" value="<?php echo $id;?>" >
<input type="hidden" name="provider_idc" value="<?php echo $provider_id;?>" >
<input type="hidden" name="sendername" value="<?php echo $username;?>" >
<input type="hidden" name="senderid" value="<?php echo $id;?>" >
<input type="text" id="message-input" name="message" placeholder="Type your message..." required/>
<input type="submit" value="Send" id="chat-button1">
</form> 
</div>

</div>   

</div>
</div>

</div>
</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$("#chat-button").click(function(){
$("#chat-box").toggle();
});
});
</script>

<script type="text/javascript">
$(document).ready(function() {
$("#send-button").click(function() {
var message = $("#message-input").val();
var recipient_id = $("#recipient-id").val();
$.ajax({
type: "POST",
url: "send_message.php",
data: { message: message, recipient_id: recipient_id },
success: function(response) {
$("#message-input").val("");
$("#chat-body").append("<p class='message'>" + message + "</p>");
}
});
});
});

</script>

<?php include "templates/footer.php";?>