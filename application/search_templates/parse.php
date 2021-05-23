<form id="main_search" method="POST" style="margin-top: -15px;">
	<?
		echo "<input type='hidden' name='task' value='{$_GET['task']}'>
		<input type='hidden' name='action' value='{$_GET['action']}'>";
	?>
	<div class="row">
		<?
		if($parent == "Квартиры"){
			include "application/includes/filters/count_types.php";
		}
        include "application/includes/filters/price.php";
		$rent_true = $topic=="Аренда";
		?>
		<div class="geo" style="width: 99%;">
			<?include "application/includes/filters/city.php";
			include "application/includes/filters/districts_list.php";
			include "application/includes/filters/street_house.php";
			if($parent != "Квартиры" && $parent != "Комната"){
				include "application/includes/filters/orientir.php";
			}
            include "application/includes/filters_buysell/area.php";
			?>
		</div>
        <input type="submit" class="btn btn-primary <?=$_SESSION['mobile']==1?'left':'right'?>"
               value="Поиск" style = 'margin: <?=$_SESSION['mobile']==1?'10px 0px ':'0px 10px '?>;'>
        <input type='hidden' id = 'page_post_id' name = 'page' value = '1'>
        <input type='hidden' id = 'post_poligon_points' name = 'poligon' value = '<?=Helper::FilterVal('poligon')?>'>
        <input type='hidden' id = 'post_view_type' name = 'view_type' value = 'list'>
	</div>
    <?=$_SESSION['mobile']==1 ?'':''?>
		
	<?
	if($_SESSION['user'] != 'guest' && $_GET['task'] != "profile"){
		if($_SESSION['mobile'] ==1 ){
			?>
	<div class="row" style = 'padding: 2px; border-radius: 4px; width:100%;'>
			<?
			include "application/includes/filters/searchFooter_mobile.php";
		}else{
			?>
	<div class="row col-xs-12 center" id="control_panel" style = 'width: 95%;padding-left: 0px'>
			<?
			include "application/includes/filters/searchFooter.php";	
		}		
	}
	?>
	</div>
	<input type="hidden" name="parent_id" value="<?=$parent_id;?>">	
</form>	