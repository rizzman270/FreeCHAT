<?php
	require "core/config.php";
	if(!isset($_SESSION["user"])) header("Location: login.php");
	$user=$_SESSION["user"];
	$users=load_users();
	$message="";

	include "core/header.php";

	if($_SERVER["REQUEST_METHOD"]==="POST"){
		$name=$_POST["name"];
		$users[$user]["name"]=$name;
		$gen=$_POST["gender"];
		$users[$user]["gender"]=$gen;
		$language=$_POST["language"];
		$users[$user]["language"]=$language;
		save_users($users);
		$_SESSION['lang']=$language;
		$message=$lang["message"]["profile"];
	}

	echo '
		<form method="post" enctype="multipart/form-data">
			<div class="w3-theme-white">
				<header class="w3-container w3-text-theme">
					<h4><strong><i class="fas fa-user"></i> '. $lang["profile"]["title"] .'</strong> '. $message .'</h4>
				</header>
				<div class="w3-half">
					<div class="w3-row-padding w3-margin-bottom">
						<input class="w3-input" name="name" type="text" placeholder="Fullname" style="width: 100%" value="'. $users[$user]["name"] .'" minlength="8" maxlength="16" required>
					</div>
				</div>
				<div class="w3-half">
					<div class="w3-row-padding w3-margin-bottom">
						<select class="w3-select" name="gender">
							<option value="fa-venus-mars">Hetero</option>
							<option value="fa-venus-double">Lesbian</option>
							<option value="fa-venus">Female</option>
							<option value="fa-transgender">Transgender</option>
							<option value="fa-non-binary">Genderqueer</option>
							<option value="fa-neuter">Neutrois</option>
							<option value="fa-mercury">Hermaphrodit</option>
							<option value="fa-mars-stroke-up">Androgyne</option>
							<option value="fa-mars-stroke-right">Othergender</option>
							<option value="fa-mars-double">Gay</option>
							<option value="fa-mars-and-venus">Bigender</option>
							<option value="fa-mars">Male</option>
							<option value="fa-genderless">Genderless</option>
						</select>
					</div>
				</div>
				<div class="w3-half">
					<div class="w3-row-padding w3-margin-bottom">
						<select class="w3-select" name="language">
							<option value="de_de">'. $lang["lang"]["de_de"] .'</option>
							<option value="en_us">'. $lang["lang"]["en_us"] .'</option>
							<option value="zh_cn">'. $lang["lang"]["zh_cn"] .'</option>
						</select>
					</div>
				</div>
				<div class="w3-row-padding w3-margin-bottom">
					<button class="w3-button w3-theme w3-hover-theme" type="submit"><i class="fas fa-save"></i> <span class="w3-hide-small">'. $lang["button"]["save"] .'</span></button>
				</div>
			</div>
		</form>
	';

	include "core/footer.php";
?>
