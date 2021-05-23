<legend>Список произведенных оплат</legend>
<table id="orders" class="table table-striped">
	<thead>
		<tr><th>#</th><th>АН</th><th>Тип оплаты</th><th>Номер карты/<br>кошелька</th><th>Место <br>платежа</th><th>Сумма</th><th>Коментарий <br>в платеже</th><th>Коментарий</th><th>Дата</th><th>Дата <br>платежа</th><th></th></tr>
	</thead>
	<tbody>
		<?$count = count($data["order_list"]);
		for($i=0; $count>$i; $i++){
			$active = $data[$i]['active'] == 0 ? "" : "color:#4CAE4C";?>
				<tr data-name='order' id="<?echo $data["order_list"][$i]["company_id"];?>" data-order-id="<?echo $data["order_list"][$i]["id"];?>">
					<td><?echo $i+1;?></td>
					<td><?echo $data["order_list"][$i]["company_name"];?></td>
					<td><?echo Translate::Order_type_place($data["order_list"][$i]["order_type"]);?></td>
					<td><?echo $data["order_list"][$i]['wallet_num'];?></td>
					<td><?echo Translate::Order_type_place($data["order_list"][$i]['order_place']);?></td>
					<td><?echo $data["order_list"][$i]["sum"];?></td>	
					<td><?echo $data["order_list"][$i]['comment_pay'];?></td>	
					<td><?echo $data["order_list"][$i]["comment_order"];?></td>	
					<td style="width: 100px;"><?echo date("d.m.Y H:i:s", strtotime($data["order_list"][$i]["date_order"]));?></td>	
					<td style="width: 100px;"><?echo date("d.m.Y H:i:s", strtotime($data["order_list"][$i]['pay_date']));?></td>
					<td style="<?echo $active;?>"><?if($active!="") echo "Новый!";?></td>
				</tr>
		<?}unset($i, $count, $active);?>
	</tbody>	
</table>