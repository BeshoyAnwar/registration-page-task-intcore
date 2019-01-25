<?php
/* form.php */
    session_start();
    $_SESSION['message'] = '';
	require_once("dbcontroller.php");
	$db_handle = new DBController();
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$email = $_POST['email'];
		$_SESSION['email']=$email;
		$password = md5($_POST['password']);
		$findemail=False;
		$query = "SELECT * FROM users where email = '" . $email . "'";
		$result=$db_handle->getdata($query);
		if($result[0]==1){ 
			$username=$result[1][0]['username'];
			$avatar=$result[1][0]['avatar'];
			$_SESSION['avatar']=$avatar;
			$_SESSION['username']=$username;
			if($password==$result[1][0]['password']){
			   if(!empty($_POST["remember"]))   
			   {  
				setcookie ("member_email",$email,time()+ (10 * 365 * 24 * 60 * 60));  
				setcookie ("member_password",$_POST['password'],time()+ (10 * 365 * 24 * 60 * 60));
			   }  
			   else  
			   {  
				if(isset($_COOKIE["member_email"]))   
				{  
				 setcookie ("member_email","");  
				}  
				if(isset($_COOKIE["member_password"]))   
				{  
				 setcookie ("member_password","");  
				}  
			   }  
			   //require 'validate.php';
			   header("location:welcome.php");
			}
			else{
				$_SESSION['message']="Password wrong";
			}
		}	
		else{
			$_SESSION['message']="Email is not registered";
		}	
	
?>
# registration-page-task-intcore
## Features
1-Registration page with following data: name, email, password, photo.<br />
2-Password should be *Hashed* and validations is provided.<br />
3-Login form with email and password addition to remember me checkbox.<br />
4-After login is done then redirecting to update profile page to update all information name, email, password, photo.<br />
5-User can logout from his account.<br />
## Used Tools
Task is implemented via php and mysql database using xampp sever.
## How to start
1-Setup [xampp](http://mrbool.com/how-to-install-xampp-server-in-windows/28257)<br />
2-Create in the mysql accounts database,you may set a password and change it in dbcontroller.php file<br />
3-Download[Souce code] and put it in the path:"c:\xampp\htdoc\"<br />
4-from any browser goto "http://localhost/reg/form.php"<br />
Registration page with following data [name, email, password, photo] with login form with email and password addition to remember me checkbox implemented using php and mysql database
registeration-page-task-intcore




<link href="//db.onlinewebfonts.com/c/a4e256ed67403c6ad5d43937ed48a77b?family=Core+Sans+N+W01+35+Light" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="form.css" type="text/css">
<div class="body-content">
  <div class="module">
    <h1>LogIn</h1>
    <form class="form" action="login.php" method="post" enctype="multipart/form-data" autocomplete="off">
      <div class="alert alert-error"><?= $_SESSION['message'] ?></div>
      <input type="email" placeholder="Email" name="email" required value="<?php if(isset($_COOKIE["member_email"])) { echo $_COOKIE["member_email"]; } ?>"/>
      <input type="password" placeholder="Password" name="password" autocomplete="new-password" required value="<?php if(isset($_COOKIE["member_password"])) { echo $_COOKIE["member_password"]; } ?>"/>
	  <div class="form-group">  
     <input type="checkbox" name="remember" <?php if(isset($_COOKIE["member_email"])) { ?> checked <?php } ?> />  
     <label for="remember-me">Remember me</label>  
    </div>
	  <input type="submit" value="Login" name="loginbtn" class="btn btn-block btn-primary" />
	  <input type="button" value="Don't have an account(Register)" name="register" class="btn btn-block btn-primary" onClick="parent.location='form.php'"/>
    </form>
  </div>
</div>