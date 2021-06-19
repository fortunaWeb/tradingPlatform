<?php

class Model_Main extends Model
{
	public $row_list_ngs = "id, user_id, active, dis, planning, live_point, street, parent_id, house, orientir, text, topic_id, 
	type_id, price, date_last_edit, sq_all, sq_live, sq_k, sq_land, floor, floor_count, contact_name, contact_tel, 
	contact_email, inet, furn, tv, washing, refrig, conditioner, favorit, link, photos, review";

	public $row_list = "v.id, v.user_id, v.active, v.owner, ap_layout, v.parent_id,
	 v.commission, c.company_name, p.name, p.id as people_id, p.second_name, p.phone, 
	 dis, planning, live_point, street, house, orientir, text, topic_id, type_id,
	  price, date_last_edit, sq_all, sq_live, sq_k, sq_land, floor, floor_count, 
	   room_count, coords, deliv_period, prepayment, utility_payment, deposit, furn, val_bal, val_lodg,
	   tv, washing, refrig, ap_view_date, ap_race_date, status, premium, favorit,
	    ap_view_price, in_black_list, review, residents, wc_type, heating, wash, copyright,
	    park, water, sewage, torg, warning, metro_name, distance_to_metro, prolong_garant, last_call_date, last_call_date_ts,
	    wall_type, obmen, ipoteka, chist_prod, developer, construct_y, kvartal,own_type,y_done, 
	    v.keys, v.sleeping_area, full_price, app_status, app_type,repair,credit_bank";
	
	public function get_data()
	{
        if(!isset($_SESSION['fio'])){
            return null;
        }

        $_SESSION['buysell'] = 1;
        $_SESSION['search_user_id'] = "site";
		$room_count = "";
		$dis = "";
		$sq=0;
        $condition = " v.active = 1 ";

		$_SESSION['in_black_list'] = ','.
				DB::Select('GROUP_CONCAT(people_id) as in_black_list', 
                    're_black_list',
                    "owner_people_id = {$_SESSION['people_id']}")[0]['in_black_list'].",";
		$group_inc_user = Get_functions::Get_group_inc_user($_SESSION['fio']);

		$condition .= Helper::FilterVal('live_point')
            ? " AND live_point='{$_POST['live_point']}'"
            :  " AND live_point='Сочи'";


		if($_SESSION['people_id'] == 1 && Helper::FilterVal('suspicion') ){
				$condition.=" AND `suspicion`= ".Helper::FilterVal('suspicion')." ";
		}

        $table = "re_var as v
        INNER JOIN re_user as u ON v.user_id = u.user_id 
        INNER JOIN re_people as p ON p.id = u.people_id
        INNER JOIN re_company as c ON c.id = p.company_id 
        INNER JOIN re_access_date_end as a ON a.company_id = c.id
        ";
        //AND  a.rent_date_end > NOW()
        $condition .= "AND v.user_id IS NOT NULL AND copyright = 0";
        $column = $this->row_list .", 
            DATE_FORMAT(DATE_ADD(`date_last_edit`, INTERVAL -1 hour),'%d/%m/%Y %H:%i') as `date_last_edit_format`,
            DATE_FORMAT(v.`date_added`, '%d/%m/%Y %H:%i') as `date_added_format`";

        if(Helper::FilterVal('photo') == 1){
            $table .= " INNER JOIN re_photos as photo on photo.var_id = v.id ";
        }

        if(Helper::FilterVal("race_now")){
            $today = date('Y-m-d');
            $condition.=" AND `ap_view_date` <= '{$today}' AND `ap_race_date` <= '{$today}' ";
        }

        if(Helper::FilterVal("keys")){$condition.=" AND `keys` = '1' ";}


        $condition = Helper::Post_filters_search($condition);
		if(Helper::FilterVal("id")){
			$condition .= " AND v.id=".Helper::FilterVal('id');
		}

		if($group_inc_user != ""){
            $condition .= " AND (
                v.group=0
                OR
                NOT(v.group = 1 AND v.user_id IN ({$group_inc_user}0)))
            ";
		}
		if(Helper::FilterVal("company_id")){
			$condition .= " AND p.company_id=".Helper::FilterVal("company_id")." ";
		}

		$conditionGroupBy = " GROUP BY v.id ";

		$people_ids = DB::Select("GROUP_CONCAT(people_id) as people_ids", "re_white_list", "owner_people_id={$_SESSION['people_id']}")[0]['people_ids'];
		$_SESSION['white_list']  = '';
		if(!empty($people_ids)){
		$_SESSION['white_list'] =  
			DB::Select("GROUP_CONCAT(`user_id`) as user_ids", "re_user", "people_id=".str_replace(',', " or people_id=", $people_ids))[0]["user_ids"];
		}

		if(isset($_POST['order'])){
			if($_POST['order']=="while_list"){
				$order = "v.user_id=".str_replace(',', " DESC, v.user_id=", $_SESSION['white_list'])." DESC, ";
			}else if($_POST['order'] == 'prolong_garant'){
					$order = " prolong_garant DESC, ";
			}else if($_POST['order'] == 'last_call_date'){
					$order = " `v`.`last_call_date` DESC , ";
			}else{
				$order = $_POST["order"]!=" `v`.`date_last_edit`" ? "v.".$_POST["order"]." DESC, " : "";
			}
			$conditionOrderBy =" ORDER BY premium DESC, {$order} v.date_last_edit DESC";
		}else{
            $conditionOrderBy =" ORDER BY premium DESC, v.date_last_edit DESC";
		}

		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$limit_max = Get_functions::Get_limit_max();
		$limit = Get_functions::Get_limit($limit_max, $page);
		$data = DB::Select($column, $table, $condition.$conditionGroupBy.$conditionOrderBy." limit {$limit}, {$limit_max}",true);

        $dataCount = DB::Select("count(v.id) as CNT", $table, $condition.$conditionGroupBy);
        $data[0]['count'] = count($dataCount);

        $lookVars = DB::Select('look_vars','re_photos_look',"`people_id` = '{$_SESSION['people_id']}'");
        $data['lookVars'] = $lookVars[0];
		$num = count($data);

		for($j=0; $j<$num; $j++)
		{
			$data[$j]['date_added'] = Translate::month_ru($data[$j]['date_added_format']);
		}

		return $data;

	}
	
	public function parse(){

        $condition = " active=1 AND `date_last_edit` > DATE_SUB(NOW(), INTERVAL 1 MONTH) ";
        if(Helper::FilterVal('origin')){
            $condition .= " AND link LIKE '%{$_GET['origin']}%' ";
        }else{
            $condition .= " AND (  link LIKE '%ngs%'  OR  link LIKE '%avito%' )";
        }
        $condition .= " AND topic_id=2 ";


        if(!isset($_GET["parent_id"])){
            $condition .= " AND parent_id=1 ";
        }

        $condition = Helper::Post_filters_search($condition)." ORDER BY  `modified` DESC, `date_last_edit` DESC"; //date_last_edit

        $page = Helper::FilterVal('page') ? Helper::FilterVal('page') : 1;
        $limit_max = Get_functions::Get_limit_max();
        $limit = Get_functions::Get_limit($limit_max, $page);

        $data = DB::Select("*", "re_pay_parse", $condition." limit {$limit}, {$limit_max}");

        $data[0]['count'] = DB::Select("count(*) as c", "re_pay_parse", $condition)[0]['c'];

        return $data;
	}
	
	public function pay_parse()
    {
        $condition = " active=1 AND topic_id=2 ";
		if($_SESSION["sell_date_end"] >= date("Y-m-d")) {
            $condition .= !Helper::FilterVal("parent_id") ? " AND parent_id=1 " : '';

            $condition = Helper::Post_filters_search($condition) . " ORDER BY  `date_last_edit` DESC, `modified` DESC";

            $page = Helper::FilterVal('page') ? Helper::FilterVal('page') : 1;
            $limit_max = Get_functions::Get_limit_max();
            $limit = Get_functions::Get_limit($limit_max, $page);

            $data = DB::Select("*", "re_pay_parse_buysell", $condition . " limit {$limit}, {$limit_max}");

            $data[0]['count'] = DB::Select("count(*) as c", "re_pay_parse_buysell", $condition)[0]['c'];

            return $data;
        }else{
            return ['accessError' => 'Раздел «Частники» сейчас вам не доступен так как закончилась оплата. 
            Необходимо перейти в ЛК, в раздел «продление и оплата» продлить данную услугу.'];
        }
	}
	
	public function check_var(){
		if($_GET["var_id"] && $_SESSION && $_SESSION["tariff_id"] != '1'){
            $var = Helper::getVarById('re_var',$_GET["var_id"])[0];
            $streetCondition = '';
            if(!empty($var)){
                $streetCondition = Helper::strPartsCondition($var['street'], 'p.');
            }
			if($_GET['table']=="archive"){
				$table = "re_parse as p";
				$condition = "p.topic_id = '{$var['topic_id']}' 
                    AND p.parent_id = '{$var['parent_id']}'
                    {$streetCondition}
                   AND(
                        p.live_point = '{$var['live_point']}' 
                    OR 
                        p.live_point=''
                    )
                    AND (
                        (p.type_id >=19 AND p.type_id <=24 AND '{$var['room_count']}' = p.type_id-18) 
                    OR 
                        (p.type_id > 24 AND p.type_id= '{$var['type_id']}')
                    OR 
                        (p.type_id=18)
                    ) 
                    AND p.price BETWEEN '{$var['price']}' - 3000 AND '{$var['price']}' + 3000";
			}else if($_GET['table']=="pay_parse"){
				$table = "re_pay_parse as p";
				$condition = "p.topic_id = '{$var['topic_id']}' AND 
				    p.parent_id =  '{$var['parent_id']}'
                    {$streetCondition} AND 
                    (p.live_point = '{$var['live_point']}' OR p.live_point='') AND p.parent_id = '{$var['parent_id']}'
                        AND (
                                '{$var['parent_id']}' = 18
                            OR
		                        p.room_count = '{$var['room_count']}'
		                 )
                        AND p.price BETWEEN '{$var['price']}' - 3000 AND '{$var['price']}' + 3000 ";
			}

			if($_GET['table']!="pay_parse" ||$_GET['table']!="parse" || $_SESSION["sell_date_end"] > date("Y-m-d")){

				$column = "p.*, 
				DATE_FORMAT(DATE_ADD(p.date_last_edit, INTERVAL -1 hour),'%d/%m/%Y %H:%i') as `date_last_edit_format`, 
				DATE_FORMAT(p.date_added,'%d/%m/%Y %H:%i') as `date_added_format`";
                $condition .= " ORDER BY date_last_edit DESC LIMIT 100";
				$data_res = DB::Select($column, $table, $condition);
				$num = count($data_res);
				$data_res[0]['count'] = $num;
				for($j=0; $j<$num; $j++)
				{
				/*	$data_res[$j]['date_last_edit'] = Translate::month_ru($data_res[$j]['date_last_edit_format']);
					$data_res[$j]['date_added'] = Translate::month_ru($data_res[$j]['date_added_format']);*/
				}
			}else{
				$data_res = "Нет доступа";
			}


			return $data_res;
		}
	}
	
	public function get_type()
	{
		$query = "SELECT * FROM `re_topic` where ((`parent_id` = '2') or (`parent_id` = '3'))";

		echo "<option value=''>Тип обьекта</option>";
		$q_res = mysql_query($query);
		$q_num = mysql_num_rows($q_res);
			$q_row = mysql_fetch_array($q_res);
		for($j=0; $j<$q_num; ++$j) {
			if ($q_row['parent_id'] == '3') {
				echo "<option value='". $q_row['id'] ."'>Новостройка: ". $q_row['name'] ."</option>";
			} else {
				echo "<option value='". $q_row['id'] ."'>". $q_row['name'] ."</option>";
			}
		}			
	}
	
	public function search_street()
	{
		$str = $_POST['street'];
		mysql_set_charset( 'utf8' );
		$r_begin = mysql_query("SELECT * from `re_street` where `name` like '{$str}%' LIMIT 0,10");
		$r_next_word = mysql_query("SELECT * from `re_street` where `name` like '% {$str}%' LIMIT 0,10");
		$r_contains = mysql_query("SELECT * from `re_street` where `name` like '%{$str}%' LIMIT 0,10");
		
		if (mysql_num_rows($r_begin) > 0)
		{	
			echo "<ul id='str_list'>";
			$j = 0;
			while ($row_a = mysql_fetch_array($r_begin))
			{
				echo "<li id='str{$j}' onclick='addStreet({$j})'>{$row_a['name']}</li>";
				$j = $j+1;
			}
			echo "</ul>";
		}elseif (mysql_num_rows($r_next_word) > 0)
		{	
			echo "<ul id='str_list'>";
			$j = 0;
			while ($row_a = mysql_fetch_array($r_next_word))
			{
				echo "<li id='str{$j}' onclick='addStreet({$j})'>{$row_a['name']}</li>";
				$j = $j+1;
			}
			echo "</ul>";
		}elseif (mysql_num_rows($r_contains) > 0)
		{	
			echo "<ul id='str_list'>";
			$j = 0;
			while ($row_a = mysql_fetch_array($r_contains))
			{
				echo "<li id='str{$j}' onclick='addStreet({$j})'>{$row_a['name']}</li>";
				$j = $j+1;
			}
			echo "</ul>";
		}

		mysql_free_result($r_begin);
		mysql_free_result($r_next_word);
		mysql_free_result($r_contains);
	}
	
	public function street_in_parse(){

		$parentId = $_POST['parentId'];
		mysql_set_charset( 'utf8' );
		$table = "re_pay_parse_buysell";
        $str = Helper::FilterVal('street');


		$r_a = mysql_query("SELECT DISTINCT street FROM `{$table}` WHERE 
          parent_id = {$parentId} AND  
          (`street` LIKE '%{$str}%') LIMIT 0,10");

		if (mysql_num_rows($r_a) > 0)
		{
			echo "<ul id='str_list'>";
			$j = 0;
			while ($row_a = mysql_fetch_array($r_a))
			{
				echo "<li id='str{$j}' onclick='addDStreet({$j})'>{$row_a['street']}</li>";
				$j = $j+1;
			}
			echo "</ul>";
		}
		mysql_free_result($r_a);
	}
	
	public function save_limit()
	{
		if(Helper::FilterVal('limit')){
			$_SESSION['limit'] = Helper::FilterVal('limit');
		} else {
			$_SESSION['limit'] = 50;
		}
	}
	
	public function save_page()
	{
		if($_POST['PAGE']){
			$_SESSION['PAGE'] = $_POST['PAGE'];
		} else {
			$_SESSION['PAGE'] = 1;
		}
	}
	
	public function refresh()
	{
		unset($_POST, $_SESSION["post"], $_SESSION['condition']);
	}
	
	public function another_view(){
		if(isset($_SESSION["people_id"]) && isset($_POST["id"])){
			$table = "`re_var` INNER JOIN re_user ON re_var.user_id = re_user.user_id INNER JOIN re_people ON re_user.people_id = re_people.id INNER JOIN re_company ON re_people.company_id = re_company.id";
			$column = $this->row_list .", DATE_FORMAT(DATE_ADD(`date_last_edit`, INTERVAL -1 hour),'%d/%m/%Y %H:%i') as `date_last_edit_format`, DATE_FORMAT(`date_added`,'%d/%m/%Y %H:%i') as `date_added_format`";
			$data = DB::Select($column, $table, "re_var.id = ".$_POST["id"]);
			return $data;
		}
	}
}
?>