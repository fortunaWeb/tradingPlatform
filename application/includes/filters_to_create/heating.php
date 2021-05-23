<div class="col-xs-2 deployed">
	<label class="signature">Отопление</label>	
	<select class="form-control" name="heating" id="heating" required>
		<option value="" >выберите</option>
		<option value="отсутствует" <?php if($data_res['heating'] == 'отсутствует') echo "selected"; ?>  >Отсутствует</option>
		<option value="электрическое" <?php if($data_res['heating'] == 'электрическое') echo "selected"; ?>  >Электрическое</option>
		<option value="газовое" <?php if($data_res['heating'] == 'газовое') echo "selected"; ?> >Газовое</option>
		<option value="печное" <?php if($data_res['heating'] == 'печное') echo "selected"; ?> >Печное</option>
		<option value="центральное" <?php if($data_res['heating'] == 'центральное') echo "selected"; ?> >Центральное</option>
	</select>
</div>