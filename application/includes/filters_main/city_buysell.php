<div class="col-xs-2 deployed">
	<?php 
    	$city = Get_functions::Get_city_list($_GET['parent_id']);

	?>
	<label class="signature">Город</label>
	<select class="form-control" name="live_point">
		<option value="Сочи"
            <?php if(Helper::FilterVal('live_point')=="Сочи" || Helper::FilterVal('live_point')=="") echo "selected"; ?>
        >Сочи</option>
		<option value="Все города" <?php if(Helper::FilterVal('live_point')=="Все города") echo "selected"; ?>
        style = 'color:rgb(128, 128, 128);'>
        Все города</option>
        <?
            $num = count($city);
            for($c=0; $c<$num; $c++)
            {
                if($city[$c]!="Сочи" && $city[$c]!="" && $city[$c]!="HCO" && $city[$c]!="0"){
                    echo "<option value='".$city[$c]."' ".((Helper::FilterVal('live_point') == $city[$c]) ? 'selected' : "").">".$city[$c]."</option>";
                }
            }
            unset($city, $c, $num);
		?>		
	</select>
</div>