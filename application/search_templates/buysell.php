<form id="buysell_search" method="POST" style="margin-top: -30px;">
	<?
		echo "<input type='hidden' name='task' value='{$_GET['task']}'>
		<input type='hidden' name='action' value='{$_GET['action']}'>";
	?>
	<div class="row" >
		<div style="display: inline-block;">
	<?php
//		include "application/includes/filters_buysell/topic.php";
		$rent_true = null;
		$topic=="Продажа";
	?>
		</div>
        <div>
            <?php
                if($parent == "Квартиры" || $parent == 'Новостройки'){
                    include "application/includes/filters_buysell/count_types.php";
                }
            ?>
        </div>
		<div class="geo" style="width: 99%;">

	<?php

		include "application/includes/filters_main/city.php";
		include "application/includes/filters_buysell/districts_list.php";
		include "application/includes/filters_buysell/street_house.php";
	?>
		</div>
        <?php
        if($parent != "Квартиры") {
            ?>
            <div class="geo" style="width: 99%;">
                <?php
                if ($parent == "Комната") {
                    include "application/includes/filters_buysell/estate_type_apartment.php";
                }

                if ($parent == "Дома") {
                    include "application/includes/filters_buysell/estate_type_house.php";
                    include "application/includes/filters_buysell/floor_count.php";
                } else if ($parent == 'Дачи') {
                    include "application/includes/filters_buysell/estate_type_dacha.php";
                } else if ($parent == 'Гаражи') {

                    include "application/includes/filters_buysell/estate_type_garage.php";
                } else if ($parent == 'Коммерческая') {
                    include "application/includes/filters_buysell/estate_type_commercial.php";
                } else if ($parent == 'Земля') {
                    include "application/includes/filters_buysell/estate_type_land_plot.php";
                } else {

//        include "application/includes/filters_buysell/floor.php";
//        include "application/includes/filters_buysell/floor_count.php";
                }

                //		include "application/includes/filters/area_room.php";
                //        include "application/includes/filters_buysell/description.php";
                ?>
            </div>

            <?php
        }
        ?>
	</div>

    <hr>
    <div class="row col-xs-12 " style = 'text-align: right;' id="control_panel">
        <?php
            include "application/includes/filters_buysell/searchFooter.php";
        ?>
        <input type="submit" class="btn btn-primary right" value="Поиск">
    </div>
	<input type="hidden" name="parent_id" value="<?=$parent_id;?>">
</form>