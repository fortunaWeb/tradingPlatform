<div class="col-xs-2 deployed">
	<label class="signature">Населенный пункт</label>
	<!--<input type="text" name="live_point" class="form-control" placeholder="Введите город" 
	value="<?php if(Helper::FilterVal('live_point')) { echo Helper::FilterVal('live_point'); }else{echo 'Сочи';} ?>">-->
	<select class="form-control" name="live_point">		
		<option value="Сочи" <?php if(Helper::FilterVal('live_point')=="Сочи" || Helper::FilterVal('live_point')=="")
		    echo "selected"; ?>>Сочи</option>

		<?
        $city = Get_functions::Get_city_list_buysell();
		$num = count($city);
		for($c=0; $c<$num; $c++)
		{
			if($city[$c]!="г. Сочи" && $city[$c]!="" && $city[$c]!="0"){
				echo "<option value='".$city[$c]."' ".((Helper::FilterVal('live_point') == $city[$c]) ? 'selected' : "").">".$city[$c]."</option>";
			}
		}
		//unset($city, $c, $num);
		?>		
	</select>
</div>