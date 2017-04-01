<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link rel = "stylesheet" type = "text/css" href="style.css">

<title>Resident advisor event recommendations</title>


<style>
p {
    margin-left: 100px;
}
   * {
       margin: 0; 
       padding: 0;
     }

#logo a {
background-size: 86px 43px;
height: 43px;
width: 86px;
}

#logo a, .black #logo a:hover, #logo.dark a:hover {
}

     div#banner { 
       position: absolute; 
       top: 0; 
       left: 0; 
       background-color: #000000; 
       width: 100%; 
     }
     div#banner-content { 
       width: 1800px; 
       margin: 0 auto; 
       padding: 10px; 
       border: 1px solid #000;
     }
     div#main-content { 
       padding-top: 150px;
    }
table.outer-table
{
    table-layout: fixed;
    width: 1400px;
}
.date a {
font-size: 11px;
color: #9c9c9c;
}
img#profilepic { 
border: 1px solid white;
position: absolute;
right: 20px;
top: 20px;
}

    .black_overlay{
        display: none;
        position: absolute;
        top: 0%;
        left: 0%;
        width: 100%;
        height: 100%;
        background-color: black;
        z-index:1001;
        -moz-opacity: 0.8;
        opacity:.80;
        filter: alpha(opacity=80);
    }
    .white_content {
        display: none;
        position: absolute;
        top: 25%;
        left: 25%;
        width: 50%;
        height: 50%;
        padding: 16px;
        border: 16px solid orange;
        background-color: white;
        z-index:1002;
        overflow: auto;
    }

.myButton {
	-moz-box-shadow:inset 0px 1px 0px 0px #ffffff;
	-webkit-box-shadow:inset 0px 1px 0px 0px #ffffff;
	box-shadow:inset 0px 1px 0px 0px #ffffff;
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #ededed), color-stop(1, #dfdfdf));
	background:-moz-linear-gradient(top, #ededed 5%, #dfdfdf 100%);
	background:-webkit-linear-gradient(top, #ededed 5%, #dfdfdf 100%);
	background:-o-linear-gradient(top, #ededed 5%, #dfdfdf 100%);
	background:-ms-linear-gradient(top, #ededed 5%, #dfdfdf 100%);
	background:linear-gradient(to bottom, #ededed 5%, #dfdfdf 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ededed', endColorstr='#dfdfdf',GradientType=0);
	background-color:#ededed;
	-moz-border-radius:4px;
	-webkit-border-radius:6px;
	border-radius:4px;
	border:1px solid #dcdcdc;
	display:inline-block;
	cursor:pointer;
	color:#777777;
	font-family:arial;
	font-size:12px;
	font-weight:bold;
	padding:4px 16px;
	text-decoration:none;
	text-shadow:0px 1px 0px #ffffff;
}
.myButton:hover {
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #dfdfdf), color-stop(1, #ededed));
	background:-moz-linear-gradient(top, #dfdfdf 5%, #ededed 100%);
	background:-webkit-linear-gradient(top, #dfdfdf 5%, #ededed 100%);
	background:-o-linear-gradient(top, #dfdfdf 5%, #ededed 100%);
	background:-ms-linear-gradient(top, #dfdfdf 5%, #ededed 100%);
	background:linear-gradient(to bottom, #dfdfdf 5%, #ededed 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#dfdfdf', endColorstr='#ededed',GradientType=0);
	background-color:#dfdfdf;
}
.myButton:active {
	position:relative;
	top:1px;
}
.classname {
	-moz-box-shadow:inset 0px 1px 0px 0px #ffffff;
	-webkit-box-shadow:inset 0px 1px 0px 0px #ffffff;
	box-shadow:inset 0px 1px 0px 0px #ffffff;
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #ededed), color-stop(1, #dfdfdf) );
	background:-moz-linear-gradient( center top, #ededed 5%, #dfdfdf 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ededed', endColorstr='#dfdfdf');
	background-color:#ededed;
	-webkit-border-top-left-radius:6px;
	-moz-border-radius-topleft:6px;
	border-top-left-radius:6px;
	-webkit-border-top-right-radius:6px;
	-moz-border-radius-topright:6px;
	border-top-right-radius:6px;
	-webkit-border-bottom-right-radius:6px;
	-moz-border-radius-bottomright:6px;
	border-bottom-right-radius:6px;
	-webkit-border-bottom-left-radius:6px;
	-moz-border-radius-bottomleft:6px;
	border-bottom-left-radius:6px;
	text-indent:0;
	border:1px solid #dcdcdc;
	display:inline-block;
	color:#777777;
	font-family:arial;
	font-size:10px;
	font-weight:bold;
	font-style:normal;
	height:20px;
	line-height:20px;
	width:200px;
	text-decoration:none;
	text-align:center;
	text-shadow:1px 1px 0px #ffffff;
}
.classname:hover {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #dfdfdf), color-stop(1, #ededed) );
	background:-moz-linear-gradient( center top, #dfdfdf 5%, #ededed 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#dfdfdf', endColorstr='#ededed');
	background-color:#dfdfdf;
}.classname:active {
	position:relative;
	top:1px;
</style>
</head>
<body>
<div id="banner">
<div id="banner-content">  
<img src='RAlogo2.png'><br>

<?php

// Connect to MySQL database.

$con=mysqli_connect("localhost","speakit9","Dorianbassem@11","speakit9_RA");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
} else {
  echo "Connection successful!" . "<br>";
}

// Get the user id from the username in the userids table 
$username = $_POST["users_id"];
$result_username = mysqli_query($con, "SELECT distinct * FROM userids WHERE username like '$username%'");
   
// Try to find the users RA profile pic      
$row_userid = mysqli_fetch_array($result_username);
$image = 'http://www.residentadvisor.net/images/user/av/' . $row_userid['userid'] . '-' . $username . '.jpg';

// Check to see if the users image exists, otherwise dont display it.
if (@getimagesize($image)) {
	echo "<img src = '$image' width=100 height=100 id='profilepic'>";
}
?>    
</div>
</div>

<!-- Form to connect to ticket advisor app -->

<form action="http://www.math.nyu.edu/~dgoldman/ratickets2.php" method="post" name="myform">
<input id="event" name="event" placeholder="http://www.residentadvisor.net/event.aspx?558361" required="" style="width:400px; height:40px" class="font1" type="hidden">
<input id="emailaddress" type="hidden" name="content" placeholder="anything@example.com" required="" style="width:300px; height:40px" class="font1">
<button type="Submit" style="height:40px; width:100px">Submit</button>
</form>

<script>

// This function takes the users email and notifies them when tickets to the event become available. 

function load_text(url) {
   var person = prompt("Please enter your email to be notified", "you@you.com");
	if (person != null) {
                var elem = document.getElementById("emailaddress");
                elem.value = "doriang102@gmail.com";
                var elem2 = document.getElementById("event");
                elem2.value = "http://www.residentadvisor.net/event.aspx?637777";
                document.forms["myform"].submit();
    }
}
</script>

</body>
</html>
<?php

// Connect to MySQL server

$con=mysqli_connect("localhost","speakit9","Dorianbassem@11","speakit9_RA");

// Check connection
if (mysqli_connect_errno()) {
  	echo "Failed to connect to MySQL: " . mysqli_connect_error();
} else {
	//  echo "Connection successful!" . "<br>";
}

// Get users id from SQL database

$username = $_POST["users_id"];
$result_username = mysqli_query($con, "SELECT distinct * FROM userids WHERE username like '$username%'");
$row_userid = mysqli_fetch_array($result_username);

// Find url which links to users profile image.

$image = 'http://www.residentadvisor.net/images/user/av/' . $row_userid['userid'] . '-' . $username . '.jpg';
echo "<br><br><br><br><br><br><br><br>";

// Check to see if user image exists on RA website, and otherwise just display default message

if (@getimagesize($image)) {
	echo "<br><br>";
	echo "<table valign='top'><td>";
	echo "</td><td valign='top'>";
	echo "<h1>Welcome " . $row_userid['username'] . "!</h1><br>";
	echo "</td>";
	echo "</table>";
	echo "<br>";
} else 
{
	echo "<br><h1>Welcome " . $row_userid['username'] . "!</h1><br>";
}
echo '<table><thead><tr>';

// Create column headers for event suggestions

echo '<th align="left"><span><h2>Favorite DJs</h2></span></th>';
echo '<th align="left"><h2>Favorite promoters</h2></th>';
echo '<th align="left"><h2>Users similar to you are attending</h2></th>';
echo '</tr></thead><tbody>';

// Find user favorites from favorites table

$id = $row_userid['userid'];
$result = mysqli_query($con, "SELECT * FROM favorites WHERE userid = '$id'");
$row = mysqli_fetch_array($result);

$result2 = mysqli_query($con, "SELECT * FROM favs WHERE uid = '$id'");
$row2 = mysqli_fetch_array($result2);


// Initalize arrays

$title_dj = array();		// Event titles related to dj history
$title_promoter = array();	// Event titles related to promoter history
$title_venue = array();		// Event titles related to venue history (currently not using)
$tickets = array();		// Indicates if tickets are available for event or not
$str_tickets = array();		// Added to title in the case tickets are not available
$dates = array();		// Dates for the events
$event_num = array();		// Obtain the event number to get the event logo image from site

// For events based on djs, get top event suggetions from MySQL database and display them.

for($i=1; $i <= 5; $i++) {
	$column = 'e' . $i;
	$url = $row2[$column];
	
	// Get event name of the url listed.

	$result_url = mysqli_query($con, "SELECT * FROM event_names WHERE url like '%$url%'");
	$row_url = mysqli_fetch_array($result_url);
	
	// Get event date of the url listed.

	$date_query = mysqli_query($con, "SELECT * FROM dates WHERE url like '%$url%'");
	$row_dates = mysqli_fetch_array($date_query);
	$dates[$i] = $row_dates['date'];
	

	// Create the title, after some formatting to remove "RA Tickets:"

	$title_dj[$i] = $row_url['name'];
	$title_dj[$i] = str_replace(':','',strstr($title_dj[$i], ':'));
	
	// Indicates true/false for ticket availability

	$tickets[$i] = str_replace(' ', '', $row_url['tickets']);
	
	
	// Obtain event number from url to generate image url for logo

	$event_num[$i] = str_replace('?','',strstr($url, '?'));

	// This code finds the venue and places it on a new line in unbolded font

	$ename = strstr($title_dj[$i], " at ", true);
                $location = str_replace(" at ", "", strstr($title_dj[$i], " at "));
                if(strlen($location) > 1) {
                        $title_dj[$i] = "<b>" . $ename . "</b>" . "<br>" . $location;
                } else {
                        $title_dj[$i] = "<b>" . $title_dj[$i] . "</b>";
                }

	// If tickets are not available, add a button which connects to the php form which notifies users when tickets are available.

	if(strcmp($tickets[$i],'True') == 0) {
		$str_tickets[$i] = '';
	} else {
		$str_tickets[$i] = "<input id='clickMe' class = 'classname' type='button' value='Notify me when tickets are available *' onclick='load_text(\"$url\");' />";
	}
}

// For events based on promoters, get top event suggetions from MySQL database and display them.

for($i=5; $i <= 10; $i++) {
        
	$column = 'e' . $i;
        $url = $row2[$column];
        
	// Obtain event names from SQL database.

	$result_url = mysqli_query($con, "SELECT * FROM event_names WHERE url like '%$url%'");
        $row_url = mysqli_fetch_array($result_url);
	

	// Obtain dates of events from SQL database.
	$date_query = mysqli_query($con, "SELECT * FROM dates WHERE url like '%$url%'");
        $row_dates = mysqli_fetch_array($date_query);

	// Fetch the event title, and format it as before to have venue on the bottom in non-bold text.

        $title_promoter[$i-5] = $row_url['name'];
	$title_promoter[$i-5] = str_replace(':','',strstr($title_promoter[$i-5], ':'));
	$ename = strstr($title_promoter[$i-5], " at ", true);
       	$location = str_replace(" at ", "", strstr($title_promoter[$i-5], " at "));
        if(strlen($location) > 1) {
               $title_promoter[$i-5] = "<b>" . $ename . "</b>" . "<br>" . $location;
         } else {
                        $title_promoter[$i-5] = "<b>" . $title_promoter[$i-5] . "</b>";
         }
        
	// Fetch ticket availability information from SQL.
	$tickets[$i] = str_replace(' ', '', $row_url['tickets']);

	// Find event number from url to generate logo for event.

	$event_num[$i] = str_replace('?','',strstr($url, '?'));

	// Fetch even date from SQL.
	$dates[$i] = $row_dates['date'];


	// If tickets are not yet available, create button which when clicked informs users when tickets are available after supplying email.

        if(strcmp($tickets[$i],'True') == 0) {
                $str_tickets[$i] = '';
        } else {
        	
		$str_tickets[$i] = "<input id='clickMe' class = 'classname' type='button' value='Notify me when tickets are available' onclick='myFunction(" . '$url' . ");' />";
        }
}
// Code to generate suggestions based on venues, currently not in use but may use in future.

/*
for($i=10; $i <= 15; $i++) {
        $column = 'e' . $i;
        $url = $row2[$column];
        $result_url = mysqli_query($con, "SELECT * FROM event_names WHERE url like '%$url%'");
        $row_url = mysqli_fetch_array($result_url);
	 $date_query = mysqli_query($con, "SELECT * FROM dates WHERE url like '%$url%'");
        $row_dates = mysqli_fetch_array($date_query);
        $title_venue[$i-10] = $row_url['name'];
        $tickets[$i] = str_replace(' ', '', $row_url['tickets']);
	$title_venue[$i] = str_replace(':','',strstr($title_venue[$i], ':'));
	$event_num[$i] = str_replace('?','',strstr($url, '?'));
        $dates[$i] = $row_dates['date'];
	if(strcmp($tickets[$i],'True') == 0) {
                $str_tickets[$i] = '';
        } else {
                $str_tickets[$i] = 'Notify me when tickets become available! (Coming soon)';
        
                $str_tickets[$i] = "  <button onclick='myFunction()' class='myButton'>Notify me when tickets are available</button>";
		$str_tickets[$i] = "<a href='#' class='classname'>Notify me when tickets are available</a>";
//              $str_tickets[$i] = "<a href = 'javascript:void(0)' onclick = 'document.getElementById(\"light\").style.display=\"block\";document.getElementById(\"fade\").style.display=\"$
        }
}
*/

// Analagous arrays to previous section but for collaborative filtering suggestions

$title2_s = array();
$tickets_s = array();
$str_tickets_s = array();
$dates_s = array();
$event_num_s = array();

// Fetch suggestions from SQL table.

$result = mysqli_query($con, "SELECT * FROM knn WHERE uid = '$id'");
$row = mysqli_fetch_array($result);

// Go through each of the 10 suggestions in the database.

for($k=1; $k <= 10; $k++) {
        $column = 'event' . $k;
        $url = $row[$column];

	// Fetch url from SQL table.
        $result_url = mysqli_query($con, "SELECT * FROM event_names WHERE url like '%$url%'");
        $row_url = mysqli_fetch_array($result_url);
         

	// Fetch date from SQL table.
	$date_query = mysqli_query($con, "SELECT * FROM dates WHERE url like '%$url%'");
        $row_dates = mysqli_fetch_array($date_query);
        $dates_s[$k] = $row_dates['date'];
        

	// If the entry is not empty, then proceed to generate title of event 
	if(strlen($url) > 1) {
                $title2_s[$k] = $row_url['name'];
		
		// Remove the "RA:" part of the title.
                $title2_s[$k] = "" .  str_replace(':','',strstr($title2_s[$k], ':')) . "";
		
		// Seperate the name of the event and venue.
		$ename = strstr($title2_s[$k], " at ", true);
		$location = str_replace(" at ", "", strstr($title2_s[$k], " at "));

		// If there is a venue, put it on a new line non-bolded, otherwise just set title to be the name.
		if(strlen($location) > 1) {
			$title2_s[$k] = "<b>" . $ename . "</b>" . "<br>" . $location;
		} else {
			$title2_s[$k] = "<b>" . $title2_s[$k] . "</b>";
		}	

		// See if tickets are available.
		$tickets_s[$k] = str_replace(' ', '', $row_url['tickets']);
           
		// If tickets are not available, add button which lets users be notified when they are.

		$event_num_s[$k] = str_replace('?','',strstr($url, '?'));
                if(strcmp($tickets_s[$k],'True') == 0) {
                        $str_tickets_s[$k] = '';
                } else {
                        $str_tickets_s[$k] = 'Notify me when tickets become available! (Coming soon)';
        
                        $str_tickets_s[$k] = "  <button onclick='myFunction()'>Notify me when tickets are available</button>";
                }
        }
}

// Finally output the suggestions into the table.

echo "<h2>Based on your event history preferences we recommend the following events: </h2>" . "<br>";

for($i =1; $i <= count($title_dj); $i++) {
        $column = 'e' . $i;
        $url = $row2[$column];
	echo "<tr>";
	echo "<td>";
	
	// Fron the date string, we generate the URL for the image logo.
	$date_str = explode("/", $dates[$i]);
	$day = sprintf("%02s", $date_str[0]);
	$month = sprintf("%02s", $date_str[1]);
	$image = "http://www.residentadvisor.net/images/events/flyer/2014/10/us-" . $month . $day . "-" . $event_num[$i] . "-list.jpg";
	
	// Output the date on top left of event page.
	echo "<font color='#9c9c9c' size='2px'>" . $dates[$i] . "</font><br>";
	echo "<table border='0' cellpadding = '3' cellspacing = '3'>";
	echo "<td width='152'>";

	// If event logo exist, then show it, otherwise show the default image.
	if (@getimagesize($image)) {
		echo "<img src = " . $image . "><br>";
	} else {
		echo "<img src = 'RAlogo2.png' width = 152px height=76px><br>"; 
	}
	// Put the event title in the adjacent sub-table.

	echo "<td width='300' valign='top'>";
	echo "<a href='" . $url . "' style='text-decoration:none'>" . $title_dj[$i] . "</a>" . $str_tickets[$i] . "<br>";
	echo "</table>";

	// Move to promoter column and repeat the above.

	$j = $i + 5;
        $column = 'e' . $j;   
        $url = $row2[$column];
        echo "</td><td>";
	$date_str = explode("/", $dates[$j]);
        $day = sprintf("%02s", $date_str[0]);
        $month = sprintf("%02s", $date_str[1]);
	$image = "http://www.residentadvisor.net/images/events/flyer/2014/10/us-" . $month . $day . "-" . $event_num[$j] . "-list.jpg";
	if(strlen($url) > 1) {
	 echo "<font color='#9c9c9c' size='2px'>" . $dates[$i] . "</font><br>";
	}
	echo "<table border='0' cellpadding = '3' cellspacing = '3'>";
        echo "<td width='152'>";
	 if (@getimagesize($image)) {
        	echo "<img src = " . $image . "><br>";
        } else {
        	echo "<img src = 'RAlogo2.png' width = 152px height=76px><br>";
        }	
	echo "<td width='300' valign='top'>";
	echo "<a href='" . $url . "' style='text-decoration:none'>" . $title_promoter[$i] . "</a>" . $str_tickets[$i+5] . "<br>";
	echo "</table>";


	// Move to 'similar users' column and repeat the above.

	$j = $i + 10;
         $column = 'e' . $j;  
        $url = $row2[$column];
	echo "</td><td>";
 	$date_str = explode("/", $dates_s[$j-10]);
        $day = sprintf("%02s", $date_str[0]);
        $month = sprintf("%02s", $date_str[1]);
        $image = "http://www.residentadvisor.net/images/events/flyer/2014/10/us-" . $month . $day . "-" . $event_num_s[$j-10] . "-list.jpg";
	if(strlen($title2_s[$i]) > 1) {
	 echo "<font color='#9c9c9c' size='2px'>" . $dates_s[$i] . "</font><br>";
	}
	echo "<table border='0' cellpadding = '3' cellspacing = '3'>";
        echo "<td width=152px height=76px>";
	if (strlen($title2_s[$i]) > 1) {
	 if (@getimagesize($image)) {
        	echo "<img src = " . $image . "><br>";
        } else {
        	echo "<img src = 'RAlogo2.png' width = 152px height=76px><br>";
        }
        echo "<td width='300' valign='top'>";
	echo "<a href='" . $url . "' style='text-decoration:none'>" . $title2_s[$i] . "</a>" . $str_tickets_s[$i] . "<br>";
	}
	echo "</table>";
	echo "</td></tr>";
} 
echo "</tbody></table>";

echo "<br><br>";
echo "<center>";

?>
