<div class="col-xs-2 deployed">
	<label class="signature">Предоплата за</label>					
	<select class="form-control" name="prepayment" id="prepayment" required>						
		<?for ($i=1; $i<=12; $i++){
			$prepayment = $data_res['prepayment'] == $i ? "selected" : "";
			echo "<option value='".$i."' ".$prepayment.">".$i." мес.</option>";
		}?>	
	</select>
</div>