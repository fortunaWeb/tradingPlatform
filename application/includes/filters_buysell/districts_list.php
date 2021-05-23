<div class="col-xs-2 deployed">
	<label class="signature">Районы</label>
	<input type="text" class="form-control" placeholder="Район" autocomplete="off" name="dis" type="text" 
			value="<?php if(Helper::FilterVal('dis')) {echo Helper::FilterVal('dis'); } ?>">
	<div class="district_list">
		<label class="checkbox-inline <?php if (Helper::FilterVal('dis1')) echo 'active'; ?>">
		  <input type="checkbox" name="dis1" value="Дзержинский" onClick="countDis($(this))" <?php if (Helper::FilterVal('dis1')) echo 'checked="checked"'; ?>>Дзержинский
		</label>
		<label class="checkbox-inline <?php if (Helper::FilterVal('dis2')) echo 'active'; ?>">
		  <input type="checkbox" name="dis2" value="Железнодорожный" onClick="countDis($(this))" <?php if (Helper::FilterVal('dis2')) echo 'checked="checked"'; ?>>Железнодорожный
		</label>
		<label class="checkbox-inline <?php if (Helper::FilterVal('dis3')) echo 'active'; ?>">
		  <input type="checkbox" name="dis3" value="Заельцовский" onClick="countDis($(this))" <?php if (Helper::FilterVal('dis3')) echo 'checked="checked"'; ?>>Заельцовский
		</label>
		<label class="checkbox-inline <?php if (Helper::FilterVal('dis4')) echo 'active'; ?>">
		  <input type="checkbox" name="dis4" value="Калининский" onClick="countDis($(this))" <?php if (Helper::FilterVal('dis4')) echo 'checked="checked"'; ?>>Калининский
		</label>
		<label class="checkbox-inline <?php if (Helper::FilterVal('dis5')) echo 'active'; ?>">
		  <input type="checkbox" name="dis5" value="Кировский" onClick="countDis($(this))" <?php if (Helper::FilterVal('dis5')) echo 'checked="checked"'; ?>>Кировский
		</label>
		<label class="checkbox-inline <?php if (Helper::FilterVal('dis6')) echo 'active'; ?>">
		  <input type="checkbox" name="dis6" value="Ленинский" onClick="countDis($(this))" <?php if (Helper::FilterVal('dis6')) echo 'checked="checked"'; ?>>Ленинский
		</label>
		<label class="checkbox-inline <?php if (Helper::FilterVal('dis7')) echo 'active'; ?>">
		  <input type="checkbox" name="dis7" value="Октябрьский" onClick="countDis($(this))" <?php if (Helper::FilterVal('dis7')) echo 'checked="checked"'; ?>>Октябрьский
		</label>
		<label class="checkbox-inline <?php if (Helper::FilterVal('dis8')) echo 'active'; ?>">
		  <input type="checkbox" name="dis8" value="Первомайский" onClick="countDis($(this))" <?php if (Helper::FilterVal('dis8')) echo 'checked="checked"'; ?>>Первомайский
		</label>
		<label class="checkbox-inline <?php if (Helper::FilterVal('dis9')) echo 'active'; ?>">
		  <input type="checkbox" name="dis9" value="Советский" onClick="countDis($(this))" <?php if (Helper::FilterVal('dis9')) echo 'checked="checked"'; ?>>Советский
		</label>
		<label class="checkbox-inline <?php if (Helper::FilterVal('dis10')) echo 'active'; ?>">
		  <input type="checkbox" name="dis10" value="Центральный" onClick="countDis($(this))" <?php if (Helper::FilterVal('dis10')) echo 'checked="checked"'; ?>>Центральный
		</label>
		<span data-id="all" class="btn btn-success" onclick="countDis('all')" style="float: left; margin-top: 10px;display: inline-block;">Выбрать всех</span>
		<span class="btn btn-success" onclick="$(this).parent().slideUp()" style="float: right; margin-top: 10px;display: inline-block;">Ok</span>
		
	</div>
</div>