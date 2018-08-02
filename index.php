<html>


<?php
   ob_start();
   session_start();
?>

<?php require_once 'dbConfig.php'; ?>

    <head>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <title>ToDo App</title>
    </head>
    <body>
  
    <h2 class="w3-topbar w3-bottombar w3-margin-left">Welcome to ToDo</h2>
	
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<h3 class="w3-margin-left">Username</h3>
		<input class="w3-margin-left" id="name" name="name">
	  
		<h3 class="w3-margin-left">Password</h3>
		<input class="w3-margin-left" type="password" name="pwd" id="pwd">
		 
		<h3 class="w3-margin-left">Company Code</h3>
		<input class="w3-margin-left" id="code" name="code">
	  
		<h3></h3>
		<button class="w3-button w3-black w3-margin-left" type="submit" name="login">Login</button>
	</form>
  
 

    <h3 class="w3-margin-left">New user?</h3>

    <form action="register.php">
        <input class="w3-button w3-black w3-margin-left" type="submit" value="Create account" name="register" />
    </form>
   
    <h3></h3>
  
    <p class="w3-bottombar"></p>
  
	<?php
	
	if(isset($_POST['create'])){
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
				
			$sql = "select * from UserInfo where UserName='$user' AND binary UserPassword='$pass' AND binary CompanyCode='$code'";
				            
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

                $sql = "select isAdmin from UserInfo WHERE username='$user' limit 1";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $isAdmin = $row['isAdmin'];
						
				session_start();
				$_SESSION['username'] = $user;
				$_SESSION['code'] = $code;
				$_SESSION['firstName'] = $firstName;
				$_SESSION['lastName'] = $lastName;
				$_SESSION['email'] = $email;
				$_SESSION['companyName'] = $companyName;
				$_SESSION['isAdmin'] = $isAdmin;
						
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