
<?php
$parent_id = Helper::FilterVal('parent_id');
/*
if(Helper::FilterVal('action') != 'mytype') {
    ?>
    <div class="btn-group medium" data-toggle="buttons">
        <label data-id="user_id"
               onClick="window.location='/?task=main&action=index&parent_id=<?= $parent_id ?>&topic_id=2'"
               class="btn btn-default
                        <?php if ($_SESSION['search_user_id'] == "site" &&
                   $_GET['action'] != "pay_parse" && $_GET['action'] != "parse") echo "active"; ?>">

            <input type="radio" name="search_user_id"
                   value="site" <?php if ($_SESSION['search_user_id'] == "site") echo "checked"; ?>>агентства
        </label>

        <label onClick="window.location='/?task=main&action=pay_parse&parent_id=<?= $parent_id ?>&topic_id=2'"
               class="btn btn-default <?= (Helper::FilterVal('action') == "pay_parse") ? "active" : '' ?>">
            <input type="radio" <?= (Helper::FilterVal('action') == "parse_buysell") ? "checked" : '' ?>>частники
        </label>
    </div>
<?php
}
*/
?>
<div class="btn-group medium" data-toggle="buttons" style="margin-left: 1%;min-width: 70px;">
    <label onClick="HideContacts($(this))" class="btn btn-default <?php if(Helper::FilterVal('without_cont') == 1) echo "active"; ?>">
        <input type="checkbox" name="without_cont" value="1" <?php if(Helper::FilterVal('without_cont') == 1) echo "checked"; ?>>Скрыть
    </label>
</div>
<div class="btn-group medium" data-toggle="buttons" style="margin-left: 1%;">
    <label class="btn btn-default <?php if(Helper::FilterVal('photo') == 1) echo "active"; ?>">
        <input type="checkbox" name="photo" value="1" <?php if(Helper::FilterVal('photo') == 1) echo "checked"; ?>>С фото
    </label>
</div>

<div class="btn-group medium" data-toggle="buttons" style="margin-left: 1%;min-width: 70px;">
    <label class="btn btn-default <?=Helper::FilterVal('full_price') == 1?"active":''?>"
           id = 'full_price_button'   onClick = 'fullPriceClick($(this))' >
        <input type="checkbox" id="full_price"  name="full_price" value="1" <?=Helper::FilterVal('full_price') == 1? "checked":''?>> Полная сумма в договоре
    </label>
</div>

    <?php
  include "application/includes/filters_buysell/price.php";
    ?>