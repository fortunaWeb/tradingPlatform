<script type="text/javaScript">	
	//для сохранения
	var confirmStr = "Обновить информацию?";
	var postUrl = '?task=profile&action=change_user';
	$('.fancybox').fancybox();
</script>
<div class="col-xs-9">	
	<legend>Результаты поиска логина</legend>	
	<table class="table table-striped list">
		<thead><tr><th>#</th><th>АН</th><th>Дата истечения аренды</th><th>Дата истечения продажи</th></tr></thead>
		<tbody>
			<?php $company_id = $data[0]['company_id'];
			?>
			<tr class="an" id="<?echo $company_id;?>">
				<td>1</td>
				<td><? echo $data[0]['company_name'];?></td>
				<td><? echo $data[0]['sell_date_end'];?></td>
				<td><? echo $data[0]['sell_date_end'];?></td>				
				<!--<td><span style="cursor:pointer;color: #F0AD0A;" onclick="user_to_archive('<?php echo $company_id; ?>')">В архив</span></td>	
				<td><span style="cursor:pointer;color: #c9302c;" onclick="delete_user('<?php echo $company_id; ?>')">Удалить</span></td>-->
			</tr>
			<tr>
				<td colspan="4">
					<?include "application/views/employee_list_view.php";?>
				</td>
			</tr>
		</tbody>
	</table>
</div>