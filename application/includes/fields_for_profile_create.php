<?$login = Get_functions::Get_new("re_user", "login", 8000, 1000);?>
<div class="row">
	<?if($_GET['task']!='admin'){
		echo "<div class='col-xs-12 deployed' style='margin-bottom: 15px;'><span style='font-size: 80%;color: red;font-weight: bold; margin-left: 5%;'>Данная операция может повлиять на ваш тариф. Для получения информации свяжитесь c администрацией сайта.</span></div><input name='us-active' type='hidden' value='0'>";
	}else{
		echo "<div class='col-xs-2 deployed'>
				<div class='checkbox' style='margin-bottom: auto; display: inline-block;'>
					<label>
						<input name='us-active' type='checkbox' value='1'>
						Активный
					</label>
				</div>
			</div>";
	}?>
	<div class="col-xs-4 deployed">
		<label class="signature">Фото паспорта</label>
		<input type="file" name="passport" class="form-control" >
	</div>	
	<div class="col-xs-4 deployed">
		<label class="signature">Фото сотрудника</label>
		<input type="file" name="face" class="form-control">
	</div>
</div>
<div class="row">
	<div class="col-xs-2 deployed">
		<label class="signature">Логин</label>
		<input type="text" name="us-login" class="form-control" placeholder="логин" value="<?if(isset($_POST['us-login'])){echo $_POST['us-login'];}else{echo $login;}?>"
               autocomplete="off" required readonly>
		<div class="street_list">﻿<ul id='str_list'></ul></div>
	</div>
	<div class="col-xs-2 deployed">
		<label class="signature">Пароль</label>
		<input type="text" name="us-password" class="form-control" placeholder="пароль" value="<?if(isset($_POST['us-password'])) echo $_POST['us-password'];?>" autocomplete="off">
	</div>	
	<!--<div class="col-xs-2 deployed">
		<label class="signature">Ник для чата</label>
		<input type="text" name="us-nickname" class="form-control" placeholder="nickname" value="<?if(isset($_POST['us-nickname'])) echo $_POST['us-nickname'];?>">
	</div>-->
	<div class="col-xs-2 deployed">
		<label class="signature">Фамилия</label>
		<input type="text" name="pe-surname" class="form-control" placeholder="Фамилия" value="<?if(isset($_POST['pe-surname'])) echo $_POST['pe-surname'];?>" autocomplete="off" required>
		<div class="street_list">﻿<ul id='str_list'></ul></div>
	</div>
	<div class="col-xs-2 deployed">
		<label class="signature">Имя</label>
		<input type="text" name="pe-name" class="form-control" placeholder="Имя" value="<?if(isset($_POST['pe-name'])) echo $_POST['pe-name'];?>" autocomplete="off" required>
		<div class="street_list">﻿<ul id='str_list'></ul></div>
	</div>
	<div class="col-xs-2 deployed">
		<label class="signature">Отчество</label>
		<input type="text" name="pe-second_name" class="form-control" placeholder="Отчество" value="<?if(isset($_POST['pe-second_name'])) echo $_POST['pe-second_name'];?>" autocomplete="off" required>
		<div class="street_list">﻿<ul id='str_list'></ul></div>
	</div>	
	<!--<div class="col-xs-2 deployed">
		<label class="signature">Email</label>
		<input type="text" name="pe-email" class="form-control" placeholder="email" value="<?if(isset($_POST['pe-email'])) echo $_POST['pe-email'];?>">
	</div>-->
	<div class="col-xs-2 deployed">
		<label class="signature">Телефон для сообщений</label>
		<input type="text" id="phone" data-id="phone" name="pe-phone" class="form-control" placeholder="Телефон для сообщений" value="<?if(isset($_POST['pe-phone'])) echo $_POST['pe-phone'];?>" autocomplete="off" required>
		<div class="street_list">﻿<ul id='str_list'></ul></div>
	</div>
	<br/>
	<div class="col-xs-2 deployed">
		<label class="signature">Рабочий e-mail</label>
		<input type="text" id="email_work" data-id="email_work" name="pe-email_work" class="form-control" placeholder="Рабочий e-mail" value="<?if(isset($_POST['pe-email_work'])) echo $_POST['pe-email_work'];?>" autocomplete="off" >
		<div class="street_list">﻿<ul id='str_list'></ul></div>
	</div>
	<div class="col-xs-2 deployed">
		<label class="signature">Пароль e-mail</label>
		<input type="text" id="email_pass" data-id="email_pass" name="pe-email_pass" class="form-control" placeholder="пароль e-mail" value="<?if(isset($_POST['pe-email_pass'])) echo $_POST['pe-email_pass'];?>" autocomplete="off" >
		<div class="street_list">﻿<ul id='str_list'></ul></div>
	</div>
	<br/>
	<br/>
	<!--<div class="col-xs-1 deployed">	
		<label onClick="add_phone_to_div()" data-user="<?echo $_SESSION['user'];?>" id="add_phone" class="form-control btn btn-success right">+</label>
	</div>
	<div class="phones">	
		
	</div>-->
	<!--<div class="col-xs-6 deployed">
		<div class="checkbox" style="margin-bottom: auto; height: 26px; display: inline-block;">
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
		</div>					
	</div>-->
	<?if ($_SESSION["admin"]==1){?>
		<div class="col-xs-8 deployed">
			<label class="signature">Коментарий администратору</label>
			<textarea rows="3" name="pe-comment" class="form-control" placeholder="коментарий администратору"><?if(isset($_POST['pe-comment'])) echo $_POST['pe-comment'];?></textarea>
		</div>
	<?}?>
</div>
<!--<div id="address">
	<?if($_SESSION['group_topic_id'] != "2"){?>
		<div class="col-xs-6 deployed info left" id="1">
			<label>Аренда</label>
			<br />
			<div class="row">
				<div class="col-xs-2 deployed">
					<label class="signature">ip</label>
					<input type="text" name="ad-rent-ip" class="form-control" placeholder="ip аренды" value="<?if(isset($_POST['ad-rent-ip'])) echo $_POST['ad-rent-ip'];?>" required>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-2 deployed">
					<label class="signature">Улица</label>
					<input type="text" name="ad-rent-street" class="form-control" placeholder="улица" value="<?if(isset($_POST['ad-rent-street'])) echo $_POST['ad-rent-street'];?>">
				</div>		
				<div class="col-xs-1 deployed">
					<label class="signature">Дом</label>
					<input type="text" name="ad-rent-house" class="form-control" placeholder="номер" value="<?if(isset($_POST['ad-rent-house'])) echo $_POST['ad-rent-house'];?>">
				</div>
				<div class="col-xs-1 deployed">
					<label class="signature">Офис</label>
					<input type="text" name="ad-rent-office" class="form-control" placeholder="номер" value="<?if(isset($_POST['ad-rent-office'])) echo $_POST['ad-rent-office'];?>">
				</div>
			</div>			
			<textarea type="text" class="form-control" name="ad-rent-comment" placeholder="дополнение"><?if(isset($_POST['ad-rent-comment'])) echo $_POST['ad-rent-comment'];?></textarea>
		</div>
	<?}if($_SESSION['group_topic_id'] != "1" && false){?>
	<div class="col-xs-6 deployed info right" id="2">
		<label>Продажа</label>
		<br />
		<div class="row">
			<div class="col-xs-2 deployed">
				<label class="signature">ip</label>
				<input type="text" name="ad-sell-ip" class="form-control" placeholder="ip продажи" value="<?if(isset($_POST['ad-sell-ip'])) echo $_POST['ad-sell-ip'];?>">
			</div>
		</div>
		<div class="row">
			<div class="col-xs-2 deployed">
				<label class="signature">Улица</label>
				<input type="text" name="ad-sell-street" class="form-control" placeholder="улица" value="<?if(isset($_POST['ad-sell-street'])) echo $_POST['ad-sell-street'];?>">
			</div>		
			<div class="col-xs-1 deployed">
				<label class="signature">Дом</label>
				<input type="text" name="ad-sell-house" class="form-control" placeholder="номер"value="<?if(isset($_POST['ad-sell-house'])) echo $_POST['ad-sell-house'];?>">
			</div>
			<div class="col-xs-1 deployed">
				<label class="signature">Офис</label>
				<input type="text" name="ad-sell-office" class="form-control" placeholder="номер"value="<?if(isset($_POST['ad-sell-office'])) echo $_POST['ad-sell-office'];?>">
			</div>
		</div>			
		<textarea type="text" class="form-control" name="ad-sell-comment" placeholder="дополнение"><?if(isset($_POST['ad-sell-comment'])) echo $_POST['ad-sell-comment'];?></textarea>
	</div>
	<?}?>
</div>-->
<input type="hidden" name="action" value="new" />
<div class="row">
	<div class="col-xs-2 deployed">	
		<input type="submit" class="form-control btn btn-success" name="submit" value="Создать" onclick="return checkPass();"/>
	</div>
	<div class="col-xs-2 deployed">	
		<a href="javaScript:void(0)" class="form-control btn btn-default" onclick="history.go(-1)">Назад</a>
	</div>
</div>