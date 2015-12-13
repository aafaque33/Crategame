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
$recname = $_SESSION['name'] ;
$finalscore = $_SESSION['finalscore'];

if(isset($_SESSION['name']))
{
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
                        
    $sql = "UPDATE puzzles SET recname = '$recname', score = '$finalscore' , time = now() where puzname = '$puzname' and seedlev = '$seedlev' " ;

         	    $file = fopen("F:/test.txt","w");
			 	echo fwrite($file,$sql);
			 fclose($file);

    $result = $connect->query($sql);

    $_SESSION['scoreupdate'] = true;
    
    if(!$result)
    {
        echo "<ul>";
        echo '<li class="error"> Could not insert into Database: User already Present </li>' ;
        echo "</ul>";
        die("Could not Update the Record");
    }
    else
	header("Location: crategame.php?seed=" . $seedlev . "&recscore=" . $finalscore . "&puzname=" . $puzname);
}
else
{
	$_SESSION['flag'] = 'redirect';
	header("Location: login.php");
}

?>