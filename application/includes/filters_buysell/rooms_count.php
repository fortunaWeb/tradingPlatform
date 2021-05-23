<?$rc = Helper::FilterVal('room_count');?>
<div class="col-xs-2 deployed">
	<label class="signature">Всего комнат в квартире</label>
	<select class="form-control" name="room_count">			
		<option value="">не важно</option>
		<option value="2" <?php if($rc == "2") echo "selected"; ?>>
			не более 2
		</option>
		<option value="3" <?php if($rc == "3") echo "selected"; ?>>
			не более 3
		</option>	
		<option value="4" <?php if($rc == "4") echo "selected"; ?>>
			не более 4
		</option>	
		<option value="5" <?php if($rc == "5") echo "selected"; ?>>
			не более 5
		</option>				
	</select>
</div>