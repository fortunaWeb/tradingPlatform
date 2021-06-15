<?php 
$condition = ($_SESSION['group_topic_id'] == 3 AND $_SESSION['user'] != 'guest');
$url = "?task=main&action=index";
//$post_uri = "?task=main&action=search";
$post_uri = $url."&parent_id=".$parent_id."&topic_id=".$topic_id;
$copyright = Helper::FilterVal('copyright')?:0;
$mytype_page = false;
if($_GET['task'] == "profile")
{
	$active = isset($_GET['active']) ? "&active=".$_GET['active'] : "";	
	$url = "?task=profile&action=".$_GET['action'].$active;
	if($_GET['active']==1){
		$url.="&limit=all";
	}
	$post_uri = $_SERVER["REQUEST_URI"];
	$mytype_page = true;
	$parent = $_GET['parent_id']=="" ? "Все" : $parent;
}else if($_GET['action'] == "pay_parse"){
	$url = "?task=main&action=pay_parse";
}else if($_GET['action'] == "parse"){
	$url = "?task=main&action=parse";
}
$url .= "&copyright=".$copyright;
/*if($condition){?>	
	<script type="text/javascript">
		$(function(){	
			var hiddenMenuButton = $(".secondary_menu .nav-pills li:hidden");	
			var liActive = $(".secondary_menu .nav-pills li.active");
			var forHover = $("div[data-id=forHover]");
			$(forHover).hover(function(){
				$(liActive).hide();	
				$(hiddenMenuButton).show();					
			});				
			$(forHover).mouseout(function(){	
				$(liActive).show();	
				$(hiddenMenuButton).hide();
			});
			$(forHover).on("click", function(){
				window.location = $(".secondary_menu .nav-pills li:visible a").attr("href");
			})
		})
	</script>
<?}*/
if($_SESSION['mobile']){  ?>
<style >
.col-xs-4 {
    width: 40%;
}
.col-xs-2.deployed {
min-width: 100px !important;
}
.col-xs-3.deployed {
    width: 195px;
}
.col-xs-1.deployed {
    min-width: 72px !important;
}

.pagination_row{
	padding: 0px;	
	max-height: 100px;
	height: unset;
}

div .deployed{

	padding-left: 2px;	
	padding-right: 2px;	
}
.search .row div {
    min-width: 50px;
}
.pagination_row .input-group select {
    width: 60px;
}

span.slide-top {
    left: 1px;
}


</style>
<?php } ?>

<script type="text/javascript">
	$(function(){
		GeoUpdate($("[name=live_point]").val());
		$(".nav-tabs li.active a").click(function(e){
			e.preventDefault();
			var link = $(this).attr("href");
			$.post("?task=main&action=refresh", function(){
				window.location = link;
			});
		});
		$("[name=live_point]").change(function(){
			GeoUpdate($(this).val());			
		})
	});

function GeoUpdate(val){
	if(val != "Сочи" && val != "НСО" && val != ""){
		$("[name=dis]").val("");
		$(".district_list :checkbox").each(function(){
			$(this).prop("checked", "");
			$(this).parent().removeClass("active");
		});
		$(".district_list").parent().hide();
		$(".street_list").parent().show();
		$("[name=house]").parent().show();
	}else if(val == "НСО" || val == ""){
		$("[name=dis]").val("");
		$("[name=street]").val("");
		$(".district_list :checkbox").each(function(){
			$(this).prop("checked", "");
			$(this).parent().removeClass("active");
		});
		$(".district_list").parent().hide();
		$(".street_list input").each(function(){
			$(this).val("");
		});
		$(".street_list").parent().hide();
		$("[name=house]").val("").parent().hide();
	}else{
		$(".street_list").parent().show();
		$(".district_list").parent().show();
		$("[name=house]").parent().show();
	}
}
</script>
<div class="row" style="margin-top: -15px;margin-bottom: -10px;display: block;width: 100%;margin-left: auto;">
	<div class="secondary_menu" style="overflow: hidden;">
		<!--<?php if($condition) { ?>	
			<div data-id="forHover" style="width: 95px;height: 45px;position: absolute; z-index: 99; cursor:pointer"></div>
			<ul class="nav nav-pills">	
				<li id="label-main-vkrent" 
					class="<?php if (($topic == "Аренда") OR !isset($topic)) echo 'active'; ?>" >
					<a href="<?echo $url."&topic_id=1&parent_id=1";?>">Аренда</a>
				</li>
				<li id="label-main-vksell" 
					class="<?php if ($topic == "Продажа") echo 'active'; ?>" >
					<a href="<?echo $url."&topic_id=2&parent_id=1";?>">Продажа</a>
				</li>
			</ul>
		<?}?>-->
		<ul class="nav nav-tabs" style="width:100%">
			<?if($mytype_page){?>
				<li class="<?php if($parent == "Все") echo 'active';?>">
                    <a href="<?=$url."&parent_id=all".((isset($topic))? '&topic_id='. $topic_id : '')?>">Все</a>
				</li>
			<?}?>
			<li class="<?=($parent == "Квартиры")?'active':''?>">
				<a href="<?=$url."&parent_id=1".((isset($topic))? '&topic_id='. $topic_id : '')?>">Квартиры</a>
			</li>
			<li class="<?=($parent == "Комната")?'active':''?>">
				<a href="<?=$url."&parent_id=18".((isset($topic))?'&topic_id='. $topic_id:'')?>">Комнаты</a>
			</li>
			<li class="<?=($parent=="Дома")?'active':''?>">
				<a href="<?=$url."&parent_id=3".((isset($topic))?'&topic_id='. $topic_id:'')?>">Дома</a>
			</li>
            <li class="<?=($parent=="Коммерческая")?'active':''?>">
                <a href="<?=$url."&parent_id=7".((isset($topic))?'&topic_id='. $topic_id:'')?>">Коммерческая</a>
            </li>
            <li class="<?=($parent=="Земля")?'active':''?>">
                <a href="<?=$url."&parent_id=5".((isset($topic))?'&topic_id='. $topic_id:'')?>">Земля</a>
            </li>
		</ul>
	</div>

	 
	<div class="search" id="search">
		<?php
			if($_SESSION['mobile'] ){
				$topic = "Аренда";
				 if($_GET['action']=='parse' ||$_GET['action']=='pay_parse' ){
						include "application/search_templates/parse.php";			
				 }else{
					include "application/search_templates/mobile.php";	
				}

			}else if($_GET['action']=='pay_parse' || $_GET['action']=='favorites_pay_parse'){
				include "application/search_templates/pay_parse.php";
			}else if($_GET['action']=='parse' || $_GET['action']=='favorites_parse'){
				include "application/search_templates/parse.php";			
			}else{
				include "application/search_templates/buysell.php";
			}
		?>	
	</div>
</div>