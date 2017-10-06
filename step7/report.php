<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Felis Investigations Case Report</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="lib/css/felis.css">
</head>

<body>
<div class="report">
<nav>
	<ul class="left">
		<li><a href="./">The Felis Agency</a></li>
	</ul>
	<ul class="right">
		<li><a href="staff.php">Staff</a></li>
		<li><a href="cases.php">Cases</a></li>
		<li><a href="case.php">Case</a></li>
		<li><a href="./">Log out</a></li>
	</ul>
</nav>

<header class="main">
	<h1><img src="images/comfortable.png" alt="Felis Mascot"> Felis Case Report<img src="images/comfortable.png" alt="Felis Mascot"></h1>
</header>

<form>
	<fieldset>
		<legend>Case Report</legend>
		<p class="right"><a href="case.php">Back to Case</a></p>
		<p>Client: Helm, Levon</p>
		<p>Case: Felix caterwauling every night.</p>

		<h2>Report</h2>
		<div class="report">
		<p>
			<label for="date">Date and Time (for the activity)</label><br>
			<input type="text" id="date" name="date" placeholder="mm/dd/yyyy h:mmam">
		</p>
		<p>
			<label for="summary">Summary</label><br>
			<textarea id="summary" name="summary" placeholder="Summary">Surveillance of neighborhood for two hours. Spotted a very attractive Siamese cat wandering though. Caterwauling commenced.</textarea>
		</p>
		<p>
			<label for="detail">Detail</label><br>
			<textarea id="detail" name="detail" placeholder="Detail">Arrived at 1:00am. Everything was quiet for about an hour. Suddenly, a Siamese cat wandered by and the caterwauling began. I think the Siamese was enjoying the attention, since she hung around for over an hour. Felix didn't shut up until she finally left. She didn't seem interested in him, though.</textarea>
		</p>
		<p>
			<input type="submit" value="OK">
		</p>

		</div>
		<h2>Pictures</h2>
		<table>
			<tr><th>&nbsp;</th><th>Time</th><th>Description</th></tr>
			<tr><td><a href="images/offender.jpg"><img src="images/offender.jpg" alt="Offender image"></a></td><td>2:05am</td><td>The offender</td></tr>
		</table>

		<p class="center">
			<label for="desc">New photo description: </label>
			<input type="text" id="desc" name="desc" placeholder="Description"></p>
		<p class="center">
			<input type="file">
			<input type="submit" value="OK">
		</p>

	</fieldset>
</form>


<footer>
	<p>Copyright © 2016 Felis Investigations, Inc. All rights reserved.</p>
</footer>

</div>

</body>
</html>
