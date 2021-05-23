<script type='text/javascript'>
	$(function(){
		$(document).on("click", "[data-id=contacts]", function(){
			setTimeout(function(){
				$("[type=submit]").click();
			}, 500)
		})
	})
</script>
<form id="main_search" method="POST" style="margin-top: -15px;">
    <input type='hidden' name='task' value='<?=$_GET['task']?>'>
	<input type='hidden' name='action' value='<?=$_GET['action']?>'>


	<div class="row">
		<div class="col-xs-2 deployed" style="min-width: 150px  !important;display:none">
			<div class="btn-group medium" data-toggle="buttons">
			  <label data-id="topic_id" class="btn btn-default active">
		      <input type="radio" name="topic_id" value="2" checked="">Продам</label>
			</div>
		</div>
		<?
		if($parent == "Квартиры"){
			include "application/includes/filters/count_types.php";
		}
		$rent_true = $topic=="Аренда";
//		include "application/includes/filters/price.php";
		?>
		<div class="geo" style="width: 99%;">
			<?include "application/includes/filters/city.php";
			include "application/includes/filters/districts_list.php";
			include "application/includes/filters/street_house.php";?>
			<div class="col-xs-2 deployed">
				<input class="form-control" type="text" name="phone" placeholder="телефон" value="<?=Helper::FilterVal('phone')?>">
			</div>
			<?php if($_SESSION['admin']==1) {
				?>
			<div class="col-xs-2 deployed">
				<input class="" type="checkbox" name="review" placeholder="" value="1" <?php if (Helper::FilterVal('review')==1) echo "checked"; ?>>
			</div>
			<?php 
			}
			include "application/includes/filters_buysell/description.php";
			?>



		</div>
	</div>
	<hr>	
	<div class="row col-xs-12" style = 'text-align: right;' id="control_panel">
		<?if($_SESSION['user'] != 'guest' && $_GET['task'] != "profile"){
			include "application/includes/filters/searchFooter.php";
		}else{
			Helper::Retro_pag($data[0]['count'], 100);
		}
?>
		<input type="submit" class="btn btn-primary right" value="Поиск">
        <input type='hidden' id = 'page_post_id' name = 'page' value = '1'>
        <input type='hidden' id = 'post_poligon_points' name = 'poligon' value = '<?=Helper::FilterVal('poligon')?>'>
        <input type='hidden' id = 'post_view_type' name = 'view_type' value = 'list'>
	</div>
	<input type="hidden" name="parent_id" value="<?=$parent_id;?>">	
</form>	