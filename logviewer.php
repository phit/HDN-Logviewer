<html>
	<head>
		<title>Hidden Source ChatLog</title>
		<!-- refresh every 45seconds -->
		<meta http-equiv="refresh" content="45" >
		<style>
			body
			{
				background-color: #333;
				font-family: verdana, arial;
				font-size: 12px;
			}
			.dat
			{
				border: 1px solid #000;
				background-color: #EEE;
				padding: 10px;
				margin: 10px;
				width: 700px;
				margin-left: auto;
				margin-right: auto;
			}
			#fright
			{
				float:right;
			}
		</style>
	</head>
	<body>
		<div class="dat">
			Title/Navigation whatever
		</div>
		<div class="dat">
<?php
@ini_set("memory_limit","128M");

// SET PATH TO YOUR LOG DIRECTORY HERE
define('LOG_DIR', '.\logs\\');

function GetFriendID($authString)
{
	$authString = substr($authString,6,strlen($authString));
	$auth = explode(":",$authString);
	$friendID = "7656".number_format($auth[2] * 2 + $auth[1] + 1197960265728, 0, '.', '');
	return $friendID;
}

echo 'Main Server Chat Logs for '.date("l jS \of F Y").'<br><br>';
$year = !empty($_GET['y']) ? (int)$_GET['y'] : (int)date("Y");
$month = !empty($_GET['m']) ? (int)$_GET['m'] : (int)date("n");
$day = !empty($_GET['d']) ? (int)$_GET['d'] : (int)date("j");

$dir = opendir(LOG_DIR);
while($file = readdir($dir))
	// get logfiles for current day
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
		if(ereg("([0-9]{2}:[0-9]{2}:[0-9]{2}): \"(.+)<[0-9]+><(STEAM_[0-9]{1}:[0-9]{1}:[0-9]+)><[A-Za-z]+>\" (say) \"(.*)\"", $item, $items))
			echo $items[1]." [ALL] &lt;<a href='http://steamcommunity.com/profiles/".GetFriendID($items[3])."' target='_blank'>".str_replace("<","&lt;",str_replace(">","&gt;",$items[2]))."</a>&gt;: ".str_replace("<","&lt;",str_replace(">","&gt;",$items[5]))."<br>\r\n";
		
		// Team Chat messages
		elseif(ereg("([0-9]{2}:[0-9]{2}:[0-9]{2}): \"(.+)<[0-9]+><(STEAM_[0-9]{1}:[0-9]{1}:[0-9]+)><[A-Za-z]+>\" (say_team) \"(.*)\"", $item, $items))
			echo $items[1]." [TEAM] &lt;<a href='http://steamcommunity.com/profiles/".GetFriendID($items[3])."' target='_blank'>".str_replace("<","&lt;",str_replace(">","&gt;",$items[2]))."</a>&gt;: ".str_replace("<","&lt;",str_replace(">","&gt;",$items[5]))."<br>\r\n";
		
		// Console Chat messages
		elseif(ereg("([0-9]{2}:[0-9]{2}:[0-9]{2}): \"(.+)<0><Console><Console>\" (say) \"(.*)\"", $item, $items))
			echo $items[1]." &lt;Console&gt;: ".str_replace("<","&lt;",str_replace(">","&gt;",$items[4]))."<br>\r\n";
		
		// Player Join messages
		elseif($_GET['join'] !== "1" && ereg("([0-9]{2}:[0-9]{2}:[0-9]{2}): \"(.+)<[0-9]+><(STEAM_[0-9]{1}:[0-9]{1}:[0-9]+)><>\" entered the game", $item, $items))
			echo $items[1]." &lt;<a href='http://steamcommunity.com/profiles/".GetFriendID($items[3])."' target='_blank'>".str_replace("<","&lt;",str_replace(">","&gt;",$items[2]))."</a>&gt; entered the game<br>\r\n";
		
		// Ignore Bot Join messages (could be merged with Bot Leave)
		elseif($_GET['join'] !== "1" && ereg("([0-9]{2}:[0-9]{2}:[0-9]{2}): \"Bot[0-9]+<[0-9]+><BOT><>\" entered the game", $item, $items))
			echo "";
		
		// Ignore Bot Leave messages
		elseif($_GET['join'] !== "1" && ereg("([0-9]{2}:[0-9]{2}:[0-9]{2}): \"Bot[0-9]+<[0-9]+><BOT><[A-Za-z]+>\" disconnected (.*)", $item, $items))
			echo "";			
		
		// Player Leaves
		elseif($_GET['join'] !== "1" && ereg("([0-9]{2}:[0-9]{2}:[0-9]{2}): \"(.+)<[0-9]+><(STEAM_[0-9]{1}:[0-9]{1}:[0-9]+)><(.*)>\" disconnected (.*)", $item, $items))
			echo $items[1]." &lt;<a href='http://steamcommunity.com/profiles/".GetFriendID($items[3])."' target='_blank'>".str_replace("<","&lt;",str_replace(">","&gt;",$items[2]))."</a>&gt; disconnected ".str_replace("<","&lt;",str_replace(">","&gt;",$items[5]))."<br>\r\n";
		
		// output if url parameter ?debug=1
		elseif($item && $_GET['debug'] == "1")
			echo "".$item."<br>";
}
else
	echo "Nothing found (I probably fucked up or it's midnight)";
	/* logfiles change name first mapchange after midnight, so you might have a blank page for a few minutes */

?>
		<br>
		<!-- you're allowed to remove this but i'd prefer if you give me credit -->
		<pre id="fright"><a href="https://github.com/phitriz/HDN-Logviewer">&copy; phit 2014</a></pre>
		</div>
	</body>
</html>
