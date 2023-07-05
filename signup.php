<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Efficiency Monitoring System</title>
  <link href="https://fonts.googleapis.com/css?family=Inter&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/style.css" />
</head>

<body>
  <div class="login_link">
    Already have an account? <a href="index.php">Log in</a>
  </div>

  <div class="sign">
    <h3>Sign up</h3>
    <hr />
    <form action="classes/signup.php" method="POST" class="signup-form">
      <div class="filteration">
        <input type="text" name="firstname" placeholder="First Name" class="input" required />
        <input type="text" name="lastname" class="input" placeholder="Last Name" required />
      </div>
      <div class="filteration">
        <input type="text" name="username" placeholder="Username" class="input" required />
      </div>

      <div class="filteration">
        <input type="email" name="email" placeholder="Email" class="input" required />
      </div>

      <div class="filteration">
        <input type="password" name="password" placeholder="Password" class="input" required />
        <input type="password" name="confirm_p" placeholder="Confirm Password" class="input" required />
      </div>

      <div>
        <input type="submit" value="SIGN UP" class="create" />
      </div>
    </form>
  </div>
</body>

</html>