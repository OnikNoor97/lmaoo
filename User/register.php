<?php session_start(); if (isset($_SESSION['userLoggedIn'])) { header("Location: ../Ticket/index.php"); } ?>

<!DOCTYPE html>
<html>
<title>Register Page</title>

<head>
  <p id="navBarActive" hidden>registerPage</p>
  <link rel="stylesheet" href="../Css/LoginRegister.css">
  <?php include("../Global/head.php"); ?>
</head>

<body>
  <?php include("../Global/navBar.php"); ?>

  <div class="top-buffer">
    <div class="container">
      <div class="wrap">
        <p class="alert alert-warning mt-3" id="validateMessage" hidden></p>
        <form action="userController.php" onSubmit="return checkPassword(this)" method='POST'>

          <input type="text" name="forename" id="forenameRegister" required placeholder="First Name">
          <input type="text" name="surname" id="surnameRegister" required placeholder="Last Name">
          <input type="text" name="username" id="usernameRegister" required placeholder="Username">
          <input type="password" name="password1" id="password1Register" required placeholder="Password">
          <input type="password" name="password2" id="password2Register" required placeholder="Re-Type Password">
          <input type="hidden" name="function" value="register">
          <input class="one" type="submit" value="Submit">
          <a href="../User/index.php">Already Registered? Login here!</a>

        </form>
      </div>
    </div>
  </div>
  <?php include("../Global/scripts.php"); ?>
  <script src="../Script/User/passwordchecker.js"></script>
</body>

</html>