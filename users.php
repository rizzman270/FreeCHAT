<?php
	require "core/config.php";
	if(!isset($_SESSION["user"])) header("Location: login.php");
	$user=$_SESSION["user"];
	$users=load_users();

	include "core/header.php";

	echo '
		<div class="w3-theme-white">
			<header class="w3-container w3-text-theme">
				<h4><strong><i class="fas fa-users"></i> '. $lang["users"]["title"] .'</strong></h4>
			</header>
			<div class="w3-half">
				<div class="w3-row-padding w3-margin-bottom">
					<input type="text" id="memberSearch" class="w3-input" placeholder="'. $lang["users"]["search"] .'">
				</div>
			</div>
			<div class="w3-row-padding w3-margin-bottom">
				<table class="w3-table w3-striped w3-theme-white">
					<tr class="w3-theme w3-border w3-border-theme-light">
						<td><b>'. $lang["users"]["user"] .'</b></td>
					</tr>
					<tbody id="membersList">
					</tbody>
				</table>
			</div>
		</div>
	';
?>



		<script>
			const members = <?php echo json_encode($users); ?>;
			const membersList = document.getElementById("membersList");
			const searchBox = document.getElementById("memberSearch");

			function renderMembers(filter = "") {
				membersList.innerHTML = "";
				let table_theme = 'w3-theme-light';
				Object.keys(members).filter(user=>user.toLowerCase().includes(filter.toLowerCase())).forEach(user=> {
					const tr = document.createElement("tr");
					tr.className = "w3-theme-white";
					if (table_theme == "w3-theme-light") {
						table_theme = "w3-theme-white";
					} else {
						table_theme = "w3-theme-light";
					}
					tr.innerHTML = '<td class="w3-border '+ table_theme +' w3-border-theme-light w3-hover-text-theme" style="vertical-align: middle;"><a class="w3-link" href="private.php?user='+ user +'"><b><i class="fas '+ members[user].gender +'"></i> '+ members[user].name +'</b></td>';
					membersList.appendChild(tr);
				});
			}

			searchBox.addEventListener("input", () => { renderMembers(searchBox.value); });
			renderMembers();
		</script>

<?php
	include "core/footer.php";
?>
