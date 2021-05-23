<script type="text/javascript">
	$(function(){
		$("#new-street").submit(function(e){
			e.preventDefault();
			var adr = $(this).attr("action");
			$.post(adr, "street="+$("#new-street #str").val(), function(){
				$("#new-street").parent().prepend("улица добавлена");
				setTimeout(function(){
					window.location = "/?task=admin";
				}, 1000)
			})
		})
		$("#interval").on("change", function(){
			var interval = $(this).val();
			if(interval<1){
				if(confirm("Вы уверены, что хотите поставить данное значение?")){
					$.post("?task=admin&action=update_archive_interval", "interval="+interval);	
				}else{
					window.location.reload();
				}
			}else{
				$.post("?task=admin&action=update_archive_interval", "interval="+interval);		
			}
		})
	})
</script>
<div class="col-xs-9">
	<legend>Общие сведения</legend>
	<div class="col-xs-8 info">
		<form id="new-street" action="?task=admin&action=new_street" method="POST" style="margin-bottom:5px">
			<label for="str" style="margin-top:3px;" class="left control-label">Добавление новой улицы</label>
			<div class="col-xs-4">
				<input id="str" class="form-control" type="text" form="new-street" name="street" placeholder="название улицы" value="" autocomplete="off" required>
				<div class="street_list" style="display: none;"></div>
			</div>
			<input type="submit" form="new-street" value="Добавить">
		</form>
	</div>
	<div class="col-xs-4 deployed">
		<a class="btn btn-success" href="/?task=tasks" target="_blank">Задачник</a>
	</div>
	<div class="row"></div>
	<div class="col-xs-4 deployed">
		<a href="/?task=admin&action=user_list&online=1">Сейчас на сайте: <?=Helper::Online_count();?></a>
	</div>
	<div class="col-xs-4 deployed">
		<a href="?task=var&action=photo_statistic" target="_blank">Статистика просмотра фото</a>
	</div>
	<div class="col-xs-4 deployed">
		<a href="/?task=admin&action=user_list&pay_parse=1">Подключили 'частники 2': <?=Helper::Pay_parse_company_count();?></a>
	</div>
	<div class="col-xs-4 deployed">
		<a href="/?task=admin&action=user_list&free_ip=1">Список АН без ограничений по IP: <?=Helper::Free_ip_count();?></a>
	</div>
	<div class="col-xs-4 deployed">
		<a href="/?task=admin&action=user_list&order_access=0">Список АН без доступа к оплате: <?=Helper::Order_access_off_count();?></a>
	</div>
	<div class="col-xs-4 deployed">
		<a href="/?task=admin&action=user_list&duty=1">Должники: <?=Helper::Company_with_duty_count();?></a>
	</div>
	<div class="col-xs-4 deployed">
		<a href="/?task=admin&action=user_list&buy_sell=1">
			Продажа: <?=Helper::Pay_parse_buysell_company_count();?></a>
	</div>
	<br/>
	<div class="col-xs-4 deployed form-inline" style = 'margin-right: 50%;'>
		<div class="form-group">
			<label for="interval">Интервал перевода в архив:</label>
			<input type="text" class="form-control" id="interval" style="width: 50px;" value="<?=Helper::For_archive_interval()?>" />
		</div>
	</div>
</div>