<?php require("../User/user.php"); require("../connection.php"); session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
<style></style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include("../Global/head.php"); ?> 
    <link rel="stylesheet" type="text/css" href="../Css/managerPage.css"/>
    <title>Manager</title>
</head>
<body>
    <?php include("../Global/navBar.php"); ?>

    <h1>Manager Dashboard</h1>

    <div class="container">
        <div class="row">
            <div class="col-sm-10">
                <h3 href="#">Projects <span id="projectSize" class="badge"></span></h3>
            </div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-success" data-toggle='modal' data-target='#globalModal' onclick="createProjectPrompt()">New Project</button>
            </div>
        </div>
        
        <!-- Projects List -->
        <hr><ul id="projectUl" class="list-group list-group-flush project-list"></ul>
    </div>

    <?php include("../Global/scripts.php"); ?>
    <?php include("managerModal.php"); ?>
    <script type="text/javascript" src="../Script/managerController.js"></script>
    <?php include("../Global/editUserModal.php"); ?>
</body>
</html>