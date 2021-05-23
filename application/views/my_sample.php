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
	<div class="row products-list">		
		<h4 class="center" style="margin-bottom: 30px;">
			<?=$title?>
		</h4>
		<?php
		$dataVars = [];
		$dataParse = [];
        $dataPayParseBuysell = [];
		foreach ($data as $key => $value) {
			if(isset($data[$key]['date_added_format'])){
				$dataVars[$key] = $value;
			}else{
				$dataParse[$key] = $value;
			}
		}
		$data = $dataVars;
		if($_SESSION['mobile']){
				include "application/includes/product_compact_mobile.php";
			}else{
				include "application/includes/product_compact.php";
			}

		$data = $dataParse;
		if($_SESSION['mobile']){
			include "application/includes/product_pay_parse_mobile.php";
		}else{
			include "application/includes/product_pay_parse.php";
		}

		$data = $dataPayParseBuysell;
		if($_SESSION['buysell']){
            include "application/includes/product_pay_parse_buysell.php";
        }

		?>
	</div>
<?php 
	echo "<script src='js/yandex_new.js' type='text/javascript'></script>";
	echo Helper::Modal_win_find_address();
	echo Helper::Modal_win_clean();
	echo Helper::Modal_win_send_review();
	echo Helper::Modal_win_add_to_black_list();
	echo Helper::Modal_win_send_sample();
?>



		