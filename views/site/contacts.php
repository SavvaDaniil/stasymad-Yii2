
<div class="row contacts">
	<div class="col-12">
		<div class="breadcamp">
			<ul>
				<li>Contacts</li>
			</ul>
		</div>
	</div>
	<div class="col-4 d-none d-md-block"></div>
	<div class="col-12 col-lg-4 col-md-4 col-sm-12 block form" id="contactForm">
		
		<form>
			<input type="email" id="email" class="form-control" placeholder="Your email" onkeypress="clearWarning(this.id)" />
			<input type="email" id="name" class="form-control" placeholder="Your name" onkeypress="clearWarning(this.id)" />
			<textarea class="form-control" id="message" placeholder="Your message" rows="10" onkeypress="clearWarning(this.id)"></textarea>
			
			<button type="button" class="btn btn-info" onclick="contacts()" id="btn_form">Send</button>
            <p id="warning"></p>
		</form>
	
	</div>
	<script>
        
    function enableSubmit(){
        document.getElementById("btn_form").disabled = false;
    }
    function disableSubmit(){
        document.getElementById("btn_form").disabled = true;
    }
    function clearWarning(id){
        $("#"+id).removeClass("not_filled");
        $("#warning").html("");
    }
    function contacts(){
        disableSubmit();

        $("#warning").html("");
        var email = document.getElementById("email").value.trim();
        var name = document.getElementById("name").value.trim();
        var message = document.getElementById("message").value.trim();
        
        if(email === ""){
            $("#email").addClass("not_filled");
            $("#warning").html("Please fill in all fields");
            enableSubmit();
        } else if(!(email.indexOf('@') + 1)){
            $("#email").addClass("not_filled");
            $("#warning").html("Mail entered incorrectly");
            enableSubmit();
        } else if(name === ""){
            $("#name").addClass("not_filled");
            $("#warning").html("Please fill in all fields");
            enableSubmit();
        } else if(message === ""){
            $("#message").addClass("not_filled");
            $("#warning").html("Please fill in all fields");
            enableSubmit();
        } else {
            $.ajax({
                type: "POST",
                url:  "/api/contacts",
                data: {
                    "email":email,
                    "name":name,
                    "message":message,
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
                        $("#contactForm").addClass("notactive");
                        $("#contactSuccess").removeClass("notactive");
                        enableSubmit();
                    } else {
                        alert("Unknown error on server!");
                        enableSubmit();
                    }
                }
            });

        }
    }
    </script>
	
	<div class="col-12 col-lg-4 col-md-4 col-sm-12 block success notactive" id="contactSuccess">
		
		<h4>We will try to answer you as soon as possible</h4>
	
	</div>
	
</div>