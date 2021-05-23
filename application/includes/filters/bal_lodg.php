<?$val_bal = Helper::FilterVal('val_bal');?>
<?$val_lodg = Helper::FilterVal('val_lodg');?>
<div class="col-xs-1 deployed" style="min-width: 110px !important;">
	<label class="signature">Бал2. | лодж.</label>
	<div class="input-group interval">
		<input type="text" id="val_bal" name="val_bal"  class="form-control" placeholder="кол."
               value="<?php if($val_bal) {echo $val_bal; } ?>">

		<input type="text" id="val_lodg" name="val_lodg"  class="form-control" placeholder="кол."
               value="<?php if($val_lodg) {echo $val_lodg; } ?>">
	</div>
</div>
<?unset($val_bal);?>
<?unset($val_lodg);?>