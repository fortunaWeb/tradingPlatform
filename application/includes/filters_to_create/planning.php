<div class="col-xs-2 deployed">
	<label class="signature">Планировка</label>
	<?$planning = $data_res['planning'] ? $data_res['planning'] : $data_res['planning'];?>
	<select class="form-control"  name="planning" >
		<option value="">выберите планировку</option>
		<?if($parent != "Комната"){?>			
			<option value="изолированная" <?php if($planning == "изолированная") echo "selected"; ?>>
				Изолированная
			</option>
			<option value="смежная" <?php if($planning == "смежная") echo "selected"; ?>>
				Смежная
			</option>
			<option value="см-изолированная" <?php if($planning == "см-изолированная") echo "selected"; ?>>
				См-изолированная
			</option>					
			<option value="студия" <?php if($planning == "студия") echo "selected"; ?>>
				Студия
			</option>					
		<?}else{?>
			<option value="изолированная" <?php if($planning == "изолированная") echo "selected"; ?>>
				Изолированная
			</option>
			<option value="смежная" <?php if($planning == "смежная") echo "selected"; ?>>
				Смежная дальняя
			</option>
			<option value="см-изолированная" <?php if($planning == "см-изолированная") echo "selected"; ?>>
				Смежная проходная
			</option>
		<?}?>
	</select>
</div>