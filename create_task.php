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
  header("location: home.php");
  exit;
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Task</title>
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
        <input type="submit" id="picButton" value="+">
        <br><br>
        <input type="submit" value="Save">
    </form>
</body>
</html>