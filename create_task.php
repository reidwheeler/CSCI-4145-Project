<!DOCTYPE html>


<html>

<?php
   ob_start();
   session_start();
?>
<?php require_once 'dbConfig.php'; ?>

    <head>
    <meta charset="UTF-8">
    <title>Create Task</title>
    </head>

    <body>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
    <h1>Create Task</h1><br>
    <h3>Title:</h3>
    <input type="text" name="title" id="title">
    <br><br>
    <h3>Description:</h3>
    <textarea rows="4" cols="50" name="description" id="description"></textarea>
    <br><br>
    <h3>Due Date:</h3>
    <input type="datetime-local" name="dueDate" id="dueDate" value="2018-07-31T19:30" min="2018-07-31T01:59" max="2118-12-31T23:59">
    <br><br>
    
    <h3>Assignees (optional):</h3><br>
    <?php
    $ccode = $_SESSION['code'];
    $sql = "SELECT * FROM Employee WHERE CompanyCode = '$ccode'";
    $result = $conn->query($sql);

    if ($result->num_rows >= 1){
        echo "<table>";
        while($row = $result->fetch_assoc()){
            $ln = $row['LastName'];
            $fn = $row['FirstName'];
            $id = $row['UserName'];
            echo "<tr>";
            echo "<td>$fn</td>";
            echo "<td>$ln</td>";
            //set the value of the check box to the username
            echo '<td><input type="checkbox" value = "'.$id.'" name = "assignees[]"></td>';
            echo "</tr>";
        }
        echo "</table>";
    }
    ?>

    <br><br>
    <h3>Picture (optional):</h3><br>
    <input type="file" name="img">
    <br><br>
    <input type="submit" name="ctask" value="Create Task">





    </form>

	<?php
	
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ctask']) && !empty($_POST['title'])) {
        $fuser = $_SESSION['username'];
        $title = $_POST['title'];
        $detail = $_POST['description'];
        //create time is current time
        $ctime = date("Y-m-d h:i");
        $dtime = $_POST['dueDate'];

         //randomly get a task id 

        $idselect=0;
        $tskid=rand();

         //check the id first 

        while($idselect==0){
            $sqlcheck = "SELECT * FROM Task WHERE TaskID='$tskid'";
            $tpres=$conn->query($sqlcheck);
            if($tpres->num_rows >= 1){
                $tskid=rand();
            }else{
                $idselect=1;
            }

            
        }
        $tmpimage = $_FILES['img']['tmp_name'];
        $imagename = $_FILES['img']['name'];
        $imagepath = "pic/".$imagename;

        //move the image to the pic folder
        move_uploaded_file($tmpimage, $imagepath);

        //for all users who are assgined, insert the data into db
        if(!empty($_POST['assignees'])){
            //get each value of the check box which is the username of that user and insert into db
            foreach($_POST['assignees'] as $tuser){
                $sql = "INSERT INTO Task VALUES('$tskid' ,'$fuser' ,'$tuser' ,'$title' ,'$detail' ,'$ctime' ,'$dtime' ,'$imagepath')";
                $insertesult = $conn->query($sql);
                
            }
        }
            //insert this user as touser into db
            $sql="INSERT INTO Task VALUES('$tskid' ,'$fuser' ,'$fuser' ,'$title' ,'$detail' ,'$ctime' ,'$dtime' ,'$imagepath')";
            $insertesult = $conn->query($sql);
        

        //return to home page
        header("location: home.php");
    }
	?>

  
  
    </body>
</html>
