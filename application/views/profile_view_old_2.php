<script>
	$(function(){
	});
</script>

<div class="row personal-account">
	<h3 class="center">Личный кабинет</h2>
	<div class="col-xs-12">	
		<?if($_SESSION['parent'] == "0"){?>
		<div class="col-xs-5">	
			<div class="info">
				<h4><a href="?task=profile&action=change_profile">Добавление и редактирование сотрудников АН</a></h4>
				<p>
				В данном разделе Вы сможете создать дополнительные логины (аккаунты) для ваших сотрудников, а также просмотреть и изменить информацию своего агентства.				
				</p>
			</div>
		</div>

		<?php }/* if($_SESSION['admin'] == 1) { ?>		
			<div class="col-xs-5 right">	
				<div class="info">
					<h4><a href="?task=profile&action=user_list">Список пользователей сайта</a></h4>
					<p>
					В данном разделе Вы сможете создать логины, удалить, заблокировать, продлить, активировать.
					</p>
				</div>
			</div>		
		<?php } */?>
	</div>
	<div class="col-xs-12">	
		<div class="col-xs-5">	
			<div class="info">
				<h4>Личные данные</h4>							
				<div class="info">					
					ФИО: <span><?php echo $_SESSION['fio']; ?> </span> <br />
					Телефон: <span><?php echo $_SESSION['phone']; ?> </span> <br />
					Название агентства: <span><?php echo $_SESSION['company_name']; ?> </span> <br />
					Email: <span><?php echo $_SESSION['email']; ?> </span>
					<!--
					<li><a href="?task=profile&action=change_profile">Редактировать профиль</a></li>
					-->
				</div>
			</div>
		</div>
	</div>

</div>
