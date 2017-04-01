
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel = "stylesheet" type = "text/css" href="style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Home Page</title>
</head>
 
<body>
<h1>Welcome <?php echo $_SESSION["sess_user_id"] ?>!</h1>
 <form method="post" action="post.php" >
        <table border="1" >
            <tr>
                <td><label for="title">Title</label></td>
                <td><input type="text"
                  name="title" id="title" style="width:400pt"></input></td>
            </tr>
            <tr>
                <td><label for="message">Text</label></td>
                <td><input name="message"
                  type="text" id="message" style="height:200pt;width:400pt" onfocus="moveCursorToStart(this);"></input></td>
            </tr>
            <tr>
                <td><input type="submit" value="Submit"/>
                <td><input type="reset" value="Reset"/>
            </tr>
        </table>
    </form>

<?php
$title = $_POST['title'];
$message = $_POST['message'];
$name = $_SESSION["sess_user_id"];
$handle = fopen("RA_nearest_neighbors_oct1.csv", "r");

$con=mysqli_connect("localhost","speakit9","Dorianbassem@11","speakit9_RA");
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
} else {
  echo "Connection successful!";
}

if ($handle) {   
    while (($line = fgets($handle)) !== false) {
        // process the line read.
        $data = explode(" ", $line);
        $size = count($data);
	$size = min($size,10);
	$sql = "INSERT INTO knn VALUES ('$data[0]', '$data[1]', '$data[2]', '$data[3]', '$data[4]', '$data[5]', '$data[6]', '$data[7]', '$data[8]', '$data[9]', '$data[10]')";
if (!mysqli_query($con, $sql)) {
        die('Error: ' . mysqli_error($con));
}       
 }
} else {
    // error opening the file.
echo "Error opening file";
}
fclose($handle); 
exit();

//$sql = "INSERT INTO favorites (userid, dj, promoter, venue) VALUES ('$data[0]', '$data[1]', '$data[2]', '$data[3]')";

//if (!mysqli_query($con, $sql)) {
//	die('Error: ' . mysqli_error($con));
//}

echo "<h1>Message board posts:</h1>" . "<br>";
$result = mysqli_query($con, "SELECT * from entry");
while($row = mysqli_fetch_array($result)) {
        echo "<h1> " . $row['title'] . " </h1><br>";
	echo $row['text'] . " <h2>Author: " . $row['name'] . "</h2>";
	echo "<br>";
}
?>

   <form method="post" action="logout.php" >
        <table border="1" >
            <tr>
                <td><input type="submit" value="Logout"/>
            </tr>
        </table>
    </form>
</body>
</html>
