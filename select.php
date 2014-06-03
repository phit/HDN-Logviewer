<html>
<head>
    <title>Server Logs</title>
   	<link rel="stylesheet" type="text/css" href="style.css" media="all">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css"></style>
</head>
<body>
<b>Information</b>
<hr color="000000">
<i>Monthly server chat logs for EuropePublic Hidden: Source Servers</i><br>
- <a href="http://eupublic-hdn.tk" name="Sourcebans" target="_blank">Sourcebans</a><br>
- <a href="https://github.com/phitriz/HDN-Logviewer" name="Github" target="_blank">Github</a><br><br>

<b>Servers</b>
<hr color="000000">
<?php
echo '- <a target="chat" href="srv_1.php?y='.date('Y').'&m='.date('n').'&d='.date('d').'" onClick="parent.days.location=\'srv_2_menu.php\'">#Main Server</a><br>'; 
echo '- <a target="chat" href="srv_2.php?y='.date('Y').'&m='.date('n').'&d='.date('d').'" onClick="parent.days.location=\'srv_2_menu.php\'">#Physics Server</a><br>'; 
?>
</body>
