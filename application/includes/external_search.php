
<?php 
$url = "?task=external&action=index";
$post_uri = $url."&parent_id=".$parent_id."&topic_id=".$topic_id;
$mytype_page = false;
if($_GET['task'] == "external")
{
	$active = isset($_GET['active']) ? "&active=".$_GET['active'] : "";	
	$url = "?task=external&action=index";
	if($_GET['active']==1){
		$url.="&limit=all";
	}
	$post_uri = $_SERVER["REQUEST_URI"];
	$mytype_page = true;

	$parent = $_GET['parent_id']=="" ? "Все" : $parent;
}
?>
<script type="text/javascript">
	$(function(){
		GeoUpdate($("[name=live_point]").val());
		$(".nav-tabs li.active a").click(function(e){
			e.preventDefault();
			var link = $(this).attr("href");
			$.post("?task=main&action=refresh", function(){
				window.location = link;
			});
		});
		$("[name=live_point]").change(function(){
			GeoUpdate($(this).val());			
		})
	});

function GeoUpdate(val){
	if(val != "Новосибирск" && val != "НСО" && val != ""){
		$("[name=dis]").val("");
		$(".district_list :checkbox").each(function(){
			$(this).prop("checked", "");
			$(this).parent().removeClass("active");
		});
		$(".district_list").parent().hide();
		$(".street_list").parent().show();
		$("[name=house]").parent().show();
	}else if(val == "НСО" || val == ""){
		$("[name=dis]").val("");
		$("[name=street]").val("");
		$(".district_list :checkbox").each(function(){
			$(this).prop("checked", "");
			$(this).parent().removeClass("active");
		});
		$(".district_list").parent().hide();
		$(".street_list input").each(function(){
			$(this).val("");
		});
		$(".street_list").parent().hide();
		$("[name=house]").val("").parent().hide();
	}else{
		$(".street_list").parent().show();
		$(".district_list").parent().show();
		$("[name=house]").parent().show();
	}
}
</script>

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
<div class="row" style="margin-top: -15px;margin-bottom: -10px;display: inline-block;width: inherit;margin-left: auto;">	
<form id="external_search" method="GET" style="margin-top: -15px;" action = <?=$url?>>
	<?
	echo "<input type='hidden' name='task' value='external'>
		<input type='hidden' name='action' value='{$_GET['action']}'>";

	$rent_true = true;
	?>
	<div class="row">
		<?
		include "application/includes/filters/area_type.php";
		if($parent=="Комната"){
			include "application/includes/filters/ap_layout_room.php";
		}else if($parent=="Квартиры" || $parent=="Новостройки"){
			/*колличество комнат*/
			include "application/includes/filters/count_types.php";
		}
		if($rent_true && ($parent=="Квартиры" || $parent=="Комната"))
			include "application/includes/filters/planning.php";

		if($parent != "Все" && $parent!="Комната") 
			include "application/includes/filters/ap_layout.php";

		include "application/includes/filters/price.php";

		if($rent_true)
			include "application/includes/filters/delivery_period.php";

		if($parent=="Земля" || $parent=="Коммерческая")
			include "application/includes/filters/area.php";?>
		<div class="geo" style="width: 99%;">
			<?include "application/includes/filters/city.php";
			include "application/includes/filters/districts_list.php";
			include "application/includes/filters/street_house.php";


			?>
		</div>
		</div>
		<div style="display: inline-block;">
			<?php
			if($parent=="Комната")include "application/includes/filters/rooms_count.php";
			?>
	</div>	
	<div class="row col-xs-12" id="control_panel" style = "margin-top:0px">		
		<input type="submit" class="btn btn-primary right" value="Поиск">		
		<input type="button" onClick="$('.nav-tabs li.active a').click()" class="btn btn-danger right" style="margin-right: 15px;" value="Сброс">
	</div>
</form>	