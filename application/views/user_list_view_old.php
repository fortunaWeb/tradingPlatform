<script type="text/javaScript">	
	//для модального окна
	var confirmStr = "Обновить пользователя?";
	var postUrl = '?task=profile&action=change_user';
</script>
<div class="row">
	<div class="right" id="">
		<a class="form-control btn btn-success" href='?task=profile&action=create_login'>Добавить АН</a>
	</div>	
	<div class="left" id="">
		<input type="text" data-id="searchAn" onchange="searchAn()" class="form-control" style="min-width:130px" placeholder="поиск по любой строке" value="">
	</div>		
	<table class="table table-striped">
		<thead><tr><th>#</th><th>Логин</th><th>IP</th><th>АН</th><th>ФИО</th><th>Тип пользователя</th><th></th><th></th></tr></thead>
		<tbody>
			<?php for($j=0; $j<count($data); ++$j) { 
				$user_id = $data[$j]['user_id'];
			?>
			<tr id="<?echo $user_id;?>" <?if($data[$j]['active'] == "0") echo "title='Не подтвержден администратором' style='background-color:#ccc;'"; if($data[$j]['parent'] == 0) echo "style='background-color: #C7F2D2;'";?>>
				<th><? echo $j+1; ?></th>
				<th data-id="login"><a href="javascript:void(0)" onclick="openModalWin(<?echo $j;?>)">
				<? echo $data[$j]['login']; ?></a></th>
				<th><? echo Get_functions::Get_address_by_people_id($data[$j]['people_id'], 'rent')[0]['ip']; ?></th>
				<th><? echo $data[$j]['company_name']; ?></th>	
				<th><? echo ($data[$j]['surname']." ".$data[$j]['name']." ".$data[$j]['second_name']); ?></th>	
				<th><? echo ($data[$j]['parent'] == 0 ? "Директор" : "Сотрудник"); ?></th>	
				<th><span style="cursor:pointer;color: #F0AD0A;" onclick="user_to_archive('<?php echo $user_id; ?>')">В архив</span></th>	
				<th><span style="cursor:pointer;color: #c9302c;" onclick="delete_user('<?php echo $user_id; ?>')">Удалить</span></th>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?/* кнопка и хелпер работают только в паре*/?>
	<button style="display:none" data-toggle="modal" data-target="#modal-win"></button>
	<?if ($_POST){
		echo Helper::Modal_win_change_user($data, $_POST['index']);
	}?>	
		
</div>


