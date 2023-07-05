
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
    Don't have an account? <a href="signup.php"> Sign up</a>
  </div>

  <div class="sign">
    <h3>Log in</h3>
    <hr />
    <form action="classes/login.php" method="POST" class="signup-form">
      <div class="filteration">
        <input type="text" name="email" placeholder="Email" class="input" required />
      </div>
      <div class="filteration">
        <input type="password" name="password" placeholder="Password" class="input" required />
      </div>
      <div class="pass"><a href="reset.html">Forget Password?</a></div>
      <div>
        <input type="submit" value="LOG IN" class="create" />
      </div>
    </form>
  </div>
</body>

</html>