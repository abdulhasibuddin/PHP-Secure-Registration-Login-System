<?php 
	//require '../content/registrationPage2.php';
	//require '../content/passwordValidation.php';
?>
<!--This file generates the registration page front-end design::-->
<!DOCTYPE html>
<html>
<head>
	<title>Registration</title>

	<!--CSS design::-->
	<style type="text/css">
		#tableId{
			width: 65%;
			height: 500px;
			background-color: #f2f2f2;
			margin-left: 250px;
			padding-top: 20px;
			padding-bottom: 5px;
			border-radius: 25px;
		}

		#td1{
			padding-left: 5%;
		}

		#td2{

		}

		#error
		{
			color: red;
		}

		#footerId{
			text-align: center;
			margin-top: 30px;
			padding-top: 5px;
			height: 25px;
			width: 100%;
			background-color: grey;
		}

		#inputId{
			height: 25px; 
			width: 50%; 
			border-radius: 3px;
		}

		#pass_message{
			font-size: x-small;
			font-style: oblique;
		}
	</style>

</head>

<body>
	<h2 style="padding-left: 45%; color: #808080;">Registration Page</h2>

	
	<!--The following part needs to be loaded before the form section to use the variables declared and assigned in the file-->
	<?php
		//Declaring necessary variables with certain messages to show the user about the different characteristics that the input password should have::[default color of the messages is blue]
	    $pass_size_min = "<div style='color: blue;'>*Password should be atleast 8 characters!</div>";
	    $pass_size_max = "<div style='color: blue;'>*Password should not exceed 255 characters!</div>";
	    $pass_char_lower = "<div style='color: blue;'>*Password should contain atleast one lowercase character!</div>";
	    $pass_char_upper = "<div style='color: blue;'>*Password should contain atleast one uppercase character!</div>";
	    $pass_char_num = "<div style='color: blue;'>*Password should contain atleast one number!</div>";
	    $pass_char_spe = "<div style='color: blue;'>*No special character is permitted except (_)!</div>";
	    require '../content/registrationPage2.php';
	?>

	
	<!--'POST' method prevents data from exposing on the url bar-->
	<!--Don't use $_SERVER['PHP_SELF'] as it is vulnerable to Cross-Site Scripting(XSS)-->
	<!--If you have to use $_SERVER['PHP_SELF'], then use it as htmlspecialchars($_SERVER['PHP_SELF'])-->
	<form method="POST" action="" ><!--action="" refers to the self submission of this form-->

		<table id="tableId">
			<tr>
				<td id="td1">First Name: </td>
				<td id="td2">
					<input id="inputId" type="text" name="firstName" maxlength="255" title="maximum 255 characters" value="<?php echo $fName; ?>" required autofocus><!--First name input area-->
					<span id="error">* <?php echo $fNameErr; ?></span><!--Error messages related to first name-->
				</td>
			</tr>
<?//---------------------------------------------------------------------------------------------------------------------------?>

			<tr>
				<td id="td1">Last Name: </td>
				<td id="td2">
					<input id="inputId" type="text" name="lastName" maxlength="255" title="maximum 255 characters" value="<?php echo $lName; ?>" required><!--Last name input area-->
					<span id="error">* <?php echo $lNameErr; ?></span><!--Error messages related to last name-->
				</td>
			</tr>
<?//---------------------------------------------------------------------------------------------------------------------------?>

			<tr>
				<td id="td1">E-mail: </td>
				<td id="td2">
					<input id="inputId" type="E-mail" name="email" maxlength="255" title="maximum 255 characters" value="<?php echo $eMail; ?>" required><!--Email input area-->
					<span id="error">* <?php echo $eMailErr; ?></span><!--Error messages related to email-->
				</td>
			</tr>
<?//---------------------------------------------------------------------------------------------------------------------------?>

			<tr>
				<td id="td1">Username: </td>
				<td id="td2">
					<input id="inputId" type="text" name="userName" maxlength="255" title="maximum 255 characters" value="<?php echo $uName; ?>" required><!--Username input area-->
					<span id="error">* <?php echo $uNameErr; ?></span><!--Error messages related to username-->
				</td>
			</tr>
<?//---------------------------------------------------------------------------------------------------------------------------?>

			<tr>
				<td id="td1">Password: </td>
				<td id="td2">
					<input id="inputId" type="password" name="password" maxlength="255" title="maximum 255 characters" required><!--Password input area-->
					<span id="error">*</span>
				</td>
			</tr>
			<?//---------------------------------------------------------------------------------------------------------------?>

			<tr><td></td>
				<td>
					<span id="pass_message"><?php echo $pass_size_min; ?></span>
					<span id="pass_message"><?php echo $pass_size_max; ?></span>
                    <span id="pass_message"><?php echo $pass_char_lower; ?></span>
                    <span id="pass_message"><?php echo $pass_char_upper; ?></span>
                    <span id="pass_message"><?php echo $pass_char_num; ?></span>
                    <span id="pass_message"><?php echo $pass_char_spe; ?></span>
				</td>
			</tr>
<?//---------------------------------------------------------------------------------------------------------------------------?>

			<tr>
				<td id="td1">Confirm Password: </td>
				<td id="td2">
					<input id="inputId" type="password" name="conPassword" maxlength="255" title="maximum 255 characters" required><!--Confirmation password input area-->
					<span id="error">* <?php echo $conPasswordErr; ?></span><!--Error messages related to confirmation password-->
				</td>
			</tr>
<?//---------------------------------------------------------------------------------------------------------------------------?>

			<tr>
				<td id="td1">Gender:
					<span id="error">* </span>
				</td id="td2">
			</tr>
			<?//---------------------------------------------------------------------------------------------------------------?>

			<tr>
				<td id="td1" style="padding-left: 200px;">
					<input type="radio" name="gender" value="male" required>Male <!--Gender input area [if male]-->
				</td>
			</tr>
			<?//---------------------------------------------------------------------------------------------------------------?>

			<tr>
				<td id="td1" style="padding-left: 200px;">
					<input type="radio" name="gender" value="female">Female <!--Gender input area [if female]-->
				</td>
			</tr>
<?//---------------------------------------------------------------------------------------------------------------------------?>

			<tr>
				<td id="td1"><img src="../content/captcha.php"></td><!--Captcha image area-->
				<td id="td2"> <span id="error"><?php echo $captchaErr; ?></span></td><!--Error messages related to captcha code-->
			</tr>
			<?//---------------------------------------------------------------------------------------------------------------?>

			<tr>
				<td id="td1">Enter captcha: </td>
				<td id="td2"><input id="inputId" type="text" name="captcha" maxlength="6" required/></td><!--Captcha code input area-->
			</tr>
<?//---------------------------------------------------------------------------------------------------------------------------?>

			<tr>
				<td id="td1">
					<h6 style="color: red">*Required field</h6>
				</td>
				<?//-----------------------------------------------------------------------------------------------------------?>

				<td id="td2">
					<input type="submit" value="Submit" style="height: 40px; width: 80px; border-radius: 3px;"><!--Submit button-->
				</td>
			</tr>
		</table>

		<footer id="footerId">Already have an account? Login <a href="loginPage.php"><strong>here</strong></a></footer><!--Link to the login page-->	
	</form>
</body>
</html>
