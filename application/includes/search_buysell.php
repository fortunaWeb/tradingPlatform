<?php 
$condition = ($_SESSION['group_topic_id'] == 3 AND $_SESSION['user'] != 'guest');
$url = "?task=main&action=index";

$post_uri = $url."&parent_id=".$parent_id."&topic_id=2";
$mytype_page = false;
$url = "?task=buysell&action=parse_buysell";

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
	if(val != "Новосибирск" && val != "НСО" && val != ""){
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

		<ul class="nav nav-tabs" style="width:100%">
			<?if($mytype_page){?>
				<li class="<?php if($parent == "Все") echo 'active';?>">
					<a href="<?echo $url."&parent_id=all";if(isset($topic)) echo '&topic_id='. $topic_id; ?>">
						Все
					</a>
				</li>	
			<?}?>
			<li class="<?php if($parent == "Квартиры") echo 'active';?>">
				<a href="<?echo $url."&parent_id=1";if(isset($topic)) echo '&topic_id='. $topic_id; ?>">
					Квартиры
					<?/*if($mytype_page)echo "<span class='badge' style=' margin-right: -15px;'>".Get_functions::Get_var_count($_SESSION['user'], $topic_id, 1, 1)."</span>";*/?>
				</a>
			</li>
			
			<li class="<?php if($parent == "Комната") echo 'active';?>">
				<a href="<?echo $url."&parent_id=18";if(isset($topic)) echo '&topic_id='. $topic_id; ?>">
					Комнаты
				</a>
			</li>

			
			<li class="<?php if($parent=="Дома") echo 'active'; ?>">
				<a href="<?echo $url."&parent_id=3";if(isset($topic)) echo '&topic_id='. $topic_id; ?>">
					Дома
				</a>
			</li>
			<?php 
			if($_SESSION['mobile'] !=1){
			?>
				<li class="<?php if($parent=="Коммерческая") echo 'active'; ?>">
					<a href="<?echo $url."&parent_id=7";if(isset($topic)) echo '&topic_id='. $topic_id; ?>">
						Коммерческая
					</a>
				</li>
				
				<li class="<?php if($parent=="Земля") echo 'active'; ?>">
					<a href="<?echo $url."&parent_id=5";if(isset($topic)) echo '&topic_id='. $topic_id; ?>">
						Земля
					</a>
				</li>
	  
	  		<?php
	  		}
			?>
		</ul>
	</div>

	 
	<div class="search" id="search">
		<?php

			if($_SESSION['mobile'] ){
					include "application/search_templates/parse.php";
			}else{
				include "application/search_templates/pay_parse_buysell.php";
			}
		?>	
	</div>
</div>