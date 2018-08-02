<html>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<?php
   ob_start();
   session_start();
?>
<?php require_once 'dbConfig.php'; ?>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title>ToDo App Register</title>
    </head>

    <body>
        <h3 class="w3-topbar"></h3>
        <h2 class="w3-margin-left">Register for ToDo!</h2>
        <h3 class="w3-bottombar"></h3>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h3 class="w3-margin-left">First Name</h3>
            <input class="w3-margin-left" id="fn" name="fn">
            <h3 class="w3-margin-left">Last Name</h3>
            <input class="w3-margin-left" id="ln" name="ln">
            <h3 class="w3-margin-left">Email</h3>
            <input class="w3-margin-left" id="email" name="email">
            <h3 class="w3-margin-left">User Name</h3>
            <input class="w3-margin-left" id="un" name="un">
            <h3 class="w3-margin-left">Password</h3>
            <input class="w3-margin-left" type="password" id="pwd" name="pwd">
            <h3 class="w3-margin-left">Confirm Password</h3>
            <input class="w3-margin-left" type="password" id="cpwd" name="cpwd">
            <h3 class="w3-margin-left">Company Code</h3>
            <input class="w3-margin-left" id="code" name="code">
            <br><br>
            <button class="w3-button w3-black w3-margin-left" type="submit" name="register"> Register</button>
        </form>
        <p class="w3-bottombar"></p>

        <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['register'])
                && !empty($_POST['fn'])
                && !empty($_POST['ln'])
                && !empty($_POST['email'])
                && !empty($_POST['un'])
                && !empty($_POST['pwd'])
                && !empty($_POST['cpwd'])
                && !empty($_POST['code'])) {

                $firstname = $_POST['fn'];
                $lastname = $_POST['ln'];
                $email = $_POST['email'];
                $username = $_POST['un'];
                $pass = $_POST['pwd'];
                $confpass = $_POST['cpwd'];
                $code = $_POST['code'];

                if(!validEmail($email)){
                    echo "<script type='text/javascript'>alert('Invalid email address');</script>";
                } elseif (existingUsername($username, $conn)) {
                    echo "<script type='text/javascript'>alert('Username is already taken');</script>";
                } elseif ($pass != $confpass) {
                    echo "<script type='text/javascript'>alert('Passwords do not match');</script>";
                } elseif (!existingCode($code, $conn)) {
                    echo "<script type='text/javascript'>alert('Company code does not exist');</script>";
                } else {

                    $sql = "INSERT INTO Employee(CompanyCode, LastName, FirstName, UserName, Email)
                        VALUES ('$code', '$lastname', '$firstname', '$username', '$email')";
                    $sql2 = "INSERT INTO UserInfo(CompanyCode, UserName, UserPassword)
                         VALUES ('$code', '$username', '$pass')";

                    $result = $conn->query($sql);
                    $result = $conn->query($sql2);

                    header("location: index.php");
                }
            } else {
                echo 'Please fill in all fields';
            }
        }
        function existingUsername($username, $conn) {
            $sql = "SELECT 1 FROM Employee WHERE `UserName` = '$username'";
            $result = $conn->query($sql);

            if ($result && mysqli_num_rows($result) > 0) {
                return true;
            }
            else{
                return false;
            }
        }

        function existingCode($code, $conn) {
            $sql = "SELECT 1 FROM Company WHERE `CompanyCode` = '$code'";
            $result = $conn->query($sql);

            if ($result && mysqli_num_rows($result) > 0) {
                return true;
            }
            else{
                return false;
            }
        }

        function validEmail($email){
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return true;
            } else {
                return false;
            }
        }
        ?>
    </body>
</html>
