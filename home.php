<!DOCTYPE html>

<?php
// Initialize the session
session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username'])
	|| empty($_SESSION['lastName']) || !isset($_SESSION['lastName'])
	|| empty($_SESSION['code']) || !isset($_SESSION['code'])
	|| empty($_SESSION['firstName']) || !isset($_SESSION['firstName'])
	|| empty($_SESSION['email']) || !isset($_SESSION['email'])
	|| empty($_SESSION['companyName']) || !isset($_SESSION['companyName'])){
  header("location: index.php");
  exit;
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
</head>
<body>
    <h3>Company <?php echo htmlspecialchars($_SESSION['companyName']); ?></h3>
    <h1 id="homeTitle">Welcome to ToDo, <?php echo htmlspecialchars($_SESSION['firstName'])?> <?php echo htmlspecialchars($_SESSION['lastName']); ?>! </h1>
	<form method="post">
		<button name="addTask">+</button>
	</form>
	
    <ol id="taskList">
        <li>Task 1</li>
        <li>Task 2</li>
    </ol>
	
	<form method="post">
		<button name="logout">Logout</button>
	</form>

	
	<?php
	
	if (isset($_POST['addTask'])){
		session_start();
		$_SESSION['username'] = $user;
		$_SESSION['code'] = $code;
		$_SESSION['firstName'] = $firstName;
		$_SESSION['lastName'] = $lastName;
		$_SESSION['email'] = $email;
		$_SESSION['companyName'] = $companyName;
					
		if (mysql_error()) {
			die(mysql_error());
		}
		header("location: create_task.php");	
	}
	
	if (isset($_POST['logout'])){
		
		unset($_SESSION['username']);
		unset($_SESSION['code']);
		unset($_SESSION['firstName']);
		unset($_SESSION['lastName']);
		unset($_SESSION['email']);
		unset($_SESSION['companyName']);
	   
	   header('Refresh: 2; URL = index.php');
	}
	
	?>
	
	
	
</body>
</html>