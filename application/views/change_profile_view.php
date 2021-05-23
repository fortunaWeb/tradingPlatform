<script type="text/javaScript">
	var confirmStr = "Обновить пользователя?";
	var postUrl = '?task=profile&action=change_user';
	function photoView(fotoType){			
		if (!$("li[data-id="+fotoType+"]").hasClass("active")){
			$("ul.photo li").each(function() {			
				$(this).toggleClass("active");
			});
		}
		photoShow();
	}
	$(function(){
		photoShow();
	});
	function photoShow(){		
		$("#modalForPhoto img").attr("src", $("ul.photo li.active").data("src"));
	}
</script>

<div class="row">
	<?//print_r ($_SESSION);	
		echo "<b>IP-адрес клиента:</b><br />".$_SERVER['REMOTE_ADDR']."<hr />"; 
		$fio[0] = "Фамилия";
		$fio[1] = "Имя";
		$fio[2] = "Отчество";
		$fioStrArr = explode(" ", $_SESSION['fio']);
		$phone_addon =  explode('||', $_SESSION['phone_addon']);
		$phones_for_archive =  Get_functions::Get_phones_for_archive();		
		$premium = Get_functions::Get_premium_count();
		$access = $_SESSION['group_topic_id'];
		$address_rent = Get_functions::Get_address_by_people_id($_SESSION['people_id'], 'rent');		
		$address_sell = Get_functions::Get_address_by_people_id($_SESSION['people_id'], 'sell');	
	?>
	<div class="col-xs-12 info an">
		<div class="row">
			<legend>
				Информация агентства
				<span style="font-size:15px; margin-left: 40%;">Дата регистрации: <strong><?echo Translate::month_ru(date("d/m/Y H:i", strtotime($_SESSION['date_company_reg'])));?></strong></span>
			</legend>
			<div class="col-xs-8">
				<div class="input-group interval xl">
					<span class="input-group-addon">А.Н.</span>
					<input type="text" class="form-control" value="<?echo $_SESSION['company_name'];?>" disabled>
				</div>
				<div class="input-group interval xl">
					<span class="input-group-addon">Логин</span>
					<input type="text" class="form-control" value="<?echo $_SESSION['login'];?>" disabled>
				</div>	
				<div class="input-group interval xl">
					<span class="input-group-addon">Пароль</span>
					<input type="text" class="form-control" value="<?echo $_SESSION['pass'];?>" disabled>
				</div>			
				<br />
				<?for($i=0; $i < count($fioStrArr); $i++){
					if(count($fioStrArr) == 1){?>
						<div class="input-group interval xl">
							<span class="input-group-addon">Имя</span>
							<input type="text" class="form-control" value="<?echo $fioStrArr[$i];?>" disabled>
						</div>	
					<?}else{?>
						<div class="input-group interval xl fio">
							<span class="input-group-addon"><?echo $fio[$i];?></span>
							<input type="text" class="form-control" value="<?echo $fioStrArr[$i];?>" disabled>
						</div>	
					<?}
				}?>
				<br />
				<div class="input-group interval xxl">
					<span class="input-group-addon" style="min-width: 180px;">Телефон для сообщений</span>
					<input type="text" class="form-control" value="<?echo $_SESSION['phone'];?>" disabled>
				</div>	
				<div class="input-group interval xxl">
					<span class="input-group-addon">E-mail</span>
					<input type="text" class="form-control" style="min-width: 180px; max-width: 180px;" value="<?echo $_SESSION['email'];?>" disabled>
				</div>	
				
				<div class="input-group interval xxxl">
					<span class="input-group-addon">E-mail рабочий </span>
					<input type="text" class="form-control" style="min-width: 180px; max-width: 180px;" value="<?echo $_SESSION['email'];?>" disabled>
				</div>	
				<div class="input-group interval xxxl">
					<span class="input-group-addon">пароль рабочий </span>
					<input type="text" class="form-control" style="min-width: 180px; max-width: 180px;" value="<?echo $_SESSION['email'];?>" disabled>
				</div>	
				<br />	

				<div class="phoneAddon info col-xs-6 deployed">
					<span>Дополнительные телефоны</span><br />				
					<div class="input-group interval xl phone" data-id="new">
						<input type="text" class="form-control" placeholder="доп. телефон" id="phone">
						<button onClick="add_phone('<?echo $_SESSION['user'];?>', false)" data-user="<?echo $_SESSION['user'];?>" id="add_phone" class="form-control btn btn-success right">добавить</button>
					</div>
					<?if(count($phone_addon) > 0){
						for($i=0; $i<count($phone_addon); $i++){
							if ($phone_addon[$i] != ""){?>
							<div class="input-group interval xl phone" data-id="<?echo $i;?>">
								<span class="input-group-addon success">Активен</span>
								<input type="text" class="form-control" value="<?echo $phone_addon[$i];?>" disabled>
								<button onClick="delete_phone(<?echo $i;?>)" data-user="<?echo $_SESSION['user'];?>" id="delete_phone" class="form-control btn btn-danger right">удалить</button>
							</div>
						<?}
						}
					}?>
					<?if(count($phones_for_archive) > 0){
						for($i=0; $i<count($phones_for_archive); $i++){
						 if($phones_for_archive[$i] != ""){
						?>
							<div class="input-group interval xl phone">
								<span class="input-group-addon danger disabled">Не активен</span>
								<input type="text" class="form-control" value="<?echo $phones_for_archive[$i];?>" disabled>
								<button class="form-control btn btn-danger right disabled">удалить</button>
							</div>
						<?}
						}
					}?>
				</div>			
			</div>
			<div class="col-xs-4">
				<?if(file_exists("images/".$_SESSION['user']."/user_face/face.jpg") ||
					file_exists("images/".$_SESSION['user']."/documents/document.jpg")){?>
					<ul class="nav nav-tabs photo">			
					  <li class="active" data-id="document" onClick="photoView('document')" data-src="images/<?echo $_SESSION['user'];?>/user_face/face.jpg">
						  <a href="javaScript:void(0)">Фото</a>				  
					  </li>	
					  <li class="" onClick="photoView('face')" data-id="face" data-src="images/<?echo $_SESSION['user'];?>/documents/document.jpg" class="img-rounded">
						<a href="javaScript:void(0)">Паспорт</a>								
					  </li>
					</ul>			
					<div id="modalForPhoto">
						<img src="" style="width: 100%;">
					</div>
				<?}?>
			</div>		
		</div>	
		<div class="row">
			<legend>Информация о доступах к БД</legend>
			<div class="col-xs-6 <?echo $access == 2 ? "disabled" : "";?>">
				<label><?if($access == 2) echo "Недоступно для Вашего агентства";?></label>
				<br>
				<div class="input-group interval xl">
					<span class="input-group-addon" style="min-width: 100px;">Аренда</span>
					<input type="text" class="form-control" style="min-width:130px" value="<?echo Get_functions::Get_date_end("rent");?>" disabled>
				</div>	
				<br />
				<div class="input-group interval xl">
					<span class="input-group-addon">Премиумы</span>				
					<input type="text" style="" class="form-control" value="<?echo $premium['rent_premium'];?>" disabled>
					<span class="input-group-addon">Сумма</span>
					<input type="text" class="form-control" value="<?echo $premium['rent_premium'] * 40 -200;?>" disabled>
				</div>				
				<br />
				<label>Адреса</label>
				<? Helper::Address($address_rent);?>
			</div>	
			<div class="col-xs-6 <?echo $access == 1 ? "disabled" : "";?>">
				<label><?if($access == 1) echo "Недоступно для Вашего агентства";?></label>
				<br>
				<div class="input-group interval xl">
					<span class="input-group-addon" style="min-width: 100px;">Продажа</span>
					<input type="text" class="form-control" style="min-width:130px" value="<?echo Get_functions::Get_date_end("sell");?>" disabled>
				</div>	
				<br />
				<div class="input-group interval xl">
					<span class="input-group-addon">Премиумы</span>				
					<input type="text" style="" class="form-control" value="<?echo $premium['sell_premium'];?>" disabled>
					<span class="input-group-addon">Сумма</span>
					<input type="text" class="form-control" value="<?echo $premium['sell_premium'] * 40 - 200;?>" disabled>
				</div>	
				<br />
				<label>Адреса</label>			
				<? Helper::Address($address_sell);?>
			</div>			
		</div>
	</div>
	<table class="table table-striped">
		<thead><tr><th>#</th><th>Логин</th><th>ФИО</th><th>Стоимость</th><th></th></tr></thead>
		<tbody>
		<?php
		if ($_POST['response']) {
			echo '<div id="error_div" >'. $_POST['response'] .'<span id="close" style="color: red" onclick="closeResponse()">x</span></div>';	
		}
			for($j=0; $j<count($data); ++$j) {?>
				<tr id="<?php echo $data[$j]['user_id']; ?>" <?if($data[$j]['active'] == "0") echo "title='Не подтвержден администратором' style='background-color:#ccc;'"?>>
					<th scope="row"><?echo $j+1;?></th>				
					<th>
						<a href="javascript:void(0)" onclick="openModalWin(<?echo $j;?>)">
							<?echo $data[$j]['login'];?>
						</a>
					</th>
					<th id="fio"><?echo $data[$j]['surname']." ".$data[$j]['name']." ".$data[$j]['second_name'];?></th>
					<th><? echo Helper::Cost_for_user($j, $data[$j]['ip_rent'], $data[$j]['ip_sell']);?></th>
					<th><span style="cursor:pointer;color: #c9302c;" onclick="delete_user('<?php echo $data[$j]['user_id']; ?>')">Удалить</span></th>
				</tr>
			<?}?>
		</tbody>
	</table>
	<div class="right" id="">
		<a class="form-control btn btn-success" href='?task=profile&action=create_child_profile'>Добавить сотрудника</a>
	</div>
</div>
<?/* кнопка и хелпер работают только в паре*/?>
<button style="display:none" data-toggle="modal" data-target="#modal-win"></button>
<?if ($_POST){
	echo Helper::Modal_win_change_user($data, $_POST['index']);
}?>	