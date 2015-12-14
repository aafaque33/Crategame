<?php 
require('dbconfig.php'); 
    session_start();
?>

<?php

if(isset($_POST['currentseed']) && isset($_POST['finalscore']) && isset($_POST['puzzlename']))
{
	$_SESSION['currentseed'] = $_POST['currentseed'];
	$_SESSION['finalscore'] = $_POST['finalscore'];
	$_SESSION['puzzlename'] = $_POST['puzzlename'];
}

$seedlev = $_SESSION['currentseed'] ;
$puzname = $_SESSION['puzzlename'] ;
$finalscore = $_SESSION['finalscore'];

if(isset($_SESSION['name']))
{
    $recname = $_SESSION['name'] ;
	unset($_SESSION['flag']);
	unset($_SESSION['currentseed'] );
	unset($_SESSION['finalscore'] );
	unset($_SESSION['puzzlename'] );

	$connect = mysqli_connect($server, $user, $pass, $db);
                        
    if(!$connect) 
    {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }

    $connect = mysqli_connect($server, $user, $pass, $db);
                    if(!$connect) 
                    {
                        printf("Connect failed: %s\n", $mysqli->connect_error);
                        exit();
                    }

                    $sql = "Select puzname from puzzles where puzname = '$puzname' and seedlev = '$seedlev' " ;

                    $result = $connect->query($sql);
                        if(!$result)
                        {
                            die("Could not query Database" . $mysqli->error);
                        }

                        else
                        {
                            if($result->num_rows > 0)
                            {
                                $sql2 = "UPDATE puzzles SET recname = '$recname', score = '$finalscore' , `when` = now() where puzname = '$puzname' and seedlev = '$seedlev' " ;

                                $result2 = $connect->query($sql2);

                                if(!$result2)
                                {
                                    echo '<div class="errorbox error"><span>error: </span>Could not Update score in Database</div>';
                                    die("Could not Could not Update score database");
                                }
                                else
                                {
                                    $_SESSION['scoreupdate'] = true;
                                    header("Location: crategame.php?seed=" . $seedlev . "&recscore=" . $finalscore . "&puzname=" . $puzname);
                                }
                            }
                            else
                            {
                                $sql2 = "INSERT INTO puzzles (seedlev, puzname, name,recname,score,`when`) VALUES ('$seedlev', '$puzname', '$recname', '$recname','$finalscore',now() )" ;
                                $result2 = $connect->query($sql2);
                                if(!$result2)
                                {
                                    echo '<div class="errorbox error"><span>error: </span>Could not insert into Database</div>';
                                    die("Could not Insert into database");
                                }
                                else
                                {
                                    $_SESSION['scoreupdate'] = true;
                                    header("Location: crategame.php?seed=" . $seedlev . "&recscore=" . $finalscore . "&puzname=" . $puzname);
                                }                       
                            }
                        }
    
}
else
{
	$_SESSION['flag'] = 'redirect';
	header("Location: login.php");
}

?>