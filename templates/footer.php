<div id="notificationsOverlay" class="overlay">
  <div class="overlay-content">
    <span class="close" onclick="closeNotificationsOverlay()">&times;</span>
    <iframe src="notifications.php" frameborder="0" scrolling="auto"></iframe>
  </div>
</div>


<script>
    // Get all radio buttons by name
    const radioButtons = document.querySelectorAll('input[name="access"]');

    // Add event listener to each radio button
    radioButtons.forEach(function (radioButton) {
      radioButton.addEventListener("change", function () {
        // Reset color for all radio buttons
        radioButtons.forEach(function (rb) {
          rb.nextElementSibling.style.color = "";
        });

        // Change color of selected radio button value
        if (this.checked) {
          this.nextElementSibling.style.color = "black";
        }
      });
    });
  </script>
  <script src="./js/project.js"></script>
  <script>
  <script>
  document.addEventListener("DOMContentLoaded", function() {
    var activeItem = sessionStorage.getItem('activeItem');
    if (activeItem) {
      var item = document.getElementById(activeItem);
      item.classList.add('active');
    }
  });
</script>

</body>

</html>