<!-- ************************************************* -->
<!-- PHP "self" code handling e-mailing submit request -->
<!-- ************************************************* -->
<!-- Code remastered by cdesigner.eu along  -->

<?php
	// two variables for message and styling of the mesage with bootstrap
	$msg = '';
	$msgClass = '';

	// Control if data was submitted
	if(filter_has_var(INPUT_POST, 'submit')){
		// Data obtained from $_POST are assigned to local variables
		$name = htmlspecialchars($_POST['name']);
		$email = htmlspecialchars($_POST['email']);
		$message = htmlspecialchars($_POST['message']);

		// Controll if all required fields was written
		if(!empty($email) && !empty($name) && !empty($message)){
			// If check passed - all needed fields are written
			// Check if E-mail is valid
			if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
				// E-mail is not walid
				$msg = 'Please use a valid email';
				$msgClass = 'alert-danger';
			} else {
				// E-mail is ok
				$toEmail = 'ciljak@localhost.org'; //!!! e-mail address to send to - change for your needs!!!
				$subject = 'Contact Request From '.$name;
				$body = '<h2>Contact Request</h2>
					<h4>Name</h4><p>'.$name.'</p>
					<h4>Email</h4><p>'.$email.'</p>
					<h4>Message</h4><p>'.$message.'</p>
				';

				// Email Headers
				$headers = "MIME-Version: 1.0" ."\r\n";
				$headers .="Content-Type:text/html;charset=UTF-8" . "\r\n";

				// Additional Headers
				$headers .= "From: " .$name. "<".$email.">". "\r\n";

				if(mail($toEmail, $subject, $body, $headers)){
					// Email Sent
					$msg = 'Your e-mail has been sent';
					$msgClass = 'alert-success';
				} else {
					// Failed
					$msg = 'Your e-mail was not sent';
					$msgClass = 'alert-danger';
				}
			}
		} else {
			// Failed - if not all fields are fullfiled
			$msg = 'Please fill in all contactform fields';
			$msgClass = 'alert-danger'; // bootstrap format for allert message with red color
		}
	}
?>

<!-- **************************************** -->
<!-- HTML code containing Form for submitting -->
<!-- **************************************** -->
<!DOCTYPE html>
<html>
<head>
	<title>Contact Form</title>
	<link rel="stylesheet" href="./css/bootstrap.min.css"> <!-- bootstrap mini.css file -->
	<link rel="stylesheet" href="./css/style.css"> <!-- my local.css file -->
</head>
<body>
	<nav class="navbar navbar-default">
      <div class="container">
        <div class="navbar-header">    
          <a class="navbar-brand" href="index.php">Submit form example</a>
        </div>
      </div>
    </nav>
    <div class="container">	
    	<?php if($msg != ''): ?>
    		<div class="alert <?php echo $msgClass; ?>"><?php echo $msg; ?></div>
    	<?php endif; ?>
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	      <div class="form-group">
		      <label>Your Name:</label>
		      <input type="text" name="name" class="form-control" value="<?php echo isset($_POST['name']) ? $name : ''; ?>">
	      </div>
	      <div class="form-group">
	      	<label>Your e-mail:</label>
	      	<input type="text" name="email" class="form-control" value="<?php echo isset($_POST['email']) ? $email : ''; ?>">
	      </div>
	      <div class="form-group">
	      	<label>Please writte your mesage:</label>
	      	<textarea name="message" class="form-control"><?php echo isset($_POST['message']) ? $message : ''; ?></textarea>
	      </div>
	      <br>
	      <button type="submit" name="submit" class="btn btn-primary"> Send message ... </button>
      </form>
	</div>
	
	   <div class="footer"> 
          <a class="navbar-brand" href="https://cdesigner.eu"> Visit us on CDesigner.eu </a>
		</div>
      
</body>
</html>