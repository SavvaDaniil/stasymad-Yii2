<?php

/* @var $this yii\web\View */

//$this->title = "Nastya's Bagdasarova Online Platform";
?>


<div class="row section1">
	<div class="col-12 col-lg-6 col-md-6 col-sm-12">
		<h2>
			Frame Up Strip<br />+ Exotic<br />+ Acrobatics
		</h2>
		<h4>
			Take the best dance lessons from a top Frame Up Strip and Acrobatics choreographer from home.
		</h4>
	</div>
	<div class="col-1 d-sm-none d-md-block"></div>
	<div class="col-12 col-lg-5 col-md-5 col-sm-12">
		<img src="/images/section1.png" class="img-fluid" />
	</div>
</div>


<div class="container">
	<div class="row section2">
		<div class="col-12">
			<center>
				<h2>Nastya's Bagdasarova Online Platform</h2>
				<p>makes it possible to join classes<br class="d-none d-sm-none d-md-block" />
				of top Frame Up Strip teacher from anywhere in the world.</p>
			</center>
		</div>
		
		
		
		<div class="col-12 col-lg-6 col-md-6 col-sm-12">
			<center>
				<img src="/images/section2.jpg" class="img-fluid" />
			</center>
		</div>
		
		
		<div class="col-12 col-lg-6 col-md-6 col-sm-12 row">
			
			<?php
			$a = array(
                "<p><b>Comfortable viewing and study </b> of material <b> at any time </b>, with the ability to practice each moves as many times as you need</p>",
                "<p><b>Opportunity for feedback.</b><br />I will advise, answer your questions and provide feedback!</p>",
                "<p>For 1 online lesson, I will give material, the analysis of which in an offline lesson takes 3 lessons</p>"
			);
			foreach($a as $key => $content){
			?>
			<div class="col-2">
				<img src="/images/circle.png" class="img-fluid" />
			</div>
			<div class="col-10">
				<div class="block">
					<?= $content;?>
				</div>
			</div>
			<?php
			}
			?>
		</div>
		
	</div>
</div>
