<?php include_once "../../vendor/autoload.php";

use Lmaoo\Controller\AdminController;
use Lmaoo\Core\Middleware;

use Lmaoo\Controller\GithubController;
use Lmaoo\Controller\ManagerController;
use Lmaoo\Controller\ProjectController;
use Lmaoo\Controller\FeatureController;

if (session_status() == PHP_SESSION_NONE) session_start();

// Documentation: https://github.com/bramus/router
$router = new Bramus\Router\Router();
$json = file_get_contents("php://input");

// Secure all Endpoints using Middleware
$router->before("GET|POST", "/project.*", fn() => Middleware::verifyUser($router, 1));
$router->before("GET|POST", "/manager.*", fn() => Middleware::verifyUser($router, 2));
$router->before("GET|POST", "/admin.*", fn() => Middleware::verifyUser($router, 4));
$router->before("POST", "/project.*", fn() => Middleware::verifyJson($router, $json));
$router->before("POST", "/manager.*", fn() => Middleware::verifyJson($router, $json));
$router->before("POST", "/admin.*", fn() => Middleware::verifyJson($router, $json));
$router->before("POST", "/feature.*", fn() => Middleware::verifyJson($router, $json));

// Set 404 Page
$router->set404("Lmaoo\Core\Render::NotFound");

// Non-secure routes
$router->get("/", "Lmaoo\Core\Render::index" );
$router->get("/register", "Lmaoo\Core\Render::register" );
$router->get("/login", "Lmaoo\Core\Render::login" );
$router->post("/login", "Lmaoo\Controller\UserController::standardLogin" );
$router->get("/logout", "Lmaoo\Controller\UserController::logout" );

// All /project requests
$router->mount("/project", function() use ($router, $json)
{
    $router->get("/", "Lmaoo\Core\Render::project");
    $router->post("/", fn() => ProjectController::createProject($json));
    $router->put("/", fn() => ProjectController::updateProject());

    $router->get("/activate/(\d+)", fn($projectId) => ProjectController::activateProject($projectId));
    $router->get("/deactivate/(\d+)", fn($projectId) => ProjectController::deactivateProject($projectId));

});

// All /manager requests
$router->mount("/manager", function() use ($router, $json)
{
    $router->get("/", "Lmaoo\Core\Render::manager");

    $router->post("/", fn() => ManagerController::createUsersToProject($json));

    $router->delete("/project/(\d+)", fn($projectId) => ManagerController::deleteUsersFromProject($projectId));
});

// All /admin requests
$router->mount("/admin", function() use ($router, $json)
{
    $router->get("/", "Lmaoo\Core\Render::admin");
    
    $router->get("/user/active", fn() => AdminController::readUser("1"));
    $router->get("/user/inactive", fn() => AdminController::readUser("0"));

    $router->put("/user", fn() => AdminController::updateUser($json));
});

// All Github OAuth
$router->mount("/github", function() use ($router)
{
    // GET github/authorize/login OR GET github/authorize/register 
    $router->get("/authorize/(\w+)", fn($function) => (new GithubController)->authorise($function));
    $router->get("/callback", "Lmaoo\Controller\GithubController@callback");
});

// For Testing Purposes
// $router->post("/test", fn() => Lmaoo\Controller\ManagerController::addUsersToProject(file_get_contents("php://input")));

$router->run();
