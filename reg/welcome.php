<link rel="stylesheet" href="form.css">
<?php 
/* welcome.php */
session_start();
$_SESSION['message'] = '';
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		require 'dbcontroller.php';
		$db_handle = new DBController();
		if (isset($_POST['edit'])) {
			if(!empty($_POST['username'])){
				$username=$_POST['username'];
				$useremail=$_SESSION['email'];
				$sql = "UPDATE users SET username='".$username."' WHERE email='".$useremail."'";
				$db_handle->updateQuery($sql);
				$_SESSION['username']=$username;
			}
			if(!empty($_POST['emailnew'])){
				$newmail=$_POST['emailnew'];
				$useremail=$_SESSION['email'];
				$sql = "UPDATE users SET email='".$newmail."' WHERE email='".$useremail."'";
				//echo $sql;
				$db_handle->updateQuery($sql);
				$_SESSION['email']=$newmail;
				if(isset($_COOKIE["member_email"])){
					setcookie ("member_email",$newmail,time()+ (10 * 365 * 24 * 60 * 60));  
				}
			}
			if(!empty($_POST['oldpassword']) or !empty($_POST['newpassword']) or !empty($_POST['confirmpassword'])){
				if(!empty($_POST['oldpassword']) and !empty($_POST['newpassword']) and !empty($_POST['confirmpassword'])){
					$useremail=$_SESSION['email'];
					$sql = "SELECT * FROM users WHERE email='".$useremail."'";
					$result=$db_handle->runQuery($sql);
					$oldpassword=$result[0]['password'];
					if(md5($_POST['oldpassword'])==$oldpassword){
						if($_POST['newpassword']==$_POST['confirmpassword']){
							$newpassword=md5($_POST['newpassword']);
							$sql = "UPDATE users SET password='".$newpassword."' WHERE email='".$useremail."'";
							$db_handle->updateQuery($sql);
							if(isset($_COOKIE["member_password"])){  
								setcookie ("member_password",$_POST['newpassword'],time()+ (10 * 365 * 24 * 60 * 60));
							}  
						}
						else{
							$_SESSION['message'] = 'New password fields don\'t match!';
						}
					}
					else{
						$_SESSION['message'] = 'Old password is wrong!';
					}
				}
				else{
					$_SESSION['message'] = 'All password fields must be filled!';
				}
			}
			if($_FILES['avatar']['name']!=""){
				//path were our avatar image will be stored
				$avatar_path = 'images/'.$_FILES['avatar']['name'];
				//make sure the file type is image
				if (preg_match("!image!",$_FILES['avatar']['type'])) {
					
					//copy image to images/ folder 
					if (copy($_FILES['avatar']['tmp_name'], $avatar_path)){
						$useremail=$_SESSION['email'];
						$sql = "UPDATE users SET avatar='".$avatar_path."' WHERE email='".$useremail."'";
						$db_handle->updateQuery($sql);
						$_SESSION['avatar'] = $avatar_path;
					}
					else{
						$_SESSION['message'] = 'File upload failed!';
					}
				}
				else {
					$_SESSION['message'] = 'Please only upload GIF, JPG or PNG images!';
				}
			}	
			if(empty($_POST['username']) and empty($_POST['emailnew']) and empty($_POST['oldpassword']) and empty($_POST['newpassword']) and empty($_POST['confirmpassword']) and $_FILES['avatar']['name']==""){
				//if all are empty
				$_SESSION['message'] = 'All fields are empty!';
			}
		}
		
		
	}
//$_SESSION variables become available on this page 
?>


<div class="body content">
<input type="button" value="LogOut" name="logout" class="btn btn-logout btn-primary" onClick="parent.location='login.php'"  style="float: right;"/>

<div class="welcome">
	Welcome <span class="user"><?= $_SESSION['username']?></span>
    <img src="<?= $_SESSION['avatar']  ?>"><br />

</div>
</div>
<link href="//db.onlinewebfonts.com/c/a4e256ed67403c6ad5d43937ed48a77b?family=Core+Sans+N+W01+35+Light" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="form.css" type="text/css">
<div class="body-content">
  <div class="module">
    <h1>Edit profile</h1>
	<h4>(provide only the fields that you want to edit)</h4>
    <form class="form" action="welcome.php" method="post" enctype="multipart/form-data" autocomplete="off">
      <div class="alert alert-error"><?= $_SESSION['message'] ?></div>
      <input type="text" placeholder="User Name" name="username"  />
      <input type="email" placeholder="Email" name="emailnew"  />
      <input type="password" placeholder="Old Password" name="oldpassword"  />
	  <input type="password" placeholder="New Password" name="newpassword" autocomplete="new-password"  />
      <input type="password" placeholder="Confirm New Password" name="confirmpassword" autocomplete="new-password"  />
      <div class="avatar"><label>Select your profile photo: </label><input type="file" name="avatar" accept="image/*"  /></div>
	  <input type="submit" value="Edit" name="edit" class="btn btn-block btn-primary" />
      
    </form>
  </div>
</div>