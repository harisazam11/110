function checkForm() {
  const taskInput = document.getElementById("label");
  const dueTimeInput = document.getElementById("time-picker");
  const addButton = document.getElementById("add-button");

  if (taskInput.value.trim() !== "" && dueTimeInput.value.trim() !== "") {
    addButton.disabled = false;
    addButton.style.color = "#5ab8de"; // Change button text color
    addButton.style.border = "1px solid #5ab8de";
  } else {
    addButton.disabled = true;
  }
}

document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("form");
  const tableBody = document.getElementById("task-table-body");
  const stopwatchData = []; // Array to store stopwatch-related variables and percentage for each row

  form.addEventListener("submit", (e) => {
    e.preventDefault();

    const taskInput = document.getElementById("label");
    const dueTimeInput = document.getElementById("time-picker");

    const task = taskInput.value.trim();
    const dueTime = dueTimeInput.value.trim();

    // Create a new row in the table with the entered data
    const newRow = document.createElement("tr");
    const rowId = "row-" + Date.now(); // Unique ID for the row
    newRow.id = rowId;
    newRow.innerHTML = `
   
    <td>${task}</td>
    <td></td>
    <td>${dueTime}</td>
    <td id="percentage-${rowId}"></td>
    <td id="stopwatch-${rowId}">00:00:00</td>
    <td style="text-align: center">
      <button id="stopwatchButton-${rowId}" style="border: none; background: none;">
        <img src="/sources/images/play (Stroke).png" alt="" style="width: 12px; height: 12px; margin-left: 0" />
      </button>
    </td>
      <td style="text-align: center">
        <button id="more-btn-${rowId}" class="more-btn" style="border: none; background: none;">
          <img src="/sources/images/ellipsis.png" alt="" style="width: 3px; height: 12px; margin-left: 0px" />
        </button>
      </td>
    `;

    tableBody.appendChild(newRow);

    // Reset the form fields
    taskInput.value = "";
    dueTimeInput.value = "";

    // Disable the "Add" button again
    document.getElementById("add-button").disabled = true;
    document.getElementById("add-button").style = "";

    // Assuming you have a variable for the due time in seconds
    const dueTimeSeconds = parseInt(dueTime) * 3600;

    // Set the initial percentage to 0%
    document.getElementById(`percentage-${rowId}`).textContent = "0%";

    // Add stopwatch-related variables and percentage to the array for the new row
    stopwatchData.push({
      id: rowId,
      interval: null,
      running: false,
      time: 0,
      percentage: 0,
    });

    function updatePercentage(index) {
      const { time, percentage } = stopwatchData[index];
      const newPercentage = Math.floor((time / dueTimeSeconds) * 100);
      if (percentage !== newPercentage) {
        document.getElementById(
          `percentage-${rowId}`
        ).textContent = `${newPercentage}%`;
        stopwatchData[index].percentage = newPercentage;
      }
    }

    function updateStopwatch() {
      stopwatchData.forEach(({ id, time }) => {
        time++;
        var hours = Math.floor(time / 3600);
        var minutes = Math.floor((time % 3600) / 60);
        var seconds = Math.floor(time % 60);

        hours = hours.toString().padStart(2, "0");
        minutes = minutes.toString().padStart(2, "0");
        seconds = seconds.toString().padStart(2, "0");

        document.getElementById(
          `stopwatch-${id}`
        ).textContent = `${hours}:${minutes}:${seconds}`;
      });
    }

    function startStopwatch(index) {
      const { id, running, interval } = stopwatchData[index];
      if (!running) {
        stopwatchData[index].running = true;
        stopwatchData[index].interval = setInterval(() => {
          stopwatchData[index].time++;
          updateStopwatch();
          updatePercentage(index);
        }, 1000);
        document.getElementById(`stopwatchButton-${id}`).innerHTML = `
         <img src="/sources/images/Vector.png" alt="" style="width: 7px; height: 12px; margin-left: 0" />
       `;
      } else {
        stopwatchData[index].running = false;
        clearInterval(interval);
        document.getElementById(`stopwatchButton-${id}`).innerHTML = `
         <img src="/sources/images/play (Stroke).png" alt="" style="width: 12px; height: 12px; margin-left: 0" />
       `;
      }
    }

    document
      .getElementById(`stopwatchButton-${rowId}`)
      .addEventListener("click", () => {
        const index = stopwatchData.findIndex((data) => data.id === rowId);
        startStopwatch(index);
      });

    const dropdownMenu = document.getElementById(`dropdown-menu`);
    const moreBtn = document.getElementById(`more-btn-${rowId}`);

    // Hide the dropdown menu by default
    dropdownMenu.style.display = "none";
    // Add an event listener to show the dropdown menu on button click
    moreBtn.addEventListener("click", function () {
      // Toggle the display of the dropdown menu
      dropdownMenu.style.display =
        dropdownMenu.style.display === "none" ? "block" : "none";
    });

    // Add event listeners to menu items
    // Inside the event listener for menu items
    dropdownMenu.querySelectorAll("a").forEach(function (item) {
      item.addEventListener("click", function (event) {
        event.preventDefault();
        const row = item.closest("tr");
        if (row) {
          const action = item.classList[0];
          const rowId = row.id;
          performAction(action, rowId);
        }
        dropdownMenu.style.display = "none";
      });
    });

    // Perform the selected action
    function performAction(action, rowId) {
      switch (action) {
        case "delete":
          deleteFunction(rowId);
          break;
        case "edit":
          // Call the edit function
          editFunction();
          break;
        case "view-team":
          // Call the view team function
          viewTeamFunction();
          break;
        default:
          console.log("Invalid action");
      }
    }

    function deleteFunction(rowId) {
      const row = document.getElementById(rowId);
      if (row) {
        row.remove();
      }
    }

    function editFunction(index) {
      // Implement the edit function here
      console.log(`Edit function called for row ${index}`);
    }

    function viewTeamFunction(index) {
      // Implement the view team function here
      console.log(`View team function called for row ${index}`);
    }
  });
});
