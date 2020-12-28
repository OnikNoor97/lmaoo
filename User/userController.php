<?php  require_once(__DIR__ . "/../connection.php"); require_once(__DIR__ . "/user.php");
$userController = new userController();

if ($function == "login")
{
	$userController->login($_POST['username'], $_POST['password']);
}
else if ($function == "register")
{
	if ($userController->hasDup(null))
	{
		session_start();
    	$_SESSION['message'] = 'Username already exist! Try logging in!';
		header("Location: index.php");
	}
	else
	{
		$userController->register($_POST['forename'], $_POST['surname'], $_POST['username'], $_POST['password']);
	}
}
else if ($function == 'update')
{
	validateSuperUser();
	$userController->updateUser($_POST['editForename'], $_POST['editSurname'], $_POST['editUsername'], $_POST['editUserId']);
}
else if ($function == "checkUsername")
{
	validateManager();
	if ($userController->hasDup(null))
	{
		$json->fromServer = "True";
		echo json_encode($json);
	}
	else if (!$userController->hasDup(null))
	{
		$json->fromServer = "False";
		echo json_encode($json);
	}
}
else if ($function == "getActiveUsers") 
{
	validateDeveloper();
	echo json_encode($userController->getActiveUsers());
}
else if ($function == "darkModeToggle")
{
	validateDeveloper();
	$userController->darkModeToggle($_POST['darkMode'], $_POST['userId']);
}
else if ($function == "uploadProfilePic")
{
	validateDeveloper();
	echo $userController->uploadImage($_POST['userId'], null);
}
else
{
	return;
}

class userController 
{
	public function hasDup(?string $unitTest)
	{
		$username = $unitTest == null ? $_POST['username'] : $unitTest;
		$pdo = logindb('user', 'pass');
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
		$stmt = $pdo->prepare("SELECT username FROM user WHERE username = ?");
		$stmt->execute([$username]);

		return $stmt->rowCount() > 0 ? true : false;
	}

	public function updateUser($forename, $surname, $username, $userId)
	{
		$pdo = logindb('user', 'pass');
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
		$stmt = $pdo->prepare("UPDATE user SET forename = ?, surname = ?, username = ? WHERE userId = ?");
		$stmt->execute([$forename, $surname, $username, $userId]);

		session_start();
		$userLoggedIn = $_SESSION["userLoggedIn"];
		$userLoggedIn->setForename($forename);
		$userLoggedIn->setSurname($surname);
		$userLoggedIn->setUsername($username);
		$_SESSION['message'] = 'Your User Details has been updated';
		header("Location: ../Home/index.php");
	}

	public function userInfoById($userId) // Should be used for Unit Testing and Admin Only!
	{
		$pdo = logindb('user', 'pass');
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
		$stmt = $pdo->prepare("SELECT * FROM user WHERE userId = ?");
		$stmt->execute([$userId]);
		$user = $stmt->fetch();
		return $user;
	}

	public function login($username, $password)
	{
		$pdo = logindb('user', 'pass');
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
		$stmt = $pdo->prepare("SELECT * FROM user WHERE username = ?");
		$stmt->execute([$username]);
		$user = $stmt->fetch();
		$userController = new userController();

		if (password_verify($password, $user->password))
		{
			if($user->isActive == true)
			{
				$userLoggedIn = new user($user->userId, $user->forename, $user->surname, $user->username, $user->password, $user->level, $user->isActive, $user->darkMode);
				if ($user->darkMode != $_COOKIE["lmaooDarkMode"]) setcookie("lmaooDarkMode", $user->darkMode, 0, "/");
				session_start();
				$_SESSION['userLoggedIn'] = $userLoggedIn;
				header("Location: ../Home/index.php");
			}
			else
			{
				session_start();
				$_SESSION['message'] = 'User deactivated, contact the administrator';
				header("Location: index.php");
			}
		}
		else
		{
			$userController->failedLogin();
		}

	}

	public function register($forename, $surname, $username, $password)
	{		
		$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

		$pdo = logindb('user', 'pass');
		$stmt = $pdo->prepare("INSERT INTO user (userId, username, password, forename, surname) VALUES (null, ?, ?, ?, ?)");
		$stmt->execute([$username, $hashedPassword, $forename, $surname]);
		session_start();
		$_SESSION['message'] = 'Register Successful';
		header("Location: index.php");
	}

	public function failedLogin() // May change to return false in the future to allow dynamic login page
	{
		session_start();
		$_SESSION['message'] = 'Login attempted failed';
		header("Location: index.php");
	}

	public function getAllUsers() // This is used in Admin -> May be moved, not unit testing
	{
		$pdo = logindb('user', 'pass');
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
		$stmt = $pdo->prepare("SELECT * FROM user");
		$stmt->execute();
		$users = $stmt->fetchAll();
		return $users;
	}

	public function getActiveUsers()
	{
		$pdo = logindb('user', 'pass');
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
		$stmt = $pdo->prepare("SELECT userId, forename, surname, username, picture FROM user WHERE isActive = 1");
		$stmt->execute();
		$activeUsers = $stmt->fetchall();
		return $activeUsers;
	}

	public function darkModeToggle($toggle, $userId)
	{
		$pdo = logindb('user', 'pass');
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
		$stmt = $pdo->prepare("UPDATE user SET darkMode = ? WHERE userId = ?");
		$stmt->execute([$toggle, $userId]);
	}

	public function loadDarkMode($userId) // Keeping for Unit Testing
	{
		$pdo = logindb('user', 'pass');
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
		$stmt = $pdo->prepare("SELECT darkMode FROM user WHERE userId = ?");
		$stmt->execute([$userId]);
		return $stmt->fetchColumn();
	}

	public function updatePicture($target, $userId)
	{
		$pdo = logindb('user', 'pass');
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
		$stmt = $pdo->prepare("UPDATE user SET picture = ? WHERE userId = ?");
		$stmt->execute([$target, $userId]);
	}

	public function uploadImage($userId, ?string $unitTest)
	{
		$userController = new userController();
		$target_dir = $unitTest == null ? "../Images/profilePictures/" : __DIR__ . "../Images/profilePictures/";
		$target_file = $target_dir . basename($_FILES["image"]["name"]);
		$ext = pathinfo($target_file, PATHINFO_EXTENSION);
		$rename = $target_dir . $userId . "." . $ext;
		
		if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) 
		{
			rename($target_file, $rename);
			$userController->updatePicture($rename, $userId);
			echo true;
		}
		else echo false;
	}

	public function loadDarkModeToggle($toggle, $userLoggedIn)
	{ 
		if ($toggle == null) 
		{
			if ($userLoggedIn == null) 
			{
				$toggle = false;
				setcookie("lmaooDarkMode", false, 0, "/");
			}
			else if ($userLoggedIn != null)
			{
				$toggle = $userLoggedIn->getDarkMode();
				setcookie("lmaooDarkMode", $userLoggedIn->getDarkMode(), 0, "/");
			}
		}

		echo "<div class='custom-control custom-switch'>";
		echo $toggle == true ? "<input type='checkbox' class='custom-control-input' id='darkModeSwitch' onclick='darkModeToggle()' checked>" : "<input type='checkbox' class='custom-control-input' id='darkModeSwitch' onclick='darkModeToggle()'>";
		echo "<label class='custom-control-label' for='darkModeSwitch'>Dark Mode</label>";
		echo "</div>";
	}

	public function loadDropdownItems($userLoggedIn)
	{
		if($userLoggedIn == null)
		{
			echo "<a class='dropdown-item' id='registerNav' href='../User/register.php'>Register</a>";
			echo "<a class='dropdown-item' id='loginNav' href='../User/index.php'>Login</a>";
		}
		else
		{
			if ($userLoggedIn->getLevel() > 1) echo "<a class='dropdown-item' id='managerNav' href='../Manager/index.php'>Manager</a>"; 
			echo "<a class='dropdown-item' id='editAccountNav' data-toggle='modal' data-target='#view-modal' role='button'>Edit Account</a>";
			echo "<a class='dropdown-item' id='logoutNav' href='../User/logout.php'>Logout</a>";
			if($userLoggedIn->getLevel() > 3) echo "<a class='dropdown-item' id='adminNav' href='../User/admin.php'>Admin</a>";
		}
	}
}
?>