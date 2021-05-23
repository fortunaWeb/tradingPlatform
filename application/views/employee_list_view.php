<div id="employeeList">	
	<form class="tariff col-xs-12" data-id="<?echo $data[0]['company_id'];?>" style="background-color: rgb(186, 236, 188) !important;">
		<div class="row">
			<div class="col-xs-12 deployed">
				<div class="col-xs-2 deployed">
					<label class="signature">Дата продажи</label>
					<input type="text" onFocus="$(this).mask('9999-99-99')" onClick="showDatePicker()" name="ac-sell_date_end" class="form-control" placeholder="дата" value="<?echo $data[0]['sell_date_end'];?>">
				</div>			
				<div class="col-xs-1 deployed">
					<label class="signature">Прем.П</label>
					<input type="text" name="co-sell_premium" class="form-control" placeholder="периум" value="<?echo $data[0]['sell_premium'];?>">
				</div>		
				<div class="col-xs-1 deployed">
					<label class="signature">Абонентка</label>
					<input type="text" name="co-subscription_sell" class="form-control" placeholder="абонентка" value="<?echo $data[0]['subscription_sell'];?>">
				</div>
				<div class="col-xs-12"></div>
				<div class="col-xs-2 deployed">
					<label class="signature">Дата частники  продажа</label>
					<input type="text" onFocus="$(this).mask('9999-99-99')" name="ac-sell_date_end" class="form-control" placeholder="дата" value="<?echo $data[0]['sell_date_end'];?>">
				</div>
				<div class="col-xs-1 deployed">
					<label class="signature">Долг</label>
					<input type="text" name="co-duty" class="form-control" placeholder="Долг" value="<?echo $data[0]['duty'];?>">
				</div>
				<div class="col-xs-2 deployed right">
					<a href="javascript:void(0)" style="color:#A70000" onclick="DeleteAn(<?=$data[0]['company_id']?>)">Удалить АН</a>
				</div>
				<div class="col-xs-2 deployed right">
					<span class="dropdown">
						<a href="javascript:void(0)" style="color:#A70000" id="blockAn" data-toggle="dropdown" aria-expanded="false">Блокировка/активация</a>
						<ul class="dropdown-menu" aria-labelledby="blockAn">
							<li><a href="javascript:void(0)" onclick="BlockAn(<?=$data[0]['company_id']?>, 1)">Активировать всех сотрудников АН</a></li>
							<li><a href="javascript:void(0)" onclick="BlockAn(<?=$data[0]['company_id']?>, 0)">Заблокировать всех сотрудников АН</a></li>	
						</ul>
					</span>
				</div>	
				<div class="col-xs-12 deployed">
					<textarea class="form-control" name="co-duty_comment" placeholder="коментарий к долгу" rows="1"><?echo $data[0]['duty_comment'];?></textarea>
				</div>
			</div>
			<div class="col-xs-12">
				<div class="col-xs-1 deployed">
					<div class="checkbox" style="margin-bottom: auto; height: 26px; display: inline-block;">
						<label>
							<input type="checkbox" name="co-order_access" value="<?if($data[0]['order_access'] == 1) echo 1;?>" <?if($data[0]['order_access'] == 1) echo "checked";?>>
							Оплата
						</label>
					</div>
				</div>	
				<div class="col-xs-2 deployed">
					<div class="checkbox" style="margin-bottom: auto; height: 26px; display: inline-block;">
						<label>
							<input type="checkbox" name="co-tariff_id" value="<?=$data[0]['tariff_id'];?>" <?if($data[0]['tariff_id'] == 1) echo "checked";?>>
							Архивный т.п.
						</label>
					</div>
				</div>	
				<div class="col-xs-2 deployed">
					<div class="checkbox" style="margin-bottom: auto; height: 26px; display: inline-block;">
						<label>
							<input type="checkbox" name="co-prolong_garant_no_exists" value="<?=$data[0]['prolong_garant_no_exists'];?>" 
							<?if($data[0]['prolong_garant_no_exists'] == 1) echo "checked";?>>
							Выкл актуален 100%
						</label>
					</div>
				</div>

				<div class="col-xs-2 deployed">
					<div class="checkbox" style="margin-bottom: auto; height: 26px; display: inline-block;">
						<label>
							<input type="checkbox" name="co-without_vip" value="<?=$data[0]['without_vip'];?>" <?if($data[0]['without_vip'] == 1) echo "checked";?>>
							Без VIP
						</label>
					</div>
				</div>

				<div class="col-xs-1 deployed">
					<a href="javascript:void(0)" onClick="ServicesListShow(<?=$data[0]['company_id'];?>)">Покупки</a>
				</div>
				<div class="col-xs-1 deployed">
					<a href="javascript:void(0)" onClick="OrderListShow(<?=$data[0]['company_id'];?>)">Оплаты</a>
				</div>
				<div class="col-xs-2 deployed">
					<button type="button" onClick="Update('<?echo "co-".$data[0]['company_id']."-tariff";?>')" data-id="<?echo $data[0]['company_id'];?>" class="form-control btn btn-success">Сохранить</button>	
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 deployed hidden" data-name="services-list">
			</div>
			<div class="col-xs-12 deployed hidden" data-name="order-list">
			</div>
		</div>
	</form>
	<?
	for($e=0; $e<count($data); $e++){?>
		<form class="employee col-xs-12 director <?/*if($data[$e]['parent']==0) echo 'director';*/?>" data-id="<?echo $data[$e]['user_id'];?>">
			<div class="row fio" <?php if($data[$e]['date_dismiss'] != '0000-00-00 00:00:00') echo "style = 'background-color:red' " ;?>
			>
				<div class="col-xs-3" style="margin-bottom: 10px;">
					<span class="dropdown">
						<a href="javascript:void(0)" style="color:#A70000" id="changeStatus" data-toggle="dropdown" aria-expanded="true"><?echo ($data[$e]['parent'] == 0 ? "Директор" : "Сотрудник");?></a>
						<?if($data[$e]['parent'] > 0){?>
							<ul class="dropdown-menu" aria-labelledby="changeStatus">
								<li><a href="javascript:void(0)" onclick="ChangeStatus('<?echo $data[$e]['user_id'];?>')">Перевести сотрудника в директоры</a></li>
							</ul>
						<?}?>
					</span>
					<div class="checkbox" style="margin-bottom: auto; height: 26px; display: inline-block;  margin-left: 10px;">
						<label>
							<input type="checkbox" data-id="trusted" onClick="ForOpenSite($(this))" <?if($data[$e]['for_open_site']!=0)echo "checked";?>>
							Доверенный
						</label>
					</div>
					<br />
					<a href="javascript:void(0)" onClick="Delete('session', <?=$data[$e]['user_id'];?>)">Удалить статистику</a>
					<br />
					<br />
					<a href="javascript:void(0)" onClick="deleteSession(<?=$data[$e]['people_id'];?>)">Удалить Сессию(Выкинуть)</a>
				</div>
				<div class="col-xs-2">
					<div class="checkbox" style="margin-bottom: auto; height: 26px; display: inline-block;">
						<label>
							<input name="us-active" type="checkbox" value="<?if($data[$e]['active'] == 1) echo 1;?>" <?if($data[$e]['active'] == 1) echo "checked";?> disabled>
							Активен
						</label>
						<span class="dropdown"
                            `>
							<a href="javascript:void(0)" style="color:#A70000" id="deleteEmploye" data-toggle="dropdown" aria-expanded="false">Удалить</a>
							<ul class="dropdown-menu" aria-labelledby="deleteEmploye">
								<li><a href="javascript:void(0)" onClick="DeleteEmploye(<?=$data[$e]['user_id']?>, 0)">Предать варианты директору</a></li>
								<li><a href="javascript:void(0)" onClick="DeleteEmploye(<?=$data[$e]['user_id']?>, 1)">Удалить всю информацию</a></li>	
							</ul>
						</span>
					</div>
				</div>	
				<div class="col-xs-3">
					<div class="checkbox" style="display: none;">
						<label>
							<input type="checkbox" name="sell_on" value="2" "checked" >
							Продажа
						</label>
					</div>
				</div>
				<div class="col-xs-2 deployed">
					<label class="signature">Добавитт на баланс</label>
					<input type="text" name="pe-pay_adds" class="form-control" placeholder="pay_adds" value="<?echo $data[$e]['pay_adds'];?>" required disabled>
				</div>

				<div class="col-xs-4">					
					<div class="checkbox" style="margin-bottom: auto; height: 26px; display: inline-block;">
						<label>
							<input name="us-block_com_an" type="checkbox" value="1" <?if($data[$e]["block_com_an"]==1) echo "checked";?> disabled>
							Блок ком. АН	
						</label>
					</div>
					<div class="checkbox" style="margin-bottom: auto; height: 26px; display: inline-block;">
						<label>
							<input name="us-block_com_parse" type="checkbox" value="1" <?if($data[$e]["block_com_parse"]==1) echo "checked";?> disabled>
							Блок ком. хоз
						</label>
					</div>
					<div class="checkbox" style="margin-bottom: auto; height: 26px; display: inline-block;">
						<label>
							<input name="us-block_forum" type="checkbox" value="1" <?if($data[$e]["block_forum"]==1) echo "checked";?> disabled>
							Блок форума
						</label>
					</div>
					<div class="checkbox" style="margin-bottom: auto; height: 26px; display: inline-block;">
						<label>
							<input name="us-block_chat" type="checkbox" value="1" <?if($data[$e]["block_chat"]==1) echo "checked";?> disabled>
							Блок чата
						</label>
					</div>
				</div>
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
				<div class="col-xs-2">
					<?
					$doc = opendir('images/'.$data[$e]['people_id'].'/documents/');
					while ($file = readdir($doc)){
						if($file != "." && $file!=".."){
							$photo = 'images/'.$data[$e]['people_id'].'/documents/'.$file;
						}
					}
					echo "<a class='fancybox' href='".$photo."' title='Паспорт'>Паспорт</a>";?>
				</div>
				<div class="col-xs-2">
					<?
					$doc = opendir('images/'.$data[$e]['people_id'].'/user_face/');
					unset($photo);
					while ($file = readdir($doc)){
						if($file != "." && $file!=".."){
							$photo = 'images/'.$data[$e]['people_id'].'/user_face/'.$file;
						}
					}
					echo "<a class='fancybox' href='".$photo."' title='Физиономия'>Физиономия</a>";
					unset($photo, $doc, $file, $address_rent, $i, $address_sell, $phones_addon);?>
				</div>
			</div>
			<div class="row fio">
				<div class="col-xs-2 deployed">
					<label class="signature">Email рабочий</label>
						<input 
						type="text" 
						data-id="email_work_<?echo $data[$e]['user_id'];?>" 
						class="form-control" 
						placeholder="Рабочий E-mail"
						id="email_work_<?echo $data[$e]['user_id'];?>" 
						value="<?=$data[$e]['email_work'];?>" >

						<button type="button" onClick="add_email_work('<?echo $data[$e]['user_id'];?>', true)" 
							data-user="<?echo $data[$e]['user_id'];?>" class="form-control btn btn-success right">добавить</button>
				</div>
				<div class="col-xs-2 deployed">
					<label class="signature">Email Пароль</label>
					<input type="text" data-id="email_pass_<?echo $data[$e]['user_id'];?>" class="form-control" placeholder="Рабочий E-mail" id="email_pass_<?echo $data[$e]['user_id'];?>" value="<?echo $data[$e]['email_pass'];?>" >
					<button type="button" onClick="add_email_pass('<?echo $data[$e]['user_id'];?>', true)" data-user="<?echo $data[$e]['user_id'];?>" class="form-control btn btn-success right">добавить</button>
				</div>

				<div class="col-xs-2 deployed">
					<label class="signature">Внешний логин</label>
					<input type="text" data-id="external_login_<?echo $data[$e]['user_id'];?>" class="form-control" placeholder="Логин внешнего сайта" id="external_login_<?echo $data[$e]['user_id'];?>" value="<?echo $data[$e]['external_login'];?>" >
					<button type="button" onClick="add_external_login('<?echo $data[$e]['user_id'];?>', true)" data-user="<?echo $data[$e]['user_id'];?>" class="form-control btn btn-success right">добавить</button>
				</div>
				<div class="col-xs-2 deployed">
					<label class="signature">Внешний пароль</label>
					<input type="text" data-id="external_pass_<?echo $data[$e]['user_id'];?>" class="form-control" placeholder="пароль внешнего сайта" id="external_pass_<?echo $data[$e]['user_id'];?>" value="<?echo $data[$e]['external_pass'];?>" >
					<button type="button" onClick="add_external_pass('<?echo $data[$e]['user_id'];?>', true)" data-user="<?echo $data[$e]['user_id'];?>" class="form-control btn btn-success right">добавить</button>
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
					<input type="text" name="us-nickname" class="form-control" placeholder="nick" value="<?echo $data[$e]['nickname'];?>" required disabled>
				</div>

				<div class="col-xs-2 deployed">
					<label class="signature">Лимит просмотра</label>
					<input type="text" name="pe-photo_limit" class="form-control" placeholder="pholo_limit" value="<?echo $data[$e]['photo_limit'];?>" required disabled>
				</div>

				<div class="col-xs-2 deployed">
					<label class="signature">Лимит заявок</label>
					<input type="text" name="pe-save_search_limit" class="form-control" placeholder="save_search_limit" value="<?echo $data[$e]['save_search_limit'];?>" required disabled>
				</div>

				<div class="col-xs-2 deployed">
					<label class="signature">WhatsApp Id</label>
					<input type="text" name="pe-mesenger_id" class="form-control" placeholder="save_mesenger_id" value="<?echo $data[$e]['mesenger_id'];?>" required disabled>
				</div>
А
			</div>
			<div class="row fio phone">
				<div class="col-xs-2 deployed">
					<label class="signature">яёТелефон</label>
					<input type="text" name="pe-phone" onFocus="$(this).mask('8 (999) 999-9999')" class="form-control" placeholder="Телефон для сообщений" value="<?echo $data[$e]['phone'];?>" required disabled>
				</div>
				<?$phones_addon = explode('||', $data[$e]['phone_addon']);
				for($p=0; $p<count($phones_addon); $p++){
					if(ereg('8', $phones_addon[$p])){
						echo "<div class='col-xs-2 deployed'>
								<label class='signature'>основной</label>
								<input type='text' onFocus='$(this).mask(\"8 (999) 999-9999\")' name='pe-phone_addon".$p."' class='form-control' placeholder='Телефоны для созвонов' value='".$phones_addon[$p]."' required disabled>
							</div>";
					}
				}
				?>
				<div class="col-xs-3 deployed">
					<div class="input-group interval xl phone" data-id="new">
						<input type="text" data-id="phone" class="form-control" placeholder="доп. телефон" id="phone">
						<button type="button" onClick="add_phone('<?echo $data[$e]['user_id'];?>', true)"
                                    data-user="<?echo $data[$e]['user_id'];?>" class="form-control btn btn-success right">
                            добавить</button>
					</div>
				</div>
			</div>
			
				<?
				$address_rent = Get_functions::Get_address_by_people_id($data[$e]['people_id'], 'rent');	
				for($i=0; $i<count($address_rent); $i++){
					$mobChecked = $address_rent[$i]['mob']==1 ?' checked':' ';
					echo "<div class='row fio' data-id = '{$address_rent[$i]['id']}' id = '{$address_rent[$i]['id']}'>
							<div style = 'display:block'class='col-xs-8 deployed'>
								<div class='col-xs-1 deployed' style = 'margin-top: 20px;margin-left:0px;'>
										<a  href = '#removeIP{$address_rent[$i]['id']}' ";
								?>
									onClick ="remove_ip('<?=$address_rent[$i]['id']?>')"  
								<?php
								echo "
										style = 'min-width: 20px !important;font-color: red; font-weight:bold'>X</a>
								</div>
								<div class='col-xs-1 deployed'>
									<label class='signature'>Моб.</label>
										<input type='checkbox' name='ad-rent_mob-{$address_rent[$i]['id']}' 
										class='form-control' placeholder='mob' value='{$address_rent[$i]['mob']}' required disabled {$mobChecked} >
										
								</div>
								<div class='col-xs-2 deployed'>
									<label class='signature'>IP аренды</label><input type='text' name='ad-rent_ip-{$address_rent[$i]['id']}' 
										class='form-control' placeholder='ip' value='{$address_rent[$i]['ip']}' required disabled>
								</div>
							</div>
							<div class='col-xs-5 deployed' style = 'display:block'>
								<label class='signature'>Браузер</label>
									<input type='text' name='ad-rent_browser-{$address_rent[$i]['id']}' 
									class='form-control' style = 'width:100%' placeholder='browser' 
										value='{$address_rent[$i]['browser']}' required disabled>
							</div>
							";
							?>
					
							<?php
						echo "</div>";
				}?>
				<div class='row fio'>
					<div class='col-xs-2 deployed'>
					<div class="input-group interval xl ip" data-id="new">
						<input type="checkbox" class="form-control" placeholder="mob" id="mob" 
						style = "min-width: 15px; margin-right: 10px">
						<input type="text" class="form-control" placeholder="ip" id="ip">
						<input type="text" class="form-control" style = 'width: 550px'  placeholder="browser" id="browser">
						<button type="button" 
							onClick="add_ip('<?echo $data[$e]['user_id'];?>', 'rent')" 
								data-user="<?echo $data[$e]['user_id'];?>" 
								class="form-control btn btn-success right">добавить</button>
					</div></div>
				</div>
			<!--<div class="row">
				<div class="col-xs-2 deployed">
					<span class="right">IP продажи:</span>
				</div>
				<?
				$address_sell = Get_functions::Get_address_by_people_id($data[$e]['people_id'], 'sell');	
				for($i=0; $i<count($address_sell); $i++){
					echo "<div class='col-xs-2 deployed'><input type='text' name='ad-sell_ip-".$address_sell[$i]['id']."' class='form-control' placeholder='sell_ip' value='". $address_sell[$i]['ip']."' required disabled></div>";
				}?>
			</div>-->
			<div class="row">
			</div>
			<div class="row fio topMNull">
				<div class="col-xs-8 deployed">
					<textarea rows='3' name='pe-comment' class='form-control' placeholder='коментарий к человеку' disabled><?echo $data[$e]['comment'];?></textarea>	
				</div>
			</div>
			<div class="row fio topMNull">
				<div class="col-xs-8 deployed">
					<span style="color: #A70000;">Дата регистрации: <?=(date("d.m.Y", strtotime($data[$e]['date_reg'])));?></span>
				</div>
			</div>
			<div class="col-xs-2 deployed fio">
				<?$fio = $data[$e]["surname"]." ".$data[$e]["name"]." ".$data[$e]["second_name"];?>
				<button type="button" class="form-control btn btn-info" target="_blank" data-toggle="modal" data-target="#clean-modal-win"
                        onClick="EnterStatistics(<?= "'".$data[$e]["login"]."', '".$fio."'"?>)">Статистика входов</button>
			</div>
			<div class="col-xs-2 deployed fio">
				<?$message_str = "'".$data[$e]['people_id']."', '".$_SESSION['people_id']."', '".$fio."'";
				unset($fio);
				?>
				<button type="button" class="form-control btn btn-info" target='_blank' data-toggle='modal' data-target='#messages-modal-win' onClick="Messages(<?echo$message_str;?>)">Отпр. сообщение</button>
			</div>
			<div class="col-xs-1 deployed fio">
				<span class="edit" style="cursor:pointer;" onClick="EditEmployee('<?echo $data[$e]['user_id'];?>')">Редакт.</span>
			</div>
			<div class="col-xs-2 deployed fio">
				<a href="javascript:void(0)" class="form-control btn btn-danger" onClick="delete_user(<?echo $data[$e]['user_id'];?>)">Уволить</a>
			</div>
		</form>
	<?}?>
</div>