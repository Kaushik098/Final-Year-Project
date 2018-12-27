<!DOCTYPE html>
<html>
<head>
	<title>Countdown</title>
	<style type="text/css">
		body{
			background: #f6f6f6;
		}
		.countdownContainer{
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translateX(-50%) translateY(-50%);
			text-align: center;
			background: #ddd;
			border: 1px solid #999;
			padding: 10px;
			box-shadow: 0 0 5px 3px #ccc;
		}
		.info{
			font-size: 80px;
		}
	</style>
</head>
<body>
	<table class="countdownContainer">
		<tr class="info">
			<td colspan="4">Countdown</td>
		</tr>
		<tr class="info">
			<td id="days">120</td>
			<td id="hours">4</td>
			<td id="minutes">12</td>
			<td id="seconds">22</td>
		</tr>
		<tr>
			<td>Days</td>
			<td>Hours</td>
			<td>Minutes</td>
			<td>Seconds</td>
		</tr>
	</table>
</body>
</html>