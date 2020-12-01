<?php require(__DIR__ . 'userController.php'); 
$adminController = new adminController();
$userController = new userController();

$userId = $_GET['userId'];
$function = $_POST['function'];

if(isset($userId))
{
    $userSelected = $userController->userInfoById($userId);
    echo json_encode($userSelected);
}

if($function == "adminUpdate")
{
    $adminController->adminUpdate($_POST['editForename'], $_POST['editSurname'], $_POST['editUsername'], $_POST['userSelect'], $_POST['userId']);
}
else if ($function == "deactivateUser")
{
    $adminController->deactivateUser($_POST["userId"]);
}

class adminController
{
    public function adminUpdate($forename, $surname, $username, $level, $userId)
    {
        $pdo = logindb('user', 'pass');
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $stmt = $pdo->prepare("UPDATE user SET forename = ?, surname = ?, username = ?, level = ? WHERE userId = ?");
        $stmt->execute([$forename, $surname, $username, $level, $userId]);
        header("Location: admin.php");
    }

    public function deactivateUser($userId)
    {
        $pdo = logindb('user', 'pass');
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $stmt = $pdo->prepare("UPDATE user SET isActive = 0 WHERE userId = ?");
        $stmt->execute([$userId]);
        header("Location: admin.php");
    }
}

?>