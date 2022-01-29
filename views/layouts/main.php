<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(70742770, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/70742770" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-WM431MN475"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-WM431MN475');
</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-190151020-1">
</script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-190151020-1');
</script>

<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '3476397479136617');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=3476397479136617&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

</head>
<body>
<?php $this->beginBody() ?>



<div class="row" id="header">
	<div class="col-6 col-lg-1 col-md-1 col-sm-6" style="padding:0;margin:0;">
		<img src="/images/logo.png" class="img-fluid logo" />
	</div>
	
	<div class="col-6 d-md-none menu">
		<button class="btn" onclick="menuMobile();">
			<img src="/images/barsBlack.png" class="img-fluid" />
		</button>
	</div>
	
	<div class="col-6 d-none d-sm-none d-md-block headerMenu">
		<ul>
			<li <?php if($this->params["menu"] == 1)echo 'class="active"';?>><a href="/">Main</a></li>
			<li <?php if($this->params["menu"] == 2)echo 'class="active"';?>><a href="/exotic">Exotic</a></li>
			<li <?php if($this->params["menu"] == 4)echo 'class="active"';?>><a href="/strip">Strip</a></li>
			<li <?php if($this->params["menu"] == 3)echo 'class="active"';?>><a href="/acrobatics">Acrobatics</a></li>
			<li <?php if($this->params["menu"] == 5)echo 'class="active"';?>><a href="/contacts">Contacts</a></li>
			<li <?php if($this->params["menu"] == 6)echo 'class="active"';?>><a href="/privacy">Privacy</a></li>
			<li <?php if($this->params["menu"] == 7)echo 'class="active"';?>><a href="/terms">Terms</a></li>
		</ul>
	</div>
	<div class="col-1 d-none d-sm-none d-md-block"></div>
	<div class="col-1 d-none d-sm-none d-md-block" style="padding:0;">
		<a href="/cart">
			<button class="btn cart">Cart</button>
		</a>
	</div>


	<?php
	if(!Yii::$app->user->isGuest){
	?>

	<div class="col-2 d-none d-sm-none d-md-block">
		<a href="/account">
			<button class="btn">Account</button>
		</a>
	</div>
	<div class="col-1 d-none d-sm-none d-md-block">
		<form action="/logout" method="post">
			<input type="hidden" name="<?=Yii::$app->request->csrfParam; ?>" value="<?=Yii::$app->request->getCsrfToken(); ?>" />
			<button class="btn">Logout</button>
		</form>
	</div>

<script>
function logout(){
    $.ajax({
			type: "GET",
			url:  "/api/logout",
			cashe: false,
			async:false,
			error:function(){
				alert("Произошла ошибка соединения!");
			},
			success: function(html)
			{
        if(html["answer"] == "success"){
          location.reload();
        } else {
          alert("Неизвестная ошибка на сервере!");
        }
			}
		});
  }
</script>

	<?php
	} else {
	?>

	<div class="col-1 d-none d-sm-none d-md-block">
		<a href="/login">
			<button class="btn">Login</button>
		</a>
	</div>
	<div class="col-1 d-none d-sm-none d-md-block">
		<a href="/registration" >
			<button class="btn">Registration</button>
		</a>
	</div>
	<div class="col-1 d-none d-sm-none d-md-block"></div>
	<?php
	}
	?>
	
	<div id="menuMobile">
		<button class="btn" onclick="menuMobile();">
			<img src="/images/barsBlack.png" class="img-fluid" />
		</button>
		<ul>
			<li><a href="/">Main</a></li>
			<li><a href="/exotic">Exotic</a></li>
			<li><a href="/acrobatics">Acrobatics</a></li>
			<li><a href="/strip">Strip</a></li>
			<li><a href="/contacts">Contacts</a></li>
			<li><a href="/privacy">Privacy</a></li>
			<li><a href="/terms">Terms</a></li>
		</ul>
		<hr />

		<?php
		if(!Yii::$app->user->isGuest){
		?>
		<ul>
			<li><a href="/cart">Cart</a></li>
			<li>
				<a href="/account">Account</a>
				<form action="/logout" method="post" id="logoutMobileFrom">
					<input type="hidden" name="<?=Yii::$app->request->csrfParam; ?>" value="<?=Yii::$app->request->getCsrfToken(); ?>" />
					<a href="#" onclick="document.getElementById('logoutMobileFrom').submit();">Logout</a>
				</form>
			</li>
		</ul>
		<?php
		} else {
		?>
		<ul>
			<li><a href="/login">Login</a></li>
			<li><a href="/registration">Registration</a></li>
		</ul>
		<?php
		}
		?>
	</div>
</div>


<script>
var menuMobileStatus = false;
function menuMobile(){
	if(menuMobileStatus){
		menuMobileStatus = false;
		$("#menuMobile").removeClass("active");
	} else {
		menuMobileStatus = true;
		$("#menuMobile").addClass("active");
	}
}

  


  function add_to_cart(id, product, back, operation){
  	$.ajax({
  		type: "POST",
  		url:  "/api/cart/add",
  		data: {
  			"id":id,
  			"product":product,
  			"back":back,
  			"operation":operation,
  			"_csrf":"<?=Yii::$app->request->getCsrfToken()?>"
  		},
  		cashe: false,
  		async:false,
  		error:function(){
  			alert("Error connection!");
  		},
  		success: function(html)
  		{		
			fbq('track', 'AddToCart', {
				value: 1,
				currency: 'USD',
				contents: [
					{
						id: '1',
						quantity: 1
					}
				],
				content_ids: '1',
			});
  			if(html["answer"] == "success"){
  				animation_cart(0);
  			} else if(html["answer"] == "error" && html["error"] == "quest"){
  				location.href = "/login";
  			} else if(html["answer"] == "error" && html["error"] == "already_done"){
  				animation_cart(1);
  			} else {
				alert("Unknown error on server!");
  			}
  		}
  	});
  }

  function animation_cart(a){
  	if(a == 0){
  		$("#cart_add_success").addClass("active");
  		setTimeout(function(){
  			$("#cart_add_success").removeClass("active");
  		},1000);
  	} else if(a == 1){
  		$("#cart_already_add").addClass("active");
  		setTimeout(function(){
  			$("#cart_already_add").removeClass("active");
  		},1000);
  	}

  }
</script>



<div id="cart_add_success" class="cart_alert">
<p>Product added to cart successfully</p>
</div>
<div id="cart_already_add" class="cart_alert">
<p>Product has already been added to the cart</p>
</div>





<!-- Modal -->
<div class="modal fade" id="modal_login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body row">
				<div class="col-12 block row" id="login_form">
					<div class="col-12">
						<img src="/images/logo.jpg" class="imng-fluid" />
						
						<form action="#">
							<center>
								<input type="email" class="form-control" placeholder="Email" maxlength="100" />
								<input type="password" class="form-control" placeholder="Пароль" maxlength="100" />
								<button type="button" class="btn">Войти</button>
							</center>
						</form>
					</div>
					<div class="col-6" style="padding:0;">
						<p class="reg"><font>У меня нет аккаунта</font></p>
					</div>
					<div class="col-6" style="padding:0;">
						<p align="left"><button class="btn reg" onclick="change_modal_form(1);">Зарегистрироваться</button></p>
					</div>
				</div>
				
				
				<div class="col-12 block row" id="login_registration">
					<div class="col-12">
						<img src="/images/logo.jpg" class="imng-fluid" />
						
						<form action="#">
							<center>
								<input type="text" class="form-control" placeholder="Ваше имя" maxlength="100" />
								<input type="email" class="form-control" placeholder="Email" maxlength="100" />
								<input type="password" class="form-control" placeholder="Пароль" maxlength="100" />
								<input type="password" class="form-control" placeholder="Подтвердить пароль" maxlength="100" />
								<button type="button" class="btn">Зарегистрироваться</button>
							</center>
						</form>
					</div>
					<div class="col-6" style="padding:0;">
						<p class="reg"><font>У меня уже есть аккаунт</font></p>
					</div>
					<div class="col-6" style="padding:0;">
						<p align="left"><button class="btn reg" onclick="change_modal_form(0);">Войти</button></p>
					</div>
				</div>
			</div>
			
			<div class="modal-footer">
				
				<!--
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				-->
				
			</div>
		</div>
	</div>
</div>



<script>
function change_modal_form(v){
	if(v == 0){
		$("#login_registration").css("display","none");
		$("#login_form").css("display","flex");
	} else if(v==1){
		$("#login_form").css("display","none");
		$("#login_registration").css("display","flex");
	}
}
</script>


















<!-- Modal -->
<div class="modal fade modalYoutube" id="modalYoutube" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<h2></h2><span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<iframe id="modalOriginalYoutubeSrc" src=""
				frameBorder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
				allowfullscreen></iframe>
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script>
function openOriginal(type,src){
	if(type === 1 && src !== ""){
		window.open(src);
	} else if(type === 2){
		$("#modalOriginalYoutubeSrc").attr("src", "https://www.youtube.com/embed/"+src);
		$("#modalYoutube").modal();
	}
}

</script>















<?= $content ?>












<div class="row footer">
	<div class="col-12 col-lg-8 col-md-8 col-sm-12">
		<img src="/images/logo.png" class="img-fluid" />
		<p>©<?= date("Y"); ?> Nastya's Bagdasarova<br />
		Online Platform
		</p>
	</div>
	<div class="col-12 col-lg-2 col-md-2 col-sm-12">
		<ul>
			<li><a href="/">Main</a></li>
			<li><a href="/exotic">Frame Up Exotic</a></li>
			<li><a href="/acrobatics">Acrobatics</a></li>
			<li><a href="/strip">Strip</a></li>
			<li><a href="/contacts">Contacts</a></li>
			<li><a href="/privacy">Privacy</a></li>
		</ul>
	</div>
	<div class="col-12 col-lg-2 col-md-2 col-sm-12">
		<ul>
			<li><a href="https://www.instagram.com/stasy_mad/" target="_blank">Instagram</a></li>
			<li><a href="https://vk.com/stasymadoff" target="_blank">Vkontakte</a></li>
			<li><a href="https://www.youtube.com/channel/UCf-pzd5DYFS0c076WAgXYEA" target="_blank">Youtube</a></li>
		</ul>
	</div>

</div>





<!-- Modal -->
<div class="modal fade modalVideo" id="modalDemo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="stopDemo()">
					<h2></h2><span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="modalDemoPlayer">
				<video-js id=vid1 width=600 height=300 class="vjs-default-skin" controls >
				  <!--<source src="/video/example/playlist.m3u8" type="application/x-mpegURL">-->
				  <!--<track kind="captions" src="http://stasymad-backend.com/track_demo/2/english.vtt" srclang="en" label="English" default>-->
				</video-js>
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal" onclick="stopDemo()">Close</button>
			</div>
		</div>
	</div>
</div>



<link href="/video.js/dist/video-js.css" rel="stylesheet" type="text/css">
<script src="/video.js/dist/video.js"></script>


<script>
var player = videojs('vid1');
player.preload();
function openDemo(id_of_course,src){
	//player.src({type: 'application/x-mpegURL', src: "http://stasymad-backend.com/demo/2/playlist.m3u8"});
	player.src({type: 'application/x-mpegURL', src: src});
	//player.play();
	addTrackDemo(id_of_course);
		
	$("#modalDemo").modal();
}
function stopDemo(){
	player.pause();
}

/*
var video = document.getElementById("vid1"),
i,
track,
loadwebvtt = document.getElementById("loadwebvtt"),
loadcues = document.getElementById("loadcues"),
hideTracks = function() {
	// Oddly, there's no way to remove a track from a video, so hide them instead
	for (i = 0; i < video.textTracks.length; i++) {
		video.textTracks[i].mode = "hidden";
	}
};
*/


function addTrackDemo(id_of_course){
	/*
	track = document.createElement("track");
	track.kind = "captions";
	track.label = "English";
	track.srclang = "en";
	track.src = "http://stasymad-backend.com/track_demo/"+id_of_course+"/english.vtt";
	track.addEventListener("load", function() {
		this.mode = "showing";
		video.textTracks[0].mode = "showing"; // thanks Firefox
	});
	
	var videoDemo = document.getElementById("vid1");
	
	videoDemo.appendChild(track);
	*/
	const basePath = "/content/course/"+id_of_course+"/demo/track";
	const trackFormat = "vtt";
	
	var trackSrc;
	const arrayTracksLanguages = [
		["english","English","en"],
		["china","中文","china"],
		["spain","Español","spain"],
		["deutch","Deutsche","deutch"],
		["hungarian","Magyar","hungarian"]
	];

	arrayTracksLanguages.forEach(function(language, index){
		trackSrc = new File([""], basePath + "/" + language[0] + "." + trackFormat);
		if(index == 0){
			player.addRemoteTextTrack({
				src:  basePath + "/" + language[0] + "." + trackFormat,
				kind : "captions",
				label : language[1],
				srclang : language[2],
				language : language[1],
				mode : "showing"
			}, false);
		} else {
			player.addRemoteTextTrack({
				src:  basePath + "/" + language[0] + "." + trackFormat,
				kind : "captions",
				label : language[1],
				srclang : language[2],
				language : language[1],
			}, false);
		}
	});
	
	/*
	const trackEl = player.addRemoteTextTrack({
		src: basePath+"/english.vtt",
		kind : "captions",
		label : "English",
		srclang : "en",
		language : "English",
		mode : "showing"
	}, false);
	
	trackEl.addEventListener('load', function() {
		
	});
	
	player.addRemoteTextTrack({
		src: basePath+"/china.vtt",
		kind : "captions",
		label : "中文",
		srclang : "china",
		language : "中文"
	}, false);
	
	player.addRemoteTextTrack({
		src: basePath+"/spain.vtt",
		kind : "captions",
		label : "Español",
		srclang : "spain",
		language : "Español"
	}, false);
	
	player.addRemoteTextTrack({
		src: basePath+"/deutch.vtt",
		kind : "captions",
		label : "Deutsche",
		srclang : "deutch",
		language : "Deutsche"
	}, false);
	
	player.addRemoteTextTrack({
		src: basePath+"/hungarian.vtt",
		kind : "captions",
		label : "Magyar",
		srclang : "hungarian",
		language : "Magyar"
	}, false);
	*/

}


function videoDemoload(){
	
	$.ajax({
		type: "POST",
		url:  "/templates/videoDemo.php",
		data:{
			
		},
		cashe: false,
		async:false,
		error:function(){
			alert("Произошла ошибка!");
			document.getElementById("btn_form").disabled = false;
		},
		success: function(html)
		{
			
			$("#modalDemoPlayer").html(html);
			var player = videojs('vid1');
			player.preload();
		}
	});
}
</script>







<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
