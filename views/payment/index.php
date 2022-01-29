<?php

?>



<div class="row section_payment">
	<div class="col-12">
		<div class="breadcamp">
			<ul>
				<li>Processing request</li>
			</ul>
		</div>
	</div>

	<div class="col-12 block">
        <h5 class="desc">Invoice is being formed, please wait ...<br />
            The site will have to redirect you for payment<br />
            <br />
            If this did not happen, please click on <a href="<?= $url;?>">the link</a>
			<?= $exception;?>
        </h5>
    </div>

<script>
window.onload = function(){
	location.href = "<?= $url;?>";
}
</script>

</div>

