<div class="col-xs-2 deployed" style="max-width: 190px;">
	<label class="signature">Балконов  | лоджий</label>
	<div class="input-group interval" style = 'margin: 0px 10px; width: 90px'>
          <select    class="form-control"  name="val_bal" id = "val_bal" required
         >
            <option value="" <?=($data_res['val_bal'] == "0") ? "selected":""?>>
                =?=
            </option>
            <option value="1" <?php if($data_res['val_bal'] == "1") echo "selected"; ?>>
                1
            </option>
            <option value="2" <?php if($data_res['val_bal'] == "2") echo "selected"; ?>>
                2
            </option>
            <option value="3" <?php if($data_res['val_bal'] == "3") echo "selected"; ?>>
                3
            </option>
            <option value="5" <?php if($data_res['val_bal'] == "5") echo "selected"; ?>>
              Нет
            </option>
        </select>
        <span style = 'width: 0%'></span>
        <select required class="form-control" name="val_lodg" id = "val_lodg"

        required
        >
            <option value="" <?=($data_res['val_lodg'] == "0") ? "selected":""?>>
                =?=
            </option>
            <option value="1" <?php if($data_res['val_lodg'] == "1") echo "selected"; ?>>
                1
            </option>
            <option value="2" <?php if($data_res['val_lodg'] == "2") echo "selected"; ?>>
                2
            </option>
            <option value="3" <?php if($data_res['val_lodg'] == "3") echo "selected"; ?>>
                3
            </option>
            <option value="5" <?php if($data_res['val_lodg'] == "5") echo "selected"; ?>>
                Нет
            </option>
        </select>
	</div>
</div>