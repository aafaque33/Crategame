<!DOCTYPE html>

<?php 
    session_start();
    ?>
<html>

	<head>

		<title> Home </title>
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
                            echo '<li class="username">' .'Logged in as user: '.  $_SESSION['name'] . '</li>' ;
                        }
                        else
                        {
                            echo  '<li><a href="registration.php" class="registration">Registration</a></li>' ;
                            echo '<li><a href="login.php" class="login">Login</a></li>';
                        }
                        ?>
                    </ul>
            </nav>

            <div class="errorbox success"><h1>Welcome to Crate Game , Click on Puzzle list to play Exisitng Games or Create New Puzzles</h1>
                <div>
                <audio autoplay="autoplay" controls="controls" loop="loop">
                     <source src="audio.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>
                </div>
            </div>;


            <div id="container3">
                <div id="container2">
                    <div id="container1">
                        <div id="col1">
                            <img src="crategame.gif" alt="Game Demo"> 
                        </div>
                        <div id="col2">
                            <div class="errorbox info">
                                <h1> Instructions </h1>
                                <ul style="text-align:left; text" class="instructions">
                                    <li> Game Play
                                    </li><br/>
                                    <li> &quot; Forward Arrow &quot; : &nbsp; Move forward in any direction
                                    </li><br/>
                                    <li> &quot; Left Arrow &quot; : &nbsp; Turn Left acording to current postion
                                    </li><br/>
                                    <li> &quot; Right Arrow &quot; : &nbsp; Turn Right acording to current postion
                                    </li><br/>
                                    <li> &quot; Spacebar &quot; : &nbsp; Destroy the crate in front of Bobcat
                                    </li><br/>
                                    <li> &quot; Back Arrow &quot; : &nbsp; Invalid Move
                                    </li>
                                </ul>
                            </div>
                            <div class="errorbox info">
                                <h1> Rules </h1>
                                <ul style="text-align:left; text" class="instructions">
                                    <li> Bring the Target Block in Red to Bobcat Position
                                    </li><br/>
                                    <li> Each move , forward or turn will count a score addition of 1
                                    </li><br/>
                                    <li> Destroy a Crate will count score addition of 100
                                    </li><br/>
                                    <li> You cannot destroy a block with 0 weight or Target block
                                    </li><br/>
                                    <li> You must be logged in to create a new Puzzle or add your Record score
                                    </li><br/>
                                    <li> You can only add your score if you have scored minimum score as record
                                    </li><br/>
                                    <li> You can reset and create a new puzzle while you are mid of playing existing game
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div id="col3">
                         <img src="crategame.gif" alt="Game Demo">   
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