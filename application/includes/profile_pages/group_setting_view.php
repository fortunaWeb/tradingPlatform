<script type="text/javascript">
	var	postUrl = "?task=profile&action=edit_group",
	confirmStr = "Обновить информацию о своей группе?";
</script>
<div class='col-xs-9'>
	<legend>Настройка своей группы</legend>
	<form class='form-inline' id='group_setting'>
		<div class='modal-body'>
			<div class='row info' style='margin:0'>
				<h4>Исключить из моей группы</h4>
				<hr>
				<div class='col-xs-3'>
					<label class='signature'>Телефон риелтера</label>
					<input type='text' class='form-control' data-id='phone' onkeyup='SearchRieleter($(this).val())'>
				</div>
				<div class='col-xs-2'>
					<label class='signature'>Название АН</label>

					<input type='text' class='form-control' data-name='an-list' placeholder='агентство' value=''>
					<div class='an_list' style='display: none;overflow: auto; height: 250px;'></div>
					<input type='hidden' name='company_id' value=''>
				</div>
				<div class='col-xs-12'>
					<table class='table table-striped' data-id='seacrh-rielter'>
						<thead>
							<tr><th>Агентство</th><th>Имя</th><th>Телефон</th><th></th></tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<div class='ccol-xs-12' style='font-size:17px; margin-top:25px'>
				Список риелтеров, которые не входят в мою группу и не видят мои варианты</div>
			<?
				$group_list = Get_functions::Get_black_group_list($_SESSION['fio']);
				$checked_hide_black_group = ($group_list['hide_black_group'] ==1) ? "checked" : "";
			?>
			<table class='table table-striped' data-id='black-group'>
				<thead>
					<tr>
						<th>Агентство</th><th>Имя</th><th>Телефон</th><th>Амнистировать</th>
						<th>Не отображать варианты(для всех)
							<input type='checkbox' name = 'hide_black_group' value='1' <?=$checked_hide_black_group?>>
						</th>
					</tr>
				</thead>
				<tbody>
					<?
					for($i = 0; $i<count($data); $i++){			
						$fio = $data[$i]['surname']." ".$data[$i]['name']." ".$data[$i]['second_name'];
						$checked = (!ereg($fio, $group_list['black_group'])) ? "checked" : "";
						echo "<tr>
							  <td>".$data[$i]['company_name']."</td>
							  <td>".$data[$i]['name']." ".$data[$i]['second_name']."</td>
							  <td>".$data[$i]['phone']."</td>
							  <td><input type='checkbox' value='".$fio."' ". $checked ."></td>
							  <td></td>
						</tr>";
					}?>
				</tbody>
			</table>
			<button type='button' class='btn btn-primary' onclick="formSubmit('group_setting')">Сохранить</button>
		</div>
	</form>
</div>