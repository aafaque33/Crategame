<!DOCTYPE html>

<?php 
    session_start();
    ?>
<html>

	<head>

		<title> Play Game </title>
		<link rel="stylesheet" type="text/css" href="crate.css">

	</head>

	<body class="game">   
		
		<div id="main">

            <div id="header">
                <header class="wrapper clearfix">
                    <div class="center">
                        <h1 class="title">CRA</h1>
                        <img src="bobcat1.gif" alt="" />
                        <img src="boxtarget3inverse.png" alt="" />
                        <h1 class="title">&nbsp;</h1>
                        <h1 class="title">GAM</h1>
                        <img src="boxtarget3inverse.png" alt="" />
                    </div>
                </header>
            </div>

            <nav class="navigation">
                    <ul>
                        <li><a href="index.php" class="list">Home</a></li>
                        <li><a href="puzzlelist.php" class="list">Puzzle List</a></li>
                        <?php 
                        if(isset($_SESSION['name']))
                        {
                            echo '<li><a href="logout.php" class="login">' . "Logout" . '</a></li>' ;
                            echo '<li>' .'Logged in as user: '.  $_SESSION['name'] . '</li>' ;
                        }
                        else
                        {
                            echo  '<li><a href="registration.php" class="registration">Registration</a></li>' ;
                            echo '<li><a href="login.php" class="login">Login</a></li>';
                        }
                        ?>
                    </ul>
            </nav>

            <div id="container3">
                <div id="container2">
                    <div id="container1">
                        <div id="col1">
                        </div>
                        <div id="col2">
                            <img src="crategame.gif" alt="Game Demo">
                        </div>
                        <div id="col3">
                        </div>
                    </div>
                </div>
            </div>

			<div id="container">

			<script src="utils.js"> </script>
			<script src="crateboard.js"> </script>
		
		</div>

	</body>

</html>