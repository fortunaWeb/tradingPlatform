<div class="col-xs-2 deployed">
	<label class="signature">Комиссия не менее</label>					
	<select class="form-control" name="commission" id="commission" required>
		<?
		$maxComission = 70;
		$i =  50;	
		if($parent == "Комната") $maxComission = 100;	
		
		for ($i; $i<=$maxComission; $i=$i+5){
			$commission = $data_res['commission'] == $i ? "selected" : "";
			echo "<option value='".$i."' ".$commission.">".$i."%</option>";
		}
		?>	
	</select>
</div>