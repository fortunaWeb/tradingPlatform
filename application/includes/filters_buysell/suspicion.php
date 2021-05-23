<?$suspicion = Helper::FilterVal('suspicion');?>
<div class="col-xs-2 deployed">
	<select class="form-control" name="suspicion">			
		<option value="">не важно</option>
        <option value="0">без подозрений</option>
		<option value="1" <?php if($suspicion == "1") echo "selected"; ?>>подозрительно</option>
	</select>
</div>