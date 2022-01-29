<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */
/*
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
*/

?>



<div class="row section_login_reg">
	<div class="col-12">
		<div class="breadcamp">
			<ul>
				<li>Login</li>
			</ul>
		</div>
	</div>
	
	<div class="col-4"></div>
	
	<div class="col-12 col-lg-4 col-md-4 col-sm-12 row">
		
		<div class="col-12">
			<center>
				<img src="/images/logo.png" class="img-fluid" />
			</center>
			
			<form action="#">
				<center>
					<input type="email" id="username" class="form-control" placeholder="Email" maxlength="100" onkeypress="clear_warning()" />
					<input type="password" id="password" class="form-control" placeholder="Password" maxlength="100" onkeypress="clear_warning()" />
					<button type="button" class="btn" id="btn_form" onclick="login()">Login</button>
				</center>
			</form>
			<div class="error">
	            <p id="warning"></p>
	        </div>
		</div>
		<div class="col-6" style="padding:0;">
			<p class="reg"><font>I have not account</font></p>
		</div>
		<div class="col-6" style="padding:0;">
			<p align="left"><a href="/registration"><button class="btn reg">Registration</button></a></p>
		</div>
		
		<div class="col-6" style="padding:0;">
			<p class="reg"><font>Forget password?</font></p>
		</div>
		<div class="col-6" style="padding:0;">
			<p align="left"><a href="/forget"><button class="btn reg">Password recovery</button></a></p>
		</div>
	
	</div>
	
</div>




<script>
function login(){
  var username = document.getElementById("username").value.trim();
  var password = document.getElementById("password").value.trim();
	document.getElementById("btn_form").disabled = true;

  if(username == "" || password == ""){
    $("#warning").html("Please fill in all fields");
		document.getElementById("btn_form").disabled = false;
  } else if(!(username.indexOf('@') + 1)){
    $("#warning").html("Mail entered incorrectly");
		document.getElementById("btn_form").disabled = false;
  } else {
    $.ajax({
			type: "POST",
			url:  "/api/login",
			data: {
                "username":username,
                "password":password,
                "_csrf":"<?=Yii::$app->request->getCsrfToken()?>"
            },
			cashe: false,
			async:false,
			error:function(){
				alert("Sorry, error net connection");
				document.getElementById("btn_form").disabled = false;
			},
			success: function(html)
			{
                if(html["answer"] == "success"){
                        document.getElementById("btn_form").disabled = false;
                        location.href = "/account";
                } else if(html["answer"] == "error" && html["error"] == "wrong"){
                        $("#warning").html("Wrong login or password");
                        document.getElementById("btn_form").disabled = false;
                } else {
                        $("#warning").html("Sorry, unknown error on server");
                        document.getElementById("btn_form").disabled = false;
                }
			}
		});
  }
}

function clear_warning(){
  $("#warning").html("");
}
</script>


