<div class="col-xs-2 deployed">			
	<div class="btn-group medium" data-toggle="buttons">			  
	  <label class="btn btn-default <?php if($data_res['rent_type'] == 'месяц' || !$data_res['rent_type']) echo "active"; ?>">
		<input type="radio" name="rent_type" value="месяц" <?php if($data_res['rent_type'] || !$data_res['rent_type'] == 'месяц') echo "checked"; ?>>длительно
	  </label>
	  <?if ($parent == "Дома" || $parent == "Квартиры" || $parent == "Комната"){?>
		  <label class="btn btn-default <?php if($data_res['rent_type'] == 'сутки') echo "active"; ?>">
			<input type="radio" name="rent_type" value="сутки" <?php if($data_res['rent_type'] == 'сутки') echo "checked"; ?>>сутки
		  </label>			  		 		  
	  <?}?>
	</div>	
</div> 