<?php
if(!is_dir('./data')) mkdir('./data', 0777, true);
if(!is_dir('./data/upload')) mkdir('./data/upload', 0777, true);
$defaultUsers = [
	"Admin"=>["password"=>password_hash("Passw0rd",PASSWORD_DEFAULT),"name"=>"Admin","gender"=>"fa-mars","theme"=>"light","language"=>"en_us","invite"=>"no","is_admin"=>true],
	"Guest"=>["password"=>password_hash("Passw0rd",PASSWORD_DEFAULT),"name"=>"Guest","gender"=>"fa-mars","theme"=>"light","language"=>"en_us","invite"=>"no","is_admin"=>false]
];
file_put_contents('./data/users.json',json_encode($defaultUsers));
$defaultRooms = [
	"Chill Zone"=>["description"=>"Relaxed conversations, anywhere, anytime."],
	"Daily Chatter"=>["description"=>"Casual conversations about anything and everything."],
	"Local Events"=>["description"=>"Share meetups, events, and local tips."],
	"Feedback & Suggestions"=>["description"=>"Submit feedback and ideas for the community."],
	"Local Politics"=>["description"=>"City and regional political discussion."],
	"Global Affairs"=>["description"=>"International news, diplomacy, and geopolitics."],
	"Policy & Analysis"=>["description"=>"In-depth breakdowns of policy proposals and impacts."],
	"Budget Travel Tips"=>["description"=>"Save money on transport, lodging, and food."],
	"City Guides"=>["description"=>"Recommendations and must-sees for major cities."],
	"Adventure & Outdoors"=>["description"=>"Hiking, camping, and nature trips."],
	"Long-term & Digital Nomads"=>["description"=>"Living abroad, visas, and remote work logistics."],
	"Multiplayer Lobby"=>["description"=>"Find teammates and organize matches."],
	"Indie Spotlight"=>["description"=>"Discuss indie titles and hidden gems."],
	"Strategy & Guides"=>["description"=>"Walkthroughs, tips, and meta discussion."],
	"Retro & Classics"=>["description"=>"Nostalgia for classic games and consoles."],
	"Football/Futbol"=>["description"=>"Match discussion, leagues and transfers."],
	"Basketball"=>["description"=>"NBA, Euroleague, and pickup tips."],
	"Fitness & Training"=>["description"=>"Training plans, recovery, and conditioning."],
	"Motorsports"=>["description"=>"Racing news and event threads."],
	"Community Matchups"=>["description"=>"Organize amateur matches and leagues."],
	"Photography"=>["description"=>"Sharing shots, gear advice, and critiques."],
	"Crafts & DIY"=>["description"=>"Projects, tutorials, and materials."],
	"Books & Writing"=>["description"=>"Reading recommendations and writing workshops."],
	"Collecting Corner"=>["description"=>"Cards, coins, figures and other collections."],
	"Event Planning"=>["description"=>"Organize parties, potlucks, and festivals."],
	"Music & DJs"=>["description"=>"Share mixes, playlists, and stage tips."],
	"Decor & Themes"=>["description"=>"Decoration ideas and party aesthetics."],
	"Dark Fantasies"=>["description"=>"A place to talk openly about kinks, roleplay themes, and boundaries. Mature, respectful only."],
	"Roleplay Zone"=>["description"=>"Immersive adult roleplay and character-driven scenarios. Keep it consensual."],
	"Seduction & Desire"=>["description"=>"Conversations exploring attraction, dominance, submission, and erotic energy."],
	"Kinks & Fetishes"=>["description"=>"Open talk about different preferences, limits, and safe exploration."],
	"Experiences & Stories"=>["description"=>"Sharing real encounters, lessons, and adult situations (non-graphic)."],
	"Lifestyles & Exploration"=>["description"=>"Discussion of open relationships, swinging, BDSM, and other lifestyles."]
];
file_put_contents('./data/rooms.json',json_encode($defaultRooms));
header("location: login.php");
?>
