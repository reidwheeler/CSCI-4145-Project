<html>

<?php require_once 'dbConfig.php'; ?>

    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <title>ToDo App</title>
    </head>
    <body>
  
    <h2>Welcome to ToDo</h2>
	
	<form method="post">
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
    <form action="http://">
        <input type="submit" value="Create account" name="register" />
      </form>
   
    <h3></h3>
  
	<?php
	
	if (isset($_POST['login']) && !empty($_POST['name']) 
           && !empty($_POST['pwd']) 
		   && !empty($_POST['code'])) {
				
				$user = $_POST['name'];
			    $pass = $_POST['pwd'];
				$code = $_POST['code'];
				
				$sql = "select * from Company where UserName='$user' AND UserPassword='$pass' AND CompanyCode='$code'";
				            
				$result = $conn->query($sql);
				
				
					
				if ($result->num_rows == 1) { //login successfull
				
					

					session_start();
					$_SESSION['username'] = $user;
					$_SESSION['code'] = $code;
					header("location: home.php");	
               
				}else {
					echo 'Invalid Username or Password';
				}
		   
	}
	
				
				
				
				
	
	?>

  
  
    </body>
</html>