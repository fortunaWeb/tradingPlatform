<script type="text/javascript">
	$(function(){
		var reviewCount = $(".hasReview").length;
		ReviewCountShow(reviewCount);
		$(".hasReview").on("click", function(){
			if(reviewCount < $(".hasReview").length){
				reviewCount = $(".hasReview").length;
				ReviewCountShow(reviewCount);
			}
		});
		if(QueryString("active")==0){
			var colCount = $(".dateCol").length;
			ColCountShow(colCount);
			$(".dateCol").on("click", function(){
				if(colCount < $(".dateCol").length){
					colCount = $(".dateCol").length;
					ColCountShow(colCount);
				}
			});
		}
	})
	
	function ReviewCountShow(count){
		if(count>0){
			var id = $(".hasReview").attr("id");
			$(".btn-group-justified.count label.active").append("<span class='badge' style='background-color: #E81010;' title='колличество вариантов с отзывами'>"+count+"</span>");
			if(confirm("У Вас есть отзыв на вариант. Показать данный вариант?")){
				$('html,body').stop().animate({	scrollTop: $("#"+id+"").offset().top-100}, 1000);
			}
		}
	}
	
	function ClearFavorites(table){
		alertify.confirm("Очистить избранное", function(result){
			if (result) {
				jQuery.ajax({
				type: 'POST',
				url: '?task=profile&action=clear_favorites',
				data: 'table=' +table, 
					success: function(html) {
						alertify.alert("Удалено "+ html + ' вариантов избанного.');
						window.location.reload();
					}
				});	
			}	
		});
	}

	function ColCountShow(count){
		if(count>0){
			var id = $(".dateCol").attr("id");
			$(".btn-group-justified.count label.active").append("<span class='badge' data-id='date_col' style='background-color: #0F919E;' title='колличество вариантов для прозвона'>"+count+"</span>");
			if(confirm("У Вас есть вариант требуемый прозвона. Показать данный вариант?")){
				$('html,body').stop().animate({	scrollTop: $("#"+id+"").offset().top-100}, 1000);
			}
		}
	}
</script>

<?php
	if($_GET["action"] != "recipients" && $_GET["action"] != "sample"){
		include_once 'application/includes/search.php';
	}
	include_once "application/includes/filters/my_type_buttons.php";
	if (isset($data[0]["topic_id"])){
		if($_GET["active"] == 1){
			$title = "МОИ ОБЪЕКТЫ, АКТИВНЫЕ ПО АРЕНДЕ: ";
		}else if($_GET["action"] == "favorites"){
			$title = "МОИ ОБЪЕКТЫ, ИЗБРАННЫЕ ПО АРЕНДЕ: ";
		}else{
			$title = "МОИ ОБЪЕКТЫ, АРХИВНЫЕ ПО АРЕНДЕ: ";			
		}
		switch ($_GET["parent_id"]){
			case "all":
				$title .= "ВСЕ-ОБЩИЙ СПИСОК";
				break;
			case "1":
				$title .= "КВАРТИРЫ";
				break;
			case "18":
				$title .= "КОМНАТЫ";
				break;
			case "2":
				$title .= "НОВОСТРОЙКИ";
				break;
			case "3":
				$title .= "КОТТЕДЖИ-ДОМА";
				break;
			case "4":
				$title .= "ДАЧИ";
				break;
			case "5":
				$title .= "ГАРАЖИ/ПАРКОВКИ";
				break;
			case "6":
				$title .= "КОММЕРЧЕСКАЯ";
				break;
			case "7":
				$title .= "ЗЕМЛЯ";
				break;
		}
	?>
		<div class="row products-list">		
			<h4 class="center" style="margin-bottom: 30px;">
			</h4>
			<?php if($_GET['action'] == "mytype" && $_GET['active'] == 1 &&  Helper::FilterVal('copyright') != 1){?>
				<div class="col-xs-12" data-id="control-buttons" style="position: absolute;z-index: 2;margin-top: -<?=$_SESSION['mobile']?'55':'30'?>px;">
					<div class="checkbox" style="display: inline-block; <?=$_SESSION['mobile']?'margin-top: 30px;':''?>">
						<label>
							<input data-id="checkAll" type="checkbox" value="" >
							<font style = 'color:#5cb85c; font-size:16px; font-weight:bold'>Выделить все</font>
						</label>
					</div>
					<?php
					$modalDialogText = 'Продлить ? ';
					if(isset($_SESSION['first_prolong']) && $_SESSION['first_prolong']){
						$modalDialogText = "Статус ВСЕХ вариантов будет изменён на «Не гарантирую актуальность варианта, выясняю это в момент обращения»! ";
					}
					?>
					<button type="button" onclick="VarExtend('checked','<?=$modalDialogText?>')" 
						style="display:none; <?=$_SESSION['mobile']?'background-color:red':''?>" class="btn btn-default btn-xs extend">Продлить</button>
				</div>
			<?
			}

			if(($_GET['action'] =="favorites" || $_GET['action'] =="favorites_parse") ){
                ?>
                    <div class="checkbox" style="display: inline-block; <?=$_SESSION['mobile']?'margin-top: 30px;':''?>; margin-left: 80%;">
                        <label>
                            <font style = 'color:#5cb85c; font-size:16px; font-weight:bold'
                                  onClick="ClearFavorites('<?=Helper::FilterVal('action')?>')"
                                    class= 'clear_favorites'>Очистить избранное</font>
                        </label>
                    </div>
                <?
			}
            if(Helper::FilterVal('action') =="mytype"){
                include 'application/includes/pagination.php';
            }
            if($_GET['action']!="favorites_parse"){
				if($_SESSION['mobile']){
						include "application/includes/product_compact_mobile.php";
					}else{
						include "application/includes/product_compact.php";		
					}			
			}else if($_SESSION["sell_date_end"] > date("Y-m-d")){
				include "application/includes/product_pay_parse.php";
			}else{
                include "application/includes/product_pay_parse.php";
//				if($_SESSION['parent']==0){
//					echo "<div class='row center products-list'><span>Ваша оплата данного раздела закончилась. Вам необходимо продлить 'частники 2' <a href='?task=profile&action=services'>в личном кабинете</a>.</span></div>";
//
//				}else{
//					echo "<div class='row center products-list'><span>Ваша оплата данного раздела закончилась. Вам необходимо продлить 'частники 2' в личном кабинете директора.</span></div>";
//				}
			}
			?>
		</div>
<?php }else{
		if($_GET["action"] != "recipients"  && $_GET["action"] != "sample" ){

		echo '<div id="row">
				<p>У вас пока, что не иммется вариантов данного типа.</p>
			</div>';
		}
		if($_GET["action"] == "recipients" ){
		
			include "application/includes/recipients.php";
		}

		if($_GET["action"] == "sample"){
			include "application/includes/sample.php";	
		}

	}
	echo "<script src='js/yandex_new.js' type='text/javascript'></script>";
	echo Helper::Modal_win_find_address();
	echo Helper::Modal_win_clean();
	echo Helper::Modal_win_send_review();
	echo Helper::Modal_win_send_sample();	
	echo Helper::Modal_win_add_to_black_list();
?>



		