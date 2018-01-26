<?php
	include_once('../php-listener/time-tz-reset.php');
    $autorefresh = TRUE;
	if (array_key_exists('autorefresh',$_GET))
	   $autorefresh = $_GET['autorefresh'];
    $purgedb = FALSE;
    if (array_key_exists('db',$_GET) && $_GET['db'] === 'purge')
	   $purgedb = TRUE;

?><html>
<head>
	<title>Simple HTTP POST listener</title>
	<style>
	  #monitor {
		  border: 1px solid Gray;
		  border-radius: 5px;
		  width: 90%;
		  height: 200%;
		  max-height: 400%;
		  overflow: auto;
	  }
	</style>
</head>
<body>
	<h1>Simple HTTP listener</h1>
	<a href='/index-dflt.php' target="_blank">Server info</a>
	<?php
	include_once('../php-listener/db-connect.php');
	include_once('../php-listener/db-create.php');
	if ($purgedb) include_once('../php-listener/db-purge.php');
	?>
	<p>Requests are listened at URL 
	   <input id="url-src" type="text" size="48" 
	   onchange="handleUrlChange()"
	   value="<?=$_SERVER['REQUEST_SCHEME']?>://<?=$_SERVER['SERVER_ADDR']?>:<?=$_SERVER['SERVER_PORT']?>/listener.php"
	   />
	</p>
	<p>NB! If IP address is missing in URL above, please, re-access this service using IP address of the computer that hosts
	   this web-server.
	</p>
		
	<div><form id="post-form" method="POST" action="listener.php" target="_blank"
		onsubmit="setTimeout(function(){window.location.reload();},250)">
		<input type="text" name="userTextInput" value="Test POST" />
		<input type="Submit" name="action" value="Send test POST" />
	</form></div>
	<div><form id="get-form" method="GET" action="listener.php" target="_blank" 
		onsubmit="setTimeout(function(){window.location.reload();},250)">
		<input type="text" name="userTextInput" value="Test GET" />
		<input type="Submit" name="action" value="Send test GET" />
	</form></div>
	<p>
		<a href="/?autorefresh=<?=($autorefresh)?0:1?>">Turn autorefresh <?=($autorefresh)?'OFF':'ON'?></a>
		<?php
			if (!$autorefresh) {
		?>
			/ <a href="/?autorefresh=0">Refresh once</a>
		<?php
			}
		?>
	</p>
	<p>
		Showing latest requests (10 max).
		<a href='/phpmyadmin' target="_blank">Database browser</a>
		(Default credentials <code>root</code> / <code>usbw</code>) 
		/ <a href="/?autorefresh=<?=$autorefresh?>&db=purge">Purge db `<?=$dbname?>`</a>
	</p>
	<iframe id="monitor" src="monitor.php?autorefresh=<?=$autorefresh?>">
	</iframe>
	<script>
		function handleUrlChange() {
			src = document.getElementById('url-src').value;
			target = document.getElementById('get-main');
			target.action = src;
		}
	</script>
</body>
</html>