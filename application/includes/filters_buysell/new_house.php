<div class="col-xs-2 deployed">
	<label class="signature">тип кв</label>
	<input type="text" class="form-control" placeholder="Тип" autocomplete="off" name="house_type" type="text" 
			value="<?php if(Helper::FilterVal('house_type')) {echo Helper::FilterVal('house_type'); } ?>">
	<div class="house_type_list">
		<label class="checkbox-inline <?php if (Helper::FilterVal('house_type1')) echo 'active'; ?>">
		  <input type="checkbox" name="house_type1" value="1" onClick="countAttrType($(this),'house_type')" 
		  	<?php if (Helper::FilterVal('house_type1')) echo 'checked="checked"'; ?>>Вторичка
		</label>
<br/>
		<label class="checkbox-inline <?php if (Helper::FilterVal('house_type2')) echo 'active'; ?>">
		  <input type="checkbox" name="house_type2" value="2" onClick="countAttrType($(this),'house_type')" 
		  	<?php if (Helper::FilterVal('house_type2')) echo 'checked="checked"'; ?>>Новостройка
		</label>

		<span data-id="all" class="btn btn-success" onclick="countAttrType('all','house_type')" style="margin : 10px 5px 0 0px; display: inline-block;">Все</span>
		<span class="btn btn-success" onclick="$(this).parent().slideUp()" style=" margin-top: 10px;display: inline-block;">Ok</span>
		
	</div>
</div>