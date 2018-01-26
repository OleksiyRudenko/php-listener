<?php
// Create database storage if doesn't exist yet
$query = $dbconnection->prepare("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '". $dbname ."'");
$query->execute();
$query->store_result();
$rows = $query->num_rows;
if ($rows) {
        echo "<pre>Log: Database `$dbname` exists.</pre>";
    }
    else {
		$result = $dbconnection->query("CREATE DATABASE `". $dbname ."`");
		if (!$result) {
			die('<h2 style="color:Red;">Could not create Database ' . $dbname . '</h2>'
			  . '<p style="color:Red;">' . $dbconnection->error . '</p>');
		} else { ?>
			<pre>Log: Database `<?=$dbname?>` has been created</pre>
		<?php
		}
    }
include_once('../php-listener/db-select.php');

// Create table if doesn't exist yet
$query = "CREATE TABLE IF NOT EXISTS `$tbname` ("
 . "id INT(6) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,"
 . "ts TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,"
 . "headers TEXT NOT NULL,"
 . "payload TEXT NOT NULL,"
 . " INDEX ts (ts)"
 . ") ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
if (!$result = $dbconnection->query($query)) {
	die('<h2 style="color:Red;">Could not create Table ' . $tbname . '</h2>'
			  . '<p style="color:Red;">' . $dbconnection->error . '</p>');
}
?>