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
			echo "<th>Due Date</th>";
			echo "<th></th>";
			echo "</tr>";
			
			if ($result->num_rows >= 1){
				while($row = $result->fetch_assoc()) {
					$id = $row['TaskID'];
					$idURL = urlencode($id);
					
					$task = $row['Title'];
					$taskURL  = urlencode($task);
					
					$from = $row['FromUser'];
					$fromURL  = urlencode($from);
					
					$to = $row['ToUser'];
					$toURL  = urlencode($to);
					
					$details = $row['Detail'];
					$detailsURL  = urlencode($details);
					
					$createTime = $row['CreateTime'];
					$createTimeURL  = urlencode($createTime);
					
					$deadline = $row['Deadline'];
					$deadlineURL  = urlencode($deadline);
					
					$pic = $row['PicturePath'];
					$picURL  = urlencode($pic);
					
					echo "<tr>";
					echo "<td>$id</td>";
					echo "<td>$from</td>";
					echo "<td>$to</td>";
					echo "<td>$task</td>";
					echo "<td>$deadline</td>";
					$url = "home.php?taskID=$idURL&taskName=$taskURL&from=$fromURL&to=$toURL&details=$detailsURL&createTime=$createTimeURL&deadline=$deadlineURL&pic=$picURL";
					echo "<td><a href=$url>Details</a></td>";			
					
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
	
	if (isset($_GET['taskID']) 
		&& isset($_GET['taskName'])
		&& isset($_GET['from'])
		&& isset($_GET['to'])
		&& isset($_GET['details'])
		&& isset($_GET['createTime'])
		&& isset($_GET['deadline'])
		&& isset($_GET['pic'])
		)
	{
		$_SESSION['username'] = $user;
		$_SESSION['code'] = $code;
		$_SESSION['firstName'] = $firstName;
		$_SESSION['lastName'] = $lastName;
		$_SESSION['email'] = $email;
		$_SESSION['companyName'] = $companyName;
		$_SESSION['taskID'] = $_GET['taskID'];
		$_SESSION['taskName'] = $_GET['taskName'];
		$_SESSION['fromUser'] = $_GET['from'];
		$_SESSION['toUser'] = $_GET['to'];
		$_SESSION['details'] = $_GET['details'];
		$_SESSION['createTime'] = $_GET['createTime'];
		$_SESSION['deadline'] = $_GET['deadline'];
		$_SESSION['pic'] = $_GET['pic'];
		
		header("location: EditTodo.php");
		
	}
	
	?>
	
	
	
</body>
</html>