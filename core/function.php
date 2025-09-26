<?php
function load_json($file){ $path = DATA_DIR."/".$file; return file_exists($path) ? json_decode(file_get_contents($path), true) : []; }
function save_json($file,$data){ file_put_contents(DATA_DIR."/".$file,json_encode($data)); }

$ImageIcon = "📷";
$emojiIcon = "😀";

function parse_emoji($text) {
	$emoji = load_emoji();
	foreach ($emoji as $category)
		foreach ($category as $name => $path)
			$text = str_replace(":[$name]:", "<img src='$path' class='w3-image'>", $text);

	return $text;
}

function load_emoji(){ return load_json("../assets/emoji.json"); }

function load_users(){ return load_json("users.json"); }
function save_users($data){ save_json("users.json",$data); }
function load_rooms(){ return load_json("rooms.json"); }
function save_rooms($data){ save_json("rooms.json",$data); }
function load_messages(){ return load_json("messages.json"); }
function save_messages($data){ save_json("messages.json",$data); }
function load_bans(){ return load_json("bans.json"); }
function save_bans($data){ save_json("bans.json",$data); }
function load_online(){ return load_json("online.json"); }
function save_online($data){ save_json("online.json",$data); }
function load_invite(){ return load_json("invites.json"); }
function save_invite($data){ save_json("invites.json",$data); }
function load_accepted(){ return load_json("accepted_invites.json"); }
function save_accepted($data){ save_json("accepted_invites.json",$data); }
function load_declined(){ return load_json("declined_invites.json"); }
function save_declined($data){ save_json("declined_invites.json",$data); }
function load_typing_private(){ return load_json("typing_private.json"); }
function save_typing_private($data){ save_json("typing_private.json",$data); }
function load_typing(){ return load_json("typing.json"); }
function save_typing($data){ save_json("typing.json",$data); }
function load_private(){ return load_json("private.json"); }
function save_private($data){ save_json("private.json",$data); }

function filter_badword($text) {
	$badwords = ["shit", "bullshit", "piss", "pissed", "ass", "asshole", "bastard", "bitch", "sonofabitch", "dick", "dickhead", "cock", "cocksucker", "prick", "pussy", "slut", "whore", "cum", "cumshot", "blowjob", "handjob", "tit", "tits", "boobs", "boobies", "vagina", "penis", "balls", "nuts", "wanker", "jerkoff", "motherfucker", "goddamn", "damn", "crap", "twat", "cunt", "arse", "arsehole", "retard", "idiot", "moron", "loser", "kill", "die", "murder", "rape", "rapist", "nazi"];
    foreach ($badwords as $word) {
        $pattern = '/\b' . preg_quote($word, '/') . '\b/i';
        $replacement = str_repeat('*', strlen($word));
        $text = preg_replace($pattern, $replacement, $text);
    }
    return $text;
}

function parse_bbcode($text) {
    $bbcode = [
        '/\[b\](.*?)\[\/b\]/is' => '<strong>$1</strong>',
        '/\[u\](.*?)\[\/u\]/is' => '<u>$1</u>',
        '/\[s\](.*?)\[\/s\]/is' => '<del>$1</del>',
        '/\[url=(.*?)\](.*?)\[\/url\]/is' => '<a href="$1" target="_blank" rel="noopener">$2</a>',
        '/\[url\](.*?)\[\/url\]/is' => '<a href="$1" target="_blank" rel="noopener">$1</a>',
        '/\[img\](.*?)\[\/img\]/is' => '<a href="$1" target="_blank"><img class="w3-image" src="$1" style="max-width: 150px; max-height: 150px;" /></a>',
        '/\[size=(\d+)\](.*?)\[\/size\]/is' => '<span style="font-size:${1}px;">$2</span>',
        '/\[quote\](.*?)\[\/quote\]/is' => '<blockquote>$1</blockquote>',
        '/\[code\](.*?)\[\/code\]/is' => '<pre><code>$1</code></pre>'
    ];
    foreach ($bbcode as $pattern => $replace)
        $text = preg_replace($pattern, $replace, $text);
    return $text;
}

function encryptMessage($message) {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length("AES-256-CBC"));
    $encrypted = openssl_encrypt($message, "AES-256-CBC", SECRETKEY, 0, $iv);
    return base64_encode($iv . $encrypted);
}

function decryptMessage($encoded) {
    $data = base64_decode($encoded);
    $ivLength = openssl_cipher_iv_length("AES-256-CBC");
    $iv = substr($data, 0, $ivLength);
    $ciphertext = substr($data, $ivLength);
    return openssl_decrypt($ciphertext, "AES-256-CBC", SECRETKEY, 0, $iv);
}
?>
