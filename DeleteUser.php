<!DOCTYPE html>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<?php
// Initialize the session
session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username'])
    || empty($_SESSION['lastName']) || !isset($_SESSION['lastName'])
    || empty($_SESSION['code']) || !isset($_SESSION['code'])
    || empty($_SESSION['firstName']) || !isset($_SESSION['firstName'])
    || empty($_SESSION['email']) || !isset($_SESSION['email'])
    || empty($_SESSION['companyName']) || !isset($_SESSION['companyName'])
    || empty($_SESSION['isAdmin']) || !isset($_SESSION['isAdmin'])
    || $_SESSION['isAdmin'] == false){
    header("location: home.php");
    exit;
}

require_once 'dbConfig.php';
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete User</title>
</head>
<body>
<h3 class="w3-topbar"></h3>
<h2 class="w3-margin-left">Users In <?php echo htmlspecialchars($_SESSION['companyName']); ?>'s System</h2>
<h3 class="w3-bottombar"></h3>
<br>

<table id="userTable">
    <tr>
        <th>Username</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Delete?</th>
    </tr>

    <div>
        <?php

        $user = $_SESSION['username'];
        $code = $_SESSION['code'];
        $firstName = $_SESSION['firstName'];
        $lastName = $_SESSION['lastName'];

        $sql = "select UserInfo.UserName, Employee.FirstName, Employee.LastName
            from UserInfo 
            INNER JOIN Employee ON UserInfo.UserName=Employee.UserName 
            WHERE 
              UserInfo.CompanyCode = '$code' 
              && Employee.companyCode = '$code'
              && UserInfo.isAdmin = 'False'"; // don't print admins
        $result = $conn->query($sql);
        if (!$result) {
            echo "nahh";
            trigger_error('Invalid query: ' . $conn->error);
        }
        if ($result->num_rows >= 1){
            while($row = $result->fetch_assoc()) {
                $username = $row['UserName'];
                $usernameURL = urlencode($username);

                //watch out for upper/lower case with this one...
                $firstname = $row['FirstName'];
                $firstnameURL = urlencode($firstname);

                $lastname = $row['LastName'];
                $lastnameURL = urlencode($lastname);

                echo "<tr>";
                echo "<td>$username</td>";
                echo "<td>$firstname</td>";
                echo "<td>$lastname</td>";
                $url = "DeleteUser.php?UserName=$usernameURL&FirstName=$firstnameURL&LastName=$lastnameURL";
                echo "<td><a href=$url><input class=\"w3-button w3-red w3-margin-left\" type=\"button\" value=\"Delete This User\"></a></td>";
                echo "</tr>";
            }
        }
        ?>
</table>
<br>
</div>
<br>
<?php
$url = "home.php";
echo"<a href=$url><input class=\"w3-button w3-black w3-margin-left\"type=\"button\" value=\"Return Home\">";
?>

<?php
$user = $_SESSION['username'];
$code = $_SESSION['code'];
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
$email = $_SESSION['email'];
$companyName = $_SESSION['companyName'];

if (isset($_GET['UserName'])
    && isset($_GET['FirstName'])
    && isset($_GET['LastName'])
)
{
    $userToDelete = $_GET['UserName'];

    
    //delete the user's tasks from the DB
    $sql = "DELETE a.* 
            FROM Task a
            WHERE a.FromUser = '$userToDelete' OR a.ToUser = '$userToDelete'";
    $result = $conn->query($sql);

    //delete the user from the DB
    $sql = "DELETE a.*, b.* 
            FROM Employee a 
            LEFT JOIN UserInfo b 
            ON b.UserName = a.UserName 
            WHERE a.UserName = '$userToDelete'";
    $result = $conn->query($sql);
    header("location: DeleteUser.php");
}
?>

</body>
</html>