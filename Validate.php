<?php

function Validtag($str)
{
	$str = trim($str);
	$p = '/^[A-Za-z0-9]+$/' ;
	return (boolean) preg_match($p,$str);
}

function Validemail($str)
{
	$str = trim($str);
	$p = '/^[\w.]+\@[\w.]+\.\w+$/' ;
	return (boolean) preg_match($p,$str);
}

function Validpass($str)
{
	$str = trim($str);
	$p = '/^[A-Za-z0-9]+$/' ;
	return (boolean) preg_match($p,$str);
}

?>
