<div class="col-xs-2 deployed" style='min-width: 130px !important; max-width: 130px;'>
	<label class="signature">Кого берут</label>	
	<input type="hidden" class="form-control" name="residents" value="<?php echo $data_res['residents']; ?>" required>
	<div class="form-control" style="cursor:pointer; padding:2px; overflow:hidden;" id="residents">
		<span class="placeholderSpan">выберите</span>
	</div>
	<div class="residents_list"> 
		<span data-id="1" onClick="residentAdd(1)">Студ</span>
		<span data-id="2" onClick="residentAdd(2)">Нер</span>
		<span data-id="3" onClick="residentAdd(3)">Сп</span>
		<span data-id="4" onClick="residentAdd(4)">Сп*р</span>
		<span data-id="5" onClick="residentAdd(5)">Жив</span>
		<span data-id="6" onClick="residentAdd(6)">Ж*р</span>
		<span data-id="7" onClick="residentAdd(7)">1м</span>
		<span data-id="8" onClick="residentAdd(8)">1ж</span>
		<span data-id="9" onClick="residentAdd(9)">2м</span>
		<span data-id="10" onClick="residentAdd(10)">2ж</span>
		<span data-id="11" onClick="residentAdd(11)">субаренда</span>
<!--		<span data-id="all" class="btn btn-success" onClick="residentAdd('all')" style="float: left; margin-top: 10px;display: inline-block;">Всех</span> -->
		<span class="btn btn-success" onclick="$('.residents_list').slideUp()" style="float: right; margin-top: 10px;display: inline-block;">Ok</span>
	</div>
</div>
<?if($parent=="Комната"){?>
	<div class="col-xs-2 deployed">
		<label class="signature">Кто проживает</label>	
		<input type="text" class="form-control" name="owner" placeholder="кто проживает" value="<?php echo $data_res['owner']; ?>" required>
	</div>
<?}?>
