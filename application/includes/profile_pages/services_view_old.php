<script type="text/javascript">
	$(function(){
		if(window.location.search.indexOf("show=message") != -1){
			alertify.alert("Ваш счет пополнен и составляет "+$("[data-id=balance]").text()+" рублей. Вам необходимо активировать и продлить услуги.");
		}
		$(document).on("change", "[name=rent_month_count]", function(){
			var month_count = parseInt($("[name=rent_month_count]").val()),
				subscription = parseInt($("[data-id=rielter_sum]").val()),
				sum_rent = month_count * subscription,
				sum_rent_prem = (parseInt($("[name=rent_premium_count]").val()) * 40 - 200)*month_count;
			$("[data-id=rent_sum]").val(sum_rent);
			$("[data-id=sum]").val(sum_rent_prem + sum_rent);
			$("[data-id=rent_premium_sum]").val(sum_rent_prem);
		});
		
		$(document).on("change", "[name=rent_premium_count]", function(){
			var month_count = parseInt($("[name=rent_month_count]").val()),
				subscription = parseInt($("[data-id=rielter_sum]").val()),
				sum_rent = month_count * subscription,
				sum_rent_prem = (parseInt($("[name=rent_premium_count]").val()) * 40 - 200)*month_count;
			$("[data-id=rent_premium_sum]").val(sum_rent_prem);
			$("[data-id=sum]").val(sum_rent_prem + sum_rent);
		});
		$(document).on("change", "[name=sell_month_count]", function(){
			var sum_sell = parseInt($("[name=sell_month_count]").val()) * 400;				
			$("[data-id=sell_sum]").val(sum_sell);			
		});
		$(document).on("keyup change", "[name=rielter_count]", function(){
			$("[data-id=rielter_sum]").val(parseInt($(this).val()) * 100);			
		})


		$("#rent-extension").submit(function (e) {
            e.preventDefault();
			var sum = parseInt($("#rent-extension [data-id=sum]").val()),
				balance = parseInt($("[data-id=balance]").text()),
				duty = parseInt($("[data-id=duty]").text()),
				date = $("[data-id=sell_date_end]").text(),
				resultSum = balance-sum-duty;
			if((resultSum)>=0){
				alertify.confirm("Внести оплату в размере "+sum+" рублей?", function (result) {
					if (result) {
						$.ajax({
							type:"POST",
							url:"?task=profile&action=services_payment",
							data:"type=rent&"+decodeURIComponent($("#rent-extension").serialize())+"&date="+date,
							success:function(html){	
								if(QueryString("task")=="profile"){
									$("[data-id=balance]").text(resultSum);
									$("[data-id=duty]").text(0);
									$("[data-id=sell_date_end]").text(html);
									alertify.success("Доступ к аренде продлен");
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
		});
		
		$("#sell-extension").submit(function (e) {
            e.preventDefault();
			var sum = parseInt($("#sell-extension [data-id=sell_sum]").val()),
				balance = parseInt($("[data-id=balance]").text()),
				duty = parseInt($("[data-id=duty]").text()),
				date = $("[data-id=sell_date_end]").text(),
				resultSum = balance-sum-duty;
			if((resultSum)>=0){
				alertify.confirm("Внести оплату в размере "+sum+" рублей?", function (result) {
					if (result) {
						$.ajax({
							type:"POST",
							url:"?task=profile&action=services_payment",
							data:"type=sell&"+decodeURIComponent($("#sell-extension").serialize())+"&date="+date,
							success:function(html){		
								if(QueryString("task")=="profile"){
									$("[data-id=balance]").text(resultSum);
									$("[data-id=duty]").text(0);
									$("[data-id=sell_date_end]").text(html);
									alertify.success("Доступ к продаже продлен");
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
		});
		
		$("#new-address, #new-ip, #new-rielter").submit(function (e) {
            e.preventDefault();
			var balance = parseInt($("[data-id=balance]").text()),
				duty = parseInt($("[data-id=duty]").text());
			var rielterSum = parseInt($(this).find("[data-id=rielter_sum]").val()),
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
								$("[data-id=balance]").text(resultSum);
								$("[data-id=duty]").text(0);
								alertify.success("Заявка отправлена.");
							}
						})
					}
				});
			}else{
				alertify.error("На Вашем счете не достаточно средств!");
			}
		})
	})
</script>
<div class="col-xs-9">
	<legend>Текущее состояние доступа</legend>		
	<div class="col-xs-2 deployed">
		Баланс: <span data-id="balance"><?echo $data["balance"];?></span>
	</div>
	<div class="col-xs-12">
	</div>
	<?if($_SESSION['group_topic_id'] != 2){?>
		<div class="col-xs-3 deployed">
			Аренда до: <span data-id="sell_date_end"><?echo date("d.m.Y", strtotime($data["sell_date_end"]));?></span>
		</div>
	<?}?>
	<div class="col-xs-2 deployed">
		Премиумы: <span data-id="rent_premium"><?echo $data["rent_premium"];?></span>
	</div>
	<?if($_SESSION['group_topic_id'] != 1){?>
		<div class="col-xs-4 deployed">
			Продажа до: <span data-id="sell_date_end"><?echo date("d.m.Y", strtotime($data["sell_date_end"]));?></span>
		</div>
	<?}?>
</div>
<div class="col-xs-9">
	<legend>Продление, добавление услуг</legend>	
	<form id="rent-extension" method="POST">
		<div class="col-xs-6 deployed" style="margin: 0; margin-left:-15px; min-width: 420px;max-width: 430px;padding-right: 0px;">
			<div class="col-xs-2 deployed">
				Аренда <span><?echo $data["subscription"];?>р./мес.</span>
			</div>		
			<div class="col-xs-2 deployed">
				<label class="signature">Продлить на</label>
				<select class="form-control" name="rent_month_count" required>
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
				<input type="text" data-id="rent_sum" class="form-control" value="<?echo $data["subscription"];?>" disabled>	
			</div>
			<div class="col-xs-2 deployed">
				Премиумы <br /><span style="color: #ccc;">200р./5шт./мес.</span>
			</div>		
			<div class="col-xs-1 deployed">
				<label class="signature">Колл.</label>
				<select class="form-control" name="rent_premium_count" required>
					<?for($i=1; $i<21; $i++){
						echo "<option value='".($i*5)."'>".($i*5)."</option>";
					}?>			
				</select>
			</div>
			<div class="col-xs-1 deployed"></div>
			<div class="col-xs-1 deployed">			
				<label class="signature">Сумма</label>
				<input type="text" data-id="rent_premium_sum" class="form-control" value="0" disabled>	
			</div>
		</div>
		<div class="col-xs-4 deployed" style="margin-top: 25px;">
			<div class="col-xs-1 deployed">
				<label class="signature">К оплате</label>
				<input type="text" data-id="sum" class="form-control" value="<?echo $data["subscription"];?>" disabled>
			</div>
			<div class="col-xs-2 deployed">
				<input type="submit" class="form-control btn btn-success" value="Оплатить">	
			</div>
		</div>
		<input type="hidden" data-id="rielter_sum" value="<?echo $data["subscription"];?>">
	</form>
	<?if($_SESSION['group_topic_id'] != 1 && false){?>
		<div class="col-xs-12 deployed">	
			<hr style="margin: 0;">
		</div>
		<form id="sell-extension" method="POST" action="?task=profile&action=extension">		
			<div class="col-xs-3 deployed">
				Продажа <span>350р./мес.</span>
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
				<label class="signature">К оплате</label>
				<input type="text" data-id="sell_sum" class="form-control" value="400" disabled>	
			</div>
			<div class="col-xs-2 deployed">
				<input type="submit" class="form-control btn btn-success" value="Оплатить">	
			</div>
		</form>
	<?}?>
</div>
<?if($_GET["task"]=="profile"){?>
	<div class="col-xs-9">
		<legend>Дополнительные услуги</legend>		
		<form id="new-address" method="POST" action="?task=profile&action=new_application">
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
		<form id="new-ip" method="POST" action="?task=profile&action=new_application">
			<div class="col-xs-7 deployed">
				<p>Смена ip-адреса на подключенной точке доступа (500 руб.)</p>
				<textarea class="form-control" name="comment" placeholder="ардес, телефон и новый IP точки" required="required"></textarea>
				<input type="hidden" name="rielter_sum" data-id="rielter_sum" value="500">
			</div>
			<div class="col-xs-2 deployed" style="margin: 30px;">
				<input type="submit" class="form-control btn btn-success" value="Заказать">	
			</div>
		</form>
		<!--
		<div class="col-xs-12 deployed">	
			<hr style="margin: 0;">
		</div>	
		<form id="new-rielter" method="POST" action="?task=profile&action=new_application">
			<div class="col-xs-5 deployed">
				<p>Регистрация нового сотрудника или смена номера</p>
				<textarea class="form-control" name="comment" placeholder="пояснение" required="required"></textarea>
			</div>
			<div class="col-xs-1 deployed" style="margin: 30px 0;">
				<label class="signature">Колл.</label>
				<input type="number" name="rielter_count" class="form-control" min="0" value="1">
			</div>
			<div class="col-xs-1 deployed" style="margin: 30px 0;">
				<label class="signature">К оплате</label>
				<input type="number" data-id="rielter_sum" class="form-control" value="100" disabled>
			</div>
			<div class="col-xs-2 deployed" style="margin: 30px;">
				<input type="submit" class="form-control btn btn-success" value="Оплатить">	
			</div>
		</form>
		-->
	</div>
<?}?>
<div class="col-xs-9" style="margin-top: 20px;">
	<legend>Список заказаных ранее услуг</legend>
	<table id="application" class="table table-striped">
		<thead>
			<tr><th>#</th><th>Дата вступание в силу</th><th>Дата платежа</th><th>Кол. проплаченых месяцев</th><th>Кол. оплаченых премиумов</th><th>Сумма</th></tr>
		</thead>
		<tbody>
			<?$count = count($data["payment_list"]);
			for($i=0; $count>$i; $i++){?>
				<tr>
					<td><?echo $i+1;?></td>
					<td><?echo $data["payment_list"][$i]["date_start"];?></td>
					<td><?echo $data["payment_list"][$i]["date_payment"];?></td>
					<td><?echo $data["payment_list"][$i]["month_count"];?></td>
					<td><?echo $data["payment_list"][$i]["premium_count"];?></td>
					<td><?echo $data["payment_list"][$i]["sum"];?></td>
				</tr>
			<?}?>
		</tbody>
	</table>
</div>