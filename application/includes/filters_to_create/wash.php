<div class="col-xs-2 deployed">
	<label class="signature">Мыться</label>	
	<select class="form-control" name="wash" required>
		<option value="">выберите</option>
		<option value="баня" <?php if($data_res['wash'] == "баня") echo "selected"; ?>>
			Баня
		</option>
		<option value="душ" <?php if($data_res['wash'] == "душ") echo "selected"; ?>>
			Душ
		</option>
		<option value="негде" <?php if($data_res['wash'] == "негде") echo "selected"; ?>>
			Негде
		</option>
	</select>
</div>