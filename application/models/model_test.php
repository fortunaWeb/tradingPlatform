<?php
class Model_Test extends Model
{
	
	public $row_list = "v.id, v.user_id, v.active, v.owner, ap_layout, v.parent_id, v.rent_type, v.commission, c.company_name, p.name, p.id as people_id, p.second_name, p.phone, dis, planning, live_point, street, house, orientir, text, topic_id, type_id, price, date_last_edit, sq_all, sq_live, sq_k, sq_land, floor, floor_count, room_count, coords, deliv_period, prepayment, utility_payment, deposit, furn, tv, washing, refrig, ap_view_date, ap_race_date, status, premium, favorit, ap_view_price, in_black_list, review, residents, wc_type, heating, wash, water, sewage, torg, warning";
	
	public $row_list_ngs = "id, user_id, active, dis, planning, live_point, street, parent_id, house, orientir, text, topic_id, type_id, price, date_last_edit, sq_all, sq_live, sq_k, sq_land, floor, floor_count, contact_name, contact_tel, contact_email, inet, furn, tv, washing, refrig, conditioner, favorit, link, photos, review";	

	public function site(){
		$room_count = "";
		$dis = "";
		$sq=0;
		//$_SESSION['post']['view_type'] == "compact";
		$_SESSION['in_black_list'] = DB::Select('GROUP_CONCAT(people_id) as in_black_list', 're_black_list', "owner_people_id = {$_SESSION['people_id']}")[0]['in_black_list'].",";
		
		$group_inc_user = Get_functions::Get_group_inc_user($_SESSION['fio']);
		
		$condition = " v.active = 1 ";
		$condition .= isset($_GET['live_point']) ? " AND live_point='{$_GET['live_point']}'" :  " AND live_point='Новосибирск'";
		if($_SESSION['group_topic_id'] != 2 && ($_GET["topic_id"]%2!=0 OR !isset($_GET['topic_id']))){
			$hours = isset($_GET['hours']) ? $_GET['hours'] : "24 hour";
			$condition .= " AND DATE_ADD(date_last_edit, INTERVAL {$hours}) >= NOW()".(isset($_GET['rent_type']) ? " AND rent_type='{$_GET['rent_type']}'" : " AND rent_type='месяц'");			
		}else if(!isset($_GET['hours'])){
			$condition.=" AND DATE_ADD(date_last_edit, INTERVAL {$_GET['hours']}) >= NOW() ";
		}else{
			$condition.=" AND DATE_ADD(date_last_edit, INTERVAL 3 day) >= NOW() ";
		}		
		
		if(!isset($_GET["topic_id"]) && ($_SESSION['group_topic_id'] == 3 || $_SESSION['group_topic_id'] == 1)){
			$condition .= " AND topic_id=1 ";
		}else if(!isset($_GET["topic_id"]) && $_SESSION['group_topic_id'] == 2){
			$condition .= " AND topic_id=2 ";
		}
		
		if(!isset($_GET["parent_id"])){
			$condition .= " AND parent_id=1 ";
		}
		
		if($_GET['view_type'] == "map"){
			$_SESSION['limit'] = 50;
			$table = "re_var as v";
			$column = "id, coords";
		}else{
			$table = "re_var as v, re_user as u, re_people as p, re_company as c, re_access_date_end as a";
			$condition .= " AND v.user_id = u.user_id AND u.people_id = p.id AND p.company_id = c.id AND a.company_id = c.id AND sell_date_end > NOW()";
			$column = $this->row_list .", DATE_FORMAT(DATE_ADD(`date_last_edit`, INTERVAL -1 hour),'%d/%m/%Y %H:%i') as `date_last_edit_format`, DATE_FORMAT(`date_added`, '%d/%m/%Y %H:%i') as `date_added_format`";
		}
		
		$condition = Helper::Get_filters($condition);
		
		//$condition = str_replace("company_id", "p.company_id", $condition);
		
		if(isset($_GET['order'])){
			if($_GET['order']=="while_list"){
				$people_ids = DB::Select("GROUP_CONCAT(people_id) as people_ids", "re_white_list", "owner_people_id={$_SESSION['people_id']}")[0]['people_ids'];
				$_SESSION['white_list'] =  DB::Select("GROUP_CONCAT(`user_id`) as user_ids", "re_user", "people_id=".str_replace(',', " or people_id=", $people_ids))[0]["user_ids"];
				$order = "v.user_id=".str_replace(',', " DESC, v.user_id=", $_SESSION['white_list'])." DESC, ";
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
		
		$data = DB::Select($column, $table, $condition." limit 50");
		$data[0]['count'] = DB::Select("count(*) as c", $table, $condition)[0]['c'];
		$num = count($data);
		for($j=0; $j<$num; $j++)
		{
			$data[$j]['date_last_edit'] = Translate::month_ru($data[$j]['date_last_edit_format']);
			$data[$j]['date_added'] = Translate::month_ru($data[$j]['date_added_format']);
		}
		return $data;
	}
	
	public function parse(){
		if(($_SESSION["tariff_id"] != '1' OR ($_GET['topic_id'] != '1' && $_GET['topic_id'] != '3' && isset($_GET['topic_id']))) AND (date("Y-m-d", strtotime($_SESSION['sell_date_end'])) >= date("Y-m-d") OR ($_GET['topic_id'] != '2' && $_GET['topic_id'] != '4' && isset($_GET['topic_id'])))){
			$table = "`re_parse`";
			$column = $this->row_list_ngs .", DATE_FORMAT(DATE_ADD(`date_last_edit`, INTERVAL -2 hour),'%d/%m/%Y %H:%i') as `date_last_edit_format`, DATE_FORMAT(`date_added`, '%d/%m/%Y %H:%i') as `date_added_format`";
			if(isset($_GET['topic_id']) && isset($_GET['parent_id'])){
				$condition = "active='1'";
				$condition = Helper::Get_filters($condition);
				
				if($_POST['photo']>0){
					$condition = preg_replace("/`photo`='1'/", "photos like '%Есть фотографии%'", $condition);
				}
				
				if($_GET['parent_id'] == 1)$condition.=" AND `type_id`!=18";
				$condition.=" ORDER BY `date_last_edit` DESC";
				
				//if($_SESSION['admin']==1)echo "Select {$column} FROM {$table} where {$condition}";
				
				$page = isset($_GET['page']) ? $_GET['page'] : 1;
				$limit_max = Get_functions::Get_limit_max();
				$limit = Get_functions::Get_limit($limit_max, $page);
				
				$data = DB::Select($column, $table, $condition." limit {$limit}, {$limit_max}");
				$data[0]['count'] = DB::Select("count(*) as c", $table, $condition)[0]['c'];
				$num = count($data);
				for($j=0; $j<$num; $j++)
				{
					$data[$j]['date_last_edit'] = Translate::month_ru($data[$j]['date_last_edit_format']);
					$data[$j]['date_added'] = Translate::month_ru($data[$j]['date_added_format']);
				}
				return $data;
			}
		}
	}
	
	public function pay_parse(){
		if($_SESSION['admin']==1){
			$_SESSION['search_user_id'] = "ngs";
			$condition .= " active=1 ";
			if(!isset($_GET["topic_id"]) && ($_SESSION['group_topic_id'] == 3 || $_SESSION['group_topic_id'] == 1)){
				$condition .= " AND topic_id=1 ";
			}else if(!isset($_GET["topic_id"]) && $_SESSION['group_topic_id'] == 2){
				$condition .= " AND topic_id=2 ";
			}
			
			if(!isset($_GET["parent_id"])){
				$condition .= " AND parent_id=1 ";
			}
			$condition = Helper::Get_filters($condition)." ORDER BY date_last_edit DESC";
			
			$page = isset($_GET['page']) ? $_GET['page'] : 1;
			$limit_max = Get_functions::Get_limit_max();
			$limit = Get_functions::Get_limit($limit_max, $page);
			
			$data = DB::Select("*", "re_pay_parse", $condition." limit {$limit}, {$limit_max}");
			//echo "SELECT * FROM re_pay_parse WHERE".$condition." limit {$limit}, {$limit_max} <br />";
			$data[0]['count'] = DB::Select("count(*) as c", "re_pay_parse", $condition)[0]['c'];
			
			return $data;
		}
		
	}
}
?>