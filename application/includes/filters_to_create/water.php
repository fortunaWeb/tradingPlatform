<div class="col-xs-2 deployed">
	<label class="signature">Вода</label>	
	<select class="form-control" name="water" id="water" required>
		<option value="" >выберите</option>
		<option value="колонка" <?php if($data_res['water'] == 'колонка') echo "selected"; ?> >Ходить в колонку</option>
		<option value="х" <?php if($data_res['water'] == 'х') echo "selected"; ?> >В доме хол.</option>
		<option value="хг" <?php if($data_res['water'] == 'хг') echo "selected"; ?> >В доме хол.+ гор.</option>
		<option value="бойлер" <?php if($data_res['water'] == 'бойлер') echo "selected"; ?> >В доме хол.+ бойлер</option>
	</select>
</div>