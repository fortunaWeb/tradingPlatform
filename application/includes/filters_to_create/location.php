<div class="col-xs-2 deployed">
	<label class="signature">Населеный пункт</label>
	<input type="text" id="live_point" name="live_point" class="form-control" placeholder="Населеный пункт" autocomplete="off" value="<? if($data_res['live_point']) {echo $data_res['live_point']; }else{echo "Новосибирск";} ?>" onClick="$(this).val('')" required>
	<div class="live_point_list" style="display: none;"></div>
</div>
<div class="col-xs-2 deployed">
	<input type="text" class="form-control" id="dis" placeholder="Район" onClick="if($('.district_list_to_add').css('display') == 'none'){$('.district_list_to_add').slideDown();}"  name="dis" type="text" autocomplete="off"  value="<?php if($data_res['dis']) {echo $data_res['dis']; } ?>" style="cursor: pointer;background-color: #FFF;"  readonly required >
	<div class="district_list_to_add" style="display:none">
		<span>Дзержинский</span>
		<span>Железнодорожный</span>
		<span>Заельцовский</span>
		<span>Калининский</span>
		<span>Кировский</span>
		<span>Ленинский</span>
		<span>Октябрьский</span>
		<span>Первомайский</span>
		<span>Советский</span>
		<span>Центральный</span>							
	</div>
</div>
<div class="col-xs-2 deployed">
	<input type="text" id="str" name="street" class="form-control" placeholder="Улица" autocomplete="off" <?if($_GET["parent_id"]!=6 && $_GET["parent_id"]!=4)echo "required";?> 
	value="<?php if($data_res['street']) {echo $data_res['street']; } ?>">
	<div class="street_list" style="display: none;"></div>
</div>
<?php
	if($_GET["parent_id"]!=5){
/*

		var live_p = $('[name=live_point]').val();
		strt = $('[name=street]').val();
		hse = $('[name=house]').val();
			if(confirm('Рабочий e-mail ?')){		
				$.ajax({
					type: 'POST',
					url: '?task=profile&action=coord_by_address',
					data: 'live_point='+live_p+ '&street='+strt +'&house='+hse
				});	
			}	
/**/


	?>
<div class="col-xs-1 deployed">
	<input type="text" name="house" class="form-control" placeholder="Дом"  onKeyPress="return check_number(event);"
	value="<?php if($data_res['house']) {echo $data_res['house']; } ?>" <?if($_GET["parent_id"]!=6 && $_GET["parent_id"]!=4 && $_GET["parent_id"]!=3)echo "required";?>>
</div>

<?}?>
<div class="col-xs-2 deployed">
	<input type="text" name="orientir" class="form-control" placeholder="Ориентир"  
	 value="<?php if($data_res['orientir']) {echo $data_res['orientir']; } ?>" <?if($_GET["parent_id"]==6 || $_GET["parent_id"]==5 || $_GET["parent_id"]==4)echo "required";?>>
</div>
<!--<div class="col-xs-2 deployed">
	<input type="button" class="form-control btn btn-yellow" data_res-toggle="modal" data_res-target="#modal-win" name="map" value="Область карты">
</div>-->