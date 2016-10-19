<?php
	if (!isset($_SESSION)) {
		session_start();
	}else{
		if (!isset($_SESSION['jenengataz'])) {
			session_start();
			header("location:login.php");
			exit;
		} else if (($_SESSION['levelataz']) != "owner ataz" and ($_SESSION['levelataz']) != "manager ataz") {
			echo "anda tidak punya hak di sini";
			header("location:home");
			exit;
		}
	}
?>

