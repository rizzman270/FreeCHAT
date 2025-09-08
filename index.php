<?php
	require "core/config.php";
	if(!isset($_SESSION["user"])) header("Location: login.php");
	$user=$_SESSION["user"];
	$room=$_GET["room"]??"Chill Zone";
	$rooms=load_rooms();
	if(!isset($rooms[$room])) die($lang["message"]["room_not_exist"]);
	$messages=load_messages()[$room];
	$users=load_users();
	$bans=load_bans();
	if (isset($bans[$user]))
		$messages=$lang["message"]["banned"];

	include "core/header.php";

	echo '
		<div class="w3-theme-white">
			<header class="w3-container w3-text-theme">
				<h4><strong><i class="fas fa-house"></i> '. htmlspecialchars($room) .'</strong> <span class="w3-hide-small">- '. htmlspecialchars($rooms[$room]['description']) .'</span> '. $message .'</h4>
			</header>
			<div class="w3-row-padding w3-margin-bottom">
				<div class="w3-table-scroll w3-border w3-border-theme-light w3-threequarter">
					<div class="w3-table-scroll w3-chatfield" id="chatBox" style="overflow-y: scroll; padding: 1px;"></div>
				</div>
				<div class="w3-table-scroll w3-border w3-border-theme-light w3-hide-small w3-quarter w3-chatfield" id="onlineUsers" style="overflow-y: scroll; padding: 1px;"></div>
				<div class="w3-hide-small w3-tiny" id="typingIndicator" style="float: left; font-style: italic; color: #aaa; width: 100%;"></div>
			</div>
			<div class="w3-bottom w3-theme-white w3-chatcontainer">
				<form id="chatForm">
					<audio id="joinSound" src="assets/online.wav"></audio>
					<audio id="leaveSound" src="assets/offline.wav"></audio>
	';

	if (!isset($bans[$user])) {
		echo '
					<input type="file" id="imageUpload" accept="image/*" style="display:none;">
					<button class="w3-button w3-theme-white w3-hover-theme w3-left" type="button" onclick="document.getElementById(\'imageUpload\').click()" style="width: 10%;">'. $ImageIcon .'</button>
					<input class="w3-input-theme w3-left" type="text" id="msg" placeholder="Type your message" minlength="2" style="width: 30%;" required>
					<div class="w3-button w3-theme-white w3-hover-theme w3-left" id="emoji-button" style="width: 10%;">'. $emojiIcon .'</div>
					<div id="emoji-picker" class="w3-border w3-border-theme-light w3-theme-white w3-center w3-table-scroll w3-hide" style="position: absolute; bottom: 40px; right: 10px; width: 300px; max-height: 200px; overflow-y: auto;"></div>
					<select class="w3-select-theme w3-left" id="color" style="width: 19%;">
		';

		if ($users[$user]["theme"] == "dark")
			echo '<option value="#ffffff">Default</option>';
		else
			echo '<option value="#000000">Default</option>';

		echo '
						<option value="#9E0F22" style="color: #9E0F22;">Dark Red</option>
						<option value="#E44235" style="color: #E44235;">Light Red</option>
						<option value="#111C4E" style="color: #111C4E;">Dark Blue</option>
						<option value="#1083C4" style="color: #1083C4;">Light Blue</option>
						<option value="#062721" style="color: #062721;">Dark Green</option>
						<option value="#3A984A" style="color: #3A984A;">Light Green</option>
						<option value="#C08856" style="color: #C08856;">Dark Yellow</option>
						<option value="#F4B72B" style="color: #F4B72B;">Light Yellow</option>
						<option value="#11151F" style="color: #11151F;">Dark Gray</option>
						<option value="#A8ACBA" style="color: #A8ACBA;">Light Gray</option>
					</select>
					<select class="w3-select-theme w3-left" id="style" style="width: 19%;">
						<option value="normal" style="font-style: normal;">Normal</option>
						<option value="italic" style="font-style: italic;">Italic</option>
					</select>
					<button class="w3-button w3-theme-white w3-hover-theme w3-left" type="submit" style="width: 12%;">&nbsp;<i class="fas fa-paper-plane"></i><span class="w3-hide-small"> '. $lang["button"]["send"] .'</span>&nbsp;</button>
		';
	}

	echo '
				</form>
			</div>
	';
?>

			<script type="text/javascript">
				const imageInput = document.getElementById("imageUpload");
				const chatBox=document.getElementById("chatBox");
				const form=document.getElementById("chatForm");

				let lastCount = 0;
				let typingTimeout;

				form.addEventListener("submit",e=>{
					e.preventDefault();
					const text=document.getElementById("msg").value;
					const color=document.getElementById("color").value;
					const style=document.getElementById("style").value;
					fetch("core/post.php",{method:"POST",headers:{"Content-Type":"application/x-www-form-urlencoded"},body:"room=<?=urlencode($room)?>&text="+encodeURIComponent(text)+"&color="+encodeURIComponent(color)+"&style="+encodeURIComponent(style)})
					.then(r=>r.text()).then(r=>{ document.getElementById("msg").value=""; document.getElementById("msg").focus(); fetchMessages(); });
				});

				function fetchMessages(){
					fetch("core/fetch.php?room=<?=urlencode($room)?>").then(r=>r.json()).then(data=>{
						chatBox.innerHTML="";
						data.forEach(m=>{
							let div=document.createElement("div");
							div.innerHTML="<div style='padding: 2px;'><a class='w3-hover-text-theme' href='private.php?user="+ m.user +"' style='text-decoration: none;'><i class='fas "+ m.icon.toLowerCase() +"'></i> <strong>"+ m.name +"</strong></a>: <span class='w3-right w3-tiny'>"+ m.time +"</span><span style='font-style: "+ m.style +"; color: "+ m.color +";'>"+ m.text +"</span></div>";
							chatBox.appendChild(div);
						});

						if (data.length > lastCount) {
							let last = data[data.length - 1];
							if (last.name === "Alice") {
								if (last.text.includes("<?=$lang["message"]["joined"]?>")) document.getElementById("joinSound").play();
								if (last.text.includes("<?=$lang["message"]["left"]?>")) document.getElementById("leaveSound").play();
							}
						}
						lastCount = data.length;

						chatBox.scrollTop=chatBox.scrollHeight;
					});
				}

				window.addEventListener("beforeunload", ()=>{
					navigator.sendBeacon("core/heartbeat.php?logout=1&room=<?=urlencode($room)?>");
				});

				function heartbeat(){
					fetch("core/heartbeat.php?room=<?=urlencode($room)?>");
				}

				function loadOnlineUsers(){
					fetch("core/online.php?room=<?=urlencode($room)?>").then(r=>r.json()).then(data=>{
						let list = "";
						data.forEach(u=>{
							list += "<div style='padding: 2px;'><a class='w3-hover-text-theme' href='private.php?user="+ u.user +"' style='text-decoration: none;'><i class='fas "+ u.icon.toLowerCase() +"'></i> <strong>"+ u.name +"</strong></a></div>";
						});
						document.getElementById("onlineUsers").innerHTML=list;
					});
				}

				document.getElementById("msg").addEventListener("input", ()=>{
					sendTyping(1);
					clearTimeout(typingTimeout);
					typingTimeout = setTimeout(()=>sendTyping(0), 2000);
				});

				function sendTyping(state){
					fetch("core/post_typing.php", {
						method:"POST",
						body:"target=room:<?=urlencode($room)?>&typing="+state,
						headers:{"Content-Type":"application/x-www-form-urlencoded"}
					});
				}

				function fetchTyping(){
					fetch("core/fetch_typing.php?target=room:<?=urlencode($room)?>").then(r=>r.json()).then(users=>{
						let div = document.getElementById("typingIndicator");
						if(users.length > 0){
							div.innerText = users.join(", ") +" <?php echo $lang["chat"]["typing"]; ?>";
						} else {
							div.innerText = "";
						}
					});
				}

				async function loademoji() {
					const res = await fetch("assets/emoji.json");
					const data = await res.json();
					const picker = document.getElementById("emoji-picker");
					picker.innerHTML = "";

					for (const category in data) {
						const title = document.createElement("div");
						title.textContent = category;
						title.style.width = "100%";
						title.style.fontWeight = "bold";
						title.className = "w3-border w3-border-theme-light w3-theme";
						picker.appendChild(title);

						for (const [name, path] of Object.entries(data[category])) {
							const img = document.createElement("img");
							img.src = path;
							img.alt = name;
							img.style.padding = "2px";
							img.addEventListener("click", () => {
								const input = document.getElementById("msg");
								input.value += `:[${name}]:`;
							});
							picker.appendChild(img);
						}
					}
				}

				document.getElementById("emoji-button").addEventListener("click", () => {
					const picker = document.getElementById("emoji-picker");
					picker.classList.toggle("w3-hide");
					if (!picker.classList.contains("w3-hide")) loademoji();
				});

				imageInput.addEventListener("change", () => {
					if(imageInput.files.length > 0){
						let formData = new FormData();
						formData.append("image", imageInput.files[0]);
						fetch("core/upload.php", { method: "POST", body: formData }).then(r => r.text()).then(tag => {
							if(tag.startsWith("[img]"))
								msg.value += tag;
							else
								alert(tag);
						});
					}
				});

				setInterval(fetchTyping, 500);
				setInterval(loadOnlineUsers,1000);
				setInterval(fetchMessages,500);
				setInterval(heartbeat,1000);
			</script>

<?php
	echo '
		</div>
	';

	include "core/footer.php";
?>
