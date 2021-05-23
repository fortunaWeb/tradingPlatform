<script>
	$(function(){
		$(document).on("ready", function(){
			$("button[data-value=1]").click();
		});		
		var lastClickButton = "";
		$("div.actionList button").on("click", function(){
			var rentOrSell = $(this).parent().attr("id");
			if (lastClickButton != $(this).html() + rentOrSell){				
				lastClickButton = $(this).html() + rentOrSell;				
				$(this).parent().find("button.active").removeClass("active");
				$(this).addClass("active");		
				$("div#"+rentOrSell+" button").each(function(){
					if(!$(this).hasClass("active")){
						$(this).addClass("disabled");
					}
				});
				var active = $(this).data("value");
				var obj = $("#mes_" + rentOrSell);
				$(obj).slideUp("fast");
				$(obj).children().remove();
				jQuery.ajax({
					type: 'POST',
					url: location,
					data: rentOrSell + '_active=' + active,
					success: function(html) {						
						setTimeout(function(){
							$(obj).append($(html).find("#mes_" + rentOrSell).html());
							$(obj).slideDown("fast");
						}, 500);	
					},complete: function(){
						setTimeout(function(){
							$("div button.disabled").each(function(){
								$(this).removeClass("disabled");
							});
						}, 500);
					}
				});
			}
		});
	});
</script>

<div class="row personal-account">
	<h3 class="center">Личный кабинет</h2>

	<?php
	//	print_r($_SESSION);
	//	print_r($data);
	//	die();
	
	mysql_set_charset( 'utf8' );
		$query = "SELECT `id`, `name` FROM `re_type_object` where (`parent_id` = '0')";		
					$q_res = mysql_query($query);
		$query2 = "SELECT * FROM `re_type_object` where (`parent_id` = '0')";		
					$q_res2 = mysql_query($query2);
		$query3 = "SELECT * FROM re_favorites WHERE user_id = '". $_SESSION['user'] ."'";
					$q_res3 = mysql_query($query3);
	?>
	
	<div class="col-xs-12">	
	
		<?php if($_SESSION['group_topic_id'] != 2) { ?>
			<div class="col-xs-5">	
				<button type="button" class="btn btn-success wide" title="нажмите для просмотра дополнительных возможностей">
					Аренда
				</button>
				<div class="col-xs-12 center actionList" id="rent">
					<button type="button" class="btn btn-default kindOfAction" data-value="1" id="action">Активные</button>
					<button type="button" class="btn btn-default kindOfAction" data-value="-1" id="create">Создать</button>
					<button type="button" class="btn btn-default kindOfAction" data-value="0" id="arhive">Архив</button>									
					<div class="col-xs-12" id="mes_rent" style="display:none">
						<?php
							if($_POST)
							{
								$res_num = mysql_num_rows($q_res);
								for ($j=0; $j<$res_num; ++$j) {
									$res = mysql_fetch_array($q_res);
									$q_type = "SELECT `id` FROM `re_var` where (((`user_id` = '". $_SESSION['user'] ."') AND (`active` = '".($_POST['rent_active'] ? $_POST['rent_active'] : '0')."')) AND (`parent_id` = '". $res['id'] ."') AND (`topic_id` = '1'))";
									$q_a = mysql_query($q_type);
									$q_num = mysql_num_rows($q_a);
									if($res['id']!= "2"){
										if($_POST['rent_active'] == "-1")
										{
											echo '									
												<a class="left" href="?task=profile&action=newvar&topic_id=1&parent_id='. $res['id'] .'">'. $res['name'] .' </a> <br />
											';
										}
										else if($_POST['rent_active'] == "0")
										{
											echo '									
												<a class="left" href="?task=profile&action=archive_list&topic_id=1&active=0&parent_id=' .$res['id'].'">'. $res['name'] . ' ('. $q_num .')'.' </a> <br />
											';
										}
										else if($_POST['rent_active'] == "1"){
											echo '									
												<a class="left" href="?task=profile&action=mytype&topic_id=1&active=1&parent_id='. $res['id'] .'">'. $res['name'] . ' ('. $q_num .')' .' </a> <br />
											';
										}
									}
								}
							}
						?>
					</div>
				</div>
			</div>
		<?php } ?>


		<?php if($_SESSION['group_topic_id'] != 1) { ?>

			<div class="col-xs-5 right">	
				<button type="button" class="btn btn-success wide" title="нажмите для просмотра дополнительных возможностей">
					Продажа					
				</button>
				<div class="col-xs-12 center actionList" id="sell">
					<button type="button" class="btn btn-default kindOfAction" data-value="1" id="action">Активные</button>
					<button type="button" class="btn btn-default kindOfAction" data-value="-1" id="create">Создать</button>
					<button type="button" class="btn btn-default kindOfAction" data-value="0" id="arhive">Архив</button>
					
					<div class="col-xs-12" id="mes_sell" style="display:none">
						<?php
							if($_POST)
							{
								$res_num2 = mysql_num_rows($q_res2);
								for ($i=0; $i<$res_num2; ++$i) {
									$res2 = mysql_fetch_array($q_res2);
									$q_type2 = "SELECT `id` FROM `re_var` where (((`user_id` = '". $_SESSION['user'] ."') AND (`active` = '".($_POST['sell_active'] ? $_POST['sell_active'] : '0')."')) AND (`parent_id` = '". $res2['id'] ."') AND (`topic_id` = '2'))";
									$q_a2 = mysql_query($q_type2);
									$q_num2 = mysql_num_rows($q_a2);
									if($_POST['sell_active'] == "-1")
									{
										echo '
											<a class="left" href="?task=profile&action=newvar&topic_id=2&parent_id='. $res2['id'] .'">'. $res2['name'] .'</a><br />
										';
									}
									else if($_POST['sell_active'] == "0")
									{
										echo '
											<a class="left" href="?task=profile&action=archive_list&topic_id=2&active=0&parent_id='. $res2['id'] .'">'. $res2['name'] . ' ('. $q_num2 .')'. '</a><br />
										';
									}
									else if($_POST['sell_active'] == "1"){
										echo '
											<a class="left" href="?task=profile&action=mytype&topic_id=2&active=1&parent_id='. $res2['id'] .'">'. $res2['name'] . ' ('. $q_num2 .')' .' </a><br />
										';
									}
								}
							}
						?>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>

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

		<?php } if($_SESSION['admin'] == 1) { ?>		
			<div class="col-xs-5 right">	
				<div class="info">
					<h4><a href="?task=profile&action=user_list">Список пользователей сайта</a></h4>
					<p>
					В данном разделе Вы сможете создать логины, удалить, заблокировать, продлить, активировать.
					</p>
				</div>
			</div>		
		<?php } ?>
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
		
		<div class="col-xs-5 right">
			<div class="info">
				<h4><a href="?task=profile&action=favorites">Избранное</a></h4>
				<p>Данный раздел содержит варианты добавленные вами в избранное</p>
				 <ul>
				 <?php		
					// $res_num3 = mysql_num_rows($q_res3);
					// for ($i=0; $i<$res_num3; ++$i) {
							// $res3 = mysql_fetch_array($q_res3);
							// $q_type3 = "SELECT * FROM re_var WHERE id = '". $res3['id'] ."'";
							// $q_favorites = mysql_query($q_type3);
							// echo "<li>Описание: ". $q_favorites['text'] ." <br> Цена: ". $q_favorites["price"] ."</li>";
					// }
				// ?>	
				 </ul>
			</div> 
		</div>
	</div>

</div>
