<html>
	<head>
		<link href="admin_styles.css" rel="stylesheet" type="text/css" />
	</head>
	<body bgcolor="tan">
		
		<div id="page">
			<div id="header">
				<h1>Logged Out Successfully </h1>
				<p align="center">&nbsp;</p>
			</div>
			<div align="center">
				<?php
					session_start();
					session_destroy();
				?>
				You have been successfully logged out of your control panel.<br><br><br>
				Return to <a href="index.php"><font color="blue">Login</font></a>
			</div>
			<div id="footer">
				<div class="bottom_addr">&copy; Prepared by RMKCET</div>
			</div>
		</div>
	</body>
</html>