<!DOCTYPE html>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<html>

<?php
   ob_start();
   session_start();
?>
<?php require_once 'dbConfig.php'; ?>

    <head>
    <meta charset="UTF-8">
    <title>Edit Task</title>
    </head>

    <body>
    <h3 class="w3-topbar"></h3>
    <h2 class="w3-margin-left">Edit Task</h2>
    <h3 class="w3-bottombar"></h3>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h3 class="w3-margin-left">Title</h3>
        <!--show the current title, description and due date for this task in the type field-->
        <input class="w3-margin-left" type="text" name="title" id="title" value= "<?php echo htmlspecialchars($_SESSION['taskName']); ?>" />
        <br><br>
        <h3 class="w3-margin-left">Description</h3>
        <textarea class="w3-margin-left" rows="4" cols="50" name="description" id="description" ><?php echo htmlspecialchars($_SESSION['details']); ?></textarea>
        <br><br>
        <h3 class="w3-margin-left">Due Date</h3>
        <input class="w3-margin-left" type="datetime-local" name="dueDate" id="dueDate"
         value="<?php
         $tid = $_SESSION['taskID'];
         $sqq="SELECT * FROM Task WHERE TaskID = '$tid'";
         $tm=$conn->query($sqq);
        while($roww=$tm->fetch_array()){
            $tt=str_replace(" ", "T" ,$roww[6]);
        }echo htmlspecialchars($tt)?>">
        <br><br>
        <h3 class="w3-margin-left">Assignees</h3>
        <?php
        $ccode = $_SESSION['code'];
        $sql = "SELECT * FROM Employee WHERE CompanyCode = '$ccode'";
        $result = $conn->query($sql);

        if ($result->num_rows >= 1){
            echo "<table class=\"w3-margin-left w3-border\">";
            while($row = $result->fetch_assoc()){
                $ln = $row['LastName'];
                $fn = $row['FirstName'];
                $id = $row['UserName'];
                echo "<tr>";
                echo "<td>$fn</td>";
                echo "<td>$ln</td>";
                //set the check box to checked state for users who are assgined by this task
                $tmpid=$_SESSION['taskID'];
                $tmpsql= "SELECT * FROM Task WHERE ToUser='$id' AND TaskID='$tmpid'";
                $tmpresult = $conn->query($tmpsql);
                if($tmpresult->num_rows >= 1){
                    echo '<td><input type="checkbox" value = "'.$id.'" name = "assignees[]" checked></td>';
                }else{
                    echo '<td><input type="checkbox" value = "'.$id.'" name = "assignees[]"></td>';
                }

                echo "</tr>";
            }
            echo "</table>";
        }
        ?>
        <br>
        <h3 class="w3-margin-left">Picture</h3>
        <?php
            $tid = $_SESSION['taskID'];
            $displayimg="SELECT * FROM Task WHERE TaskID = '$tid' LIMIT 1";
            $tmpp=$conn->query($displayimg);

            $curimg=$tmpp->fetch_array();
            echo "<img class=\"w3-margin-left\" height='300' width='300' src='".$curimg[7]."' >";
        ?>
        <br><br>
        <h3 class="w3-margin-left">Picture URL (optional)</h3>
        <input class="w3-margin-left" type="text" name="img" value="<?php echo $curimg[7]; ?>">
        <br><br>

        <input class="w3-button w3-black w3-margin-left" type="submit" name="ctask" value="Done">
    </form>

	<?php
	
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ctask']) && !empty($_POST['title']) && !empty($_POST['assignees'])) {

        /*
        we could use update for editting date in db, but i dont know how to check 
        a touser is in $_POST['assignees'] or not, so, i remove all old record given 
        the db and insert the new record to db
        */
        $fuser = $_SESSION['username'];
        $title = $_POST['title'];
        $detail = $_POST['description'];
        //create time is the time when this task is created, it will not be changed in edit task
        $ctime = $_SESSION['createTime'];
        $tskid = $_SESSION['taskID'];
        $dtime = $_POST['dueDate'];
        $imagepath = $_SESSION['pic'];
        //check for new uploading image

        if(isset($_POST['img'])){

			$imagepath = $_POST['img'];
		
			if(!endsWith($imagepath, ".jpg") 
				&& !endsWith($imagepath, ".png")
				&& !endsWith($imagepath, ".jpeg")
				&& !endsWith($imagepath, ".gif"))
			{
				$imagepath = "";
			}
			
            //move the image to the pic folder
//            move_uploaded_file($tmpimage, $imagepath);
        }
        
       

        //remove all record given the task id
        $droprecord = "DELETE FROM Task WHERE TaskID='$tskid'";
        $dropresult = $conn->query($droprecord);

        //for all users who are assgined, insert the data into db
        if(!empty($_POST['assignees'])){
            //get each value of the check box which is the username of that user and insert into db
            foreach($_POST['assignees'] as $tuser){
                $sql = "INSERT INTO Task VALUES('$tskid' ,'$fuser' ,'$tuser' ,'$title' ,'$detail' ,'$ctime' ,'$dtime' ,'$imagepath')";
                $insertesult = $conn->query($sql);
                
            }
        }
           
        

        //return to home page
        header("location: home.php");
    }
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ctask'])){
        //if the title is empty
        if(empty($_POST['title']))
        {
            $message = "Title is required, please fill in a title.";
            echo "<script type='text/javascript'>alert('$message');</script>";

        }
        if(empty($_POST['assignees']))
        {
            $message = "Please assign this task to an assignee in the list, if no one you want to assign to, then assign this task to yourself.";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }
	
	//Method from https://stackoverflow.com/questions/834303/startswith-and-endswith-functions-in-php
	function endsWith($string, $end)
	{
		$length = strlen($end);

		return $length === 0 || 
		(substr($string, -$length) === $end);
	}

	?>
    </body>
</html>
