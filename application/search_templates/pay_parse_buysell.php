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
	<?
		echo "<input type='hidden' name='task' value='".Helper::FilterVal('task')? Helper::FilterVal('task'):''."'>
		<input type='hidden' name='action' value='{$_POST['action']}'>";
	?>

	<div class="row">
		<div class="col-xs-2 deployed" style="min-width: 150px  !important;display:none">
			<div class="btn-group medium" data-toggle="buttons">
			  <label data-id="topic_id" class="btn btn-default active">
		<input type="radio" name="topic_id" value="2" checked="">Продам</label>			
			</div>
		</div>
		

		<div class="geo" style="width: 99%;">
			<?
			if($parent == "Квартиры"){
				include "application/includes/filters/count_types.php";
			}
			include "application/includes/filters/city_buysell.php";
            include "application/includes/filters/districts_list.php";
			include "application/includes/filters/street_house.php";
			include "application/includes/filters/price.php";
			if($_SESSION['admin']==1) {
		?>
				<div class="col-xs-2 deployed">
					<input class="" type="checkbox" name="review" placeholder="" value="1" <?php if (Helper::FilterVal('review')==1) echo "checked"; ?>>
				</div>
		<?php 
			}
		$topic=="Продажа";
        ?>

	</div>

    <div class="row">
        <?
        include "application/includes/filters_buysell/details.php";
        ?>
        <div class="col-xs-2 deployed">
            <input class="form-control" type="text" name="phone" placeholder="телефон" value="<?=Helper::FilterVal('phone')?>">
        </div>
    </div>
    <div class="row">
        <?

        include "application/includes/filters_buysell/area.php";
        ?>
    </div>
	<hr>	
	<div class="row col-xs-12 center" id="control_panel">
		<?if($_SESSION['user'] != 'guest' && Helper::FilterVal('task') != "profile"){
			include "application/includes/filters/search_footer_buysell.php";
		}else{
			Helper::Retro_pag($data[0]['count'], 100);
		}
		if(Helper::FilterVal('action') != "favorites_parse"){
		/*
		?>	

			<div class="btn-group medium" data-toggle="buttons" style="margin-left: 2%;">
				<label onClick="HideContacts($(this))" data-id="contacts" class="btn btn-default <?php if($_SESSION["post"]['without_cont'] == 1) echo "active"; ?>">
					<input type="checkbox" name="without_cont" value="1" <?php if($_SESSION["post"]['without_cont'] == 1) echo "checked"; ?>>ВИД
				</label>
			</div>
		<? /**/
	}else{?>
			<div class="btn-group medium" data-toggle="buttons" style="margin-left: 2%;">
				<label onClick="HideContacts($(this))"  data-id="contacts" class="btn btn-default <?php if($_SESSION["post"]['without_cont'] == 1) echo "active"; ?>">
					<input type="checkbox" value="1" <?php if($_SESSION["post"]['without_cont'] == 1) echo "checked"; ?>>ВИД
				</label>
			</div>
		<?}?>
        <input type='hidden' id = 'page_post_id' name = 'page' value = '1'>
		<input type="submit" class="btn btn-primary right" value="Поиск">		
	</div>
	<input type="hidden" name="parent_id" value="<?=$parent_id;?>">	
</form>	