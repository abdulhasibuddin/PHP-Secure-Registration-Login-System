<?php
	//This file destorys any existing session related to the current user::
	session_start(); //Start session
	session_destroy(); //Destroy session
	header("location: ../view/loginPage.php"); //Take the user to the login page
?>
