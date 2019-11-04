<?php require("../User/user.php");
session_start(); 
?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="../Css/UserPage.css">
<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<title>Login</title>
<head></head>
<?php include("../Global/navBar.php"); ?>
<body>
<div class="top-buffer">
	<div class="container">
		<form action="userController.php" method='POST'>
			Username:<br>
		<input type="text" name="username">
		<br>
			Password:<br>
		<input type="password" name="passowrd">
		<input type="hidden" name="function" value="login">
		<input class="one" type="submit" value="Submit"> <br><br>
		<a href="../User/register.php">Not Registered? Click here!</a>
		</form>
	</div>
</div>
<div ID="return">
    <p><b><?php if(isset($_SESSION['message'])){echo$_SESSION['message'];session_unset();}?></b></p>
</div>
</body>
</html>