<!DOCTYPE html>
<?php 
    require('dbconfig.php');
    require('Validate.php');     
    session_start();

    ?>
<html>

    <head>

        <title> Sign In </title>
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
            $email = "";
            $password = "";

                if(count($_POST) > 0)
                {
                    //$name = $_POST['name'] ;
                    $email = $_POST['email'] ;
                    $password = $_POST['pass'] ;


                    if(!Validemail($email ) || empty($email) || strlen($email) > 128)
                    {
                        $err["email"] = true ;
                    }

                    if(!Validpass($password) || empty($password) || (strlen($password) > 32 || strlen($password) < 4))
                    {
                        $err["password"] = true ;
                    }

                    if(!isset($err))
                    {
                        $connect = mysqli_connect($server, $user, $pass, $db);
                        
                        if(!$connect) 
                        {
                            printf("Connect failed: %s\n", $mysqli->connect_error);
                            exit();
                        }  

                        $md5pass = md5($password) ;
                        
                        $sql = "Select tag from users where email = '$email' and password = '$md5pass'" ;

                        $result = $connect->query($sql);
                        if(!$result)
                        {
                            die("Could not query Database" . $mysqli->error);
                        }
                        else
                        {
                            if($result->num_rows > 0 )
                            {
                                // $file = fopen("E:/test.txt","w");
                                // fwrite($file,"Hello World. Testing!");
                                // fclose($file);

                                $row = $result->fetch_array(MYSQLI_ASSOC);
                                $_SESSION['name'] =  $row["tag"] ;
                                if(isset($_SESSION['flag']) && ($_SESSION['flag'] == 'redirect'))
                                {
                                    header("Location: score.php");
                                }
                                else
                                {
                                    header("Location: puzzlelist.php");
                                }
                            }
                            else
                            {       
                                echo '<div class="errorbox error"><span>error: </span>Username or Pasword is Incorrect , Please try again</div>';
                            }
                        }
                    }

                    if(isset($err))
                    {
                        //$fields = implode(',',array()ray_keys($err));

                        foreach ($err as $key => $value) {
                            if($key == 'email')
                            {
                                echo '<div class="errorbox error"><span>error: </span>Please Enter correct email format abc@domain.com.</div>';
                            }
                            if($key == 'password')
                            {
                                echo '<div class="errorbox error"><span>error: </span>Password should have Alpha Numeric Character and greater than 4 characters and less than 32 characters and not be empty</div>';
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
                            <?php 

                            if( !(isset($_SESSION['name'])))
                            {

                                if($_SERVER['REQUEST_METHOD'] === "GET" || isset($err))
                                {
                                   
                                    if(count($_POST) > 0 ) 
                                    { 
                                        //$name = $_POST['name'] ;
                                        $email = $_POST['email'] ;
                                        $password = $_POST['pass'] ;
                                    }
                                    else
                                    {
                                        //$name = "" ;
                                        $email = "" ;
                                        $password = "";
                                    }

                                ?>  
                                    <h1> Sign In Form</h1> <br/><br/>
                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">

                                        <p><label for="name">Username: *</label> 
                                        <input class="input" type="text" name="email" value="<?php print $email ?>"></p><br />

                                        <p><label for="name">Password : *</label> 
                                        <input class="input" type="password" name="pass" value="<?php print $password ?>"></p><br />

                                        <input class="submit" type="submit" namprint $namee="submit" value="Sign In">
                                    </form>

                                    <?php 
                                } 
                                
                            }
                            else
                            {   ?>
                                <div class="errorbox notice"><span>Notice: </span>You are already Logged In , Please Logout First</div>;
                            <?php    } ?>
                        </div>
                        <div id="col3">
                        </div>
                    </div>
                </div>
            </div>       
        
        </div>

    </body>

</html>