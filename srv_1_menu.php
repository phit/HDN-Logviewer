<html>
<head>
    <title>days menu server_1</title>
   	<link rel="stylesheet" type="text/css" href="style.css" media="all">
   	
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css"></style>
</head>
<body>
<b><?php 
echo date('F Y');
?></b>
<hr color="000000">
<?php

$num_of_days = date('d');    
for( $i=1; $i<= $num_of_days; $i++)
{
 echo '- <a target="chat" href="srv_1.php?y='.date('Y').'&m='.date('n').'&d='. str_pad($i,2,'0', STR_PAD_LEFT).'">'. str_pad($i,2,'0', STR_PAD_LEFT).'.'.date('m.Y').'</a><br>'; 
}


?>
</body>