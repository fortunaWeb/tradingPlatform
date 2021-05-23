<div class="col-xs-1 deployed" style = 'margin-right: <?=$_SESSION['mobile']==1?"auto;'":"auto;"?>'>
    <label class="signature">Планировка</label>
    <input  class="form-control" placeholder="Планировка" autocomplete="off" name="planning" type="text"
           value="<?php if(Helper::FilterVal('planning')) {echo Helper::FilterVal('planning'); } ?>">
    <div class="planning_list">
        <label class="checkbox-inline <?php if (Helper::FilterVal('planning1')) echo 'active'; ?>">
            <input type="checkbox" name="planning1" value="изолированная" onClick="countValueList('planning',$(this))" <?php if (Helper::FilterVal('planning1')) echo 'checked="checked"'; ?>>Изолированная
        </label>
        <label class="checkbox-inline <?php if (Helper::FilterVal('planning2')) echo 'active'; ?>">
            <input type="checkbox" name="planning2" value="смежная" onClick="countValueList('planning',$(this))" <?php if (Helper::FilterVal('planning2')) echo 'checked="checked"'; ?>>Смежная
        </label>
        <label class="checkbox-inline <?php if (Helper::FilterVal('planning3')) echo 'active'; ?>">
            <input type="checkbox" name="planning3" value="см-изолированная" onClick="countValueList('planning',$(this))" <?php if (Helper::FilterVal('planning3')) echo 'checked="checked"'; ?>>cм-изолир
        </label>
        <label class="checkbox-inline <?php if (Helper::FilterVal('planning4')) echo 'active'; ?>">
            <input type="checkbox" name="planning4" value="студия" onClick="countValueList('planning',$(this))" <?php if (Helper::FilterVal('planning4')) echo 'checked="checked"'; ?>>Студия
        </label>
        <span data-id="all" class="btn btn-success" onclick="countValueList('planning','all')" style="float: left; margin-top: 10px;display: inline-block;">Выбрать всех</span>
        <span class="btn btn-success" onclick="$(this).parent().slideUp()" style="float: right; margin-top: 10px;display: inline-block;">Ok</span>
    </div>
</div>