<?php
/* validate.php */
global $email ;
$_SESSION['email']="";
//the form has been submitted with post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['register'])) {
		//two passwords are equal to each other
		if ($_POST['password'] == $_POST['confirmpassword']) {
			
			//define other variables with submitted values from $_POST
			$username = $_POST['username'];
			
			$GLOBALS['email']= $_POST['email'];
			$findmail=$db_handle->findmail($email);
			$password = md5($_POST['password']);
			$avatar_path = 'images/'.$_FILES['avatar']['name'];
			if(!$findemail) {
			//make sure the file type is image
				if (preg_match("!image!",$_FILES['avatar']['type'])) {
					
					//copy image to images/ folder 
					if (copy($_FILES['avatar']['tmp_name'], $avatar_path)){
						
						//set session variables to display on welcome page
						$_SESSION['username'] = $username;
						$_SESSION['avatar'] = $avatar_path;
						$_SESSION['email'] = $email;
						//insert user data into database
						$sql = 
						"INSERT INTO users (username, email, password, avatar) "
						. "VALUES ('$username', '$email', '$password', '$avatar_path')";
						$_SESSION['message'] = "Registration succesful!";
						header( "location: login.php" );
						if($db_handle->insertQuery($sql))
						{
							/* sending email */
							/*   //$base_url = "http://localhost/tutorial/email-address-verification-script-using-php/";
							   $mail_body = "
							   <p>Hi ".$username.",</p>
							   <p>Thanks for Registration.</p>
							   <p>Best Regards</p>";
							   require 'class/class.phpmailer.php';
							   $mail = new PHPMailer;
							   $mail->IsSMTP();        //Sets Mailer to send message using SMTP
							   $mail->Host = 'smtpout.secureserver.net';  //Sets the SMTP hosts of your Email hosting, this for Godaddy
							   $mail->Port = '80';        //Sets the default SMTP server port
							   $mail->SMTPAuth = true;       //Sets SMTP authentication. Utilizes the Username and Password variables
							   $mail->Username = 'xxxxxxxx';     //Sets SMTP username
							   $mail->Password = 'xxxxxxxx';     //Sets SMTP password
							   $mail->SMTPSecure = '';       //Sets connection prefix. Options are "", "ssl" or "tls"
							   $mail->From = 'Admin@admin.com';   //Sets the From email address for the message
							   $mail->FromName = 'Admin';     //Sets the From name of the message
							   $mail->AddAddress($email,$username);  //Adds a "To" address   
							   $mail->WordWrap = 50;       //Sets word wrapping on the body of the message to a given number of characters
							   $mail->IsHTML(true);       //Sets message type to HTML    
							   $mail->Subject = 'Sucessful Email Registeration';   //Sets the Subject of the message
							   $mail->Body = $mail_body;       //An HTML or plain text message body
							   if($mail->Send())        //Send an Email. Return true on success or false on error
							   {
								$message = '<label class="text-success">Register Done, Please check your mail.</label>';
							   }*/
							ini_set("SMTP","ssl://smtp.gmail.com");
							ini_set("smtp_port","465");
							$_SESSION['message'] = "Registration succesful!";
							//send email to user to thank him
							$subject = "Registeration successful";
							$content = "Dear $username,\r\nThanks for your registeration";
							$mailHeaders = "From: Admin\r\n";
							if(mail($email, $subject, $content, $mailHeaders)){$_SESSION['message'] = 'Email is sent';}
						}
							  
					}
					else {
						$_SESSION['message'] = 'File upload failed!';
					}
				}
				else {
					$_SESSION['message'] = 'Please only upload GIF, JPG or PNG images!';
				}
			}
			else {
				$_SESSION['message'] = "User Email is already in use!";
			}
		}
		else {
			$_SESSION['message'] = 'Two passwords do not match!';
		}
	}
	if (isset($_POST['login'])) {
		 header( "location: login.php" );
	}
} //if ($_SERVER["REQUEST_METHOD"] == "POST")
?>
