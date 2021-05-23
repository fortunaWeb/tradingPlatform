<div class="col-xs-2 deployed">
	<label class="signature">Отопление</label>
	<input type="text" class="form-control" placeholder="Отопление" autocomplete="off" name="heating" type="text" 
			value="<?php if(Helper::FilterVal('heating')) {echo Helper::FilterVal('heating'); } ?>">
	<div class="heating_list">
		<label class="checkbox-inline <?php if (Helper::FilterVal('heating1')) echo 'active'; ?>">
		  <input type="checkbox" name="heating1" value="Электрическое" onClick="countAttrType($(this),'heating')" 
		  	<?php if (Helper::FilterVal('heating1')) echo 'checked="checked"'; ?>>Электрическое
		</label>
<br/>
		<label class="checkbox-inline <?php if (Helper::FilterVal('heating2')) echo 'active'; ?>">
		  <input type="checkbox" name="heating2" value="Газовое" onClick="countAttrType($(this),'heating')" 
		  	<?php if (Helper::FilterVal('heating2')) echo 'checked="checked"'; ?>>Газовое
		</label>
<br/>
		<label class="checkbox-inline <?php if (Helper::FilterVal('heating3')) echo 'active'; ?>">
		  <input type="checkbox" name="heating3" value="Печное" onClick="countAttrType($(this),'heating')" 
		  	<?php if (Helper::FilterVal('heating3')) echo 'checked="checked"'; ?>>Печное
		</label>
<br/>
		<label class="checkbox-inline <?php if (Helper::FilterVal('heating4')) echo 'active'; ?>">
		  <input type="checkbox" name="heating4" value="Центральное" onClick="countAttrType($(this),'heating')" 
		  	<?php if (Helper::FilterVal('heating4')) echo 'checked="checked"'; ?>>Центральное
		</label>

		<span data-id="all" class="btn btn-success" onclick="countAttrType('all','heating')" style="margin : 10px 5px 0 0px; display: inline-block;">Все</span>
		<span class="btn btn-success" onclick="$(this).parent().slideUp()" style=" margin-top: 10px;display: inline-block;">Ok</span>
		
	</div>
</div>