<html>
	<head>
		
		
		
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="css/normalize.css" rel="stylesheet" type="text/css">
	    <link href="css/skeleton.css" rel="stylesheet" type="text/css">
		<link href="css/custom.css" rel="stylesheet" type="text/css">
		<h1 class="title">Real Time Bus Information</h1>
	</head>
	<body>
		<form action="index.php" method="post" name="form1">
			<div align="center" >
				<input type = "radio" name = "choice" value = "bus">Bus
				<input type = "radio" name = "choice" value = "rail">Irish Rail
			</div>
			<nav>
			<div class="row">
					
				
 				<input type = "text" class="search"  name = "code" placeholder = "Stop number / Station Code" required></td>
 			
 				<input type = "submit" class="button-primary" value="Search">
			</div>
		</form>
		<?php
			if(isset($_POST['code']) && isset($_POST['choice']))
			{
				$choice1 = $_POST['choice'];
				if($choice1 == "bus")
				{
				$stop_num = $_POST['code'];
				
				$url = 'https://data.dublinked.ie/cgi-bin/rtpi/realtimebusinformation?stopid='.$stop_num.'&format=xml';
				
				$xml = simplexml_load_file($url);
				echo '<div align = "center">';
				echo '<h3>Stop number:'.$stop_num.'</h3>';
				echo "Last updated :".$xml->timestamp;
				echo "</div>";
				?>

				<div align="center">
				<table border="1">
					<th> Bus number </th>
					<th> Origin </th>
					<th> Destination </th>
					<th> Due time </th>

					<?php
					foreach ($xml->results -> result as $result) {
						echo '
						<tr>
							<td>'.$result->route.'</td>
							<td>'.$result->origin.'</td>
							<td>'.$result->destination.'</td>
							<td>'.$result->duetime.'</td>

						</tr>'
						;
						# code...
					}



				echo "</table>";
				echo "</div>";

			}
			elseif($choice1 == "rail")
			{
				$Station_code = $_POST['code'];
				$Rail_url = 'http://api.irishrail.ie/realtime/realtime.asmx/getStationDataByCodeXML?StationCode='.$Station_code;
				$xml_rail = simplexml_load_file($Rail_url);
				echo '<div align = "center">';
				echo '<h3>Station Name: '.$xml_rail->objStationData->Stationfullname.'</h3>';
				echo "</div>";
				?>
				<div align="center">
					<table border="1">
						<th>Train Code</th>
						<th>Origin</th>
						<th>Destination</th>
						<th>Status</th>
						<th>Last Location</th>
						<th>Due time</th>
						<?php
						foreach ($xml_rail->objStationData as $result) {
							echo '
						<tr>
							<td>'.$result->Traincode.'</td>
							<td>'.$result->Origin.'</td>
							<td>'.$result->Destination.'</td>
							<td>'.$result->Status.'</td>
							<td>'.$result->Lastlocation.'</td>
							<td>'.$result->Duein.'</td>

						</tr>'
						;

							# code...
						}

					echo "</table>";
					echo "</div>";
				
			}
		}

			
		?>
		
		
			
	</body>
</html>




