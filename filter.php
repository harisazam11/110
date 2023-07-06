
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
  <form id="filter" action="" method="GET">
    <div class="filteration">
      <span class="fx1">Filter </span>
      <div class="flex">
        <span class="fx2">All</span>
      </div>
      <div class="flex">
        <span class="fx3">
          <select name="status" style="width: 100px; height: 30px; border-radius: 5px; border: 1px solid #ccc; font-size: 16px;">
            <option>Status</option>
            <?php
            $con = mysqli_connect("localhost", "root", "", "ems");
            $sql = "SELECT DISTINCT Status FROM projects";
            $result = mysqli_query($con, $sql);
            if ($result === false) {
              // Handle errors
              die("Error: " . mysqli_error($con));
            }
            if (mysqli_num_rows($result) > 0) {
              $statusArray = array();
              while ($row = mysqli_fetch_assoc($result)) {
                $status = $row['Status'];
                if (!in_array($status, $statusArray)) {
                  array_push($statusArray, $status);
                  echo "<option>{$status}</option>";
                }
              }
            }
            ?>
          </select>
        </span>
      </div>
      <div class="flex">
        <span class="fx4">Access
          <select name="access" style="width: 100px; height: 30px; border-radius: 5px; border: 1px solid #ccc; font-size: 16px;">
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
          <input id="filter" type="submit" value="Filter" />
        </span>
      </div>
    </div>
  </form>
</div>

<?php
include("classes/config.php");

// Retrieve distinct access and status values from the projects table
$sql = "SELECT DISTINCT access, status FROM projects";
$result = $conn->query($sql);

// Check if the query was successful
if ($result->num_rows > 0) {
  // Create arrays to store the access and status values
  $accessArray = array();
  $statusArray = array();

  // Loop through the query results
  while ($row = $result->fetch_assoc()) {
    $access = $row['access'];
    $status = $row['status'];

    // Add unique access values to the array
    if (!in_array($access, $accessArray)) {
      array_push($accessArray, $access);
    }

    // Add unique status values to the array
    if (!in_array($status, $statusArray)) {
      array_push($statusArray, $status);
    }
  }

  //////

  // Check if the filter form has been submitted
  if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['status']) && isset($_GET['access'])) {
    // Get the selected filter options
    $selectedStatus = $_GET['status'];
    $selectedAccess = $_GET['access'];

    // Construct the SQL query with the selected filter options
    $filterQuery = "SELECT project_id, project_name, team, access, deadline, status FROM projects";

    // Add the WHERE clause to filter by status value
    if ($selectedStatus != 'Status') {
      $filterQuery .= " WHERE status = '{$selectedStatus}'";
    }

    // Add the WHERE clause to filter by access value
    if ($selectedAccess != 'Access') {
      if ($selectedStatus != 'Status') {
        $filterQuery .= " AND";
      } else {
        $filterQuery .= " WHERE";
      }
      if ($selectedAccess == 'private') {
        $filterQuery .= " access = 0";
      } elseif ($selectedAccess == 'public') {
        $filterQuery .= " access = 1";
      }
    }

    // Execute the filtered query
    $filteredResult = $conn->query($filterQuery);

    // Check if the filtered query returnedany results
    if ($filteredResult->num_rows > 0) {
      echo '<div class="project-list">';
      echo '<div class="pro-list">';
      echo '<table>';
      echo '<thead>';
      echo '<tr>';
      echo '<td>Project name</td>';
      echo '<td>Total Members</td>';
      echo '<td>Access</td>';
      echo '<td>Deadline</td>';
      echo '<td>Status</td>';
      echo '<td>Action</td>';
      echo '</tr>';
      echo '</thead>';
      echo '<tbody>';

      // Output the filtered query results in the table
      while ($row = $filteredResult->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['project_name'] . '</td>';
        echo '<td>' . $row['team'] . '</td>';

        if ($row['access'] == 0) {
          echo '<td>Private</td>';
        } else {
          echo '<td>Public</td>';
        }

        echo '<td>' . $row['deadline'] . '</td>';
        echo '<td>' . $row['status'] . '</td>';
        echo '<td><a href="tasks.php?pid=' . $row["project_id"] . '">View</a></td>';
        echo '</tr>';
      }

      echo '</tbody>';
      echo '</table>';
      echo '</div>';
      echo '</div>';
    } else {
      echo 'No results found.';
    }
  }
}

// Close the database connection
$conn->close();
?>
<?php include "templates/footer.php"; ?>