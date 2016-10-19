<?php
	if (!isset($_SESSION)) {
		session_start();
	}else{
		if (!isset($_SESSION['jenengataz'])) {
			session_start();
			header("location:login.php");
			exit;
		}
	}
?>

<?php
/*
if(!isset($_SESSION)) 
{ 
session_start(); 
} 

if (!isset($_SESSION['jenengataz']))
{
    session_start(); 
	header("location:login.html");
	exit;
}
*/
?>