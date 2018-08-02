<!DOCTYPE html>

<?php
	// Initialize the session
	session_start();
	ob_start();
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

	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <meta charset="UTF-8">
    <title>Home</title>
	
	<style>
	.onTime {
		color: black;
	}
	
	.overdue {
		color: red;
	}
	</style>
	
</head>
<body>
	<h3 class="w3-topbar"></h3>
    <h3 class="w3-margin-left">Company <?php echo htmlspecialchars($_SESSION['companyName']); ?></h3>
    <h3 class="w3-bottombar"></h3>
	<h1 id="homeTitle" class="w3-panel" color="#ccc">Welcome to ToDo, <?php echo htmlspecialchars($_SESSION['firstName'])?> <?php echo htmlspecialchars($_SESSION['lastName']); ?>! </h1>
	<h3 class="w3-panel w3-green">Task List</h3>

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
			
			echo "<table class=\"w3-table w3-bordered w3-striped\">";
			echo "<tr>";
			echo "<th>Task ID</th>";
			echo "<th>From</th>";
			echo "<th>Assignees</th>";
			echo "<th>Task</th>";
			echo "<th>Due Date</th>";
			echo "<th></th>";
            echo "<th></th>";
			echo "</tr>";
			
			if ($result->num_rows >= 1){
				while($row = $result->fetch_assoc()) {
					
					$class="onTime";
					
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
					$deadline = strtotime($deadline);
					
					$time = time();
					$isOverdue = $time - $deadline;
					
					if($isOverdue>=0){
						$class = "overdue";
					}
					
					$deadline = date("Y-m-d", $deadline);		
					$deadlineURL  = urlencode($deadline);
					
					$pic = $row['PicturePath'];
					$picURL  = urlencode($pic);
					
					echo "<tr>";
					echo "<td class=$class>$id</td>";
					echo "<td class=$class>$from</td>";
					echo "<td class=$class>$to</td>";
					echo "<td class=$class>$task</td>";
					echo "<td class=$class>$deadline</td>";
					$url = "home.php?taskID=$idURL&taskName=$taskURL&from=$fromURL&to=$toURL&details=$detailsURL&createTime=$createTimeURL&deadline=$deadlineURL&pic=$picURL";
					echo "<td><a href=$url><button class = \"w3-button w3-round w3-black\" name=\"addTask\">Details</button></a></td>";
					if($_SESSION['username'] == $from){
                        $deleteTaskID = urlencode($id);
                        $url = "home.php?deleteTaskID=$deleteTaskID";
                        echo "<td><a href=$url><button class = \"w3-button w3-round w3-black\" name=\"deleteTask\">Delete</button></a></td>";
                    }
                    else{
                        echo "<td></td>";
                    }
					
					echo "</tr>";
				}
			}
			echo "</table>";
?>
	</div>
	
	<br/>
	
	<form method="post">
		<button name="addTask" class = "w3-circle w3-button w3-black w3-margin-left">+</button>
	</form>
	
	<br/>
	
	<form method="post">
		<button name="logout" class = " w3-margin-left w3-button w3-black">Logout</button>
	</form>

    <?php
        if($_SESSION['isAdmin'] == true){
            $url = "DeleteUser.php?";
			echo "<br/>";
            echo "<a href=$url><input class = \" w3-margin-left w3-button w3-black\" type=\"button\" value=\"Delete Users\"></a>";
        }
    ?>
	
	<?php
	
	$user = $_SESSION['username'];
	$code = $_SESSION['code'];
	$firstName = $_SESSION['firstName'];
	$lastName = $_SESSION['lastName'];
	$email = $_SESSION['email'];
	$companyName = $_SESSION['companyName'];
	
	if (isset($_POST['addTask'])){
		
		$_SESSION['username'] = $user;
		$_SESSION['code'] = $code;
		$_SESSION['firstName'] = $firstName;
		$_SESSION['lastName'] = $lastName;
		$_SESSION['email'] = $email;
		$_SESSION['companyName'] = $companyName;

    if (mysqli_error($_SESSION)) {
        die(mysqli_error($_SESSION));
    }

		sleep(1);
		header("location: create_task.php");	
	}
	
	if (isset($_POST['logout'])){
		
		unset($_SESSION['username']);
		unset($_SESSION['code']);
		unset($_SESSION['firstName']);
		unset($_SESSION['lastName']);
		unset($_SESSION['email']);
		unset($_SESSION['companyName']);
	   
	   header('Refresh: 0.1; URL = index.php');
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
		$_SESSION['taskID'] = urldecode($_GET['taskID']);
		$_SESSION['taskName'] = urldecode($_GET['taskName']);
		$_SESSION['fromUser'] = urldecode($_GET['from']);
		$_SESSION['toUser'] = urldecode($_GET['to']);
		$_SESSION['details'] = urldecode($_GET['details']);
		$_SESSION['createTime'] = urldecode($_GET['createTime']);
		$_SESSION['deadline'] = urldecode($_GET['deadline']);
		$_SESSION['pic'] = urldecode($_GET['pic']);
		
		header("location: edittask.php");
		
	}
	if (isset($_GET['deleteTaskID'])){
        $taskToDelete = $_GET['deleteTaskID'];
        //delete the task from the DB
        $sql = "DELETE a.* 
            FROM Task a
            WHERE a.TaskID='$taskToDelete'";
        $result = $conn->query($sql);
        header("location: home.php");
    }
	
	?>
	<p class="w3-bottombar"></p>
	
	
	
</body>
</html>