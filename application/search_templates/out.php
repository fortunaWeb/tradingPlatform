	<script>
$(function (){
	$(".btn.active [name=topic_id]").click();
	<?if(!$_POST){ ?>
		// var parent = $(".products-list").data("parent");
		// var topic = $(".products-list").data("topic");
		// $("input[name=parent_id]").val(parent ? parent : "1");
		// $("input[name=topic_id]").val(topic ? topic : "1");				
	<?}else{?>
	$(".street_list span").each(function(){
		if($(this).text().toString().match(/\S/) != null)
		{			
			$(this).css("display", "block");
		}
	});
	<?}?>
	$(document).on("click", "label[data-id=topic_id], label[data-id=view_type]",  function(){	
		if(!$(this).hasClass("active")){
			if($(this).text().match(/списком/) == "списком"){
				$.post('?task=main&action=save_limit', 'limit=50');
			}
			setTimeout(function(){
				$("input[type=submit]").click();
			}, 400)
		}
	});
	if($('[name=type_id6]').is(':checked')){
		$('select[name=ap_layout]').parent().toggleClass('hidden').attr('disabled', 'disabled');
	}
});

function ApLayoutChange(){
	$('select[name=ap_layout]').parent().toggleClass('hidden');
	if($('select[name=ap_layout]').parent().hasClass('hidden')){
		$('select[name=ap_layout]').attr('disabled', 'disabled');
	}else{
		$('select[name=ap_layout]').removeAttr('disabled');
	}
}
</script>
<form id="main_search" method="GET" style="margin-top: -15px;">
	<?
	echo "<input type='hidden' name='task' value='main'>
		<input type='hidden' name='action' value='{$_GET['action']}'>";
	if($_GET['task']=='profile'){
		echo "<input type='hidden' name='task' value='profile'>
		<input type='hidden' name='action' value='{$_GET['action']}'>
		<input type='hidden' name='page' value='1'>";
		if(isset($_GET['active'])){
			echo "<input type='hidden' name='active' value='{$_GET['active']}'>";
		}
	}
	$rent_true = $topic=="Аренда" && $_SESSION['search_user_id'] != "ngs";
	?>
	<div class="row">
		<?include "application/includes/filters/topic.php";
		if($_SESSION['search_user_id'] != "ngs" && $parent=="Комната"){
			include "application/includes/filters/ap_layout_room.php";
		}else if($parent=="Квартиры" || $parent=="Новостройки"){
			/*колличество комнат*/
			include "application/includes/filters/count_types.php";
		}

		include "application/includes/filters/price.php";
		include "application/includes/filters/delivery_period.php";

		?>
		<div class="geo" style="width: 99%;">
		<?
			include "application/includes/filters/city.php";
			include "application/includes/filters/districts_list.php";
			include "application/includes/filters/street_house.php";
		?>
		</div>
	</div>	
	<hr>	
	<div class="row col-xs-12 <?if($_SESSION['search_user_id'] == "ngs")echo "center";?>" id="control_panel">		

		<?if($_SESSION['user'] != 'guest' && $_GET['task'] != "profile"){
			include "application/includes/filters/searchFooter.php";
		}else{
			Helper::Retro_pag($data[0]['count'], 100);?>	
			<div class="col-xs-2 deployed" style="width: 150px;">			
				<select class="form-control" name="order">
					<option value="date_last_edit" <?php if($order == "date_last_edit") echo "selected"; ?>>
						по продлению555
					</option>
					<option value="date_added" <?php if($order == "date_added") echo "selected"; ?>>
						по созданию
					</option>
				</select>
			</div>
			<?
			/*if($_GET['active']==1){?>
				<a href="<?="http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}&limit=all"?>" style="vertical-align: sub;margin-left: 20px;">Показать все активные варианты</a>
			<?}*/
		}?>
		<input type="submit" class="btn btn-primary right" value="Поиск">		
		<input type="button" onClick="$('.nav-tabs li.active a').click()" class="btn btn-danger right" style="margin-right: 15px;" value="Сброс">
	</div>
	<input type="hidden" name="parent_id" value="<?=$parent_id;?>">	
</form>	