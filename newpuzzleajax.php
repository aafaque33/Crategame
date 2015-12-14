<?php

if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
	
	$action = $action . "=abcdef"
	echo $action;
}

?>