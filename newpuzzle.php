<!DOCTYPE html>
<?php 
    require('dbconfig.php');
    require('Validate.php');     
    session_start();

    ?>
<html>

    <head>

        <title> New Puzzle </title>
        <link rel="stylesheet" type="text/css" href="crate.css">

    </head>

    <body class="login">

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

            <?php

            //$name = "";
            $newpuzname = "";

                if(count($_POST) > 0)
                {
                    //$name = $_POST['name'] ;
                    $newpuzname = $_POST['newpuzname'] ;
                    $recname = $_SESSION['name'] ;

                    $connect = mysqli_connect($server, $user, $pass, $db);
                    if(!$connect) 
                    {
                        printf("Connect failed: %s\n", $mysqli->connect_error);
                        exit();
                    }

                    $sql = "Select puzname from puzzles where puzname = '$newpuzname' " ;

                    $result = $connect->query($sql);
                        if(!$result)
                        {
                            die("Could not query Database" . $mysqli->error);
                        }

                        else
                        {
                            if($result->num_rows > 0 )
                            {
                                $err["newpuzname"] = true ; 
                            }
                            else
                            {
                                header("Location: crategame.php?seed=" . 0 . "&recscore=" . 0 . "&puzname=" . $newpuzname);
                            }
                        }

                    if(isset($err))
                    {
                        //$fields = implode(',',array()ray_keys($err));

                        foreach ($err as $key => $value) {
                            if($key == 'newpuzname')
                            {
                                echo '<div class="errorbox error"><span>error: </span>Puzzle name already exist please add new puzzle name</div>';
                            }
                        }
                    }
                }
                ?>

            <div id="container3">
                <div id="container2">
                    <div id="container1">
                        <div id="col1">
                        </div>
                        <div id="col2">
                            <div>
                                <?php 

                                if(isset($_SESSION['name']))
                                {
                                    unset($_SESSION['newpuz']);

                                    if($_SERVER['REQUEST_METHOD'] === "GET" || isset($err))
                                    {
                                       
                                        if(count($_POST) > 0 ) 
                                        { 
                                            //$name = $_POST['name'] ;
                                            $newpuzname = $_POST['newpuzname'] ;
                                        }
                                        else
                                        {
                                            //$name = "" ;
                                            $newpuzname = "" ;
                                        }

                                    ?>  
                                        <form method="post" class="smart-green" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">

                                            <h1>New Puzzle Name <span>Please add name and submit.</span></h1>
                                            <p><label for="name"><span>PuzzleName:*</span></label> 
                                            <input class="input" type="text" name="newpuzname"  placeholder="testpuzzle" value="<?php print $newpuzname ?>"></p>    

                                            <p><input class="submit" type="submit" namprint $namee="submit" value="Submit"></p>
                                        </form>

                                        <?php 
                                    } 
                                    
                                } 
                                else
                                    {
                                        $_SESSION['newpuz'] = 'redirect';
                                        header("Location: login.php");
                                    }
                                ?>
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



