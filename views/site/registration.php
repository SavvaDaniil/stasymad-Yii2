<?php


?>

<div class="row section_login_reg">
	<div class="col-12">
		<div class="breadcamp">
			<ul>
				<li>Registration</li>
			</ul>
		</div>
	</div>
	
	<div class="col-4"></div>
	
	<div class="col-12 col-lg-4 col-md-4 col-sm-12  row">
		
		<div class="col-12">
			<center>
				<img src="/images/logo.png" class="img-fluid" />
			</center>
			
			<form action="#">
				<center>
					<input type="email" class="form-control" placeholder="Email" maxlength="100" id="username" onkeypress="clearWarning(this.id)"  />
					<input type="text" class="form-control" placeholder="Your name" maxlength="100" id="fio" onkeypress="clearWarning(this.id)" />
					<input type="password" class="form-control" placeholder="Password" maxlength="100" id="password" onkeypress="clearWarning(this.id)"  />
					<input type="password" class="form-control" placeholder="Confirm password" maxlength="100" id="confirmPassword" 
                    onkeypress="clearWarning(this.id)"  />

                    <p class="agreement">By signing up I agree to STASYMAD's 
                        <a href="/terms" target="_blank">Terms of Service</a> & 
                        <a href="/privacy" target="_blank">Privacy Policy</a>.
                    </p>

					<button type="button" class="btn" id="btn_form" onclick="registration()">Registration</button>
                    <p id="warning"></p>
				</center>
			</form>

		</div>
		<div class="col-6" style="padding:0;">
			<p class="reg"><font>I have an account already</font></p>
		</div>
		<div class="col-6" style="padding:0;">
			<p align="left"><a href="/login"><button class="btn reg">Login</button></a></p>
		</div>
	
	</div>
	
</div>

<script>
function enableSubmit(){
    document.getElementById("btn_form").disabled = false;
}
function disableSubmit(){
    document.getElementById("btn_form").disabled = true;
}

function registration(){

    $("#warning").html("");
    var username = document.getElementById("username").value.trim();
    var fio = document.getElementById("fio").value.trim();
    var password = document.getElementById("password").value.trim();
    var confirmPassword = document.getElementById("confirmPassword").value.trim();

    disableSubmit();

    if(username === ""){
        $("#username").addClass("not_filled");
        $("#warning").html("Please fill in all fields");
        enableSubmit();
    } else if(fio === ""){
        $("#fio").addClass("not_filled");
        $("#warning").html("Please fill in all fields");
        enableSubmit();
    } else if(!(username.indexOf('@') + 1)){
        $("#warning").html("Mail entered incorrectly");
        enableSubmit();
    } else if(password === ""){
        $("#password").addClass("not_filled");
        enableSubmit();
    } else if(confirmPassword === ""){
        $("#confirmPassword").addClass("not_filled");
        enableSubmit();
    } else if(password !== confirmPassword){
        $("#warning").html("Passwords must be match");
        enableSubmit();
    } else {
        $.ajax({
            type: "POST",
            url:  "/api/registration",
            data: {
                "username":username,
                "fio":fio,
                "password":password,
                "confirmPassword":confirmPassword,
                "_csrf":"<?=Yii::$app->request->getCsrfToken()?>"
            },
            cashe: false,
            async:false,
            error:function(){
                alert("Error connection");
                enableSubmit();
            },
            success: function(html)
            {
                if(html["answer"] == "success"){
                    enableSubmit();
                    location.href = "/account";
                } else if(html["answer"] == "error" && html["error"] == "login_already_exist"){
                    $("#warning").html("Username already exist");
                    enableSubmit();
                } else {
                    alert("Unknown error on server!");
                    enableSubmit();
                }
            }
        });
    }
}


function clearWarning(id){
    $("#"+id).removeClass("not_filled");
    $("#warning").html("");
}

</script>