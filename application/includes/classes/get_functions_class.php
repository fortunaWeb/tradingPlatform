<?php
Class Get_functions
{		


	static function Get_phone_addon() {
		$query = "SELECT phone_addon FROM re_people WHERE `id` = '".Get_functions::Get_people_id_by_user_id($_SESSION['user'])."'";
		return  explode(",", mysql_fetch_assoc(mysql_query($query))['phone_addon']);		
	}

	static function Get_black_list_show_var($people_id) {
		$show_var = DB::Select('show_var', 're_black_list', "`owner_people_id` = '{$_SESSION['people_id']}' AND `people_id` = {$people_id}");
		return  $show_var[0]['show_var'];		
	}

	static function Get_black_list_forum() {
		$res = mysql_query("SELECT `people_id` FROM re_black_list WHERE `owner_people_id` = '{$_SESSION['people_id']}' AND `show_forum` = 0");
		$data = '0';
		while ($row = mysql_fetch_array($res))
      		{	
				$data.= ','.$row['people_id'];
			}	
		return  $data;
	}

	static function Get_black_list_show_forum($people_id) {
		$query = "SELECT show_forum FROM re_black_list WHERE 
				`owner_people_id` = '{$_SESSION['people_id']}' AND `people_id` ={$people_id}";
		return  mysql_fetch_assoc(mysql_query($query))['show_forum'];		
	}
	

	static function Get_phones_for_archive() {
		$query = "SELECT phone_for_archive FROM re_people WHERE `id` = '".Get_functions::Get_people_id_by_user_id($_SESSION['user'])."'";
		return explode("||", mysql_fetch_assoc(mysql_query($query))['phone_for_archive']);		 	
	}
	
	static function Get_fio_by_pnone($phone){
		$query = "SELECT `surname`, `name`, `second_name` FROM `re_people` WHERE `phone` LIKE '%".$phone."%' OR `phone_addon` LIKE '%".$phone."%' AND `date_dismiss` = '0000-00-00 00:00:00'";
		return mysql_fetch_assoc(mysql_query($query));
	}
	
	static function Get_fio_by_people_id($id){
		$query = "SELECT `surname`, `name`, `second_name` FROM re_people WHERE `id` = '".$id."' AND `date_dismiss` = '0000-00-00 00:00:00'";
		$fio_array = mysql_fetch_assoc(mysql_query($query));
		$fio = $fio_array['surname']." ".$fio_array['name']." ".$fio_array['second_name'];
		return $fio;
	}
	
	static function Get_io_by_people_id($id){
		$res = mysql_query("SELECT CONCAT(name,' ',second_name) as io FROM re_people WHERE `id` = '".$id."' AND `date_dismiss` = '0000-00-00 00:00:00'");
		$io = mysql_fetch_assoc($res)["io"];
		return $io;
	}
	
	static function Get_fio_by_company_name($company_name){
		$query = "SELECT `surname`, `name`, `second_name` FROM re_people WHERE `company_id` = '".$company_name."' AND `date_dismiss` = '0000-00-00 00:00:00'";
		$fio_array = mysql_fetch_assoc(mysql_query($query));
		$fio = $fio_array['surname']." ".$fio_array['name']." ".$fio_array['second_name'];
		return $fio;
	}
	
	static function Get_date_end($rent_or_sell) {
		$query = "SELECT ".$rent_or_sell."_date_end, DATE_FORMAT(`".$rent_or_sell."_date_end`,'%d/%m/%Y') as `".$rent_or_sell."_date_end_format` FROM re_access_date_end WHERE company_id = '".$_SESSION['company_id']."'";
		$rent_or_sell_date_end =  mysql_fetch_assoc(mysql_query($query));
		return Translate::month_ru($rent_or_sell_date_end[$rent_or_sell.'_date_end_format']);
	}
	
	static function Get_premium_count() {
		$query = "SELECT sell_premium, rent_premium FROM re_company WHERE id = '".$_SESSION['company_id']."'";
		return mysql_fetch_assoc(mysql_query($query));	
	}
	
	static function Get_premium_balance() {
		if(isset($_SESSION['company_id'])){
		    $topicId = Helper::FilterVal('topic_id');
			mysql_query("UPDATE re_var set premium=0 where user_id={$_SESSION['user']} AND active=0");
			$table = "re_user INNER JOIN re_people ON re_user.people_id = re_people.id INNER JOIN re_var ON re_user.user_id = re_var.user_id";
			$condition = "company_id=".$_SESSION['company_id']." AND (topic_id={$topicId} OR topic_id=". ($topicId += 2) .")";
			$sum = DB::Select("SUM(premium)", $table, $condition);			
			$premium_count = Get_functions::Get_premium_count();
			$result = Helper::FilterVal('topic_id') == 5 || Helper::FilterVal('topic_id') == 3
                ? ($premium_count['sell_premium'] - $sum[0]['SUM(premium)'])
                : ($premium_count['rent_premium'] - $sum[0]['SUM(premium)'])
                ;
			return $result;
		}
	}
	
	static function Get_date_reg() {
		$query = "SELECT DATE_FORMAT(`date_reg`,'%d/%m/%Y %H:%i') as `date_reg_format` FROM re_company WHERE id = '".$_SESSION['company_id']."'";
		$date_reg = mysql_fetch_assoc(mysql_query($query));
		return Translate::month_ru($date_reg['date_reg_format']);
	}
	
	static function Get_applications_count(){
		if($_SESSION['admin'] == '1'){			
			$query = "SELECT `id` FROM re_applications WHERE archive = '0'";
			$num = mysql_num_rows(mysql_query($query));
			echo $num;
			if($num>0){
				/*echo "<a href='?task=profile&action=applications' class='btn btn-primary left'>
				  Заявки <span class='badge'>".$num."</span>
				</a>";*/
			}
		}
	}
	
	static function Get_var_count($user_id, $topic_id, $parent_id, $active){
		if($_SESSION['user']){			
			if(!isset($user_id)) $user_id = $_SESSION['user'];
			$condition =  "user_id = ".$user_id;
			
			if(isset($topic_id) && $topic_id!="") $condition.= " AND (`topic_id` = ".$topic_id." OR `topic_id` = ".($topic_id+2).")";
			if(isset($parent_id) && $parent_id!="" && $parent_id!="all") $condition.= " AND `parent_id` = ".$parent_id."";
			if(isset($active)) $condition.= " AND `active` = ".$active."";			
			$var_count = DB::Select("COUNT(*)", "`re_var`", $condition);					
			return $var_count[0]['COUNT(*)'];
		}
	}
	
	static function Get_var_count_list($topic_id){
		if($_SESSION['user']){
			if($_GET["task"]=="main"){
				$table = $_SESSION['search_user_id'] == "site" ? "re_var" : "re_parse";
			}else{
				$table = "re_var";
			}
			$condition="";
			if($_GET["parent_id"] > 0 && $_GET["parent_id"]!= "all"){
				$condition.=" AND parent_id = '".$_GET["parent_id"]."'";
			}
			if($_GET["topic_id"] > 0 && $_GET["parent_id"]!= "all"){
				$condition.=" AND topic_id = '".$_GET["topic_id"]."'";
			}else{
				$condition.=" AND topic_id = '".$_SESSION["group_topic_id"]."'";
			}
			$count_active = mysql_fetch_assoc(mysql_query("select COUNT(id) as count from ".$table." where active=1 and user_id=".$_SESSION["user"].$condition))["count"];
			$count_archive = mysql_fetch_assoc(mysql_query("select COUNT(id) as count from ".$table." where active=0 and user_id=".$_SESSION["user"].$condition))["count"];
			$count_favorit = mysql_fetch_assoc(mysql_query("select COUNT(id) as count from ".$table." where favorit like '%|".$_SESSION["people_id"]."|%'".$condition))["count"];
			$topic_id = $_SESSION["group_topic_id"] == 2 ? 2 : $topic_id;
			$resault = "<a title='число активных вариантов' style='color:#333' href='/?task=profile&action=mytype&active=1&parent_id=all&topic_id=".$topic_id."'><span style='color: #337ab7;'>активные:</span>".$count_active."</a><a title='число архивных вариантов' style='color:#333' href='/?task=profile&action=mytype&active=0&parent_id=all&topic_id=".$topic_id."'> <span style='color: #337ab7;'>архив:</span>".$count_archive."</a><a id='favorites-count' style='color:#333	' title='число избранных вариантов' href='/?task=profile&action=favorites&parent_id=all&topic_id=".$topic_id."'> <span style='color: #337ab7;'>избр:</span>".$count_favorit."</a>";
			unset($table, $count_active, $count_archive, $count_favorit);
			return $resault;
		}
	}
	
	static function Get_favorites_count($people_id){
		if($_SESSION['user']){	
			$topic_id = isset($_GET["topic_id"]) ? $_GET["topic_id"] : $_SESSION["group_topic_id"];
			if(!isset($people_id)) $people_id = $_SESSION['people_id'];
			$condition =  "favorit like '%|".$people_id."|%' AND topic_id = ".$topic_id;
			$fuvorites_count = DB::Select("COUNT(*)", "`re_var`", $condition);
			echo $fuvorites_count[0]['COUNT(*)'];
		}
	}
	
	static function Get_company_name_by_people_id($id){
		if(isset($_SESSION['user'])){	
			$query = "SELECT company_name FROM re_company INNER JOIN re_people ON re_people.company_id = re_company.id WHERE re_people.id = ".$id;
			return mysql_fetch_assoc(mysql_query($query))['company_name'];
		}
	}
	

	static function Get_company_name_by_id($id){
		if($_SESSION['parent'] == '0'){	
			$query = "SELECT company_name FROM re_company WHERE `id` = ".$id;
			return mysql_fetch_assoc(mysql_query($query))['company_name'];
		}
	}
	

	static function Get_suspicion_text($text){
		$suspWord = false;
		//$words = ['тысяч', 'тыс', 'коммуналка', 'комуналка', 'коммунальные', 'комунальные', 'плюс', 'задаток', 'плюс', 'залог', 'звонить'];
		 $words = ['тысяч', 'тыс', 'коммуналка', 'комуналка', 'коммунальные', 'комунальные', 'плюс', 'задаток', 'залог', 'звонить', 'на продаже'];
		foreach ($words as $key => $value) if(strpos($text,$value)){$suspWord = true; break;}
		preg_match_all("/[0-9]{1}/", $text, $out);
		//$duo1 = preg_match("/\d{2}/", $text);
		$duo1 = preg_match("/\d{3}/", $text);		
		//$duo2 = preg_match("/\d{1}.\d{1}/", $text);
		$duo2 = preg_match("/89/", $text);
		$duo3 = preg_match("/\+7/", $text);
		if($duo1 || $duo2 || $duo3 /*|| sizeof($out[0]) > 3*/ || $suspWord) return 1;
			return 0 ;
	}

	static function Get_company_id_by_people_id($id){
		if($_SESSION['parent'] == '0'){				
			$query = "SELECT company_id FROM re_people WHERE `id` = ".$id;
			return mysql_fetch_assoc(mysql_query($query))['company_id'];
		}
	}
	
	static function Get_login_by_id($id){
		if($_SESSION['admin'] == '1'){	
			$query = "SELECT `login` FROM re_user WHERE `user_id` = ".$id;
			return mysql_fetch_assoc(mysql_query($query))['login'];
		}
	}
	
	static function Get_people_id_by_user_id($id){
		if($_SESSION['parent'] == '0'){	
			$query = "SELECT `people_id` FROM re_user WHERE `user_id` = ".$id;
			return mysql_fetch_assoc(mysql_query($query))['people_id'];
		}
	}
	
	static function Get_people_id_by_login($login){
		if($_SESSION['parent'] == '0'){	
			$query = "SELECT `people_id` FROM re_user WHERE `login` = '".$login."' AND `archive` = '0'";
			return mysql_fetch_assoc(mysql_query($query))['people_id'];
		}
	}
		
	static function Get_address_by_people_id($people_id, $type){		
		$condition = "`people_id` = '".$people_id."' 						
					AND `archive` = '0' 
					AND `".$type."` = '1'";
		$address = DB::Select("*", "`re_addresses`", $condition);		
		return $address;
	}
	
	static function Get_page(){		
		$page = $_SESSION['PAGE'] ? $_SESSION['PAGE'] : 1;
		if($_GET){
			if($_SESSION['topic_id'])
			{
				$page = $_SESSION['PAGE'] = $_SESSION['topic_id'] != $_GET['topic_id'] ? 1 : $_SESSION['PAGE'];
				$_SESSION['topic_id'] = $_GET['topic_id'];
			}		
			if($_SESSION['parent_id'])
			{
				$page = $_SESSION['PAGE'] = $_SESSION['parent_id'] != $_GET['parent_id'] ? 1 : $_SESSION['PAGE'];
				$_SESSION['parent_id'] = $_GET['parent_id'];
			}		
		}
		return $page;		
	}	
	
	static function Get_limit_max(){
		$limit_max = isset($_SESSION['limit']) ? $_SESSION['limit'] : 50;
		return $limit_max;
	}
	
	static function Get_limit($limit_max, $page){
		$limit = $page == 1 ? 0 : ($page - 1)*$limit_max;
		return $limit;
	}
	/*список пользователей, которым не показываются сообщения данного риелтера*/
	static function Get_black_group_list($fio){
		$query = "SELECT `black_group`,`hide_black_group` FROM `re_group` WHERE `group_owner` = '".$fio."'";
		$res = mysql_query($query);
		$group_list = mysql_fetch_assoc($res);
		unset($query, $res);
		return $group_list;
	}
	/*список пользователей, которые скрывают свои сообщения от данного риелтера*/
	static function Get_group_inc_user($fio){
		if(!isset($fio)) return null;
		list($surname, $name, $second_name) =  explode(" ", $fio);
		$group_array = DB::Select("`group_owner`", "`re_group`", "`black_group` like '%".$fio."%'");
		$group_list = "";
		$num = count($group_array);
		if($num>0){
			for($i=0; $i<$num; $i++){
				list($surname, $name, $second_name) =  explode(" ", $group_array[$i]['group_owner']);
					$groupListAdd = DB::Select("`user_id`",
                        "`re_user` INNER JOIN `re_people` ON re_people.id=re_user.people_id",
                        "`surname`='".$surname."' AND `name`='".$name."' AND `second_name`='".$second_name."'"
                    );
					if(isset($groupListAdd[0]['user_id']))
					    $group_list.= $groupListAdd[0]['user_id'].",";
			}
		}

		unset($num, $group_array, $fio, $i, $surname, $name, $second_name);
		return $group_list;
	}
	
	static function Get_city_list($parent_id = null, $hours = '24 hour', $action = 1)
    {
        $active = Helper::FilterVal('active')==='0' ? 0 : 1 ;
        $interval = '';
        $filterParentId = (!empty($parent_id) && $parent_id != 'all') ? "AND parent_id = {$parent_id} " : "";
		$myTypeFiler = (Helper::FilterVal('action')=="mytype") ? "AND `user_id` = {$_SESSION['user']}" : '';
		$payParseFilter = (Helper::FilterVal('action') == 'parse')
            ? " AND ( link LIKE '%ngs%' OR link LIKE '%avito%' ) AND `date_last_edit` > DATE_SUB(NOW(), INTERVAL 1 MONTH) "
            : "";

		if(
			($_SESSION['search_user_id'] == "site"
                && Helper::FilterVal('action')!="pay_parse"
                && Helper::FilterVal('action')!="parse")
			||
            Helper::FilterVal('action')=="mytype")
		{
            $action==1
                ? $interval = " AND DATE_ADD(date_last_edit, INTERVAL {$hours}) >= NOW() "
                : $interval = "";
			$table = "re_var";
		}else if ( Helper::FilterVal('action') == "parse_buysell"){
			$table = "re_pay_parse_buysell";
		}else{
			$table = "re_pay_parse";
            $interval = "";
		}


		$cities = DB::Select(' distinct live_point', $table, "active={$active} {$filterParentId}{$myTypeFiler} {$interval} {$payParseFilter}");
        foreach ($cities as $i => $city ) {
            $data[$i] = $city['live_point'];
        }
		return $data;
	}

	static function Get_city_list_buysell(){
		$table = "re_parse_buysell";
		$hours = Helper::FilterVal("hours");
		$hours = $hours ? $hours : "24 hour";
		$condition = $table == "re_var" ?  " AND DATE_ADD(date_last_edit, INTERVAL {$hours}) >= NOW() " : "";
		$parent = isset($_GET['parent_id']) && $_GET['parent_id']!="all" ? " AND parent_id={$_GET['parent_id']}" : "";
		$topic = isset($_GET['topic_id']) ? " AND topic_id={$_GET['topic_id']}" : "";
		$res = mysql_query("select distinct live_point from {$table} WHERE active=1{$parent}{$topic}{$condition} ORDER BY live_point");
		
		$num = mysql_num_rows($res);
		for($i=0; $i<$num; $i++)
		{
			$data[$i] = mysql_fetch_assoc($res)['live_point'];
		}
		unset($num, $res, $i, $table, $condition);
		return $data;
	}
	
	static function Get_message_count($people_id){
		$count = DB::Select("COUNT(*)", "re_messages", "people_id_to=".$people_id." AND `new` = '1'")[0]["COUNT(*)"];
		echo $count;
	}
	
	static function Get_new_order_count(){
		$count = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) FROM re_order WHERE active=1"))["COUNT(*)"];
		return $count;
	}

	static function Get_new_tinkoff_order_count(){
        return current(DB::Select('COUNT(id) cnt', 're_payment_tinkoff payment',"archive IS NULL "))['cnt'];

    }

	static function Get_black_list(){
		$res=mysql_query("SELECT distinct people_id FROM re_black_list WHERE owner_people_id=".$_SESSION["people_id"]);
		$num = mysql_num_rows($res);
		for($i=0; $i<$num; $i++){
			$black_list.=mysql_fetch_assoc($res)["people_id"].",";
		}
		return $black_list;
	}
	
	static function Get_new($table, $column, $start, $round){
		$res = mysql_query("SELECT ".$column." FROM ".$table." GROUP BY (".$column.")");
		while($id = mysql_fetch_assoc($res)){
			$ids[] = $id[$column];
		}
		$end = $start+$round;
		$result = rand($start, $end);
		while(in_array($result, $ids)){
			$result = rand($start, $end);
		}
		unset($table, $column, $start, $round, $end, $id, $ids);
		return $result;
	}
	
	static function Get_an_count($what)
	{
		if($what == 'all'){
			$count = DB::Select("count(*) as c", "re_company as c,  re_access_date_end as a", "c.id=a.company_id GROUP BY(DATE_FORMAT(a.sell_date_end, '%Y-%m-%d') < DATE_FORMAT(NOW(), '%Y-%m-%d'))");
			$result = $count[0]['c']+$count[1]['c']."/".$count[0]['c']."/".$count[1]['c'];
			return $result;
		}
	}
	
	static function Get_chat_mess_list(){
		if(isset($_SESSION["user"])){
			$mess = DB::Select("chat.text as text, 
								chat.nickname as nickname, 
								usr.user_id as user_id, 
								DATE_FORMAT(chat.date,'%H:%i %d.%m') as date, 
								people.phone as phone, 
								people.name as name
								", 
								"re_chat as chat
								INNER JOIN re_user as usr on chat.user_id = usr.user_id
								INNER JOIN re_people as people on usr.people_id = people.id", 
								"DATE_ADD(date,INTERVAL +30 day) > NOW()");

			$count = count($mess);
			for($m=0; $m<$count; $m++){
				echo "<div class='mess'>
						<div style = 'line-height: 0.8em;'>
							<div class = 'chatBlock'>
								<span  class='nickname'>
									{$mess[$m]['nickname']}</span>
							</div>
							<div class = 'chatBlock' style = 'float:right' >
								<span class='messTime'>{$mess[$m]['date']}</span>
							</div>

								<a class='nickname'  href='tel:{$mess[$m]['phone']}'>{$mess[$m]['phone']}</a>
								<span class='nickname' > {$mess[$m]['name']}</span>

						</div>
						<span>{$mess[$m]['text']}</span>
					</div>";
			}
		}
	}
	
	static function Get_chat_mess_count(){
		if(isset($_SESSION["user"])){
			echo DB::Select("count(*) as c", "re_chat", "DATE_ADD(date,INTERVAL +30 day) > NOW()")[0]["c"];
		}
	}
	
	static function Get_peoples_ids_in_an($an_id){
		if($_SESSION['company_id']==$an_id && $an_id!=""){
			$res = mysql_query("SELECT GROUP_CONCAT(p.id) as ids FROM re_people as p, re_user as u WHERE p.id = u.people_id AND p.date_dismiss='0000-00-00 00:00:00' AND p.company_id=".$an_id);
			$ids_str = mysql_fetch_assoc($res)['ids'];
			$ids_arr = explode(",", $ids_str);
			unset($res, $ids_str);
			return $ids_arr;
		}
	}
}
?>