<?
if($_SESSION['search_user_id'] != "ngs" && $_GET['action']!="pay_parse" &&  $_GET['action']!="parse"){?>		

<div class="col-xs-1 deployed" style = 'width: <?=$_SESSION['mobile']==1?"99%;'":"auto;"?>'>

<div class="btn-group medium" data-toggle="buttons" style = 'width: 27%'>
		<input type="text" class="form-control" data-name="an-list" placeholder="агентство" value="<?if(Helper::FilterVal("company_id")!="") echo $data[0]['company_name'];?>">
		<div class="an_list" style="display: none;overflow: auto; height: 250px;"></div>
		<input type="hidden" name="company_id" value="<?if(Helper::FilterVal("company_id")!="") echo Helper::FilterVal("company_id");?>">		
</div>

	<?php
}

if($_GET['action']!="pay_parse" &&  $_GET['action']!="parse"){
?>
	<div class="btn-group medium" data-toggle="buttons" style="margin-left: 1%;min-width: 60px;">
		<label onClick="HideContacts($(this))" class="btn btn-default 
			<?php 
				if(	Helper::FilterVal('without_cont') == 1 || $_SESSION["post"]["without_cont"]==1
				) echo "active"; 
			?>">
					<input type="checkbox" name="without_cont" value="1" 
			<?php 
				if(Helper::FilterVal('without_cont') == 1 || $_SESSION["post"]["without_cont"]==1) echo "checked"; 
			?>>ВИД
		</label>
	</div>

		<div class="btn-group medium" data-toggle="buttons" style="margin-left: 1%;width: 60px">
			<label class="btn btn-default <?php if(Helper::FilterVal('photo') == 1) echo "active"; ?>">
				<input type="checkbox" name="photo" value="1" <?php if(Helper::FilterVal('photo') == 1) echo "checked"; ?>>С фото
			</label>
		</div>
</div>
<?php
if($_SESSION['buysell'] !=1 && Helper::FilterVal('task') != 'profile'){
    ?>
    <br/>
    <br/>
    <div class="btn-group medium" data-toggle="buttons" style=" width: 99%">
        <label data-id="user_id"
               onClick="window.location='/?task=main&action=index&parent_id=<?= $parent_id ?>&topic_id=<?= $topic_id ?>'"
               class="btn btn-default
					<?php if ($_GET['action'] == "index") echo "active"; ?>">
            <input type="radio" name="search_user_id" value="site"
                <?php if ($_GET['action'] == "index") echo "checked"; ?>>агентства
        </label>
        <label data-id="user_id"
               onClick="window.location='/?task=main&action=parse&parent_id=<?= $parent_id ?>&topic_id=<?= $topic_id ?>'"
               class="btn btn-default <?php if ($_GET['action'] == "parse") echo "active"; ?>">
            <input type="radio" name="search_user_id"
                   value="ngs" <?php if ($_GET['action'] == "parse") echo "checked"; ?>>частники
        </label>
        <?php
        $parent_id = Helper::FilterVal('parent_id');
        if ($topic_id % 2 != 0) {
            ?>
            <label onClick="window.location='/?task=main&action=pay_parse&parent_id=<?=$parent_id ?>&topic_id=<?= $topic_id ?>'"
                   class="btn btn-default <?php if ($_GET['action'] == "pay_parse") echo "active"; ?>">
                <input type="radio" <?php if ($_GET['action'] == "pay_parse") echo "checked"; ?>>частники 2
            </label>
        <?
        } ?>
    </div>
    <?
}
if($_SESSION['buysell'] != 1) {
    $order = Helper::FilterVal("order");
    ?>
    <div class="col-xs-2 deployed" style="width: 20%;margin-right: 5%;	margin-bottom: 1px;">
        <select class="form-control" name="order">
            <option value="date_last_edit" <?php if ($order == "date_last_edit") echo "selected"; ?>>
                по продлению
            </option>
            <option value="date_added" <?php if ($order == "date_added") echo "selected"; ?>>
                по созданию
            </option>
            <option value="while_list" <?php if ($order == "while_list") echo "selected"; ?>>
                белый список
            </option>
            <option value="status=3" <?php if ($order == "status=3") echo "selected"; ?>>
                нет в инете
            </option>
            <option value="prolong_garant" <?php if ($order == "prolong_garant") echo "selected"; ?>>
                актуальные 100%
            </option>
        </select>
    </div>
    <?php
    $hours = Helper::FilterVal("hours");
    ?>
    <div class="col-xs-1 deployed" style="width: 15%;">
        <select class="form-control" name="hours" form="main_search">
            <option value="24 hour" <?php if ($hours == "24 hour") echo "selected"; ?>>
                24ч.
            </option>
            <option value="48 hour" <?php if ($hours == "48 hour") echo "selected"; ?>>
                48ч.
            </option>
            <option value="72 hour" <?php if ($hours == "72 hour") echo "selected"; ?>>
                72ч.
            </option>
            <option value="96 hour" <?php if ($hours == "96 hour") echo "selected"; ?>>
                96ч.
            </option>
        </select>
    </div>
    <?php
    unset($hours);
    unset($order);
}
?>
</div>
<?php

}else{

?>
<div class="btn-group medium" data-toggle="buttons" style="margin-bottom: 1%;">
	<label class="btn btn-default <?php if(Helper::FilterVal('photos') == "Есть фотографии.") echo "active"; ?>"><input 
		type="checkbox" name="photos" value="1" <?php if(Helper::FilterVal('photos') == "Есть фотографии.")
			 echo "checked"; ?>>С фото</label>
</div>


<?php
    if(Helper::FilterVal('task') != 'profile') { ?>
        <div class="btn-group medium" data-toggle="buttons" style=" width: 99%">
            <label data-id="user_id"
                   onClick="window.location='/?task=main&action=index&parent_id=<?= $parent_id ?>&topic_id=<?= $topic_id ?>'"
                   class="btn btn-default
                        <?php if (
                       $_GET['action'] != "pay_parse" && $_GET['action'] != "parse") echo "active"; ?>">

                <input type="radio" name="search_user_id"
                       value="site" <?php if (
                    $_GET['action'] != "pay_parse" && $_GET['action'] != "parse") echo "checked"; ?>>агентства
            </label>
            <label data-id="user_id"
                   onClick="window.location='/?task=main&action=parse&parent_id=<?= $parent_id ?>&topic_id=<?= $topic_id ?>'"
                   class="btn btn-default
                    <?php if ($_GET['action'] == "parse") echo "active"; ?>">
                <input type="radio" name="search_user_id"
                       value="ngs" <?php if ($_GET['action'] == "parse") echo "checked"; ?>>частники
            </label>
            <?php
            if ($topic_id != 0) { ?>
                <label onClick="window.location='/?task=main&action=pay_parse&parent_id=<?= $parent_id ?>&topic_id=<?= $topic_id ?>'"
                       class="btn btn-default <?php if ($_GET['action'] == "pay_parse") echo "active"; ?>">

                    <input type="radio" <?php if ($_GET['action'] == "pay_parse") echo "checked"; ?>>частники 2
                </label>
            <? } ?>
        </div>
        <?
    }
}?>
