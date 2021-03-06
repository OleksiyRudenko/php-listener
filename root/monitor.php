<?php
	include_once('../php-listener/time-tz-reset.php');
?><!DOCTYPE html>
  <html lang="en">
	<meta charset="UTF-8">
    <title>Simple HTTP POST listener</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href='https://fonts.googleapis.com/css?family=Overpass%20Mono' rel='stylesheet'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.4/css/all.css">
    <link rel="stylesheet" href="https://cdn.rawgit.com/OleksiyRudenko/normalize.css/28e3dc36/normalize.css">
    <link rel="stylesheet" href="https://cdn.rawgit.com/OleksiyRudenko/default-beauty.css/482728bd/default-beauty.css">
	<style>
	  .entry {
		  margin-bottom: 1em;
		  background-color: #eee;
		  font-family: Courier New, Courier, monospace, sans-serif;
		  font-size: 90%;
	  }
	  .ts {
		  font-weight: bold;
		  font-size: 120%;
	  }
	  .headers {
		  color: Blue;
	  }
	</style>
</head>
<body>
<p>Current UTC timestamp: <code><?=$currentDateUTC?></code></p>
<?php
include_once('../php-listener/db-connect.php');
include_once('../php-listener/db-select.php');

$query = "SELECT * FROM `$tbname` ORDER BY ts DESC LIMIT 10";
$result = $dbconnection->query($query);
if (!$result) {
	die('<p style="color:Blue;">No data in DB</p>');
} else {
	while ($row = $result->fetch_assoc()) { // id, ts, headers, payload
	?>
		<div class="entry">
			<div class="ts"><?=$row['ts']?> UTC</div>
			<div class="headers"><pre>Headers (as JSON):<br/><?=$row['headers']?></pre></div>
			<div class="payload"><pre>Payload:<br/><br/><?=$row['payload']?></pre></div>
		</div>
	<?php
	}
}
$autorefresh = TRUE;
if (array_key_exists('autorefresh',$_GET))
   $autorefresh = $_GET['autorefresh'];

if ($autorefresh) {
?>
	<script>
		setTimeout(function(){location='';},500);
	</script>
<?php
}
?>
</body>
</html>