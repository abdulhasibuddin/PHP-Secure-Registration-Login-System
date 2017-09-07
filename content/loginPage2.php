<?php
	//After submitting the form of 'loginPage.php', submitted 'name' properies are processed in this file::
	session_start(); //Start session
	require 'secureInput.php'; //This file checks for cross-site scripting(XSS) vulnerability
	
	//-----------------------------------------------------------------
	$userName = $password = $verPass = $captcha =  "";
	$err = $captchaErr =  "";
	$errFlag = 0; //If any error occures, this flag would be valued 1
	$userExists = 1;


	//-----------------------------------------------------------------
	if($_SERVER["REQUEST_METHOD"]=="POST") { //Checking if the form was submitted as POST
		$userName = secureInput($_POST["userName"]); //XSS vulnerability checking of input username

		if(strlen($userName) > 255) {
			$err = "Invalid input!"; 
			$errFlag = 1;
		}
		
		if(!preg_match("/^[a-zA-Z0-9_]{1,255}$/", $userName)) { //Regular expression comparison
			//If input username is invalid::
			$err = "Invalid input!";
			$errFlag = 1;
		}
		else { //If input is OK::
			$uName = $userName;
			require '../model/checkUniqueUserName.php'; //This file checks if the username input by the user already exists or not
			foreach($result as $value){ //Traverse columns of the selected row
				if(!count(array_filter($value)) > 0) {//If user does not exist...
					$err = "Incorrect username or password!"; //notify user...
					$errFlag = 1; //set error flag high
					$userExists = 0;
				}
			}
		}
	//-----------------------------------------------------------------

		$password = secureInput($_POST["password"]); //XSS vulnerability checking of input password
		if(strlen($password) > 255) {
			$err = "Invalid input!"; 
			$errFlag = 1;
		}
		if(!preg_match("/^[a-zA-Z0-9_]{1,255}$/", $password)) { //Regular expression comparison
			$err = "Invalid input!";
			$errFlag = 1;
		}
		elseif($userExists == 1 AND $errFlag == 0) {
			require '../model/checkLoginPassword.php';

			foreach($chkResult as $value){ //Traversing columns of the selected row
				if(count(array_filter($value)) > 0) { //If username/account exists...
					$verPass = $value["password"]; //get the encrypted password stored in the database corresponding to the username...
				}
				else {
					//If username/account does not exist::
					$err = "Incorrect username or password!"; 
					$errFlag = 1;
				}
			}

			//password_verify('Unencrypted password needs to be verified', 'Encrypted password to be verified with')::
			if (!password_verify($password, $verPass)) { //Verify the user input password with the stored password,
				//if they don't match::
				$err = "Incorrect username or password!";
				$errFlag = 1;
			}
		}
	//-----------------------------------------------------------------

		
		//$_POST["captcha"]-> captcha code input by the user [here, 'vercode' is the name of the captcha input field; don't be 	confused with the session 'vercode'!]
		//$_SESSION["vercode"]-> session 'vercode' holding the actual captcha code

		if(isset($_SESSION["vercode"])){ //Check if session 'vercode' is set
			$captcha = secureInput($_POST["captcha"]);

			if(!preg_match("/^[a-zA-Z0-9_]{1,6}$/", $captcha)) { //Regular expression comparison
				//If input username is invalid::
				$captchaErr =  "Incorrect captcha!";
				$errFlag = 1;
			}
			if(strlen($captcha) > 255) {
				$captchaErr =  "Incorrect captcha!";
				$errFlag = 1;
			}
			elseif($captcha != $_SESSION["vercode"] OR $_SESSION["vercode"] == ""){
				//If the captcha input is not correct or if the session 'vercode' does not contain any captcha::
				$captchaErr =  "Incorrect captcha!";
				$errFlag = 1;
			}
			else{
				session_unset($_SESSION["vercode"]); //Unsetting session 'vercode' when captcha is confirmed
			}	
		}	
	}
	//-----------------------------------------------------------------

	if ($userName != "" AND $password != "" AND $errFlag == 0) { //If the username and password fields are not empty and if there is no other error...
		echo "errFlag = ".$errFlag;
		$_SESSION['user'] = $userName; //assign the username to the session 'user'...
		header("location: ../view/authenticatedUser.php"); //take the user to his/her own authenticated page
	}
?>
