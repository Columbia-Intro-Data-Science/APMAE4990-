<html>
  <body>
    <?php

$con=mysqli_connect("localhost","speakit9","Dorianbassem@11","speakit9_RA");
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
} else {
//  echo "Connection successful!";
}


        $DisplayForm=True;
      if (array_key_exists('content', $_POST)) {

        # Check to see if the user has entered an email address

                if(empty($_POST['content'])) {
                        echo "You did not enter an email address.";
                        die();
                }
        # Check that the email address is a valid one, such as example@example.com

                if (!filter_var($_POST['content'],FILTER_VALIDATE_EMAIL))
                {
                        echo "The email address you have entered is invalid.";
                        die();
                }

                $returnValue = parse_url($_POST['event']);

        # Check that the URL entered is indeed in valid form for a Resident Advisor music event.

                if($returnValue['host'] != 'www.residentadvisor.net') {
                        echo "The URL must be www.residentadvisor.net";
                        die();
                }

                if($returnValue['path'] != '/event.aspx') {
                        echo "You did not enter a valid RA event.";
                        die();
                }
                if($returnValue['query'] == '') {
                        echo "You did not enter a valid RA event.";
                        die();
                }
  # Extract the title of the event from the webpage.
                 
                preg_match("/<title>(.+)<\/title>/siU", file_get_contents($_POST['event']), $matches);
                $title = $matches[1];
                $titles = mb_substr($title,3,13);

        # Ensure that the URL indeed leads to an event page, and not the default page which occurs when event is invalid
  
                if(strncmp($titles,"RA: Events",10)==0) {
                        echo "This does not appear to be a valid RA event. Check the number after the question mark";
                        die();
                }
                $DisplayForm=False;
                $addEvent=1;
      
                
        # Check to see if the list of emails for this event already exists
                        
                 $email = $_POST['content'];
                 $sql_check = "SELECT * from ticket_advisor where email='" . $email . "' and url='" . $_POST['event'] . "'";
                $result = mysqli_query($con, $sql_check);
                $row = mysqli_fetch_array($result);
                echo $row[0];
                if(!$result) {
                        die('Error: ' . mysqli_error($con));
                }
                if(strlen($row[0]) > 0 ) {
                        echo "Your email is already listed for this event - don't worry, you'll be notified!";
                        die();
                }
                $url = $_POST['event'];
                $sql_insert = "INSERT INTO ticket_advisor VALUES ('$email', '$url', 0)";
                $result = mysqli_query($con, $sql_insert);
                        
                if (!result) {
                        die('Error: ' . mysqli_error($con));
                }
        # Go through each line in the email file and check to see if the email has already been entered.

                
        # If everything is valid, add the URL of the RA event to the RAEventFile, and notify the user. The rest is up to the Python app now.
                echo "Thank you. You will receive an email at:<pre>\n";
                echo htmlspecialchars($_POST['content']);
                echo " when tickets are available.";
                echo "\n</pre>";

     } 

if($DisplayForm) {
?>                      
<style>                 
.font1 {         
        font-size: 15px;
}               
.font2 {        
        font-size: 12px;
}               
</style>                
<title>Resident Advisor Ticket Advisor</title>
<center><IMG SRC ="http://www.math.nyu.edu/~dgoldman/RATicketpic.gif" ALT="Test" WIDTH=701 HEIGHT=177><br>
<p class="font2">Please enter the full URL of the Resident Advisor event (eg. http://www.residentadvisor.net/event.aspx?558361) and your email address, then
click Submit.</p>
<form action="raticket_advisor.php" method="post">
<input name="event" placeholder="http://www.residentadvisor.net/event.aspx?558361" required="" style="width:400px; height:40px" class="font1">
<input id="emailaddress" type="content" name="content" placeholder="anything@example.com" required="" style="width:300px; height:40px" class="font1">
                
<button type="Submit" style="height:40px; width:100px">Submit</button>
    </form></center>
<?php
} ?>
 </body>                
</html>


