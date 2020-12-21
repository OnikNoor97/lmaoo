<?php require(__DIR__ . '/userController.php'); 

$adminController = new adminController();

$function = $_POST['function'];

if($function == "adminUpdate")
{
    $adminController->adminUpdate($_POST['editForename'], $_POST['editSurname'], $_POST['editUsername'], $_POST['userSelect'], $_POST['userId']);
}
else if ($function == "deactivateUser")
{
    $adminController->deactivateUser($_POST["userId"]);
}
else if ($function == "getAdminActiveUsers")
{
	echo json_encode($adminController->getActiveUsers());
}
else if ($function == "getAdminInActiveUsers")
{
	echo json_encode($adminController->getInActiveUsers());
}

class adminController
{
    public function adminUpdate($forename, $surname, $username, $level, $userId)
    {
        $pdo = logindb('user', 'pass');
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $stmt = $pdo->prepare("UPDATE user SET forename = ?, surname = ?, username = ?, level = ? WHERE userId = ?");
        $stmt->execute([$forename, $surname, $username, $level, $userId]);
    }

    public function deactivateUser($userId)
    {
        $pdo = logindb('user', 'pass');
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $stmt = $pdo->prepare("UPDATE user SET isActive = 0 WHERE userId = ?");
        $stmt->execute([$userId]);
    }

    public function getActiveUsers()
	{
		$pdo = logindb('user', 'pass');
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
		$stmt = $pdo->prepare("SELECT userId, forename, surname, username, level FROM user WHERE isActive = 1");
		$stmt->execute();
		$activeUsers = $stmt->fetchall();
		return $activeUsers;
    }
    
    public function getInActiveUsers()
	{
		$pdo = logindb('user', 'pass');
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
		$stmt = $pdo->prepare("SELECT userId, forename, surname, username, level FROM user WHERE isActive = 0");
		$stmt->execute();
		$activeUsers = $stmt->fetchall();
		return $activeUsers;
	}
}
?>