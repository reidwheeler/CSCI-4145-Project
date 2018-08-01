<html>


<?php
   ob_start();
   session_start();
?>

<?php require_once 'dbConfig.php'; ?>

    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <title>ToDo App</title>
    </head>
    <body>
  
    <h2>Welcome to ToDo</h2>
	
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<h3>Username</h3>
		<input id="name" name="name">
	  
		<h3>Password</h3>
		<input type="password" name="pwd" id="pwd">
		 
		<h3>Company Code</h3>
		<input id="code" name="code">
	  
		<h3></h3>
		<button type="submit" name="login">Login</button>
	</form>
  
 

    <h3>New user?</h3>
    <form method="post">
        <button type="submit" name="register">Register</button>
    </form>
   
    <h3></h3>
  
	<?php
	
	if(isset($_POST['register'])){
		header('location: register.php');
	}
	
	if ($_SERVER["REQUEST_METHOD"] == "POST"
		   && isset($_POST['login']) 
		   && !empty($_POST['name']) 
           && !empty($_POST['pwd']) 
		   && !empty($_POST['code'])) {					
				
			$user = $_POST['name'];
			$pass = $_POST['pwd'];
			$code = $_POST['code'];
				
			$sql = "select * from UserInfo where UserName='$user' AND UserPassword='$pass' AND CompanyCode='$code'";
				            
			$result = $conn->query($sql);					
					
			if ($result->num_rows == 1) { //login successfull
				
				$sql = "SELECT FirstName FROM Employee WHERE username='$user' limit 1";
				$result = $conn->query($sql);
				$row = $result->fetch_assoc();
				$firstName = $row['FirstName'];
						
						
				$sql = "SELECT LastName FROM Employee WHERE username='$user' limit 1";
				$result = $conn->query($sql);
				$row = $result->fetch_assoc();
				$lastName = $row['LastName'];
						
						
				$sql = "SELECT Email FROM Employee WHERE username='$user' limit 1";
				$result = $conn->query($sql);
				$row = $result->fetch_assoc();
				$email = $row['Email'];

							
				$sql = "select CompanyName from Company where CompanyCode='$code' limit 1";
				$result = $conn->query($sql);
				$row = $result->fetch_assoc();
				$companyName = $row['CompanyName'];
						
				session_start();
				$_SESSION['username'] = $user;
				$_SESSION['code'] = $code;
				$_SESSION['firstName'] = $firstName;
				$_SESSION['lastName'] = $lastName;
				$_SESSION['email'] = $email;
				$_SESSION['companyName'] = $companyName;
						
				if (mysqli_error($_SESSION)) {
					die(mysqli_error($_SESSION));
				}
				header("location: home.php");	
			}else {
				echo 'Invalid Username or Password';
			}	
		   
	}			
	
	?>
  
    </body>
</html>