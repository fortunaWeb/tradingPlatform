<?
	$rent_access = ($data["day_count"]>0);
	$show_all = $data["group_topic_id"] != 2;
?>
<script type="text/javascript">
	$(function(){		
		var postUrl = "?task=profile&action=services_payment";
		if(window.location.search.indexOf("show=message") != -1){
			alertify.alert("Ваш счет пополнен и составляет "+$("[data-id=balance]").text()+" рублей. Вам необходимо активировать и продлить услуги.");
		}
		<?if($show_all){?>
			$(document).on("change", "[name=rent_month_count]", function(){
				var month_count = parseInt($("[name=rent_month_count]").val()),
					subscription = parseInt($("[data-id=rielter_sum]").val()),
					sum_rent = month_count * subscription;
				$("#rent-extension [data-id=rent_sum]").val(sum_rent);
			});
		
			$(document).on("change", "[name=rent_premium_count], [name=rent_premium_period]", function(){
				var period = parseInt($("[name=rent_premium_period]").val()),
					premium_count = parseInt($("[name=rent_premium_count]").val());
				if(period < 10){
                    premiumCost = period*premium_count*2;
				}else if(period < 30){
                    premiumCost = period*premium_count*1.5;
                }else if((period+0) == 30) {
                    premiumCost = 40*premium_count;
                }

				$("#premium-extension [data-id=premium_sum]").val(Math.ceil(premiumCost));
			});
		<?}?>
		$(document).on("change", "[name=sell_month_count]", function(){
			var subscription_sell = parseInt($("[data-id=subscription_sell]").val());
			    sum_sell = parseInt($("[name=sell_month_count]").val()) * subscription_sell ;


			$("[data-id=sell_sum]").val(sum_sell);			
		});
		$(document).on("keyup change", "[name=rielter_count]", function(){
			$("[data-id=rielter_sum]").val(parseInt($(this).val()) * 100);			
		});
		$(document).on("change", "[name=pay_parse_period]", function(){
			var payParsePeriod = parseInt($("[name=pay_parse_period]").val());
			console.log(payParsePeriod);
			if(payParsePeriod > 0){
				$("[data-id=pay_parse_sum]").val(Math.round(payParsePeriod * 7).toFixed(0));
			}else{
				$("[data-id=pay_parse_sum]").val(0);
			}
		})
        <?if($show_all){?>
			$("#rent-extension").submit(function (e) {
				e.preventDefault();
				var sum = parseFloat($("#rent-extension [data-id=rent_sum]").val()),
					balance = parseFloat($("[data-id=balance]").text()),
					duty = parseFloat($("[data-id=duty]").text()),
					date = $("[data-id=sell_date_end]").text(),
					resultSum = balance-sum-duty;
				if(duty==0){
					if((resultSum)>=0){
						alertify.confirm("Продлить раздел 'Аренда' на  "+$("[name=rent_month_count] option:selected").text()+" ?", function (result) {
							if (result) {
								$.ajax({
									type:"POST",
									url:postUrl,
									data:"type=rent&rent_month_count="+$("[name=rent_month_count]").val()+"&date="+date + '&sum='+ sum,
									success:function(html){	
										if(QueryString("task")=="profile"){
											window.location = "\?task=profile&action=services&topic_id=1&parent_id=1";
										}else{
											alertify.confirm("Оплата проведена. Можете входить.", function(result){
												if(result){
													window.location = "/?task=login&action=enter&access=0";
												}else{

												}
											})
										}
									}
								})
							}
						});
					}else{
						alertify.error("На Вашем счете не достаточно средств!");
					}
				}else{
					alertify.alert("Чтобы воспользоваться данной услугой, сначало необходимо погасить долг в размере "+duty+"р.");
				}
			});
		
			$("#premium-extension").submit(function (e) {
				e.preventDefault();
				var sum = parseFloat($("#premium-extension [data-id=premium_sum]").val()),
					duty = parseFloat($("[data-id=duty]").text()),
					balance = parseFloat($("[data-id=balance]").text()),
					new_premium_count = parseInt($("[name=rent_premium_count]").val()) + parseInt($("[data-id=rent_premium]").text());
					resultSum = balance-sum-duty;
				if(sum == 0){
					$("[name=rent_premium_count]").focus();		
					alertify.error("Выберете количество премиумов.");
					return false;
				}
				if(duty==0){
					if((resultSum)>=0){
						alertify.confirm("Активировать "+$("[name=rent_premium_count]").val() + " премиумов на "+$("[name=rent_premium_period] option:selected").text()+"?", function (result) {
							if (result) {
								$.post(postUrl, "type=premium&"+'sum='+ sum+'&'+decodeURIComponent($("#premium-extension").serialize()), function(html){
									// window.location = "\?task=profile&action=services";
									// $("[data-id=rent_premium]").text(new_premium_count);
									// $("[data-id=balance]").text(resultSum);
									// $("[data-id=duty]").text(0);
									// alertify.success("Премиумов добавленно: "+$("[name=rent_premium_count]").val());
								})
							}
						})
					}else{
						alertify.error("На Вашем счете не достаточно средств!");
					}
				}else{
					alertify.alert("Чтобы воспользоваться данной услугой погасите долг в размере "+duty+"р.");
				}
			});
			
			$("#pay-parse-extension").submit(function (e) {
				e.preventDefault();
				var sum = parseFloat($("[data-id=pay_parse_sum]").val()),
					balance = parseFloat($("[data-id=balance]").text()),
					duty = parseFloat($("[data-id=duty]").text()),
					date = $("[data-id=sell_date_end]").text(),
					resultSum = balance-sum-duty;
				if(duty==0){
					if((resultSum)>=0){
						alertify.confirm("Продлить раздел 'Частники 2' на  "+$("[name=pay_parse_period] option:selected").text()+" ?", function (result) {
							if (result) {
								$.ajax({
									type:"POST",
									url:postUrl,
									data:"type=pay_parse&pay_parse_period="+$("[name=pay_parse_period]").val()+'&sum='+sum,
									success:function(){	
										window.location = location;
									}
								})
							}
						});
					}else{
						alertify.error("На Вашем счете не достаточно средств!");
					}
				}else{
					alertify.alert("Чтобы воспользоваться данной услугой, сначало необходимо погасить долг в размере "+duty+"р.");
				}
			});
		<?}?>
		$("#sell-extension").submit(function (e) {
            e.preventDefault();
			var sum = parseFloat($("#sell-extension [data-id=sell_sum]").val()),
				balance = parseFloat($("[data-id=balance]").text()),
				duty = parseFloat($("[data-id=duty]").text()),
				date = $("[data-id=sell_date_end]").text(),
				resultSum = balance-sum-duty;
			if(duty==0){
				if((resultSum)>=0){
					alertify.confirm("Внести оплату в размере "+sum+" рублей?", function (result) {
						if (result) {
							$.ajax({
								type:"POST",
								url:postUrl,
								data:"type=sell&"+decodeURIComponent($("#sell-extension").serialize())+"&date="+date,
								success:function(html){		
									if(QueryString("task")=="profile"){
										window.location = "\?task=profile&action=services";
									}else{
										alertify.confirm("Оплата проведена. Можете входить.", function(result){
											if(result){
												window.location = location;
											}else{
												window.location = location;
											}
										})
									}
								}
							})
						}
					});
				}else{
					alertify.error("На Вашем счете не достаточно средств!");
				}
			}else{
				alertify.alert("Чтобы воспользоваться данной услугой погасите долг в размере "+duty+"р.");
			}
		});
		
		$("#new-address, #new-ip, #new-rielter").submit(function (e) {
            e.preventDefault();
			var balance = parseFloat($("[data-id=balance]").text()),
				duty = parseFloat($("[data-id=duty]").text());
			if(duty==0){
				var rielterSum = parseFloat($(this).find("[data-id=rielter_sum]").val()),
					message = $(this).attr("id") == "new-rielter" 
								? "Внести оплату в размере "+$("#new-rielter [data-id=rielter_sum]").val()+" рублей?"
								: "Ваша заявка на добавление или изменение данных будет отправлена администратору. По данной заявки с вашего счета будет списано "+rielterSum+" рублей. Заказать услугу?",				
					resultSum = balance-duty-rielterSum,
					data = decodeURIComponent($(this).serialize());
				if(resultSum >=0){
					alertify.confirm(message, function (result) {
						if (result) {
							$.ajax({
								type:"POST",
								url:"?task=profile&action=services_payment",
								data:"type=application&"+data,
								success:function(html){			
									window.location = "\?task=profile&action=services";
									// $("[data-id=balance]").text(resultSum);
									// $("[data-id=duty]").text(0);
									// alertify.success("Заявка отправлена.");
									// alertify.success("Заявка отправлена.");
								}
							})
						}
					});
				}else{
					alertify.error("На Вашем счете не достаточно средств!");
				}
			}else{
				alertify.alert("Чтобы воспользоваться данной услугой погасите долг в размере "+duty+"р.");
			}
		})
	})
</script>
<div class="col-xs-9">
	<legend>Текущее состояние доступа</legend>
	<div style="width: 400px;display: inline-block;float: left;">
		<div class="col-xs-2 deployed">
			Баланс: <span data-id="balance"><?echo $data["balance"];?></span>
		</div>
		<div class="col-xs-2 deployed">
			Долг: <span data-id="duty"><?echo $data["duty"];?></span>
		</div>
		<?if($_SESSION['group_topic_id'] != 1){?>
			<div class="col-xs-4 deployed">
				 Доступ до: <span data-id="sell_date_end" style="<?=Helper::Warn($data["sell_date_end"])?>"><?echo date("d.m.Y", strtotime($data["sell_date_end"]));?></span>
			</div>
		<?}?>
	</div>
	<?if($data["duty"]>0){?>
		<form method="POST" action="?task=profile&action=services_payment" id="duty_pay">
			<div class="col-xs-4 deployed info">
				<label class="signature">Описание долга</label>
				<span><?echo $data["duty_comment"];?></span>
			</div>
			<?if(($data["balance"] - $data["duty"])>=0){?>
				<div class="col-xs-2 deployed">
					<input type="submit" form="duty_pay" class="form-control btn btn-danger" value="Погасить долг">
				</div>
				<input type="hidden" name="type" value="duty">
				<input type="hidden" name="duty" value="<?echo $data["duty"];?>">
			<?}?>
		</form>
	<?}?>
	<?$count = count($data["prem_end_date"]);
	$diff = null;?>
</div>

<div class="col-xs-9">
	<legend>Продление доступа</legend>
	<?if($_SESSION['group_topic_id'] != 1){?>
		<div class="col-xs-12 deployed">	
			<hr style="margin: 0;">
		</div>
		<form id="sell-extension" method="POST" action="?task=profile&action=extension">		
			<div class="col-xs-2 deployed" style="max-width: 110px !important;min-width: 110px !important;">
				<b style="font-size: 17px;color: rgb(92, 184, 92);">Продажа</b>
			</div>		
			<div class="col-xs-2 deployed">
				<label class="signature">Продлить на</label>
				<select class="form-control" name="sell_month_count" required>
					<option value="1">1 месяц</option>
					<option value="2">2 месяца</option>
					<option value="3">3 месяца</option>
					<option value="4">4 месяца</option>
					<option value="5">5 месяцев</option>
					<option value="6">6 месяцев</option>
					<option value="7">7 месяцев</option>
					<option value="8">8 месяцев</option>
					<option value="9">9 месяцев</option>
					<option value="10">10 месяцев</option>
					<option value="11">11 месяцев</option>
					<option value="12">12 месяцев</option>				
				</select>
			</div>		
			<div class="col-xs-1 deployed">			
				<label class="signature">Сумма</label>
                <input type="hidden" data-id = 'subscription_sell' value="<?=$data["subscription_sell"]?>">
				<input type="text" data-id="sell_sum" class="form-control" value="<?=$data["subscription_sell"]?>" disabled>
			</div>
			<div class="col-xs-2 deployed">
				<input type="submit" class="form-control btn btn-success" value="Продлить продажу">	
			</div>
		</form>
	<?}?>
</div>
<?if($_GET["task"]=="profile"){?>
	<div class="col-xs-9">
		<div class="hidden">
			<form id="new-address" method="POST">
				<div class="col-xs-7 deployed">
					<p>Подключение или перенос точки доступа (1 000 руб.)</p>
					<textarea class="form-control" name="comment" placeholder="ардес и телефон точки" required="required"></textarea>
					<input type="hidden" name="rielter_sum" data-id="rielter_sum" value="1000">
				</div>
				<div class="col-xs-2 deployed" style="margin: 30px;">
					<input type="submit" class="form-control btn btn-success" value="Заказать">	
				</div>
			</form>
			<div class="col-xs-12 deployed">	
				<hr style="margin: 0;">
			</div>
			<form id="new-ip" method="POST">
				<div class="col-xs-7 deployed">
					<p>Смена ip-адреса на подключенной точке доступа (500 руб.)</p>
					<textarea class="form-control" name="comment" placeholder="ардес, телефон и новый IP точки" required="required"></textarea>
					<input type="hidden" name="rielter_sum" data-id="rielter_sum" value="500">
				</div>
				<div class="col-xs-2 deployed" style="margin: 30px;">
					<input type="submit" class="form-control btn btn-success" value="Заказать">	
				</div>
			</form>
		</div>
	</div>
	<div class="col-xs-9" style="margin-top: 20px;">
	<?include "application/views/services_list_view.php";?>
	</div>
<?}?>
