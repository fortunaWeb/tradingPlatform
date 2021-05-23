<legend>Статистика посещения</legend>
<table class="table table-striped list">
	<thead>
		<tr><th>#</th><th>IP</th><th>Дата</th><th>Браузер</th></tr>
	</thead>
	<tbody>
	<?
	$num=count($data);
	for($i=0; $i<$num; $i++){?>
		<tr>
			<td><?echo $i+1;?></td>
			<td><?echo $data[$i]["ip"];?></td>
			<td><?echo $data[$i]["date_enter"];?></td>
			<td><?echo $data[$i]["browser"];?></td>
		</tr>
	<?}
	unset($num, $i);
	?>
	</tbody>
</table>