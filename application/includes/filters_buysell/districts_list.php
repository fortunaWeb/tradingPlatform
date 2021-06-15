<div class="col-xs-2 deployed">
	<label class="signature">Районы</label>
	<input type="text" class="form-control" placeholder="Район" autocomplete="off" name="dis" type="text"
			value="<?php if(Helper::FilterVal('dis')) {echo Helper::FilterVal('dis'); } ?>">
	<div class="district_list">
		<label class="checkbox-inline <?php if (Helper::FilterVal('dis1')) echo 'active'; ?>">
		  <input type="checkbox" name="dis1" value="Адлерский" onClick="countDis($(this))" <?php if (Helper::FilterVal('dis1')) echo 'checked="checked"'; ?>>Адлерский
		</label>
		<label class="checkbox-inline <?php if (Helper::FilterVal('dis2')) echo 'active'; ?>">
		  <input type="checkbox" name="dis2" value="Центральный" onClick="countDis($(this))" <?php if (Helper::FilterVal('dis2')) echo 'checked="checked"'; ?>>Центральный
		</label>
		<label class="checkbox-inline <?php if (Helper::FilterVal('dis3')) echo 'active'; ?>">
		  <input type="checkbox" name="dis3" value="Хостинский" onClick="countDis($(this))" <?php if (Helper::FilterVal('dis3')) echo 'checked="checked"'; ?>>Хостинский
		</label>
		<label class="checkbox-inline <?php if (Helper::FilterVal('dis4')) echo 'active'; ?>">
		  <input type="checkbox" name="dis4" value="Лазаревский" onClick="countDis($(this))" <?php if (Helper::FilterVal('dis4')) echo 'checked="checked"'; ?>>Лазаревский
		</label>
		<span data-id="all" class="btn btn-success" onclick="countDis('all')" style="float: left; margin-top: 10px;display: inline-block;">Выбрать всех</span>
		<span class="btn btn-success" onclick="$(this).parent().slideUp()" style="float: right; margin-top: 10px;display: inline-block;">Ok</span>
		
	</div>
</div>