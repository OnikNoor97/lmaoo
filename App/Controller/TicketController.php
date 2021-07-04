<?php
namespace Lmaoo\Controller;

use Lmaoo\Core\Constant;
use Lmaoo\Model\Comment;
use Lmaoo\Model\Ticket;
use Lmaoo\Model\User;
use Lmaoo\Utility\APIResponse;
use Lmaoo\Utility\Validation;

class TicketController extends BaseController
{
    public function createTicket($json)
    {
        $data = json_decode($json, true); $data["reporter_key"] = $this->userLoggedIn->userId;
        $validation = Validation::createTicket($data);
        
        $validation == null ? Ticket::create($data) : APIResponse::BadRequest($validation);
    }

    public function updateTicket($json)
    {
        $data = json_decode($json, true); $validation = Validation::updateTicket($data);

        if ($validation == null) 
        {
            $ticketId = $data["ticketId"]; unset($data["ticketId"]);
            if (@$data["selfAssignee"] == null ) { Ticket::update($ticketId, $data); }
            else { Ticket::update($ticketId, ["assignee_key" => $this->userLoggedIn->userId]); } 
            echo json_encode(Ticket::withId($ticketId));
        }
        else
        {
            APIResponse::BadRequest($validation);
        }
    }

    public function createComment($json)
    {
        $data = json_decode($json, true); $data["userId"] = $this->userLoggedIn->userId;
        $validation = Validation::createComment($data);

        if ($validation == null) 
        {
            $latestId = Comment::create($data);
            echo json_encode(Comment::withId($latestId));
        }
        else 
        {
            APIResponse::BadRequest($validation);
        }
    }

    public function updateComment($json)
    {
        $data = json_decode($json, true); $data["userId"] = $this->userLoggedIn->userId;
        $validation = Validation::updateComment($data);
        if ($data["commentId"] ?? null != null) $commentId = $data["commentId"]; unset($data["commentId"]);
        $validation == null ? Comment::update($commentId, $data) : APIResponse::BadRequest($validation);
    }

    public function deleteComment($commentId)
    {
        $comment = Comment::read(Constant::$COMMENT_COLUMNS, ["commentId" => $commentId])[0] ?? null;
        if ($comment == null) return APIResponse::BadRequest("Comment does not exist");
        if ($comment->userId != $this->userLoggedIn->userId) return APIResponse::Forbidden("You do not have rights to do this action");
        Comment::delete($commentId);
    }

    public function getAssignees()
    {
        $users = User::read(["userId", "forename", "surname", "username"], ["isActive" => "1"]);
        echo json_encode($users);
    }
}
