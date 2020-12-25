<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
<link rel="stylesheet" href="../Css/notifications.css">

<script>
<?php 
if(isset($_SESSION['userLoggedIn'])) 
{
  $userLoggedIn = $_SESSION['userLoggedIn'];
  include_once("../User/user.php");
  
  echo "const userId = '" . $userLoggedIn->getId() . "'\n";
  echo "const userForename = '" . $userLoggedIn->getForename(). "'\n";
  echo "const userSurname = '" . $userLoggedIn->getSurname(). "'\n";
  echo "const userUsername = '" . $userLoggedIn->getUsername(). "'\n";
  echo "const userLevel = '" . $userLoggedIn->getLevel(). "'\n";

  if ($userLoggedIn->getLevel() > 1)
  {
    include_once("../User/userController.php");
    echo "const users = " . json_encode($userController->getActiveUsers()) . "\n";
  }
} 
?>

</script>