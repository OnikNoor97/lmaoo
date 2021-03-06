<?php include_once(__DIR__ . "/../../includes/autoloader.inc.php");

$adminController = new AdminController();

$function = $_POST['function'];

if ($function == "deactivateUser")
{
    $adminController->deactivateUser($_POST["userId"]);
}
else if ($function == "activateUser")
{
    $adminController->activateUser($_POST["userId"]);
}
else if ($function == "getAdminActiveUsers")
{
	echo json_encode($adminController->getActiveUsers());
}
else if ($function == "getAdminInActiveUsers")
{
	echo json_encode($adminController->getInActiveUsers());
}
else if ($function == "resetPassword")
{
    echo json_encode($adminController->resetPassword($_POST['userId'], null));
}
else if ($function == "updateUserLevel")
{
    ($adminController->updateUserLevel($_POST["userId"], $_POST["chosenUserLevel"]));
}
else 
{
    Library::notFoundMessage();
}