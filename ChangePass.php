<?PHP
	session_start();	
	$conn = oci_connect("system", "Dom546275", "//localhost/XE");
	if(empty($_SESSION['ID']) || empty($_SESSION['NAME']) || empty($_SESSION['SURNAME'])){
		echo '<script>window.location = "Login.php";</script>';
	}
	if (!$conn) {
		$m = oci_error();
		echo $m['message'], "\n";
		exit;
	} 
?>

Change Password
<hr>

<form action='ChangePass.php' method='post'>
	Password <br>
	<input name='password' type='password'><br><br>
	New Password<br>
	<input name='newpassword' type='password'><br>
	Confirm Password<br>
	<input name='confpassword' type='password'><br><br>
	<input name='submit' type='submit' value='Confirm'><br><br>
	<li><a href='MemberPage.php'>Back</a></li>
	
</form>

<?PHP
 
	if(isset($_POST['submit'])){
		$newpass = trim($_POST['newpassword']);
		$confpass = trim($_POST['confpassword']);
		$password = trim($_POST['password']);
		
		// Fetch each row in an associative array
		//$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
		
		/*echo $_SESSION['PASSWORD']."<br>";
		echo "ID : ".$_SESSION['ID']."<br>";
		echo "NAME : ".$_SESSION['NAME']."<br>";
		echo "SURNAME : ".$_SESSION['SURNAME']."<br>";*/
	
		if($newpass == $confpass && $newpass != NULL && $password == $_SESSION['PASSWORD']){			
			$query = "UPDATE LOGIN SET PASSWORD='$newpass' WHERE USERNAME = '".$_SESSION['USERNAME']."' and password = '$password'";
			$_SESSION['PASSWORD'] = $newpass;
			$parseRequest = oci_parse($conn, $query);
			oci_execute($parseRequest);
			//echo $_SESSION['PASSWORD'];
			echo 'Success!!';		
		}
		else{
			echo 'Error!!';
		}
	};
	oci_close($conn);
?>
