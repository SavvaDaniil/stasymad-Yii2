<?php


?>



<div class="row section_lk">
	<div class="col-12">
		<div class="breadcamp">
			<ul>
				<li>Account</li>
			</ul>
		</div>
	</div>
	<div class="col-12">
		<div class="filter_lk">
			<ul class="nav">
				<li><a class="active" data-toggle="tab" href="#strip" role="tab" aria-controls="nav-strip" aria-selected="true">Strip</a></li>
				<li><a data-toggle="tab" href="#exotic" role="tab" aria-controls="nav-exotic" aria-selected="true">Exotic</a></li>
				<li><a data-toggle="tab" href="#acrobatics" role="tab" aria-controls="nav-acrobatics" aria-selected="true">Acrobatics</a></li>
				<li><a data-toggle="tab" href="#profile" role="tab" aria-controls="nav-profile" aria-selected="true">Profile</a></li>
			</ul>
		</div>
	</div>
	
	
	<div class="tab-content col-12 row">

		<div class="tab-pane fade show active col-12 row" id="strip" role="tabpanel" aria-labelledby="nav-strip-tab">

			<div class="main row col-12">

				<?php
				if(is_null($accessStrip) || empty($accessStrip)){
				?>
				<div class="col-12">
					<center class="no_content">
						<i>- You don't have paid strip content -</i>
					</center>
				</div>
				<?php
				}

				foreach($accessStrip as $key => $accessCourse){
				?>
				
				
				<div class="col-12 row block_content">
					<div class="col-12 col-lg-5 col-md-5 col-sm-12 videoContent">
						<img src="<?= $accessCourse["posterSrc"];?>" class="img-fluid" />
						<img src="/images/play.png" class="play" data-toggle="modal" data-target="#videoModal" onclick="getvideo('course','<?= $accessCourse["id_of_course"]; ?>','<?= $accessCourse["last_played_number"];?>')" />
					</div>
					<div class="col-12 col-lg-6 col-md-6 col-sm-12 info row">
						<div class="col-12">
							<h2><?= $accessCourse["name"];?></h2>
							
							<p><?= $accessCourse["description"];?></p>
						</div>
						
						
						<div class="col-12">
						
							<p class=""><font>Date of purchase:</font> <?= date("d.m.Y H:i:s",strtotime($accessCourse["date_of_add"]));?></p>
							<p class=""><font>Days: </font>
							<?= $accessCourse["days"];?>
							</p>

							<p class="">
								<font>Date of activation:</font>
								<?php
								if($accessCourse["date_of_activation"] == null){
									?>
									No activation (launch to activate)
									<?php
								} else {
									?>
									<?= date("d.m.Y",$accessCourse["date_of_activation"]);?>
									<?php
								}
								?>
							</p>

							<p class=""><font>Available until: </font>
							<?php
							if($accessCourse["date_must_be_used"] == null){
								?>
								No activation (launch to activate)
								<?php
							} else {
								?>
								<?= date("d.m.Y",$accessCourse["date_must_be_used"]);?>
								<?php
							}
							?>
							</p>
							
							<p class="prolong">
								<!--
								<button class="btn">Prolong</button>
								-->
							</p>
						</div>
						
						
						
					</div>
				</div>


				<?php
				}
				?>

						
						

			</div>


		</div>


		<div class="tab-pane fade col-12 row" id="exotic" role="tabpanel" aria-labelledby="nav-exotic-tab">

			<div class="main row col-12">

				<?php
				if(is_null($accessExotic) || empty($accessExotic)){
				?>
				<div class="col-12">
					<center class="no_content">
						<i>- You don't have paid exotic content -</i>
					</center>
				</div>
				<?php
				}

				foreach($accessExotic as $key => $accessCourse){
				?>
				
				
				<div class="col-12 row block_content">
					<div class="col-12 col-lg-5 col-md-5 col-sm-12 videoContent">
						<img src="<?= $accessCourse["posterSrc"];?>" class="img-fluid" />
						<img src="/images/play.png" class="play" data-toggle="modal" data-target="#videoModal" onclick="getvideo('course','<?= $accessCourse["id_of_course"]; ?>','<?= $accessCourse["last_played_number"];?>')" />
					</div>
					<div class="col-12 col-lg-6 col-md-6 col-sm-12 info row">
						<div class="col-12">
							<h2><?= $accessCourse["name"];?></h2>
							
							<p><?= $accessCourse["description"];?></p>
						</div>
						
						
						<div class="col-12">
						
							<p class=""><font>Date of purchase:</font> <?= date("d.m.Y H:i:s",strtotime($accessCourse["date_of_add"]));?></p>
							<p class=""><font>Days: </font>
							<?= $accessCourse["days"];?>
							</p>

							<p class="">
								<font>Date of activation:</font>
								<?php
								if($accessCourse["date_of_activation"] == null){
									?>
									No activation (launch to activate)
									<?php
								} else {
									?>
									<?= date("d.m.Y",$accessCourse["date_of_activation"]);?>
									<?php
								}
								?>
							</p>

							<p class=""><font>Available until: </font>
							<?php
							if($accessCourse["date_must_be_used"] == null){
								?>
								No activation (launch to activate)
								<?php
							} else {
								?>
								<?= date("d.m.Y",$accessCourse["date_must_be_used"]);?>
								<?php
							}
							?>
							</p>
							
							<p class="prolong">
								<!--
								<button class="btn">Prolong</button>
								-->
							</p>
						</div>
						
						
						
					</div>
				</div>


				<?php
				}
				?>

						
						

			</div>
		</div>


		<div class="tab-pane fade col-12 row" id="acrobatics" role="tabpanel" aria-labelledby="nav-acrobatics-tab">

			<div class="main row col-12">

				<?php
				if(is_null($accessAcrobatics) || empty($accessAcrobatics)){
				?>
				<div class="col-12">
					<center class="no_content">
						<i>- You don't have paid acrobatics content -</i>
					</center>
				</div>
				<?php
				}

				foreach($accessAcrobatics as $key => $accessCourse){
				?>
				
				
				<div class="col-12 row block_content">
					<div class="col-12 col-lg-5 col-md-5 col-sm-12 videoContent">
						<img src="<?= $accessCourse["posterSrc"];?>" class="img-fluid" />
						<img src="/images/play.png" class="play" data-toggle="modal" data-target="#videoModal" onclick="getvideo('course','<?= $accessCourse["id_of_course"]; ?>','<?= $accessCourse["last_played_number"];?>')" />
					</div>
					<div class="col-12 col-lg-6 col-md-6 col-sm-12 info row">
						<div class="col-12">
							<h2><?= $accessCourse["name"];?></h2>
							
							<p><?= $accessCourse["description"];?></p>
						</div>
						
						
						<div class="col-12">
						
							<p class=""><font>Date of purchase:</font> <?= date("d.m.Y H:i:s",strtotime($accessCourse["date_of_add"]));?></p>
							<p class=""><font>Days: </font>
							<?= $accessCourse["days"];?>
							</p>

							<p class="">
								<font>Date of activation:</font>
								<?php
								if($accessCourse["date_of_activation"] == null){
									?>
									No activation (launch to activate)
									<?php
								} else {
									?>
									<?= date("d.m.Y",$accessCourse["date_of_activation"]);?>
									<?php
								}
								?>
							</p>

							<p class=""><font>Available until: </font>
							<?php
							if($accessCourse["date_must_be_used"] == null){
								?>
								No activation (launch to activate)
								<?php
							} else {
								?>
								<?= date("d.m.Y",$accessCourse["date_must_be_used"]);?>
								<?php
							}
							?>
							</p>
							
							<p class="prolong">
								<!--
								<button class="btn">Prolong</button>
								-->
							</p>
						</div>
						
						
						
					</div>
				</div>


				<?php
				}
				?>

						
						

			</div>
		</div>


	  <div class="tab-pane fade col-12 row" id="profile" role="tabpanel" aria-labelledby="nav-profile-tab">
			<div class="row">
				<div class="col-12 col-lg-4 col-md-4 col-sm-12 profile">
					<form>
						<label>Login / Email:</label>
						<input type="email" class="form-control" value="<?= $user["username"];?>" maxlength="150" id="username" onkeypress="clear_warning(this.id)" />
						<label>Name:</label>
						<input type="text" class="form-control" value="<?= $user["fio"];?>" maxlength="150" id="fio" onkeypress="clear_warning(this.id)" />

						<hr />

						<label>New password:</label>
						<input type="password" class="form-control" maxlength="150" id="new_password" onkeypress="clear_warning(this.id)" />
						<label>Confirm password:</label>
						<input type="password" class="form-control" maxlength="150" id="new_password_confirm" onkeypress="clear_warning(this.id)" />
						<label>Current password:</label>
						<input type="password" class="form-control" maxlength="150" id="password" onkeypress="clear_warning(this.id)" />

						<button type="button" class="btn btn-success" onclick="save()">Save</button>
						<p id="profile_warning"></p>
					</form>
				</div>
			</div>
		</div>

	</div>
		
	
</div>



<div class="modal fade" id="modalVideo" tabindex="-1" role="dialog" aria-labelledby="videoModal" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="videoModalHeader">

				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="close_video()">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12" id="modalVideoJS">
						<center>
							<video-js id=vid1 width=600 height=300 class="vjs-default-skin" controls >
							</video-js>
						</center>
					</div>
					<div class="col-12" id="modalVideoJSNotReady">
						<p><i>Your video content in progress. Please wait.<br />Date of activation not set until you start to watch</i></p>
						<p>If something wrong, please right to us through  contacts or social network</p>
					</div>

				</div>
				<div class="row">
					<div class="col-6">
						<p class="prev">
							<button class="btn btn-info" id="video_prev" onclick="changeNumberOfVideo(0)">Prev</button>
						</p>
					</div>
					<div class="col-6">
						<p class="next">
							<button class="btn btn-info" id="video_next" onclick="changeNumberOfVideo(1)">Next</button>
						</p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal" onclick="close_video()">Close</button>
			</div>
		</div>
	</div>
</div>






<script>

function save(){
	var username = document.getElementById("username").value.trim();
	var fio = document.getElementById("fio").value.trim();
	var new_password = document.getElementById("new_password").value.trim();
	var new_password_confirm = document.getElementById("new_password_confirm").value.trim();
	var password = document.getElementById("password").value.trim();

	if(username == ""){
		$("#profile_warning").html("Field 'login' could not be empty");
		change_input("username");
	} else if(fio == "") {
		$("#profile_warning").html("Field 'name' could not be empty");
		change_input("fio");
	} else if(!(username.indexOf('@') + 1)){
        $("#profile_warning").html("Mail entered incorrectly");
		change_input("username");
	} else if(new_password != "" && new_password != new_password_confirm) {
		$("#profile_warning").html("Passwords must be match");
		change_input("new_password_confirm");
	} else if(new_password != "" && new_password == new_password_confirm && password == "") {
		$("#profile_warning").html("Enter please current password");
		change_input("password");
	} else {
		$.ajax({
				type: "POST",
				url:  "/api/account/save",
				data: {
					"username":username,
					"fio":fio,
					"new_password":new_password,
					"new_password_confirm":new_password_confirm,
					"password":password,
					"_csrf":"<?=Yii::$app->request->getCsrfToken()?>"
				},
				cashe: false,
				async:false,
				error:function(){
					alert("Error connection!");
				},
				success: function(html)
				{
					if(html["answer"] == "success"){
						$("#profile_warning").html("Save successfull");
					} else if(html["answer"] == "error" && html["error"] == "username_already_exist"){
						$("#profile_warning").html("Login already exist");
					} else if(html["answer"] == "error" && html["error"] == "wrong_password"){
						$("#profile_warning").html("Wrong current password");
					} else {
						$("#profile_warning").html("Unknown error on server!");
					}
				}
			});
		}


}

function change_input(id){
	$("#"+id).addClass("not_filled");
}
function clear_warning(id){
	$("#"+id).removeClass("not_filled");
	$("#profile_warning").html("");
}

window.onload = function(){
	$("#videoModal").on("hidden.bs.modal", function () {
	    player.pause();
	});



	resizePlayer();
	window.addEventListener('resize', function(){
		resizePlayer();
	});

	$( "#chatFileVideo" ).change(function() {
		readChatFileVideo()
	});
}










var GLOBAL_id_of_content, GLOBAL_content, GLOBAL_number;
var GLOBAL_array_of_content;

function getvideo(content, id_of_content, number){
	$("#modalVideo").modal();
	if(GLOBAL_id_of_content == id_of_content && GLOBAL_content == content){
		return;
	}
	GLOBAL_id_of_content = id_of_content;
	GLOBAL_content = content;
	GLOBAL_number = number - 1;

	$.ajax({
		type: "POST",
		url:  "/api/account/getvideo",
		data: {
			"content":content,
			"id_of_content":id_of_content,
			"number":number,
			"_csrf":"<?=Yii::$app->request->getCsrfToken()?>"
		},
		cashe: false,
		async:false,
		error:function(){
			alert("Error connection!");
			document.getElementById("btn_form").disabled = false;
		},
		success: function(html)
		{
			if(html["answer"] == "success"){

				GLOBAL_array_of_content = [];

				for(var i = 0; i < html["content"].length; i++){
					//GLOBAL_array_of_content.push(html["content"][i]["hash"]);
					GLOBAL_array_of_content.push(html["content"][i]);
				}
				
				console.log(html["content"].length);


				rebuildplayer();

				loadSrcOfVideo(number-1);

				

				/*
				player.src({
					type: 'application/x-mpegURL',
					//src: "/video/"+content+"/"+GLOBAL_id_of_content+"_"+GLOBAL_array_of_content[number-1]+"/playlist.m3u8"
					src : GLOBAL_array_of_content[number-1]["src"]
				});
				player.play();
				*/

			} else if(html["answer"] == "error" && html["error"] == "no_data"){
				alert("No data for server");
			} else if(html["answer"] == "error" && html["error"] == "server_error"){
				alert("Sorry, no content found on the server. Please inform the owners of the platform.");
			} else {
				alert("Unknown error on server!");
			}
		}
	});
}


function loadSrcOfVideo(index){
	console.log(GLOBAL_array_of_content);
	
	$("#modalVideoJS").removeClass("not_active");
	$("#modalVideoJSNotReady").removeClass("active");
	if(GLOBAL_array_of_content[index]["src"] == null && GLOBAL_array_of_content[index]["statusQRContent"] != "2"){
		$("#modalVideoJS").addClass("not_active");
		$("#modalVideoJSNotReady").addClass("active");
		player.src({
			type: 'application/x-mpegURL',
			src: ""
		});
		return;
	}
	
	player.src({
		type: 'application/x-mpegURL',
		src: GLOBAL_array_of_content[index]["src"]
	});
	
	var subtitles = GLOBAL_array_of_content[index]["listOfSubtitle"];
	if(subtitles != null){
		subtitles.forEach(
			function(subtitle, index, array){
				if(subtitle["label"] == "English"){
					player.addRemoteTextTrack({
						src: subtitle["src"],
						kind : subtitle["kind"],
						label :subtitle["label"],
						srclang : subtitle["srclang"],
						language : subtitle["language"],
						mode : "showing"
					}, false);
				} else {
					player.addRemoteTextTrack({
						src: subtitle["src"],
						kind : subtitle["kind"],
						label :subtitle["label"],
						srclang : subtitle["srclang"],
						language : subtitle["language"]
					}, false);
				}
			}
		);
	}
}









function updatevideoplay(){
	$.ajax({
		type: "POST",
		url:  "/api/account/updatevideoplay",
		data: {
			"content":GLOBAL_content,
			"id_of_content":GLOBAL_id_of_content,
			"number":(GLOBAL_number + 1),
			"_csrf":"<?=Yii::$app->request->getCsrfToken()?>"
		},
		cashe: false,
		async:false,
		error:function(){

		},
		success: function(html)
		{

		}
	});
}

function resizePlayer(){
	var w_max = window.innerWidth;

	if(w_max > 768){
		player.width(600);
		player.height(300);
	} else {
		var new_width = w_max - 50;
		var new_height = new_width*9/16;
		player.width(new_width);
		player.height(new_height);
	}
}

function rebuildplayer(){
	//console.log("GLOBAL_array_of_content.length = " + GLOBAL_array_of_content.length)
	if(GLOBAL_array_of_content.length > 1){
		document.getElementById("videoModalHeader").innerHTML = "Lesson №" + (GLOBAL_number + 1);



		document.getElementById("video_prev").disabled = false;
		document.getElementById("video_next").disabled = false;

		document.getElementById("video_prev").style.display = "inline";
		document.getElementById("video_next").style.display = "inline";
		if(GLOBAL_number <= 0){
			document.getElementById("video_prev").style.display = "none";
		}
		if(GLOBAL_number >= (GLOBAL_array_of_content.length - 1)){
			document.getElementById("video_next").style.display = "none";
		}
		updatevideoplay();
	} else {
		document.getElementById("videoModalHeader").innerHTML = "";
		//прячем все кнопки
		document.getElementById("video_prev").style.display = "none";
		document.getElementById("video_next").style.display = "none";
		updatevideoplay();
	}
}

function changeNumberOfVideo(a){
	document.getElementById("video_prev").disabled = true;
	document.getElementById("video_next").disabled = true;
	player.pause();
	for(var i = 0; i < GLOBAL_array_of_content.length; i++){
		//console.log(GLOBAL_array_of_content[i]);
	}


	var next_video;

	GLOBAL_number = parseInt(GLOBAL_number);

	if(a == 0){
		GLOBAL_number -= 1;


		next_video = GLOBAL_array_of_content[GLOBAL_number];
		//console.log("next_video = " + next_video);

		loadSrcOfVideo(GLOBAL_number);
		
		rebuildplayer();
	} else if(a == 1){
		GLOBAL_number += 1;

		next_video = GLOBAL_array_of_content[GLOBAL_number];

		//console.log("next_video = " + next_video);

		loadSrcOfVideo(GLOBAL_number);
		
		rebuildplayer();
	}
}
</script>

<link href="/video.js/dist/video-js.css" rel="stylesheet" type="text/css">
<script src="/video.js/dist/video.js"></script>

<script>
var player = videojs('vid1');
player.preload();
function close_video(){
	player.pause();
}


</script>
