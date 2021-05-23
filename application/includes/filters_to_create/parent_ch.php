<?php
    $url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $parentId = Helper::FilterVal('parent_id');
    $url = current(explode('&parent_id',$url));
?>
<div class="col-xs-4 deployed">
    <label class="btn btn-default <?=$parentId==18 ? 'active':''?>"
            onclick="location.href='<?=$url .'&parent_id=18'?>';">
            Комната
    </label>
    <label class="btn btn-default <?=$parentId==1 ? 'active':''?>"
           onclick="location.href='<?=$url .'&parent_id=1'?>';">
         Квартира
    </label>
</div>