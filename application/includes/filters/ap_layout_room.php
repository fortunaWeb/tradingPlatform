<!--<div class="col-xs-2 deployed">
	<label class="signature">тип комнаты</label>
	<input type="text" class="form-control" placeholder="тип комнаты" autocomplete="off" name="type_id" value="">
	<div class="type_list" style="display: none;">
		<label class="checkbox-inline ">
		  <input type="checkbox" name="type_id1" value="48" onclick="countDis($(this))">Койко-место
		</label>
		<label class="checkbox-inline ">
		  <input type="checkbox" name="type_id2" value="49" onclick="countDis($(this))">Комната
		</label>
		<label class="checkbox-inline ">
		  <input type="checkbox" name="type_id3" value="50" onclick="countDis($(this))">Коммуналка
		</label>
		<label class="checkbox-inline ">
		  <input type="checkbox" name="type_id4" value="51" onclick="countDis($(this))">2 смежные комнаты
		</label>
		<label class="checkbox-inline ">
		  <input type="checkbox" name="type_id5" value="52" onclick="countDis($(this))">2 смежные коммуналки
		</label>
		<span class="btn btn-success" onclick="$(this).parent().slideUp()" style="float: right; margin-top: 10px;display: inline-block;">Ok</span>
	</div>
</div>
<div class="col-xs-3 deployed">
	<label class="checkbox-inline">
	  <input type="checkbox" name="type_id1" value="48"> К-м
	</label>
	<label class="checkbox-inline">
	  <input type="checkbox" name="type_id2" value="49"> Комн
	</label>
	<label class="checkbox-inline">
	  <input type="checkbox" name="type_id3" value="50"> Комм
	</label>
	<label class="checkbox-inline">
	  <input type="checkbox" name="type_id4" value="51"> 2 смеж комн
	</label>
	<label class="checkbox-inline">
	  <input type="checkbox" name="type_id5" value="52"> 2 смеж комм
	</label>
</div>
-->

<div class="col-xs-4 deployed" style="min-width: 470px !important;">
	<label class="signature">тип комнаты</label>
	<div class="btn-group medium" data-toggle="buttons"  data-id="furn_list">	
		<label class="btn btn-default <?php if(Helper::FilterVal('type_id1') == 48) echo "active"; ?>" title="Койко-место">
			<input type="checkbox" name="type_id1" value="48" <?php if(Helper::FilterVal('type_id1') == 48) echo "checked"; ?>>К-м
		</label>
		<label class="btn btn-default <?php if(Helper::FilterVal('type_id2') == 49) echo "active"; ?>" title="Комната">
			<input type="checkbox" name="type_id2" value="49" <?php if(Helper::FilterVal('type_id2') == 49) echo "checked"; ?>>Комн
		</label>
		<label class="btn btn-default <?php if(Helper::FilterVal('type_id3') == 50) echo "active"; ?>" title="Коммуналка">
			<input type="checkbox" name="type_id3" value="50" <?php if(Helper::FilterVal('type_id3') == 50) echo "checked"; ?>>Комм
		</label>
		<label class="btn btn-default <?php if(Helper::FilterVal('type_id4') == 51) echo "active"; ?>" title="2 смежные комнаты">
			<input type="checkbox" name="type_id4" value="51" <?php if(Helper::FilterVal('type_id4') == 51) echo "checked"; ?>>2 см комн
		</label>
		<?php 
		if($_SESSION['mobile']){
			?>
		</div>
		</div>
<div class="col-xs-4 deployed" style="min-width: 470px !important;">
		<div class="btn-group medium" data-toggle="buttons"  data-id="furn_list">
			<?php
		}
		?>
		<label class="btn btn-default <?php if(Helper::FilterVal('type_id5') == 52) echo "active"; ?>" title="2 смежные коммуналки">
			<input type="checkbox" name="type_id5" value="52" <?php if(Helper::FilterVal('type_id5') == 52) echo "checked"; ?>>2 см комм
		</label>
		<label class="btn btn-default <?php if(Helper::FilterVal('type_id6') == 53) echo "active"; ?>" title="общежитие коридорного типа" onClick="ApLayoutChange()">
			<input type="checkbox" name="type_id6" value="53" <?php if(Helper::FilterVal('type_id6') == 53) echo "checked"; ?>>Общ. кор.
		</label>
		<label class="btn btn-default <?php if(Helper::FilterVal('type_id7') == 54) echo "active"; ?>" title="общежитие секционного типа" onClick="ApLayoutChange()">
			<input type="checkbox" name="type_id7" value="54" <?php if(Helper::FilterVal('type_id7') == 54) echo "checked"; ?>>Общ. сек.
		</label>
	</div>	
</div>

<?if ($parent == "Комната" && !$_SESSION['mobile']){?>
	<div class="col-xs-1 deployed">			
		<label class="signature">тип</label>
		<select class="form-control" name="ap_layout" >
			<option value="">тип объекта</option>
			<option value="в квартире" <?php if(Helper::FilterVal('ap_layout') == "в квартире") echo "selected"; ?>>
				в квартире
			</option>
			<?/*<option value="в общежитии" <?php if(Helper::FilterVal('ap_layout') == "в общежитии") echo "selected"; ?>>
				в общежитии
			</option>	
			<?*/if($topic== "Аренда"){?>
				<option value="в частном доме" <?php if(Helper::FilterVal('ap_layout') == "в частном доме") echo "selected"; ?>>
					в частном доме
				</option>
				<option value="в коттедже" <?php if(Helper::FilterVal('ap_layout') == "в коттедже") echo "selected"; ?>>
					в коттедже
				</option>
			<?}?>
		</select>
	</div>
<?}?>