<?php

session_start();
$loggedInUserId = $_SESSION['user_id'];
?>
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
     
          <div class="filteration">
            <span class="fx1">Filter </span>
            <div class="flex">
              <span class="fx2">All</span>
            </div>
            <div class="flex">
              <span class="fx3">Status


                <select id="s-status" name="s-status" style="width: 100px; height: 30px; border-radius: 5px; border: 1px solid #ccc; font-size: 16px;" >
                  <option value=''>All</option>
                  <option value='To Do'>To Do</option>
                  <option value='Doing'>Doing</option>
                  <option value='Done'>Done</option>
                </select>
                 

              </span>
            </div>
            <div class="flex">
              <span class="fx4">Access

                <select id="s-access" name="s-access" style="width: 100px; height: 30px; border-radius: 5px; border: 1px solid #ccc; font-size: 16px;" >
                  <option value='3'>All</option>
                  <option value='1'>Public</option>
                  <option value='2'>Private</option>
                </select>
              </span>
            </div>
            <div class="flex">
              <span class="fx5">
                
                <button id="filter"  onclick="ApplyFilter()" >Apply</button>
              </span>
            </div>
          </div> 
    </div>
  
    <br/><br/>
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
          <tbody id='t-projects'>
         
          </tbody>
        </table>
      </div>
    </div>
  </div>
  
<script>
      // Function to set the first project as the default selection
      function setDefaultProject() {
        var dstatus = document.getElementById("s-status");
        var daccess = document.getElementById("s-access");
        daccess.selectedIndex = 0;
        dstatus.selectedIndex=0;
          ApplyFilter();
        }

      // Execute the function on page load
      setDefaultProject();

      function ApplyFilter() {
        var status = document.getElementById("s-status").value;
        var access = document.getElementById("s-access").value;
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
         //   alert(this.responseText);
            document.getElementById("t-projects").innerHTML = this.responseText;
          }
        };
        xhr.open("GET", "classes/GetProjects.php?status=" + status+"&access="+access, true);
        xhr.send();
      }
    </script>


<?php include "templates/footer.php"; ?>