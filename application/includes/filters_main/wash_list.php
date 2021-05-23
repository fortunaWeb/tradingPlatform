<div class="col-xs-2 deployed">
	<label class="signature">Мыться</label>
	<input type="text" class="form-control" placeholder="Мыться" autocomplete="off" name="wash" type="text" 
			value="<?php if(Helper::FilterVal('wash')) {echo Helper::FilterVal('wash'); } ?>">
	<div class="wash_list">
		<label class="checkbox-inline <?php if (Helper::FilterVal('wash1')) echo 'active'; ?>">

		  <input type="checkbox" name="wash1" value="Баня" onClick="countAttrType($(this),'wash')" 
		  	<?php if (Helper::FilterVal('wash1')) echo 'checked="checked"'; ?>>Баня
		</label>
<br/>
		<label class="checkbox-inline <?php if (Helper::FilterVal('wash2')) echo 'active'; ?>">

		  <input type="checkbox" name="wash2" value="Душ" onClick="countAttrType($(this),'wash')" 
		  	<?php if (Helper::FilterVal('wash2')) echo 'checked="checked"'; ?>>Душ
		</label>
	<br/>
		<label class="checkbox-inline <?php if (Helper::FilterVal('wash3')) echo 'active'; ?>">

		  <input type="checkbox" name="wash3" value="Негде" onClick="countAttrType($(this),'wash')" 
		  	<?php if (Helper::FilterVal('wash3')) echo 'checked="checked"'; ?>>Негде
		</label>
		</label>
		<br/>

		<span data-id="all" class="btn btn-success" onclick="countAttrType('all','wash')" style="margin : 10px 5px 0 0px; display: inline-block;">Все</span>
		<span class="btn btn-success" onclick="$(this).parent().slideUp()" style=" margin-top: 10px;display: inline-block;">Ok</span>
	
	</div>
</div>