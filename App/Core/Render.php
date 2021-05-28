<?php
namespace Lmaoo\Core;

use Lmaoo\Controller\ProjectController;
use Lmaoo\Controller\FeatureController;

class Render
{
    public static function layout(string $view, string $js)
    {
        ob_start(); include_once __DIR__ . "/../View/$view.php"; $content = ob_get_clean();
        ob_start(); include_once __DIR__ . "/../View/navbar.php"; $navbar = ob_get_clean();
        ob_start(); echo "<script type='module' src='/Script/public/$js.js'></script>"; $script = ob_get_clean();
        include_once __DIR__ . "/../View/_layout.php";
    }
    
    public static function index()
    {
        $userLoggedIn = $_SESSION["userLoggedIn"] ?? null;
        $userLoggedIn == null ? self::layout("aboutUs", "home") : self::layout("dashboard", "home");
    }

    public static function login() { self::layout("login", "login"); }
    public static function register() { self::layout("register", "register"); }
    public static function manager() { self::layout("manager", "manager"); }
    public static function project() { self::layout("project", "project"); }
    public static function admin() { self::layout("admin", "admin"); }

    public static function DropdownItems($userLoggedIn)
    {
        $userLoggedIn = $userLoggedIn;
        if($userLoggedIn == null)
        {
            echo "<a class='dropdown-item' id='registerNav' href='/register'>Register</a>";
            echo "<a class='dropdown-item' id='loginNav' href='/login'>Login</a>";
        }
        else
        {
            if ($userLoggedIn->level > 1) echo "<a class='dropdown-item' id='managerNav' href='/manager'>Manager</a>"; 
            echo "<a class='dropdown-item' id='editAccountNav' data-toggle='modal' data-target='#view-modal' role='button'>Edit Account</a>";
            echo "<a class='dropdown-item' id='logoutNav' href='/logout'>Logout</a>";
            if($userLoggedIn->level > 3) echo "<a class='dropdown-item' id='adminNav' href='/admin'>Admin</a>";
        }
    }

    public static function ProjectsInNavBar($userLoggedIn)
    {
        if ($userLoggedIn == null) return; 
        $projectController = new projectController();
        $projects = $projectController->getAccessibleProjectList($userLoggedIn);

        echo "<li class='nav-item dropdown'>";
        echo "<a id='projectNav' href='#' class='nav-link dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>Project<span class='caret'></span></a>";
        echo "<div class='dropdown-menu'>";
        
        foreach ($projects as $project) 
        { 
            echo "<a class='dropdown-item' href='/project?projectId=$project->projectId'>$project->name</a>";
        } 
        
        echo "</div>";
        echo "</li>";
    }

    public static function SearchBar($userLoggedIn) 
    {
        if ($userLoggedIn == null) return;

        echo "<div class='navbar-brand form-inline lg-1'>";
        echo "<input id='searchBarInput' class='form-control mr-sm-2' type='search' placeholder='Search Ticket' aria-label='Search'>";
        echo "<button id='searchBarBtn' class='btn btn-outline-success my-sm-0' onclick='searchBar()'>Search</button>";
        echo "</div>";
    }

    public static function Features($active)
    {
        $features = FeatureController::readFeatures($_GET["projectId"], $active);

        foreach($features as $feature)
        {
            echo "<li value='$feature->featureId'>$feature->name<l class='far fa-edit'></l></li>";
        }
    }
}