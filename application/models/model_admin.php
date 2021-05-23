<?
class Model_Admin extends Model
{	
	public function get_data()
	{
		return null;
	}
	
	public function review_list()
	{
		if($_SESSION['admin'] == 1){
			$columns = "re_var.id, re_var.user_id, re_var.active, ap_layout, re_var.parent_id, 
			re_company.company_name, re_people.name, re_people.id as people_id, re_people.second_name, 
			re_people.phone, dis, planning, live_point, street, house, orientir, text, topic_id, 
			type_id, price, date_last_edit, sq_all, sq_live, sq_k, floor, floor_count, room_count, 
			coords, deliv_period, prepayment, utility_payment, deposit, inet, furn, tv, washing, refrig, 
			conditioner, ap_view_date, ap_race_date, status, premium, favorit, ap_view_price, in_black_list, commission,
			residents, DATE_FORMAT(`date_last_edit`,'%d/%m/%Y %H:%i') as `date_last_edit_format`, prolong_garant, last_call_date,
			DATE_FORMAT(`date_added`,'%d/%m/%Y %H:%i') as `date_added_format`";
			
			$table = "`re_var` INNER JOIN re_user ON re_var.user_id = re_user.user_id INNER JOIN re_people ON re_user.people_id = re_people.id INNER JOIN re_company ON re_people.company_id = re_company.id INNER JOIN re_review ON re_var.id = re_review.var_id";
			
			$condition = "re_review.checked = 0 GROUP BY id order by re_var.active DESC";
			$data = DB::Select($columns, $table, $condition);
			$num = count($data);
			for($j=0; $j<$num; $j++)
			{
				$data[$j]['date_last_edit'] = Translate::month_ru($data[$j]['date_last_edit_format']);
				$data[$j]['date_added'] = Translate::month_ru($data[$j]['date_added_format']);
			}
			unset($columns, $table, $condition, $num, $j);
			return $data;
		}else{
			header("Location: http://". $_SERVER['SERVER_NAME']);
		}
	}
	
	public function review_list_for_admin()
	{
		if($_POST['id'] && $_SESSION['admin'] == 1){
			$table = "re_review INNER JOIN re_people ON re_review.people_id = re_people.id INNER JOIN re_company ON re_company.id = re_people.company_id";
			$condition = "var_id = ".$_POST['id'];
			$columns = "re_review.id, people_id, review, anonymous, review_date, company_name, name, second_name";
			$data = DB::Select($columns, $table, $condition);			
			$num = count($data);			
			for($r=0; $r<$num; $r++){
				echo "<div class='comment' data-id=".$data[$r]['id'].">
						<div class='center' style='margin-bottom: 10px;'>
							Жалоба ".($data[$r]['anonymous'] == 1 ? "админу" : "видна всем")." от {$data[$r]['name']} {$data[$r]['second_name']} АН: «{$data[$r]['company_name']}» ".date("d.m.Y H:i", strtotime($data[$r]['review_date']))."<a href='javascript:void(0)' onClick='DeleteReview(".$data[$r]['id'].")' class='right' style='margin-right:5px'>удалить</a>
						</div>
						<hr>
						<p style='margin-left: 10px;'>".$data[$r]['review']."</p>
					</div>";
			}
			unset($columns, $table, $condition, $num, $r, $data);
		}else{
			header("Location: http://". $_SERVER['SERVER_NAME']);
		}
	}

	public function checked_review()
	{
		if($_SESSION['admin'] == 1 && $_POST['var_id']){
			DB::Update("re_review", "checked=1", "var_id=".$_POST['var_id']);
		}else{
			header("Location: http://". $_SERVER['SERVER_NAME']."/?task=login&action=logout");
		}
	}
	
	public function delete_review(){
		if($_SESSION['admin'] == 1 && $_POST['id']){
			$res = mysql_query("select count(*)-1 as count, var_id from re_review where var_id=(SELECT var_id from re_review where id = ".$_POST['id'].") and anonymous = 0 and checked = 0");
			DB::Delete("re_review", "id=".$_POST['id']);
			$result = mysql_fetch_assoc($res);
			if($result["count"]<=0){
				DB::Update("re_var", "review=0", "id=".$result["var_id"]);
			}
		}else{
			header("Location: http://". $_SERVER['SERVER_NAME']."/?task=login&action=logout");
		}
	}

	public function street_change()
    {
        if($_SESSION['admin'] == 1 && $_POST['id']&& $_POST['street']){
            $update = DB::Update("re_pay_parse", "street='{$_POST['street']}'",
                "id=".$_POST['id']);
            if(!empty($update)){
                echo 'OK';
                return true;
            }
        }else{
            header("Location: http://". $_SERVER['SERVER_NAME']."/?task=login&action=logout");
        }
    }

	public function address_change()
    {
        if($_SESSION['admin'] == 1 && $_POST['id']&& $_POST['address']){
            $var = current(DB::Select('dis,street,house','re_pay_parse',"id=".$_POST['id']));
            $address = explode(',', $_POST['address']);

            $distinctCh = !empty($address[0]) ? ", `dis` =  '".trim(Translate::districtAbbrBack($address[0]))."'" : "";
            $strCh = !empty($address[1]) ? ", street = '".trim($address[1])."'" : "";
            $houseCh = !empty($address[1]) ? ", house = '". trim($address[2])."'" : "";

            $update = DB::Update("re_pay_parse", "modified = NOW() {$distinctCh} {$strCh} {$houseCh}",
                "id=".$_POST['id']);
            if(!empty($update)){
                $dis = !empty($address[0]) ? $address[0] : Translate::districtAbbr($var['dis']);
                $street = !empty($address[1]) ? $address[1] : $var['street'];
                $house = !empty($address[2]) ? $address[2] : $var['house'];
                echo "{$dis}. {$street} {$house}";
                return true;
            }
        }else{
            header("Location: http://". $_SERVER['SERVER_NAME']."/?task=login&action=logout");
        }
    }

	public function user_list()
	{
		if($_SESSION['user'] == 1){
			
			$active = isset($_GET['active']) && $_GET['active']==0 ? " AND DATE_FORMAT(sell_date_end, '%Y-%m-%d') < DATE_FORMAT(NOW(), '%Y-%m-%d')" : "";
			$activeOrder = $_GET['active']==0 ? " sell_date_end DESC": " company_name ASC ";

			if($_GET['online']==1){
				  $data = DB::Select("p.mesenger_id, c.id, c.fortuna_mid, c.company_name, a.sell_date_end, a.sell_date_end, a.pay_parse_date_end",
				  	"re_company as c, re_access_date_end as a, re_session as s, re_people as p",
				  		 "c.id = a.company_id AND p.company_id = c.id AND s.people_id = p.id AND 
				  		 DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -5 MINUTE), '%Y%m%d%H%i%s') < DATE_FORMAT(s.date_update, '%Y%m%d%H%i%s') AND 
				  		 company_name!='' ORDER BY {$activeOrder}");
			}else 
				if($_GET['pay_parse']==1){
				$data = DB::Select("p.mesenger_id, c.id, c.fortuna_mid, c.company_name, a.sell_date_end, a.sell_date_end, a.pay_parse_date_end",
						"re_company as c, re_access_date_end as a, re_people as p", 
						"c.id = a.company_id AND p.company_id = c.id AND a.pay_parse_date_end>NOW() AND company_name!='' GROUP BY company_name ORDER BY {$activeOrder}");
			}else 
				if($_GET['buy_sell']==1){
				$data = DB::Select("p.mesenger_id, c.id, c.fortuna_mid, c.company_name, a.sell_date_end, a.sell_date_end, a.pay_parse_date_end, a.pay_parse_date_end",
						"re_company as c, re_access_date_end as a, re_people as p", 
						"c.id = a.company_id AND p.company_id = c.id AND a.sell_date_end>NOW() AND company_name!='' GROUP BY company_name ORDER BY {$activeOrder}");
			}else 
				if($_GET['free_ip']==1){
				$data = DB::Select("p.mesenger_id,c.id, c.fortuna_mid, c.company_name, a.sell_date_end, a.sell_date_end, a.pay_parse_date_end",
						"re_company as c, re_access_date_end as a, re_people as p, re_addresses as ad", 
						"ad.people_id = p.id AND c.id = a.company_id AND p.company_id = c.id AND ad.ip=1 AND ad.active = 1 AND company_name!='' GROUP BY company_name ORDER BY {$activeOrder}");
			}else 
				if(isset($_GET['order_access']) && $_GET['order_access']==0){
				$data = DB::Select("p.mesenger_id,c.id, c.fortuna_mid, c.company_name, a.sell_date_end, a.sell_date_end, a.pay_parse_date_end",
						"re_company as c, re_access_date_end as a, re_people as p", 
						"c.id = a.company_id AND p.company_id = c.id AND c.order_access=0 AND company_name!='' GROUP BY company_name ORDER BY {$activeOrder}");
			}else 
				if(isset($_GET['duty']) && $_GET['duty']==1){
				$data = DB::Select("p.mesenger_id,c.id, c.fortuna_mid, c.company_name, a.sell_date_end, a.sell_date_end, a.pay_parse_date_end",
						"re_company as c, re_access_date_end as a, re_people as p", 
						"c.id = a.company_id AND p.company_id = c.id AND c.duty>0 AND company_name!='' GROUP BY company_name ORDER BY {$activeOrder}");
			}else{
				$data = DB::Select("re_people.mesenger_id, re_company.id, re_company.fortuna_mid, re_company.company_name, re_access_date_end.sell_date_end, re_access_date_end.sell_date_end, re_access_date_end.pay_parse_date_end",
						"re_company INNER JOIN re_access_date_end ON re_company.id=re_access_date_end.company_id
						INNER JOIN re_people ON re_people.company_id = re_company.id",
						"company_name!='' {$active}
						GROUP BY company_name 
						 ORDER BY {$activeOrder}, mesenger_id ASC");
			}
			return $data;
		} else {
			header("Location: http://". $_SERVER['SERVER_NAME']);
		}
	}
	
	public function find_an()
	{
		if($_SESSION['admin'] == 1 && ($_POST['an'] OR $_GET['an']) ){

			$an = !empty($_POST['an'])?$_POST['an']:$_GET['an'];
			$data = DB::Select("re_people.mesenger_id, re_company.id, re_company.fortuna_mid, re_company.company_name, re_access_date_end.sell_date_end, re_access_date_end.sell_date_end, re_access_date_end.pay_parse_date_end",
					"re_company INNER JOIN re_access_date_end ON re_company.id=re_access_date_end.company_id
								INNER JOIN re_people ON re_people.company_id = re_company.id",
					 "company_name like '%{$an}%'
					  GROUP BY company_name ORDER BY company_name ASC, mesenger_id ASC");
			return $data;
		}else{
			header("Location: http://". $_SERVER['SERVER_NAME']."/?task=login&action=logout");
		}
	}
	
	public function find_employee()
	{
		if($_SESSION['admin'] == 1 && $_POST['login']){
			$data = DB::Select("re_company.id, re_company.fortuna_mid, re_company.company_name, re_access_date_end.sell_date_end, 
				re_access_date_end.sell_date_end, re_access_date_end.pay_parse_date_end", 
				
				"re_user INNER JOIN re_people ON re_user.people_id = re_people.id	INNER JOIN re_company ON re_people.company_id = re_company.id INNER JOIN re_access_date_end ON re_people.company_id = re_access_date_end.company_id", "login = '".$_POST['login']."' ORDER BY parent");
			return $data;
		}else{
			header("Location: http://". $_SERVER['SERVER_NAME']."/?task=login&action=logout");
		}
	}
	
	public function find_phone()
	{
		if($_SESSION['admin'] == 1 && $_POST['phone']){
			$data = DB::Select("re_company.id, re_company.fortuna_mid, re_company.company_name, re_access_date_end.sell_date_end, re_access_date_end.sell_date_end, re_access_date_end.pay_parse_date_end", "re_user INNER JOIN re_people ON re_user.people_id = re_people.id	INNER JOIN re_company ON re_people.company_id = re_company.id INNER JOIN re_access_date_end ON re_people.company_id = re_access_date_end.company_id", "phone = '".$_POST['phone']."' OR phone_addon like '%".$_POST['phone']."%' OR phone_for_archive like '".$_POST['phone']."' OR phone_archive like '".$_POST['phone']."' ORDER BY parent");
			return $data;
		}else{
			header("Location: http://". $_SERVER['SERVER_NAME']."/?task=login&action=logout");
		}
	}
	
	public function find_fio(){
		if($_SESSION['admin'] == 1){
			$mobile = $_POST['mobile']==1?" re_addresses.`mob` = '1'  AND":'';
			$data = DB::Select("re_company.id, re_company.fortuna_mid, re_company.company_name, re_access_date_end.sell_date_end, re_access_date_end.sell_date_end",
			 					"re_user 
			 		  INNER JOIN re_people ON re_user.people_id = re_people.id 
			 		  INNER JOIN re_company ON re_people.company_id = re_company.id 
			 		  INNER JOIN re_access_date_end ON re_people.company_id = re_access_date_end.company_id 
			 		  INNER JOIN re_addresses ON re_people.id = re_addresses.people_id", 
						 "
						 `surname` like '%{$_POST['surname']}%' AND 
						 `name` like '%{$_POST['name']}%' AND 
						 `second_name` like '%{$_POST['second_name']}%' AND 
						 {$mobile}
						 `ip` like '%{$_POST['ip']}%' 

						 ORDER BY parent ASC");
			return $data;
		}else{
			session_destroy();
		}
	}
	
	public function save_profile()
	{
		$cur_date = date("Y-m-d H:i:s");
		if($_SESSION['admin']==1 AND isset($_POST['company_id'])){
			$fio = Get_functions::Get_fio_by_pnone($_POST['pe-phone']);
			if($fio['pe-surname'] == "" && $fio['pe-name'] == ""){			
				$people_id = Get_functions::Get_people_id_by_login($_POST['us-login']);
				$fio = Get_functions::Get_fio_by_people_id($people_id);
				if($people_id == ""){
					unset($people_id);
					$query = "SELECT * FROM `re_people` WHERE `surname` LIKE '%".$_POST['pe-surname']."%' AND `name` LIKE '%".$_POST['pe-name']."%' AND `second_name` LIKE '%".$_POST['pe-second_name']."%' AND `date_dismiss` = '0000-00-00 00:00:00'";
					$peoples = mysql_query($query);
					$company_name = Get_functions::Get_company_name_by_id(mysql_fetch_assoc($peoples)['company_id']);
					$peoples_num = mysql_num_rows($peoples);
					if($peoples_num == 0){
						$parent_id = mysql_fetch_assoc(mysql_query("select user_id from re_user INNER JOIN re_people on re_user.people_id = re_people.id where company_id = ".$_POST['company_id']." AND re_user.parent = 0"))['user_id'];
						
						foreach($_POST as $k=>$v){				
							if($v!=""){
								if(ereg('us-', $k)){
									$k = explode('-', $k)[1];
									$values_user.= "'".$v."', ";
									$columns_user.= "`".$k."`, ";
									$condition_user.= "`".$k."`='".$v."', ";
								}else if(ereg('pe-', $k)){
									$k = explode('-', $k)[1];									
									$values_people.= "'".$v."', ";
									$columns_people.= "`".$k."`, ";
									$condition_people.= "`".$k."`='".$v."' AND ";
								}else if(ereg('ad-', $k)){
									if(ereg('ad-rent', $k)){
										$k = explode('-', $k)[2];		
										$values_address_rent.= "'".$v."', ";
										$columns_address_rent.= "`".$k."`, ";
										$condition_address_rent.= "`".$k."`='".$v."' AND ";
									}else if(ereg('ad-sell', $k)){
										$k = explode('-', $k)[2];
										$values_address_sell.= "'".$v."', ";
										$columns_address_sell.= "`".$k."`, ";
										$condition_address_sell.= "`".$k."`='".$v."' AND ";
									}
								}
							}
						}
						if($values_people){	
							$columns_people.="`date_reg`, `company_id`";
							$values_people.="'".$cur_date."', ".$_POST['company_id'];
							$condition_people.=" company_id=".$_POST['company_id'];
							$data = DB::Insert("re_people", $columns_people, $values_people);
							$people_id = DB::Select("id", "re_people", $condition_people)[0]['id'];
						}
						if(isset($people_id)){
							if(isset($values_user)){
								$columns_user.="`people_id`, `parent`";
								$values_user.="'".$people_id."', '".$parent_id."'";
								$data = DB::Insert("re_user", $columns_user, $values_user);
							}
							if(isset($values_address_rent)){
								$columns_address_rent.="`active`, `rent`, `people_id`";
								$values_address_rent.="'1', '1', ".$people_id;
								$data = DB::Insert("re_addresses", $columns_address_rent, $values_address_rent);
							}
							if(isset($values_address_sell)){
								$columns_address_sell.="`active`, `sell`, `people_id`";
								$values_address_sell.="'1', '1', ".$people_id;
								$data = DB::Insert("re_addresses", $columns_address_sell, $values_address_sell);								
							}
							
								@mkdir($_SERVER['DOCUMENT_ROOT'] .'/images/'. $people_id, 0777);
								$document_dir = $_SERVER['DOCUMENT_ROOT'] .'/images/'. $people_id .'/documents';
								$user_face_dir = $_SERVER['DOCUMENT_ROOT'] .'/images/'. $people_id .'/user_face';
								@mkdir($document_dir, 0777);
								@mkdir($user_face_dir, 0777);
								// $face_type = explode('/', $_FILES['face']['type'])[1];
								// $doc_type = explode('/', $_FILES['passport']['type'])[1];
							try{	
								$document_file = PhpThumbFactory::create($_FILES['passport']['tmp_name']);
								$document_file->resize(600);
								$document_file->save($document_dir."/document.jpg");
							}catch(Exception $ex){}
							try{
								$face_file = PhpThumbFactory::create($_FILES['face']['tmp_name']);
								$face_file->resize(600);
								$face_file->save($user_face_dir."/face.jpg");
							}catch(Exception $ex){}
							
							if($_POST['old-people-id']>0){
								$old_people = DB::Select("count(*) as c", "re_people", "id={$_POST['old-people-id']} AND surname='{$_POST['pe-surname']}' AND name='{$_POST['pe-name']}' AND surname='{$_POST['pe-surname']}'")[0]["c"];
								if($old_people>0){
									$user = DB::Select("user_id", "re_user", "people_id=".$people_id)[0]["user_id"];
									DB::Update("re_var", "user_id={$user}, owner_people_id=null", "owner_people_id=".$_POST['old-people-id']);
									DB::Update("re_photos", "people_id=".$people_id, "people_id=".$_POST['old-people-id']);
									$old_dir = $_SERVER['DOCUMENT_ROOT'] .'/images/'.$_POST['old-people-id'];
									if(file_exists($old_dir)){
										if ($objs = glob($old_dir."/*")){
											foreach($objs as $obj) {
												if(is_dir($obj)){
													$new_dir = str_replace("/images/".$_POST['old-people-id'], "/images/".$people_id, $obj);
													rename($obj, $new_dir);
												}
											}
										}
										Helper::removeDirectory($old_dir);
									}
								}
							}
							$data = "Готово!";
						}
					}else{$data = "Данный риелтер работает в агенстве '".$company_name."'";}
				}else{$data =  "Логин '".$_POST['login']."' прикреплён за '".$fio."'";}
			}else{$data =  "Телефон '".$_POST['phone']."' прикреплён за '".$fio['surname']." ".$fio['name']." ".$fio['second_name']."'";}
		}else{
			header("Location: http://". $_SERVER['SERVER_NAME']);
		}
		unset($cur_date, $fio);
		return $data;
	}
	
	public function applications(){
		if($_SESSION['admin']==1){
			$data = DB::Select("*", "re_applications", "archive = '0'");
			return $data;
		}else{
			header("Location: http://". $_SERVER['SERVER_NAME']);
		}
	}
	
	public function application_to_archive(){
		if($_SESSION['admin']==1 && $_POST){
			DB::Update("re_applications", "archive = '1'", "id=".$_POST['id']);			
		}else{
			header("Location: http://". $_SERVER['SERVER_NAME']);
		}
	}
	
	public function messages(){
		if($_SESSION['admin']==1){
			$data = DB::Select("id, people_id_from, login_from, people_id_to, text, DATE_ADD(date_send, INTERVAL -1 hour) as date_send, new, spec_recipient, archive, max(new)", "re_messages", "people_id_to={$_SESSION['people_id']} AND archive=0 GROUP BY people_id_from ORDER BY max(new) DESC, date_send DESC");
			return $data;
		}else{
			header("Location: http://". $_SERVER['SERVER_NAME']);
		}
	}
	
	public function messages_list(){
		if(isset($_SESSION['user']) && isset($_POST['to']) && isset($_POST['from'])){
			$fio =  $_POST['fio'];
            $messages = DB::Select("re_messages.id mess_id, 
            people_id_from, login_from, re_messages.text, DATE_ADD(date_send, INTERVAL -1 hour) as date_send, company_name, phone, archive",
						"re_messages INNER JOIN re_people ON re_messages.people_id_from = re_people.id INNER JOIN re_company ON re_people.company_id=re_company.id", 
						"(people_id_from=".$_POST['from']." AND people_id_to=".$_POST['to'].") 
						OR (people_id_to=".$_POST['from']." AND people_id_from=".$_POST['to'].") AND re_messages.archive = 0
						    ORDER BY date_send DESC");
			
			DB::Update("re_messages", 
						"`new`='0'", 
						"people_id_from='".$_POST['from']."' AND people_id_to='".$_POST['to']."'");
            foreach ($messages as $message)
            {
                if($message['archive'] == 1)
                    continue;
				if($message['people_id_from'] == $_POST['from'])
				{
					if($_SESSION['admin'] == 1)
					{
						$title = $message['login_from']." АН «".$message['company_name']."» ".$fio." т.:".$message['phone']." ".$message['date_send'];
					}else{
						$title = $fio." ".$message['date_send'];
					}
					echo "<div class='item info'><div class='question' data-id='".$_POST['from']."'>".$title."</div>".$message['text']."</div>";
				}else{
					echo "<div class='item info' style='text-align: right;'><div class='reply'>".$_SESSION['fio']." ".$message['date_send']."</div>".$message['text']."</div>";
				}
			}			
		}else{
			header("Location: http://". $_SERVER['SERVER_NAME']);
		}
	}

	public function street_error()
    {
        if($_SESSION['admin'] == 1 )
        {
            return  DB::Select(
                'id, street, created, link', 're_pay_parse',
                'created > (NOW() - INTERVAL 7 DAY) AND 
                (street LIKE "%ул.%" OR 
                street LIKE "%ул %" OR
                street LIKE "% ул%" OR
                street LIKE "%ул.%" OR
                street LIKE "%улица%" OR
                street LIKE "%имени%" OR
                street LIKE "% им%" OR
                street LIKE "%им %"   )              
                ORDER BY  created DESC'
            );
        }
    }

	public function message_reply(){
		if(isset($_SESSION['user']) && isset($_POST['people_id_to'])){
			$date = date("Y-m-d H:i:s");
			$columns = "`people_id_from`, `login_from`, `people_id_to`, `text`, `date_send`, `new`";
			$values = $_SESSION['people_id'].", '{$_SESSION['login']}', {$_POST['people_id_to']}, '{$_POST['content']}', '{$date}', 1";
			DB::Insert("re_messages", $columns, $values);
			unset($date, $columns, $values);
		}else{
			header("Location: http://". $_SERVER['SERVER_NAME']);
		}
	}
	
	public function send_message(){
		if($_SESSION['admin'] == 1 && $_POST['text'] != ""){
			$date = date("Y-m-d H:i:s");
			$columns = "`people_id_from`, `login_from`, `people_id_to`, `text`, `date_send`, `new`, spec_recipient";
			if($_POST['user_id']=='directors'){
				//$values = $_SESSION['people_id'].", '".$_SESSION['login']."', 0, '".$_POST['text']."', '".$date."', 1";
				$peoples=DB::Select("p.id", "re_people as p, re_user as u", "u.people_id = p.id AND u.parent=0");
				$count=count($peoples);
				for($i=0; $count>$i; $i++){
					$data = DB::Insert("re_messages", "`people_id_from`, `login_from`, `people_id_to`, `text`, `date_send`", "'{$_SESSION['people_id']}', '{$_SESSION['login']}', '{$peoples[$i]['id']}', '{$_POST['text']}', '{$date}'");
				}
				if($data == "1"){
					$data = "<div style='margin: 20px;color: rgb(78, 202, 58);'>Сообщение отправлено всем директорам</div>";
				}
			}else if($_POST['user_id']=='all'){
				//$values = $_SESSION['people_id'].", '".$_SESSION['login']."', 0, '".$_POST['text']."', '".$date."', 1, 'all'";
				$peoples=DB::Select("p.id", "re_people as p, re_user as u", "u.people_id = p.id");
				$count=count($peoples);
				for($i=0; $count>$i; $i++){
					$data = DB::Insert("re_messages", "`people_id_from`, `login_from`, `people_id_to`, `text`, `date_send`", "'{$_SESSION['people_id']}', '{$_SESSION['login']}', '{$peoples[$i]['id']}', '{$_POST['text']}', '{$date}'");
				}
				if($data == "1"){
					$data = "<div style='margin: 20px;color: rgb(78, 202, 58);'>Сообщение отправлено всем активным пользователям сайта</div>";
				}
			}else{
				$people_id = Get_functions::Get_people_id_by_user_id($_POST['user_id']);
				$values = $_SESSION['people_id'].", '".$_SESSION['login']."', ".$people_id.", '".str_replace("'", "", $_POST['text'])."', '".$date."', 1, ''";
				$data = DB::Insert("re_messages", $columns, $values);
				if($data == "1"){
					$data = "<div style='margin: 20px;color: rgb(78, 202, 58);'>Сообщение отправлено</div>";					
				}
				
			}			
		}else{
			$data = "<div style='margin: 20px;color: #CA3A3A;'>Сообщение не может быть пустым!</div>";
		}
		return $data;
	}
	
	public function message_to_archive()
    {
        if(!Helper::FilterVal('id')){
            return false;
        }
        $message = current(DB::Select("people_id_to",'re_messages', "id=".Helper::FilterVal('id')));
        if($message['people_id_to']==$_SESSION['people_id']){
            DB::Update("re_messages", "archive=1","id=".Helper::FilterVal('id'));
        }
	}
	
	public function delete_message()
    {
        if(!Helper::FilterVal('id')){
            return false;
        }
        $message = current(DB::Select("people_id_to",'re_messages', "id=".Helper::FilterVal('id')));
        if($message['people_id_to']==$_SESSION['people_id']){
			DB::Delete("re_messages", "id=".Helper::FilterVal('id'));
		}
	}
	
	public function check_rielter()
	{
		if($_SESSION['user'] && !empty($_POST)){
			$date = date("Y-m-d H:i:s");
			$check_list = DB::Select("re_check_rielter.id, people_id, search_str, search_result, date_search, check_comment, second_name, name, phone",
					 "re_check_rielter INNER JOIN re_people ON re_check_rielter.people_id = re_people.id", 
					 "search_str = '".$_POST['phone']."' ORDER BY `date_search` DESC  LIMIT 1,500");

			$continue = $check_list[0]['people_id'] != $_SESSION['people_id'] ? true : false;

			if($_POST['search_type'] == "phone"){
				$company_id = $_POST["company_id"] == "" ? "" : "AND company_id=".$_POST["company_id"];
				$data = DB::Select(
					"parent, date_dismiss, second_name, name, phone, phone_addon, phone_archive, date_reg, company_name", 
					"re_people 
					INNER JOIN re_company ON re_people.company_id = re_company.id 
					INNER JOIN re_user ON re_people.id=re_user.people_id", 

					"(phone like '%".$_POST['phone']."%' OR phone_addon like '%".$_POST['phone']."%' OR phone_archive like '%".$_POST['phone']."%') ".$company_id." 
					ORDER BY date_dismiss DESC");
				$count = count($data);

				if($count > 0){
					for($s=0; $s<$count; $s++){
						$data[$s]['status'] = $data[$s]['date_dismiss'] == '0000-00-00 00:00:00' ? "работник агентства" : "<span style='color:red'>уволен, дата увольнения: ".date("d.m.Y H:i:s", strtotime($data[$s]['date_dismiss']))."</span>";
						
						if($data[$s]['parent'] != 0){
							$data[$s]['director'] = DB::Select("parent, date_dismiss, second_name, name, phone, phone_addon, phone_archive, date_reg, company_name", "re_people INNER JOIN re_company ON re_people.company_id = re_company.id INNER JOIN re_user ON re_people.id=re_user.people_id", "user_id='".$data[$s]['parent']."'")[0];
						}
					}
					$search_result = $data[0]['date_dismiss'] == '0000-00-00 00:00:00' ? 2 : 1;
				}else{
					$search_result = 0;
				}	

				if($continue){
					DB::Insert("re_check_rielter", "people_id, search_str, search_result, date_search", $_SESSION['people_id'].", '".$_POST['phone']."', ".$search_result.", '".$date."'");
				}

				$data['check_list'] = $check_list;
				unset($search_result, $count, $s, $check_list);
				return $data;
			}
		}else if($_SESSION['admin'] == 1 && $_GET['request'] == "all"){

			$day = 0;
			if(!empty($_GET['day'])) 
			{
				$day = $_GET['day']*1;
			}	

			$query = "SELECT  people_id, company_name, search_str, search_result, 
								DATE_ADD(date_search, INTERVAL -1 hour) as date_search, 
								check_comment, 
								second_name, 
								name, 
								phone, 
								variant
				FROM re_check_rielter 
					INNER JOIN re_people ON re_check_rielter.people_id = re_people.id 
					INNER JOIN re_company ON re_company.id = re_people.company_id 
				WHERE 
						`date_search` > DATE_FORMAT(DATE_SUB(NOW(), INTERVAL {$day} DAY), '%Y-%m-%d') 
						AND `date_search` < DATE_FORMAT(DATE_SUB(NOW(), INTERVAL ". ($day - 1)." DAY),'%Y-%m-%d')  
						AND `search_str` <> ''
						ORDER BY `date_search` DESC";
			$res = mysql_query($query);
			$num = mysql_num_rows($res);
			for($i=0; $i<$num; $i++)
			{
				$data['check_list'][] = mysql_fetch_assoc($res);
				$cnt = DB::SELECT('COUNT(search_str) as cnt', 're_check_rielter', "`search_str` = '".$data['check_list'][$i]['search_str']."'");
				$companyExist = DB::Select(" COUNT(re_company.id) as company_cnt", 
				 "re_user 
				 INNER JOIN re_people ON re_user.people_id = re_people.id	
				 INNER JOIN re_company ON re_people.company_id = re_company.id 
				 INNER JOIN re_access_date_end ON re_people.company_id = re_access_date_end.company_id", 
				 "(phone like '%".$data['check_list'][$i]['search_str']."%' OR phone_addon like '%".$data['check_list'][$i]['search_str']."%' OR phone_archive like '%".$data['check_list'][$i]['search_str']."%')"
				 );
				
				$data['check_list'][$i]['cnt'] = $cnt[0]['cnt'];
				$data['check_list'][$i]['company_cnt'] = $companyExist[0]['company_cnt'];
			}			
	
			unset($query, $res, $num, $i);
			return $data;
		}
	}
	
	public function order(){
		if($_SESSION['admin'] == 1){
		    $conditions = '';
		    (Helper::FilterVal('archive') == 1) ? $conditions = ' AND archive = 1 ' :'';
		    (Helper::FilterVal('active') == 1) ? $conditions = ' AND archive = 0 ' :'';
			$tinkoffPayments = DB::Select('
                payment.id id,
                payment.`sum` sum, 
                payment.`date_order` created,
                payment.`pay_date` pay_date,
                payment.`order_type` order_type,
                payment.`order_place` order_place,
                payment.`comment_order` comment,
                payment.`archive` archive,
                company.id company_id,
                company.company_name company_name',
                're_order payment
                    INNER JOIN re_company company ON payment.company_id = company.id',
                "1 {$conditions} ORDER BY payment.id DESC");

            return $tinkoffPayments;
		}else{
			header("Location: http://". $_SERVER['SERVER_NAME']);
		}
	}
	
	public function order_check(){
		if($_SESSION['admin'] == 1 && $_POST){
			DB::Update("re_order", "active=0", "`id`=".$_POST['id']);
		}else{
			header("Location: http://". $_SERVER['SERVER_NAME']);
		}
	}
	
	public function order_to_archive(){
	    $tableName = isset($_POST["name"]) ? $_POST["name"] : 'order';
		if($_SESSION['admin']==1 && $_POST["id"]){
			DB::Update("re_{$tableName}", "archive=1", "id={$_POST['id']}");
		}
	}
	
	public function delete_order(){
		if($_SESSION['admin']==1 && isset($_POST["id"]) && isset($_POST['name'])){
			DB::Delete("re_{$_POST['name']}", "id={$_POST['id']}");
		}
	}

	public function delete_tinkoff_payment(){
		if($_SESSION['admin']==1 && isset($_POST["id"]) && isset($_POST['name'])){
			DB::Delete("re_{$_POST['name']}", "id={$_POST['id']}");
		}
	}
	
	public function enter_statistics(){
		if($_SESSION["admin"]==1)
		{

			if($_POST["login"]){
				$data = DB::Select("id, people_id, login, ip, browser, DATE_FORMAT(DATE_ADD(date_enter, INTERVAL -1 hour),
				 '%d.%m.%Y %H:%i:%s') as date_enter",
                    "re_enter_statistics",
                    "login=".$_POST["login"]." ORDER BY id DESC");
				return $data;
			}
		}
	}
	
	public function callboard(){
		if($_SESSION["admin"]==1 && $_GET["callboard_topic"])
		{
			$columns = "re_callboard.id, re_callboard.text, re_people.id as people_id, DATE_FORMAT(re_callboard.date,'%d.%m.%Y %H:%i') as date, name, phone, company_name, photo";
			$table = "re_callboard INNER JOIN re_people ON re_people.id=re_callboard.people_id INNER JOIN re_company ON re_company.id=re_people.company_id";
			$data = DB::Select($columns, $table, "callboard_topic = '".$_GET["callboard_topic"]."' ORDER BY id DESC");
			unset($columns, $table);
			return $data;
		}
	}
	
	public function forum(){
		
	}
	
	public function change_group_id()
	{
		if($_SESSION["admin"]==1){
			DB::Update("re_user", "group_topic_id=".$_POST["group"], "user_id=".$_POST["user_id"]);
            $condition = "sell=1, rent=0";
			$people_id = Get_functions::Get_people_id_by_user_id($_POST["user_id"]);
			DB::Update("re_addresses", $condition, "people_id=".$people_id);
		}
	}
	
	public function services_list_show()
	{
		if($_SESSION["admin"]==1){
			$res = mysql_query("(SELECT p.id, p.company_id, p.month_count, p.day_count, p.premium_count, p.sum, p.date_finish, p.date_payment, p.comment from re_payment as p where company_id = '".$_POST["id"]."') UNION (SELECT a.id, a.company_id, null, null, null, a.comment, a.date, a.date, null from re_applications as a where company_id = '".$_POST["id"]."' and `comment` like '%оплачено%') ORDER BY date_payment DESC");
			$count = mysql_num_rows($res);
			for($i=0; $i<$count; $i++){
				$res_data[] = mysql_fetch_assoc($res); 
			}
			$data["payment_list"] = $res_data;
			unset ($res, $count, $i, $res_data);
			return $data;
		}
	}
	
	public function order_list_show()
	{
		if($_SESSION["admin"]==1){
			$res = mysql_query("SELECT o.id, o.active, order_type, sum, comment_order, DATE_ADD(date_order, INTERVAL -1 hour) as date_order, wallet_num, order_place, pay_date, comment_pay, company_name, company_id FROM re_order as o, re_company as c WHERE o.company_id ='".$_POST['id']."' AND o.company_id = c.id ORDER BY date_order DESC");
			$count = mysql_num_rows($res);
			for($i=0; $i<$count; $i++){
				$res_data[] = mysql_fetch_assoc($res); 
			}
			$data["order_list"] = $res_data;
			unset ($res, $count, $i, $res_data);
			return $data;
		}
	}
	
	public function check_input(){
		if($_SESSION["admin"]==1 && isset($_POST)){
			if(!isset($_POST["fio"])){
				if(isset($_POST["company_name"])){
					$res = mysql_query("SELECT company_name FROM re_company WHERE company_name like '".$_POST["company_name"]."%' limit 0,5");
					while($result = mysql_fetch_assoc($res)){						
						echo "<li>".$result["company_name"]."</li>";
					}
				}else if(isset($_POST["login"])){
					$res = mysql_query("SELECT login FROM re_user WHERE login like '".$_POST["login"]."%' limit 0,5");
					while($result = mysql_fetch_assoc($res)){
						echo "<li>".$result["login"]."</li>";
					}
				}else if(isset($_POST["surname"])){
					$res = mysql_query("SELECT surname FROM re_people WHERE surname like '".$_POST["surname"]."%' limit 0,5");
					while($result = mysql_fetch_assoc($res)){
						echo "<li>".$result["surname"]."</li>";
					}
				}else if(isset($_POST["name"])){
					$res = mysql_query("SELECT name FROM re_people WHERE name like '".$_POST["name"]."%' limit 0,5");
					while($result = mysql_fetch_assoc($res)){
						echo "<li>".$result["name"]."</li>";
					}
				}else if(isset($_POST["second_name"])){
					$res = mysql_query("SELECT second_name FROM re_people WHERE second_name like '".$_POST["second_name"]."%' limit 0,5");
					while($result = mysql_fetch_assoc($res)){
						echo "<li>".$result["second_name"]."</li>";
					}
				}else if(isset($_POST["phone"])){
					$res = mysql_query("SELECT phone FROM re_people WHERE phone like '".$_POST["phone"]."%' limit 0,5");
					while($result = mysql_fetch_assoc($res)){
						echo "<li>".$result["phone"]."</li>";
					}
				}
			}
			
			unset($_POST, $res, $result);
		}
	}
	
	public function recipients()
	{
		if($_SESSION["admin"] == 1){
			$data = DB::Select("GROUP_CONCAT(DISTINCT r.text) as ids, r.id, r.address, DATE_FORMAT(DATE_ADD(r.date, INTERVAL -1 hour), '%d.%m.%Y %H:%i') as date, CONCAT_WS(' ',p.second_name,p.name,p.surname) as fio, c.company_name", "re_recipients_list as r, re_people as p, re_company as c", "r.people_id = p.id AND p.company_id = c.id GROUP BY address, DATE(date) ORDER BY r.date DESC");
			return $data;
		}
	}
	
	public function delete_statistic(){
		if(isset($_POST['user']) && $_SESSION['admin']==1){
			$people_id = Get_functions::Get_people_id_by_user_id($_POST['user']);
			DB::Delete("re_session", "people_id={$people_id}");			
		}
	}
	
	public function delete_callboard(){
		if($_SESSION["admin"]==1 && isset($_POST['id'])){
			$query = mysql_query("SELECT people_id FROM re_callboard WHERE id={$_POST['id']}");
			$people_id = mysql_fetch_assoc($query)["people_id"];
			$dir = $_SERVER['DOCUMENT_ROOT'] ."/images/{$people_id}/callboard/{$_POST['id']}";
			if(file_exists($dir)){
				if ($objs = glob($dir."/*")) {
				   foreach($objs as $obj) {
						unlink($obj);
				   }
				}
				rmdir($dir);
			}
			DB::Delete("re_callboard", "id={$_POST['id']}");
		}
	}
	
	public function delete_parse(){
		if($_SESSION["admin"]==1 && isset($_POST['id']) && isset($_POST['name'])){
			DB::Delete("re_{$_POST['name']}", "id={$_POST['id']}");
		}
	}
	
	public function trusted(){
		if($_SESSION["admin"]==1 && isset($_POST["id"])){
			if($_POST['trusted']=="true"){
				DB::Update("re_user", "for_open_site=2", "user_id={$_POST['id']}");
			}else{
				DB::Update("re_user", "for_open_site=0", "user_id={$_POST['id']}");
			}
		}
	}
	
	public function delete_photos(){
		if(isset($_POST['id']) && $_SESSION['admin']==1){
			$people_id = DB::Select("people_id", "re_var as v, re_user as u", "v.user_id=u.user_id and v.id=".$_POST['id'])[0]["people_id"];
			$dir = $_SERVER['DOCUMENT_ROOT'] .'/images/'. $people_id .'/'. $_POST['id'];
			Helper::removeDirectory($dir);
			DB::Delete("re_photos", "var_id=".$_POST['id']);
			DB::Update("re_var", "photo=0", "id=".$_POST['id']);
		}
	}
	
	public function delete_employe(){
		if(!isset($_POST['user_id']) || $_SESSION['admin']!=1) return null;

			$people_id = DB::Select("people_id", "re_user", "user_id=".$_POST['user_id'])[0]['people_id'];

			if(empty($people_id)) return null;

			$new_owner = DB::Select("people_id, user_id", "re_user", "user_id=(SELECT parent from re_user where user_id={$_POST['user_id']})")[0];
			$old_dir = $_SERVER['DOCUMENT_ROOT'] .'/images/'.$people_id;
			$old_dir_sample = '/var/www/arendanovosib/images/'.$people_id;
			$new_dir = $_SERVER['DOCUMENT_ROOT'] .'/images/'.$new_owner["people_id"];
			$condition = "people_id=".$people_id;
			DB::Delete("re_addresses", $condition);
			DB::Delete("re_applications", $condition);
			DB::Delete("re_black_list", "owner_people_id={$people_id} OR people_id=".$people_id);
			DB::Delete("re_callboard", $condition);
			DB::Delete("re_check_rielter", $condition);
			DB::Delete("re_enter_statistics", $condition);
			DB::Delete("re_forum", $condition);
			DB::Delete("re_forum_topic", $condition);
			DB::Delete("re_messages", "people_id_to={$people_id} OR people_id_from=".$people_id);
			DB::Delete("re_people", "id=".$people_id);
			DB::Delete("re_recipients_list", $condition);
			DB::Delete("re_review", $condition);
			DB::Delete("re_review_parse", $condition);
			DB::Delete("re_review_pay_parse", $condition);
			DB::Delete("re_session", $condition);
			DB::Delete("re_user", "user_id=".$_POST['user_id']);
			DB::Delete("re_white_list", "owner_people_id={$people_id} OR people_id=".$people_id);
			
			if(isset($_POST['all']) && $_POST['all']==1){
				DB::Delete("re_var", "user_id=".$_POST['user_id']);
				DB::Delete("re_photos", $condition);
				Helper::removeDirectory($old_dir);
				Helper::removeDirectory($old_dir_sample);
			}else{
				DB::Update("re_var", "user_id=".$new_owner["user_id"], "user_id=".$_POST['user_id']);
				DB::Update("re_photos", "people_id=".$new_owner["people_id"], "people_id=".$people_id);
				if(file_exists($old_dir)){
					Helper::removeDirectory($old_dir."/documents");
					Helper::removeDirectory($old_dir."/user_face");
					if ($objs = glob($old_dir."/*")){
						foreach($objs as $obj) {
							if(is_dir($obj)){
								$new_dir = str_replace("/images/".$people_id, "/images/".$new_owner["people_id"], $obj);
								rename($obj, $new_dir);
							}
						}
					}
					Helper::removeDirectory($old_dir);
					Helper::removeDirectory($old_dir_sample);
				}
			}
	}
	
	public function block_an(){
		if(isset($_POST['an_ip']) && $_SESSION['admin']==1){
			$user_ids = DB::Select("user_id", "re_people as p, re_user as u", "p.id = u.people_id AND company_id=".$_POST['an_ip']);
			foreach($user_ids as $user_id){
				DB::Update("re_user", "active=".$_POST['block'], "user_id=".$user_id['user_id']);
			}
		}
	}
	
	public function delete_an(){
		if( $_SESSION['admin']!=1)return null;
		if(!isset($_POST['an_id']) || empty($_POST['an_id'])) return null;
		
		$peoples = DB::Select("id", "re_people", "company_id=".$_POST['an_id']);
		foreach($peoples as $people){
			$people_id = $people['id'];
			$login = DB::Select("login", "re_user", "people_id=".$people_id)[0]["login"];		
			$user_id = DB::Select("user_id", "re_user", "people_id=".$people_id)[0]["user_id"];		
			$dir = $_SERVER['DOCUMENT_ROOT'] .'/images/'.$people_id;
			$dir_sample = '/var/www/arendanovosib/images/'.$people_id;	
			$condition = "people_id=".$people_id;
			DB::Delete("re_addresses", $condition);
			DB::Delete("re_applications", $condition);
			DB::Delete("re_black_list", "owner_people_id={$people_id} OR people_id=".$people_id);
			DB::Delete("re_callboard", $condition);
			DB::Delete("re_check_rielter", $condition);
			DB::Delete("re_enter_statistics", $condition);
			DB::Delete("re_forum", $condition);
			DB::Delete("re_forum_topic", $condition);
			DB::Delete("re_messages", "people_id_to={$people_id} OR people_id_from=".$people_id);
			DB::Delete("re_people", "id=".$people_id);
			DB::Delete("re_recipients_list", $condition);
			DB::Delete("re_review", $condition);
			DB::Delete("re_review_parse", $condition);
			DB::Delete("re_review_pay_parse", $condition);
			DB::Delete("re_session", $condition);
			DB::Delete("re_user", "`user_id`={$user_id}");
			DB::Delete("re_white_list", "owner_people_id={$people_id} OR people_id=".$people_id);
			DB::Delete("re_var", "`user_id`={$user_id}");
			DB::Delete("re_photos", $condition);
			DB::Delete("re_save_search", $condition);				
			DB::Delete("re_photo_statistic", "`login` = '{$login}'");			
			DB::Delete("re_chat", "`user_id` = {$user_id}");			
			if(file_exists($dir)){
				Helper::removeDirectory($dir);
				Helper::removeDirectory($dir_sample);
			}
		}
		DB::Delete("re_access_date_end", "company_id=".$_POST['an_id']);
		$an_name = DB::Select("company_name", "re_company", "id=".$_POST['an_id'])[0]["company_name"];
		DB::Delete("re_caution", "an='{$an_name}'");
		DB::Delete("re_company", "id=".$_POST['an_id']);
		DB::Delete("re_order", "company_id=".$_POST['an_id']);
		DB::Delete("re_payment", "company_id=".$_POST['an_id']);
	}
	
	public function new_street(){
		if($_SESSION['admin']==1 && isset($_POST['street'])){
			DB::Insert("re_street", "`name`", "'{$_POST['street']}'");
		}
	}
	
	public function change_status(){
		if($_SESSION['admin']==1 && isset($_POST['user_id'])){
			$user = DB::Select("login, parent", "re_user", "user_id=".$_POST['user_id'])[0];
			$old_dir_login = DB::Select("login", "re_user", "user_id=".$user['parent'])[0]['login'];
			DB::Update("re_user", "parent=".$_POST["user_id"], "parent={$user['parent']} AND user_id!=".$_POST['user_id']);
			DB::Update("re_user", "login='{$user['login']}', parent=".$_POST['user_id'], "user_id=".$user['parent']);
			DB::Update("re_user", "login='{$old_dir_login}', parent=0", "user_id=".$_POST['user_id']);
			$user_people_id = Get_functions::Get_people_id_by_user_id($_POST["user_id"]);
			$dir_people_id = Get_functions::Get_people_id_by_user_id($user["parent"]);
			DB::Delete("re_session", "people_id={$user_people_id} OR people_id={$dir_people_id}");
		}
	}
	
	public function find_dismiss_people(){
		if($_SESSION['admin']==1){
			$condition = "p.id = a.people_id AND c.id=p.company_id AND date_dismiss>0";
			if(isset($_POST['surname'])){
				$condition .= " AND surname='{$_POST['surname']}'";
			}
			if(isset($_POST['name'])){
				$condition .= " AND name='{$_POST['name']}'";
			}
			if(isset($_POST['second_name'])){
				$condition .= " AND second_name='{$_POST['second_name']}'";
			}
			$peoples = DB::Select("people_id, surname, name, second_name, company_name, phone, phone_addon, GROUP_CONCAT(ip) as ips, date_reg, date_dismiss", "re_people as p, re_addresses as a, re_company as c", $condition." GROUP BY people_id");
			
			if(count($peoples[0]["people_id"])>0){
				echo "<table class='table table-striped list'>
						<thead><tr><th>Фамилия</th><th>Имя</th><th>Отчество</th><th>Прошлое АН</th><th>Основной телефон</th><th>ip</th><th>Дата увольнения</th><th></th></tr></thead>
						<tbody>";
					foreach($peoples as $p){
						echo "<tr id='{$p['people_id']}'>";
						echo "<td data-id='surname'>{$p['surname']}</td>";
						echo "<td data-id='name'>{$p['name']}</td>";
						echo "<td data-id='second_name'>{$p['second_name']}</td>";
						echo "<td>{$p['company_name']}</td>";
						echo "<td data-id='phone'>{$p['phone']}</td>";
						echo "<td data-id='ips'>{$p['ips']}</td>";
						echo "<td>{$p['date_dismiss']}</td>";
						echo "<td data-id='choosePeople'>Выбрать</td></tr>";
					}
				echo "</tbody></table>";
			}
		}
	}
	
	public function update_archive_interval(){
		if(isset($_POST['interval'])){
			DB::Update("re_admin_data","for_archive_interval={$_POST['interval']}");
		}
	}


	public function functional_description(){
		if($_SESSION['admin'] == 1){
			if($_POST['new'] == 1 ){
				if($_POST['fd_name'] != '' &&  $_POST['fd_description'] != '')
					DB::Insert("re_description_list", "`name`,`description`, `created`, `modyfied`", "'{$_POST['fd_name']}', '{$_POST['fd_description']}', NOW(), NOW()");
			}
			if($_POST['update'] == 1 ){
				DB::Update("re_description_list", "description='{$_POST['fd_description']}', name='{$_POST['fd_name']}'", "id=".$_POST['id']);
			}
			if(isset($_POST['active'])){
				DB::Update("re_description_list", "actual='{$_POST['actual']}'", "id=".$_POST['id']);
			}
			

			$data = DB::Select("*", "re_description_list", " 1 ORDER BY `created` DESC ");
			return $data;
		}else{
			header("Location: http://". $_SERVER['SERVER_NAME']);
		}
	}
}
?>