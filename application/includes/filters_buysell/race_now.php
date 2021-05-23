<div class="col-xs-2 deployed">
	<div class="btn-group medium" data-toggle="buttons" style="margin-left: 1%;">
		<label class="btn btn-default <?php if(Helper::FilterVal('race_now') == "now") echo "active"; ?>">
			<input type="checkbox" name="race_now" value="now" <?php if(Helper::FilterVal('race_now') == "now") echo "checked"; ?>>Заезд и просмотр сегодня
		</label>
	</div>
</div>
