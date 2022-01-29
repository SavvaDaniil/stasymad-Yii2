<?php

?>

<div class="row section_content">
	<div class="col-12">
		<div class="breadcamp">
			<ul>
				<li><?= $themeOfContent;?></li>
			</ul>
		</div>
	</div>
	<div class="col-12">
		<div class="filter">
			<ul>
				<li class="active" onclick="filter(0)"><p>All</p></li>
				<li onclick="filter(1)"><p>Beginners</p></li>
				<li onclick="filter(2)"><p>Intermediate</p></li>
			</ul>
		</div>
	</div>
	
	<?php
	foreach($courseList as $courseInfo){

		$divClass = "";
		if($courseInfo -> beginner == 1){
			$divClass .= " beginner";
		}
		if($courseInfo -> intermediate == 1){
			$divClass .= " intermediate";
		}
	?>
		<div class="block col-12 row <?= $divClass;?>">
			<div class="col-12 row">
				<div class="col-12 col-lg-4 col-md-12 col-sm-12 video">

					<img src="<?= $courseInfo -> posterOriginalSrc;?>" alt="poster" class="img-fluid posterOriginal" />
					<?php
					if($courseInfo -> isOriginal){
					?>
					<img src="/images/play.png" alt="play" class="img-fluid play" onClick="openOriginal(<?= $courseInfo -> original_inst1_youtube2;?>,'<?= $courseInfo -> originalLink;?>');" />
					<?php
					}
					?>
				</div>
				<div class="col-12 col-lg-4 col-md-12 col-sm-12 row">
					<div class="info">
						<div class="col-12">
							<h2><?= $courseInfo -> name;?></h2>
							
							<?= $courseInfo -> description;?>
						</div>
						
						<div class="col-12 row bottom">
							<?php
							if($courseInfo -> alreadyBuyed){
							?>
							<div class="col-12 cart">
								<a href="/account">
									<button class="btn alreadyBuyed">Already have</button>
								</a>
							</div>
							<?php
							} else {
							?>

							<div class="col-6 price">
								<p>
									Price: <?= $courseInfo -> price;?> RUB (&#8776;<?= $courseInfo -> priceUSD;?> USD)<br />
									Days: <?= $courseInfo -> days;?> days
								</p>
							</div>
							<div class="col-6 cart">
								<button class="btn"
								onclick="add_to_cart(<?= $courseInfo -> id;?>, null, 0, 0)">
								In cart
								</button>
							</div>

							<?php
							}
							?>


						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4 col-md-12 col-sm-12 video">
					<img src="<?= $courseInfo -> posterDemoSrc;?>" alt="poster" class="img-fluid posterDemo" />
					<?php
					if($courseInfo -> isDemo){
					?>
					<img src="/images/play.png" alt="play" class="img-fluid play" onClick="openDemo(<?= $courseInfo -> id;?>,'<?= $courseInfo -> demoSrc;?>');" />
					<?php
					}
					?>
				</div>
			</div>
		</div>

	<?php
	}
	?>


		<!--
		<div class="block col-12 row beginner">
			<div class="col-12 row">
				<div class="col-12 col-lg-4 col-md-12 col-sm-12 video">
					<img src="/images/tutorial_example.jpg" alt="poster" class="img-fluid posterOriginal" />
					<img src="/images/play.png" alt="play" class="img-fluid play" onClick="openOriginal(2,'QpmPZN8V3qE');" />
				</div>
				<div class="col-12 col-lg-4 col-md-12 col-sm-12 row">
					<div class="info">
						<div class="col-12">
							<h2>Стойка на руках</h2>
							
							<p>Тип занятия: разбор элемента</p>
						</div>
						
						<div class="col-12 row bottom">
							<div class="col-6 price">
								<p>With feedback 30$ / 30 days</p>
							</div>
							<div class="col-6 cart">
								<button class="btn">In cart</button>
							</div>
							<div class="col-6 price">
								<p>Without feedback 20$ / 30 days</p>
							</div>
							<div class="col-6 cart">
								<button class="btn">In cart</button>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4 col-md-12 col-sm-12 video">
					<img src="/images/tutorial_example.jpg" alt="poster" class="img-fluid posterDemo" />
					<img src="/images/play.png" alt="play" class="img-fluid play" onClick="openDemo('124');" />
				</div>
			</div>
		</div>
		
		
		<div class="block col-12 row intermediate">
			<div class="col-12 row">
				<div class="col-12 col-lg-4 col-md-12 col-sm-12 video">
					<img src="/images/tutorial_example.jpg" alt="poster" class="img-fluid posterOriginal" />
					<img src="/images/play.png" alt="play" class="img-fluid play" onClick="openOriginal(2,'QpmPZN8V3qE');" />
				</div>
				<div class="col-12 col-lg-4 col-md-12 col-sm-12 row">
					<div class="info">
						<div class="col-12">
							<h2>Стойка на руках</h2>
							
							<p>Тип занятия: разбор элемента</p>
						</div>
						
						
						<div class="col-12 row bottom">
							<div class="col-12 cart">
								<a href="/lk">
									<button class="btn alreadyBuyed">Already have</button>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4 col-md-12 col-sm-12 video">
					<img src="/images/tutorial_example.jpg" alt="poster" class="img-fluid posterDemo" />
					<img src="/images/play.png" alt="play" class="img-fluid play" onClick="openDemo('124');" />
				</div>
			</div>
		
		
		
		</div>
		-->
	
</div>

<script>
function filter(a){
	var f = document.getElementsByClassName("filter")[0].querySelectorAll("li");
	for (var i = 0; i < f.length; i++) {
		f[i].classList.remove("active");
	}
	f[a].classList.add("active");

	var c = document.getElementsByClassName("block");
	for (var i = 0; i < c.length; i++) {
		if(a == 0){
			c[i].classList.remove("hide");
		} else if(a == 1){
			if(c[i].classList.contains("beginner")){
				c[i].classList.remove("hide");
			} else {
				c[i].classList.add("hide");
			}
		} else if(a == 2){
			if(c[i].classList.contains("intermediate")){
				c[i].classList.remove("hide");
			} else {
				c[i].classList.add("hide");
			}
		}

	}
}
</script>
