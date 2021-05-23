<?$val_bal = Helper::FilterVal('val_bal');?>
<?$val_lodg = Helper::FilterVal('val_lodg');?>
<div class="col-xs-1 deployed" style="min-width: 110px !important;">
    <label class="signature" style = 'margin-left: 1px'>Балкон</label>
    <label class="signature" style = 'margin-left: 50px'>Лоджии</label>
	<div class="input-group interval" style = 'min-width: 95px'>
        <select class="form-control"  name="val_bal" id = "val_bal" >
            <option value="0" <?=(empty($val_bal) || $val_bal == '=?=')
                ? "selected"
                : $val_bal?>>
                =?=
            </option>
            <option value="1" <?php if($val_bal == "1") echo "selected"; ?>>
                Есть
            </option>
            <option value="5" <?php if($val_bal == "5") echo "selected"; ?>>
                Нет
            </option>
        </select> |
        <select class="form-control"  name="val_lodg" id = "val_lodg" >
            <option value="0" <?=(empty($val_lodg) || $val_lodg == '=?=')
                ? "selected"
                : $val_lodg?>>
                =?=
            </option>
            <option value="1" <?php if($val_lodg == "1") echo "selected"; ?>>
                Есть
            </option>
            <option value="5" <?php if($val_lodg == "5") echo "selected"; ?>>
                Нет
            </option>
        </select>

	</div>
</div>
<?unset($val_bal);?>
<?unset($val_lodg);?>