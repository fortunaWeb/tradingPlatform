<div class="col-xs-2 deployed">
	<label class="signature">Планировка</label>
	<?$planning = $data_res['planning'] ? $data_res['planning'] : $data_res['planning'];?>
	<select class="form-control"  name="planning" required >
		<option value="">выберите планировку</option>
			<option value="студия" <?php if($planning == "студия") echo "selected"; ?>>
                студия
			</option>
			<option value="свободная" <?php if($planning == "свободная") echo "selected"; ?>>
                свободная
			</option>

            <option value="изолированная" <?php if($planning == "изолированная") echo "selected"; ?>>
                Изолированная
            </option>
            <option value="смежная" <?php if($planning == "смежная") echo "selected"; ?>>
                Смежная
            </option>
			<option value="евродвушка" <?php if($planning == "евродвушка") echo "selected"; ?>>
				Евродвушка
			</option>
	</select>
</div>