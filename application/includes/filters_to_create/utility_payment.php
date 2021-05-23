<div class="col-xs-4 deployed">
	<label class="signature">За свет и воду</label>					
	<select class="form-control" name="utility_payment" id="utility_payment" required>
		<option value="платить дополнительно" <?php if($data_res['utility_payment'] == 'платить дополнительно') echo "selected"; ?> >
			Платить дополнительно
		</option>			
		<option value="оплата включена в цену" <?php if($data_res['utility_payment'] == 'оплата включена в цену') echo "selected"; ?> >
			Оплата включена в цену
		</option>
		<option value="дополнительно только за воду" <?php if($data_res['utility_payment'] == 'дополнительно только за воду') echo "selected"; ?> >
			Дополнительно только за воду
		</option>
		<option value="дополнительно только за свет" <?php if($data_res['utility_payment'] == 'дополнительно только за свет') echo "selected"; ?> >
			Дополнительно только за свет
		</option>						
	</select>
</div>			