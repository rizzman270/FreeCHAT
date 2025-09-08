<?php
require "config.php";
if(!isset($_SESSION["user"])) exit($lang["message"]["logged"]);
$user=$_SESSION["user"]??"";
$room=$_POST["room"]??"Chill Zone";
$text=$_POST["text"]??"";
$color=$_POST["color"]??"#000000";
$style=$_POST["style"]??"normal";
$users=load_users();
$messages=load_messages();
$use_command=0;
if (substr($text, 0, 1) === '/') {
	$firstSpace = strpos($text, ' ');
	$command = substr($text, 0, $firstSpace);
	$parameters = substr($text, $firstSpace + 1);
	switch ($command) {
		case '/ban':
			if ($users[$user]["is_admin"] == false)
				break;
			$use_command=1;
			$bans=load_bans();
			$bans[$users[$parameters]]=true;
			save_bans($bans);
			$messages[$room][] = [
				"name"=>"Alice",
				"text"=>"<small>". $users[$parameters]['name'] ." ". $lang["message"]["post_banned"] ."</small>",
				"color"=>"#C08856",
				"style"=>"italic",
				"icon"=>"fa-genderless",
				"time"=>date("H:i:s")
			];
			save_messages($messages);
			break;
		case '/unban':
			if ($users[$user]["is_admin"] == false)
				break;
			$use_command=1;
			$bans=load_bans();
			unset($bans[$parameters]);
			save_bans($bans);
			$messages[$room][] = [
				"name"=>"Alice",
				"text"=>"<small>". $users[$parameters]['name'] ." ". $lang["message"]["post_unbanned"] ."</small>",
				"color"=>"#C08856",
				"style"=>"italic",
				"icon"=>"fa-genderless",
				"time"=>date("H:i:s")
			];
			save_messages($messages);
			break;
		case '/clear':
			if ($users[$user]["is_admin"] == false)
				break;
			$use_command=1;
			if ($parameters == "chat") {
				$messages[$room]=[];
				save_messages($messages);
			} else if ($parameters == "all") {
				$messages=[];
				save_messages($messages);
			} /* else if ($parameters == "upload") {
				$dir = DATA_DIR."/upload/"
				if (is_dir($dir))
					foreach (glob($dir . "*") as $file)
						if (is_file($file))
							unlink($file);
			} */
			break;
	}
}
if ($use_command != 1) {
	$text = filter_badword ($text);
	$text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
	$text = parse_bbcode($text);
	$text = parse_emoji($text);
	if(!isset($messages[$room])) $messages[$room]=[];
	$messages[$room][]=["icon"=>$users[$user]["gender"],"user"=>$user,"name"=>$users[$user]["name"],"text"=>$text,"color"=>$color,"style"=>$style,"time"=>date("H:i:s")];
	save_messages($messages);
}
echo "ok";
