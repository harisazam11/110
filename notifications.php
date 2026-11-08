<style>
  <style>
.overlay {
  display: block;
  position: fixed;
  width: 100px;
  height: 250px;
  overflow: auto;
}

.overlay-content {
  background-color: #fefefe;
  margin: 10% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}
</style>

</style>

<div class="container">
  <div class="title">
    <div class="project-bar">
      <div class="add-heading">Notifications</div>
    </div>
  </div>
  <div class="project-list">
    <div class="pro-list">
      <table>
        <thead>
          <tr>
            <td>Notification</td>
            <td>Date</td>
            <td>View</td>
          </tr>
        </thead>
        <tbody class="mybody">
          <script>
            function fetchNotifications() {
              // Make an AJAX request to fetch notifications from fetch_notifications.php
              // and update the content of the <tbody> element.
              var xhttp = new XMLHttpRequest();
              xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                  document.querySelector(".mybody").innerHTML = this.responseText;
                }
              };
              xhttp.open("GET", "fetch_notifications.php", true);
              xhttp.send();
            }

            // Fetch notifications when the page loads
            fetchNotifications();
          </script>
        </tbody>
      </table>
    </div>
  </div>
</div>
