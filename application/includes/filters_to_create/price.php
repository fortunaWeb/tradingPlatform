<?$label = $topic == "Аренда" ? "Цена объекта не более" : "Цена";?>
<div class="col-xs-2 deployed">
	<label class="signature"><?echo $label;?></label>	
	<input id="price" placeholder="<?echo $label;?>" name="price" type="text"
           class="form-control" value="<?php if ($data_res['price']) echo $data_res['price']; ?>" required/>
</div>