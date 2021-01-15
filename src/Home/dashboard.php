<?php if(!defined('directAccessValidator')) { die(file_get_contents('../../includes/notFound.php')); return; } ?>

<h1 class='welcomeMessage'>Welcome back User</h1>
<div class="container-fluid">
    <div id="homePageTickets">
        <div class="homeDashboard">
            <span class="homeProject-list">
                <p class="text-center"><b>Your projects</b></p>
                <hr class="small-hr">
                <ul id="homeProjects" class="list-inline">
                </ul>
            </span>
            <span class="ticket-deadline">
                <p class="text-center"><b>Ticket Deadlines</b></p>
                <hr class="small-hr">
                <ul id="homeTickets" class="list-inline">
                </ul>
            </span>
        </div>
    </div>
</div>