<?php
/*
 required in php.ini:
   always_populate_raw_post_data = On
  
*/
include_once('../php-listener/time-tz-reset.php');
include_once('../php-listener/db-connect.php');
include_once('../php-listener/db-select.php');

$request_time = explode('.',$_SERVER['REQUEST_TIME_FLOAT']); // [unixtime,msec]
$timestamp = date("Y-m-d H:i:s",$request_time[0]) . '.' . $request_time[1];

$headers = json_encode(apache_request_headers(),JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

$request_body = file_get_contents('php://input');
$request_body = 'php non-multipart POST request body: ' . "\n" . ((strlen($request_body)>0)?$request_body:NULL);
$request_body .= "\n\n".'php $_GET: ' . var_export($_GET,TRUE);
$request_body .= "\n\n".'php $_POST: ' . var_export($_POST,TRUE);
$request_body .= "\n\n".'php $_FILES: '.var_export($_FILES,TRUE);


// save request
$query = "INSERT INTO `$tbname` "
 . "(ts,headers,payload)"
 . "VALUES"
 . "("
 . "'".$timestamp."',"
 . "'".$dbconnection->real_escape_string($headers)."',"
 . "'".$dbconnection->real_escape_string($request_body)."'"
 . ")";
if (!$result = $dbconnection->query($query)) {
	die('<h3 style="color:Red;">Failed to write into Table ' . $tbname . '</h3>'
			  . '<p style="color:Red;">' . $dbconnection->error . '</p>');
} else {?>
	<h3 style="color: Green">Request stored successfully</h3>
<?php
}


// save multiparts as files
$uploads_dir = './post-files';
foreach ($_FILES as $key => $fileprops) {
  if ($fileprops['error'] == UPLOAD_ERR_OK) {
    $tmp_name = $fileprops['tmp_name'];
    $name = basename($fileprops['name']);

    /* $query = "INSERT INTO `$tbname` "
     . "(ts,headers,payload)"
     . "VALUES"
     . "("
     . "'".$timestamp."',"
     . "'".$dbconnection->real_escape_string($tmp_name)."',"
     . "'".$dbconnection->real_escape_string("$uploads_dir/$name")."'"
     . ")";
    $dbconnection->query($query); */

    move_uploaded_file($tmp_name, "$uploads_dir/$name");
  }
}

$dbconnection->close();
?>
<script>
  setTimeout(function(){window.close();},100);
</script>