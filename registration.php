<!DOCTYPE html>
<?php 
    require('dbconfig.php');
    require('Validate.php');     
    session_start();
    ?>
<html>

    <head>

        <title> Sign Up </title>
        <link rel="stylesheet" type="text/css" href="crate.css">

    </head>

    <body class="registration">

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

            $name = "";
            $email = "";
            $password = "";

                if(count($_POST) > 0)
                {
                    $name = $_POST['name'] ;
                    $email = $_POST['email'] ;
                    $password = $_POST['pass'] ;

                    if(!Validtag($name) || empty($name) || strlen($name) > 32)
                    {
                        $err["name"] = true ;
                    }

                    if(!Validemail($email ) || empty($email) || strlen($password) > 128)
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
                        
                        $sql = "INSERT INTO users (tag, password, email) VALUES ('$name', '$md5pass', '$email')" ;
                        $result = $connect->query($sql);
                        if(!$result)
                        {
                            echo '<div class="errorbox error"><span>error: </span>Could not insert into Database: User already Present</div>';
                            die("Could not Insert into database: User Already Preset");
                        }
                    }

                    if(isset($err))
                    {
                        echo "<ul>";
                        //$fields = implode(',',array_keys($err));

                        foreach ($err as $key => $value) {
                            if($key == 'name')
                            {
                                echo '<div class="errorbox error"><span>error: </span>Tag should have Alpha Numeric Character and less than 32 characters only and not be empty</div>';
                            }
                            if($key == 'email')
                            {
                                echo '<div class="errorbox error"><span>error: </span>Please Enter correct email format abc@domain.com</div>';
                            }
                            if($key == 'password')
                            {
                                echo '<div class="errorbox error"><span>error: </span>Password should have Alpha Numeric Character and greater than 4 characters and less than 32 characters and not be empty</div>';
                            }
                        }
                        echo "</ul>";
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
                                        $name = $_POST['name'] ;
                                        $email = $_POST['email'] ;
                                        $password = $_POST['pass'] ;
                                    }
                                    else
                                    {
                                        $name = "" ;
                                        $email = "" ;
                                        $password = "";
                                    }

                                ?>  

                                    <form method="post" class="smart-green" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">

                                        <h1>Sign Up <span>Please fill all the texts in the fields.</span></h1>

                                        <p><label for="name"><span>Tag:*</span></label> 
                                        <input class="input" type="text" name="name" placeholder="iffi" value="<?php print $name ?>"></p>

                                        <p><label for="name"><span>Email:*</span></label>  
                                        <input class="input" type="text" name="email" placeholder="abc@domain.com" value="<?php print $email ?>"></p>

                                        <p><label for="name"><span>Password:*</span></label> 
                                        <input class="input" type="password" name="pass" placeholder="****" value="<?php print $password ?>"></p>

                                        <input class="submit" type="submit" namprint $namee="submit" value="Signup">
                                    </form>

                                    <?php 
                                } 
                                else
                                {

                                unset($_POST['name']);
                                unset($_POST['email']);
                                unset($_POST['pass']);

                                    ?>

                                <div class="errorbox success"><span>Success: </span>Congratulations:  You have Successfully Registered</div>;
                            
                            <?php   } 
                            }
                            else
                                    {   ?>

                                <div class="errorbox notice"><span>Notice: </span>You are already Logged In , Please Logout First</div>;

                            <?php   } ?>
                        </div>
                        <div id="col3">
                        </div>
                    </div>
                </div>
            </div>      
        
        </div>

    </body>

</html>