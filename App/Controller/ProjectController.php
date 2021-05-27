<?php
namespace App\Controller;

use PDO;
use App\Utility\Library;

class ProjectController
{
    public static function projectExistance($name)
    {
        if ($name == null) return;

        $pdo = Library::logindb();
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $stmt = $pdo->prepare("SELECT name FROM project WHERE name = ?");
        $stmt->execute([$name]);

        return $stmt->rowCount() != 0 ? true : false;
    }

    public static function createNewProject($projectName, $projectStatus)
    {
        $pdo = Library::logindb();
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $stmt = $pdo->prepare("INSERT INTO project (name, status, owner) VALUES (?, ?, ?)");
        $stmt->execute([$projectName, $projectStatus, unserialize($_SESSION['userLoggedIn'])->userId]);
    }

    public static function createNewTicket($featureId, $summary, $reporterKey)
    {
        $pdo = Library::logindb();
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $stmt = $pdo->prepare("INSERT INTO ticket (summary, featureId, reporter_key) VALUES (?, ?, ?)");
        $stmt->execute([$summary, $featureId, $reporterKey]);
    }

    public static function getProjectList()
    {
        $pdo = Library::logindb();
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $stmt = $pdo->prepare("SELECT projectId, name, status FROM project");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getAccessibleProjectList($userLoggedIn)
    {
        $pdo = Library::logindb();
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $stmt = $pdo->prepare("SELECT DISTINCT p.projectId, p.name, p.owner FROM projectAccess pa 
                               RIGHT JOIN project p ON pa.projectId = p.projectId 
                               WHERE pa.allowAccess = 1 AND pa.userId = ? OR p.owner = ?");
        $stmt->execute([unserialize($userLoggedIn)->userId, unserialize($userLoggedIn)->userId]);
        return $stmt->fetchAll();
    }

    public static function getTicketListWithProgress($featureId, $progress)
    {
        $sql = "SELECT ticket.ticketId, ticket.summary, ticket.progress, user.forename, user.surname 
        FROM ticket LEFT JOIN user on user.userId = ticket.assignee_key
        WHERE featureId = ? AND (ticket.progress = ?";
        // TODO: When re-writing this, ensure that a better way is used for this
        if($progress == "In Progress") $sql = $sql . "OR ticket.progress = 'In Automation')";
        else $sql = $sql .")";
        $pdo = Library::logindb();
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $stmt = $pdo->prepare($sql);

        $stmt->execute([$featureId, $progress]);
        return $stmt->fetchAll();
    }
}
