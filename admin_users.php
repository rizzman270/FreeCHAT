<?php
	require "core/config.php";
	if(!isset($_SESSION["user"])) header("Location: login.php");
	$user=$_SESSION["user"];
	$users=load_users();
	if ($users[$user]["is_admin"] == false) die($lang["message"]["is_admin"]);
	$table_theme = "w3-theme-light";

	include "core/header.php";

	echo '
		<div class="w3-theme-white">
			<header class="w3-container w3-text-theme">
				<h4><strong><i class="fas fa-users"></i> '. $lang["admin_users"]["title"] .'</strong></h4>
			</header>
			<div class="w3-row-padding w3-margin-bottom">
				<table class="w3-table w3-striped w3-theme-white">
					<tr class="w3-theme w3-border w3-border-theme-light">
						<td class="w3-center"><b>'. $lang["admin_users"]["user"] .'</b></td>
						<td class="w3-center" style="width: 25%"><b>'. $lang["admin_users"]["option"] .'</b></td>
					</tr>
	';

	$user_names = [];
	$total_pages = 0;
	foreach($users as $u=>$data) {
		$user_names[$total_pages] = $u;
		$total_pages += 1;
	}

	$adjacents = 6;
	$targetpage = "admin_users.php";
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
							<b>'. htmlspecialchars($user_names[$i]) .'</b>
						</td>
						<td class="w3-center '. $table_theme .' w3-border w3-border-theme-light" style="vertical-align: middle;">
							<button class="w3-button w3-theme w3-hover-theme" onclick="delUser(\''. htmlspecialchars($user_names[$i]) .'\')"><i class="fas fa-trash"></i> <span class="w3-hide-small">'. $lang["button"]["delete"] .'</span></button>
							<button class="w3-button w3-theme w3-hover-theme" onclick="banUser(\''. htmlspecialchars($user_names[$i]) .'\')"><i class="fas fa-user-lock"></i> <span class="w3-hide-small">'. $lang["button"]["ban"] .'</span></button>
							<button class="w3-button w3-theme w3-hover-theme" onclick="unbanUser(\''. htmlspecialchars($user_names[$i]) .'\')"><i class="fas fa-user-check"></i> <span class="w3-hide-small">'. $lang["button"]["unban"] .'</span></button>
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
		</div>
	';
?>

		<script>
			function delUser(u){ fetch('core/bans.php',{method:'POST',headers:{"Content-Type":"application/x-www-form-urlencoded"},body:'action=del&user='+ u}).then(r=>r.text()).then(r=>alert(r)); }
			function banUser(u){ fetch('core/bans.php',{method:'POST',headers:{"Content-Type":"application/x-www-form-urlencoded"},body:'action=ban&user='+ u}).then(r=>r.text()).then(r=>alert(r)); }
			function unbanUser(u){ fetch('core/bans.php',{method:'POST',headers:{"Content-Type":"application/x-www-form-urlencoded"},body:'action=unban&user='+ u}).then(r=>r.text()).then(r=>alert(r)); }
		</script>

<?php
	include "core/footer.php";
?>
