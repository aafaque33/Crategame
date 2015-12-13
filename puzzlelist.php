<!DOCTYPE html>
<?php 
require('dbconfig.php'); 
    session_start();
    ?>
<html>

    <head>

        <title> Registration </title>
        <link rel="stylesheet" type="text/css" href="crate.css">

    </head>

    <body class="list">

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

            <div id="container3">
                <div id="container2">
                    <div id="container1">
                        <div id="col1">
                        </div>
                        <div id="col2">
                            <h1> ScoreBoard </h1> <br/>
                            <div id="puzzlelist">
                                <?php

                                    $connect = mysqli_connect($server, $user, $pass, $db);
                                    
                                    if(!$connect) 
                                    {
                                        printf("Connect failed: %s\n", $mysqli->connect_error);
                                        exit();
                                    }   
                                    
                                    $result = $connect->query("select min(score) total,seedlev,puzname,name,recname from puzzles group by puzname");
                                    
                                    if(!$result)
                                    {
                                       die("results have not been fetched");
                                       exit();
                                    }
                                ?>

                                <table class="cratetable" >
                                    <th>Puzzle Name</th>
                                    <th>Game Creator</th>
                                    <th>Record Holder</th>
                                    <th>Score</th>
                                
                                <?php  
                                    //echo nl2br("PuzzleName ==> Name , Recname ===> Score \n\n") ;
                                    
                                    echo "<tr>" ;
                                    echo '<td><a href="crategame.php?seed=' . 0 . '&recscore=' . 0 . '&puzname=new" class="button">' . 'Create New Puzzle </a></td>';
                                    echo '<td>'  . "" . "</a></td>";
                                    echo '<td>'  . "" . "</a></a></td>";
                                    echo '<td>' . "" . "</a></td>";
                                    echo "</tr>" ;

                                    while($row = $result->fetch_array(MYSQLI_ASSOC))
                                    {
                                        echo "<tr>" ;
                                        echo '<td><a href="crategame.php?seed=' .$row["seedlev"]. '&recscore=' . $row["total"] . '&puzname=' . $row["puzname"] . '" class="button">Play&nbsp;'  . $row["puzname"] . "</a></td>";
                                        echo '<td>'  . $row["name"] . "</a></td>";
                                        echo '<td>'  . $row["recname"]. "</a></td>";
                                        echo '<td>' . $row["total"]. "</a></td>";
                                        echo "</tr>" ;
                                    }
                         
                                ?>
                                </table>
                            </div>
                        </div>
                        <div id="col3">
                        </div>
                    </div>
                </div>
            </div>
        
        </div>

    </body>

</html>