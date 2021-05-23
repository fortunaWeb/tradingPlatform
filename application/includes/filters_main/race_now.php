<div class="col-xs-2 deployed" style="min-width: 110px !important;margin-right: 50px;">
	<div class="btn-group medium" data-toggle="buttons" style="margin-left: 1%;margin-right: 50px;">
		<label class="btn btn-default <?=Helper::FilterVal('race_now')=="now"?"active":''?>">
			<input type="checkbox" name="race_now" value="now" <?=Helper::FilterVal('race_now')=="now"?"checked":''?>>Заезд и просмотр сегодня
		</label>
	</div>
</div>
