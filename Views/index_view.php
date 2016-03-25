<!DOCTYPE html>
<html>

	<head>
		<title>Photo Search</title>
	</head>

	<body style="background-color: #0084b4">

		<h1 style="font-family:sans-serif; color:white" align='center' >Search</h1>

		<form id="mainForm"class="form" action="index.php" method="get" align='center'>

			<input type="text" name="location" placeholder="location"><br>
			<select name="distance" form="mainForm">
				<option value=""></option>
				<option value="5">5</option>
				<option value="10">10</option>
				<option value="15">15</option>
				<option value="20">20</option>
				<option value="25">25</option>
				<option value="30">30</option>
				<option value="35">35</option>
				<option value="40">40</option>
				<option value="45">45</option>
				<option value="50">50</option>
			</select><br>
			<input type="submit" value="Submit">

		</form>

		


	</body>

</html>