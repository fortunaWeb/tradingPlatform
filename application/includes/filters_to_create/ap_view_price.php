<div class="col-xs-12 deployed" <?=$_SESSION['mobile']?"style='width:240px'":""?>>
	<label class="signature">Если показываю или оформляю один:</label>
	<div class="input-group interval xl" id="view_price">
		<span class="input-group-addon" style="min-width: 37px;max-width: 37px;">
			<input type="checkbox" onClick="view_price()" <?php if($data_res['ap_view_price']) echo "checked"; ?> style="min-width: 25px; max-width: 25px;"/>
		</span>
		<span class="input-group-addon" style="padding-right: 10px;">Возьму с Вашей комиссии</span>
		<select class="form-control" name="ap_view_price" >
			<option value="0" <?php if($data_res['ap_view_price'] == '0') echo "selected"; ?> >
				0 руб.
			</option>
			<option value="500" <?php if($data_res['ap_view_price'] == '500') echo "selected"; ?> >
				500 руб.
			</option>
			<option value="1000" <?php if($data_res['ap_view_price'] == '1000') echo "selected"; ?> >
				1000 руб.
			</option>
			<option value="-1" <?php if($data_res['ap_view_price'] == '-1') echo "selected"; ?> >
				В одиночку не показываю
			</option>
		</select>
	</div>	
</div>