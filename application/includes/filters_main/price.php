<div class="col-xs-3 deployed" style ='<?=$_SESSION['mobile']==1?'width: 65%;margin-right: 20%;':''?>'>
	<label class="signature">Цена,руб.</label>
	<div class="input-group interval xl">
		<div class="btn-group medium" data-toggle="buttons" style="min-width: 340px">
			<input type="text" id="pricefrom" name="pricefrom" class="form-control" placeholder="от"  size="11" maxlength="11" aria-describedby="basic-addon1"
                   value="<?php if (Helper::FilterVal('pricefrom')) echo Helper::FilterVal('pricefrom'); ?>"
                   style="max-width: 88px;<?=$_SESSION['mobile']==1?'margin-right: 5px;':''?>">
			<input id="priceto" name="priceto" type="text" class="form-control" placeholder="до" size="11" maxlength="11"
                   value="<?php if (Helper::FilterVal('priceto')) echo Helper::FilterVal('priceto'); ?>"
                   style="max-width: 88px;">
		</div>
	</div>
</div>