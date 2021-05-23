<div class="col-xs-2 deployed">
	<label class="signature">Канализация</label>	
	<select class="form-control" name="sewage" required>
		<option value="">выберите</option>
		<option value="отсутствует" <?php if($data_res['sewage'] == "отсутствует") echo "selected"; ?>>
			Отсутствует
		</option>
		<option value="выгребная яма" <?php if($data_res['sewage'] == "выгребная яма") echo "selected"; ?>>
			Выгребная яма
		</option>
		<option value="центральная канализация" <?php if($data_res['sewage'] == "центральная канализация") echo "selected"; ?>>
			Центральная канализация
		</option>
	</select>
</div>