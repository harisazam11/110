//
//
//
// PROJECT MODULE MAIN WINDOW
//
//
// Get the button and overlay elements
const addProjectButton = document.getElementById("add-project-button");
const overlay = document.getElementById("overlay");

// Function to show the overlay
function showOverlay() {
  overlay.style.display = "block";
}

// Function to hide the overlay
function hideOverlay() {
  overlay.style.display = "none";
}

// Add click event listener to the button
addProjectButton.addEventListener("click", showOverlay);

// Add click event listener to the overlay
overlay.addEventListener("click", function (event) {
  // Check if the click target is the overlay itself or its child elements
  if (event.target === overlay) {
    hideOverlay();
  }
});

//
//
//
// PROJECT MODULE SUB WINDOW - TASKS
//
//

function check() {
  const proTaskName = document.getElementById("t-name");
  const proTaskAssign = document.getElementById("t-assign");
  const proTaskDeadline = document.getElementById("t-deadline");
  const addButton2 = document.getElementById("t-add");

  if (
    proTaskName.value.trim() !== "" &&
    proTaskAssign.value.trim() !== "" &&
    proTaskDeadline.value.trim() !== ""
  ) {
    addButton2.disabled = false;
    addButton2.style.color = "#5ab8de";
    addButton2.style.border = "1px solid #5ab8de";
  } else {
    addButton2.disabled = true;
    addButton2.style.color = "";
    addButton2.style.border = "";
  }
}

// Get the button and attach a click event listener
const addButton = document.getElementById("t-add");
addButton.addEventListener("click", handleAddTask);

// Function to handle the task addition
function handleAddTask(event) {
  event.preventDefault(); // Prevent form submission

  // Get the input values and create an object
  const taskNameInput = document.getElementById("t-name");
  const taskAssignInput = document.getElementById("t-assign");
  const taskDeadlineInput = document.getElementById("t-deadline");

  const task = {
    name: taskNameInput.value,
    assignedTo: taskAssignInput.value,
    deadline: taskDeadlineInput.value,
  };

  // Create a new table row
  const tableBody1 = document.getElementById("pt-table-body1");
  const tableBody2 = document.getElementById("p-table-body");
  const newRow1 = document.createElement("tr");
  const newRow2 = document.createElement("tr");

  // Create the name cell
  const nameCell1 = document.createElement("td");
  nameCell1.textContent = task.name;

  // Create the name cell for the second table
  const nameCell2 = document.createElement("td");
  nameCell2.textContent = task.name;

  // Append the name cell to the new rows in both tables
  newRow1.appendChild(nameCell1);
  newRow2.appendChild(nameCell2);

  // Check if the assignedTo value is not empty
  if (task.assignedTo.trim() !== "") {
    // Create the assigned to cell
    const assignCell = document.createElement("td");
    assignCell.textContent = task.assignedTo;

    // Append the assigned to cell to the new row in the second table
    newRow2.appendChild(assignCell);
  }

  // Append the new rows to the table bodies
  tableBody1.appendChild(newRow1);
  tableBody2.appendChild(newRow2);

  // Clear the input fields
  taskNameInput.value = "";
  taskAssignInput.value = "";
  taskDeadlineInput.value = "";
}

//
//
//
// PROJECT MODULE SUB WINDOW - ACCESS
//
//

const tabs = document.querySelectorAll(".tabs");

// Get all the content divs
const contentDivs = document.querySelectorAll(".page > div");

// Add click event listener to each tab
tabs.forEach((tab) => {
  tab.addEventListener("click", function (event) {
    event.preventDefault(); // Prevent default link behavior

    // Hide all the content divs
    contentDivs.forEach((div) => {
      div.style.display = "none";
    });

    // Remove active class from all tabs
    tabs.forEach((tab) => {
      tab.classList.remove("cl-active");
    });

    // Add active class to the clicked tab
    this.classList.add("cl-active");

    // Show the corresponding content div
    const targetId = this.getAttribute("href");
    const targetDiv = document.querySelector(targetId);
    targetDiv.style.display = "block";
  });
});

//
//
//
// PROJECT MODULE SUB WINDOW - TEAM MEMBERS
//
//

// Get the link and overlay elements
const memberLink = document.getElementById("memberLink");
const memberOverlay = document.getElementById("memberOverlay");

// Add click event listener to the link
memberLink.addEventListener("click", showMemberOverlay);

// Function to show the member overlay
function showMemberOverlay(event) {
  event.preventDefault(); // Prevent the default link behavior

  // Check if there are members in the database
  const members = getMembersFromDatabase(); // Replace with your actual code to retrieve members from the database
  const memberOverlayContent = document.getElementById("memberOverlayContent");

  if (members.length > 0) {
    // Clear the overlay content
    memberOverlayContent.innerHTML = "";

    // Create and append member list
    const memberList = document.createElement("ul");
    memberList.classList.add("member-list");

    members.forEach((member) => {
      const listItem = document.createElement("li");
      listItem.classList.add("member");
      listItem.textContent = member.name; // Assuming each member object has a "name" property
      memberList.appendChild(listItem);
    });

    memberOverlayContent.appendChild(memberList);
  } else {
    // Display "No members added" message
    memberOverlayContent.textContent = "No members added. Add member";
  }

  // Show the overlay
  memberOverlay.style.display = "flex";
}

async function getMembersFromDatabase() {
  // Replace the URL with the endpoint to fetch members from your API or database
  const url = "https://example.com/api/members";

  // Make a fetch request to retrieve members from the database
  try {
    const response = await fetch(url);
    const data = await response.json();
    return data;
  } catch (error) {
    console.log("Error fetching members:", error);
    return [];
  }
}
