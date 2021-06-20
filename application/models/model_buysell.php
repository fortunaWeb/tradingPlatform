<?php

class Model_Buysell extends Model
{
	public $row_list_ngs = "id, user_id, active, dis, planning, live_point, street, parent_id, house, orientir, text, topic_id, type_id, price, date_last_edit, sq_all, sq_live, sq_k, sq_land, floor, floor_count, contact_name, contact_tel, contact_email, inet, furn, tv, washing, refrig, conditioner, favorit, link, photos, review";	

	public $row_list = "*";
	
	public function get_data()
	{
		if(!isset($_SESSION['fio'])) return null;
		
		$_SESSION['search_user_id'] = "site";
		$dis = "";
		$sq=0;
		
		$_SESSION['in_black_list'] = DB::Select('GROUP_CONCAT(people_id) as in_black_list', 're_black_list', "owner_people_id = {$_SESSION['people_id']}")[0]['in_black_list'].",";
		
		$group_inc_user = Get_functions::Get_group_inc_user($_SESSION['fio']);
		
		$condition = " buysell.active = 1 ";
		$condition .= isset($_GET['live_point']) ? " AND live_point='{$_GET['live_point']}'" :  " AND live_point='Сочи'";

		if($_SESSION['people_id'] == 1 && isset($_GET["suspicion"]) && $_GET["suspicion"]!='' ){
				$condition.=" AND `suspicion`= ".$_GET["suspicion"]." ";
		}
        $condition .= " AND topic_id=2 ";
        $_SESSION["topic_id"] = 2;



		if($_GET["topic_id"]%2!=0 && $_SESSION['group_topic_id'] == 2){
			$_SESSION["topic_id"] = 2;
			return null;
		}
		
		if(isset($_GET['view_type']) && $_GET['view_type'] == "map"){
			$_SESSION['limit'] = 50;
			$table = "re_parse_buysell as buysell";
			$column = "id, coords";
		}else{
			$table = "re_parse_buysell as buysell, re_user as u, re_people as p, re_company as c, re_access_date_end as a";
			$condition .= " AND buysell.user_id = u.user_id AND u.people_id = p.id AND p.company_id = c.id AND a.company_id = c.id AND sell_date_end > NOW()";
			$column = $this->row_list .", DATE_FORMAT(DATE_ADD(`date_last_edit`, INTERVAL -1 hour),'%d/%m/%Y %H:%i') as `date_last_edit_format`, DATE_FORMAT(`date_added`, '%d/%m/%Y %H:%i') as `date_added_format`";
		}

		if(isset($_GET["race_now"]) && $_GET["race_now"] == 'now'){
			$today = date('Y-m-d');
			$condition.=" AND `ap_view_date` <= '{$today}' AND `ap_race_date` <= '{$today}' ";
		}



		//if($_SESSION['people_id'] == 1) print_r("\n\n\n<br><br><br><br>".$condition);
		$condition = Helper::postFiltersBuysell($condition);
		//if($_SESSION['people_id'] == 1) print_r("\n\n\n<br><br><br><br>".$condition);
		if(isset($_GET["id"])){
			$condition .= " AND buysell.id={$_GET['id']} ";
		}

		if($group_inc_user != ""){
			$group_arr = explode(',', $group_inc_user);
			if((count($group_arr)-1) == 1){
				$condition.=" AND (buysell.user_id!='".$group_arr[0]."' OR buysell.group=0)";
			}else{
				$num = count($group_arr)-1;
				for($j=0; $j< $num; $j++){
					if($j==0){
						$condition.=" AND (buysell.user_id!='".$group_arr[$j]."'";
					}else if($j == (count($group_arr)-2)){
						$condition.=" && buysell.user_id!='".$group_arr[$j]."' OR buysell.group=0)";
					}else{
						$condition.=" && buysell.user_id!='".$group_arr[$j]."'";
					}
				}
			}
		}
		
		if(isset($_GET["company_id"]) && $_GET["company_id"]>0){
			$condition .= " AND p.company_id={$_GET['company_id']} ";
		}
		
		$people_ids = DB::Select("GROUP_CONCAT(people_id) as people_ids", "re_white_list", "owner_people_id={$_SESSION['people_id']}")[0]['people_ids'];
		$_SESSION['white_list'] =  DB::Select("GROUP_CONCAT(`user_id`) as user_ids", "re_user", "people_id=".str_replace(',', " or people_id=", $people_ids))[0]["user_ids"];
		
		if(isset($_GET['order'])){
			if($_GET['order']=="while_list"){
				$order = "buysell.user_id=".str_replace(',', " DESC, buysell.user_id=", $_SESSION['white_list'])." DESC, ";
			}else{
				$order = $_GET["order"]!="date_last_edit" ? $_GET["order"]." DESC, " : "";
			}				
			$condition.=" ORDER BY ".$order."premium DESC, date_last_edit DESC";
		}else{
			$condition .=" ORDER BY premium DESC, date_last_edit DESC";			
		}
			
		// if($_SESSION['admin']==1)
		// {
			// echo "Select {$column} FROM {$table} where {$condition} <br />";
			// //print_r ($_GET);
		// }

        $page = !empty(Helper::FilterVal('page')) ? Helper::FilterVal('page') : 1;

		$limit_max = Get_functions::Get_limit_max();
		$limit = Get_functions::Get_limit($limit_max, $page);

		$data = DB::Select($column, $table, $condition." limit {$limit}, {$limit_max}");
		$data[0]['count'] = DB::Select("count(*) as c", $table, $condition)[0]['c'];
		$num = count($data);
		for($j=0; $j<$num; $j++)
		{
	//*		$data[$j]['date_last_edit'] = Translate::month_ru($data[$j]['date_last_edit_format']);
			$data[$j]['date_added'] = Translate::month_ru($data[$j]['date_added_format']);
		}
		
		return $data;
	}

		public function street_in_parse(){
		$str = $_POST['street'];
		mysql_set_charset( 'utf8' );
		$table = "re_parse_buysell";
		$r_a = mysql_query("SELECT DISTINCT street FROM `{$table}` WHERE (`street` LIKE '%{$str}%') LIMIT 0,10");
		$j = 0;

		if (mysql_num_rows($r_a) > 0)
		{
			echo "<ul id='str_list'>";
			$j = 0;
			while ($row_a = mysql_fetch_array($r_a))
			{
				echo "<li id='str{$j}' onclick='addStreet({$j})'>{$row_a['street']}</li>";
				$j = $j+1;
			}
			echo "</ul>";
		}
		mysql_free_result($r_a);
	}

    public function var_clone()
    {

        $varId = Helper::FilterVal('var_id');
        if(empty($varId)){
            return null;
        }
        $parseVar = current(DB::Select('*','re_var', "id = '{$varId}'"));
        if(empty($parseVar)){
            return null;
        }
        $userId  = $_SESSION['user'];

        $peopleIdSource = current(DB::Select('people_id','re_user',"user_id = '{$parseVar['user_id']}'"))['people_id'];
        $peopleId = current(DB::Select('people_id','re_user',"user_id = '{$userId}'"))['people_id'];
        $dirSource = __DIR__."/../../images/$peopleIdSource/$varId/";
        $dirDist = __DIR__."/../../images/$peopleId/";
        $dateModified = (new DateTimeImmutable())->format('Y-m-d H:i:s');

        $columns = '`user_id`,`active`,`group`, `topic_id`, `type_id`,`parent_id`,`live_point`, `dis`, `street`,
            `house`,`orientir`, `sq_all`, `sq_live`, `sq_k`,`sq_land`, `planning`, `ap_layout`, `wc_type`,`val_bal`, 
            `val_lodg`, `inet`, `furn`,`tv`, `washing`, `refrig`, `conditioner`,`own_type`,  `developer`, `y_done`, 
            `kvartal`,`park`, `floor`, `floor_count`, `room_count`, `wall_type`,  `elec`, `water`, `gas`,
            `heating`, `heating_type`, `sewage`, `grhouse`, `posadki`, `hole`, `banya`,  `wash`,`text`, `var_code`, 
            `image`, `price`, `prepayment`, `deposit`,   `utility_payment`,`ap_view_price`, `torg`,`chist_prod`, `obmen`,
            `ipoteka`, `rent_type`,`link`, `date_added`, `date_last_edit`, `randomName`, `coords`, `metro_coords`,
            `metro_name`,   `distance_to_metro`, `new_house`,`deliv_period`, `residents`,`ap_view_date`, `ap_race_date`, 
            `status`,`photo`,  `col_date`,  `suspicion`,`sleeping_area`, `keys`, `construct_y`, `copyright`,`owner`,
            `repair`, `credit_bank`, `app_type`, `app_status`, `full_price`, `land_status`';
        $values = "'{$userId}', '1','{$parseVar['group']}','{$parseVar['topic_id']}','{$parseVar['type_id']}','{$parseVar['parent_id']}',
            '{$parseVar['live_point']}','{$parseVar['dis']}','{$parseVar['street']}','{$parseVar['house']}',
            '{$parseVar['orientir']}','{$parseVar['sq_all']}','{$parseVar['sq_live']}','{$parseVar['sq_k']}',
            '{$parseVar['sq_land']}','{$parseVar['planning']}','{$parseVar['ap_layout']}','{$parseVar['wc_type']}',
            '{$parseVar['val_bal']}','{$parseVar['val_lodg']}','{$parseVar['inet']}','{$parseVar['furn']}',
            '{$parseVar['tv']}','{$parseVar['washing']}','{$parseVar['refrig']}','{$parseVar['conditioner']}',
            '{$parseVar['own_type']}','{$parseVar['developer']}','{$parseVar['y_done']}','{$parseVar['kvartal']}',
            '{$parseVar['park']}','{$parseVar['floor']}','{$parseVar['floor_count']}','{$parseVar['room_count']}',
            '{$parseVar['wall_type']}','{$parseVar['elec']}','{$parseVar['water']}','{$parseVar['gas']}',
            '{$parseVar['heating']}','{$parseVar['heating_type']}','{$parseVar['sewage']}','{$parseVar['grhouse']}',
            '{$parseVar['posadki']}','{$parseVar['hole']}','{$parseVar['banya']}','{$parseVar['wash']}',
            '{$parseVar['text']}','{$parseVar['var_code']}','{$parseVar['image']}','{$parseVar['price']}',
            '{$parseVar['prepayment']}','{$parseVar['deposit']}','{$parseVar['utility_payment']}',
            '{$parseVar['ap_view_price']}','{$parseVar['torg']}',
            '{$parseVar['chist_prod']}','{$parseVar['obmen']}','{$parseVar['ipoteka']}','{$parseVar['rent_type']}',
            '{$parseVar['link']}','{$dateModified}','{$dateModified}', 
            '{$parseVar['randomName']}','{$parseVar['coords']}','{$parseVar['metro_coords']}',
            '{$parseVar['metro_name']}','{$parseVar['distance_to_metro']}','{$parseVar['new_house']}',
            '{$parseVar['deliv_period']}','{$parseVar['residents']}',
            '{$parseVar['ap_view_date']}','{$parseVar['ap_race_date']}','{$parseVar['status']}',
            '{$parseVar['photo']}','{$parseVar['col_date']}','{$parseVar['suspicion']}',
            '{$parseVar['sleeping_area']}','{$parseVar['keys']}','{$parseVar['construct_y']}','1', '{$varId}',
            '{$parseVar['repair']}', '{$parseVar['credit_bank']}', '{$parseVar['app_type']}', '{$parseVar['app_status']}',
                '{$parseVar['full_price']}', '{$parseVar['land_status']}'
            ";

        if(!file_exists($dirDist)){
            mkdir($dirDist);
        }

        if( DB::Insert('re_var', $columns,$values,true) == 1 ){
            $newVarId = current(DB::Select('id','re_var',"`owner` = '{$varId}' AND `user_id` = '{$userId}'"));
            if(empty($newVarId)){
                return null;
            }
            $newVarId  = $newVarId ['id'];
            foreach (scandir( $dirSource) as $photo) {
                if($photo == '.'  || $photo =='..'){
                    continue;
                }
//                echo $dirDist.$newVarId;
                if(!file_exists($dirDist.$newVarId)){
                    mkdir($dirDist.$newVarId);
                }
                if(!file_exists($dirDist.$newVarId.'/'.$photo)) {
                    copy($dirSource.$photo,$dirDist.$newVarId.'/'.$photo);
                }


                $columns = '`var_id`, `photo`, `people_id`,  `date_added`';
                $values = "'$newVarId', '$photo','$peopleId','{$parseVar['date_last_edit']}'";
                DB::Insert('re_photos',$columns, $values);
            }
            return $newVarId;
        }

        return null;


    }

    public function parse_var_clone()
    {
        $varId = Helper::FilterVal('var_id');

        if(empty($varId)){
            return null;
        }
        $parseVar = current(DB::Select('*','re_pay_parse_buysell', "id = '{$varId}'"));
        if(empty($parseVar)){
            return null;
        }
        $user_id  = $_SESSION['user'];

        $dateModified = (new DateTimeImmutable())->format('Y-m-d H:i:s');
        $columnsVar = "`group`, `topic_id`, `type_id`, `parent_id`, `live_point`, `dis`, `street`, `house`,
         `orientir`, `sq_all`, `sq_live`, `sq_k`, `sq_land`, `planning`, `ap_layout`, `wc_type`, `val_bal`, 
         `val_lodg`, `inet`, `furn`, `tv`, `washing`, `refrig`, `conditioner`, `own_type`, `developer`, `y_done`, 
         `kvartal`, `park`, `floor`, `floor_count`, `room_count`, `wall_type`, `elec`, `water`, `gas`, `heating`,
          `heating_type`, `sewage`, `grhouse`, `posadki`, `hole`, `banya`, `wash`, `text`, `hidden_text`, `var_code`, 
          `image`, `price`, `prepayment`, `deposit`, `utility_payment`, `ap_view_price`, `torg`, `commission`, 
          `chist_prod`, `obmen`, `ipoteka`, `rent_type`, `link`, `date_added`, `date_last_edit`, `randomName`,
           `coords`, `metro_coords`, `metro_name`, `distance_to_metro`, `new_house`, `deliv_period`, `residents`, 
           `owner`, `ap_view_date`, `ap_race_date`, `status`, `premium`, `photo`, `fortuna_id`, `favorit`, `review`,
            `delete`, `col_date`, `owner_people_id`, `suspicion`, `archive_date`, `prolong_garant`, `last_call_date`, 
            `last_call_date_ts`, `sleeping_area`, `keys`, `construct_y` ";

        $valuesParse = "'$user_id', 
         '{$parseVar['parent_id']}','{$parseVar['live_point']}','{$parseVar['dis']}','{$parseVar['street']}','{$parseVar['house']}','{$parseVar['coords']}',
         '{$parseVar['sq_all']}','{$parseVar['sq_land']}','{$parseVar['room_count']}','{$parseVar['floor']}','{$parseVar['floor_count']}',
          '{$parseVar['date_added']}','$dateModified',{$parseVar['photos']},'{$parseVar['text']}', '{$parseVar['price']}',
          'ссылка:`{$parseVar['link']}`; Телефон:`{$parseVar['phone']}`; Дата:`{$parseVar['modified']}`;', 1, '$varId'";

        $peopleId = current(DB::Select('people_id','re_user',"user_id = '{$user_id}'"))['people_id'];
        $dirSuorce = __DIR__."/../../images/parse/$varId/";
        $dirDist = __DIR__."/../../images/$peopleId/";

        if(!file_exists($dirDist)){
            mkdir($dirDist);
        }

        if( DB::Insert('re_var', $columnsVar,$valuesParse) == 1 ){
            $newVarId = current(DB::Select('id','re_var',"`owner` = '{$varId}' AND `user_id` = '{$user_id}'"));
            if(empty($newVarId)){
                return null;
            }
            $newVarId  = $newVarId ['id'];
            foreach (scandir( $dirSuorce) as $photo) {
                if($photo == '.'  || $photo =='..'){
                    continue;
                }
//                echo $dirDist.$newVarId;
                if(!file_exists($dirDist.$newVarId)){
                    mkdir($dirDist.$newVarId);
                }
                if(!file_exists($dirDist.$newVarId.'/'.$photo)) {
                    copy($dirSuorce.$photo,$dirDist.$newVarId.'/'.$photo);
                }


                $columns = '`var_id`, `photo`, `people_id`,  `date_added`';
                $values = "'$newVarId', '$photo','$peopleId','{$parseVar['modified']}'";
                DB::Insert('re_photos',$columns, $values);
            }
            return $newVarId;
        }
        return null;
    }

    public function parse_buysell(){
		$_SESSION['search_user_id'] = "ngs";
		$_SESSION['buysell'] = 1;
        $condition = '';
		if(date("Y-m-d", strtotime($_SESSION['sell_date_end'])) >= date("Y-m-d") ){

			$table = "`re_pay_parse_buysell`";
			$condition .= " active=1  AND topic_id=2 ";

			$condition = Helper::postFiltersBuysell($condition)." ORDER BY  `modified` DESC, `date_last_edit` DESC";

            $page = !empty(Helper::FilterVal('page')) ? Helper::FilterVal('page') : 1;
			$limit_max = Get_functions::Get_limit_max();
			$limit = Get_functions::Get_limit($limit_max, $page);

			$data = DB::Select("*", $table, $condition." limit {$limit}, {$limit_max}");

			$data[0]['count'] = DB::Select("count(*) as c", $table, $condition)[0]['c'];

			return $data;
			}

	}
	
	
	public function check_var(){
		if($_GET["var_id"] && $_SESSION){
			if($_GET['table']=="parse_buysell"){
				$table = "re_parse_buysell as p, re_buysell as_buysell";
				$condition = "buysell.id=".$_GET["var_id"]." AND p.topic_id = buysell.topic_id AND p.parent_id = buysell.parent_id AND p.street = buysell.street AND (p.live_point=buysell.live_point OR p.live_point='') AND ((p.type_id >=19 AND p.type_id <=24) OR (p.type_id > 24 AND p.type_id=buysell.type_id) OR (p.type_id=18)) AND p.price BETWEEN buysell.price - 1000 AND buysell.price + 1000 ORDER BY date_last_edit DESC";
			}
			if($_GET['table']!="pay_parse_buysell" || $_SESSION["sell_date_end"] > date("Y-m-d")){
				$column = "p.*, DATE_FORMAT(DATE_ADD(p.date_last_edit, INTERVAL -1 hour),'%d/%m/%Y %H:%i') as `date_last_edit_format`, DATE_FORMAT(p.date_added,'%d/%m/%Y %H:%i') as `date_added_format`";
				$data_res = DB::Select($column, $table, $condition);
				$num = count($data_res);
				$data_res[0]['count'] = $num;
				for($j=0; $j<$num; $j++)
				{
					$data_res[$j]['date_last_edit'] = Translate::month_ru($data_res[$j]['date_last_edit_format']);
					$data_res[$j]['date_added'] = Translate::month_ru($data_res[$j]['date_added_format']);
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
		for($j=0; $j<$q_num; ++$j) {
			$q_row = mysql_fetch_array($q_res);
			if ($q_row['parent_id'] == '3') {
				echo "<option value='". $q_row['id'] ."'>Новостройка: ". $q_row['name'] ."</option>";
			} else {
				echo "<option value='". $q_row['id'] ."'>". $q_row['name'] ."</option>";
			}
		}			
	}

	public function getSubDistr()
    {
        $district = Helper::FilterVal('district');
        if($district != null){
            $subDistricts = DB::Select('name', 'sub_districts', "`district` = '$district'");
        }else{
            return '';
        }
        $formText = '';
        foreach ($subDistricts as $subDistrict) {
            $formText.= "<span onClick ='subdistrClick(\"{$subDistrict['name']}\")' >".$subDistrict['name'].'</span>';
        }
        echo $formText;
        return 'oK';
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
	
	public function street_in_parse_buysell(){
		$str = $_POST['street'];
		$parent_id = $_POST['parent_id'];
		mysql_set_charset( 'utf8' );
		$table = "re_pay_parse_buysell";
		if($_POST["action"] == "pay_parse_buysell"){
			$table = "re_pay_parse_buysell";
		}
		$r_a = mysql_query("SELECT DISTINCT street FROM {$table} 
				WHERE  parent_id = {$parent_id} AND (street LIKE '%{$str}%') LIMIT 0,10");
		
		$j = 0;
		if (mysql_num_rows($r_a) > 0)
		{
			echo "<ul id='str_list'>";
			$j = 0;
			while ($row_a = mysql_fetch_array($r_a))
			{
				echo "<li id='str{$j}' onclick='addStreet({$j})'>{$row_a['street']}</li>";
				$j = $j+1;
			}
			echo "</ul>";
		}
		mysql_free_result($r_a);
	}
	
	public function save_limit()
	{
		if($_POST['limit']){
			$_SESSION['limit'] = $_POST['limit'];
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
			$table = "`re_buysell` INNER JOIN re_user ON re_buysell.user_id = re_user.user_id INNER JOIN re_people ON re_user.people_id = re_people.id INNER JOIN re_company ON re_people.company_id = re_company.id";
			$column = $this->row_list .", DATE_FORMAT(DATE_ADD(`date_last_edit`, INTERVAL -1 hour),'%d/%m/%Y %H:%i') as `date_last_edit_format`, DATE_FORMAT(`date_added`,'%d/%m/%Y %H:%i') as `date_added_format`";
			$data = DB::Select($column, $table, "re_buysell.id = ".$_POST["id"]);
			return $data;
		}
	}


    public function my_sample()
    {
        $dataPayParseBuysell = [];
        if(empty($_POST['sample_id'])) return $dataPayParseBuysell;
        $tablePayParseBuysell = "re_sample_var  as samples 
	   				 INNER JOIN `re_pay_parse_buysell`  on samples.var_id = re_pay_parse_buysell.id";
        $condition = "sample_id = {$_POST['sample_id']} AND type = 'pri' ORDER BY samples.created DESC ";
        $dataPayParseBuysell = DB::Select('*', $tablePayParseBuysell, $condition);

        return $dataPayParseBuysell;
    }

}
?>