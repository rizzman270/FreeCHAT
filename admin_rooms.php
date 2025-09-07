<?php
	require "core/config.php";
	if(!isset($_SESSION["user"])) header("Location: login.php");
	$user=$_SESSION["user"];
	$users=load_users();
	if ($users[$user]["is_admin"] == false) die($lang["message"]["is_admin"]);
	$table_theme = "w3-theme-light";
	$rooms=load_rooms();
	$message="";
	if($_SERVER["REQUEST_METHOD"]==="POST"){
		$action=$_POST["action"]??"";
		$room=$_POST["room"]??"";
		$desc=$_POST["desc"]??"";
		if($action==="add" && $room){ $rooms[$room]=["description"=>$desc]; $message=$lang["message"]["add"]; }
		if($action==="delete" && isset($rooms[$room])){ unset($rooms[$room]); $message=$lang["message"]["delete"]; }
		save_rooms($rooms);
	}
	$table_theme = "w3-theme-light";

	include "core/header.php";

	echo '
		<div class="w3-theme-white">
			<header class="w3-container w3-text-theme">
				<h4><strong><i class="fas fa-house"></i> '. $lang["admin_rooms"]["title"] .'</strong> '. $message .'</h4>
			</header>
			<div class="w3-row-padding w3-margin-bottom">
				<form method="post" enctype="multipart/form-data">
					<table class="w3-table w3-striped w3-theme-white">
						<tr class="w3-theme w3-border w3-border-theme-light">
							<td class="w3-center"><b>'. $lang["admin_rooms"]["room"] .'</b></td>
							<td class="w3-hide-small w3-center" style="width: 55%"><b>'. $lang["admin_rooms"]["description"] .'</b></td>
							<td class="w3-center" style="width: 25%"><b>'. $lang["admin_rooms"]["option"] .'</b></td>
						</tr>
	';

	$room_names = $room_description = [];
	$total_pages = 0;
	foreach($rooms as $r=>$data) {
		$room_names[$total_pages] = $r;
		$room_description[$total_pages] = $data["description"];
		$total_pages += 1;
	}

	$adjacents = 6;
	$targetpage = "admin_rooms.php";
	$limit = 15;
	$page = $_GET['page'];
	if ($page) 
		$start = ($page - 1) * $limit;
	else
		$start = 0;
	if ($page == 0)
		$page = 1;
	$prev = $page - 1;
	$next = $page + 1;
	$lastpage = ceil($total_pages/$limit);
	$lpm1 = $lastpage - 1;
	$pagination = "";

	$i = $start;
	while (1) {
		if ($table_theme == "w3-theme-light")
			$table_theme = "w3-theme-white";
		else
			$table_theme = "w3-theme-light";

		echo '
						<tr class="w3-theme-white">
							<td class="w3-border '. $table_theme .' w3-border-theme-light w3-hover-text-theme" style="vertical-align: middle;">
								<b>'. htmlspecialchars($room_names[$i]) .'</b>
							</td>
							<td class="w3-hide-small '. $table_theme .' w3-border w3-border-theme-light" style="vertical-align: middle;">
								'. htmlspecialchars($room_description[$i]??"") .'
							</td>
							<td class="w3-center '. $table_theme .' w3-border w3-border-theme-light" style="vertical-align: middle;">
								<a class="w3-button w3-theme w3-hover-theme" href="core/chat_clear.php?room='. htmlspecialchars($room_names[$i]) .'"><i class="fas fa-trash-alt"></i> <span class="w3-hide-small">'. $lang["button"]["clear"] .'</span></a>
								<input type="hidden" name="action" value="delete">
								<input type="hidden" name="room" value="'. htmlspecialchars($room_names[$i]) .'">
								<button class="w3-button w3-theme w3-hover-theme" type="submit" name="submit"><i class="fas fa-trash"></i> <span class="w3-hide-small">'. $lang["button"]["delete"] .'</span></button>
							</td>
						</tr>
		';

		if ($i > $total_pages - 2)
			break;
		else {
			if ($i > $limit * $page)
				break;
			else
				$i++;
		}
	}

	echo '
					</table>
				</form>
			</div>
	';

	if ($lastpage > 1) {	
		if ($page > 1) 
			$pagination.= "<a class='w3-button w3-theme-white w3-hover-theme' href='". $targetpage ."?page=". $prev ."'><</a> ";
		else
			$pagination.= "<span class='w3-button w3-theme-white w3-hover-theme'><</span> ";	

		if ($lastpage < 7 + ($adjacents * 2)) {	
			for ($counter = 1; $counter <= $lastpage; $counter++) {
				if ($counter == $page)
					$pagination.= "<span class='w3-button w3-theme-white w3-hover-theme'>". $counter ."</span>";
				else
					$pagination.= "<a class='w3-button w3-theme-white w3-hover-theme' href='". $targetpage ."?page=". $counter ."'>". $counter ."</a>";				
			}
		} else if($lastpage > 5 + ($adjacents * 2)) {
			if($page < 1 + ($adjacents * 2)) {
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
					if ($counter == $page)
						$pagination.= "<span class='w3-button w3-theme-white w3-hover-theme'>". $counter ."</span>";
					else
						$pagination.= "<a class='w3-button w3-theme-white w3-hover-theme' href='". $targetpage ."?page=". $counter ."'>". $counter ."</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a class='w3-button w3-theme-white w3-hover-theme' href='". $targetpage ."?page=". $lpm1 ."'>". $lpm1 ."</a>";
				$pagination.= "<a class='w3-button w3-theme-white w3-hover-theme' href='". $targetpage ."?page=". $lastpage ."'>". $lastpage ."</a>";		
			}
			else if ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
				$pagination.= "<a class='w3-button w3-theme-white w3-hover-theme' href='". $targetpage ."?page=1'>1</a>";
				$pagination.= "<a class='w3-button w3-theme-white w3-hover-theme' href='". $targetpage ."?page=2'>2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
					if ($counter == $page)
						$pagination.= "<span class='w3-button w3-theme-white w3-hover-theme'>". $counter ."</span>";
					else
						$pagination.= "<a href='". $targetpage ."?page=". $counter ."'>". $counter ."</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a class='w3-button w3-theme-white w3-hover-theme' href='". $targetpage ."?page=". $lpm1 ."'>". $lpm1 ."</a>";
				$pagination.= "<a class='w3-button w3-theme-white w3-hover-theme' href='". $targetpage ."?page=". $lastpage ."'>". $lastpage ."</a>";
			} else {
				$pagination.= "<a class='w3-button w3-theme-white w3-hover-theme' href='". $targetpage ."?page=1'>1</a>";
				$pagination.= "<a class='w3-button w3-theme-white w3-hover-theme' href='". $targetpage ."?page=2'>2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
					if ($counter == $page)
						$pagination.= "<span class='w3-button w3-theme-white w3-hover-theme'>". $counter ."</span>";
					else
						$pagination.= "<a class='w3-button w3-theme-white w3-hover-theme' href='". $targetpage ."?page=". $counter."'>". $counter ."</a>";					
				}
			}
		}

		if ($page < $counter - 1) 
			$pagination.= " <a class='w3-button w3-theme-white w3-hover-theme' href='". $targetpage ."?page=". $next ."'>></a>";
		else
			$pagination.= " <span class='w3-button w3-theme-white w3-hover-theme'>></span>";	
	}

	echo '
			<div class="w3-row-padding w3-margin-bottom">
				'. $pagination .'
			</div>
			<form method="post" enctype="multipart/form-data">
				<div class="w3-half">
					<div class="w3-row-padding w3-margin-bottom">
						<input class="w3-input" name="room" type="text" placeholder="'. $lang["admin_rooms"]["room_name"] .'" style="width: 100%" required>
					</div>
				</div>
				<div class="w3-half">
					<div class="w3-row-padding w3-margin-bottom">
						<input class="w3-input" name="desc" type="text" placeholder="'. $lang["admin_rooms"]["description"] .'" style="width: 100%" required>
					</div>
				</div>
				<div class="w3-row-padding w3-margin-bottom">
					<input type="hidden" name="action" value="add">
					<button class="w3-button w3-theme w3-hover-theme" type="submit" name="submit"><i class="fas fa-house-circle-check"></i> <span class="w3-hide-small">'. $lang["button"]["add"] .'</span></button>
				</div>
			</form>
		</div>
	';

	include "core/footer.php";
?>
