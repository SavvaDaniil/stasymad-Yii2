
<div class="row section_login_reg">
	<div class="col-12">
		<div class="breadcamp">
			<ul>
				<li>Password recovery</li>
			</ul>
		</div>
	</div>

	<div class="d-none d-md-block col-4"></div>

	<div class="col-12 col-lg-4 col-md-4 col-sm-12 row">

		<div class="col-12">
			<center>
				<img src="/images/logo.png" class="img-fluid logo" />
			</center>

			<form action="#" id="forget_form_0">
				<center>
				<p>A 6-digit code will be sent to the specified mail</p>
					<input type="email" class="form-control" placeholder="Enter email" maxlength="100" id="username" onkeypress="clear_warning(this.id)" />
					<button type="button" class="btn" id="btn_form" onclick="forget(0)">Send mail</button>
				</center>
			</form>

			<form action="#" id="forget_form_1" style="display:none;">
				<center>
                    <p>
                        Please, enter code from mail.<br />
                        After it, system will generate new password for you and send it to your mail.
                    </p>
					<input type="text" class="form-control" placeholder="Enter the received code" maxlength="6" id="code" onkeypress="clear_warning(this.id)" />
					<button type="button" class="btn" onclick="forget(1)" id="send_code">Send code</button>
					<button type="button" class="btn cansel" onclick="cansel()">Cansel</button>
				</center>
			</form>

			<center>
        <p id="warning"></p>
      </center>
		</div>

		<div class="col-6" style="padding:0;">
			<p class="reg"><font>I have an account already</font></p>
		</div>
		<div class="col-6" style="padding:0;">
			<p align="left"><a href="/login"><button class="btn reg">Login</button></a></p>
		</div>
		<div class="col-6" style="padding:0;">
			<p class="reg"><font>I have not account</font></p>
		</div>
		<div class="col-6" style="padding:0;">
			<p align="left"><a href="/registration"><button class="btn reg">Registration</button></a></p>
		</div>

	</div>

</div>



<script>
var code, hash, username;

function forget(action){
    username = document.getElementById("username").value.trim();
    code = document.getElementById("code").value.trim();
	document.getElementById("btn_form").disabled = true;
    $("#send_code").show();

    if(username == "" && action == 0){
        $("#username").addClass("not_filled");
        document.getElementById("btn_form").disabled = false;
    } else if(code == "" && action == 1){
        $("#code").addClass("not_filled");
        document.getElementById("btn_form").disabled = false;
    } else if(!(username.indexOf('@') + 1)){
        $("#warning").html("Mail entered incorrectly");
        $("#username").addClass("not_filled");
        document.getElementById("btn_form").disabled = false;
    } else {
        $.ajax({
            type: "POST",
            url:  "/api/forget",
            data: {
                "action":action,
                "username":username,
                "code":code,
                "hash":hash,
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
                if(action == 0 && html["answer"] == "success" && html["hash"] != ""){
                    document.getElementById("btn_form").disabled = false;
                    document.getElementById("forget_form_0").style.display = "none";
                    document.getElementById("forget_form_1").style.display = "block";
                    $("#code").val("");
                    //code = html["code"];
                    hash = html["hash"];
                } else if(action == 1 && html["answer"] == "success"){
                    location.href = "/account";
                } else if(html["answer"] == "error"){
                    switch(html["error"]){
                        case "no_user":
                            $("#warning").html("Username not found");
                            break;
                        case "please_wait_20":
                            $("#warning").html("Too often requests, please wait 20 minutes");
                            break;
                        case "limit_try":
                            $("#warning").html("Exhausted attempts, please start over");
                            $("#send_code").hide();
                            break;
                        case "wrong_code_2":
                            $("#warning").html("The code is incorrect, you have 2 attempts left");
                            break;
                        case "wrong_code_1":
                            $("#warning").html("The code is incorrect, you have 1 attempt left");
                            break;
                        default:
                            $("#warning").html("Unknown error on server");
                            break;
                    }
                    document.getElementById("btn_form").disabled = false;
                } else {
                    alert("Unknown error on server!");
                    document.getElementById("btn_form").disabled = false;
                }
            }
        });
    }  
}

function clear_warning(id){
    $("#warning").html("");
    $("#"+id).removeClass("not_filled");
}
function cansel(){
  clear_warning();
  document.getElementById("forget_form_0").style.display = "block";
  document.getElementById("forget_form_1").style.display = "none";
}
</script>