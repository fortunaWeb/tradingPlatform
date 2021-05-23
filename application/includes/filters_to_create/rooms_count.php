<?php
if($parent!="Комната" && $parent!="Дома"){
?>
<div class="col-xs-3 deployed">
	<label class="signature">Количество комнат</label>
	<div class="btn-group medium" data-toggle="buttons">			  
	  <label class="btn btn-default <?php if($data_res['room_count'] == 1 || !$data_res['room_count']) echo "active"; ?>">
		<input type="radio" name="room_count" value="1" <?php if($data_res['room_count'] == 1 || !$data_res['room_count']) echo "checked"; ?>>1-к
	  </label>
	  <label class="btn btn-default <?php if($data_res['room_count'] == 2) echo "active"; ?>">
		<input type="radio" name="room_count" value="2" <?php if($data_res['room_count'] == 2) echo "checked"; ?>>2-к
	  </label>
	  <label class="btn btn-default <?php if($data_res['room_count'] == 3) echo "active"; ?>">
		<input type="radio" name="room_count" value="3" <?php if($data_res['room_count'] == 3) echo "checked"; ?>>3-к
	  </label>
	  <label class="btn btn-default <?php if($data_res['room_count'] == 4) echo "active"; ?>">
		<input type="radio" name="room_count" value="4" <?php if($data_res['room_count'] == 4) echo "checked"; ?>>4-к
	  </label>
	  <label class="btn btn-default <?php if($data_res['room_count'] == 5) echo "active"; ?>">
		<input type="radio" name="room_count" value="5" <?php if($data_res['room_count'] == 5) echo "checked"; ?>>5-к
	  </label>			  
	</div>	
</div> 
<?php }else{
	$room_str = $parent == "Дома" ? "Комнат в доме" : "Комнат в квартире";
?>
	<div class="col-xs-2 deployed">
		<label class="signature"><?echo $room_str;?></label>			
		<select class="form-control" name="room_count" required>
			<option value="">выберите</option>
			<option value="1" <?php if($data_res['room_count'] == "1") echo "selected"; ?>>
				1
			</option>
			<option value="2" <?php if($data_res['room_count'] == "2") echo "selected"; ?>>
				2
			</option>	
			<option value="3" <?php if($data_res['room_count'] == "3") echo "selected"; ?>>
				3
			</option>
			<option value="4" <?php if($data_res['room_count'] == "4") echo "selected"; ?>>
				4
			</option>
			<option value="5" <?php if($data_res['room_count'] == "5") echo "selected"; ?>>
				5
			</option>		
			<option value="6" <?php if($data_res['room_count'] == "6") echo "selected"; ?>>
				6
			</option>
		</select>
	</div>
<?}?>