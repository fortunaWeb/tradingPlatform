<?php //edit_child_profile_view.php

// //print_r($data);


// $query = "INSERT INTO `re_user` (`login`, `active`, `reg_date`, `password`, `fio`, `email`, `group_id`, `phone`, `parent`, `company_name`, `group_topic_id`) VALUES ('". $_POST['login'] ."', '1', '". $cur_date ."', '". $_POST['password'] ."', '". $_POST['fio'] ."', '". $_POST['email'] ."', '3', '". $_POST['phone'] ."', '0', '". $_POST['company_name'] ."', '". $_POST['group_topic_id'] ."')";

// 
$login = Get_functions::Get_new("re_user", "login", 9000, 1000);
?>
<script type="text/javaScript">
	$(function(){
		$(":required").each(function(){
			if($(this).val()==""){
				$(this).css("border-color", "red");
			}else{
				$(this).css("border-color", "#5cb85c");
			}
		});
		
		$(":required").on("keyup", function(){
			if($(this).val()!=""){
				$(this).css("border-color", "#5cb85c");
				var objName = $(this).attr("name"),
					query="",
					fio = objName == "surname" || objName == "name" || objName == "second_name",
					name = $("[name=name]").val(),
					surname = $("[name=surname]").val(),
					secondName = $("[name=second_name]").val(),
					val = $(this).val();
					query = objName.split('-')[1]+"="+val;
				/*if(objName == "company_name" || objName == "login" || objName == "nickname" || objName == "phone"){
					query = objName+"="+val;
				}
				 else if(fio && name!="" && surname!="" && secondName!=""){
					// query = "fio=1&surname="+surname+"&name="+name+"&second_name"+secondName;
				// }*/
				if(query!=""){
					$.post("?task=admin&action=check_input", query, function(html){
						var ul = $("[name="+objName+"]").next().find("ul");
						if(html!=""){
							$(ul).empty();
							$(ul).append(html);
							$("[name="+objName+"]").next().slideDown();
							$("[name="+objName+"]").css("border-color", "red");
						}else{
							$(ul).empty();
							$("[name="+objName+"]").next().slideUp();
						}
					})
				}
			}else{
				$(this).css("border-color", "red");
			}
		});
		
		$(document).on("keyup", "[name=rent-ip], [name=sell-ip]", function(){
			if($(this).val()!=""){
				$("#group_topic_id").css("border-color", "#5cb85c");				
			}else{
				$("#group_topic_id").css("border-color", "red");
			}
		})
		
		$(document).on("change", "[name=pe-surname], [name=pe-name], [name=pe-second_name]", function(){
			var name = $("[name=pe-name]").val(),
				surname = $("[name=pe-surname]").val(),
				secondName=$("[name=pe-second_name]").val(),
				data = "";
			if(name!="")data +="name="+name;
			if(surname!="")data +="&surname="+surname;
			if(secondName!="")data +="&secondName="+secondName;
			if($(this).val() != ""){
				$.post("?task=admin&action=find_dismiss_people", data, function(html){
					$("#for-table").empty().append($(html));
				})
			}
		});
		
		$(document).on('click', "[data-id=choosePeople]", function(){
			var tr = $("tr").has($(this));
			$("[name=pe-surname]").val($(tr).find('[data-id=surname]').text());
			$("[name=pe-name]").val($(tr).find('[data-id=name]').text());
			$("[name=pe-second_name]").val($(tr).find('[data-id=second_name]').text());
			$("[name=pe-phone]").val($(tr).find('[data-id=phone]').text());
			$("[name=ip]").val($(tr).find('[data-id=ips]').text().split(',')[0]);
			$("[name=old-people-id]").val($(tr).attr("id"));
			$("[name=passport]").parent().remove();
			$("[name=face]").parent().remove();
		});
	})
</script>
<div class="col-xs-10 deployed">
	<form id="child_profile" action="?task=profile&action=create_login" method="POST" enctype="multipart/form-data">
		<legend>Форма создания АН</legend>
		<div class="row">
			<div class="col-xs-4 deployed">
				<label class="signature">Фото паспорта директора</label>
				<input type="file" name="passport" class="form-control">
			</div>	
			<div class="col-xs-4 deployed">
				<label class="signature">Фото директора</label>
				<input type="file" name="face" class="form-control">
			</div>
		</div>
		<div class="row">				
			<div class="col-xs-2 deployed">
				<label class="signature">Название АН</label>
				<input type="text" id="company_name" class="form-control" name="co-company_name" value="<?if(isset($_POST['company_name'])) echo $_POST['company_name'];?>" placeholder="АН" autocomplete="off" required>
				<div class="street_list">﻿<ul id='str_list'></ul></div>
			</div>
			<div class="col-xs-2 deployed">
				<label class="signature">Логин</label>
				<input type="text" name="us-login" class="form-control" placeholder="логин" value="<?if(isset($_POST['login'])){echo $_POST['login'];}else{echo $login;}?>" autocomplete="off" required>
				<div class="street_list">﻿<ul id='str_list'></ul></div>
			</div>
			<div class="col-xs-2 deployed">
				<label class="signature">Пароль</label>
				<input type="text" name="us-password" class="form-control" placeholder="пароль" value="<?if(isset($_POST['password'])) echo $_POST['password'];?>" autocomplete="off" required>
			</div>	
			<div class="col-xs-2 deployed">
				<label class="signature">Ник для чата</label>
				<input type="text" name="us-nickname" class="form-control" placeholder="nickname" value="<?if(isset($_POST['nickname'])) echo $_POST['nickname'];?>" autocomplete="off">
			</div>	
		</div>	
		<div class="row">
			<div class="col-xs-2 deployed">
				<label class="signature">Фамилия</label>
				<input type="text" name="pe-surname" class="form-control" placeholder="Фамилия" value="<?if(isset($_POST['surname'])) echo $_POST['surname'];?>" autocomplete="off" required>
				<div class="street_list">﻿<ul id='str_list'></ul></div>
			</div>
			<div class="col-xs-2 deployed">
				<label class="signature">Имя</label>
				<input type="text" name="pe-name" class="form-control" placeholder="Имя" value="<?if(isset($_POST['name'])) echo $_POST['name'];?>" autocomplete="off" required>
				<div class="street_list">﻿<ul id='str_list'></ul></div>
			</div>
			<div class="col-xs-2 deployed">
				<label class="signature">Отчество</label>
				<input type="text" name="pe-second_name" class="form-control" placeholder="Отчество" value="<?if(isset($_POST['second_name'])) echo $_POST['second_name'];?>" autocomplete="off" required>
				<div class="street_list">﻿<ul id='str_list'></ul></div>
			</div>	
			<div class="col-xs-2 deployed">
				<label class="signature">Email</label>
				<input type="text" name="pe-email" class="form-control" placeholder="email" value="<?if(isset($_POST['email'])) echo $_POST['email'];?>">
			</div>
			<div class="col-xs-2 deployed">
				<label class="signature">Телефон для сообщений</label>
				<input type="text" id="phone" name="pe-phone" class="form-control" placeholder="Телефон для сообщений" value="<?if(isset($_POST['phone'])) echo $_POST['phone'];?>" autocomplete="off" required>
				<div class="street_list">﻿<ul id='str_list'></ul></div>
			</div>			
			<div class="row col-xs-12">
				<div class="col-xs-2 deployed">		
					<label class="signature">Доступ для агентства</label>
					<select class="form-control" class="controls-select" name="us-group_topic_id" id="group_topic_id" required>
								<option value="" >выберите</option>
								<option value="1" <?php if($_POST['group_topic_id'] == "1") echo "selected"; ?> >Аренда</option>
								<option value="2" <?php if($_POST['group_topic_id'] == "2") echo "selected"; ?> >Продажа</option>
								<option value="3" <?php if($_POST['group_topic_id'] == "3" || !isset($_POST['group_topic_id'])) echo "selected"; ?> >А+П</option>
					</select>	
				</div>	
				<div class="col-xs-2 deployed">
					<label class="signature">Остаток на счете</label>
					<input type="number" class="form-control" name="co-balance" title="остаток" value="<?if(isset($_POST['balance'])) echo $_POST['balance'];?>" placeholder="остаток">
				</div>
				<div class="col-xs-2 deployed">
					<label class="signature">Долг агентства</label>
					<input type="number" class="form-control" name="co-duty" title="долг" value="<?if(isset($_POST['duty'])) echo $_POST['duty'];?>" placeholder="долг">
				</div>
				<div class="col-xs-2 deployed">
					<label class="signature">Аб. аренды</label>
					<input type="number" class="form-control" name="co-subscription" title="абонентка" value="<?if(isset($_POST['subscription'])) echo $_POST['subscription'];?>" placeholder="абонентка">
				</div>
				<div class="col-xs-2 deployed">
					<label class="signature">Аб. продажи</label>
					<input type="number" class="form-control" name="co-subscription_sell" title="абонентка" value="<?if(isset($_POST['subscription_sell'])) echo $_POST['subscription_sell'];?>" placeholder="абонентка">
				</div>
			</div>	
		</div>
		<div id="address">
			<div class="col-xs-6 deployed info left" id="1">
				<label>Аренда</label>
				<br />
				<div class="row">
					<div class="col-xs-2 deployed">
						<label class="signature">ip</label>
						<input type="text" name="ip" class="form-control" placeholder="ip аренды" value="<?if(isset($_POST['ip'])) echo $_POST['ip'];?>">
					</div>
					<div class="col-xs-2 deployed">
						<label class="signature">Премиумы аренды</label>
						<input type="number" name="co-rent_premium" class="form-control" placeholder="премиумы" value="<?if(isset($_POST['rent_premium'])) echo $_POST['rent_premium'];?>">
					</div>
				</div>
				<?/*<div class="row">
					<div class="col-xs-2 deployed">
						<label class="signature">Улица</label>
						<input type="text" name="rent-street" class="form-control" placeholder="улица" value="<?if(isset($_POST['rent-street'])) echo $_POST['rent-street'];?>">
					</div>		
					<div class="col-xs-1 deployed">
						<label class="signature">Дом</label>
						<input type="text" name="rent-house" class="form-control" placeholder="номер" value="<?if(isset($_POST['rent-house'])) echo $_POST['rent-house'];?>">
					</div>
					<div class="col-xs-1 deployed">
						<label class="signature">Офис</label>
						<input type="text" name="rent-office" class="form-control" placeholder="номер" value="<?if(isset($_POST['rent-office'])) echo $_POST['rent-office'];?>">
					</div>
				</div>*/?>
				<textarea type="text" class="form-control" name="comment" placeholder="дополнение"><?if(isset($_POST['comment'])) echo $_POST['comment'];?></textarea>	
				<!--<button type="button" onclick="ip_add(1)" class="btn btn-success narrow right">Добавить IP</button>-->
			</div>
			<?/*<div class="col-xs-6 deployed info right" id="2">
				<label>Продажа</label>
				<br />
				<div class="row">
					<div class="col-xs-2 deployed">
						<label class="signature">ip</label>
						<input type="text" name="sell-ip" class="form-control" placeholder="ip продажи" value="<?if(isset($_POST['sell-ip'])) echo $_POST['sell-ip'];?>">
					</div>
					<div class="col-xs-2 deployed">
						<label class="signature">Премиумы продажи</label>
						<input type="number" name="sell_premium" class="form-control" placeholder="премиумы" value="<?if(isset($_POST['sell_premium'])) echo $_POST['sell_premium'];?>">
					</div>
				</div>
				<div class="row">
					<div class="col-xs-2 deployed">
						<label class="signature">Улица</label>
						<input type="text" name="sell-street" class="form-control" placeholder="улица" value="<?if(isset($_POST['sell-street'])) echo $_POST['sell-street'];?>">
					</div>		
					<div class="col-xs-1 deployed">
						<label class="signature">Дом</label>
						<input type="text" name="sell-house" class="form-control" placeholder="номер"value="<?if(isset($_POST['sell-house'])) echo $_POST['sell-house'];?>">
					</div>
					<div class="col-xs-1 deployed">
						<label class="signature">Офис</label>
						<input type="text" name="sell-office" class="form-control" placeholder="номер"value="<?if(isset($_POST['sell-office'])) echo $_POST['sell-office'];?>">
					</div>
				</div>			
				<textarea type="text" class="form-control" name="sell-comment" placeholder="дополнение"><?if(isset($_POST['sell-comment'])) echo $_POST['sell-comment'];?></textarea>
				<!--<button type="button" onclick="ip_add(2)" class="btn btn-success narrow right">Добавить IP</button>-->				
			</div>*/?>
		</div>
		<div class="row">
			<div class="col-xs-2 deployed">	
				<input type="submit" class="form-control btn btn-success" name="submit" value="Создать" onclick="return checkPass();"/>
			</div>
			<div class="col-xs-2 deployed">	
				<a href="javaScript:void(0)" class="form-control btn btn-default" onclick="history.go(-1)">Назад</a>
			</div>
		</div>
	<input type="hidden" name="create" value="1" />	
	<input type="hidden" data-id="1" name="rent_ip_count" value="0" />	
	<input type="hidden" data-id="2" name="sell_ip_count" value="0" />	
	<input type="hidden" name="us-active" value="1" />
	<input type="hidden" name="us-parent" value="0" />
	<input type="hidden" name="old-people-id" value="" />
	</form>
	<div id="for-table">
	</div>
</div>
