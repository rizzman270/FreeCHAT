<?php
$emojiIcon = "😀";
$ImageIcon = "📷";

$emojiCategories = [
	"😀" => ["😀","😁","😂","🤣","😅","😊","😍","😘","😎","🤩"],
	"👨" => ["👋","👍","🙏","👏","🙌","🤝","👨‍💻","👩‍🍳","🧑‍🎨","🧑‍🚀"],
	"🐶" => ["🐶","🐱","🐭","🐹","🐰","🦊","🐻","🐼","🐨","🐯"],
	"🍕" => ["🍎","🍊","🍌","🍉","🍇","🍓","🍒","🍑","🥝","🍍"],
	"⚽" => ["⚽","🏀","🏈","⚾","🎾","🏐","🎱","🏓","🥊","🎮"],
	"🌍" => ["🚗","🚕","🚙","🚌","🚎","🏎","🚓","🚑","🚒","🚲"],
	"💡" => ["💡","📱","💻","🖥","⌨️","🖱","💿","📀","📷","🎥"],
	"❤️" => ["❤️","💛","💚","💙","💜","🖤","🤍","💔","❣️","💕"],
	"🏳️" => ["🏳️","🏴","🏁","🚩","🏳️‍🌈","🇺🇸","🇬🇧","🇫🇷","🇩🇪","🇯🇵"],
];

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
?>
