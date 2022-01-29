<?php


?>

<script src="https://www.paypal.com/sdk/js?client-id=<?= $payPalClientId;?>&currency=RUB">
</script>

<div class="row section_cart">
	<div class="col-12">
		<div class="breadcamp">
			<ul>
				<li>Cart</li>
			</ul>
		</div>
	</div>

    <div class="d-none d-lg-block d-md-block d-sm-none col-lg-1 col-md-1"></div>

    <div class="col-12 col-lg-10 col-md-10 col-sm-12 block divHide" id="cartLoading">
        <center>
            <p class="empty">Loading, please wait...</p>
        </center>
    </div>
    <div class="col-12 col-lg-10 col-md-10 col-sm-12 block" id="cartReady">
    
        <?php
        if(empty($cartList)){
        ?>
            <center>
            <p class="empty">- Cart is empty -</p>
            </center>
        <?php
        } else {
        ?>
            <table class="table table-striped table-responsive-sm">
                <thead>
                    <tr>
                        <th scope="col">№</th>
                        <th scope="col">Category</th>
                        <th scope="col">Operation</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
            <tbody>
            <?php
            $s = 0;
            $sum = 0;
            $sumUSD = 0;

            foreach($cartList as $id => $content){
            $s++;

            $sum += $content["price"];
            $sumUSD += $content["priceUSD"];
            ?>
            <tr>
                <td><?= $s;?></td>
                <td>
                    Course
                </td>
                <td>
                <?php
                if($content["operation"] == 0){
                ?>
                    Buying
                <?php
                } else if($content["operation"] == 1) {
                ?>
                    Extension
                <?php
                }
                ?>
                </td>
                <td><?= $content["name"];?></td>
                <td><?= $content["price"];?> RUB (&#8776;<?= $content["priceUSD"];?> USD)</td>
                <td>
                    <a href="#" onclick="remove_from_cart(<?= $id;?>,'course')">Remove</a>
                </td>
            </tr>
            <?php
            }
            ?>





            <tr>
            <td colspan="4">
                <p align="right">
                    <b>Summ:</b>
                </p>
            </td>
            <td>
            <p>
                <b><?= $sum;?> RUB (&#8776;<?= $sumUSD;?> USD)</b>
            </p>
            </td>
            <td></td>
            </tr>
            </tbody>
            </table>

            <!--
            <p align="center">
                <a href="/payment">
                    <button class="btn btn-light">
                        <img src="/images/paypal.png" class="img-fluid" />
                    </button>
                </a>

            </p>
            -->
            <div class="row">
                <div class="col-4 d-none d-md-block"></div>
                <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                    <div id="paypal-button-container"></div>
                </div>
            </div>

            <script>
                //paypal.Buttons().render('#paypal-button-container');
                
                paypal.Buttons({
                    createOrder: function(data, actions) {
                        return fetch('/api/paypal/createorder',
                            {
                                method: 'post',
                                headers: {
                                    'content-type': 'application/json'
                                }
                            }).then(function(res) {
                                return res.json();
                            }).then(function(data) {
                                return data.id; // Use the key sent by your server's response, ex. 'id' or 'token'
                        })
                    },
                    onApprove: function(data) {
                        changeStateOfCart(1);
                        return fetch('/api/paypal/getorder', {
                                method: 'post',
                                headers: {
                                'content-type': 'application/json'
                            },
                                body: JSON.stringify({
                                    orderID: data.orderID
                                })
                        }).then(function(res) {
                            return res.json();
                        }).then(function(details) {
                            changeStateOfCart(0);
                            //alert('Transaction approved by ' + details.payer_given_name);
                            
                            if(details.answer == "success"){
                                window.location.href = "https://stasymad.com/payment/success";
                            } else {
                                window.location.href = "https://stasymad.com/payment/error";
                            }
                            
                        });
                    }
                }).render('#paypal-button-container');

                var stateOfCart = 0;
                function changeStateOfCart(newState){
                    if(newState == 1){
                        stateOfCart = 1;
                        $("#cartLoading").removeClass("divHide");
                        $("#cartReady").addClass("divHide");
                    } else {
                        stateOfCart = 0;
                        $("#cartLoading").addClass("divHide");
                        $("#cartReady").removeClass("divHide");
                    }
                }
            </script>

        <?php
        }
        ?>

    </div>


<script>


function remove_from_cart(id, product){
	$.ajax({
		type: "POST",
		url:  "/api/cart/remove",
		data: {
			"id":id,
			"product":product,
		},
		cashe: false,
		async:false,
		error:function(){
			alert("Error connection!");
		},
		success: function(html)
		{
			if(html["answer"] == "success"){
                location.reload();
			} else if(html["answer"] == "error" && html["error"] == "quest"){
				location.href = "/login";
			} else {
				alert("unknown error on server!");
			}
		}
	});
}
</script>
</div>
