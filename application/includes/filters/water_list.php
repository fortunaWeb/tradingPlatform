<div class="col-xs-2 deployed">
	<label class="signature">Вода</label>
	<input type="text" class="form-control" placeholder="Вода" autocomplete="off" name="water" type="text" 
			value="<?php if(Helper::FilterVal('water')) {echo Helper::FilterVal('water'); } ?>">
	<div class="water_list">
		<label class="checkbox-inline <?php if (Helper::FilterVal('water1')) echo 'active'; ?>">
		  <input type="checkbox" name="water1" value="колонка" onClick="countAttrType($(this),'water')" 
		  	<?php if (Helper::FilterVal('water1')) echo 'checked="checked"'; ?>>Ходить в колонку
		</label>
<br/>
		<label class="checkbox-inline <?php if (Helper::FilterVal('water2')) echo 'active'; ?>">
		  <input type="checkbox" name="water2" value="х" onClick="countAttrType($(this),'water')" 
		  	<?php if (Helper::FilterVal('water2')) echo 'checked="checked"'; ?>>В доме хол.
		</label>
<br/>
		<label class="checkbox-inline <?php if (Helper::FilterVal('water3')) echo 'active'; ?>">
		  <input type="checkbox" name="water3" value="хг" onClick="countAttrType($(this),'water')" 
		  	<?php if (Helper::FilterVal('water3')) echo 'checked="checked"'; ?>>В доме хол.+ гор.
		</label>
<br/>
		<label class="checkbox-inline <?php if (Helper::FilterVal('water4')) echo 'active'; ?>">
		  <input type="checkbox" name="water4" value="бойлер" onClick="countAttrType($(this),'water')" 
		  	<?php if (Helper::FilterVal('water4')) echo 'checked="checked"'; ?>>В доме хол.+ бойлер
		</label>

		<span data-id="all" class="btn btn-success" onclick="countAttrType('all','water')" style="margin : 10px 5px 0 0px; display: inline-block;">Все</span>
		<span class="btn btn-success" onclick="$(this).parent().slideUp()" style=" margin-top: 10px;display: inline-block;">Ok</span>
		
	</div>
</div>