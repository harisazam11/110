<body style="background:whitesmoke;">
  <div class="navbars">
    <div class="sidebar">
      <div class="navitem">
        <a href="project.php" class="active a a1" id="a1" onclick="a1(1)">
          <div class="nav">
            <span> <img src="images/file-text.svg" alt="" /> </span>
          </div>
          <div class="linkname">
            <span>Project</span>
          </div>
        </a>
      </div>
      <div class="navitem">
        <a href="mytasks.php" class="a a2" id="a2" onclick="a1(2)">
          <div class="nav">
            <span> <img src="images/tasks.png" alt="" /> </span>
          </div>
          <div class="linkname">
            <span>My Tasks</span>
          </div>
        </a>
      </div>
      <div class="navitem">
        <a href="time_tracker.php" class="a a3" id="a3" onclick="a1(3)">
          <div class="nav">
            <span> <img src="images/stopwatch.svg" alt="" /> </span>
          </div>
          <div class="linkname">
            <span>Time Tracker</span>
          </div>
        </a>
      </div>

      <div class="navitem">
        <a href="dashboard.php" class="a a4" id="a4" onclick="a1(4)">
          <div class="nav">
            <span> <img src="images/grid.svg" alt="" /> </span>
          </div>
          <div class="linkname">
            <span>Dashboard</span>
          </div>
        </a>
      </div>

      <div class="navitem">
        <a href="reports.php" class="a a5" id="a5" onclick="a1(5)">
          <div class="nav">
            <span> <img src="images/graph-up-arrow.svg" alt="" /> </span>
          </div>
          <div class="linkname">
            <span>Report</span>
          </div>
        </a>
      </div>

      <div class="navitem">
        <a href="teams.php" class="a a6" id="a6" onclick="a1(6)">
          <div class="nav">
            <span> <img src="images/people.svg" alt="" /> </span>
          </div>
          <div class="linkname">
            <span>Team</span>
          </div>
        </a>
      </div>

      <div class="navitem">
        <a href="settings.php" class="a a7" id="a7" onclick="a1(7)">
          <div class="nav">
            <span>
              <img src="images/gear.svg" alt="" />
            </span>
          </div>
          <div class="linkname">
            <span>Setting</span>
          </div>
        </a>
      </div>

      <div class="navitem" style="position: absolute; bottom: 0; width: 100%">
        <a href="index.php" class="a">
          <div class="nav">
            <span> <img src="images/box-arrow-left.svg" alt="" /> </span>
          </div>
          <div class="linkname">
            <span>Logout</span>
          </div>
        </a>
      </div>
    </div>

    <div class="topbar">
      <div class="top-left">
        <a href="" class="a">
          <div class="nav1">
            <span>
              <img src="images/list.svg" alt="" style="width: 30px; height: 30px" />
            </span>
          </div>
        </a>
      </div>
      <div class="top-right">
        <div class="t1">
          <a href="" id="sidebarToggle" class="a">
            <div class="nav1">
              <span>
                <img src="images/question-circle.svg" alt="" />
              </span>
            </div>
          </a>
        </div>

        <div class="t2">
          <a href="notifications.php" class="a">
            <div class="nav1">
              <span>
                <img src="images/bell.svg" alt="" />
              </span>
            </div>
          </a>
        </div>

        <div class="t3">
          <a href="" class="a">
            <div class="nav1">
                <span>
                  <?php
                  include('classes/config.php');
                  $sql = "select * from register where user_id = ".$_SESSION['user_id'];
                  $result = $conn->query($sql);
                  $picpath = $result->fetch_assoc()['picture'];
                  if($picpath!=null){
                    echo  '<img style="border-radius:100%;" src="'.$picpath.'" alt="" />';
                  }
                  else{
                      echo ' <img src="images/people.svg" alt="" />';
                  }
                  ?>
                 
                </span>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
  <!-- <script>
    a1(1);
    function a1(id){
      var activePage = window.location.pathname.split('/').pop();
      if(activePage=="project.php")
      {
        document.getElementById("a1").classes.append("active");
        document.getElementById("a2").classes.remove("active");
        document.getElementById("a3").classes.remove("active");
        document.getElementById("a4").classes.remove("active");
        document.getElementById("a5").classes.remove("active");
        document.getElementById("a6").classes.remove("active");
        
        document.getElementById("a7").classes.remove("active");
      }
      else if(activePage=="time_tracker.php"){

        document.getElementById("a2").classes.append("active");
        document.getElementById("a1").classes.remove("active");
        document.getElementById("a3").classes.remove("active");
        document.getElementById("a4").classes.remove("active");
        document.getElementById("a5").classes.remove("active");
        document.getElementById("a6").classes.remove("active");
        
        document.getElementById("a7").classes.remove("active");
      }
      // for(i=1;i<8;i++){
      //   if(i==id)
      //     document.getElementById("a"+id).classes.append("active");
      //   else
      //   document.getElementById("a"+i).classes.remove("active");
      // }
      // document.getElementById("a1").classes.append("active");
      // document.getElementById("a2").classes.remove("active");
      // document.getElementById("a3").classes.remove("active");
      // document.getElementById("a4").classes.remove("active");
      // document.getElementById("a5").classes.remove("active");
      // document.getElementById("a6").classes.remove("active");
      
      // document.getElementById("a7").classes.remove("active");
    }
    </script> -->
