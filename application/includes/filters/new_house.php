<div class="col-xs-1 deployed" style="min-width:110px !important">
	<div class="btn-group medium" data-toggle="buttons">		
		<label class="btn btn-default <?php if(Helper::FilterVal('new_house') == 1) echo "active"; ?>">
			<input type="checkbox" name="new_house" value="1" <?php if(Helper::FilterVal('new_house') == 1) echo "checked"; ?>>Новый дом
		</label>
	</div>
</div>