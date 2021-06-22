<?php
namespace Lmaoo\Controller;

use Lmaoo\Model\Project;
use Lmaoo\Model\ProjectAccess;
use Lmaoo\Utility\Validation;
use Lmaoo\Utility\APIResponse;

class ManagerController extends BaseController
{
    public static function createUsersToProject($json)
    {
        $data = json_decode($json, true); $validation = Validation::ProgressAccess($data);

        $validation == null ? ProjectAccess::create($data): APIResponse::BadRequest($validation);
    }

    public static function readUsersOnProject($projectId)
    {
        echo json_encode(ProjectAccess::withProjectId($projectId));
    }

    public static function readOwnerProjects()
    {
        echo json_encode(Project::withOwnerId(self::$userLoggedIn->userId));
    }

    public static function readManagerProjects($userLoggedIn)
    {
        $projects = ProjectAccess::withManagerAccess($userLoggedIn->userId);
    }

    public static function deleteUsersFromProject($projectId)
    {
        echo json_encode(ProjectAccess::delete($projectId));
    }
}
