<?php include_once(__DIR__ . "/../../includes/autoloader.inc.php"); session_start();

$config = require("../../config.php");
$str = Library::generateString(10); // To prevent CSRF attacks
$_SESSION['state'] = $str;
header("Location: https://github.com/login/oauth/authorize?client_id={$config['github_clientId']}&scope=user%20repo%20admin%3Apublic_key%20admin%3Arepo_hook%20admin%3Aorg_hook%20gist%20notifications%20&state={$_SESSION['state']}&redirect_uri={$config['github_request_uri']}?function={$_GET['function']}");
?>