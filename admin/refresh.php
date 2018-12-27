<?php
  session_start();
  require_once 'phpmailer/PHPMailerAutoload.php';
  $mysqli = new mysqli('localhost','root','','poll');
  // retrieving candidate(s) results based on position
  if (isset($_POST['Submit']))
  {   
    $position = addslashes( $_POST['position'] ); 
    $sql1 = "SELECT * FROM tbcandidates where candidate_position='$position'";
    $results = mysqli_query($mysqli, $sql1);
    $totalvotes = 0;
    $can_name =  [];
    $can_votes = [];
    if($results!=null)
    {
        $arrayindex=0;
        while ($posrow = mysqli_fetch_array($results)) {
          $can_name[$arrayindex] = $posrow['candidate_name'];
          $can_votes[$arrayindex] = $posrow['candidate_cvotes'];
          $arrayindex++;
        }
        $arrayindex=0;
        $win_name = 0;
        $win_vote = 0;
        $clash_name = 0;
        $flag = 0;
        for ($arrayindex=0; $arrayindex < count($can_votes) ; $arrayindex++) { 
          if($can_votes[$arrayindex]>$win_vote)
          {
            $win_vote = $can_votes[$arrayindex];
            $win_name = $can_name[$arrayindex];
          }
          else if($can_votes[$arrayindex]>=$win_vote){
            $clash_name = $can_name[$arrayindex];
            $flag = 1;
          }
          $totalvotes = $totalvotes+$can_votes[$arrayindex];
        }
    }
  }
?> 
<?php
  // retrieving positions sql query
  $sql2 = "SELECT * FROM tbpositions";
  $result2=mysqli_query($mysqli, $sql2); // or die("There are no records to display ... \n" . mysqli_error()); 
?>

<?php 
  //If your session isn't valid, it returns you to the login screen for protection
  if(empty($_SESSION['admin_id']))
  {
   header("location:access-denied.php");
  }
?>

<?php
  //publishing results
  if(isset($_POST['publish']))
  {
    $publish = "SELECT * FROM tbmembers";
    $pub_result = mysqli_query($mysqli,$publish);
    if ($mysqli->query($publish))
    {
      while ($row = mysqli_fetch_array($pub_result))
      {
        $name = $row['first_name'];
        $email = $row['email'];

        // php mailer code starts
        $mail = new PHPMailer(true);
        
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'maniknoreply@gmail.com';           // SMTP username
        $mail->Password = 'ajstylesphenomenal';               // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;   
        $mail->Host = 'tls://smtp.gmail.com:587';             // set the SMTP port for the GMAIL server

        $mail->setFrom('maniknoreply@gmail.com', 'Voting_Admin');
        $mail->addAddress($email, $name);                     // Add a recipient
        
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Election Results';
        $mailmsg = "SELECT * from tbcandidates";
        $mailmsgresult = mysqli_query($mysqli,$mailmsg);
        $mail->Body = "<h4>Dear $name,</h4><br><h5>The Results of the recently conducted polls are out and are as follows</h5><br><b>Candidate Name</b>\t\t\t<b>Votes Earned</b><br>";
        while ($mailrow = mysqli_fetch_array($mailmsgresult)){
          $val1 = $mailrow['candidate_name'];
          $val2 = $mailrow['candidate_cvotes'];
          $mail->Body = $mail->Body." $val1 \t\t\t"." $val2 <br>";
        }
        $mail->Body = $mail->Body.'<h5>We hope to provide you the best possible and benefitial services</h5><br><h4>Thank You</h4>';
        $mail->send();
      }
        echo "<div class='alert alert-success' align='center'>Results Published!!</div>";
    }
  }
?>

<html>
  <head>
    <title>Results</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        body{
          background-image: url(images/Background.jpg);
          background-repeat: no-repeat;
          opacity: 0.6;
        }
        #header{
          text-align: center;
          color: white;
        }
      </style>
      <?php  
        //If your session isn't valid, it returns you to the login screen for protection
        if(empty($_SESSION['admin_id']))
        {
         header("location:access-denied.php");
        }
      ?>
  </head>
  <body>
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="admin.php">Voting</a>
        </div>
        <ul class="nav navbar-nav">
          <li><a href="manage-admins.php">Manage Administrators</a></li>
          <li><a href="positions.php">Manage Positions</a></li>
          <li><a href="candidates.php">Manage Candidates</a></li>
          <li class="active"><a href="refresh.php">Poll Results</a></li>
          <li><a href="index.php">Logout</a></li>
        </ul>
      </div>
    </nav>
    <div class="container-fluid text center">        
      <div class="row content">
        <div class="col-lg-2">
          
        </div>
        <div class="col-lg-8">
          <div class="well contact-form-container">
            <form class="form-horizontal contactform" action="refresh.php" method="post">
              <div class="col-lg-3">
                
              </div>
              <div class="col-lg-6">                
                <div class="row">
                  <div class="col-lg-5">
                    <h4>Choose Position</h4>  
                  </div>
                  <div class="col-lg-4">
                    <SELECT required class="form-control" NAME="position" id="position">
                      <OPTION VALUE="">--Select--
                      <?php 
                        $i=0;
                        //loop through all table rows
                        while ($row=mysqli_fetch_array($result2))
                        {
                          echo "<OPTION VALUE=$row[position_name]>$row[position_name]"; 
                          $i++;
                        }
                      ?>
                    </SELECT>
                  </div>
                  <div class="col-lg-3">
                    <input class="btn btn-info" type="submit" name="Submit" value="See Results" />
                  </div>
                </div>
                <br>
                <br>                                                                        
              </div>
              <div class="col-lg-3">
                
              </div>
            </form>
            <br>
            <br>
            <div class="row">
              <br>
              <br>
              <?php 
                if(isset($_POST['Submit']))
                {
                  if(count($can_name) == 0)
                  {
                    echo "<div class = 'alert alert-warning' align = 'center' style = 'color:black;'><b>There are no candidates for this section.</b></div>";
                  }
                  else
                  {
                    $arrayindex=0;
                    for ($arrayindex=0; $arrayindex < count($can_votes); $arrayindex++) { 
                      $width = 100*round(($can_votes[$arrayindex]/$totalvotes),4);
                      echo "<br>$can_name[$arrayindex]:<br>";
                      if($arrayindex%2==0)
                      {
                        echo "<img src='images/candidate-1.gif' width='$width;' height='20'> ";
                      }
                      else
                      {
                        echo "<img src='images/candidate-2.gif' width='$width;' height='20'> "; 
                      }
                      echo "$width % of $totalvotes total votes<br>votes <b>$can_votes[$arrayindex]</b><br>";  
                    }
                    if($flag==0)
                    {
                      $result_vote = 100*round(($win_vote/$totalvotes),4);
                      echo " <div class = 'alert alert-success' align = 'center' style = 'color:black;'> The Winner of the Poll is <b>$win_name</b> with <b>$win_vote </b>votes out of $totalvotes @ $result_vote</div> ";
                    }
                    else
                    {
                      $result_vote = 100*round(($win_vote/$totalvotes),4);
                      echo " <div class = 'alert alert-danger' align = 'center' style = 'color:black;'> There is a tie between <b>$win_name</b> and <b>$clash_name</b> with <b>$win_vote</b> votes out of $totalvotes @ $result_vote each.</div>";
                    }
                  }
                }
              ?>
              <form class="form-horizontal contactform" action="refresh.php" method="post">
                <div class="col-lg-4">
                      
                </div>
                <div class="col-lg-4">
                  <div align="center">
                    <input class="btn btn-info" type="submit" name="publish" value="Publish" />
                    <br>
                  </div>
                </div>
                <div class="col-lg-4">
                  
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-lg-2">
          
        </div>
      </div>
    </div>
  </body>
</html>