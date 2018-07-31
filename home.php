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

	require_once 'dbConfig.php'; 
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
</head>
<body>
    <h3>Company <?php echo htmlspecialchars($_SESSION['companyName']); ?></h3>
    <h1 id="homeTitle">Welcome to ToDo, <?php echo htmlspecialchars($_SESSION['firstName'])?> <?php echo htmlspecialchars($_SESSION['lastName']); ?>! </h1>
	
	<h3>Task List</h3>

	<div>
		<?php
		
			$user = $_SESSION['username'];
			$code = $_SESSION['code'];
			$firstName = $_SESSION['firstName'];
			$lastName = $_SESSION['lastName'];
			$email = $_SESSION['email'];
			$companyName = $_SESSION['companyName'];
		
			$sql = "select * from Task where FromUser='$user' OR ToUser='$user'";
			$result = $conn->query($sql);
			
			echo "<table>";
			echo "<tr>";
			echo "<th>Task ID</th>";
			echo "<th>From</th>";
			echo "<th>Assignees</th>";
			echo "<th>Task</th>";
			echo "<th></th>";
			echo "</tr>";
			
			if ($result->num_rows >= 1){
				while($row = $result->fetch_assoc()) {
					$id = $row['TaskID'];
					$task = $row['Title'];
					$from = $row['FromUser'];
					$to = $row['ToUser'];
					echo "<tr>";
					echo "<td>$id</td>";
					echo "<td>$from</td>";
					echo "<td>$to</td>";
					echo "<td>$task</td>";
					echo "<td>+</td>";
					echo "</tr>";
				}
			}
			echo "</table>";
		
		?>
	</div>
	
	<br/>
	
	<form method="post">
		<button name="addTask">+</button>
	</form>
	
	<br/>
	
	<form method="post">
		<button name="logout">Logout</button>
	</form>

	
	<?php
	
	$user = $_SESSION['username'];
	$code = $_SESSION['code'];
	$firstName = $_SESSION['firstName'];
	$lastName = $_SESSION['lastName'];
	$email = $_SESSION['email'];
	$companyName = $_SESSION['companyName'];
	
	if (isset($_POST['addTask'])){
		session_start();
		/*
		
		Not sure if we need to set these again?
		
		$_SESSION['username'] = $user;
		$_SESSION['code'] = $code;
		$_SESSION['firstName'] = $firstName;
		$_SESSION['lastName'] = $lastName;
		$_SESSION['email'] = $email;
		$_SESSION['companyName'] = $companyName;
		*/		
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
	
	function getTaskData()
	{
		$sql = "select * from Task where FromUser='$user' OR ToUser='$user'";
		$result = $conn->query($sql);				
		return $result;
	}
	
	?>
	
	
	
</body>
</html>