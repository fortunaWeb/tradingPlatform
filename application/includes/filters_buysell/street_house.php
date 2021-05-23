<div class="col-xs-2 deployed">
	<label class="signature">Улицы</label>
	<input type="text" id="str" name="street" class="form-control" placeholder="Улица" autocomplete="off" onKeyup="sendParseBuysellSearch()"
				value="<?php if(Helper::FilterVal('street')) {echo Helper::FilterVal('street'); } ?>">
	<div class="street_list" style="display: none;min-width: 150px !important;">	
		<span id="span-0" class="" for="street-0" onclick='removeStreet(0)' style="<?if(Helper::FilterVal('street0') != "") echo 'display: block;';?>">
			<?php echo Helper::FilterVal('street0'); ?>					
		</span>
		<input id="street-0" name="street0" type="hidden" value="<?php echo Helper::FilterVal('street0'); ?>">	
		
		<span id="span-1" class="" for="street-1" onclick='removeStreet(1)' style="<?if(Helper::FilterVal('street1')) echo 'display: block;';?>">
			<?php echo Helper::FilterVal('street1'); ?>					
		</span>
		<input id="street-1" name="street1" type="hidden" value="<?php echo Helper::FilterVal('street1'); ?>">
		
		<span id="span-2" class="" for="street-2" onclick='removeStreet(2)' style="<?if(Helper::FilterVal('street2')) echo 'display: block;';?>">
			<?php echo Helper::FilterVal('street2'); ?>					
		</span>
		<input id="street-2" name="street2" type="hidden" value="<?php echo Helper::FilterVal('street2'); ?>">
		
		<span id="span-3" class="" for="street-3" onclick='removeStreet(3)' style="<?if(Helper::FilterVal('street3')) echo 'display: block;';?>">
			<?php echo Helper::FilterVal('street3'); ?>					
		</span>
		<input id="street-3" name="street3" type="hidden" value="<?php echo Helper::FilterVal('street3'); ?>">
		
		<span id="span-4" class="" for="street-4" onclick='removeStreet(4)' style="<?if(Helper::FilterVal('street4')) echo 'display: block;';?>">
			<?php echo Helper::FilterVal('street4'); ?>					
		</span>
		<input id="street-4" name="street4" type="hidden" value="<?php echo Helper::FilterVal('street4'); ?>">
	</div>
</div>
<div class="col-xs-1 deployed">
	<input type="text" name="house" class="form-control" placeholder="Дом"  
	value="<?php if(Helper::FilterVal('house')) {echo Helper::FilterVal('house'); } ?>">
</div>