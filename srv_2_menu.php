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
<b><?php 
echo date('F Y');
?></b>
<hr color="000000">
<?php
$num_of_days = date('d');    
for( $i=$num_of_days; $i>= 1; $i--)
{
 echo '- <a target="chat" href="srv_2.php?y='.date('Y').'&m='.date('n').'&d='. str_pad($i,2,'0', STR_PAD_LEFT).'">'. str_pad($i,2,'0', STR_PAD_LEFT).'.'.date('m.Y').'</a><br>'; 
}
?>
<br>
<b><?php 
echo date('M Y', strtotime("-1 month"));
?></b>
<hr color="000000">
<?php 
$num2_of_days = date('t', strtotime("-1 month"));
for( $i=$num2_of_days; $i>= 1; $i--)
{
 echo '- <a target="chat" href="srv_2.php?y='.date('Y', strtotime("-1 month")).'&m='.date('n', strtotime("-1 month")).'&d='. str_pad($i,2,'0', STR_PAD_LEFT).'">'. str_pad($i,2,'0', STR_PAD_LEFT).'.'.date('m.Y', strtotime("-1 month")).'</a><br>'; 
}
?>
</body>
