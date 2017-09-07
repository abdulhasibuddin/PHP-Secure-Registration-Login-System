<?php
	//This file binds the data and inserts into into the database::
	//This file is required in 'registrationPage2.php'
	require 'config.php'; //Opening connection
//--------------------------------------------------------------------------------------------------------------------------------

	//Prepared statement:: (prevents sql injection into the database)::
	$stmt = $conn->prepare("INSERT INTO registrationTable (firstName, lastName, eMail, userName, password, gender) VALUES (?, ?, ?, ?, ?, ?)");

	//Checking for SQL-Injection type vulnerability::(Escaping special characters in a string having special meaning in SQL statement)::
	$fName = mysqli_real_escape_string($conn, $fName);
	$lName = mysqli_real_escape_string($conn, $lName);
	$eMail = mysqli_real_escape_string($conn, $eMail);
	$uName = mysqli_real_escape_string($conn, $uName);
	$password = mysqli_real_escape_string($conn, $password);
	$gender = mysqli_real_escape_string($conn, $gender);

	$stmt->bind_param("ssssss", $fName, $lName, $eMail, $uName, $password, $gender); //Binding parameters into prepared statement
	$stmt->execute(); //Execute query

	$stmt->close(); //Closing prepared statement
	$conn->close(); //Closing connection
//--------------------------------------------------------------------------------------------------------------------------------

	
	/*$subject = 'Activate your account'; //Subject of the email
	$message = 'Your account activation code is: '.$verCode; //Message including the account activation code
	require 'sendEmail.php'; //This file mails the account activation code to the user*/

	header("location: ../view/authenticatedUser.php"); //Take the user to the authenticated page. In this stage, it will automatically load the 'login' page
?>
