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
</body>

</html>