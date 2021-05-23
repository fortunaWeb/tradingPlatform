<?if ($parent == "Квартиры" || $parent == "Дома" || $parent == "Новостройки"){?>
	<div class="col-xs-1 deployed" style="min-width: 110px !important;">
		<label class="signature">Пл.общая</label>
		<div class="input-group interval">
			<input type="text" id="sq_allfrom" name="sq_allfrom" class="form-control" placeholder="от"  size="3" maxlength="3" value="<?php if(Helper::FilterVal('sq_allfrom')) {echo Helper::FilterVal('sq_allfrom'); } ?>">
			<input type="text" id="sq_allto" name="sq_allto" class="form-control" placeholder="до" size="3" maxlength="3" value="<?php if(Helper::FilterVal('sq_allto')) {echo Helper::FilterVal('sq_allto'); } ?>">	
		</div>
	</div>
	<div class="col-xs-1 deployed" style="min-width: 110px !important;">
		<label class="signature">Пл.жилая</label>
		<div class="input-group interval">
			<input type="text" id="sq_livefrom" name="sq_livefrom" class="form-control" placeholder="от"  size="3" maxlength="3" value="<?php if(Helper::FilterVal('sq_livefrom')) {echo Helper::FilterVal('sq_livefrom'); } ?>">
			<input type="text" id="sq_liveto" name="sq_liveto" class="form-control" placeholder="до" size="3" maxlength="3" value="<?php if(Helper::FilterVal('sq_liveto')) {echo Helper::FilterVal('sq_liveto'); } ?>">	
		</div>
	</div>
	<div class="col-xs-1 deployed" style="min-width: 110px !important;">
		<label class="signature">Пл.кухня</label>
		<div class="input-group interval">
			<input type="text" id="sq_kfrom" name="sq_kfrom" class="form-control" placeholder="от"  size="3" maxlength="3"  value="<?php if(Helper::FilterVal('sq_kfrom')) {echo Helper::FilterVal('sq_kfrom'); } ?>">
			<input type="text" id="sq_kto" name="sq_kto" class="form-control" placeholder="до" size="3" maxlength="3" value="<?php if(Helper::FilterVal('sq_kto')) {echo Helper::FilterVal('sq_kto'); } ?>">	
		</div>
	</div>
<?}else if($parent == "Комната" || $parent == "Гаражи" || $parent == "Коммерческая"){?>
	<div class="col-xs-1 deployed" style="min-width: 110px !important;">
		<label class="signature">Площадь</label>
		<div class="input-group interval">
			<input type="text" id="sq_livefrom" name="sq_livefrom" class="form-control" placeholder="от"  size="3" maxlength="3" value="<?php if(Helper::FilterVal('sq_livefrom')) {echo Helper::FilterVal('sq_livefrom'); } ?>">
			<input type="text" id="sq_liveto" name="sq_liveto" class="form-control" placeholder="до" size="3" maxlength="3" value="<?php if(Helper::FilterVal('sq_liveto')) {echo Helper::FilterVal('sq_liveto'); } ?>">	
		</div>
	</div>
<?}else if($parent == "Земля" || $parent == "Дома"){?>
	<div class="col-xs-1 deployed" style="min-width: 110px !important;">
		<label class="signature">Пл.участка</label>
		<div class="input-group interval">
			<input type="text" id="sq_landfrom" name="sq_landfrom" class="form-control" placeholder="от"  size="3" maxlength="3" value="<?php if(Helper::FilterVal('sq_landfrom')) {echo Helper::FilterVal('sq_landfrom'); } ?>">
			<input type="text" id="sq_landto" name="sq_landto" class="form-control" placeholder="до" size="3" maxlength="3" value="<?php if(Helper::FilterVal('sq_landto')) {echo Helper::FilterVal('sq_landto'); } ?>">	
		</div>
	</div>
<?}else{?>
	<div class="col-xs-1 deployed" style="min-width: 110px !important;">
		<label class="signature">Пл.дома</label>
		<div class="input-group interval">
			<input type="text" id="sq_livefrom" name="sq_livefrom" class="form-control" placeholder="от"  size="3" maxlength="3" value="<?php if(Helper::FilterVal('sq_livefrom')) {echo Helper::FilterVal('sq_livefrom'); } ?>">
			<input type="text" id="sq_liveto" name="sq_liveto" class="form-control" placeholder="до" size="3" maxlength="3" value="<?php if(Helper::FilterVal('sq_liveto')) {echo Helper::FilterVal('sq_liveto'); } ?>">	
		</div>
	</div>
	<div class="col-xs-1 deployed" style="min-width: 110px !important;">
		<label class="signature">Пл.участка</label>
		<div class="input-group interval">
			<input type="text" id="sq_landfrom" name="sq_landfrom" class="form-control" placeholder="от"  size="3" maxlength="3" value="<?php if(Helper::FilterVal('sq_landfrom')) {echo Helper::FilterVal('sq_landfrom'); } ?>">
			<input type="text" id="sq_landto" name="sq_landto" class="form-control" placeholder="до" size="3" maxlength="3" value="<?php if(Helper::FilterVal('sq_landto')) {echo Helper::FilterVal('sq_landto'); } ?>">	
		</div>
	</div>
<?}?>