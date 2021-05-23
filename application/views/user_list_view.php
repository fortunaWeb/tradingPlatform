<script type="text/javaScript">
	//для сохранения
	var confirmStr = "Обновить информацию?",
		postUrl = '?task=profile&action=change_user',
		postUrlForReload = "",
		formSubmit = "";
	$(document).on("click", "[name=rent_on], [name=sell_on]", function(){
		var form = $("form.employee").has($(this)),
			check = $(this),
			checkboxArr = {"rent_on":"sell_on", "sell_on":"rent_on"},
			otherAccess = $(form).find("[name="+checkboxArr[$(check).attr("name")]+"]"),
			accessConfirm = "",
			accessPost = "user_id="+$(form).data("id"),
			accessUrl = "?task=admin&action=change_group_id";
		if($(check).is(":checked")){
			accessConfirm = "Открыть "+$(check).parent().text().toLowerCase()+"?";
			if($(otherAccess).is(":checked")){
				accessPost += "&group=3";
			}else{
				accessPost += "&group="+$(check).val();
			}			
		}else{
			accessConfirm = "Закрыть "+$(check).parent().text().toLowerCase()+"?";
			if($(otherAccess).is(":checked")){
				accessPost += "&group="+$(otherAccess).val();
			}else{
				accessPost += "&group=0";
			}	
		}
		alertify.confirm(accessConfirm, function(r){
			if(r){
				$.post(accessUrl, accessPost, function(){
					alertify.success("Доступ изменен.");
				})
			}else{
				if($(check).is(":checked")){
					$(check).removeAttr("checked");
				}else{
					$(check).prop("checked","checked");
				}
			}
		});
	});
	$(function(){
		<?if(isset($_POST)){?>
			postUrlForReload = window.location.search;
			$("form").each(function(){
				if($(this).attr("action") == postUrlForReload){
					formSubmit = $(this).find("input").last();
				}
			})
		<?}?>
		$("[data-name=check_all]").on("change", function(){
			if($(this).is(":checked")){
				$(".an>td>:checkbox").prop("checked", true);
			}else{
				$(".an>td>:checkbox").prop("checked", false);
			}
		});
		
		$("#an_update a").on("click", function(){
			var ans = $(".an").has("td>:checkbox:checked");
			if($(ans).length > 0){
				var text = $(this).text(),
					url = $(this).data("href"),
					message = "Вы уверены, что хотите совершить '"+text+"'?",
					ids = "";
					$(ans).each(function(){
						ids += $(this).data("mid")+",";
					})
					alertify.confirm(message, function(result){
						if(result){
							Loading_an_update();
							$.ajax({
								url:url,
								type:"POST",
								data:"ids="+ids,
								success: function(html){
									console.log(html);
								},
								complete: function(){
									$(".progress").remove();
									alertify.success("Обновление завершено.");
									if(formSubmit!=""){
										$(formSubmit).click();
									}else{
										window.location.reload();
									}
								}
							})
						}
					})
			}else{
				alertify.alert("Выберите хотя бы 1 АН.");
			}
		});
	});
	
	function Loading_an_update(){
		try{
			$(".progress").remove();
		}catch(err){}	
		$($(".col-xs-9")[0]).append("<div class='progress' style='width: 100%;height: 100%;position: absolute;z-index: 10;top: -15px; margin-left: -10px;background-color: rgba(0, 0, 0, 0.5);text-align: center;'><p style='margin-top: 250px;font-size: 20px;color: #fff;'>Загрузка</p></div>");
		loading(1);
	}
</script>
<div class="col-xs-9">
	<?if($_SESSION["admin"] == 1){?>
		<div class="col-xs-12" style="margin-bottom: 10px;">
			<div class="col-xs-3 col-xs-offset-1">
				<a class="form-control btn btn-success" href='?task=profile&action=create_login'>Добавить АН</a>
			</div>	
			<?/*?>
			<span class="dropdown" style="display: block;margin-top: 0px;  position: absolute;left: 40%;">
				<a href="javascript:void(0)" id="dropdownMenu3" data-toggle="dropdown" style="margin: -11px -10px -11px 10px;padding: 13px;" class="right">Действия с АН<span class="caret"></span></a>
				<ul class="dropdown-menu" id="an_update" aria-labelledby="dropdownMenu3">
					<li class="dropdown-header center">Действия с АН</li>
					<li><a href="javascript:void(0)" data-href="/an_update.php?employee=1">Перенести отсутствующих риэлторов</a></li>
					<li><a href="javascript:void(0)" data-href="/an_update.php?archive=0&photo=1">Перенос активных вариантов с фото</a></li>	
					<li><a href="javascript:void(0)" data-href="/an_update.php?archive=0&photo=0">Перенос активных вариантов без фото</a></li>
					<li><a href="javascript:void(0)" data-href="/an_update.php?archive=1&photo=1">Перенос архивных вариантов с фото</a></li>
					<li><a href="javascript:void(0)" data-href="/an_update.php?archive=1&photo=0">Перенос архивных вариантов без фото</a></li>
				</ul>
			</span>
			<?*/?>
			<div class="col-xs-3">
				<a class="form-control btn btn-success" href="?task=admin&action=user_list&active=0">Не активные АН</a>
			</div>
			<div class="col-xs-3">
				<a class="form-control btn btn-success" href="/?task=admin&action=user_list&online=1">Онлайн</a>
			</div>
		</div>
		<div class="col-xs-12">
			<form id="find_fio" action="?task=admin&action=find_fio" method="POST" target="_blank">
				<div class="col-xs-3">
					<input class="form-control" type="text" form="find_fio" name="surname" placeholder="фамилия" value="<?=$_POST["surname"]?>">
				</div>
				<div class="col-xs-3">
					<input class="form-control" type="text" form="find_fio" name="name" placeholder="имя" value="<?=$_POST["name"]?>">
				</div>
				<div class="col-xs-3">
					<input class="form-control" type="text" form="find_fio" name="second_name" placeholder="отчество" value="<?=$_POST["second_name"]?>">
				</div>
				<div class="col-xs-5" style = "margin : 5px;">
					<input class="form-control" type="text" form="find_fio" name="discription" placeholder="Описание" value="<?=$_POST["discription"]?>">
				</div>
				<div class="col-xs-3" style = "margin : 5px;">
					<input class="form-control" type="text" form="find_fio" name="ip" placeholder="IP" value="<?=$_POST["ip"]?>">
				</div>
				<div class="col-xs-1" style = "margin : 5px;">
					<input class="form-control" type="checkbox" form="find_fio" name="mobile" placeholder="mobile" value="1" <?=$_POST["mobile"]==1?' checked':''?> >
				</div>
				<div class="col-xs-3" style = "margin : 5px;">
					<input type="submit" form="find_fio" value="Поиск">
				</div>

			</form>
		</div>
	<?}?>
	<table class="table table-striped list" style = 'width:100%;'>
		<thead><tr>
			<th>#</th>
			<th><input type="checkbox" data-name="check_all"></th>
			<th>АН</th>
			<th>Дата истечения <br/>bаренды</th>
			<th>Дата истечения <br/>частников 2</th>
			<th>WhatsApp</th>
		</tr></thead>
		<tbody>
			<?for($j=0; $j<count($data); ++$j){?>
			<tr class="an" id="<?=$data[$j]['id'];?>" data-mid="<?=$data[$j]['fortuna_mid'];?>" onClick="ShowEmployees('<?=$data[$j]['id'];?>')">
				<td><?= $j+1; ?></td>
				<td><input type="checkbox"></td>
				<td><?= $data[$j]['company_name'];?></td>
				<td><?= $data[$j]['sell_date_end'];?></td>
				
				<td><?= $data[$j]['pay_parse_date_end'];?></td>
				<td><?php
						 print_r(Helper::showMessagerId($data[$j]['id']));
					?></td>
				<!--<td><span style="cursor:pointer;color: #F0AD0A;" onclick="user_to_archive('<?=$data[$j]['id']; ?>')">В архив</span></td>	
				<td><span style="cursor:pointer;color: #c9302c;" onclick="delete_user('<?=$data[$j]['id']; ?>')">Удалить</span></td>-->
			</tr>
			<?}?>
		</tbody>
	</table>
</div>