<?php
	//After submitting the form of 'registrationPage.php', submitted 'name' properies are processed in this file::
	session_start(); //Start session
	require 'secureInput.php'; //This file checks for cross-site scripting(XSS) vulnerability
//---------------------------------------------------------------------------


	$fName = $lName = $eMail = $uName = $gender = $password = $conPasswrd = $captcha = "";
	$fNameErr = $lNameErr = $eMailErr = $uNameErr = $genderErr = $conPasswordErr = $captchaErr = "";
	$errFlag = 0; //If any error occures, this flag would be valued 1
//---------------------------------------------------------------------------


	if($_SERVER["REQUEST_METHOD"]=="POST"){ //Checking if the form was submitted as POST

		$fName = secureInput($_POST["firstName"]); //XSS vulnerability checking of input first name
		if(strlen($fName) > 255) {
			$fNameErr = "Maximum 255 characters allowed!"; 
			$errFlag = 1;
		}
		if(!preg_match("/^[a-zA-Z0-9]{1,255}$/", $fName)) { //Regular expression comparison
			//If input first name is invalid::
			$fNameErr = "Only letters allowed!"; 
			$errFlag = 1;
		}

	//-----------------------------------------------------------------------
		$lName = secureInput($_POST["lastName"]); //XSS vulnerability checking of input last name
		if(strlen($lName) > 255) {
			$lNameErr = "Maximum 255 characters allowed!"; 
			$errFlag = 1;
		}
		if(!preg_match("/^[a-zA-Z]{1,255}$/", $lName)) { //Regular expression comparison
			//If input last name is invalid::
			$lNameErr = "Only letters allowed!";
			$errFlag = 1;
		}

	//-----------------------------------------------------------------------
		$eMail = secureInput($_POST["email"]); //XSS vulnerability checking of input email
		if(strlen($eMail) > 255) {
			$eMailErr = "Maximum 255 characters allowed!"; 
			$errFlag = 1;
		}

		if(!filter_var($eMail, FILTER_VALIDATE_EMAIL)) { //Validating email using PHP's own function
			//If input email format is not valid::
			$eMailErr = "Invalid email format!"; 
			$errFlag = 1;
		}	
		elseif($errFlag == 0) { //If input length is OK::
			require '../model/checkExistingAccount.php'; //This file checks if the account [corresponding to the email] extsts or not
			foreach($result as $value) { //Traverse columns of the selected row
				if(count(array_filter($value)) > 0){ //If account exists...[count(array_filter($value)) gives the column numbers of the selected row. The row is empty if there is no column i.e. the account does not exist]
					$eMailErr = "Account exists!"; //notify the user...
					$errFlag = 1; //set error flag high
				}
			}
		}
		
	//-----------------------------------------------------------------------
		$uName = secureInput($_POST["userName"]); //XSS vulnerability checking of input username
		if(strlen($uName) > 255) {
			$uNameErr = "Maximum 255 characters allowed!"; 
			$errFlag = 1;
		}

		if(!preg_match("/^[a-zA-Z0-9_]{1,255}$/", $uName)) { //Regular expression comparison
			//If input username is invalid::
			$uNameErr = "Only letters, numbers and underscore(_) allowed!";
			$errFlag = 1;
		}
		elseif($errFlag == 0) { //If input length is OK::
			require '../model/checkUniqueUserName.php'; //This file checks if the username input by the user already exists or not
			foreach($result as $value){ //Traverse columns of the selected row
				if(count(array_filter($value)) > 0){ //If username already exists...
					$uNameErr = "Username already taken!"; //notify user...
					$errFlag = 1; //set error flag high
				}
			}
		}
		

	//-----------------------------------------------------------------------
		$password = secureInput($_POST["password"]); //XSS vulnerability checking of input password
		if(strlen($password) > 255) {
			$fNameErr = "Maximum 255 characters allowed!"; 
			$errFlag = 1;
		}
		require 'passwordValidation.php'; //This file validates the input password format
		

	//-----------------------------------------------------------------------
		$conPasswrd = secureInput($_POST["conPassword"]); //XSS vulnerability checking of input confirm password
		if(strlen($password) > 255) {
			$conPasswordErr = "Maximum 255 characters allowed!"; 
			$errFlag = 1;
		}
		if(!preg_match("/^[a-zA-Z0-9_]{1,255}$/", $conPasswrd)) { //Regular expression comparison
			$conPasswordErr = "Invalid format!";
			$errFlag = 1;
		}//Password hashing/encryption::
		elseif($password == $conPasswrd){ //If password & confirmation password are same...
			$password = password_hash($password, PASSWORD_DEFAULT); //hash the input password[default bcrypt]
		}
		elseif($conPasswordErr == ""){ //If input confirmation password doesn't match with input password::
			$errFlag = 1;
			$conPasswordErr = "Password doesn't match!";
		} //If password & confirmation password don't match, set error flag high
		
	
	//-----------------------------------------------------------------------
		$gender = $_POST['gender']; //Assigning gender value to the variable '$gender'


	//-----------------------------------------------------------------------
		if (isset($_SESSION["vercode"])) {
			$captcha = secureInput($_POST['captcha']);

			if(!preg_match("/^[a-zA-Z0-9]{1,6}$/", $captcha)) { //Regular expression comparison
				$captchaErr = "Invalid input!";
				$errFlag = 1;
			}
			if(strlen($captcha) > 6) {
				$captchaErr = "Invalid input!";
				$errFlag = 1;
			}
			elseif($captcha != $_SESSION["vercode"] OR $_SESSION["vercode"] == ""){ //$_SESSION["vercode"] == ""
				//If the captcha input is not correct or if the session 'vercode' does not contain any captcha::
				$captchaErr =  "Incorrect captcha code!";
				$errFlag = 1;
			}
			else{
				session_unset($_SESSION["vercode"]); //Unsetting session 'vercode' when captcha is confirmed
			}
		}
		
	}
//---------------------------------------------------------------------------

	//Check for if any required field is empty or there is any error::
	if (($fName == "" || $lName == "" || $eMail == "" || $uName == "" || $gender == "" || $password == "" || $conPasswrd == "") || $errFlag == 1) { }
	else{ //If everything is ok...
		$conPasswrd = ""; //Setting the unencrypted value of '$conPasswrd' to empty for security reason
		require '../model/registrationDatabase.php'; //If everything is ok, take the input values to registration database
	}
?>
