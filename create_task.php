<!DOCTYPE html>

<style>
input[type=checkbox]
{
  /* Double-sized Checkboxes */
  -ms-transform: scale(2); /* IE */
  -moz-transform: scale(2); /* FF */
  -webkit-transform: scale(2); /* Safari and Chrome */
  -o-transform: scale(2); /* Opera */
  padding: 10px;
}
</style>

<html>

<?php
   ob_start();
   session_start();
?>
<?php require_once 'dbConfig.php'; ?>

    <head>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <title>ToDo App Create Task</title>
    </head>

    <body>
	    
    <h3 class="w3-topbar"></h3>
    <h1	class="w3-margin-left">Create a Task</h2>
    <h3 class="w3-bottombar"></h3>
	    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
    <h3 class="w3-margin-left">Title:</h3>
    <input class="w3-margin-left" type="text" name="title" id="title">
    <br><br>
    <h3 class="w3-margin-left">Description:</h3>
    <textarea class="w3-margin-left" rows="4" cols="50" name="description" id="description"></textarea>
    <br><br>
    <h3 class="w3-margin-left">Due Date:</h3>
    <input class="w3-margin-left" type="datetime-local" name="dueDate" id="dueDate" value="2018-07-31T19:30" min="2018-07-31T01:59" max="2118-12-31T23:59">
    <br><br>
    
    <h3 class="w3-margin-left">Assignees (optional):</h3><br>
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
	    //if($id!=$_SESSION['username']){
            echo "<tr>";
            echo "<td><h3 class='w3-margin-left'>$fn</h3></td>";
            echo "<td><h3 class='w3-margin-left'>$ln</h3></td>";
            //set the value of the check box to the username
            echo '<td><input class="w3-margin-left" type="checkbox" value = "'.$id.'" name = "assignees[]"></td>';
            echo "</tr>";
	    //}
        }
        echo "</table>";
    }
    ?>

    <br><br>
    <h3 class="w3-margin-left">Picture URL (optional):</h3><br>
    <input class="w3-margin-left" type="text" name="img">
    <br><br>
    <input class="w3-button w3-black w3-margin-left" type="submit" name="ctask" value="Create Task">


    <p class="w3-bottombar"></p>


    </form>

	<?php
	
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ctask']) && !empty($_POST['title']) && !empty($_POST['assignees'])) {
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

		$imagepath = $_POST['img'];
		
		if(!endsWith($imagepath, ".jpg") 
			&& !endsWith($imagepath, ".png")
			&& !endsWith($imagepath, ".jpeg")
			&& !endsWith($imagepath, ".gif"))
		{
			$imagepath = "";
		}
			
		
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
