
let index;
let time_required, time_spent;
let startBtn;
let stopBtn;
let hour = 00;
let minute = 00;
let second = 00;
let count = 00;
let totaltimeinseconds=0;
let timer=false;
const overlay = document.getElementById("overlay");
// Function to hide the overlay
function hideOverlay() {
  overlay.style.display = "none";
}

// Add click event listener to the overlay
overlay.addEventListener("click", function (event) {
  // Check if the click target is the overlay itself or its child elements
  if (event.target === overlay) {
    hideOverlay();
  }
});

function startStopWatch(indx, timerequired, timespent,btn){
  time_required=timerequired;
  index=indx;
  time_spent = document.getElementById('timer-'+index).innerHTML;
  taskid = document.getElementById('task-id-'+index).innerHTML;
  [hour, minute, second] = time_spent.toString().split(":").map(Number);
  //alert(hour+":"+minute+":"+second);
  startBtn = document.getElementById('startbtn-'+index);
  stopBtn = document.getElementById('stopbtn-'+index);
  if(btn==1){
    
    timer = true;
    startBtn.style.display = 'none';
    stopBtn.style.display = 'block';
    stopWatch();
   
  }
  else{
   
    startBtn.style.display = 'block';
    stopBtn.style.display = 'none';
    timer = false;
    var timeSpentInSeconds = convertTimeToSeconds(time_spent);
    var percentage = (timeSpentInSeconds / time_required) * 100;
    // Round the percentage to two decimal places
    percentage = Math.round(percentage * 100) / 100;
    //alert(percentage);
    document.getElementById('percentage-'+index).innerHTML = percentage;

    //Here I need to call php function to update the values of timespent in database
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var response = this.responseText;
        // Handle the response from the PHP function
        console.log('Task status updated:', response);
      }
    };
    xhttp.open('POST', 'classes/updatetime.php', true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    var params = 'taskID=' + taskid + '&timespent=' + time_spent + '&timeRequired=' + time_required;
    xhttp.send(params);
  }
}

function convertTimeToSeconds(time) {
  var timeArr = time.split(':');
  var hours = parseInt(timeArr[0]);
  var minutes = parseInt(timeArr[1]);
  var seconds = parseInt(timeArr[2]);
  var totalTimeInSeconds = (hours * 3600) + (minutes * 60) + seconds;
  return totalTimeInSeconds;
}

function stopWatch() {
  if (timer && convertTimeToSeconds(time_spent)<time_required) {
    count++;

    if (count == 100) {
      second++;
      count = 0;
    }

    if (second == 60) {
      minute++;
      second = 0;
    }

    if (minute == 60) {
      hour++;
      minute = 0;
      second = 0;
    }

    let hrString = hour;
    let minString = minute;
    let secString = second;
    let countString = count;

    if (hour < 10) {
      hrString = "0" + hrString;
    }

    if (minute < 10) {
      minString = "0" + minString;
    }

    if (second < 10) {
      secString = "0" + secString;
    }

    if (count < 10) {
      countString = "0" + countString;
    }

    document.getElementById('timer-'+index).innerHTML = hrString+':'+minString+':'+secString;
    time_spent= hrString+':'+minString+':'+secString;
    setTimeout(stopWatch, 10);
  }
  else{
    startBtn.style.display = 'block';
    stopBtn.style.display = 'none';
    timer = false;
    var timeSpentInSeconds = convertTimeToSeconds(time_spent);
    var percentage = (timeSpentInSeconds / time_required) * 100;
    // Round the percentage to two decimal places
    percentage = Math.round(percentage * 100) / 100;
    //alert(percentage);
    document.getElementById('percentage-'+index).innerHTML = percentage;

    //Here I need to call php function to update the values of timespent in database
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var response = this.responseText;
        // Handle the response from the PHP function
        console.log('Task status updated:', response);
      }
    };
    xhttp.open('POST', 'classes/updatetime.php', true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    var params = 'taskID=' + taskid + '&timespent=' + time_spent + '&timeRequired=' + time_required;
    xhttp.send(params);
  }
}

function EditClicked(tid,tname,time_req){
 // alert("I am here");
  overlay.style.display = "block";
//alert("h2");
document.getElementById("utid").value=tid;
document.getElementById("ulabel").value=tname;
document.getElementById("utime").value=time_req/3600;

}
