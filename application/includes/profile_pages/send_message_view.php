<div class="col-xs-9">
	<legend><?=!$_SESSION['mobile']?'Форма отправки сообщения администратору':'Написать Админу'?></legend>	
	<?=$_POST?$data:''?>
	<form method="POST" id="send_message">				
		<div class="col-xs-12 deployed">	
			<textarea name="text" class="form-control" placeholder="содержание сообщения" rows="5" cols="80"  required="required"></textarea>
		</div>
		<div class="col-xs-2 deployed">	
			<input type="submit" class="form-control btn btn-success" value="Отправить">
		</div>	
	</form`>
</div>