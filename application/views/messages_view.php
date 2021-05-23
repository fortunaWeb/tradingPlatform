<?$admin = $_GET["task"] == "admin";?>
<div class="col-xs-9">
	<legend>Список сообщений <?if($admin){echo "администратору";}else{echo "от администратора";}?></legend>	
	<table id="application" class="table table-striped">
		<thead><tr><th>#</th><th>От</th><th>АН</th><th>Дата</th><th></th><th></th></tr></thead>
		<tbody>
			<?for($i=0; $i<count($data); $i++){				
			if($admin){
				$fio = Get_functions::Get_fio_by_people_id($data[$i]['people_id_from']);
			}else{
				$fio = "Админ";
			}
			$new = $data[$i]['max(new)'] == 1 ? "Новое!" : "";
			?>
			<tr class='message' id='<?=$data[$i]['id'];?>' data-list-id="<?=$data[$i]["id"]?>">
				<td><?=($i+1);?></td>
				<td onClick="Messages(<?=$data[$i]['people_id_from'];?>, <?=$_SESSION['people_id'];?>, '<?=$fio;?>')"
                        target='_blank' data-toggle='modal' data-target='#messages-modal-win'><?=$fio;?> <?=($admin ? " (".$data[$i]['login_from'].")" : '');?></td>
				<td><?=Get_functions::Get_company_name_by_people_id($data[$i]['people_id_from']);?></td>
				<td><?=$data[$i]['date_send'];?></td>	
				<td><td style='color:#4CAE4C'><?=$new;?></span></td>
				<td><span class="dropdown">
						<button id="messagesMenu" data-toggle="dropdown"><span class='glyphicon glyphicon-align-justify' aria-hidden='true'></span></button>
						<ul class="dropdown-menu" aria-labelledby="messagesMenu" style='margin-left: -115px;'>
							<li><a href="#"
                                   onClick="ToArchive('message', <?=$data[$i]['id']?>)">В архив</a></li>
							<li><a href="#"
                                   onClick="Delete('message', <?=$data[$i]['id']?>)">Удалить</a></li>
						</ul>
					</span>
				</td>
			</tr>
			<?} unset($i);
			echo Helper::Modal_win_messages();
			?>
		</tbody>
	</table>
</div>