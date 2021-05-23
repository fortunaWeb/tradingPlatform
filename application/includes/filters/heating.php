<div class="col-xs-2 deployed">
	<label class="signature">Отопление</label>	
	<select class="form-control" name="heating" id="heating" >
		<option value="" >не важно</option>
		<option value="электрическое" <?php if(Helper::FilterVal('heating') == 'электрическое') echo "selected"; ?>  >Электрическое</option>
		<option value="газовое" <?php if(Helper::FilterVal('heating') == 'газовое') echo "selected"; ?> >Газовое</option>
		<option value="печное" <?php if(Helper::FilterVal('heating') == 'печное') echo "selected"; ?> >Печное</option>
		<option value="центральное" <?php if(Helper::FilterVal('heating') == 'центральное') echo "selected"; ?> >Центральное</option>
	</select>
</div>