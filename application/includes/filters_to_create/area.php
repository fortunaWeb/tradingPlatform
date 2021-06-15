<?if ($parent == "Квартиры" || $parent == "Дома" || $parent == "Новостройки"){?>
	<div class="col-xs-2 deployed">
		<label class="signature">Площади, м<sup>2</sup></label>
		<div class="input-group interval">			
			<input required type="text" id="sq_all" name="sq_all" class="form-control" placeholder="общ."  size="3" maxlength="3" value="<?php if($data_res['sq_all']) {echo $data_res['sq_all']; } ?>" >
			<input type="text" id="sq_live" name="sq_live" class="form-control" placeholder="жил." size="3" maxlength="3" value="<?php if($data_res['sq_live']) {echo $data_res['sq_live']; } ?>" >
			<input type="text" id="sq_k" name="sq_k" class="form-control" placeholder="кух." size="3" maxlength="3" value="<?php if($data_res['sq_k']) {echo $data_res['sq_k']; } ?>" >
			
		</div>
	</div>
<?}else if($parent == "Комната" || $parent == "Гаражи" || $parent == "Коммерческая"){?>
	<div class="col-xs-1 deployed">
		<label class="signature">Площадь</label>
		<input type="text" id="sq_live" name="sq_live" class="form-control" placeholder="м2" size="3" maxlength="3"  value="<?php if($data_res['sq_live']) {echo $data_res['sq_live']; } ?>" required>
	</div>
<?}else if($parent == "Земля"){?>
	<div class="col-xs-2 deployed">
		<label class="signature">Площадь участка</label>
		<input type="text" id="sq_land" name="sq_land" class="form-control" placeholder="сотки" size="3" maxlength="3" value="<?php if($data_res['sq_land']) {echo $data_res['sq_land']; } ?>" required>
	</div>
<?}else{?>
	<div class="col-xs-2 deployed">
		<label class="signature">Площадь дома</label>
		<input type="text" id="sq_live" name="sq_live" class="form-control" placeholder="м2" size="3" maxlength="3" value="<?php if($data_res['sq_live']) {echo $data_res['sq_live']; } ?>" required>
	</div>
	<div class="col-xs-2 deployed">
		<label class="signature">Площадь участка</label>
		<input type="text" id="sq_land" name="sq_land" class="form-control" placeholder="сотки"  size="3" maxlength="3" value="<?php if($data_res['sq_land']) {echo $data_res['sq_land']; } ?>" required>
	</div>
<?}?>