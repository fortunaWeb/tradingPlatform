<div class="col-xs-9 deployed">
	
	<legend>
		Список сотрудников
		<a class="form-control btn btn-success" href="?task=profile&amp;action=create_profile" style="width: 220px;margin-left: 20px;margin-bottom: 5px;">
			Добавить нового сотрудника
		</a>
	</legend>
	<?for($e=0; $e<count($data); $e++){
		$director = $data[$e]['parent']==0;
		?>
		<form class="employee col-xs-12 <?if($director) echo 'director';?>" data-id="<?=$data[$e]['user_id'];?>">
			<div class="row confirm" style="<?if($data[$e]['active'] == 0) echo 'display:block;'?>">
				<div class="col-xs-12 deployed" style="text-align: center;">
					<span style="color: #F71E1E;text-align: center;text-decoration: underline;"><?if($data[$e]['active'] == 0) echo "Не подтвержден администратором!";?></span>
				</div>
			</div>
			<div class="row fio">
				<div class="col-xs-2 deployed">
					<span style="cursor:pointer; color:#A70000" onClick="ShowEmployee('<?echo $data[$e]['user_id'];?>')">
						<?echo ($data[$e]['parent'] == 0 ? "Директор" : "Сотрудник");?>
					</span>
				</div>
				<div class="col-xs-4 deployed">
					<div class="checkbox" style="margin-bottom: auto; height: 26px; display: inline-block;">
						<label style="margin-top: -15px;">
							<input type="checkbox" name="access_var"
                                   onChange="UpdateUser('access_var', <?=$data[$e]['user_id'];?>)" value="1"
                                <?=$data[$e]['access_var']==1 ? 'checked' : ''?>>
							Разрешить этому логину просмотр и продление всех вариантов АН
						</label>
					</div>
					<div class="checkbox" style="margin-bottom: auto; height: 26px; display: inline-block;">
						<label style="margin-top: -15px;">
							<input type="checkbox" name="rent_view" 
							onChange="UpdateUser('rent_view', <?=$data[$e]['user_id'];?>)" value="1"
								<?=$data[$e]['rent_view']==1 ? 'checked':''?>>
							Просмотр вариантов на куплю
                        </label>
					</div>

				</div>
				<?if($data[$e]['user_id'] != $_SESSION["user"]){?>
					<div class="col-xs-3 right deployed">
						<a href="javascript:void(0)" onClick="delete_user(<?echo $data[$e]['user_id'];?>)" style="color: #A70000;">Уволить сотрудника</a>
					</div>
				<?}?>
			</div>
			<div class="row fio">
				<div class="col-xs-1 deployed">
					<label class="signature">Логин</label>
					<input type="text" name="us-login" class="form-control" placeholder="логин" value="<?echo $data[$e]['login'];?>" required disabled>
				</div>
				<div class="col-xs-2 deployed">
					<label class="signature">Пароль</label>
					<input type="text" name="us-password" class="form-control" placeholder="пароль" value="<?echo $data[$e]['password'];?>" required disabled>
				</div>
				<div class="col-xs-4 deployed">
					<label class="signature">Email</label>
					<input type="text" name="pe-email" class="form-control" placeholder="email" value="<?echo $data[$e]['email'];?>" required disabled>
				</div>
				<div class="col-xs-2 deployed">
					<label class="signature">Email рабочий</label>
						<input type="text" data-id="email_work_<?echo $data[$e]['user_id'];?>" class="form-control" placeholder="Рабочий E-mail" id="email_work_<?echo $data[$e]['user_id'];?>" value="<?echo $data[$e]['email_work'];?>" >
						<button type="button" onClick="add_email_work('<?echo $data[$e]['user_id'];?>', true)" data-user="<?echo $data[$e]['user_id'];?>" class="form-control btn btn-success right">добавить</button>
				</div>
				<div class="col-xs-2 deployed">
					<label class="signature">Email Пароль</label>
					<input type="text" data-id="email_pass_<?echo $data[$e]['user_id'];?>" class="form-control" placeholder="Рабочий E-mail" id="email_pass_<?echo $data[$e]['user_id'];?>" value="<?echo $data[$e]['email_pass'];?>" >
					<button type="button" onClick="add_email_pass('<?echo $data[$e]['user_id'];?>', true)" data-user="<?echo $data[$e]['user_id'];?>" class="form-control btn btn-success right">добавить</button>
				</div>
			</div>	
			<div class="row fio">
				<div class="col-xs-2 deployed">
					<label class="signature">Фамилия</label>
					<input type="text" name="pe-surname" class="form-control" placeholder="Фамилия" value="<?echo $data[$e]['surname'];?>" required disabled>
				</div>
				<div class="col-xs-2 deployed">
					<label class="signature">Имя</label>
					<input type="text" name="pe-name" class="form-control" placeholder="Имя" value="<?echo $data[$e]['name'];?>" required disabled>
				</div>
				<div class="col-xs-2 deployed">
					<label class="signature">Отчество</label>
					<input type="text" name="pe-second_name" class="form-control" placeholder="Отчество" value="<?echo $data[$e]['second_name'];?>" required disabled>
				</div>
				<div class="col-xs-2 deployed">
					<label class="signature">Ник</label>
					<input type="text" name="us-nickname" onChange="NewChatNick($(this).val(), <?=$data[$e]['user_id'];?>)" class="form-control" placeholder="nick" value="<?echo $data[$e]['nickname'];?>">
				</div>
			</div>
			<div class="row phone">
				<div class="col-xs-2 deployed">
					<label class="signature">Телефон для сообщений</label>
					<input type="text" name="pe-phone" onFocus="$(this).mask('8 (999) 999-9999')" class="form-control" placeholder="Телефон для сообщений" value="<?echo $data[$e]['phone'];?>" required disabled>
				</div>
				<?$phones_addon = explode('||', $data[$e]['phone_addon']);
				for($p=0; $p<count($phones_addon); $p++){
					if(ereg('8', $phones_addon[$p])){
						echo "<div class='col-xs-2 deployed'>
								<label class='signature'>Основной</label>
								<input type='text' onFocus='$(this).mask(\"8 (999) 999-9999\")' name='pe-phone_addon".$p."' class='form-control' placeholder='Телефоны для созвонов' value='".$phones_addon[$p]."' required disabled>
							</div>";
					}
				}
				unset($phones_addon);
				?>
				<div class="col-xs-3 deployed">
					<div class="input-group interval xl phone" data-id="new">
						<input type="text" data-id="phone" class="form-control" placeholder="доп. телефон" id="phone">
						<button type="button" onClick="add_phone('<?echo $data[$e]['user_id'];?>', true)" data-user="<?echo $data[$e]['user_id'];?>" class="form-control btn btn-success right">добавить</button>
					</div>
				</div>
			</div>
			<?php
			/*
			*	прячем IP для клиентов
			?>
			<div class="row topMNull" style="display:block">
				<div class="col-xs-2 deployed">
					<span class="right">IP аренды:</span>
				</div>
				<?
				$address_rent = Get_functions::Get_address_by_people_id($data[$e]['people_id'], 'rent');	
				for($i=0; $i<count($address_rent); $i++){
					echo "<div class='col-xs-2 deployed'><input type='text' name='ad-rent_ip-".$address_rent[$i]['id']."' class='form-control' placeholder='ip' value='". $address_rent[$i]['ip']."' required disabled></div>";
				}?>				
			</div>
			<!--<div class="row">
				<div class="col-xs-2 deployed">
					<span class="right">IP продажи:</span>
				</div>
				<?
				$address_rent = Get_functions::Get_address_by_people_id($data[$e]['people_id'], 'sell');	
				for($i=0; $i<count($address_rent); $i++){
					echo "<div class='col-xs-2 deployed'><input type='text' name='ad-sell_ip-".$address_rent[$i]['id']."' class='form-control' placeholder='sell_ip' value='". $address_rent[$i]['ip']."' required disabled></div>";
				}
				unset($address_rent);

				?>
			</div>-->
			<php
			*/
			 ?>
			<div class="row" style="display:block">
				<?if(!$director){?>
					<div class="col-xs-4 deployed">
						<!--<div class="checkbox" style="margin-bottom: auto; height: 26px; display: inline-block;">
							<label>
								<input name="" type="checkbox" value="1">
								Блок ком. хоз.
							</label>
						</div>
						<div class="checkbox" style="margin-bottom: auto; height: 26px; display: inline-block;">
							<label>
								<input name="" type="checkbox" value="1">
								Блок ком. АН	
							</label>
						</div>
						<div class="checkbox" style="margin-bottom: auto; height: 26px; display: inline-block;">
							<label>
								<input name="" type="checkbox" value="1">
								Блок доски
							</label>
						</div>-->
					</div>
				<?}?>
			</div>
		</form>
	<?}?>
</div>