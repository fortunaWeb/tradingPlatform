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
<form id="main_search" method="POST" style="margin-top: -15px;">
	<?
	echo "<input type='hidden' name='task' value='main'>
		<input type='hidden' name='action' value='{$_POST['action']}'>";
	if($_POST['task']=='profile'){
		echo "<input type='hidden' name='task' value='profile'>
		<input type='hidden' name='action' value='{$_POST['action']}'>
		<input type='hidden' name='page' value='1'>";
		if(isset($_POST['active'])){
			echo "<input type='hidden' name='active' value='{$_POST['active']}'>";
		}
	}
	$rent_true = $topic=="Аренда" && $_SESSION['search_user_id'] != "ngs";
	?>
	<div class="row">
		<?
		//include "application/includes/filters_main/topic.php";
		if($_SESSION['search_user_id'] != "ngs" && $parent=="Комната"){
			include "application/includes/filters_main/ap_layout_room.php";
		}else if($parent=="Квартиры" || $parent=="Новостройки"){
			include "application/includes/filters_main/count_types.php";
		}
		if($rent_true && ($parent=="Квартиры" || $parent=="Комната"))include "application/includes/filters_main/planning.php";
		if($parent != "Все" && $parent!="Комната") include "application/includes/filters_main/ap_layout.php";
		include "application/includes/filters_main/price.php";
		if($rent_true)include "application/includes/filters_main/delivery_period.php";
		
		if($parent=="Земля" || $parent=="Коммерческая")include "application/includes/filters_main/area.php";?>
		<div class="geo" style="width: 99%;">
			<?include "application/includes/filters_main/city.php";
			include "application/includes/filters_main/districts_list.php";
			include "application/includes/filters_main/street_house.php";
			if($parent != "Квартиры" && $parent != "Комната"){
				include "application/includes/filters_main/orientir.php";
			}
			if($rent_true && ($parent=="Квартиры" || $parent=="Комната") || $parent == "Новостройки")
				include "application/includes/filters_main/floor.php";

			/*балконов/лоджий*/
            include "application/includes/filters_main/bal_lodg.php";
			?>
		</div>
	<?if($parent!="Земля" && $parent!="Гаражи" && $parent!="Коммерческая" && $parent !="Все"){?>
		<div>
			<?if($rent_true){
				/*форма собственности/мебель*/
				include "application/includes/filters_main/own_type.php";
				include "application/includes/filters_main/residents.php";
			}else{
				/*доп условия продажи*/
				if($parent=="Новостройки" || $parent=="Квартиры")include "application/includes/filters_main/additional_terms.php";
				if($parent=="Новостройки")include "application/includes/filters_main/own_type.php";
				if($parent!="Дачи" || $parent!="Дачи"){	
					/*наличие парковки*/
					include "application/includes/filters_main/park.php";
				}
				/*материал стен*/
				include "application/includes/filters_main/wall_type.php";
			}
			if($rent_true && ($parent=="Квартиры" || $parent=="Комната")){
				include "application/includes/filters_main/metro.php";
				include "application/includes/filters_main/new_house.php";
			}
			if($parent!="Комната" && $parent!="Дома" && $parent!="Дачи")
				include "application/includes/filters_main/wc_type.php";
			//include "application/includes/filters_main/area.php";
			?>
		</div>
		<div style="display: inline-block;">
			<?php
			if($parent=="Комната")include "application/includes/filters_main/rooms_count.php";
			if($parent=="Дома"){
				/*Отопление*/
				include "application/includes/filters_main/heating.php";
				/*Мыться*/
				include "application/includes/filters_main/wash.php";
				include "application/includes/filters_main/wc_type.php";
				/*Вода*/
				include "application/includes/filters_main/water.php";
			}?>
		</div>	
			<?
			if($rent_true && ($parent=="Квартиры" || $parent=="Комната"))
			{ /*площадь недвижемости*/ ?>
			<div style="display: inline-block; width:99%">
				<?php
					include "application/includes/filters_main/area.php";	
					if($rent_true)include "application/includes/filters_main/race_now.php";
                    include "application/includes/filters_main/sleeping_area.php";
                    include "application/includes/filters_main/keys.php";
				?>
			</div>
		<?php 
			}
	}
	?>
	</div>	
	<hr>	
	<div class="row col-xs-12 <?if($_SESSION['search_user_id'] == "ngs")echo "center";?>" id="control_panel">		
		<?if($_SESSION['user'] != 'guest' && $_POST['task'] != "profile"){
			include "application/includes/filters_main/searchFooter.php";
		}else{
			Helper::Retro_pag($data[0]['count'], 100);?>	
			<div class="btn-group medium" data-toggle="buttons" style="margin-left: 2%;">
				<label onClick="HideContacts($(this))" class="btn btn-default 
			<?php 
				if(	
					Helper::FilterVal('without_cont') == 1 || 
					$_SESSION["post"]["without_cont"]==1
				) echo "active"; 
			?>">
					<input type="checkbox" name="without_cont" value="1" 
			<?php 
				if(
					Helper::FilterVal('without_cont') == 1 || 
					$_SESSION["post"]["without_cont"]==1
					) echo "checked"; 
			?>>ВИД
		</label>
			</div>
			<div class="col-xs-2 deployed" style="width: 150px;">			
				<select class="form-control" name="order">
					<option value="date_last_edit" <?php if($order == "date_last_edit") echo "selected"; ?>>
						по продлению
					</option>
					<option value="date_added" <?php if($order == "date_added") echo "selected"; ?>>
						по созданию
					</option>
				</select>
			</div>
<?php   }   ?>
		<input type="submit" class="btn btn-primary right" value="Поиск" onclick="searchClearPoligon()">
		<input type="button" onClick="$('.nav-tabs li.active a').click()" class="btn btn-danger right" style="margin-right: 15px;" value="Сброс">
        <input type='hidden' id = 'page_post_id' name = 'page' value = '1'>
        <input type='hidden' id = 'post_poligon_points' name = 'poligon' value = '<?=Helper::FilterVal('poligon')?>'>
        <input type='hidden' id = 'post_view_type' name = 'view_type' value = 'list'>
	</div>
	<input type="hidden" name="parent_id" value="<?=$parent_id?>">
</form>