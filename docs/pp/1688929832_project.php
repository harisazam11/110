<?php include "templates/header.php"; ?>
<?php include "templates/sidebar.php"; ?>

  <div class="overlay" id="overlay">
    <div class="form-container">
      <h2>Create New Project</h2>
      <hr />
      <form action="classes/createproject.php" method="POST" class="create-form">
        <div class="filteration">
          <input type="text" name="projectName" placeholder="Project Name" class="input" required />
          <input type="text" name="teamMembers" class="input" placeholder="Add Team Members" />
          
        </div>

        <div class="filteration">
          <div class="input" style="padding-right: 2px">
            <label class="access">Access: </label>
            <input type="radio" id="private" name="access" <?php if (isset($access) && $access=="private") echo "checked";?> value="Private" />
            <label for="private" class="radio-label">Private</label>
            <input type="radio" id="public" name="access" <?php if (isset($access) && $access=="public") echo "checked";?> value="Public" />
            <label for="public" class="radio-label">Public</label>
          </div>


        </div>
        <div class="filteration">
          <div class="input" style="
                display: inline-flex;
                align-items: center;
                margin-bottom: 15px;
                padding-right: 2px;
              ">
            <label for="deadline" style="margin-right: 12px">Deadline:
            </label>
            <input type="date" name="deadline" id="deadline" /><br><br>
          </div>
        </div>
        <input type="submit" value="Submit" id="create-project">
      </form>
    </div>
  </div>

  <div class="container">
    <div class="title">
      <div class="project-bar">
        <div class="add-heading">Project</div>

        <div class="add-btnp">
          <div class="label">
            <input id="add-project-button" type="submit" value="Create New Project" />
          </div>
        </div>
      </div>
    </div>

    <div class="filter-bar"> 
     
         <form  id="filter" action="filter.php" method="GET">
      <div class="filteration">
        <span class="fx1">Filter </span>
        <div class="flex">
          <span class="fx2">All</span>
        </div>
        <div class="flex">
         <span class="fx3">Status


  <select name="search" style="width: 100px; height: 30px; border-radius: 5px; border: 1px solid #ccc; font-size: 16px;" >
    <option>Status</option>
    <?php
    $con = mysqli_connect("localhost", "root", "", "ems");
    $sql = "SELECT DISTINCT Status FROM projects"; // Update query to retrieve distinct status values
    $result = mysqli_query($con, $sql);
    if ($result === false) {
      // Handle errors
      die("Error: " . mysqli_error($con));
    }
    if (mysqli_num_rows($result) > 0) {
      $statusArray = array(); // Create an array to store unique status values
      while ($row = mysqli_fetch_assoc($result)) {
        $status = $row['Status'];
        if (!in_array($status, $statusArray)) { // Check if status value is already in the array
          array_push($statusArray, $status); // Add unique status value to the array
          echo "<option>{$status}</option>"; // Display the unique status value
        }
      }
    }
    ?>
  </select>

          </span>
        </div>
        <div class="flex">
          <span class="fx4">Access

 <select name="search" style="width: 100px; height: 30px; border-radius: 5px; border: 1px solid #ccc; font-size: 16px;" >
<option>Access</option>
  <?php
  $con = mysqli_connect("localhost", "root", "", "ems");
  $sql = "SELECT DISTINCT access FROM projects";
  $result = mysqli_query($con, $sql);
  if ($result === false) {
    // Handle errors
    die("Error: " . mysqli_error($con));
  }
  if (mysqli_num_rows($result) > 0) {
    $accessArray = array();
    while ($row = mysqli_fetch_assoc($result)) {
      $access = $row['access'];
      if (!in_array($access, $accessArray)) {
        array_push($accessArray, $access);
        if ($access == 0) {
          echo "<option value='private'>Private</option>";
        } elseif ($access == 1) {
          echo "<option value='public'>Public</option>";
        }
      }
    }
  }
  ?>
</select>

          
          </span>
        </div>
        <div class="flex">
          <span class="fx5">
            
            <input id="filter"  type="submit" value="Filter" />



          </span>
        </div>
      </div> </form>
    </div>
  

    <div class="project-list">
      <div class="pro-list">
        <table>
          <thead>
            <tr>
              <td>Project name</td>
              <td>Total Members</td>
              <td>Access</td>
              <td>Deadline</td>
              <td>Status</td>
              <td>Action</td>
            </tr>
          </thead>
          <tbody>
          <?php
           include("classes/config.php");

            // Retrieve project names from the database table
            $sql = "SELECT project_id, project_name, team, access, deadline,status FROM projects";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              // Output a dropdown menu for each project name
              while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['project_name'] . '</td>';
                // Display the rest of the project information
                echo '<td>'. $row['team'] . '</td>';
                if($row['access']==0)
                {echo '<td>private</td>';}
                else{
                  echo '<td>public</td>';
                }
                echo '<td>' . $row['deadline'] . '</td>';
                echo '<td>' . $row['status'] . '</td>';
                echo '<td><a href="tasks.php?pid='.$row["project_id"].'">View</a></td>';
                echo '</tr>';
              }
            } 
            // Close the database connection
            $conn->close();
          ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  
<?php include "templates/footer.php"; ?>