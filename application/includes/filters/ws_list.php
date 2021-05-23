<div class="col-xs-2 deployed">
	<label class="signature">Санузел</label>
	<input type="text" class="form-control" placeholder="Санузел" autocomplete="off" name="wc" type="text" 
			value="<?php if(Helper::FilterVal('wc')) {echo Helper::FilterVal('wc'); } ?>">
	<div class="wc_list">
		<label class="checkbox-inline <?php if (Helper::FilterVal('wc1')) echo 'active'; ?>">
		  <input type="checkbox" name="wc1" value="Отсутствует" onClick="countAttrType($(this),'wc')" 
		  	<?php if (Helper::FilterVal('wc1')) echo 'checked="checked"'; ?>>Отсутствует
		</label>

<br/>
		<label class="checkbox-inline <?php if (Helper::FilterVal('wc2')) echo 'active'; ?>">
		  <input type="checkbox" name="wc2" value="Раздельный" onClick="countAttrType($(this),'wc')" 
		  	<?php if (Helper::FilterVal('wc2')) echo 'checked="checked"'; ?>>Раздельный
		</label>
<br/>

		<label class="checkbox-inline <?php if (Helper::FilterVal('wc3')) echo 'active'; ?>">
		  <input type="checkbox" name="wc3" value="Совмещенный" onClick="countAttrType($(this),'wc')" 
		  	<?php if (Helper::FilterVal('wc3')) echo 'checked="checked"'; ?>>Совмещенный
		</label>
<br/>

		<label class="checkbox-inline <?php if (Helper::FilterVal('wc4')) echo 'active'; ?>">
		  <input type="checkbox" name="wc4" value="Без удобств " onClick="countAttrType($(this),'wc')" 
		  	<?php if (Helper::FilterVal('wc4')) echo 'checked="checked"'; ?>>Без удобств 
		</label>
<br/>

		<label class="checkbox-inline <?php if (Helper::FilterVal('wc5')) echo 'active'; ?>">
		  <input type="checkbox" name="wc5" value="2 санузла" onClick="countAttrType($(this),'wc')" 
		  	<?php if (Helper::FilterVal('wc5')) echo 'checked="checked"'; ?>>2 санузла
		</label>
<br/>

		<label class="checkbox-inline <?php if (Helper::FilterVal('wc6')) echo 'active'; ?>">
		  <input type="checkbox" name="wc6" value="3 санузла " onClick="countAttrType($(this),'wc')" 
		  	<?php if (Helper::FilterVal('wc6')) echo 'checked="checked"'; ?>>3 санузла 
		</label>
<br/>

		<label class="checkbox-inline <?php if (Helper::FilterVal('wc7')) echo 'active'; ?>">
		  <input type="checkbox" name="wc7" value="На улице" onClick="countAttrType($(this),'wc')" 
		  	<?php if (Helper::FilterVal('wc7')) echo 'checked="checked"'; ?>>На улице
		</label>
<br/>

		<span data-id="all" class="btn btn-success" onclick="countAttrType('all','wc')" style="margin : 10px 5px 0 0px; display: inline-block;">Все</span>
		<span class="btn btn-success" onclick="$(this).parent().slideUp()" style=" margin-top: 10px;display: inline-block;">Ok</span>
		
	</div>
</div>
