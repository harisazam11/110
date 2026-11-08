<?php
session_start();
include("classes/config.php");

$uid = $_SESSION['user_id'];
$sql = "SELECT * FROM notifications WHERE user_id = $uid ORDER BY not_id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $row['not_text'] . '</td>';
    echo '<td>' . $row['created'] . '</td>';
    if ($row['task_id'] != NULL)
      echo '<td><a href="mytasks.php?tid=' . $row["task_id"] . '">View</a></td>';
    else
      echo '<td><a href="tasks.php?pid=' . $row["project_id"] . '">View</a></td>';
    echo '</tr>';
  }
} else {
  echo '<tr><td colspan="3">No notifications found.</td></tr>';
}

$conn->close();
?>
