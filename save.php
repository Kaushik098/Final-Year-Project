<?php

	
	$mysqli = new mysqli($host,$user,$pass,$db);

	$vote = $_REQUEST['vote'];

	$sql = "UPDATE tbcandidates SET candidate_cvotes=candidate_cvotes+1 WHERE candidate_name='$vote'";

	mysqli_query($mysqli, $sql);

	mysqli_close($con);
?> 