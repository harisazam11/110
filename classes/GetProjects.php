<?php
session_start();
$loggedInUserId = $_SESSION['user_id'];
           include("config.php");
           $acc='3';
           $st='';
           $output='';
           if(!empty($_GET['status']))
            $st = $_GET['status'];
           if(!empty($_GET['access'])){
                $acc=$_GET['access'];
           }
            // Retrieve project names from the database table
            $sql = "SELECT p.project_id, p.project_name, p.status, p.access,p.deadline,p.team,pm.role
            FROM Projects p
            LEFT JOIN ProjectMembers pm ON p.project_id = pm.project_id
            WHERE (p.access = 1 AND (pm.user_id = '$loggedInUserId' AND pm.role = 'employee'))
            OR (p.access = 1 AND p.created_by = '$loggedInUserId')
            OR (p.access = 0 AND p.created_by = '$loggedInUserId')
            GROUP BY p.project_id, p.project_name";
            $secondQuery='';
            if ($acc == 3) {
                $secondQuery = "SELECT *
                                FROM ($sql) AS subquery
                                WHERE status LIKE '%$st%'";
            }
            else if ($acc == 2) {
                $secondQuery = "SELECT *
                                FROM ($sql) AS subquery
                                WHERE access = 0 and status LIKE '%$st%'";
            }
             else {
                $secondQuery = "SELECT *
                                FROM ($sql) AS subquery
                                WHERE access = $acc AND status LIKE '%$st%'";
            }
            $result = $conn->query($secondQuery);
         //   $output='';
            if ($result->num_rows > 0) {
              // Output a dropdown menu for each project name
              while ($row = $result->fetch_assoc()) {
                $output .= '<tr>';
                $output .= '<td>' . $row['project_name'] . '</td>';
                // Display the rest of the project information
                $output .= '<td>'. $row['team'] . '</td>';
                if($row['access']==0)
                {$output .= '<td>private</td>';}
                else{
                    $output .= '<td>public</td>';
                }
                $output .= '<td>' . $row['deadline'] . '</td>';
                $output .= '<td>' . $row['status'] . '</td>';
                $output .= '<td><a style="color:blue;" href="teams.php?pid='.$row["project_id"].'">View Team</a>';
                $output .= ' | <a style="color:blue;" href="tasks.php?pid='.$row["project_id"].'">View Tasks</a></td>';
                $output .= '</tr>';
              }
              
            echo $output;
            } 

            
            // Close the database connection
            $conn->close();
          ?>