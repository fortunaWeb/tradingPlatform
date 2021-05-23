<div class="col-xs-1 deployed">
	<label class="signature">Планировка</label>
	<?$planning = Helper::FilterVal('planning') ? Helper::FilterVal('planning') : "";?>
	<select class="form-control"  name="planning" >
		<option value="">планировка</option>		
		<?if($_SESSION['search_user_id'] == "site"){
		if($parent != "Комната"){?>			
			<option value="изолированная" <?php if($planning == "изолированная") echo "selected"; ?>>
				Из
			</option>
			<option value="смежная" <?php if($planning == "смежная") echo "selected"; ?>>
				См
			</option>
			<option value="см-изолированная" <?php if($planning == "см-изолированная") echo "selected"; ?>>
				См-из
			</option>
			<!--<option value="свободная" <?php if($planning == "свободная") echo "selected"; ?>>
				Свободная
			</option>-->
			<option value="студия" <?php if($planning == "студия") echo "selected"; ?>>
				Студ
			</option>
			<!--<option value="иное" <?php if($planning == "иное") echo "selected"; ?>>
				Иное
			</option>-->
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
		<?}
		}else{?>
			<option value="изолированная" <?php if($planning == "изолированная") echo "selected"; ?>>
				Изолированная
			</option>
			<option value="смежная" <?php if($planning == "смежная") echo "selected"; ?>>
				Смежная
			</option>
			<option value="смежно-изолированная" <?php if($planning == "смежно-изолированная") echo "selected"; ?>>
				См-изолированная
			</option>
			<option value="свободная" <?php if($planning == "свободная") echo "selected"; ?>>
				Свободная
			</option>
			<option value="иное" <?php if($planning == "иное") echo "selected"; ?>>
				Иное
			</option>
		<?}?>
	</select>
</div>