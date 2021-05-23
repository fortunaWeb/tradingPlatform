<div class="col-xs-2 deployed">
	<label class="signature">Санузел</label>	
	<select class="form-control" name="wc_type">
		<option value="">выберите</option>
		<option value="раздельный" <?php if($data_res['wc_type'] == "раздельный") echo "selected"; ?>>
			Раздельный
		</option>
		<option value="совмещенный" <?php if($data_res['wc_type'] == "совмещенный") echo "selected"; ?>>
			Совмещенный
		</option>
		<option value="без удобств" <?php if($data_res['wc_type'] == "без удобств") echo "selected"; ?>>
			Без удобств
		</option>
		<option value="2 санузла" <?php if($data_res['wc_type'] == "2 санузла") echo "selected"; ?>>
			2 санузла
		</option>
		<?php if($parent == "Дома"){?>
		<option value="3 санузла" <?php if($data_res['wc_type'] == "3 санузла") echo "selected"; ?>>
			3 санузла
		</option>
		<?}if($parent == "Дома" || $parent == "Дачи"){ ?>
			<option value="на улице" <?php if($data_res['wc_type'] == "на улице") echo "selected"; ?> >На улице</option>
		<?}?>
	</select>
</div>	