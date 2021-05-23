<?
if ($data[0]['count'] > 0){

	if($_GET["action"]=="parse_buysell") {
		include 'application/includes/pagination_parse_buysell.php';
	}

    echo Helper::Modal_win_send_sample();

    echo "<script src='js/yandex_new.js' type='text/javascript'></script>";
	echo "<div class='row products-list' style='margin-bottom: -45px;' data-topic='".(isset($_GET['topic_id']) ? $_GET['topic_id'] : "")."' data-parent='".(isset($_GET['parent_id']) ? $_GET['parent_id'] : "")."'>";	
	if(Helper::FilterVal('view_type') == "map_buysell"){
			echo "<div id='map' style='width: 100%; height: 500px;'></div>";
		$num = count($data);
		$str="";		
		for ($mc=0; $mc<$num; $mc++){
			$str.=$data[$mc]['coords'].",".$data[$mc]['id'].";";
		}		
		echo "<input type='hidden' data-id='coords' value='".$str."'>";
		unset($mc, $str, $num);
	}else if($_GET['action']=="parse_buysell"){
		echo "<div class='row col-xs-12' style='color: rgb(205, 24, 24);font-weight: bold;'>";
        $message = DB::Select("text", "re_messages", "spec_recipient='all' ORDER BY date_send DESC limit 1");
		echo isset($message[0]) ? $message[0]['text']:'';
		echo "</div>";
		include "application/includes/product_pay_parse_buysell.php";
		echo Helper::Modal_win_find_address();
		echo Helper::Modal_win_clean();
		echo Helper::Modal_win_send_review();
		echo Helper::Modal_win_add_to_black_list();
	}
	echo "</div><div id='spacer' class='spacer-bottom'></div>";
	
	if($_GET["action"]=="parse_buysell"){
		include 'application/includes/pagination_parse_buysell.php';
	}
	
}else if(date("Y-m-d", strtotime($_SESSION['sell_date_end'])) < date("Y-m-d") ){
echo "<div class='row center products-list'>
		<span>Для отображения вариантов по продаже необходимо произвести оплату.</span>
		</div>";
}else if(
	($_SESSION["tariff_id"] != '1' OR 
		($_SESSION['topic_id'] != '1' && $_SESSION['topic_id'] != '3')) 
	AND (date("Y-m-d", strtotime($_SESSION['sell_date_end'])) > date("Y-m-d") OR ($_SESSION['topic_id'] != '2' && $_SESSION['topic_id'] != '4')) OR $_SESSION['search_user_id'] == "site")
{
	echo "<div class='row center products-list'><span>По данным параметрам вариантов не найдено. Попробуйте увеличить радиус поиска.</span></div>";
}else if($_SESSION["tariff_id"] != '1' OR ($_SESSION['topic_id'] != '1' && $_SESSION['topic_id'] != '3')){
	echo "<div class='row center products-list'><span>По вашему тарифу доступ к частникам по продаже закрыт. Доступ можно получить, оплатив его в личном кобинете АН у директора.</span></div>";
}else{
	echo "<div class='row center products-list'><span>По вашему тарифу доступ к частникам по аренде закрыт.</span></div>";
}

//echo print_r(new DateTime()->format('YY-mm-dd H:m'));
?>


