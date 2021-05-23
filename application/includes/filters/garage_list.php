<div class="col-xs-2 deployed">
	<label class="signature">Гараж</label>
	<input type="text" class="form-control" placeholder="Гараж" autocomplete="off" name="garage" type="text" 
			value="<?php if(Helper::FilterVal('garage')) {echo Helper::FilterVal('garage'); } ?>">
	<div class="garage_list">

		<label class="checkbox-inline <?php if (Helper::FilterVal('garage1')) echo 'active'; ?>">
		  <input type="checkbox" name="garage1" value="Отсутствует" onClick="countAttrType($(this),'garage')" 
		  	<?php if (Helper::FilterVal('garage1')) echo 'checked="checked"'; ?>>Отсутствует
		</label>

		<label class="checkbox-inline <?php if (Helper::FilterVal('garage2')) echo 'active'; ?>">
		  <input type="checkbox" name="garage2" value="Парковка у дома" onClick="countAttrType($(this),'garage')" 
		  	<?php if (Helper::FilterVal('garage2')) echo 'checked="checked"'; ?>>Парковка у дома
		</label>
	
		<?if($parent != "Дома" && $parent != "Дачи"){?>
		<label class="checkbox-inline <?php if (Helper::FilterVal('garage3')) echo 'active'; ?>">
		  <input type="checkbox" name="garage3" value="Парковка со шлагбаумом" onClick="countAttrType($(this),'garage')" 
		  	<?php if (Helper::FilterVal('garage3')) echo 'checked="checked"'; ?>>Парковка со шлагбаумом
		</label>
	
		<label class="checkbox-inline <?php if (Helper::FilterVal('garage4')) echo 'active'; ?>">
		  <input type="checkbox" name="garage4" value="Подземный гараж" onClick="countAttrType($(this),'garage')" 
		  	<?php if (Helper::FilterVal('garage4')) echo 'checked="checked"'; ?>>Подземный гараж
		</label>
	
		<label class="checkbox-inline <?php if (Helper::FilterVal('garage5')) echo 'active'; ?>">
		  <input type="checkbox" name="garage5" value="Подземная парковка" onClick="countAttrType($(this),'garage')" 
		  	<?php if (Helper::FilterVal('garage5')) echo 'checked="checked"'; ?>>Подземная парковка
		</label>
	<?php }else{ ?>
		<label class="checkbox-inline <?php if (Helper::FilterVal('garage6')) echo 'active'; ?>">
		  <input type="checkbox" name="garage6" value="Парковка во дворе" onClick="countAttrType($(this),'garage')"
		  	 <?php if (Helper::FilterVal('garage6')) echo 'checked="checked"'; ?>>Парковка во дворе
		</label>
	
		<label class="checkbox-inline <?php if (Helper::FilterVal('garage7')) echo 'active'; ?>">
		  <input type="checkbox" name="garage7" value="Металлический гараж" onClick="countAttrType($(this),'garage')" 
		  	<?php if (Helper::FilterVal('garage7')) echo 'checked="checked"'; ?>>Металлический гараж
		</label>

		<label class="checkbox-inline <?php if (Helper::FilterVal('garage8')) echo 'active'; ?>">
		  <input type="checkbox" name="garage8" value="Капитальный гараж" onClick="countAttrType($(this),'garage')" 
		  	<?php if (Helper::FilterVal('garage8')) echo 'checked="checked"'; ?>>Капитальный гараж
		</label>
	<?php } ?>

		<span data-id="all" class="btn btn-success" onclick="countAttrType('all','garage')" style="float: left; margin-top: 10px;display: inline-block;">Выбрать все</span>
		<span class="btn btn-success" onclick="$(this).parent().slideUp()" style="float: right; margin-top: 10px;display: inline-block;">Ok</span>
		
	</div>
</div>