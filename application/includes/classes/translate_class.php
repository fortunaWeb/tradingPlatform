<?php //translate_class.php
Class Translate
{
	const MYSQL_DATE_TIME = "Y-m-d H:i:s";
	const MYSQL_DATE = "Y-m-d";
	static function listPhotosMobile($data)
	{
		$photosList = '';

		foreach ($data as $key => $value) {
			if(file_exists($_SERVER['DOCUMENT_ROOT']."/images/{$value['people_id']}/{$value['var_id']}/{$value['photo']}")){
				$photosList.=
				"<br/><br/><img src='images/{$value['people_id']}/{$value['var_id']}/{$value['photo']}' style='width:100%;'>";
			}
		}
	

		echo $photosList."<br/>
			<a title='есть фото' onclick = '". 
				"showFotosMobile({$value['var_id']})'
				 class='pull-left' href='#table-{$value['var_id']}'>
					<img class='media-object' src='images/zenit_mobile.png' 
					style='padding: 2px; border: 1px solid silver;'>
			</a>								
								";
		return $photosList;

	}
	
	static function listPhotosPayParseMobile($dir, $var_id, $ngs)
	{
		$photosList = '';

		if(!file_exists($dir))
			return null;
		$dh = opendir($dir);

		while (false !== ($file = readdir($dh))) {   
			if($file != "." && $file!="..") 
    		$photosList.=
				"<br/><br/><img src='images/{$ngs}parse/{$var_id}/{$file}' style='width:100%;'>";
		}
		echo $photosList."<br/>
			<a title='есть фото' onclick = '". 
				"showFotosMobile({$var_id})'
				 class='pull-left' href='#table-{$var_id}'>
					<img class='media-object' src='images/zenit_mobile.png' 
					style='padding: 2px; border: 1px solid silver;'>
			</a>";
			unset($dir,$ngs,$dh,$var_id);/**/
		return $photosList;

}


	static function translate_input($input) {
		switch($input) {
			case 'password':
				$input = "Пароль";
				break;
			case 'fio':
				$input = "ФИО";
				break;
			case 'email':
				$input = "Email";
				break;
			case 'group_id':
				$input = "Группа";
				break;
			case 'phone':
				$input = "Контактный телефон";
				break;
			case 'site':
				$input = "Представительский сайт";
				break;
			case 'icq':
				$input = "ICQ";
				break;
		}
		return $input;
	}	
	
	static function month_ru($date)
	{
		$datetime_arr = explode(" ", $date);
				$date_arr = explode("/", $datetime_arr[0]);
				// $month_r = array( 
					// "01" => "Января", 
					// "02" => "Февраля", 
					// "03" => "Марта", 
					// "04" => "Апреля", 
					// "05" => "Мая", 
					// "06" => "Июня", 
					// "07" => "Июля", 
					// "08" => "Августа", 
					// "09" => "Сентября", 
					// "10" => "Октября", 
					// "11" => "Ноября", 
					// "12" => "Декабря"); 
				$date = $date_arr[0].".".$date_arr[1].".".$date_arr[2]." ".$datetime_arr[1];
		return $date;
	}	
	
	static function Estate_type($topic, $parent){
		if($topic == 1 || $topic == 3)
		{
			$topic = "Аренда";
		}else{
			$topic = "Продажа";
		}

		switch($parent) {
			case '1':
				$parent = "Квартиры";
				break;
			case '2':
				$parent = "Новостройки";
				break;
			case '3':
				$parent = "Дома";
				break;
			case '4':
				$parent = "Дачи";
				break;
			case '5':
				$parent = "Земля";
				break;
			case '6':
				$parent = "Гаражи";
				break;		
			case '7':
				$parent = "Коммерческая";
				break;			
			case '18':
				$parent = "Комната";
				break;
            case '8':
                $parent = "ЖП";
                break;
            case 'all':
				$parent = "Все";
				break;				
		}
		return $topic." ".$parent;
	}
	
	static function Var_title($type_id, $topic_id, $parent_id, $room_count, $planning, $ap_layout, $deliv_period){
		if($type_id >= 19 && $type_id <= 24){
			$type_name = ($type_id-18) ."-комнатную";
		}else if($type_id == 0){
			$type_name = $room_count."-комнатную";
		}else if($type_id > 24){
			$type_name = DB::Select("`name`", "re_type_object", "`id`='".$type_id."'")[0]['name'];
			if($type_id > 24 && $type_id < 30 && $room_count >0){
				$type_name.="/".$room_count." ком.";
			}
		}
		if($planning != ""){
			if($planning != "студия"){
				$planning = preg_replace("/.{4}$/", 'ую', $planning);
			}else{
				$planning = "студию";
			}
		}		
		if($type_id != 18){
			switch($parent_id) {
				case '1':
					$parent_name = "квартиру";
					break;
				case '2':
					$parent_name = "новостройку";
					break;		
				case '3':
					$parent_name = "раздел (коттеджи/дома)";
					break;
				case '4':
					$parent_name = "дачу";
					break;
				case '5':
					$parent_name = "землю";
					break;
				case '6':
					$parent_name = "гараж";
					break;		
				case '7':
					$parent_name = "раздел (коммерческая)";
					break;			
				case '18':
					$parent_name = "комнату";
					break;
			}
		}else{
			$parent_name = "комнату";
		}
		switch ($topic_id){
			case '1':
				$topic_name = "Сдам";
				break;
			case '2':
				$topic_name = "Продам";
				break;
			case '3':
				$topic_name = "Сниму";
				break;
			case '4':
				$topic_name = "Куплю";
				break;
		}
		$topic_name = "<span class='gray'>".$topic_name.": </span>";
		
		if($deliv_period > 0 && $deliv_period < 13){
			$deliv_period_str = " (на ".$deliv_period." мес.)";
		}else if($deliv_period > 12){
			switch ($deliv_period)
			{
				case '13':
					$deliv_period_str = " (лето)";
					break;
				case '14':
					$deliv_period_str = " (длит)";
					break;
				case '15':
					$deliv_period_str = " (на продаже)";
					break;
			}
		}
		$deliv_period_str = " <span class='gray'>".$deliv_period_str."</span>";
		
		if($parent_id == 6){
			if($type_name == "Капитальный" || $type_name == "Металлический"){
				$ap_layout.=" гараж";
			}
		}


		if($parent_name != "квартиру" && $parent_name != "новостройку"){
			if($parent_name == "комнату" && $_SESSION['search_user_id'] == "ngs" && $_GET['task']!="profile"){
				$title = $topic_name."<span style='display: inline-block;text-transform: uppercase;'>".strtolower($parent_name)." ".strtolower($ap_layout).$deliv_period_str."</span>";
			}else{
				$title = $topic_name."<span style='display: inline-block;text-transform: uppercase;'>".
                    strtolower($type_name=="Дача"
                        ? 'Lfxe!!!'
//                        $parent_id == '30'
//                            ? 'Участок с домиком'
//                            : 'Садовый участок2'
                        : $type_name
                    ).
                    ($parent_name == "комнату" ? ", " : " ").strtolower($ap_layout).$deliv_period_str."</span>";
			}
		}else{
			$title = $topic_name."<span style='display: inline-block;text-transform: uppercase;'>".strtolower($type_name).", ".strtolower($planning).$deliv_period_str."</span>";
		}
		
		return $title;
	}
	


	static function Var_title_buysell($type_id, $topic_id, $room_count, $planning, $dis,
										 $street, $house, $ap_layout, $parent_id, $city, $new_house = null, $action=false){
		$new_house = '';
		if($action){
			if($type_id==18){
				$type_name = "комнату";
			}else if($type_id==1){
				$type_name = $room_count."-комн.";
			}else if($type_id==3){
				$type_name = "Дом";
			}
		}else{
			if($type_id >= 19 && $type_id <= 24){
				$type_name = ($type_id-18) ."-ком.";
			}else if($type_id == 0){
				$type_name = $room_count."-ком.";
			}else if($type_id > 24){
				$type_name = DB::Select("`name_short`", "re_type_object", "`id`='".$type_id."'")[0]['name_short'];
				if($type_id > 24 && $type_id < 30 && $room_count >0){
					$type_name.="/".$room_count." комн.";
				}
			}else{
				$type_name = "комн.";
			}
		}
/**/		
		if($planning != ""){
			if($planning != "студия"){
				$pl_arr = explode(" ", $planning);
				if(count($pl_arr) == 2){
					$planning = substr($pl_arr[0], 0, 2).substr($pl_arr[1], 0, 2)." * ";
				}else if($planning == "см-изолированная"){
					$planning = "см-из * ";
				}
				else{
					//$planning = preg_replace("/.{4}$/", 'ую', $planning);
					$planning = substr($planning, 0, 4)." * ";
				}
			}else{
				$planning = "студ * ";
			}
		}
		switch ($topic_id){
			case '1':
				$topic_name = "Продам";
				break;
			case '3':
				$topic_name = "Куплю";
				break;
		}
		
		if($dis == "Железнодорожный"){
			$dis = "Ж/Д";
		}else if($dis == "Дзержинский"){
			$dis = substr($dis, 0, 4);			
		}else{
			$dis = substr($dis, 0, 6);
		}
		
		
		
		if($ap_layout=="в квартире"){
			$ap_layout = "в кв";
		}else if($ap_layout=="в общежитии"){
			$ap_layout = "в общ";
		}else if($ap_layout=="в частном доме"){
			$ap_layout = "в ч/д";
		}else if($ap_layout=="в коттедже"){
			$ap_layout = "в кот";
		}
		
		if($parent_id == 2 )
		{
			$new_house = "новостройку";
		}

		if($parent_id == 6){
			if($type_name == "кап" || $type_name == "мет"){
				$ap_layout.=" гараж";
			}
		}
		$topic_name = "<span style='color: #476bc6;font-size: 14px;font-weight: bold;'>{$topic_name} {$new_house}: </span>";
		$street = str_replace('"', '', $street);
		$house = str_replace('"', '', $house);

		$dis = $city!="Сочи" ? $city : $dis;

		if($parent_id == 18){
			$title ="{$topic_name}<span style='font-weight: normal;'> ".strtolower($type_name) /*." {$ap_layout} * ".strtolower($planning)." {$dis} */ .". {$city}, {$street} {$house}  </span>";
		}else{
			$title ="{$topic_name}<span style='font-weight: normal;'>    ".strtolower($type_name) /*." * ".strtolower($planning).*/.". {$city}, {$street} {$house}  </span>";
		}

		return $title;
	}



	static function getTypeRoomByTypeId($type_id){
		if(empty($type_id))return '';
		$typeStr = '';
		switch ($type_id) { 
			case 48:
				$typeStr = 'К-м.';
				break;
			case 49:
				$typeStr = 'Комн.';
				break;
			case 50:
				$typeStr = 'Комм.';
				break;
			case 51:
				$typeStr = '2 см комн.';
				break;
			case 52:
				$typeStr = '2 см комм.';
				break;
			case 53:
				$typeStr = 'Общ. кор. ';
				break;
			case 54:
				$typeStr = 'Общ. сек. ';
				break;
			default:
				$typeStr = 'Ком.';
				break;
		}
		return strtolower($typeStr)."";
	}

	static function getTypeHouseByTypeId($type_id){
		if(empty($type_id))return '';
		$typeStr = '';
		switch ($type_id) { 
			case 25:
				$typeStr = 'К-м.';
				break;
			case 26:
				$typeStr = 'Комн.';
				break;
			case 27:
				$typeStr = 'Комм.';
				break;
			case 28:
				$typeStr = '2 см комн.';
				break;
			case 52:
				$typeStr = '2 см комм.';
				break;
			case 53:
				$typeStr = 'Общ.';
				break;
			default:
				$typeStr = 'Ком.';
				break;
		}
		return $typeStr;
	}

	static function getFullDistrict($districtId)
    {
        $district = DB::Select('*','sub_districts', "`id` = '$districtId'")[0];
        return  "<span>р-н. {$district['district']}</span>, <span>м-н. {$district['name']}</span>";
    }


	static function districtAbbr($district)
    {
		if(empty($district))
		    return '';

		switch ($district) {
			case 'Дзержинский':
                return 'Дзж.';
			case 'Железнодорожный':
                return 'Жд.';
			case 'Заельцовский':
                return 'Злц.';
			case 'Калининский':
                return 'Клн.';
			case 'Кировский':
                return 'Кир.';
			case 'Ленинский':
                return 'Лен.';
			case 'Октябрьский':
                return 'Окт.';
			case 'Первомайский':
                return 'Прв.';
			case 'Советский':
                return 'Сов.';
			case 'Центральный':
                return 'Цен.';
		}
		return "";
	}

    static function districtAbbrBack($str)
    {
        switch ($str){
            case 'Окт':
                return 'Октябрьский';
            case 'Дзж':
                return 'Дзержинский';
            case 'Клн':
                return 'Калининский';
            case 'Кир':
                return 'Кировский';
            case 'Жд':
                return 'Железнодорожный';
            case 'Цен':
                return 'Центральный';
            case 'Прв':
                return 'Первомайский';
            case 'Лен':
                return 'Ленинский';
            case 'Злц':
                return 'Заельцовский';
            case 'Сов':
                return 'Советский';
        }
        return '';
    }


	static function planingAbbr($planing, $action = null){
		if(
			empty($planing) ||
			(
				!empty($action)  && ($action == 'parse' || $action ==  'pay_parse')
			)
		){
			return '';	
		} 
		$planingStr = '';
			switch ($planing) {
				case 'см-изолированная':
					$planingStr = 'см-из';
					break;
				case 'изолированная':
					$planingStr = 'из';
					break;
				case 'смежная':
					$planingStr = 'см';
					break;
				case 'студия':
					$planingStr = 'студ';
					break;
				default:
					$planingStr = $planing;
					break;
			}
		return strtolower($planingStr).',';
	}

	static function getTopicName($topic_id){
		if(empty($topic_id))return '';
		return "<span style='color: #476bc6;font-size: 14px;font-weight: bold;'>".self::getTopicNameValue($topic_id).": </span>";
	}

    static function landStatusMapping($value)
    {
        switch ($value){
            case 'rent':
                $landStatus = "Аренда";
                break;
            case 'own':
                $landStatus  = 'Собственность';
            default :
                $landStatus  = "";
                break;
        }
        return $landStatus;
    }


	static function repairMapping($value)
    {

        switch ($value){
            case 'CLEAR':
                $repair = "Чистовой";
                break;
            case 'ROUGH':
                $repair = "Черновой";
                break;
            case 'RMT':
                $repair = "РМТ";
                break;
            default :
                $repair = "";
                break;
        }
        return $repair;
    }
	static function creditBankMapping($value)
    {
        switch ($value){
            case 'SBER':
                $credit_bank = "Сбер";
                break;
            case 'VTB':
                $credit_bank = "ВТБ";
                break;
            case 'OTHER':
                $credit_bank = "остальные";
                break;
            default :
                $credit_bank = "";
                break;
        }
        return $credit_bank;
    }

	static function getTopicNameValue($topic_id){
		if(empty($topic_id))return '';
		switch ($topic_id){
			case '1':
				$topicName = "Продам";
				break;
			case '2':
				$topicName = "Продам";
				break;
            default :
                $topicName = "";
                break;
		}
		return "{$topicName}";
	}


	static function getApLayoutAbbr($ap_layout, $parent_id = null, $type_name = null){
		if(empty($ap_layout))return '';
		$apLayoutAbbr = '';
		if($parent_id == 6){
			if($type_name == "кап" || $type_name == "мет"){
				return $ap_layout.=" гараж";
			}
		}
		switch ($ap_layout) {
			case 'в квартире':
				$apLayoutAbbr = "в кв";
				break;
			case 'в общежитии':
				$apLayoutAbbr = "в общ";
				break;
			case 'в частном доме':
				$apLayoutAbbr = "в ч/д";
				break;
			case 'в коттедже':
				$apLayoutAbbr = "в кот";
				break;		
			default:
				$apLayoutAbbr = '';
				break;
		}
		return $apLayoutAbbr;
	}

	static function getAreaString($district, $city, $action = null){
		$area = $city.",";
		if($city == "Сочи"){
			$area = $district;
		}
		return $area;
	}

	static function Var_title_retro_mobile($type_id, $topic_id, $room_count, $planning, $dis, $street, $house, $ap_layout, $parent_id, $city, $action=false)
	{
		if($action){
			if($type_id==18){
				$type_name = "комнату";
			}else if($type_id==1){
				$type_name = $room_count." комн";
			}else if($type_id==3){
				$type_name = "Дом";
			}
		}else{
			if($type_id >= 19 && $type_id <= 24){
				$type_name = ($type_id-18) ."-комн";
			}else if($type_id == 0){
				$type_name = $room_count."-комн";
			}else if($type_id > 24){
				
				$type_name = DB::Select("`name_short`", "re_type_object", "`id`='".$type_id."'")[0]['name_short'];

				if($type_id > 24 && $type_id < 30 && $room_count >0){
					$type_name.=" - ".$room_count." комн";
				}
			}else{
				$type_name = "";
			}
		}
		
		$topicName = self::getTopicName($topic_id);
		$planningAbbr = self::planingAbbr($planning,  $_GET['action']);
		$dis = self::districtAbbr($dis);
		$apLayoutAbbr =  self::getApLayoutAbbr($ap_layout);
		$area = self::getAreaString($dis, $city, $_GET['action']);

        $rooms = $room_count>0?"/{$room_count}":'';
		if($parent_id == '18'){					
			$title ="{$topicName}: 
				<span style='font-weight: normal;'> ".self::getTypeRoomByTypeId($type_id).$rooms
							." {$apLayoutAbbr} " . $planningAbbr . " {$area}
							 </span><br/><span style='font-weight: normal;'> {$street} {$house}  </span>
				<span style='display:none'> ".self::getTypeRoomByTypeId($type_id)." {$apLayoutAbbr} {$planning} {$area} {$street} {$house} </span>";
		}else{
			$title ="{$topicName}: 
				<span style='font-weight: normal;'>".strtolower($type_name).".   " . $planningAbbr . " {$area} 
				</span><br/><span style='font-weight: normal;'> {$street} {$house} </span>
				<span style='display:none'>".strtolower($type_name).".   " . $planning . " {$area} {$street} {$house} </span>";
			}
			
		return $title;
	}

    /**
     * type_id = parent_id
     */
	static function Var_title_retro($type_id, $topic_id, $room_count, $planning,
            $dis, $street, $house, $ap_layout, $parent_id, $city,$app_status,$app_type,
            $action=false, $varId = null
    ){
		if($action){
			if($type_id==18){
				$type_name = "комнату";
			}else if($type_id==1){
				$type_name = $room_count." комн.";
			}else if($type_id==3){
				$type_name = "Дом";
			}else if($type_id==7){
				$type_name = "Помещение";
			}else if($type_id==5){
				$type_name = "Земля";
			}
		}else{
			if($type_id >= 19 && $type_id <= 24){
				$type_name = ($type_id-18) ."-комн.";
			}else if($type_id == 0){
				$type_name = $room_count."-комн.";
			}else if($type_id == 1){
				$type_name = $room_count."-комн.";
			}else if($type_id == 3){
				$type_name = "Дом";
			}else if($type_id == 4){
				$type_name = "Дом";
			}else if($type_id == 5){
				$type_name = "Земля";
			}else if($type_id == 7){
				$type_name = "Помещение";
			}else if($type_id > 24){
				
				$type_name = DB::Select("`name_short`", "re_type_object", "`id`='".$type_id."'")[0]['name_short'];

				if($type_id > 24 && $type_id < 30 && $room_count >0){
					$type_name.=" - ".$room_count." комн.";
				}
			}else{
				$type_name = "";
			}
		}

		$actionGet = isset($_GET['action']) ? $_GET['action'] : 'index';

		switch ($app_type){
            case 'flat':
                $appType = 'кв.';
                break;

            case 'ls':
                $appType = 'жп.';
                break;
            case 'appartment':
                $appType = 'ап.';
                break;
            default:
                $appType = 'ап.';
                break;
        }

		$topicName = self::getTopicName($topic_id);
		$planningAbbr = self::planingAbbr($planning,  $actionGet);

		$apLayoutAbbr =  self::getApLayoutAbbr($ap_layout);
		$area = self::getFullDistrict($dis);

		$rooms = $room_count>0?"/{$room_count}":'';
        $address = (null === $varId)
            ? " $area, ул. $street $house"
            : "<span class = 'address_to_change' data-id ='$varId' > $area ул. $street $house</span>";
        $title = '';

		if($parent_id == '18'){
			$title ="$topicName 
				<span style='font-weight: normal;'> ".self::getTypeRoomByTypeId($type_id). $rooms
							." {$apLayoutAbbr} " . $planningAbbr . " {$area} {$street} {$house} </span>

		<span style='display:none'> ".self::getTypeRoomByTypeId($type_id)
							." {$apLayoutAbbr} " . $planning . " {$address} </span>
							";
		}else{
			$title ="{$topicName}<span style='font-weight: normal;'>".strtolower($type_name).",$appType, план $planningAbbr
                $address </span>
				<span style='display:none'>".strtolower($type_name).".   " . $planning . " {$area} {$street} {$house} </span>
				";
		}


		return $title;
	}



    static  function getParseBuysellOrigins()
    {
        return  DB::Select("DISTINCT origin", "re_pay_parse", "origin !=''");
    }


	static function getUtilityPaymentTelegram($utility_payment){
		switch ($utility_payment)
		{
			case 'платить дополнительно':
				return  " + ВОДА СВЕТ";
			case 'оплата включена в цену':
				return "ВСЕ ВКЛЮЧЕНО";
			case 'дополнительно только за воду':
				return "+ ВОДА";
			case 'дополнительно только за свет':
				return  "+ СВЕТ";
		}
	}

	static public function getPayParseIcons()
    {
        return $icon = [
            "ngs.ru" => "/images/icon/source/ngs.ico",
            "avito.ru" => "/images/icon/source/avito.ico",
            "domofond.ru" => "/images/icon/source/domofond.ico",
            "vk.com" => "/images/icon/source/vk.com.ico",
            "irr.ru" => "/images/icon/source/irr.ico",
            "cian.ru" => "/images/icon/source/cian.ico",
            "reforum.ru" => "/images/icon/source/reforum.ru.ico",
            "russianrealty.ru" => "/images/icon/source/russianrealty.ico",
            "dmir.ru" => "/images/icon/source/dmir.ru.ico",
            "realty.yandex.ru" => "/images/icon/source/ya.ico",
            "n-s-k.net" => "/images/icon/source/n-s-k.net.png",
            "nn-baza.ru" => "/images/icon/source/nn-baza.ru.ico",
            "kvadroom.ru" => "/images/icon/source/kvadroom.ico",
            "do.ru" => "/images/icon/source/do.ru.ico",
            "realty.mail.ru" => "/images/icon/source/mail.ru.ico",
            "dorus.ru" => "/images/icon/source/dorus.ru.ico",
            //"mirkvartir.ru" => "/images/icon/source/mirkvartir.ico",
            "move.su" => "/images/icon/source/move.su.ico",
            "move.ru" => "/images/icon/source/move.ico",
            "domex.ru" => "/images/icon/source/domex.ru.ico",
            "nndv.ru" => "/images/icon/source/nndv.ru.ico",
            "net-agenta.ru" => "/images/icon/source/net-agenta.ru.ico",
            "rosrealt.ru" => "/images/icon/source/rosrealt.ru.ico",
            "barahla.net" => "/images/icon/source/barahla.net.ico",
            "egent.ru" => "/images/icon/source/egent.ru.ico",
            "sibdomo.ru" => "/images/icon/source/sibdomo.ru.gif",
            "mynedv.ru" => "/images/icon/source/mynedv.ru.ico",
            "mlsn.ru" => "/images/icon/source/mlsn.gif",
            "kvadrat54.ru" => "/images/icon/source/kvadrat54.ru.ico",
            "n1.ru" => "/images/icon/source/novosibirskN1.ico",
            "youla.io" => "/images/icon/source/youla.ico",
            "youla.ru" => "/images/icon/source/youla.ico",
            "multilisting.su" => "/images/icon/source/multilisting.ico",
        ];
    }

	static function getFurnListTelegram($furn, $tv, $washing, $refrig){
		$furnList = '';
		$furnList .= ($furn ==0) ?"м- ":"м+ ";
		$furnList .= ($tv ==0) ?"tv- ":"tv+ ";
		$furnList .= ($washing ==0) ?"ст- ":"ст+ ";
		$furnList .= ($refrig ==0) ?"х- ":"х+ ";
		return $furnList;
	}
	static function getFurnListTelegramMobile($furn, $tv, $washing, $refrig){
		$furnList = '';
		$furnList .= ($furn ==0) ?"- ":"+ ";
		$furnList .= ($tv ==0) ?"- ":"+ ";
		$furnList .= ($washing ==0) ?"- ":"+ ";
		$furnList .= ($refrig ==0) ?"- ":"+ ";
		return $furnList;
	}

	static function getViewDateText($view_date, $race_date)
	{
		if(isset($view_date) && isset($race_date)){
			if(date("Y-m-d", strtotime($race_date)) < date("Y-m-d")){
				return "Смотреть и заезжать сегодня!";
			}else{
				return  "Смотреть c :".date("d.m", strtotime($view_date))."
				заезд c : ".date("d.m", strtotime($race_date))."";
			}
		}

	}

	static function getDelivPeriodText($deliv_period)
	{
		$deliv_period_str = '';
		switch ($deliv_period)
		{
			case '13':
				$deliv_period_str = "Лето";
				break;
			case '14':
				$deliv_period_str = "Длительно";
				break;
			case '15':
				$deliv_period_str = "На продаже";
				break;
			case '16':
				$deliv_period_str = "Сутки";
				break;
		}

		return "".$deliv_period_str;
	}

	static function getFloorText($floor, $floor_count)
	{
		$floorText =  "Этажность: ";
				if($floor) $floorText.=$floor;
				if($floor_count) $floorText.="/".$floor_count;

		return $floorText;
	}

	static function getSquareText($sq_all,$sq_live, $sq_k)
	{
		$squareText = ' пл:';
		if($sq_all){$squareText .= $sq_all."/";}else{$squareText .= "-/";}
		if($sq_live){$squareText .= $sq_live."/";}else{$squareText .= "-/";}
		if($sq_k){$squareText .= $sq_k;}else{$squareText .= "-";}
		return $squareText;
	}


	static function Var_title_Telegram(
			$type_id, $topic_id, $room_count, 
			$planning, $dis, $street, $house, $ap_layout, $parent_id, $city, 
			$price, $utility_payment, $furn, $tv, $washing, $refrig,
			$ap_race_date, $ap_view_date, $deliv_period, $residents, 
			$floor, $floor_count,$sq_all,$sq_live, $sq_k, $repayment,
			$action=false
		)	{
		if($action){
			if($type_id==18){
				$type_name = "комнату";
			}else if($type_id==1){
				$type_name = $room_count." комн";
			}else if($type_id==3){
				$type_name = "Дом";
			}
		}else{
			if($type_id >= 19 && $type_id <= 24){
				$type_name = ($type_id-18) ."-комн";
			}else if($type_id == 0){
				$type_name = $room_count."-комн";
			}else if($type_id > 24){
				
				$type_name = DB::Select("`name_short`", "re_type_object", "`id`='".$type_id."'")[0]['name_short'];

				if($type_id > 24 && $type_id < 30 && $room_count >0){
					$type_name.=" - ".$room_count." комн";
				}
			}else{
				$type_name = "";
			}
		}
		
		$topicName = self::getTopicNameValue($topic_id);
		$planningAbbr = self::planingAbbr($planning,  $_GET['action']);
		$apLayoutAbbr =  self::getApLayoutAbbr($ap_layout).". ";
		$area = self::getAreaString($dis, $city, $_GET['action']);

		if($parent_id == '18'){					
			$title = 
				self::getTopicNameValue($topic_id) . " " .
				strtolower(self::getTypeRoomByTypeId($type_id)). " " .
				" ". $area ." ". $price . "/".$repayment. 
				$street ." " . $house . " " .
				self::getFurnListTelegram($furn, $tv, $washing, $refrig)." ".
				self::getUtilityPaymentTelegram($utility_payment)." ".
				self::getViewDateText($ap_race_date, $ap_view_date). " ". self::getDelivPeriodText($deliv_period). " " .
				strip_tags(Helper::ResidentsRetro($residents, 2)). ". ".
				self::getFloorText($floor, $floor_count). " ".
				self::getSquareText($sq_all,$sq_live, $sq_k);
		}else{
			$title = 
				self::getTopicNameValue($topic_id) .": ".
				$type_name." " . $area ." ". 
				$street ." " . $house . " " . 
				self::getFurnListTelegram($furn, $tv, $washing, $refrig)." ".
				$price .  "/".$repayment.  self::getUtilityPaymentTelegram($utility_payment)." ".
				self::getViewDateText($ap_race_date, $ap_view_date). " ". self::getDelivPeriodText($deliv_period). " " .
				strip_tags(Helper::ResidentsRetro($residents, 2)). ". ".
				self::getFloorText($floor, $floor_count). " ".
				self::getSquareText($sq_all,$sq_live, $sq_k)
				;
		}
		return $title;
	}

	static function Var_title_Telegram_LK(
			$type_id, $topic_id, $room_count, 
			$planning, $dis, $street, $house, $ap_layout, $parent_id, $city, 
			$price, $utility_payment, $furn, $tv, $washing, $refrig,
			$ap_race_date, $ap_view_date, $deliv_period, $residents, 
			$floor, $floor_count,$sq_all,$sq_live, $sq_k, $repayment,
			$action=false
		)	{
		if($action){
			if($type_id==18){
				$type_name = "комнату";
			}else if($type_id==1){
				$type_name = $room_count." комн";
			}else if($type_id==3){
				$type_name = "Дом";
			}
		}else{
			if($type_id >= 19 && $type_id <= 24){
				$type_name = ($type_id-18) ."-комн";
			}else if($type_id == 0){
				$type_name = $room_count."-комн";
			}else if($type_id > 24){
				
				$type_name = DB::Select("`name_short`", "re_type_object", "`id`='".$type_id."'")[0]['name_short'];

				if($type_id > 24 && $type_id < 30 && $room_count >0){
					$type_name.=" - ".$room_count." комн";
				}
			}else{
				$type_name = "";
			}
		}		
		$topicName = self::getTopicNameValue($topic_id);
		$planningAbbr = self::planingAbbr($planning,  $_GET['action']);
		$apLayoutAbbr =  self::getApLayoutAbbr($ap_layout).". ";
		$area = self::getAreaString($dis, $city, $_GET['action']);

			/*
2-комн. 
Ленинский, 
Танкистов, 
д. 3, 
цена: 123000/1+ ВОДА, СВЕТ. 
Смотреть и заезжать сегодня! Длительно. 
Берут: сп, сп*р, студ, нер,. 
этаж: 9/3, 
пл: 44/-/-. 
фото в личку по запрос
*/
		if($parent_id == '18'){					
			$title = 
				strtolower(self::getTypeRoomByTypeId($type_id)). " " .
				" ". $area ." ".  
				$street ." д." . $house . " " .
				$price . "/".$repayment.
				self::getUtilityPaymentTelegram($utility_payment)." ".
				self::getFurnListTelegram($furn, $tv, $washing, $refrig)." ".
				self::getViewDateText($ap_race_date, $ap_view_date). " ". self::getDelivPeriodText($deliv_period). ". " .
				strip_tags(Helper::ResidentsRetro($residents, 2)). ". ".
				self::getFloorText($floor, $floor_count). " ".
				self::getSquareText($sq_all,$sq_live, $sq_k).".";
		}else{
			$title = 
				$type_name.". " . $area .", ". 
				$street .", д." . $house . ", " .
				$price . " "."/".$repayment." +". self::getUtilityPaymentTelegram($utility_payment)." ".
				self::getFurnListTelegram($furn, $tv, $washing, $refrig)." ".				 
				self::getViewDateText($ap_race_date, $ap_view_date). " ". self::getDelivPeriodText($deliv_period). ". " .
				strip_tags(Helper::ResidentsRetro($residents, 2)). ". ".
				self::getFloorText($floor, $floor_count). " ".
				self::getSquareText($sq_all,$sq_live, $sq_k).". "
				;
		}
		return $title;
	}






	static function Order_type_place($str){
		switch ($str){
				case 'sber_card':
					$result = "Карта Сбербанка";
					break;
				case 'tinkoff_card':
					$result = "Карта Тинькоff";
					break;
				case 'tinkoff':
					$result = "Тинькоff";
					break;
				case 'sber':
					$result = "Сбербанк";
					break;
				case 'qiwi':
					$result = "QIWI";
					break;
				case 'mobil':
					$result = "через мобильный банк";
					break;
				case 'lk':
					$result = "из ЛК";
					break;
				case 'bankomat':
					$result = "через банкомат";
					break;
				case 'cash':
					$result = "через кассира в сбербанке";
					break;
				case 'another_bank':
					$result = "с карты другого банка";
					break;
				case 'wallet':
					$result = "со своего кошелька";
					break;
				case 'terminal':
					$result = "через терминал";
					break;
				case 'euroset':
					$result = "Салон связи";
					break;
			}
		return $result;
	}
}

?>