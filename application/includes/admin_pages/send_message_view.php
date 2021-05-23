<div class="col-xs-9">
	<legend>Форма отправки сообщения</legend>	
	<?if ($_POST) echo $data;?>
	<form method="POST" id="send_message">				
		<div class="col-xs-2 deployed">			
			<label class="signature">Кому отправить</label>
			<select class="form-control" name="user_id" required>
				<option value="">выберите</option>
				<option value="directors">Всем директорам</option>
				<option value="all">Всем активным пользователям</option>
				<?Helper::Login_options();?>
			</select>				
		</div>
		<div class="col-xs-12 deployed">	
			<textarea name="text" class="form-control" placeholder="содержание сообщения" rows="5" cols="80"  required="required"></textarea>
		</div>
		<div class="col-xs-2 deployed">	
			<input type="submit" class="form-control btn btn-success">
		</div>	
	</form`>
</div>