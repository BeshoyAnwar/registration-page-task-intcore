<?php
session_start(); // session start
include("validate.php");
$filename = "myfile.jpg";
$_SESSION['email']=$filename ; // Session Set
?>
<?php
/* form.php */
	include'validate.php';
    session_start();
    $_SESSION['message'] = '';
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST['edit'])) {
			if(!empty($_POST['username'])){
				$username=$_POST['username'];
				$useremail=$GLOBALS['email'];
				$sql = "UPDATE users SET username='".$username."' WHERE email='".$useremail."'";
				echo $sql;
				require 'dbcontroller.php';
				$db_handle = new DBController();
				$db_handle->updateQuery($sql);
				$_SESSION['username']=$username;
			}
			if(!empty($_POST['emailnew'])){
				$newmail=$_POST['emailnew'];
				//$email=$_SESSION['email'];
				//$email=$_SESSION['email'];
				$sql = "UPDATE users SET email='".$newmail."' WHERE email='".$email."'";
				echo $sql;
				require 'dbcontroller.php';
				$db_handle = new DBController();
				$db_handle->updateQuery($sql);
				$_SESSION['email']=$newmail;
				$email=$newmail;
			}
		}
		
		
	}
?>


<link href="//db.onlinewebfonts.com/c/a4e256ed67403c6ad5d43937ed48a77b?family=Core+Sans+N+W01+35+Light" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="form.css" type="text/css">
<div class="body-content">
  <div class="module">
    <h1>Edit profile</h1>
	<h4>(provide only the fields that you want to edit them)</h4>
    <form class="form" action="edit.php" method="post" enctype="multipart/form-data" autocomplete="off">
      <div class="alert alert-error"><?= $_SESSION['message'] ?></div>
      <input type="text" placeholder="User Name" name="username"  />
      <input type="email" placeholder="Email" name="emailnew"  />
      <input type="password" placeholder="Old Password" name="oldpassword"  />
	  <input type="password" placeholder="New Password" name="newpassword" autocomplete="new-password"  />
      <input type="password" placeholder="Confirm New Password" name="confirmpassword" autocomplete="new-password"  />
      <div class="avatar"><label>Select your profile photo: </label><input type="file" name="avatar" accept="image/*"  /></div>
	  <input type="submit" value="Edit" name="edit" class="btn btn-block btn-primary" />
	  <input type="button" value="Back to profile" name="back" class="btn btn-block btn-primary" onClick="parent.location='welcome.php'"/>
      
    </form>
  </div>
</div>