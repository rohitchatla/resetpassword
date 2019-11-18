<?php
include("config.php");
if(!isset($_GET["code"])){

	exit("Cant find page");
}
$code = $_GET["code"];
$getEmailQuery = mysqli_query($con, "SELECT email FROM resetpasswords WHERE code='$code'");
if(mysqli_num_rows($getEmailQuery) ==0){
	exit("Cant Find page");
}
if(isset($_POST["password"])){
	$pwd = $_POST["password"];
	$pwd = md5($pwd);
	$row = mysqli_fetch_array($getEmailQuery);
	$email = $row["email"];
	$query = mysqli_query($con, "UPDATE users SET password='$pwd' WHERE email='$email'");
	if($query) {
		$query= mysqli_query($con, "DELETE FROM resetPasswords WHERE code='$code'");
		exit("Password updated");

	}else{
		exit("Something went wrong");
	}



}


?>
<form action="" method="post">
	<input type="password" name="password" placeholder="New password">
   <br>
   <input type="submit" name="submit" placeholder="Update password">
	
</form>