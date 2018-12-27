<?php

  session_start();
  //If your session isn't valid, it returns you to the login screen for protection
  if(empty($_SESSION['member_id']))
  {
     header("location:access-denied.php");
  }
  
?>

<?php

  $mysqli = new mysqli('localhost','root','','poll');
  
  // retrieving positions sql query
  $sql1 = "SELECT * FROM tbpositions";
  $result1 = mysqli_query($mysqli, $sql1); // or die("There are no records to display ... \n" . mysqli_error());

?>

<?php
  if (isset($_POST['FVote']) and  !empty($_POST['FVote'])) 
  {
    if (isset($_POST['vote'])) 
    {
        $sqlm = "SELECT * FROM tbmembers WHERE member_id = '$_SESSION[member_id]'";
        $k = mysqli_query($mysqli, $sqlm);
        $row = mysqli_fetch_array($k);
        $id = $row['member_id'];

        $radio_input = $_POST['vote'];
        $sql4 = "UPDATE tbmembers SET voted = 1 where member_id='$id'";
        $result3 = mysqli_query($mysqli, $sql4);
     
        $zzz= "UPDATE `tbcandidates` SET `candidate_cvotes` = candidate_cvotes+1 WHERE `tbcandidates`.`candidate_id` = '$radio_input'";
        $zzzz = mysqli_query($mysqli,$zzz);
        echo "<div class='alert alert-success' align='center'>Voted Successfully!</div>";
    }
  }
?>

<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Online Voting using FHE:Voting Page</title>
    <link href="user_styles.css" rel="stylesheet" type="text/css" />   
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
      body{
        background-image: url(images/Background.jpg);
        background-repeat: no-repeat;
      }
      #header{
        text-align: center;
        color: white;
      }
	  table{
			background: #f6f6f6;
			border-radius: 6px;
		}
    </style>
  </head>
  <body>
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="home.php">Voting</a>
        </div>
        <ul class="nav navbar-nav">
          <li class="active"><a href="vote.php">Current Polls</a></li>
          <li><a href="manage-profile.php">Manage Account</a></li>
          <li><a href="index.php">Logout</a></li>
        </ul>
      </div>
    </nav>
  	
    <div class="container-fluid text-center">    
      <div class="row content">
        <div class="col-lg-2">
        </div>

        <div class="col-lg-8"> 
          <div class="row">
            <div class="col-lg-12">
              <div class="well contact-form-container">
                <form class="form-horizontal contactform" action="vote.php" method="post"> 
                  <div class="col-lg-3">
                    <b>Choose Position</b>
                  </div>

                  <div class="col-lg-6">
                    <SELECT required class="form-control" NAME="position" id="position">
                      <OPTION VALUE="">--Select--
                      <?php 
                        //loop through all table rows
                        while ($row=mysqli_fetch_array($result1))
                        {
                          echo "<OPTION VALUE=$row[position_name]>$row[position_name]"; 
                        }
                        mysqli_free_result($result1);
                      ?>
                    </SELECT>
                  </div>

                  <div class="col-lg-3">
                    <input class="btn btn-info" type="submit" name="Submit" value="See Candidates" />
                  </div>
                  <br>
                </form>

                <form method="post" action="vote.php">
                  <?php                
                    //loop through all table rows
                    //if (mysql_num_rows($result)>0){
                    if (isset($_POST['Submit']))
                    {
                      $position = addslashes( $_POST['position'] ); //prevents types of SQL injection
                      $sql2 = "SELECT * FROM tbcandidates WHERE candidate_position='$position'";// retrieve based on position
                      $result2 = mysqli_query($mysqli, $sql2); //or die(" There are no records at the moment ... \n"); 
                      echo "<center><b> $position </b></center>";
                      echo "<tr>
                                <th>Candidates:</th>
                              </tr>";
                      echo "<table align=center>";
                      echo "<th>Candidate ID &nbsp;</th>";
                      echo "<th>Candidate Name &nbsp;</th>";
                      
                      $i=1;
                      while ($row = mysqli_fetch_array($result2))
                      {
                        $id = $row[0];
                        $username = $row[1];
                        echo "<tr>";
                        echo "<center><td>{$i}</td></center>";
                        echo "<center><td><label for='\"radio_candid\".$i.'>{$username}</label></td></center>";
                        echo "<td><input type='radio' name='vote' value='$id' id='\"radio_candid\".$i.'></td>";
                        $i++;
                      }
                      $voteButton = "SELECT * FROM tbmembers where member_id = '$_SESSION[member_id]'";                
                      $voteButtonresult = mysqli_query($mysqli,$voteButton);
                      $votedrow = mysqli_fetch_array($voteButtonresult);
                      $votevalue = $votedrow['voted'];
                      echo "</table>";
                      if($votevalue == 0)
                      {
                      	echo "<div align='center'>
                               <input type = 'submit' class = 'btn btn-success'name = 'FVote' value = 'Vote'>
                        	  </div>";
                      }
                      else
                      {
                      	echo "<div align='center'>
                               <input type = 'hidden' class = 'btn btn-primary'name = 'FVote' value = 'Vote'>
                        	  </div>";	
                      }
                      echo "<br>";
                      echo"<div class='alert alert-danger'>
                              Click a circle under a respective candidate to cast your vote. You can't vote more than once for a position and can't be undone.
                            </div>";
                      mysqli_free_result($result2);
                      mysqli_close($mysqli);

                    }
                  ?>
                  <br>
                </form>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-2">
    		<table class="countdownContainer" >
				<tr class="info">
					<td colspan="4" align="center"><b>Ends In</b></td>
				</tr>
				<tr class="info">
					<td id="days" align="center"><b>120</b></td>
					<td id="hours" align="center"><b>4</b></td>
					<td id="minutes" align="center"><b>12</b></td>
					<td id="seconds" align="center"><b>22</b></td>
				</tr>
				<tr>
					<td>Days </td>
					<td>Hours</td>
					<td>Minutes</td>
					<td>Seconds</td>
				</tr>
			</table>
			<script type="text/javascript">
				function countdown() {
					var now = new Date();
					var eventDate = new Date(2018,3,17,17,00);

					var currentTime = now.getTime();
					var eventTime = eventDate.getTime();

					var remTime = eventTime - currentTime; 

					var s = Math.floor(remTime / 1000);
					var m = Math.floor(s / 60);
					var h = Math.floor(m / 60);
					var d = Math.floor(h / 24);

					h = h % 24;
					m = m % 60;
					s = s % 60;

					h = (h < 10) ? "0" + h : h;
					m = (m < 10) ? "0" + m : m;
					s = (s < 10) ? "0" + s : s;

					document.getElementById("days").textContent = d;
					document.getElementById("days").innerText = d;

					document.getElementById("hours").textContent = h;
					document.getElementById("minutes").textContent = m;
					document.getElementById("seconds").textContent = s;

					setTimeout(countdown, 1000);
				}
				countdown();
			</script>
        </div>
      </div>
    </div>
  </body>
</html>