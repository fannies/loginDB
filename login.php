<?PHP
	session_start();
	// Create connection to Oracle
	$conn = oci_connect("system", "Dom546275", "//localhost/XE");
	if (!$conn) {
		$m = oci_error();
		echo $m['message'], "\n";
		exit;
	} 
?>
Login form
<hr>

<?PHP
 
	if(isset($_POST['submit'])){
		$code = $_POST['code'];
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		$query = "SELECT * FROM LOGIN WHERE username='$username' and password='$password'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		// Fetch each row in an associative array
		$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
		if($row && $code == 'FANNIES'){
			$_SESSION['ID'] = $row['ID'];
			$_SESSION['NAME'] = $row['NAME'];
			$_SESSION['SURNAME'] = $row['SURNAME'];
			$_SESSION['USERNAME'] = $row['USERNAME'];
			$_SESSION['PASSWORD'] = $row['PASSWORD'];
			echo '<script>window.location = "MemberPage.php";</script>';
		}else{
			echo "Login fail.";
		}
	};
	oci_close($conn);
?>

<form action='login.php' method='post'>
	Username <br>
	<input name='username' type='input'><br>
	Password<br>
	<input name='password' type='password'><br><br>
	FANNIES<br>
	<input name='code' type='input'><br><br>
	<input name='submit' type='submit' value='Login'>
</form>
