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
	}
?>

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
