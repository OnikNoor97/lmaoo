<?php require_once(__DIR__ . "/../connection.php"); require_once(__DIR__ . "/../User/user.php");

$projectController = new projectController();

if ($_POST['projectId'] && $_POST['progress'])
{
    validateDeveloper();
    echo json_encode($projectController->getTicketListWithProgress($_POST['projectId'], $_POST['progress']));
}
else if($_POST['function'] == "loadProjects")
{
    validateDeveloper();
    echo json_encode($projectController->getProjectList());
}
else if($_POST['function'] == "createProject")
{
    validateManager();
    $projectController->createNewProject($_POST['projectName'], $_POST['projectStatus']);
}
else if($_POST['function'] == "createTicket")
{
    validateDeveloper();
    $projectController->createNewTicket($_POST['projectId'], $_POST['summary'], $_POST['reporterKey']);
}
else if ($_POST['function'] == "checkProjectExistance")
{
    validateDeveloper();
    echo $projectController->projectExistance(null);
}
else
{
    ob_clean();
    return;
}

class projectController
{

    public function projectExistance(?string $unitTest)
    {
        if($unitTest != null) 
        { 
            $_POST['name'] = $unitTest;
            $_POST['function'] = "checkProjectExistance";
        }

        $function = $_POST['function'];
        $projectSearch = isset($function) ? $_POST['name'] : $_GET['projectId'];
        $sql = isset($function) ? "SELECT name FROM project WHERE name = ?" : "SELECT projectId FROM project WHERE projectId = ?";
        if (!isset($projectSearch) || $projectSearch == null) return false;

        $pdo = logindb();
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$projectSearch]);

        if($stmt->rowCount() != 0) return true; 

        return false;
    }

    public function createNewProject($projectName, $projectStatus)
    {
        session_start();
        $pdo = logindb();
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $stmt = $pdo->prepare("INSERT INTO project (name, status, owner) VALUES (?, ?, ?)");
        $stmt->execute([$projectName, $projectStatus, $_SESSION['userLoggedIn']->getId()]);
    }

    public function createNewTicket($featureId, $summary, $reporterKey)
    {
        $pdo = logindb();
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $stmt = $pdo->prepare("INSERT INTO ticket (summary, featureId, reporter_key) VALUES (?, ?, ?)");
        $stmt->execute([$summary, $featureId, $reporterKey]);
    }

    public function getProjectList()
    {
        $pdo = logindb();
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $stmt = $pdo->prepare("SELECT projectId, name, status FROM project");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getTicketListWithProgress($featureId, $progress)
    {
        $sql = "SELECT ticket.ticketId, ticket.summary, ticket.progress, user.forename, user.surname 
        FROM ticket LEFT JOIN user on user.userId = ticket.assignee_key
        WHERE featureId = ? AND (ticket.progress = ?";
        // TODO: When re-writing this, ensure that a better way is used for this
        if($progress == "In Progress") $sql = $sql . "OR ticket.progress = 'In Automation')";
        else $sql = $sql .")";
        $pdo = logindb();
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $stmt = $pdo->prepare($sql);

        $stmt->execute([$featureId, $progress]);
        return $stmt->fetchAll();
    }

    public function loadProjectsInNavBar($userLoggedIn)
    {
        $projectController = new projectController();
        if ($userLoggedIn == null) return; 
        $projects = $projectController->getProjectList();

        echo "<li class='nav-item dropdown'>";
        echo "<a id='projectNav' href='#' class='nav-link dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>Project<span class='caret'></span></a>";
        echo "<div class='dropdown-menu'>";
        
        foreach ($projects as $project) 
        { 
            echo "<a class='dropdown-item' href='../Project/index.php?projectId=$project->projectId'>$project->name</a>";
        } 
        
        echo "</div>";
        echo "</li>";
    }
}
?>