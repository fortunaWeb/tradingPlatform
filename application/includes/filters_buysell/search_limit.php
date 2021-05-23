<?$water = Helper::FilterVal('water');?>
<div class="col-xs-2 deployed">
	<label class="signature">Вода</label>	
	<select class="form-control" name="water" id="water" >
		<option value="" >не важно</option>
		<option value="колонка" <?php if($water == 'колонка') echo "selected"; ?> >Ходить в колонку</option>
		<option value="х" <?php if($water == 'х') echo "selected"; ?> >В доме хол.</option>
		<option value="хг" <?php if($water == 'хг') echo "selected"; ?> >В доме хол.+ гор.</option>
		<option value="бойлер" <?php if($water == 'бойлер') echo "selected"; ?> >В доме хол.+ бойлер</option>
	</select>
</div>
<?unset($water);?>