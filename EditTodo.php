<!DOCTYPE html>

<?php
	// Initialize the session
	session_start();
	if(!isset($_SESSION['username']) || empty($_SESSION['username'])
		|| empty($_SESSION['lastName']) || !isset($_SESSION['lastName'])
		|| empty($_SESSION['code']) || !isset($_SESSION['code'])
		|| empty($_SESSION['firstName']) || !isset($_SESSION['firstName'])
		|| empty($_SESSION['email']) || !isset($_SESSION['email'])
		|| empty($_SESSION['companyName']) || !isset($_SESSION['companyName'])
		|| empty($_SESSION['taskID']) || !isset($_SESSION['taskID'])
		|| empty($_SESSION['taskName']) || !isset($_SESSION['taskName'])
		|| empty($_SESSION['fromUser']) || !isset($_SESSION['fromUser'])
		|| empty($_SESSION['toUser']) || !isset($_SESSION['toUser'])
		|| empty($_SESSION['details']) || !isset($_SESSION['details'])
		|| empty($_SESSION['createTime']) || !isset($_SESSION['createTime'])
		|| empty($_SESSION['deadline']) || !isset($_SESSION['deadline'])
		){
	  header("location: home.php");
	  exit;
	}
	/*
	echo $_SESSION['username'];
	echo $_SESSION['firstName'];
	echo $_SESSION['lastName'];
	echo $_SESSION['taskID'];
	echo $_SESSION['taskName'];
	echo $_SESSION['fromUser'];
	echo $_SESSION['toUser'];
	echo $_SESSION['details'];
	echo $_SESSION['createTime'];
	echo $_SESSION['deadline'];
	*/
	require_once 'dbConfig.php'; 
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Todo</title>
</head>
<body>
    <form>
        Title:<br>
        <input type="text" id="title">
        <br><br>
        Description:<br>
        <textarea rows="4" cols="50" id="description"></textarea>
        <br><br>
        Due Date:<br>
        <input type="date" id="dueDate">
        <br><br>
        Assignees (optional):<br>
        <select id="assigneeList">
            <option>Ted</option>
            <option>Jeff</option>
        </select>
        <br><br>
        Picture (optional):<br>
        <input type="file" name="filename" accept="image/gif, image/jpeg, image/png">
        <br><br>
        <input type="submit" value="Update & Save">
    </form>
</body>
</html>