<html>
<head>
	<title>ChatLog server_1</title>
   	<link rel="stylesheet" type="text/css" href="style.css" media="all">
   	
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<div class="dat">
<?php
@ini_set("memory_limit","128M");
define('LOG_DIR', '.\logsmain\\');

function GetFriendID($authString)
{
	$authString = substr($authString,6,strlen($authString));
	$auth = explode(":",$authString);
	$friendID = "7656".number_format($auth[2] * 2 + $auth[1] + 1197960265728, 0, '.', '');
	return $friendID;
}
$year2 = empty($_GET['y']) ? date("Y") : $_GET['y'];
$month2 = empty($_GET['m']) ? date("n") : $_GET['m'];
$day2 = empty($_GET['d']) ? date("j") : $_GET['d'];

echo '<b>Main Server Chat Logs for '.$day2.'.'.$month2.'.'.$year2.' - Timezone UTC + 2 hours </b><b id="rfloat"><a href="javascript:history.go(0)">refresh the page</a></b>';
echo '<hr color="000000">';

$year = !empty($_GET['y']) ? (int)$_GET['y'] : (int)date("Y");
$month = !empty($_GET['m']) ? (int)$_GET['m'] : (int)date("n");
$day = !empty($_GET['d']) ? (int)$_GET['d'] : (int)date("j");

$dir = opendir(LOG_DIR);
while($file = readdir($dir))
	if($file != "." && $file != ".." && substr($file, 0, 5)=="l".($month<10?"0".$month:$month).($day<10?"0".$day:$day) && substr($file, -4)==".log")
	{
		$lines = file(LOG_DIR.$file);
		foreach($lines as $line)
			if(strpos(strtolower($line), ">\" say \"")!==FALSE || strpos(strtolower($line), ">\" say_team \"")!==FALSE || strpos(strtolower($line), ">\" entered the game")!==FALSE || strpos(strtolower($line), ">\" disconnected ")!==FALSE)
				$history[(int)substr($line, 8, 4)][(int)substr($line, 2, 2)][(int)substr($line, 5, 2)][] = substr($line, 15);
	}

if(count($history[$year][$month][$day])>0)
{
	//array reverse to show newest first
	foreach(array_reverse($history[$year][$month][$day]) as $item)
		// messy regex with deprecated function ._.
		// All Chat messages
		if(ereg("([0-9]{2}:[0-9]{2}:[0-9]{2}): \"(.+)<[0-9]+><(STEAM_[0-9]{1}:)([0-9]{1}:[0-9]+)><[A-Za-z]+>\" (say) \"(.*)\"", $item, $items))
			echo "[".$items[1]."] <a href='http://steamcommunity.com/profiles/".GetFriendID($items[3] . $items[4])."' target='_blank'>".str_replace("<","&lt;",str_replace(">","&gt;",$items[2]))."</a> ( ".$items[4]." ) : ".str_replace("<","&lt;",str_replace(">","&gt;",$items[6]))."<br>\r\n";
		
		// Team Chat messages
		elseif(ereg("([0-9]{2}:[0-9]{2}:[0-9]{2}): \"(.+)<[0-9]+><(STEAM_[0-9]{1}:)([0-9]{1}:[0-9]+)><[A-Za-z]+>\" (say_team) \"(.*)\"", $item, $items))
			echo "[".$items[1]."] [T] <a href='http://steamcommunity.com/profiles/".GetFriendID($items[3] . $items[4])."' target='_blank'>".str_replace("<","&lt;",str_replace(">","&gt;",$items[2]))."</a> ( ".$items[4]." ) : ".str_replace("<","&lt;",str_replace(">","&gt;",$items[6]))."<br>\r\n";
		
		// Console Chat messages
		elseif(ereg("([0-9]{2}:[0-9]{2}:[0-9]{2}): \"(.+)<0><Console><Console>\" (say) \"(.*)\"", $item, $items))
			echo "[".$items[1]."] Console: ".str_replace("<","&lt;",str_replace(">","&gt;",$items[4]))."<br>\r\n";
		
		// Player Join messages
		elseif($_GET['join'] !== "1" && ereg("([0-9]{2}:[0-9]{2}:[0-9]{2}): \"(.+)<[0-9]+><(STEAM_[0-9]{1}:)([0-9]{1}:[0-9]+)><>\" entered the game", $item, $items))
			echo "[".$items[1]."] <span style=\"color: #77b\"><i>Player <span style=\"color: #000;\">".str_replace("<","&lt;",str_replace(">","&gt;",$items[2]))."</span> ( <span style=\"color: #000;\">".$items[4]."</span> ) joined the server</i></span><br>\r\n";
		
		// Ignore Bot Join messages (could be merged with Bot Leave)
		elseif($_GET['join'] !== "1" && ereg("([0-9]{2}:[0-9]{2}:[0-9]{2}): \"Bot[0-9]+<[0-9]+><BOT><>\" entered the game", $item, $items))
			echo "";
		
		// Ignore Bot Leave messages
		elseif($_GET['join'] !== "1" && ereg("([0-9]{2}:[0-9]{2}:[0-9]{2}): \"Bot[0-9]+<[0-9]+><BOT><[A-Za-z]+>\" disconnected (.*)", $item, $items))
			echo "";			
		
		// Player Leaves
		elseif($_GET['join'] !== "1" && ereg("([0-9]{2}:[0-9]{2}:[0-9]{2}): \"(.+)<[0-9]+><(STEAM_[0-9]{1}:)([0-9]{1}:[0-9]+)><(.*)>\" disconnected (.*)", $item, $items))
			echo "[".$items[1]."] <span style=\"color: #b77\"><i>Player <span style=\"color: #000;\">".str_replace("<","&lt;",str_replace(">","&gt;",$items[2]))."</span> ( <span style=\"color: #000;\">".$items[4]."</span> ) left the server ".$items[6]."</i></span><br>\r\n";
		
		// output if url parameter ?debug=1
		elseif($item && $_GET['debug'] == "1")
			echo "".$item."<br>";
}
else
	echo "Nothing found (I probably fucked up or it's midnight)";

?>
		<hr color="000000">
		» eupublic-hdn.tk, &copy; <a href="https://github.com/phitriz/HDN-Logviewer">phit 2014</a>
		</div>
	</body>
</html>