<script type="text/javascript">
	function OpenRecipient(ids, recId, classStr){
		var obj = $(".products-list."+classStr+"[data-id="+recId+"]"),
			product = $(obj).find(".product");
		if($(product).length == 0 && ids!=""){
			$(obj).find("button").attr("disabled","disabled");
			var url ="?task=profile&action=mytype&parent_id=1&topic_id=1&active=1&res=1";
			//ids = ids.replace(/\,/g, " or ");
			$.post(url, "recipients_ids="+ids, function(html){
				$(obj).append($(html).find(".product"));
				$(obj).find('button span>span').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
				$(obj).find("button").removeAttr("disabled");
			});
		}else if($(product).is(":visible")){
			$(product).slideUp();
			$(obj).find('button span>span').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
		}else{
			$(product).slideDown();
			$(obj).find('button span>span').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
		}
	}
</script>
<?php 
	if(isset($_POST['live_point']) && count(Helper::Save_search()) < $_SESSION['save_search_limit']){
		$search_str = "";
		foreach($_POST as $k=>$v){
			if($k!="task" && $k!="company_id" && $k!="action" && $k!="order" && $k!="hours" && $k!="search_user_id" && $k!="view_type"){
				$search_str .= "{$k}={$v}|*|";
			}
		}
		$search_str = substr($search_str, 0, -3);?>
	
		<script type="text/javascript">
			$(function(){
				if($(".products-list.searches").length > 4){
					//$("form#save_search").parent().remove();
				}
				$("#save_search").submit(function(e){
					e.preventDefault();
					var data = decodeURIComponent($("#save_search").serialize());
					$.post("?task=var&action=save_search", data, function(){
						window.location = location;
					})
				})
			})
		</script>
		<div style="width: 100%;height: 100%;position: fixed;top: 0;left: 0;z-index: 99;background-color: rgba(0, 0, 0,0.5);">
			<form method="POST" id="save_search" class="col-xs-5" style="margin: 15px;border: 1px solid #ccc;background-color: #fff;position: absolute;top: 20%;left: 25%;">
				<h4>ШАГ 2: Для сохранения авто подбора по заданным критериям необходимо ввести название заявки и остальные параметры по желанию, которые будут отображатся вам для удобства!</h4>
				<div class="row">	
					<div class="col-xs-12" style="padding: 10px 20px;">
						<input type="text" class="form-control" name="search_name" placeholder="название заявки" required="">
					</div>
					<div class="col-xs-12" style="padding: 10px 20px;">
						<input type="text" class="form-control" name="client_name" placeholder="имя клиента">
					</div>
					<div class="col-xs-12" style="padding: 10px 20px;">
						<input type="text" class="form-control" name="client_phone" data-id="phone" placeholder="телефон клиента">
					</div>
					<div class="col-xs-12" style="padding: 10px 20px;">
						<input type="email" class="form-control" name="client_email" placeholder="e-mail клиента">
					</div>
					<div class="col-xs-12" style="padding: 10px 20px;">
						<input type="submit" class="btn btn-success" value="Создать">
					</div>
					<input type="hidden" name="search_str" value="<?=$search_str?>">
					<input type="hidden" name="action" value="<?=$_POST['action']?>">
				</div>
			</form>
		</div>
	<?}
	 include "application/includes/save_searches.php";
?>
<div class='row'></div>
<div class="col-xs-4 deployed">
	<a href="javascript:void(0)" class="form-control btn btn-danger" onclick="DeleteRecipients()">Удалить подборки старше 30 дней</a>
</div>
<div class="col-xs-12">
	<div class='row'></div>
	<h4>Список подборок отправленных на почту</h4>
	<div class='row'></div>
	<?
	$count = count($data);
	for($i=0; $i<$count; $i++){ ?>
		<div class='row products-list recipient' data-id='<?=$data[$i]["id"];?>'>
			<span style='float:left'><?=$data[$i]["address"];?></span>
			<span style="float:right"><?=$data[$i]["date"];?></span>
			<?if($_SESSION["admin"] == 1 && isset($data[$i]["company_name"])){?>
				<span style="float:right; margin-right:10px;"> <?=$data[$i]["fio"];?></span>
				<span style="float:right; margin-right:10px;color: #1A831E;font-weight: 600;">АН: <?=$data[$i]["company_name"];?></span>
			<?}?>
			<button type="button" class="btn btn-default left" style='margin-left:10px;padding: 3px 12px; margin-bottom: 4px;' onclick="OpenRecipient('<?=$data[$i]["ids"];?>', <?=$data[$i]["id"];?>, 'recipient')">
				<span class="glyphicon glyphicon-chevron-down"></span>
			</button>		
		</div>
	<?}
	unset ($count, $i, $data);?>
</div>