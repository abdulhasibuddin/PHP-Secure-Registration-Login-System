<?php
	//This file checks if the data from the input field contains any cross-site scripting(XSS) vulnerability::
	//This file is required in 'forgotUsernamePassword2.php', 'loginPage2.php', 'registrationPage2.php', 'resetAccount2.php' & 'verificationPage2.php'

	function secureInput($data)
	{
		$data = trim($data); //removes whitespace and other predefined characters from both sides of a string.
		//$data = stripcslashes($data); //removes backslashes added by the addcslashes() function.
		//$data = stripslashes($data); //removes backslashes added by the addslashes() function.
		$data = htmlspecialchars($data); //converts some predefined characters to HTML entities.
		$data = strip_tags($data); //removes html & php tags

		return $data;
	}
?>
