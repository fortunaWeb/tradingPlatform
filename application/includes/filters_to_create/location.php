<?php
$districtId = $data_res['dis'];
$district = Helper::getDisById($districtId);
?>
<div class="col-xs-2 deployed">
	<label class="signature">Населеный пункт</label>
	<input type="text" id="live_point" name="live_point" class="form-control" placeholder="Населеный пункт" autocomplete="off"
           value="Сочи" required readonly>
</div>
<div class="col-xs-2 deployed">
	<input type="text" class="form-control" id="dis" placeholder="Район"
           onClick="if($('.district_list_to_add').css('display') == 'none'){$('.district_list_to_add').slideDown();}"
           name="dis" type="text" autocomplete="off"  value="<?=isset($district['district'])?$district['district']:''?>"
           style="cursor: pointer;background-color: #FFF;"  readonly required >
	<div class="district_list_to_add" style="display:none">
		<?=Helper::getDistricts()?>
	</div>
</div>
<div class="col-xs-2 deployed">
    <input type="text" class="form-control" id="sub_dis" placeholder="Микрорайон"
           onClick="if($('.subdistrict_list_to_add').css('display') == 'none'){$('.subdistrict_list_to_add').slideDown();}"
           name="sub_dis" type="text" autocomplete="off"  value="<?=isset($district['name'])?$district['name']:''?>"
           style="cursor: pointer;background-color: #FFF;"  readonly required >
    <div class="subdistrict_list_to_add" id = 'subdistrict_list_to_add' style="display:none">
        <?=isset($district['district'])?Helper::getSubDistricts($district['district']):''?>
    </div>
</div>
<input type="hidden" name = 'districtId' value='<?=$district['id']?>'>
<div class="col-xs-2 deployed">
	<input type="text" id="str" name="street" class="form-control" placeholder="Улица" autocomplete="off" <?if($_GET["parent_id"]!=6 && $_GET["parent_id"]!=4)echo "required";?> 
	value="<?=isset($data_res['street'])?$data_res['street']:''?>">
	<div class="street_list" style="display: none;"></div>
</div>
<?php 	if($_GET["parent_id"]!=5){?>
    <div class="col-xs-1 deployed">
        <input type="text" name="house" class="form-control" placeholder="Дом"  onKeyPress="return check_number(event);"
            value="<?=!empty($data_res['house'])?$data_res['house']:''?>"
            <?=($_GET["parent_id"]!=6 && $_GET["parent_id"]!=4 && $_GET["parent_id"]!=3)?"required":''?>
        >
    </div>
<?}?>
