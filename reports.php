<?php 
session_start();
$loggedInUserId = $_SESSION['user_id'];

if (isset($_GET['pid'])) {

  $selectedProjectId = $_GET['pid'];
} else {
  // If pid is not set, set the selected project ID to the first item in the dropdown
  $selectedProjectId = '';
}
?>
<?php include "templates/header.php"; ?>
<?php include "templates/sidebar.php"; ?>
<link rel="stylesheet" href="./css/bootstrap.css" />
  
<style>
    .ui-widgets {
    position: relative;
    display: inline-block;
    width: 10rem;
    height: 10rem;
    border-radius: 9rem;
    margin:1.5rem;
    border: 1.2rem solid palegreen;
    box-shadow: inset 0 0 7px grey;
    border-left-color: lightblue;
    border-top-color:blue ;
    border-right-color: darkblue;
    border-bottom-color: white ;
    text-align: center;
    box-sizing: border-box;
	}
	
	/* Apply css properties to the second
		child of ui-widgets class */
	.ui-widgets:nth-child(2) {
		border-top-color:lightblue ;
		border-right-color: blue;
		border-left-color: darkblue;
		border-bottom-color: white;
	}
	
	/* Apply css properties to ui-widgets
	class and ui-values class */
	.ui-widgets .ui-values {
		top: 40px;
		position: absolute;
		left: 10px;
		right: 0;
		font-weight: 700;
		font-size: 2.0rem;
	}
	
	/*  Apply css properties to ui-widgets 
	class and ui-labels class */
	.ui-widgets .ui-labels {
		left: 0;
		bottom: -16px;
		text-shadow: 0 0 4px grey;
		color:black;
		position: absolute;
		width: 100%;
		font-size: 16px;
	}



	body, table, input, select, textarea {

	}


	.graph {
		margin-bottom:1em;
	font:normal 100%/150% arial,helvetica,sans-serif;
	}

	.graph caption {
		font:bold 150%/120% arial,helvetica,sans-serif;
		padding-bottom:0.33em;
	}

	.graph tbody th {
		text-align:right;
	}

	@supports (display:grid) {

	@media (min-width:32em) {

		.graph {
			display:block;
      width:600px;
      height:300px;
		}

		.graph caption {
			display:block;
		}

		.graph thead {
			display:none;
		}

		.graph tbody {
			position:relative;
			display:grid;
			grid-template-columns:repeat(auto-fit, minmax(2em, 1fr));
			column-gap:2.5%;
			align-items:end;
			height:100%;
			margin:3em 0 1em 2.8em;
			padding:0 1em;
			border-bottom:2px solid rgba(0,0,0,0.5);
			background:repeating-linear-gradient(
				180deg,
				rgba(170,170,170,0.7) 0,
				rgba(170,170,170,0.7) 1px,
				transparent 1px,
				transparent 20%
			);
		}

		.graph tbody:before,
		.graph tbody:after {
			position:absolute;
			left:-3.2em;
			width:2.8em;
			text-align:right;
			font:bold 80%/120% arial,helvetica,sans-serif;
		}

		.graph tbody:before {
			content:"100%";
			top:-0.6em;
		}

		.graph tbody:after {
			content:"0%";
			bottom:-0.6em;
		}

		.graph tr {
			position:relative;
			display:block;
		}

		.graph tr:hover {
			z-index:999;
		}

		.graph th,
		.graph td {
			display:block;
			text-align:center;
		}

		.graph tbody th {
			position:absolute;
			top:-3em;
			left:0;
			width:100%;
			font-weight:normal;
			text-align:center;
     		white-space:nowrap;
			text-indent:0;
			transform:rotate(-45deg);
		}

		.graph tbody th:after {
			content:"";
		}

		.graph td {
			width:100%;
			height:100%;
			background:lightblue;
			border-radius:0.5em 0.5em 0 0;
			transition:background 0.5s;
		}

		.graph tr:hover td {
			opacity:0.7;
		}

		.graph td span {
			overflow:hidden;
			position:absolute;
			left:50%;
			top:50%;
			width:0;
			padding:0.5em 0;
			margin:-1em 0 0;
			font:normal 85%/120% arial,helvetica,sans-serif;
	/* 			background:white; */
	/* 			box-shadow:0 0 0.25em rgba(0,0,0,0.6); */
			font-weight:bold;
			opacity:1;
			transition:opacity 0.5s;
      color:black;
		}

		.toggleGraph:checked + table td span,
		.graph tr:hover td span {
			width:4em;
			margin-left:-2em; /* 1/2 the declared width */
			opacity:1;
		}
	} /* min-width:32em */

	} /* grid only */
</style>
<div class="container">
	<div class="row">
		<div class="col-md-5">
			<div class="title">
				<div class="project-bar">
					<div class="add-heading">Dashboard</div>
				</div>
			
			</div>
		</div>
		<div class="col-md-7">
		
		</div>
	</div>
	

	<table ><tr >
	   <td>
		<div class="filter-bar"> 
			
			<div  id="filter" >
				<div class="filteration">
					<!-- Dropdown list -->
					<span style="margin-left:5px;"><label for="project">Select Project:</label></span>

							<?php
								
								$options = '';
								$roles = '';
								// Query projects from the Projects table
								$projectQuery = "SELECT p.project_id, p.project_name, p.created_by
								FROM Projects p
								LEFT JOIN ProjectMembers pm ON p.project_id = pm.project_id
								WHERE (p.access = 1 AND (pm.user_id = '$loggedInUserId' AND pm.role = 'employee'))
								OR (p.access = 1 AND p.created_by = '$loggedInUserId')
								OR (p.access = 0 AND p.created_by = '$loggedInUserId')
								GROUP BY p.project_id, p.project_name";
								$projectResult = mysqli_query($conn, $projectQuery);
								// Check if any projects are available
								if (mysqli_num_rows($projectResult) > 0) {
							//    echo "<script type= 'text/javascript'> alert(".$selectedProjectId." )</script>";
								
							
								while ($row = mysqli_fetch_assoc($projectResult)) {
								
								if($row['project_id']==$selectedProjectId){
									$options = $options . '<option  value="' . $row['project_id'] . '" selected>' . $row['project_name'] . '</option>';
								
									$roles = $roles . '<option  value="' . $row['created_by'] . '" selected>' . $row['created_by'] . '</option>';
								
									}
									else{
									$options = $options . '<option value="' . $row['project_id'] . '">' . $row['project_name'] . '</option>';
									$roles = $roles . '<option value="' . $row['created_by'] . '">' . $row['created_by'] . '</option>';
								
									}
									}
									$options = $options . '<option  value="-1" >My Tasks</option>';
								
									$roles = $roles . '<option  value="-1" >My Tasks</option>';
								
								} else {
									$options = $options . '<option  value="-1" >My Tasks</option>';
									$roles = $roles . '<option  value="-1" >My Tasks</option>';
								}

								// Close the database connection
								mysqli_close($conn);
							?>

							<input type='text' style="display:none;" id="current_user_id" value='<?php echo $loggedInUserId;?>'/>
							<select style="margin:0px 20px; width:150px; height:100%; font-size:15px;padding:5px;" id="project" name="project">
								<?php echo $options;?>
							</select>
							<select  style="display:none;margin:0px 20px; width:200px; height:100%; font-size:15px;padding:5px;" id="roles" name="roles">
								<?php echo $roles;?>
							</select>
							<button style="background:lightgray; border:1px solid gray; padding:5px;"  onclick="showReport()">View Report</button>
					
				</div>
			</div>
		</div>
            <!-- Circular progress bar with dynamic progress percentage -->
            <div id="project-summary" >
			</div>
		
		</td><td>
			<div id="proj-percent" style="margin-left:60%; margin-top:-50px;">
			</div>
			<table class="graph">
				<caption style="margin-top:-100px;">Tasks Progress Details</caption>
				<thead>
					<tr>
						<th scope="col">Task</th>
						<th scope="col">Percent</th>
					</tr>
				</thead>
				<tbody id="tasksBody">
					<tr style="height:85%">
						<th scope="row">Your Blog</th>
						<td><span>85%</span></td>
					</tr>
					
					<tr style="height:20%">
						<th scope="row">Other</th>
						<td><span>20%</span></td>
					</tr>
				</tbody>
			</table>
		</td></tr>
	</table>
</div>

<script>
      // Function to set the first project as the default selection
      function setDefaultProject() {
        var projectDropdown = document.getElementById("project");
          // Set the first project as the default selection
          if (projectDropdown.options.length > 0) {
         //   projectDropdown.selectedIndex = 0;
          }
          showReport();
        }

      // Execute the function on page load
      setDefaultProject();

      function showReport() {
        var projectId = document.getElementById("project").value;
        document.getElementById("roles").selectedIndex= document.getElementById("project").selectedIndex;
        adminId=document.getElementById("roles").value;
        var currUserId = document.getElementById("current_user_id").value;
        // AJAX request to fetch tasks data
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("tasksBody").innerHTML = this.responseText;
          }
        };
        xhr.open("GET", "classes/FetchtasksDetails.php?project_id=" + projectId, true);
        xhr.send();

		// AJAX request to fetch project summary
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("project-summary").innerHTML = this.responseText;
          }
        };
        xhr.open("GET", "classes/getProjectSummary.php?project_id=" + projectId, true);
        xhr.send();

		// AJAX request to fetch project percentage
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("proj-percent").innerHTML = this.responseText;
          }
        };
        xhr.open("GET", "classes/projectPercentage.php?project_id=" + projectId, true);
        xhr.send();
      }
    </script>

<?php include "templates/footer.php"; ?>