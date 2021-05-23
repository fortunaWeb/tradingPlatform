<div class="col-xs-4 deployed" style="min-width: 390px !important;">
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
		<label class="btn btn-default <?php if(Helper::FilterVal('type_id5') == 52) echo "active"; ?>" title="2 смежные коммуналки">
			<input type="checkbox" name="type_id5" value="52" <?php if(Helper::FilterVal('type_id5') == 52) echo "checked"; ?>>2 см комм
		</label>
		<label class="btn btn-default <?php if(Helper::FilterVal('type_id6') == 53) echo "active"; ?>" title="общежитие" onClick="ApLayoutChange()">
			<input type="checkbox" name="type_id6" value="53" <?php if(Helper::FilterVal('type_id6') == 53) echo "checked"; ?>>Общеж
		</label>
	</div>	
</div>
<?if ($parent == "Комната"){?>
	<div class="col-xs-1 deployed">			
		<label class="signature">тип объекта</label>
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