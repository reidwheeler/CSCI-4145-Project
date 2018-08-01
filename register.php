<html>

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
        <h2>ToDo Register</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h3>First Name</h3>
            <input id="fn" name="fn">
            <h3>Last Name</h3>
            <input id="ln" name="ln">
            <h3>Email</h3>
            <input id="email" name="email">
            <h3>User Name</h3>
            <input id="un" name="un">
            <h3>Password</h3>
            <input type="password" id="pwd" name="pwd">
            <h3>Confirm Password</h3>
            <input type="password" id="cpwd" name="cpwd">
            <h3>Company Code</h3>
            <input id="code" name="code">
            <button type="submit" name="register"> Register</button>
        </form>

        <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST"
            && isset($_POST['register'])
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

            $sql = "INSERT INTO Employee(LastName, FirstName, UserName, UserPassword, Email)
                    VALUES ('$lastname', '$firstname', '$username', '$pass', '$email')";
            $sql2 = "INSERT INTO Company(CompanyCode, UserName, UserPassword)
                     VALUES ('$code', '$username', '$pass')";

            $result = $conn->query($sql);
            $result = $conn->query($sql2);

            header("location: index.php");
            }else {
                echo 'Invalid Username or Password';
            }
        ?>
    </body>
</html>
