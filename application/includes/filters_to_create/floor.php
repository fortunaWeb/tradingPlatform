<?if($parent!="Дома"){?>
<div class="col-xs-2 deployed">			
	<label class="signature">Этаж/этажность</label>		
	<div class="input-group interval" style='width:100%'>		
		<select id="floor" name="floor" class="form-control" required>
			<option value=''>этаж</option>
			<option value='ср' <?=($data_res['floor']=="ср" ? 'selected' : '')?>>ср</option>
			<?for($i=1; $i<28; $i++){
				$selected = $data_res['floor']==$i ? 'selected' : '';
				echo "<option value='{$i}' {$selected}>{$i}</option>";
			}?>
		</select>
		<select name="floor_count" class="form-control" required>
			<option value=''>этажность</option>
			<?for($i=1; $i<29; $i++){
				$selected = $data_res['floor_count']==$i ? 'selected' : '';
				echo "<option value='{$i}' {$selected}>{$i}</option>";
			}?>
		</select>	
	</div>
</div>	
<?}else{?>
<div class="col-xs-1 deployed">
	<label class="signature">Этажность</label>			
	<select class="form-control" name="floor_count" required>		
		<option value="1" <?php if($data_res['floor_count'] == "1" || !isset($data_res['floor_count'])) echo "selected"; ?>>
			1
		</option>
		<option value="2" <?php if($data_res['floor_count'] == "2") echo "selected"; ?>>
			2
		</option>	
		<option value="3" <?php if($data_res['floor_count'] == "3") echo "selected"; ?>>
			3
		</option>
		<option value="4" <?php if($data_res['floor_count'] == "4") echo "selected"; ?>>
			4
		</option>		
	</select>
</div>
<?}?>