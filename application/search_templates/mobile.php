<script>
$(function (){
	$(".btn.active [name=topic_id]").click();
	$(".street_list span").each(function(){
		if($(this).text().toString().match(/\S/) != null)
		{			
			$(this).css("display", "block");
		}
	});
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
<form id="main_search" method="POST" style="margin-top: -15px;">
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
		<?php
		//include "application/includes/filters/topic.php";


if($_SESSION['mobile']==1){ ?><div class="col-xs-1 deployed" style = 'width:99%;'><?}
		if($_SESSION['search_user_id'] != "ngs" && $parent=="Комната"){
			include "application/includes/filters/ap_layout_room.php";
		}else if($parent=="Квартиры" || $parent=="Новостройки"){
			include "application/includes/filters/count_types.php";
		}
		if($parent == "Дома") 
			include "application/includes/filters/ap_layout.php";
if($_SESSION['mobile']==1){ echo "</div>";}
		if($parent=="Земля" || $parent=="Коммерческая")
			include "application/includes/filters/area.php";
		
if($_SESSION['mobile']==1){ ?><div class="col-xs-1 deployed" style = 'width:99%;'><?}
		include "application/includes/filters/city.php";
		include "application/includes/filters/districts_list.php";
if($_SESSION['mobile']==1){ echo "</div>";}

		include "application/includes/filters/street_house.php";
        if($_GET['action'] != 'mytype'){
            include "application/includes/filters/metro.php";
        }
		if($parent=="Новостройки"){
			include "application/includes/filters/own_type.php";
		}
		include "application/includes/filters/price.php";

        if($rent_true)include "application/includes/filters_main/race_now.php";
if($_SESSION['mobile']==1){ ?><div class="col-xs-1 deployed" style = 'width:99%;'><?}

		include "application/includes/filters/residents.php";

		if($rent_true && ($parent=="Квартиры" || $parent=="Комната")){

		}
		if($rent_true && ($parent=="Квартиры" || $parent=="Комната"))
			include "application/includes/filters/planning.php";

                    include "application/includes/filters_main/bal_lodg.php";
if($_SESSION['mobile']==1){ echo "</div>";}
		include "application/includes/filters/own_type.php";
        include "application/includes/filters/new_house.php";
        include "application/includes/filters/sleeping_area.php";
        include "application/includes/filters/keys.php";
        include "application/includes/filters_main/delivery_period.php";
	?>
</div>
<div class="row" style = 'padding: 2px; border-radius: 4px; width:50%'>
	<?if($_SESSION['user'] != 'guest' && $_GET['task'] != "profile"){
		if($_SESSION['mobile'] ==1 ){
			include "application/includes/filters/searchFooter_mobile.php";
		}else{
			include "application/includes/filters/searchFooter.php";	
		}
		
	}else{
		Helper::Retro_pag($data[0]['count'], 100);?>	
		<?php
	}?>
	<div class="col-xs-1 deployed" style = "<?=$_SESSION['mobile']==1?'width: 99%;margin-bottom: 0px;margin-top: 0%;float: auto;':''?>">
		<input type="submit" class="btn btn-primary right" value="Поиск" style = "float:left;margin: 10px 0;">
        <input type='hidden' id = 'page_post_id' name = 'page' value = '1'>
	</div>
	<!--<input type="button" onClick="$('.nav-tabs li.active a').click()" class="btn btn-danger right" style="margin-right: 15px;" value="Сброс">-->
</div>
	<input type="hidden" name="parent_id" value="<?=$parent_id;?>">	
</form>	