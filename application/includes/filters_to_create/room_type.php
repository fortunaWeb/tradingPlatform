<div class="col-xs-2 deployed" <?=($data['type_id'] ==50) ? "style = 'display:none;'":""?>>	
	<label class="signature">Тип объекта</label>			
	<select class="form-control" name="ap_layout" <?=($data['type_id'] !=50) ? "required":""?>>
		<option value="">выберите тип</option>
		<option value="в квартире" <?php if($data_res['ap_layout'] == "в квартире") echo "selected"; ?>>
			в квартире
		</option>
		<?/*<option value="в общежитии" <?php if($data_res['ap_layout'] == "в общежитии") echo "selected"; ?>>
			в общежитии
		</option>	
		<?*/if($topic == "Аренда"){?>
			<option value="в частном доме" <?php if($data_res['ap_layout'] == "в частном доме") echo "selected"; ?>>
				в частном доме
			</option>
			<option value="в коттедже" <?php if($data_res['ap_layout'] == "в коттедже") echo "selected"; ?>>
				в коттедже
			</option>	
		<?}?>		
	</select>
</div>