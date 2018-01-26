<?php
// Purge database
$query = "DELETE FROM `$tbname` WHERE 1";
if (!$result = $dbconnection->query($query)) {
	die('<h3 style="color:Red;">Failed to purge Table ' . $tbname . '</h3>'
			  . '<p style="color:Red;">' . $dbconnection->error . '</p>');
} else {?>
	<pre>Log: Table `<?=$tbname?>` has been purged</pre>
<?php
}
?>