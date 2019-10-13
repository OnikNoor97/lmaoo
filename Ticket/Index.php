<?php require("../User/user.php");
session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
        <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Ticket</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="../Css/ticketPage.css">	

<nav class="navbar navbar-default navbar-fixed-top">		
    <!-- Navbar Container -->
	<div class="container">
        <!-- Navbar Header [contains both toggle button and navbar brand] -->
        <div class="navbar-header">
            <!-- Toggle Button [handles opening navbar components on mobile screens]-->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#exampleNavComponents" aria-expanded="false">
                <i class="glyphicon glyphicon-align-center"></i>
            </button>			
        		<p class="navbar-text text-right">
                        <?php
                        if(isset($_SESSION['userLoggedIn']))
                        {
                            $userLoggedIn = $_SESSION['userLoggedIn'];
                            echo "Welcome " . $userLoggedIn->getForename() . " " . $userLoggedIn->getSurname();
                        ?>
                            
                        <?php
                        }
                        else
                        {
                            echo "Welcome to Lmaoo! Please login for full access!";
                        }
                        ?>
                </p>
        </div>
        <!-- Navbar Collapse [contains navbar components such as navbar menu and forms ] -->
        <div class="collapse navbar-collapse" id="exampleNavComponents">
            <!-- Navbar Menu -->
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="../index.php">Home</a>
                </li>
				<li>
					<a href="../About/index.php">About</a>
				</li>
                <li class="active">
                    <a href="../Ticket/index.php">Ticket</a>
                </li>
                <!-- Navbar link with a dropdown menu -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Account
                    <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if (!isset($userLoggedIn)) 
                                { ?>
                            <li><a href="../User/register.php">Register</a></li>
                            <li><a href="../User/index.php">Login</a></li>
                        <?php   } 
                              else if ($userLoggedIn->getLevel() == "1")
                                { ?>
                                    <li><a href="../User/editUser.php">Edit Account</a></li> 
                                    <li><a href="../User/logout.php">Logout</a></li>
                        <?php   } else 
                                { ?>
                                    <li><a href="../User/editUser.php">Edit Account</a></li>   
                                    <li><a href="../User/logout.php">Logout</a></li>
                                    <li><a href="../User/admin.php">Admin</a></li>
                        <?php   } ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End of Navigation Bar -->
</head>
<body>
	<div ID="ticketContainer">
    		<div ID="ticketBrief">
    		  <h1> Brief Description </h1>
    		</div>

    		<div ID="ticketPeople">
    		  <h1> People <h1>
    		</div>

    		<div ID="ticketDetails">
    		  <h1 align=""> Details </h1>
    		</div>

    		<div ID="ticketDate"> 
    		  <h1> Dates </h1>
                
                <div ID="dates1">   
                <p>Created Date:</p> <p>Stephen Help!</p> <!-- Note: Stephen, could you make sure that the 'Stephen Help' paragraphs the same line as the Date paragrahs? -->
                <p>Start Date:</p> <p>Stephen Help!</p>
                </div>
    		    <div ID="dates2">
                <p>Updated Date:</p> <p>Stephen Help!</p>
                <p>Deadline:</p> <p>Stephen Help!</p>
                </div>

            </div>

            <div ID="detailsSubBug">
            <h1>Sub Bug</h1>
            </div>

    		<div ID="ticketMessages">
    		<h1> Dev Messages </h1>
    		</div>
	</div>
		  <div ID="ticketCreate">
		      <h1> Comment Creator <h1>
		  </div>
		  <div ID="ticketComments">
		      <h1> Comment Section </h1>
		  </div>
<footer>
</footer>

</body>
</html>