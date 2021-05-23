<?php

class Model_External extends Model
{
	public $row_list_ngs = "id, user_id, active, dis, planning, live_point, street, parent_id, house, orientir, text, topic_id, type_id, price, date_last_edit, sq_all, sq_live, sq_k, sq_land, floor, floor_count, contact_name, contact_tel, contact_email, inet, furn, tv, washing, refrig, conditioner, favorit, link, photos, review";	

	public $row_list = "v.id, v.user_id, v.active, v.owner, ap_layout, v.parent_id, v.commission, c.company_name, p.name, p.id as people_id, p.second_name, p.phone, dis, planning, live_point, street, house, orientir, text, topic_id, type_id, price, date_last_edit, sq_all, sq_live, sq_k, sq_land, floor, floor_count, room_count, coords, deliv_period, prepayment, utility_payment, deposit, furn, tv, washing, refrig, ap_view_date, ap_race_date, status, premium, favorit, ap_view_price, in_black_list, review, residents, wc_type, heating, wash, park, water, sewage, torg, warning, metro_name, distance_to_metro";
	public function photo()
	{
		if($_GET['link']){
			$var_id = DB::Select('id', 're_var', " `link` = '{$_GET['link']}'")[0]['id'];
			$photos = DB::Select('var_id, people_id, photo', 're_photos', "var_id = {$var_id}");
			return $photos;
		}

		return null;
	}

	public function get_data()
	{

//echo "<br/><br/><br/><br/> !!!!! <br/><br/><br/>";
		$room_count = "";
		$dis = "";
		$sq=0;
			
		$condition = " v.active = 1 ";
		$condition .= isset($_GET['live_point']) ? " AND live_point='{$_GET['live_point']}'" :  " AND live_point='Новосибирск'";

		if($_SESSION['group_topic_id'] != 2 && ($_GET["topic_id"]%2!=0 OR !isset($_GET['topic_id']))){

			$hours = isset($_GET['hours']) ? $_GET['hours'] : "24 hour";
			$condition .= " AND DATE_ADD(date_last_edit, INTERVAL {$hours}) >= NOW()";	

		}else if(isset($_GET['hours'])){
			$condition.=" AND DATE_ADD(date_last_edit, INTERVAL {$_GET['hours']}) >= NOW() ";		}else{
			$condition.=" AND DATE_ADD(date_last_edit, INTERVAL 3 day) >= NOW() ";
		}
		if($_SESSION['people_id'] == 1 && isset($_GET["suspicion"]) && $_GET["suspicion"]!='' ){
				$condition.=" AND `suspicion`= ".$_GET["suspicion"]." ";
		}

		if(!isset($_GET["topic_id"]) || $_GET["topic_id"] ==1 ){
			$condition .= " AND topic_id=1 ";
		}else if($_GET["topic_id"] ==  2){
			$condition .= " AND topic_id=2 ";
		}
		
	
		if(isset($_GET['view_type']) && $_GET['view_type'] == "map"){
			$_SESSION['limit'] = 50;
			$table = "re_var as v";
			$column = "id, coords";
		}else{
			$table = "re_var as v, re_user as u, re_people as p, re_company as c, re_access_date_end as a";
			$condition .= " AND v.user_id = u.user_id AND u.people_id = p.id AND p.company_id = c.id AND a.company_id = c.id AND sell_date_end > NOW()";
			$column = $this->row_list .", DATE_FORMAT(DATE_ADD(`date_last_edit`, INTERVAL -1 hour),'%d/%m/%Y %H:%i') as `date_last_edit_format`, DATE_FORMAT(`date_added`, '%d/%m/%Y %H:%i') as `date_added_format`";
		}

		if(isset($_GET["race_now"]) && $_GET["race_now"] == 'now'){
			$today = date('Y-m-d');
			$condition.=" AND `ap_view_date` <= '{$today}' AND `ap_race_date` <= '{$today}' ";
		}

		$condition = Helper::Get_filters($condition);
		
		if(isset($_GET["id"])){
			$condition .= " AND v.id={$_GET['id']} ";
		}

		if($group_inc_user != ""){

			$group_arr = explode(',', $group_inc_user);

			if((count($group_arr)-1) == 1){
				$condition.=" AND (v.user_id!='".$group_arr[0]."' OR v.group=0)";
			}else{
				$num = count($group_arr)-1;
				for($j=0; $j< $num; $j++){
					if($j==0){
						$condition.=" AND (v.user_id!='".$group_arr[$j]."'";
					}else if($j == (count($group_arr)-2)){
						$condition.=" && v.user_id!='".$group_arr[$j]."' OR v.group=0)";
					}else{
						$condition.=" && v.user_id!='".$group_arr[$j]."'";
					}
				}
			}
		}
		
		if(isset($_GET["company_id"]) && $_GET["company_id"]>0){
			$condition .= " AND p.company_id={$_GET['company_id']} ";
		}
		

		if(isset($_GET['order'])){
			if($_GET['order']=="while_list"){
				$order = "v.user_id=".str_replace(',', " DESC, v.user_id=", $_SESSION['white_list'])." DESC, ";
			}else{
				$order = $_GET["order"]!="date_last_edit" ? $_GET["order"]." DESC, " : "";
			}				
			$condition.=" ORDER BY ".$order."premium DESC, date_last_edit DESC";
		}else{
			$condition .=" ORDER BY premium DESC, date_last_edit DESC";			
		}

		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$limit_max = Get_functions::Get_limit_max();
		$limit = Get_functions::Get_limit($limit_max, $page);
		
		
		
		$data = DB::Select($column, $table, $condition." limit {$limit}, {$limit_max}");
		$data[0]['count'] = DB::Select("count(*) as c", $table, $condition)[0]['c'];
		$num = count($data);
		for($j=0; $j<$num; $j++)
		{
			$data[$j]['date_added'] = Translate::month_ru($data[$j]['date_added_format']);
		}
		
		return $data;
	}
	
}
?>