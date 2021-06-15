<?php
class Model_Profile extends Model
{
	/**
	* Время сброса статуса гарантии при общем продлении 
	*/
	const ALL_PROLONG_TIME = "04:00:00";
	public $query_users = "re_user INNER JOIN re_people ON re_user.people_id = re_people.id	
								    INNER JOIN re_company ON re_people.company_id = re_company.id 
								    INNER JOIN re_access_date_end ON re_people.company_id = re_access_date_end.company_id";

    private $text_file = "application/includes/txt/rules.txt";
    private $text_file_tarifs = "application/includes/txt/tariffs.txt";
    private $text_file_orders = "application/includes/txt/orders.txt";



	public function get_data()
	{
		mysql_set_charset( 'utf8' );
		$query = "SELECT * FROM `re_data` where ((`user_id` = '". $_SESSION['user'] ."') AND (`active` = '1'))";
		$q_res = mysql_query($query);
		$data = array();
		$q_num = mysql_num_rows($q_res);
		return $data_res;
	}

    public function get_data_rules()
    {
        if(isset($_SESSION['people_id'])){
            $data = $this->text_file;
            return $data;
        }
    }

    public function get_data_tarifs()
    {
        if(isset($_SESSION['people_id'])){
            $data = $this->text_file_tarifs;
            return $data;
        }
    }

    public function my_sample()
    {
    	$data = [];
    	if(empty($_POST['sample_id'])) return $data;
        Helper::filterSampleVarsByActual($_POST['sample_id']);

		$colums_var = "re_var.id, re_var.user_id, re_var.fortuna_id as tid, re_var.photo, re_user.parent as user_parent,
            access_var, re_var.active, re_var.owner, ap_layout, re_var.parent_id, re_var.rent_type, re_var.commission, 
            col_date, re_company.company_name, re_people.name, re_people.id as people_id, re_people.second_name,
            re_people.phone, dis, planning, live_point, street, house, orientir, text, topic_id, type_id, price, copyright,
            date_last_edit, sq_all, sq_live, sq_k, sq_land, floor, floor_count, room_count, coords, deliv_period, 
            prepayment, utility_payment, deposit, furn, tv, washing, refrig, ap_view_date, ap_race_date, status,
            premium, favorit, ap_view_price, in_black_list, review, residents, hidden_text, val_bal, val_lodg, link,
            wc_type, heating, wash, water, sewage, torg, prolong_garant, last_call_date, last_call_date_ts, obmen, ipoteka, chist_prod,
            obmen, ipoteka, chist_prod, developer, construct_y, kvartal,own_type, y_done,wall_type, 
            DATE_FORMAT(DATE_ADD(`date_last_edit`, INTERVAL -1 hour),'%d/%m/%Y %H:%i') as `date_last_edit_format`, `park`,
            DATE_FORMAT(`date_added`,'%d/%m/%Y %H:%i') as `date_added_format`, re_var.keys, sleeping_area";

		$tableVars = "re_sample_var as samples
		   				INNER JOIN `re_var`on samples.var_id = re_var.id  
		   				INNER JOIN re_user ON re_var.user_id = re_user.user_id 
		   				INNER JOIN re_people ON re_user.people_id = re_people.id
		   				INNER JOIN re_company ON re_people.company_id = re_company.id";

		$dataVars = DB::Select($colums_var, $tableVars,
								"samples.sample_id = {$_POST['sample_id']} AND type = 'ag' AND re_var.`active` = 1 
									ORDER BY samples.created DESC");

     	$tablePayParse = "re_sample_var  as samples 
	   				 INNER JOIN `re_pay_parse_buysell`  on samples.var_id = re_pay_parse_buysell.id";
		$dataPayParse = DB::Select('*', 
									$tablePayParse, 
									"sample_id = {$_POST['sample_id']} AND type = 'pri' ORDER BY samples.created DESC ");

		return array_merge($dataVars, $dataPayParse);
    }


	public function get_data_type()
	{
		mysql_set_charset( 'utf8' );
		$topic_search = "";
		$parent_search = "";
        $limit = 'all';
        $page = 0;
		$active = Helper::FilterVal('active');
		$action = Helper::FilterVal('action');
		$copyright = Helper::FilterVal('copyright');
		$favorites = "";
		$_SESSION['for_open_site'] = DB::Select("for_open_site", "re_user", "user_id={$_SESSION['user']}")[0]["for_open_site"];
		$without_cont = $_SESSION['post']['without_cont'];
		$_SESSION['post'] = $_GET;
		$_SESSION['post']['without_cont'] = $without_cont ;
		$_SESSION['first_prolong'] = (
		    !$this->isAllProlong($_SESSION['user'])
            && date('H:i:s') > self::ALL_PROLONG_TIME);

		$_SESSION["topic_id"] = $_POST["topic_id"];
		$colums_var = "re_var.id, re_var.user_id, re_var.fortuna_id as tid, re_var.photo, re_user.parent as user_parent,
		 access_var, re_var.active, re_var.owner, ap_layout, re_var.parent_id, re_var.rent_type, re_var.commission, 
		 col_date, re_company.company_name, re_people.name, re_people.id as people_id, re_people.second_name,
		  re_people.phone, dis, planning, live_point, street, house, orientir, text, topic_id, type_id, price, copyright,
		  date_last_edit, sq_all, sq_live, sq_k, sq_land, floor, floor_count, room_count, coords, deliv_period, 
		  prepayment, utility_payment, deposit, furn, tv, washing, refrig, ap_view_date, ap_race_date, status,
		   premium, favorit, ap_view_price, in_black_list, review, residents, hidden_text, val_bal, val_lodg, link,
		   wc_type, heating, wash, water, sewage, torg, prolong_garant, last_call_date, last_call_date_ts, obmen, ipoteka, chist_prod,
		   obmen, ipoteka, chist_prod, developer, construct_y, kvartal,own_type, y_done,wall_type, 
		   DATE_FORMAT(DATE_ADD(`date_last_edit`, INTERVAL -1 hour),'%d/%m/%Y %H:%i') as `date_last_edit_format`, `park`,
		   DATE_FORMAT(`date_added`,'%d/%m/%Y %H:%i') as `date_added_format`, re_var.keys, sleeping_area";

        $table = "`re_var` INNER JOIN re_user ON re_var.user_id = re_user.user_id 
                    INNER JOIN re_people ON re_user.people_id = re_people.id 
                    INNER JOIN re_company ON re_people.company_id = re_company.id";

		if (!isset($_POST["recipients_ids"])){
			$r=0;/*счетчики повторов*/
			$p=0;
			$d=0;
			$s=0;
			$t=0;
			$disList = [];
            $condition_var = 1;
            if(($active == 0 || $active == 1) && $action  == 'mytype'){
                $condition_var.= " AND re_var.active = ".$active;
            }

			if($action != "favorites" && $action != "favorites_parse" && $action != "favorites_pay_parse"){
				if($_SESSION['access_var']==1){
					$condition_var .= " AND company_id = {$_SESSION['company_id']} ";
				}else{
					$condition_var .= " AND (re_user.user_id='".$_SESSION['user']."' OR re_user.parent='".$_SESSION['user']."')";
				}
			}else if($_GET['action'] != "favorites_parse" && $_GET['action'] != "favorites_pay_parse"){
				$condition_var .= " AND favorit like '%|".$_SESSION['people_id']."|%'";
                $condition_var.=" AND DATE_ADD(date_last_edit, INTERVAL 3 day) >= NOW() ";
			}else{
				$condition_var .= " AND favorit like '%|".$_SESSION['people_id']."|%'";
			}

			if(Helper::FilterVal('copyright')){
                $condition_var .= " AND copyright = 1";
            }else if($active == 0){
                $condition_var .= "";
            }else {
                $condition_var .= " AND copyright = 0";
            }
							
			foreach($_POST as $k => $v){
				if(!ereg("Выбрано", $v) && $k!="task" && $k!="action" && $k != 'hidden_text'&& $k != 'without_cont'
					&& $k!="active" && $k!="page" && $v!="all" && $k!="res" && $k!="order" && $k!='limit'
                    && $k!="search_user_id" && $k!="view_type" && $k!="photo" && $k!="val_bal" && $k!="val_lodg"
                    && $k!='description'
                ){
					if (ereg('room_count', $k) && $r==0 && $v!=""){
						if($action=="favorites_parse"){$condition_var.=" AND (`type_id`='".($v+18)."'";}
						else{$condition_var.=" AND (`room_count`='".$v."'";}	$r++;						
					}else if(ereg('type_id', $k) && $v!=""){
						if($t==0){$type_id.="type_id={$v}"; $t++;}
						else{$type_id.="||{$v}"; $t++;}
					}else if(ereg('room_count', $k) && $v!=""){
						if($action=="favorites_parse"){$condition_var.=" OR `type_id`='".($v+18)."'";}
						else{$condition_var.=" OR `room_count`='".$v."'";}
					}else if(ereg('price', $k) && $p==0){
						if ($r != 0){$condition_var.=")"; $r = 0;}
						if ($v != ""){$condition_var.=" AND (`price` BETWEEN ".str_replace(' ', '', $v); $p++;}
						else{$condition_var.=" AND (`price` BETWEEN 1"; $p++;}
					}else if(ereg('price', $k)){
						if($v!=""){$condition_var.=" AND ".str_replace(' ', '', $v).")";}
						else{$condition_var.=" AND 999999999)";}
					}else if(ereg('dis', $k) && $d==0){

					    $disList[$k] = $v;

					}else if(ereg('street', $k) && $s==0){
						if ($d != 0){$condition_var.=")";$d=0;}
						if($v!=""){$condition_var.=" AND (`street`='".$v."'"; $s++;}
					}else if(ereg('street', $k)){
						if($v!=""){$condition_var.=" OR `street`='".$v."'";}
					}else{
						if ($s != 0){$condition_var.=")";$s=0;}
						if ($v != ""){$condition_var.=" AND `".$k."`='".$v."'";}
					}					
				}
			}

			if(!empty($disList)){
                $disNames  = ' ';
                foreach ($disList as $dis) {
                    $disNames .= " `district` = '$dis' OR";
                }
                $disCond = '';
                foreach ( DB::Select('id', 'sub_districts', substr($disNames, 0, -2)) as $subId) {
                    $disCond .= "'{$subId['id']}',";
                }
                if(!empty($disCond )){
                    $condition_var  .=  " AND `dis` IN (" .substr($disCond, 0, -1).')';
                }
            }

            if(Helper::FilterVal('description')){
                $condition_var .= " AND text LIKE  '%".Helper::FilterVal('description')."%'";
            }
            if(Helper::FilterVal('val_bal')){
                $condition_var .= Helper::FilterVal('val_bal')!=0 ? ' AND val_bal = '.Helper::FilterVal('val_bal') : '';
            }
            if(Helper::FilterVal('val_lodg')){
                $condition_var .= Helper::FilterVal('val_lodg')!=0 ? ' AND val_lodg = '.Helper::FilterVal('val_lodg') : '';
            }

            if(Helper::FilterVal('photo') == 1){
                $table .= " 
            INNER JOIN re_photos as photo on photo.var_id = v.id ";
            }
            if(!empty(Helper::FilterVal('parent_id')) && Helper::FilterVal('parent_id') != 'all'){
                $condition_var.= " AND parent_id = ".Helper::FilterVal('parent_id');
            }

            if($t>0){
				$condition_var.= " AND (".(str_replace("||", " OR type_id=", $type_id)).")";
			}
		}else{
			$condition_var = " (re_var.id=".str_replace(',', " OR re_var.id=", Helper::FilterVal("recipients_ids").")");
		}
		if(empty($_SESSION['limit'])){
            $_SESSION['limit'] = 50;
        }

        $begin = Helper::FilterVal('page')>0
            ? (Helper::FilterVal('page')-1) * $_SESSION['limit']
            : 0;

        $limit = $_SESSION['limit'] == "all" && $active==1
            ? ''
            : "LIMIT {$begin}, ".$_SESSION['limit'];

        if($action != "favorites_parse"){
			$row_list_ngs = "id, user_id, active, dis, planning, live_point, street, parent_id, house, orientir, text, topic_id, type_id, price, date_last_edit, sq_all, sq_live, sq_k, sq_land, floor, floor_count, contact_name, contact_tel, contact_email, inet, furn, tv, washing, refrig, conditioner, favorit, link, photos, review";
			if($action != "favorites_parse"){
			    $order = ' premium DESC ';
				$order .= Helper::FilterVal('order') == ""
                    ? ", date_last_edit DESC"
                    : ", ".Helper::FilterVal('order')." DESC";

				$data_res = DB::Select($colums_var, $table, $condition_var." ORDER BY {$order} {$limit}",true);
				$count = count($data_res);
				$data_res[0]['count'] = DB::Select("count(*) as c", $table, $condition_var)[0]['c'];
			}else{
				$data_res = DB::Select($row_list_ngs, "re_parse", $condition_var." ORDER BY date_last_edit DESC {$limit}",true);
				$count = count($data_res);
			}
			for($j=0; $j<$count; $j++)
			{
				$data_res[$j]['date_added'] = Translate::month_ru($data_res[$j]['date_added_format']);
			}

			unset($count);		
		}else{
			$data_res = DB::Select("*", "re_pay_parse_buysell", $condition_var." ORDER BY date_last_edit DESC {$limit}");
		}
		return $data_res;		
	}
	
	public function newvar()
	{
		
	}
	
	public function newvar_old()
	{
		$data = 2;
		return $data;
	}
	
	public function savevar_old()
	{
		if($_POST) {
			$data = $_POST;
			$data['photoes'] = $_FILES;
			
		}
		return $data;
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
				//echo "<li id='str{$j}' onclick='addStreet({$j})'>{$row_a['name']}</li>";
				echo "<li id='str{$j}' onclick='setStreet({$j}, \"{$row_a['name']}\")'>{$row_a['name']}</li>";
				
				$j = $j+1;
			}
			echo "</ul>";
		}elseif (mysql_num_rows($r_next_word) > 0)
		{	
			echo "<ul id='str_list'>";
			$j = 0;
			while ($row_a = mysql_fetch_array($r_next_word))
			{
				echo "<li id='str{$j}' onclick='setStreet({$j}, \"{$row_a['name']}\")'>{$row_a['name']}</li>";
				$j = $j+1;
			}
			echo "</ul>";
		}elseif (mysql_num_rows($r_contains) > 0)
		{	
			echo "<ul id='str_list'>";
			$j = 0;
			while ($row_a = mysql_fetch_array($r_contains))
			{
				echo "<li id='str{$j}' onclick='setStreet({$j}, \"{$row_a['name']}\")'>{$row_a['name']}</li>";
				$j = $j+1;
			}
			echo "</ul>";
		}

		mysql_free_result($r_begin);
		mysql_free_result($r_next_word);
		mysql_free_result($r_contains);
	}
	
	public function search_city()
	{
		$name = $_POST['name'];		
		mysql_set_charset( 'utf8' );
		$q_a = 'SELECT * from `re_city` where (`name` like "%'. $name .'%") LIMIT 0,10';
		$r_a = mysql_query($q_a);
		$j = 0;
		if (mysql_num_rows($r_a) > 0)
			{	
				echo '<ul id="str_list">';
				$j = 0;
				while ($row_a = mysql_fetch_array($r_a))
					{
						echo '<li id="str'. $j .'" onclick="setCity('. $j .', \''.$row_a['name'].'\')" style="line-height: 1;">'
								.$row_a['name'];
						if($row_a["region"]!=""){
							echo '<br><span style="color: #969696; font-size: 12px;">р-н.:'.$row_a["region"].'</span>';
						}
						echo '</li>';
							$j = $j+1;
					}
				echo '</ul>';
			}
		mysql_free_result($r_a);
	}
	
	public function search_an()
	{
		$an = $_POST['an'];
		if($_SESSION['admin']==1){
			$q_a = "SELECT c.id, c.company_name FROM re_company as c, re_access_date_end as a, re_people as p, re_user as u 
              WHERE p.company_id = c.id AND u.people_id=p.id AND c.id = a.company_id AND a.sell_date_end > now() 
                  AND ((c.company_name like '{$an}%') OR (u.login like '{$an}%')) GROUP BY c.company_name";
		}else{
			$q_a = 'SELECT c.id, c.company_name FROM re_company as c, re_access_date_end as a 
              WHERE c.id = a.company_id AND a.sell_date_end > now() AND (c.company_name like "%'. $an .'%")';
		}
		$r_a = mysql_query($q_a);
		$j = 0;
		if (mysql_num_rows($r_a) > 0)
			{	
				echo '<ul id="str_list">';
				$j = 0;
				while ($row_a = mysql_fetch_array($r_a))
					{
						echo '<li onclick="$(\'[data-name=an-list]\').val($(this).text()); $(\'[name=company_id]\').val('.$row_a['id'].'); $(\'.an_list\').slideUp()">'. $row_a['company_name'] .'</li>';
							$j = $j+1;
					}
				echo '</ul>';
			}
		mysql_free_result($r_a);
	}
	
	
	private function isActive($id){
		$archive = DB::Select('active', 're_var', " `id` = {$id} LIMIT 1");
		return ($archive[0]['active'] == 1);
	}

    public function create_payment_tinkoff()
    {
        if(Helper::FilterVal('order_id')==null){
            return null;
        }
        $peopleId = Helper::FilterVal('people_id');
        $orderId = Helper::FilterVal('order_id');
        $amount = Helper::FilterVal('amount');
        $rent = Helper::FilterVal('rent');
        $sell = Helper::FilterVal('sell');
        $payParse = Helper::FilterVal('pay_parse');
        $premium = Helper::FilterVal('premium');
        $premium_lenght = Helper::FilterVal('premium_lenght');
        DB::Insert('re_payment_tinkoff',
            '`people_id`, `order_id`, `amount`, `rent`, `sell`, `pay_parse`, `premium`, `premium_lenght`, `created`',
            "{$peopleId}, {$orderId}, {$amount}, {$rent}, {$sell}, {$payParse}, {$premium}, {$premium_lenght}, NOW()"
        );
        }


    private function migratePayParse($varId, $sampleId)
    {
        if ($varId == null) {
            return null;
        }
        $var = current(DB::Select('*', 're_pay_parse_buysell', "id=$varId"));
        DB::Insert('re_var',
        "`user_id`, `active`, `group`, `topic_id`, `type_id`, `parent_id`, `live_point`, `dis`, `street`, `house`, `orientir`, `sq_all`, `sq_live`, `sq_k`, `sq_land`, `planning`, `ap_layout`, `wc_type`, `val_bal`, `val_lodg`, `inet`, `furn`, `tv`, `washing`, `refrig`, `conditioner`, `own_type`, `developer`, `y_done`, `construct_y`, `kvartal`, `park`, `floor`, `floor_count`, `room_count`, `wall_type`, `elec`, `water`, `gas`, `heating`, `heating_type`, `sewage`, `grhouse`, `posadki`, `hole`, `banya`, `wash`, `text`, `hidden_text`, `var_code`, `image`, `price`, `prepayment`, `deposit`, `utility_payment`, `ap_view_price`, `torg`, `commission`, `chist_prod`, `obmen`, `ipoteka`, `rent_type`, `link`, `date_added`, `sample_id`",
            "'{$_SESSION['user']}', '{$var['active']}', '{$var['group']}', '{$var['topic_id']}', '{$var['type_id']}', '{$var['parent_id']}', '{$var['live_point']}', '{$var['dis']}', '{$var['street']}', '{$var['house']}', '{$var['orientir']}', '{$var['sq_all']}', '{$var['sq_live']}', '{$var['sq_k']}', '{$var['sq_land']}', '{$var['planning']}', '{$var['ap_layout']}', '{$var['wc_type']}', '{$var['val_bal']}', '{$var['val_lodg']}', '{$var['inet']}', '{$var['furn']}', '{$var['tv']}', '{$var['washing']}', '{$var['refrig']}', '{$var['conditioner']}', '{$var['own_type']}', '{$var['developer']}',  '{$var['y_done']}', '{$var['construct_y']}', '{$var['kvartal']}', '{$var['park']}', '{$var['floor']}', '{$var['floor_count']}', '{$var['room_count']}', '{$var['wall_type']}', '{$var['elec']}', '{$var['water']}', '{$var['gas']}', '{$var['heating']}', '{$var['heating_type']}', '{$var['sewage']}', '{$var['grhouse']}', '{$var['posadki']}', '{$var['hole']}', '{$var['banya']}', '{$var['wash']}', '{$var['text']}', '{$var['hidden_text']}', '{$var['var_code']}', '{$var['image']}', '{$var['price']}', '{$var['prepayment']}', '{$var['deposit']}', '{$var['utility_payment']}', '{$var['ap_view_price']}', '{$var['torg']}', '{$var['commission']}', '{$var['chist_prod']}', '{$var['obmen']}', '{$var['ipoteka']}', '{$var['rent_type']}', '{$var['link']}', '{$var['date_added']}', '{$sampleId}'"
        );
    }

    public function collectSample()
    {
        $varId = Helper::FilterVal('varId');
        if ($varId == null) {
            return null;
        }
        $sampleId = Helper::FilterVal('sampleId');

        $this->migratePayParse($varId, $sampleId);
    }

    public function  saveSample()
    {
        $column = '';
        $values = '';
        $values_update = '';
        if (empty($_POST)) {
            return null;
        }

        $link = strtolower(md5(uniqid(rand(),true)));
        $date_last_edit = date('Y-m-d H:i:s');
        foreach($_POST as $k => $v){
            $v = $k=="price" ? preg_replace('/\D/', '', $v) : $v;
            if($k == 'submit'){
                continue;
            }
            if($k == 'text'){
                $column.="`suspicion`, ";
                $values.="'1', ";
                $values_update.="`suspicion`=".Get_functions::Get_suspicion_text($v).", ";
                if(strpos($v, "<") !== false && strpos($v, ">") !== false) $v ="";
            }
            if($k == 'prolong_garant' && !Helper::checkProlongExists($_SESSION['user']) ){
                $column.="`".$k."`, ";
                $values.="'0', ";
                $values_update.="`".$k."`='0', ";
                continue;
            }

            if($k == 'premium' && $v ==1 && Get_functions::Get_premium_balance() <= 0){
                continue;
            }
            $column.="`".$k."`, ";
            $values.="'".$v."', ";
            $values_update.="`".$k."`='".$v."', ";
        }

        $column.="`user_id`, `active`, `date_added`, `date_last_edit`, `link`";
        $values.="'{$_SESSION['user']}', '1', '".date('Y-m-d')."', '{$date_last_edit}', '{$link}'";
        $condition = "`user_id` = '{$_SESSION['user']}' AND `date_last_edit` = '{$date_last_edit}'";


        DB::Insert("`re_var_sample`", $column, $values);
        return  DB::Insert("`re_var_sample`", $column, $values);

//      Geocode::updateVarCoords($var_id);
    }

	public function savevar()
	{
        $column = '';
        $values = '';
        $values_update = '';
        $archive_date = '';
        $varId = Helper::FilterVal('id');
        $districtId = null;
		if ($_POST) {
			$link = strtolower(md5(uniqid(rand(),true)));
			$date_last_edit = date('Y-m-d H:i:s');
			$prem_count = Get_functions::Get_premium_balance();

			foreach($_POST as $k => $v){
			    if($k == 'dis' || $k =='sub_dis' || $k =='districtId'){
			        continue;
                }

				$v = $k=="price" ? preg_replace('/\D/', '', $v) : $v;
				if($k == 'text'){
					$column.="`suspicion`, ";
					$values.="'1', ";
					$values_update.="`suspicion`=".Get_functions::Get_suspicion_text($v).", ";
					if(strpos($v, "<") !== false && strpos($v, ">") !== false) $v ="";
				}
				if($k == 'prolong_garant' && !Helper::checkProlongExists($_SESSION['user']) ){
					$column.="`".$k."`, ";
					$values.="'0', ";
					$values_update.="`".$k."`='0', ";
					continue;
				}

				if($k == 'premium' && $v ==1 && Get_functions::Get_premium_balance() <= 0){
                    continue;
                }
				$column.="`".$k."`, ";
				$values.="'".$v."', ";
				$values_update.="`".$k."`='".$v."', ";
			}


            $districtId = DB::Select('id','sub_districts',"`name` = '{$_POST['sub_dis']}' AND `district` = '{$_POST['dis']}'")[0];
            if(isset($districtId['id'])){
                $column.="`dis`, ";
                $values.="'{$districtId['id']}', ";
                $values_update.="`dis`='{$districtId['id']}', ";
            }

			$column.="`user_id`, `active`, `date_added`, `date_last_edit`, `link`";
			$values.="'{$_SESSION['user']}', '1', '".date('Y-m-d')."', '{$date_last_edit}', '{$link}'";
			$condition = "`user_id` = '{$_SESSION['user']}' AND `date_last_edit` = '{$date_last_edit}'";
			$values_update.= " `link` = '{$link}' ";

			if(Helper::FilterVal('id')){
				$date_added = '';
				if(!empty(Helper::varProlongAcess($varId))){
					$values_update .= ", `date_last_edit` = '{$date_last_edit}'";
				}

				// выносим из архива
				if(Helper::FilterVal('active') == 1 && !$this->isActive($varId)) {
					$date_archive = DB::Select('archive_date, auto_archive','re_var',"`id`={$varId}")[0];
					$diff = abs(strtotime(date('Y-m-d H:m:s')) - strtotime($date_archive['archive_date']));
					if( $diff > 86000  || $date_archive['auto_archive'] == 1){
						$date_added = ", date_added = NOW()";
						$archive_date = ", `archive_date` = NOW()";
					}
				}

				DB::Update("`re_var`", $values_update." ".$date_added." ".$archive_date, "`id`={$varId}");
				DB::Update("re_var", "review=0", "id = {$varId}");
				DB::Delete("re_review", "var_id = {$varId}");

			}else{
				DB::Insert("`re_var`", $column, $values, true);
				$curVar = DB::Select("`id`", "`re_var`", $condition);
				$var_id = $curVar[0]['id'];
			}
			if ($var_id) {
				$_SESSION['cur_var'] = $var_id;

				if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/images/'. $_SESSION['people_id'])) {
					@mkdir($_SERVER['DOCUMENT_ROOT'] .'/images/'. $_SESSION['people_id'] .'/'. $var_id, 0777);
				} else {
					@mkdir($_SERVER['DOCUMENT_ROOT'] .'/images/'. $_SESSION['people_id'], 0777);
					@mkdir($_SERVER['DOCUMENT_ROOT'] .'/images/'. $_SESSION['people_id'] .'/'. $var_id, 0777);
				}

			}

		}
	}


	public function edit_group()
	{
		$data = "Изменение группы прошло не удачно.";
		if(isset($_POST['black_group']) && $_SESSION['fio']){
			$my_group = mysql_fetch_assoc(mysql_query("SELECT id FROM re_group WHERE group_owner = '{$_SESSION['fio']}'"))["id"];
			if(intval($my_group) > 0){
				DB::Update("re_group", "black_group='{$_POST['black_group']}' , `hide_black_group` = '{$_POST['hide_black_group']}' ", "id='".$my_group."'");
				$data = '1';
			}else{
				DB::Insert("re_group", "group_owner, black_group", "'".$_SESSION['fio']."', '".$_POST['black_group']."'");
				$data = '1';
			}
		}
		echo $data;
	}
	
	public function get_data_edit()
	{
	    $varId = Helper::FilterVal('id');
		if ($varId) {
			$user_var = DB::Select("v.id",
                "re_var as v, re_user as u",
                "v.id={$varId} AND v.user_id = u.user_id AND (v.user_id=".$_SESSION['user']." OR u.parent = ".$_SESSION['user']." OR (v.user_id = {$_SESSION['parent']} AND u.access_var=1))");
			if(isset($user_var[0]['id'])){
				$condition = "v.id={$varId} AND v.user_id = u.user_id AND (v.user_id=".$_SESSION['user']." OR u.parent = ".$_SESSION['user']." OR (v.user_id = {$_SESSION['parent']} AND u.access_var=1))";
				$data_res = DB::Select("v.*, u.*", "re_var as v, re_user as u", $condition)[0];
				$data_res['prolongExists'] = Helper::checkProlongExists($_SESSION['user']);
				if($data_res['user_id']!=$_SESSION['user']){
					$data_res['photo_close']=1;
				}
				$_SESSION['cur_var'] = $varId;
			}else{
				header("Location: http://". $_SERVER['SERVER_NAME']);
			}
		} else {
			$data_res = "Ошибка передачи данных.";
		}
		return $data_res;
	}

	public function get_data_edit_sample()
	{
		if ($varId = Helper::FilterVal('id')) {
            return DB::Select("*", "re_pay_parse_buysell", "id = {$varId} limit 1");
		}else{
			header("Location: http://". $_SERVER['SERVER_NAME']);
		}
	}
		
	public function deletevar()
	{
        $condition_pf = $condition_var = '';
		if(isset($_POST['var_ids']) && isset($_SESSION['user'])) {
			$ids_array = explode(',', $_POST['var_ids']);
			$count = count($ids_array) == 1 ? 2 : count($ids_array);
			for($i=0; $i<($count-1); $i++){
				if($count == 2){
					$condition_var = "`id`=".$ids_array[$i];
					$condition_pf = "`var_id`=".$ids_array[$i];
				}else if($i == 0 && $count>2){
					$condition_var = "(`id`=".$ids_array[$i];
					$condition_pf = "(`var_id`=".$ids_array[$i];
				}else if($i == $count-2 && $count>2){
					$condition_var .= " OR `id`=".$ids_array[$i].")";
					$condition_pf .= " OR `var_id`=".$ids_array[$i].")";
				}else{
					$condition_var .= " OR `id`=".$ids_array[$i];
					$condition_pf .= " OR `var_id`=".$ids_array[$i];
				}
			}			
			$user_var_count = DB::Select("COUNT(*)", "`re_var`", $condition_var." AND `user_id`='".$_SESSION['user']."'")[0]['COUNT(*)'];
			$director_count = DB::Select("COUNT(*)", "re_user", "parent='{$_SESSION['user']}'")[0]['COUNT(*)'];
			if($user_var_count == $count-1 || $director_count>0 || $_SESSION['admin']==1){
				$photos_array = DB::Select("*", "`re_photos`", $condition_pf);
				for($j=0; $j<count($photos_array); ++$j) {
					unlink($_SERVER['DOCUMENT_ROOT'] .'/images/'. $photos_array[$j]['people_id'] .'/'.  $photos_array[$j]['var_id'] .'/'.  $photos_array[$j]['photo']);
					@unlink("/var/www/arendanovosib".'/images/'. $photos_array[$j]['people_id'] .'/'.  $photos_array[$j]['var_id'] .'/'.  $photos_array[$j]['photo']);					
					unlink(''. $_SERVER['DOCUMENT_ROOT'] .'/images/'. $photos_array[$j]['people_id'] .'/'.  $photos_array[$j]['var_id'] .'/main.jpg');
					rmdir($_SERVER['DOCUMENT_ROOT'] .'/images/'. $photos_array[$j]['people_id'] .'/'.  $photos_array[$j]['var_id']);
				}
				DB::Insert("`for_delete`", "var_id", "'{$_POST['var_ids']}'");
				DB::Delete("`re_photos`", $condition_pf);
				DB::Delete("`re_var`", $condition_var);
				DB::Delete("`re_favorites`", $condition_pf);
				DB::Delete("`re_sample_var`", $condition_pf);
				DB::Delete("`re_review`", $condition_pf);
				$data = "Вариант удален. <br />
				<h2><a href='javascript:history.go(-1)'>Назад</a></h2>";
			}
		} else {
			$data = "Ошибка удаления.";
		}
		return $data;
	}
	
	public function archive()
	{
		if($_POST['id'] && $_SESSION['user']) {
			$user_var_count = DB::Select('count(*) as count', "re_var as v, re_company as c, re_people as p, re_user as u", "v.user_id=u.user_id AND u.people_id=p.id AND c.id=p.company_id AND v.id=".$_POST['id']." AND c.id='".$_SESSION['company_id']."'")[0]['count'];
			if($user_var_count>0 || $_SESSION["admin"]==1){
				DB::Update("`re_var`",
                    "`active`='".$_POST['active'] . "', premium = 0, `status` = 0, favorit = '', `archive_date` = NOW(), `auto_archive`= NULL ",
                    "`id`=".$_POST['id']);
				DB::Insert("`for_delete`", "var_id", "'{$_POST['id']}'");
			}
			$data = "Вариант перемещен.";
		} else {
			$data = "Ошибка перемещения.";
		}
		return $data;
	}
	
	public function archive_list()
	{	
		mysql_set_charset( 'utf8' );
		$topic_filter = "`topic_id` = '".$_GET['topic_id']."'";
		$parent_filter = "`parent_id` = '".$_GET['parent_id']."'";
		$query = "SELECT *, DATE_FORMAT(DATE_ADD(`date_last_edit`, INTERVAL -1 hour),'%d/%m/%Y %H:%i') as `date_last_edit` FROM `re_var` where ((`active` = '0') 
				AND (`user_id` = '". $_SESSION['user'] ."')
				AND (".$topic_filter.")
				AND (".$parent_filter."))";
			$q_res = mysql_query($query);
				
			$q_num = mysql_num_rows($q_res);
				for($j=0; $j<$q_num; ++$j) {
					$q_row = mysql_fetch_array($q_res);					
					$data_res[] = $q_row;				
					
					if ($data_res[$j]['date_last_edit']){
						$data_res[$j]['date_last_edit'] = Translate::month_ru($data_res[$j]['date_last_edit']);
					}	
				}
	
	return $data_res;	
	}
	
	public function change_profile()
	{	
		mysql_set_charset( 'utf8' );
		$condition = "`parent` = '". $_SESSION['user'] ."' 
					AND user_id != '". $_SESSION['user'] ."' 
					AND `archive` = '0' ORDER BY login";
		$data_res = DB::Select("*", $this->query_users, $condition);
		return $data_res;
	}
	
	public function change_user(){
        $values_user = $values_people =$values_company = $values_access_date_end = $phone_addon = '';
		if($_POST && $_SESSION['parent'] == '0'){
			$cur_date = date("Y-m-d H:i:s");
			foreach($_POST as $k=>$v){				
				if(ereg('ac-', $k)){
					$k = explode('-', $k)[1];
					$values_access_date_end.= "`".$k."`='".$v."', ";
				}else if(ereg('co-', $k)){
					$k = explode('-', $k)[1];
					$values_company.= "`".$k."`='".$v."', ";
				}else if(ereg('us-', $k)){
					$k = explode('-', $k)[1];
					$values_user.= "`".$k."`='".$v."', ";
				}else if(ereg('pe-', $k)){
					if(ereg('pe-phone_addon', $k))
					{
						$phone_addon.=$v."||";
					}else{
						$k = explode('-', $k)[1];
						$values_people.= "`".$k."`='".$v."', ";
					}
				}else if(ereg('ad-', $k)){
					if(ereg('ad-rent_mob-', $k)){
						$k = explode('-', $k);
						DB::Update("re_addresses", "`mob`='".$v."'", "id=".$k[2]);
					}
					if(ereg('ad-rent_ip-', $k)){
						$k = explode('-', $k);
						DB::Update("re_addresses", "`ip`='".$v."'", "id=".$k[2]);
					}
					if(ereg('ad-rent_browser-', $k)){
						$k = explode('-', $k);
						DB::Update("re_addresses", "`browser`='".$v."'", "id=".$k[2]);
					}

				}
			}
			if($values_access_date_end){
				DB::Update("re_access_date_end", substr($values_access_date_end, 0, -2), "company_id=".$_POST['company_id']);		
			}
			if($values_company){
			DB::Update("re_company", substr($values_company, 0, -2), "id=".$_POST['company_id']);		
			}
			if($values_user){
				DB::Update("re_user", substr($values_user, 0, -2), "user_id=".$_POST['user_id']);		
			}
			if($values_people || $phone_addon){
				$people_id = Get_functions::Get_people_id_by_user_id($_POST['user_id']);
				$values_people.= "`phone_addon`='".($phone_addon == "'||'" ? "NULL" : $phone_addon)."', `date_edit`='".$cur_date."'";
				DB::Update("re_people", $values_people, "`id` = ".$people_id);
			}
			if($_POST["co-without_vip"] == 1){
				$user_id = DB::Select("GROUP_CONCAT(user_id) as user_ids", "re_user as u, re_people as p", "u.people_id = p.id AND p.company_id = ".$_POST['company_id'])[0]["user_ids"];
				DB::Update("re_var", "status=1", "user_id=".(str_replace(",", " or user_id=", $user_id)));
			}

			if($_POST["co-prolong_garant_no_exists"] == 1){
				$user_id = DB::Select("GROUP_CONCAT(user_id) as user_ids", "re_user as u, re_people as p", 
					"u.people_id = p.id AND p.company_id = ".$_POST['company_id'])[0]["user_ids"];
				DB::Update("re_var", "prolong_garant = 0", "user_id=".(str_replace(",", " or user_id=", $user_id)));
			}
			echo 1;
		}
	}
	
	public function get_template()
	{	
		$data_res['type_id'] = $_POST['type_id'];
		$data_res['topic_id'] = $_POST['topic_id'];
		
		return $data_res;
	}
	
	public function save_profile() 
	{	
		$cur_date = date("Y-m-d H:i:s");
		if((!$_POST['submit']) AND (!$_POST['action'])) {
			$data = 'no';
		} else if ($_POST['action'] == 'new') {
			$fio = Get_functions::Get_fio_by_pnone($_POST['phone']);
			if($fio['surname'] == "" && $fio['name'] == ""){			
				$people_id = Get_functions::Get_people_id_by_login($_POST['login']);
				$fio = Get_functions::Get_fio_by_people_id($people_id);
				if($people_id == ""){
					$query = "SELECT * FROM `re_people` WHERE `surname` LIKE '%".$_POST['surname']."%' AND `name` LIKE '%".$_POST['name']."%' AND `second_name` LIKE '%".$_POST['second_name']."%' AND `date_dismiss` = '0000-00-00 00:00:00'";
					$peoples = mysql_query($query);
					$company_name = Get_functions::Get_company_name_by_id(mysql_fetch_assoc($peoples)['company_id']);
					$peoples_num = mysql_num_rows($peoples);
					if($peoples_num == 0){			
						mysql_query("INSERT INTO `re_people` (`surname`, `name`, `second_name`, `email`, `phone`, `company_id`, `date_reg`) VALUES ('".$_POST['surname']."', '".$_POST['name']."', '".$_POST['second_name']."', '".$_POST['email']."', '".$_POST['phone']."', '".$_SESSION['company_id']."', '".$cur_date."')");			
						$query = "SELECT `id` FROM `re_people` WHERE `surname` = '".$_POST['surname']."' AND `name` = '".$_POST['name']."' AND `second_name` = '".$_POST['second_name']."' AND `email` = '".$_POST['email']."' AND `phone` = '".$_POST['phone']."' AND `company_id` = '".$_SESSION['company_id']."' AND `date_reg` = '".$cur_date."'";			
						$people_id = mysql_fetch_assoc(mysql_query($query))['id'];
											
						$query = "INSERT INTO `re_user` (`login`, `nickname`, `active`, `people_id`, `password`, `parent`, `group_topic_id`, `ip_rent`, `street_rent`, `house_rent`, `office_rent`, `comment_rent`, `ip_sell`, `street_sell`, `house_sell`, `office_sell`, `comment_sell`) VALUES ('". $_POST['login'] ."', '". $_POST['nickname'] ."', '".$_SESSION['admin']."', '".$people_id."', '". $_POST['password'] ."', '".$_SESSION['user']."', '". $_SESSION['group_topic_id'] ."', '".$_POST['ip_rent']."', '".$_POST['street_rent']."', '".$_POST['house_rent']."', '".$_POST['office_rent']."', '".$_POST['comment_rent']."', '".$_POST['ip_sell']."', '".$_POST['street_sell']."', '".$_POST['house_sell']."', '".$_POST['office_sell']."', '".$_POST['comment_sell']."')";			
						$res = mysql_query($query);
						
						if ($_SESSION['admin'] == "0"){
							$query = "SELECT `user_id` FROM re_user INNER JOIN re_people ON re_user.people_id = re_people.id WHERE `login` = '".$_POST['login']."' AND `active` = '0' AND `people_id` = '".$people_id."' AND `date_reg` = '".$cur_date."'";
							$user_id = mysql_fetch_assoc(mysql_query($query))['user_id'];
							
							mysql_query("INSERT INTO `re_applications` (`user_id`, `people_id`, `company_id`, `date`, `comment`) VALUES ('".$user_id."', '".$people_id."', '".$_SESSION['company_id']."', '".$cur_date."', 'Новый сотрудник')");
						}
						echo "1";
					}else{echo "Данный риелтер работает в агенстве '".$company_name."'";}
				}else{echo "Логин '".$_POST['login']."' прикреплён за '".$fio."'";}
			}else{echo "Телефон '".$_POST['phone']."' прикреплён за '".$fio['surname']." ".$fio['name']." ".$fio['second_name']."'";}
		}
	}
		
	public function add_favorites()
	{
		if($_POST['var_id'] && isset($_SESSION['people_id']))
		{
			if(isset($_POST["pay_parse"])){
				$table = "re_pay_parse_buysell";
			}else{
				$table = "re_var";
			}

			$result = DB::Update($table, 'favorit=concat(favorit, "|'.$_SESSION['people_id'].'|")', 'id='.$_POST['var_id']);
			unset($table, $_POST);
			return $result;
		}
		else{
			return "Попытка не удалась";
		}
	}
	
	public function remove_from_favorites(){
		if(isset($_POST['favorit_str']) && isset($_POST['var_id']) && isset($_SESSION['people_id'])){
			if(isset($_POST["pay_parse"])){
				$table = "re_pay_parse_buysell";
			}else{
				$table = "re_var";
			}
			//$favoritNew = str_replace('|'.$_SESSION['people_id'].'|', "", $_POST['favorit_str']);
			DB::Update($table, 'favorit=REPLACE(favorit, "|'.$_SESSION['people_id'].'|", "")', 'id='.$_POST['var_id']);
			unset($table);
		}
	}

	public function clear_favorites(){
		if(isset($_SESSION['people_id']) && isset($_POST["table"])) {
			$count = 0;
			if($_POST["table"] == 'favorites_parse') {
				$table = "re_pay_parse";
			}else if($_POST["table"] == 'favorites'){
				$table = "re_var";
			}else{
				return null;
			}
			$favoritesVars =
                    DB::Select('id',$table, "favorit like '%|{$_SESSION['people_id']}|%'");

			foreach ($favoritesVars as $key => $var) {
				DB::Update($table, 'favorit=REPLACE(favorit, "|'.$_SESSION['people_id'].'|", "")', "id={$var['id']}");
				$count++;
			}			
			echo $count;	
			unset($table);
		}
	}

	
	private function isAllProlong($user_id)
	{
		$dateProlongAll = DB::Select('date_prolong_all', 're_user', "user_id = {$user_id} LIMIT 1");
		return ($dateProlongAll[0]['date_prolong_all'] == date('Y-m-d'));

	}

	public function var_extend()
	{
		if($_POST['var_ids'] && isset($_SESSION['user'])) {
            $date = new DateTime();
            $condition = '';
            $ids_array = explode(',', $_POST['var_ids']);
            $count = count($ids_array) == 1 ? 2 : count($ids_array);

            for ($i = 0; $i < ($count - 1); $i++) {
                if ($count == 2) {
                    $condition = "`id`=" . $ids_array[$i];
                } else if ($i == 0 && $count > 2) {
                    $condition = "(`id`=" . $ids_array[$i];
                } else if ($i == $count - 2 && $count > 2) {
                    $condition .= " OR `id`=" . $ids_array[$i] . ")";
                } else {
                    $condition .= " OR `id`=" . $ids_array[$i];
                }
            }
            $vars = DB::Select('*', 're_var',
                $condition . " AND 
                    DATE_ADD(date_last_edit, INTERVAL 1 HOUR) <= '{$date->format(Translate::MYSQL_DATE_TIME)}' AND 
                    `active` = 1 "
            );
            if(empty($vars)){
                return  "Нет вариантов для продления";
            }
            DB::Update("`re_user`",
                "`date_prolong_all` = '{$date->format(Translate::MYSQL_DATE_TIME)}' ",
                "`user_id` = {$_SESSION['user']}"
            );
            $dateAllProlongTime = new DateTime(self::ALL_PROLONG_TIME);

            foreach ($vars as $var) {
                $prolongGarant = '';
                $varDateEdit = new DateTime($var['date_last_edit']);

                if ($varDateEdit < $dateAllProlongTime) {
                  $prolongGarant = ", `prolong_garant` = '0'";
                }
                DB::Update(
                    're_var',
                    "`date_last_edit`='{$date->format(Translate::MYSQL_DATE_TIME)}'{$prolongGarant}",
                    "id = {$var['id']}"
                );
            }
            return "Ok";

        }else{
			return "Попытка не удалась";
		}
	}




	public function var_extend_one()
	{
		if($_POST['var_id'] && isset($_SESSION['user']))
		{
			$prolong = 0;
			if(!empty($_POST['prolong']) &&  Helper::checkProlongExists($_SESSION['user']) )
			{
				$prolong = 1;
			}
				
			$id = $_POST['var_id'];
			$date = date("Y-m-d H:i");

			$values = "`date_last_edit`='". $date ."', `prolong_garant` = '{$prolong}' ";
			DB::Update("`re_var`", $values, "`id` = {$id} AND DATE_ADD(date_last_edit, INTERVAL 1 HOUR) <= '{$date}'");
			return "Ok";
		}	
	}

	public function delete_profile()
	{
		$date = date("Y-m-d H:i");
		if($_SESSION['parent'] == 0 || $_SESSION['admin'] == 1){
			if(($_SESSION['parent'] == '0') AND ($_GET['user_id'])){
				if($_GET['user_id'] == $_SESSION["user"]){
					return false;
				}		
				$user_id = $_GET['user_id'];
				$people_id = Get_functions::Get_people_id_by_user_id($user_id);	
				DB::Update("re_people", "`date_dismiss`='{$date}'", "id=".$people_id);
				//DB::Update("re_addresses", "active=0, archive=1", "people_id=".$people_id);
				//DB::Delete("re_user", "`user_id`='". $_GET['user_id'] ."'");
				DB::Update("re_user",  'active= 0', "`user_id`='{$user_id}'");
				DB::Update("re_var", "active = 0", "user_id='{$user_id}', owner_people_id='{$people_id}"); //active = 0, owner_people_id='{$people_id}'
				DB::Update("re_applications", "`archive` = '1'", "user_id='{$user_id}'");
				DB::Insert("re_applications", 
							"user_id, people_id, company_id, date, comment", 
							"'{$_SESSION["user"]}', '{$_SESSION['people_id']}', '{$_SESSION['company_id']}', '{$date}', 'Из АН уволен сотрудник. Пересмотрите абонентку.'");
				DB::Delete("re_session", "people_id=".$people_id);
			} else {
				header("Location: http://". $_SERVER['SERVER_NAME']);
			}
		}
	}
	
	public function profile_to_archive()
	{
		$date = date("Y-m-d H:i");
		if(($_SESSION['parent'] == '0') AND ($_GET['user_id'])){
			$people_id = Get_functions::Get_people_id_by_user_id($_GET['user_id']);
			mysql_query("UPDATE `re_people` SET `date_dismiss` = '".$date."' where `id` = '".$people_id."'");
			
			$query = "UPDATE `re_user` SET `archive` = '1', `active` = '0' where `user_id` = '". $_GET['user_id'] ."'";
			mysql_query($query);
			
			$query = "SELECT `id` FROM `re_applications` WHERE `user_id` = ".$_GET['user_id'];
			$res = mysql_query($query);
			if(mysql_num_rows($res)>0)
			{
				mysql_query("UPDATE `re_applications` SET `archive` = '1' WHERE `id` = ".mysql_fetch_assoc($res)['id']);
			}
		} else {
			header("Location: http://". $_SERVER['SERVER_NAME']);
		}
	}
	
	public function create_login()
	{
        $column_company = $values_company =$values_user = $column_people =$values_people =$column_user = $for_search = $phone_addon ='';

		if(($_SESSION['admin'] == 1) AND ($_POST['us-login'])) {
			$cur_date = date("Y-m-d H:i:s");
			foreach($_POST as $k=>$v){
				if(ereg('co-', $k)){
					$k = explode('-', $k)[1];
					$column_company.= "{$k}, ";
					$values_company.= "'{$v}', ";
				}else if(ereg('us-', $k)){
					$k = explode('-', $k)[1];
					$column_user.= "{$k}, ";
					$values_user.= "'{$v}', ";
				}else if(ereg('pe-', $k)){
					$k = explode('-', $k)[1];
					$column_people.= "{$k}, ";
					$values_people.= "'{$v}', ";
					$for_search.= "{$k}='{$v}' AND ";
				}
			}
			if(isset($values_company)){
				DB::Insert("re_company", "{$column_company} date_company_reg", "{$values_company} '{$cur_date}'");
			}
			
			$query_company = "SELECT id FROM re_company WHERE company_name = '".$_POST['co-company_name']."' AND date_company_reg = '".$cur_date."'";
			$company_id = mysql_fetch_assoc(mysql_query($query_company))['id'];			
			
			$sell_date_end = $_POST['sell_date_end'] ?
			date("Y-m-d H:i:s", strtotime($_POST['sell_date_end'])) : "";
			
			$sell_date_end = $_POST['sell_date_end'] ? 
			date("Y-m-d H:i:s", strtotime($_POST['sell_date_end'])) : "";	
			
			mysql_query("INSERT INTO re_access_date_end (sell_date_end , pay_parse_date_end, company_id)
                          VALUES ('".$sell_date_end."', '".$sell_date_end."', '".$company_id."')");
			
			for($j=1; $j<=4; $j++)
			{
				$phone_addon .= $_POST['phone_addon'.$j] ? $_POST['phone_addon'.$j]."||" : "";
			}
			
			if(isset($values_people)){
				DB::Insert("re_people", "{$column_people} phone_addon, company_id, date_reg", "{$values_people} '{$phone_addon}', '{$company_id}', '{$cur_date}'");
			}
			
			$people_id = DB::Select("id", "re_people", "{$for_search} company_id='{$company_id}' AND date_reg='{$cur_date}'")[0]["id"];
			
			DB::Insert("re_addresses", "people_id, active, sell, rent, ip, comment", "'{$people_id}', '1', '1', '1', '{$_POST['ip']}', '{$_POST['comment']}'");
			
			if(isset($values_user)){
				DB::Insert("re_user", "{$column_user} people_id", "{$values_user} {$people_id}");
			}
			$people_dir = $_SERVER['DOCUMENT_ROOT'].'/images/'.$people_id;
			@mkdir($people_dir, 0777);
			
			if($_POST['old-people-id']>0){
				$old_people = DB::Select("count(*) as c",
                    "re_people",
                    "id={$_POST['old-people-id']} AND surname='{$_POST['pe-surname']}' AND name='{$_POST['pe-name']}' AND surname='{$_POST['pe-surname']}'")[0]["c"];
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
			
			@mkdir($_SERVER['DOCUMENT_ROOT'] .'/images/'. $people_id, 0777);
			try{
				$document_dir = $_SERVER['DOCUMENT_ROOT'] .'/images/'. $people_id .'/documents';
				@mkdir($document_dir, 0777);
				$document_file = PhpThumbFactory::create($_FILES['passport']['tmp_name']);
				$document_file->resize(600);
				$document_file->save($document_dir."/document.jpg");
			}catch(Exception $e){}
			try{
				$user_face_dir = $_SERVER['DOCUMENT_ROOT'] .'/images/'. $people_id .'/user_face';
				@mkdir($user_face_dir, 0777);								
				$face_file = PhpThumbFactory::create($_FILES['face']['tmp_name']);
				$face_file->resize(600);
				$face_file->save($user_face_dir."/face.jpg");
			}catch(Exception $e){}
			
			header("Location: http://". $_SERVER['SERVER_NAME']."/?task=admin&action=user_list");
			return $data;
		} else {
			header("Location: http://". $_SERVER['SERVER_NAME']);
		}
	}
	
	public function show_formnew()
	{
		
	}
	
	public function add_phone(){
		if($_POST['phone'] && $_POST['user']){
			$phone = $_POST['phone'];
			$people_id = Get_functions::Get_people_id_by_user_id($_POST['user']);
			$query = "SELECT phone_addon FROM re_people WHERE `id` = '".$people_id."'";
			$phones_in_db = mysql_fetch_assoc(mysql_query($query));
			if($phones_in_db['phone_addon'] != ""){$phone = $phone."||".$phones_in_db['phone_addon'];}
			$query_add = "UPDATE re_people SET phone_addon = '".$phone."', `date_edit` = '".date("Y-m-d H:i:s")."' WHERE `id` = '".$people_id."'"; 
			$_SESSION['phone_addon'] = $phone;
			mysql_query($query_add);
		}
	}
	
	public function add_email_work(){
		if($_POST['email'] && $_POST['user']){
			$email = $_POST['email'];
			$people_id = Get_functions::Get_people_id_by_user_id($_POST['user']);
			$query_update = "UPDATE re_people SET email_work = '".$email."', `date_edit` = '".date("Y-m-d H:i:s")."' WHERE `id` = '".$people_id."'"; 
			$_SESSION['email_work'] = $email;
			mysql_query($query_update);
		}
	}

	public function add_email_pass(){
		if($_POST['pass'] && $_POST['user']){
			$pass = $_POST['pass'];
			$people_id = Get_functions::Get_people_id_by_user_id($_POST['user']);
			$query_update = "UPDATE re_people SET email_pass = '".$pass."', `date_edit` = '".date("Y-m-d H:i:s")."' WHERE `id` = '".$people_id."'"; 
			$_SESSION['email_pass'] = $email;
			mysql_query($query_update);
		}
	}

	public function add_external_login(){
		if($_POST['login'] && $_POST['user']){
			$login = $_POST['login'];
			$people_id = Get_functions::Get_people_id_by_user_id($_POST['user']);

			DB::Update("re_people", "`external_login`='{$login}', `date_edit` = '".date("Y-m-d H:i:s")."'" , "id={$people_id}");
		}
	}

	public function add_external_pass(){
		if($_POST['pass'] && $_POST['user']){
			$pass = $_POST['pass'];
			$people_id = Get_functions::Get_people_id_by_user_id($_POST['user']);

			DB::Update("re_people", "`external_pass`='{$pass}', `date_edit` = '".date("Y-m-d H:i:s")."'" , "id={$people_id}");
		}
	}




	public function set_photo_limit(){
		if($_POST['photo_limit'] && $_POST['user']){
			$photoLimit = $_POST['photo_limit'];
			$people_id = Get_functions::Get_people_id_by_user_id($_POST['user']);
			$query_update = "UPDATE re_people SET photo_limit = '".$photo_limit."', `date_edit` = '".date("Y-m-d H:i:s")."' WHERE `id` = '".$people_id."'"; 
			$_SESSION['photo_limit'] = $photoLimit;
			mysql_query($query_update);
		}
	}

	public function delete_session()
	{
		if(!$_POST['people_id']){
			echo "FALSE";
			return null;
		}
		$sessions = DB::Select("id, name", "re_session", 
					"people_id = '{$_POST['people_id']}'");
		if(count($sessions) == 0)
		{
			echo "NO_SESSION";
			return null;
		}
		foreach ($sessions as $key => $session) {
			if(unlink("/var/www/fortuna/sessions/sess_{$session['name']}")){
				echo "UNLINK OK";
				DB::Delete('re_session', "`id` = '{$session['id']}'");
			} 
		}
	}
	
	

	public function del_ip()
	{
		if($_POST['id']){
			DB::Delete("re_addresses", 
				"id='{$_POST['id']}'"); 
			return 1;
		}
		return 0;

	}

	public function add_ip(){
		if($_POST['ip'] && $_POST['user'] && $_POST['rentOrSell']){
			$mob = $_POST['mob'];
			$ip = $_POST['ip'];
			$browser = $_POST['browser'];
			$people_id = Get_functions::Get_people_id_by_user_id($_POST['user']);
			DB::Insert("re_addresses", 
					"people_id, `active`, `{$_POST['rentOrSell']}`, `ip`, `browser`, `mob`, `created`", 
					"'{$people_id}', '1', '1', '{$_POST['ip']}', '{$browser}', '{$mob}', NOW()");
			
			$id = DB::Select("`id`", "re_addresses", "people_id = '".$people_id."' AND `".$_POST['rentOrSell']."` = '1' AND `ip`='".$_POST['ip']."'")[0]['id'];
			echo $id;
		}
	}


	
	public function update_ip(){
		if($_POST['ip'] && $_POST['id'] && $_POST['browser']){
			DB::Update("re_addresses", "ip = '{$_POST['ip']}', `browser` = '{$_POST['browser']}', `mob` = '{$_POST['mob']}', created` = NOW() ",
						 "`id` = '{$_POST['id']}'");

		}
	}

	
	public function phone_column_new($phone_column, $people_id, $phone){
		$phones_in_db = DB::Select($phone_column, "re_people", "`id`='".$people_id."'")[0];
		$phones_in_db_array = explode('||', $phones_in_db[$phone_column]);	
		$phone_column_new = "";
		for($i=0; $i<count($phones_in_db_array); $i++)
		{
			if($phones_in_db_array[$i] != $phone)
			{
				$phone_column_new.=$phones_in_db_array[$i]."||";
			}
		}	
		$phone_column_new = substr($phone_column_new, 0, -2);
		return $phone_column_new;
	}
	
	public function delete_phone(){
		if($_POST['phone'] && $_POST['user']){
			$cur_date = date("Y-m-d H:i:s");	
			$phone = $_POST['phone'];
			$people_id = Get_functions::Get_people_id_by_user_id($_POST['user']);			
			$phone_addon_new = $this->phone_column_new("phone_addon", $people_id, $phone);			
			if ($_SESSION['admin'] == "0"){
				$values = "phone_addon = '".$phone_addon_new."', 
							`date_edit` = '".date("Y-m-d H:i:s")."', 
							phone_for_archive = concat(phone_for_archive, '".$phone."||')";
				$condition = "`id` = '".$people_id."'";
				DB::Update("re_people", $values, $condition);

				$column = "`user_id`, `people_id`, `company_id`, `date`, `comment`";
				$values = "'".$_POST['user']."', '".$people_id."', '".$_SESSION['company_id']."', '".$cur_date."', 'Удаление номера ".$phone ."'";
				DB::Insert("re_applications", $column, $values);
			}else if($_SESSION['admin'] == "1"){
				$values = "phone_addon = '".$phone_addon_new."', 
						`date_edit` = '".date("Y-m-d H:i:s")."', 
						phone_archive = concat(phone_archive, '".$phone."||')";		
				$condition = "`id` = '".$people_id."'";
				DB::Update("re_people", $values, $condition);
			}
			$_SESSION['phone_addon'] = $phone_addon_new;
		}
	}

	public function user_activation(){
		if($_SESSION['admin'] == "1" && $_POST['user_id'] && $_POST['application_id'])
		{
			DB::Update("re_user", "active = '1'", "user_id = '".$_POST['user_id']."'");
			DB::Update("re_applications", "`archive` = '1'", "`id` = '".$_POST['application_id']."'");
		}
	}
	
	public function phone_to_archive(){
		if($_SESSION['admin'] == "1" && $_POST['app_id'] && $_POST['phone'])
		{
			$app_id = $_POST['app_id'];
			$phone = $_POST['phone'];
			$people_id = $_POST['people_id'];			
			$phone_for_archive_new = $this->phone_column_new("phone_for_archive", $people_id, $phone);
			$values = "phone_for_archive = '".$phone_for_archive_new."', 
					`date_edit` = '".date("Y-m-d H:i:s")."', 
					phone_archive = concat(phone_for_archive, '".$phone."||')";
			$condition = "`id` = '".$people_id."'";
			DB::Update("re_people", $values, $condition);
			DB::Update("re_applications", "archive=1", "`id`=".$app_id);
		}
	}
	
	public function employee_list(){
		if($_SESSION['parent'] == 0 && (isset($_POST['company_id']) || Helper::getCompanyByLogin()['id'])){
			$company_id = $_POST['company_id'] ? $_POST['company_id'] : $_SESSION["company_id"]; 
			$dismiss = '';
			if($_SESSION['login'] != 'admin') $dismiss = " AND `date_dismiss` = '0000-00-00'";
			$data = DB::Select("*", $this->query_users, 
					"re_company.id=".$company_id." AND `archive` = '0' {$dismiss}
					ORDER BY parent");
			return $data;
		}else{
			header("Location: http://". $_SERVER['SERVER_NAME']);
		}
	}
	
	public function an_info(){
		if($_POST['var_id'] && isset($_SESSION['user'])){
			$user = mysql_fetch_assoc(mysql_query("select re_user.user_id, re_user.people_id, re_user.parent from re_user INNER JOIN re_var ON re_user.user_id = re_var.user_id where re_var.id = ".$_POST['var_id']));
			/*если владелец варианта директор АН*/
			if($user['parent'] == 0){
				$people = mysql_fetch_assoc(mysql_query("select re_people.id, re_company.company_name, re_people.name, re_people.second_name, re_people.email, re_people.phone, re_people.phone_addon, re_addresses.street, re_addresses.house, re_addresses.office FROM re_people	INNER JOIN re_company ON re_company.id = re_people.company_id INNER JOIN re_addresses ON re_people.id = re_addresses.people_id where re_people.id = ".$user['people_id']." GROUP BY re_people.id"));
				$data = "<div style='text-align: center;'><h3>АН «".$people['company_name']."»</h3>
							<span>".$people['street']." ".$people['house']." ".$people['office']."</span>
						</div>
						<div><b>Директор АН и владелец сообщения:</b><br> 
								".$people['name']." ".$people['second_name']."
								<br>тел.: ".$people['phone']."
								<br />доп.тел.: ".str_replace('||', ', ', $people['phone_addon'])."
						</div>";
			}else{
				$res = mysql_query("select re_user.user_id, re_people.id as people_id, re_company.company_name, re_people.name, re_people.second_name, re_people.email, re_people.phone, re_people.phone_addon, re_addresses.street, re_addresses.house, re_addresses.office FROM re_user INNER JOIN re_people ON re_people.id = re_user.people_id	INNER JOIN re_company ON re_company.id = re_people.company_id INNER JOIN re_addresses ON re_people.id = re_addresses.people_id where re_user.user_id = ".$user['user_id']." OR re_user.user_id = ".$user['parent']);
				$num = mysql_num_rows($res);
				for($v=0; $v<$num; $v++){
					$fetch = mysql_fetch_assoc($res);
					$people[$fetch['user_id']] = $fetch;
				}
				$data = "<div style='text-align: center;'><h3>АН «".$people[$user['user_id']]['company_name']."»</h3>
							<span>".$people[$user['parent']]['street']." ".$people[$user['parent']]['house']." ".$people[$user['parent']]['office']."</span>
						</div>
						<div class='row' style='text-align: center;'>
							<div class='col-xs-6'><b>Директор АН:</b><br> 
									".$people[$user['parent']]['name']." ".$people[$user['parent']]['second_name']."
									<br>тел.: ".$people[$user['parent']]['phone'].", 
									<br />доп.тел.: ".str_replace('||', ', ', $people[$user['parent']]['phone_addon'])."
							</div>						
							<div class='col-xs-6'><b>Владелец сообщения:</b><br> 
									".$people[$user['user_id']]['name']." ".$people[$user['user_id']]['second_name']."
									<br>тел.: ".$people[$user['user_id']]['phone'].", 
									<br />доп.тел.: ".str_replace('||', ', ', $people[$user['user_id']]['phone_addon'])."
							</div>
						</div>";
			}
			echo $data;
			unset($user, $people, $res, $v, $num, $fetch);
		}
	}
	
	public function send_review()
	{
		if(isset($_POST['var_id']) && isset($_SESSION['people_id']) && isset($_POST['review'])){
			if($_POST['table']=="site"){
				$anonymous = isset($_POST["anonymous"]) ? 1 : 0;
				DB::Insert('re_review', 'var_id, people_id, review, anonymous', $_POST['var_id'].', '.$_SESSION['people_id'].', "'.$_POST['text'].'", '.$anonymous);
				if($anonymous==0 && $_POST['review']==0){
					DB::Update('re_var', 'review=1', 'id='.$_POST['var_id']);
				}else{
					echo "wqeqwe";
				}
                unset($anonymous);
			}else if($_POST['table']=="parse"){
				$date = date("Y-m-d H:i:s");
				DB::Update('re_parse', 'review=1', "id={$_POST['var_id']}");
				DB::Insert('re_review_parse', 'people_id, parse_id, text, date', "{$_SESSION['people_id']}, {$_POST['var_id']}, '{$_POST['text']}', '{$date}'");
			}else if($_POST['table']=="pay_parse"){
				$date = date("Y-m-d H:i:s");
				DB::Update('re_pay_parse', 'review=1', "id={$_POST['var_id']}");
				DB::Insert('re_review_pay_parse', 'people_id, parse_id, text, date', "{$_SESSION['people_id']}, {$_POST['var_id']}, '{$_POST['text']}', '{$date}'");
			}
		}
	}
	
	public function check_comment_set()
	{
		if($_POST && $_SESSION['user']){
			$result = DB::Update("re_check_rielter", "check_comment='".$_POST['comment']."'", "people_id=".$_POST['people_id']." AND search_str='".$_POST['search_str']."'");
			return $result;
		}
	}
	
	public function messages(){
		if($_SESSION['user']){
			$data = DB::Select("*, max(new)", "re_messages", "people_id_to=".$_SESSION['people_id']." GROUP BY people_id_from ORDER BY date_send DESC, new DESC");
			return $data;
		}else{
			header("Location: http://". $_SERVER['SERVER_NAME']);
		}
	}
	
	public function send_messages(){
		if($_SESSION['user'] &&  $_POST){
			$date = date("Y-m-d H:i:s");
			$result = DB::Insert("re_messages", "people_id_from, login_from, people_id_to, text, date_send, new", $_SESSION["people_id"].", '".$_SESSION['login']."', 1, '".$_POST['text']."', '".$date."', 1");
			$data = $result==1 ? "<div style='margin: 20px;color: rgb(78, 202, 58);'>Сообщение отправлено</div>" : "<div style='margin: 20px;color: rgb(202, 58, 58);'>Произошла ошибка попробуйте позже</div>";
			
			$to  = "balistic@ngs.ru";
			$subject = "Сообщение от пользователя. Логин ".$_SESSION['login'];
			$message = $_POST['text'];						
			$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
			$headers .= "From: trading-platform.ru <fortunasib@mail.ru>\r\n";
			mail($to, $subject, $message, $headers); 
		
			unset($date, $result, $to, $subject, $message, $headers);
			return $data;
		}
	}
	
	public function order_txt(){
	
		return $this->text_file_orders;
    }

	public function order(){
		if($_SESSION["parent"] == 0){
			$data = DB::Select("*", "re_order", "company_id='".$_SESSION['company_id']."' ORDER BY id DESC");
			$res = mysql_query("SELECT order_access FROM re_company WHERE id=".$_SESSION['company_id']);
			$data[0]['order_access'] = mysql_fetch_assoc($res)["order_access"];
			$_SESSION["order_access"] = $data[0]['order_access'];
			return $data;
		}
	}
	
	public function order_send(){
		if(
			$_SESSION["parent"] == 0 && 
			$_POST['access']=="on" && 
			$_SESSION["order_access"] == 1 && 
			$_POST["order_place"]!="" && 
			isset($_SESSION["company_id"])
		){

			$pay_date = $_POST['pay_date']." ".$_POST['pay_time'];
			$sum = str_replace(' ', '', $_POST["sum"]);
			
			if($_POST["order_type"]=="qiwi"){
				$sum = $sum - 20;
			}
			
			foreach($_POST as $k=>$v){
				if($v!="" && $k!="pay_date" && $k != "pay_time" && $k != "card_number"&& $k != "wallet_num" && $k != "sum" && $k != "access" && $k!="name" && $k!="surname" && $k!="second_name"){
					$values .= "'".$v."', ";
					$columns .= "`".$k."`, ";
				}
			}

			$values .= "'".$pay_date."', '".$sum."', '".date("Y-m-d H:i:s")."'";
			$columns .= "`pay_date`, `sum`, `date_order`";

			if(!empty($_POST["surname"])){
				//$second_name = substr($_POST["second_name"], 0, 2);
				$values .= ", '".$_POST["name"]." ".$_POST["surname"]." ".$_POST["second_name"]."'";
				$columns .= ", `wallet_num`";
			}

			if($_POST["order_type"]=="sber"){
				$values .= ", '{$_POST['card_number']}'";
				$columns .= ", `card_number`";
			}
			if($_POST["order_type"]=="qiwi"){
				$values .= ", '{$_POST['wallet_num']}'";
				$columns .= ", `wallet_num`";
			}


			$new_bal = intval(DB::Select("balance", "re_company", "id=".$_SESSION["company_id"])[0]['balance']) + $sum;

			DB::Update("re_company", "order_access = 0, balance = ".$new_bal, "id=".$_SESSION["company_id"]);
			DB::Insert("re_order", $columns, $values);
			$_SESSION["order_access"] = 0;
			header("Location: http://". $_SERVER['SERVER_NAME']."/?task=profile&action=services&show=message");
		}else{
			session_destroy();
			header("Location: http://". $_SERVER['SERVER_NAME']);
			// if(!isset($_SESSION['user'])){
				// header("Location: http://". $_SERVER['SERVER_NAME');
			// }else{
				// header("Location: http://". $_SERVER['SERVER_NAME']);			
			// }
		}
	}
	
	public function check_rielter()
	{
		$colums_var = "re_var.id, re_var.user_id, re_var.fortuna_id as tid, re_var.photo, 
					re_user.parent as user_parent, access_var, re_var.active, re_var.owner, ap_layout, 
					re_var.parent_id, re_var.rent_type, re_var.commission, col_date, re_company.company_name, 
					re_people.name, re_people.id as people_id, re_people.second_name, re_people.phone, dis, 
					planning, live_point, street, house, orientir, text, topic_id, type_id, price, date_last_edit, copyright,
					sq_all, sq_live, sq_k, sq_land, floor, floor_count, room_count, coords, deliv_period, prepayment, 
					utility_payment, deposit, furn, tv, washing, refrig, ap_view_date, ap_race_date, status, premium, 
					favorit, ap_view_price, in_black_list, review, residents, hidden_text, 
					DATE_FORMAT(DATE_ADD(`date_last_edit`, INTERVAL -1 hour),'%d/%m/%Y %H:%i') as `date_last_edit_format`, 
					DATE_FORMAT(`date_added`,'%d/%m/%Y %H:%i') as `date_added_format`,  
					wc_type, heating, wash, water, sewage, torg";

		$condition_var  =  " re_var.active = 1 AND (re_user.user_id='".$_SESSION['user']."' OR re_user.parent='".$_SESSION['user']."')";
		$table = "`re_var` INNER JOIN re_user ON re_var.user_id = re_user.user_id 
						INNER JOIN re_people ON re_user.people_id = re_people.id 
						INNER JOIN re_company ON re_people.company_id = re_company.id";
		$data_res['var_list'] = DB::Select($colums_var, $table, $condition_var." ORDER BY premium DESC ");
		$data = [];

		if(!empty($_POST)){
			if( $_SESSION['user']
				 && ($_POST["phone"] != "" || $_POST["company_id"] != "")
				 && ($_POST['var_id'] !="***" || $_POST["company_id"] != "")
				)	
		{
				$date = date("Y-m-d H:i:s");
				$check_list = DB::Select("re_check_rielter.id, people_id, search_str, search_result, DATE_ADD(date_search, INTERVAL -1 hour) as date_search, check_comment, second_name, name, phone, company_name",
                    "re_check_rielter INNER JOIN re_people ON re_check_rielter.people_id = re_people.id
                    INNER JOIN re_company ON re_people.company_id = re_company.id",
                    "search_str = '".$_POST['phone']."' AND 
                    re_check_rielter.date_search >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH) 
                    ORDER BY `date_search` DESC");
				$continue = $check_list[0]['people_id'] != $_SESSION['people_id'] ? true : false;			
				$company_id = $_POST["company_id"] == "" ? "" : "AND a.company_id=".$_POST["company_id"];
				$postPhone = Helper::FilterVal('phone');
				if($postPhone!=""){
                    $postPhone =  Helper::phone_format($postPhone, '8 (###) ###-####', '#');
					$data = DB::Select("p.id pid, parent, date_dismiss, second_name, name, phone, phone_addon, phone_archive, date_reg, company_name, warning, active",
						"re_people as p, re_company as c, re_user as u, re_access_date_end as a", 
						"p.company_id = c.id AND u.people_id=p.id AND a.company_id = c.id AND sell_date_end > NOW() AND
						 (
						 	phone like '%{$postPhone}%' OR 
						 	phone_addon like '%{$postPhone}%' OR 
						 	phone_archive like '%{$postPhone}%') ".$company_id." 
					AND u.active=1 
					ORDER BY date_dismiss");

				}else if($company_id !=""){
					$data = DB::Select("p.id pid, parent, date_dismiss, second_name, name, phone, phone_addon, phone_archive, date_reg, company_name, warning, active",
                        "re_people as p, re_company as c, re_user as u, re_access_date_end as a",
                        "p.company_id = c.id AND u.people_id=p.id AND a.company_id = c.id AND sell_date_end > NOW() ".
                        $company_id." AND u.active=1 ORDER BY date_dismiss");
				}

				$count = count($data);
				if($count > 0){
					for($s=0; $s<$count; $s++){
						$data[$s]['status'] = $data[$s]['date_dismiss'] == '0000-00-00 00:00:00' ? "работник агентства" : "<span style='color:red'>уволен, дата увольнения: ".date("d.m.Y H:i:s", strtotime($data[$s]['date_dismiss']))."</span>";
					}
					$search_result = $data[0]['date_dismiss'] == '0000-00-00 00:00:00' || $data[0]['active']==1 ? 2 : 1;
					$data['check_list'] = null;
				}else{
					$data['check_list'] = $check_list; 
					$search_result = 0;
				}		
				$data['search_result'] = $search_result; 
				if($continue && $_SESSION['people_id']!=1){
					DB::Insert("re_check_rielter",
							 "people_id, search_str, search_result, date_search, variant", 
								"{$_SESSION['people_id']}, '{$_POST['phone']}', {$search_result}, '{$date}', '{$_POST['var_id']}'");
				}

				unset($search_result, $count, $s, $check_list);

			}elseif ($_POST['var_id'] =="***") {
				$data['error']	=	"***";
			}


		}
		return array_merge($data, $data_res);
	}
	
	public function find_rielter(){
		if($_SESSION['user'] && ($_POST["tel"] || $_POST['id'])){
			if(isset($_POST["tel"])){
				$query = "SELECT `company_name`, `surname`, `name`, `second_name`, `phone`, CONCAT_WS(' ', surname, name, second_name) as fio FROM `re_people` INNER JOIN re_company ON re_company.id = re_people.company_id WHERE phone='".$_POST["tel"]."' OR phone_addon like '%".$_POST["tel"]."%'";
			}else{
				$query = "SELECT `company_name`, `surname`, `name`, `second_name`, `phone`, CONCAT_WS(' ', surname, name, second_name) as fio FROM `re_people` INNER JOIN re_company ON re_company.id = re_people.company_id WHERE re_company.id={$_POST['id']}";
			}
			$res = mysql_query($query);
			$num = mysql_num_rows($res);
			$result = "";
			for($t=0; $t<$num; $t++){
				$people = mysql_fetch_assoc($res);
				$result.=	"<tr>
							  <td>".$people['company_name']."</td>
							  <td>".$people['name']." ".$people['second_name']."</td>
							  <td>".$people['phone']."</td>
							  <td><a href='javascript:void(0)' onclick='$(\"[data-id=black-group] tbody\").append($(\"tr\").has($(this))); $(\"tr\").has($(this)).find(\".hidden\").removeClass(\"hidden\"); $(\"td\").has($(this)).addClass(\"hidden\")'>исключить</a></td>
							  <td class='hidden'><input type='checkbox' value='".$people['fio']."'></td>
						</tr>";
			}
			echo $result;
		}
	}
	
	public function create_profile(){
		$cur_date = date("Y-m-d H:i:s");
		if($_SESSION['parent']==0 AND $_SESSION['company_id']){
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
						$parent_id = mysql_fetch_assoc(mysql_query("select user_id from re_user INNER JOIN re_people on re_user.people_id = re_people.id where company_id = ".$_SESSION['company_id']." AND re_user.parent = 0"))['user_id'];
						
						foreach($_POST as $k=>$v){				
							if($v!=""){
								if(ereg('us-', $k)){
									$k = explode('-', $k)[1];
									$values_user.= "'".$v."', ";
									$columns_user.= "`".$k."`, ";
									$condition_user.= "`".$k."`='".$v."' AND ";
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
							
							if($_SESSION["admin"]==0){
								$query = "SELECT user_id FROM re_user WHERE people_id=".$people_id;
								$user_id = mysql_fetch_assoc(mysql_query($query))["user_id"];
								DB::Insert("re_applications", "user_id, people_id, company_id, date, comment", $user_id.", ".$people_id.", ".$_SESSION["company_id"].", '".$cur_date."', 'Новый сотрудник'");
							}
							
							@mkdir($_SERVER['DOCUMENT_ROOT'] .'/images/'. $people_id, 0777);
							try{
								$document_dir = $_SERVER['DOCUMENT_ROOT'] .'/images/'. $people_id .'/documents';
								@mkdir($document_dir, 0777);
								$document_file = PhpThumbFactory::create($_FILES['passport']['tmp_name']);
								$document_file->resize(600);
								$document_file->save($document_dir."/document.jpg");
							}catch(Exception $e){}
							try{
								$user_face_dir = $_SERVER['DOCUMENT_ROOT'] .'/images/'. $people_id .'/user_face';
								@mkdir($user_face_dir, 0777);								
								$face_file = PhpThumbFactory::create($_FILES['face']['tmp_name']);
								$face_file->resize(600);
								$face_file->save($user_face_dir."/face.jpg");
							}catch(Exception $e){}
							$data = "Готово!";
							header("Location: http://".$_SERVER['SERVER_NAME']."/?task=profile&action=user_list");
						}
					}else{$data = "Данный риелтер работает в агенстве '".$company_name."'";}
				}else{$data =  "Логин '".$_POST['login']."' прикреплён за '".$fio."'";}
			}else{$data =  "Телефон '".$_POST['phone']."' прикреплён за '".$fio['surname']." ".$fio['name']." ".$fio['second_name']."'";}
		}else{
			header("Location: http://". $_SERVER['SERVER_NAME']);
		}
		return $data;
	}
	
	public function user_list()
	{
		if($_SESSION['parent'] == 0) {	
			$data = DB::Select("re_company.id, re_company.company_name, re_access_date_end.sell_date_end, re_access_date_end.sell_date_end",
			 "re_company INNER JOIN re_access_date_end ON re_company.id=re_access_date_end.company_id", 
			 "company_name='".$_SESSION['company_name']."' ORDER BY company_name");
			return $data;
		} else {
			header("Location: http://". $_SERVER['SERVER_NAME']);
		}
	}

    public function services()
    {
        if(!Helper::isDirector())
        {
            header("Location: http://". $_SERVER['SERVER_NAME']."/?task=profile&action=rules");
        }
        return Helper::Services_data();
    }

    private function serviceUpdateRent($people_id, $rentMonthCount)
    {
        $company = Helper::getCompanyByPeople($people_id);
        Helper::logFile('rent', [$people_id, ['rentMonthCount'=>$rentMonthCount], $company]);
        $date = DB::Select("sell_date_end", "re_access_date_end", "company_id={$company['id']}")[0]["sell_date_end"];
        if(date('Y-m-d', strtotime($date)) >= date('Y-m-d')){
            $new_date = date('Y-m-d', strtotime("{$date} + {$rentMonthCount} month"));
        }else{
            $new_date = date('Y-m-d', strtotime("+{$rentMonthCount} month"));
        }
        DB::Update("re_access_date_end", "sell_date_end='$new_date', pay_parse_date_end ='$new_date'", "company_id={$company['id']}");

        $_SESSION['sell_date_end'] = $new_date;
        $_SESSION['group_topic_id'] = 2;

        $_SESSION['sell_date_end'] = date("Y-m-d", strtotime($new_date));
        $_SESSION['pay_parse_date_end'] = date("Y-m-d", strtotime($new_date));
        $res = mysql_query("SELECT GROUP_CONCAT(id SEPARATOR ' OR people_id=') as ids from re_people 
                    where company_id={$company['id']} AND id!={$people_id}");
        $ids = mysql_fetch_assoc($res)['ids'];
        if($ids!=""){
            DB::Delete("re_session", "people_id={$ids}");
        }
        return $new_date;
    }

    private function serviceUpdatePremium($people_id, $rentPremiumPeriod, $rentPremiumCount)
    {
        $company = Helper::getCompanyByPeople($people_id);
        Helper::logFile('premium', [$people_id, ['rentPremiumPeriod'=>$rentPremiumPeriod, 'rentPremiumCount'=>$rentPremiumCount], $company]);
        if($rentPremiumPeriod > 0 && $rentPremiumCount > 0){
            if($rentPremiumPeriod < 10){
                $premiumCost = $rentPremiumPeriod*$rentPremiumCount*2;
            }else if($rentPremiumPeriod < 30){
                $premiumCost = $rentPremiumPeriod*$rentPremiumCount*1.5;
            }else if(($rentPremiumPeriod+0) == 30) {
                $premiumCost = 40*$rentPremiumCount;
            }
            $date_finish = date('Y-m-d H:i:s', strtotime("+".$rentPremiumPeriod." day"));
            DB::Insert("re_payment",
                "company_id, day_count, premium_count, sum, date_payment, date_finish",
                "'{$company['id']}', '{$rentPremiumPeriod}', '{$rentPremiumCount}',
                {$premiumCost},'".date("Y-m-d H:i:s")."', '{$date_finish}'");
            DB::Update("re_company",
                "rent_premium=`rent_premium`+{$rentPremiumCount}",
                "id={$company['id']}"
            );
        }
        return Helper::getCompanyByPeople($people_id)['rent_premium'];
    }

    private function updatePayParse($people_id, $payParseMounthCount)
    {
        $company = Helper::getCompanyByPeople($people_id);
        Helper::logFile('payparse', [$people_id, ['payParseMounthCount' => $payParseMounthCount], $company]);
        $date = DB::Select("sell_date_end", "re_access_date_end", "company_id={$company['id']}")[0]["sell_date_end"];
        if(date('Y-m-d', strtotime($date)) >= date('Y-m-d')){
            $new_date = date('Y-m-d', strtotime("{$date} + {$payParseMounthCount} day"));
        }else{
            $new_date = date('Y-m-d', strtotime("+{$payParseMounthCount} day"));
        }
        DB::Insert("re_payment",
            "company_id, day_count, sum, date_payment, date_finish, comment",
            "{$company['id']}, '{$payParseMounthCount}', 
            ".$payParseMounthCount."*7, '".date("Y-m-d H:i:s")."', '$new_date', 'Оплата частников 2'"
        );
        DB::Update("re_access_date_end",
            "sell_date_end='$new_date', pay_parse_date_end='$new_date', ",
            "company_id=".$company['id']
        );
        $_SESSION["sell_date_end"] = $new_date;

        $res = mysql_query("SELECT GROUP_CONCAT(id SEPARATOR ' OR people_id=') as ids from re_people 
                where company_id={$company['id']}  AND id!={$people_id}");
        $ids = mysql_fetch_assoc($res)['ids'];
        if($ids!=""){
            DB::Delete("re_session", "people_id={$ids}");
        }
    }

    private function serviceUpdateSell($people_id, $sellMounthCount)
    {
        $company = Helper::getCompanyByPeople($people_id);
        Helper::logFile('sell', [$people_id, ['sellMounthCount' => $sellMounthCount],  $company]);
        if($sellMounthCount>0){
            $date = DB::Select("sell_date_end", "re_access_date_end", "company_id={$company['id']}")[0]["sell_date_end"];
            if(date('Y-m-d', strtotime($date)) >= date('Y-m-d')){
                $new_date = date('Y-m-d', strtotime("{$date} +{$sellMounthCount} month"));
            }else{
                $new_date = date('Y-m-d', strtotime("+{$sellMounthCount} month"));
            }
            DB::Update("re_access_date_end",
                "sell_date_end='$new_date', pay_parse_date_end='$new_date'",
                "company_id={$company['id']}"
            );
            $_SESSION['sell_date_end'] = $new_date;
            $_SESSION['pay_parse_date_end'] = $new_date;
        }
        return $new_date;
    }

	public function services_pay()
    {
        $data = Helper::Services_data();
        if(Helper::FilterVal('Success') == 'true'){
            $paymentId = Helper::FilterVal('PaymentId');
            $orderId = Helper::FilterVal('OrderId');

            $tinkoffPayment = DB::Select('*', 're_payment_tinkoff',"order_id = '{$orderId}' AND success <> 1 LIMIT 1" );

            Helper::logFileServicesPay($tinkoffPayment[0]['id'],'services_pay', ["SUCCESS",["Payment"=>$tinkoffPayment],["GET"=>$_GET],["SESSION"=>$_SESSION]]);
            if(empty($tinkoffPayment)){
                return false;
            }
            if((int)$tinkoffPayment[0]["rent"] != 0) {
                $data['sell_date_end'] = self::serviceUpdateRent($tinkoffPayment[0]["people_id"], $tinkoffPayment[0]["rent"]);
                $data['rent_month_count'] = (int)$tinkoffPayment[0]["rent"];
            }

            if((int)$tinkoffPayment[0]["premium_lenght"] != 0) {
               $data['rent_premium'] = self::serviceUpdatePremium($tinkoffPayment[0]["people_id"], $tinkoffPayment[0]["premium_lenght"], $tinkoffPayment[0]["premium"]);
                $data['rent_premium_count'] =(int) $tinkoffPayment[0]["premium"];
                $data['rent_premium_period'] = (int) $tinkoffPayment[0]["premium_lenght"];
            }

            if((int)$tinkoffPayment[0]["pay_parse"] != 0) {
                self::updatePayParse($tinkoffPayment[0]["people_id"], $tinkoffPayment[0]["pay_parse"]);
                $data['pay_parse_days_count'] = (int) $tinkoffPayment[0]["pay_parse"];
            }

            if((int)$tinkoffPayment[0]["sell"] != 0) {
                $data['sell_date_end'] = self::serviceUpdateSell($tinkoffPayment[0]["people_id"], $tinkoffPayment[0]["sell"]);
                $data['buysell_month_count'] = (int)$tinkoffPayment[0]["sell"];
            }

            $data['price'] = $tinkoffPayment[0]['amount'];

            DB::Update("re_payment_tinkoff",
                "success = 1, payment_id = '{$paymentId}', paid_date = NOW()",
                "order_id = '{$orderId}'"
            );
        }elseif (Helper::FilterVal('Success') == 'false'){
            Helper::logFile('services_pay', ["!!! FAIL !!!",$_GET,$_SESSION]);
            $data['fail'] = true;
        }
        Helper::logFile('services_pay', ["!!! EMPTY_PAYMENT !!!", $_GET, $_SESSION]);

        return  array_merge(Helper::Services_data(), $data);
    }

	public function services_payment()
	{
        if(isset($_SESSION['company_id'])){
            $company = DB::Select('*','re_company',"id = {$_SESSION['company_id']}")[0]  ;
        }
		if($_SESSION['parent']==0 && $_POST){
			$financeNeed =  DB::Select("subscription_sell, duty", "re_company", "id=".Helper::getCompanyByLogin()['id'])[0];
            DB::Update("re_company", "balance=balance-".Helper::FilterVal('sum')."-duty, duty=0", "id=".Helper::getCompanyByLogin()['id']);
            //SELL
            if($_POST["type"] == "sell"){

                if(!Helper::Service_Need_Finance(1,$_POST["sell_month_count"],(int)$company['subscription_sell'],$financeNeed['duty'])) return false;

                $date = DB::Select("sell_date_end", "re_access_date_end", "company_id=".Helper::getCompanyByLogin()['id'])[0]["sell_date_end"];
                if(date('Y-m-d', strtotime($date)) >= date('Y-m-d')){
                    $new_date = date('Y-m-d', strtotime("{$date} +{$_POST["sell_month_count"]} month"));
                }else{
                    $new_date = date('Y-m-d', strtotime("+{$_POST["sell_month_count"]} month"));
                }
                DB::Update("re_access_date_end", "sell_date_end='$new_date', pay_parse_date_end='$new_date'", "company_id=".Helper::getCompanyByLogin()['id']);
                $_SESSION['sell_date_end'] = $new_date;
                $_SESSION['pay_parse_date_end'] = $new_date;

                $balance_change = $_POST["sell_month_count"] * (int)$company['subscription_sell'];
                DB::Update("re_company", "balance=balance-".$balance_change."-duty, duty=0", "id=".Helper::getCompanyByLogin()['id']);
                unset($balance_change);

            }
			else if($_POST["duty"]){

				$duty_comment = mysql_fetch_assoc(mysql_query("SELECT duty_comment FROM re_company WHERE id=".Helper::getCompanyByLogin()['id']))["duty_comment"];
				DB::Insert("re_payment", "company_id, sum, date_finish, date_payment, active, comment", "'".Helper::getCompanyByLogin()['id']."', '".$_POST["duty"]."', '".date("Y-m-d")."', '".date("Y-m-d H:i:s")."', 0, 'Гашение долга. ".$duty_comment."'");
				$duty = DB::Select("duty", "re_company", "id=".Helper::getCompanyByLogin()['id'])[0]['duty'];
				if($duty > 0){
					DB::Update("re_company", "balance=`balance`-".$_POST["duty"].", duty=`duty`-".$_POST["duty"].", duty_comment=''", "id=".Helper::getCompanyByLogin()['id']);
				}
				header("Location: http://". $_SERVER['SERVER_NAME']."/?task=profile&action=services");
				unset($duty_comment);
			}
            // RENT
//			else if($_POST["type"] == "rent"){
//                self::serviceUpdateRent($_SESSION['people_id'], $_POST["rent_month_count"]);
//				// PREMIUM
//			}else if($_POST["type"] == "premium"){
//			    self::serviceUpdatePremium($_SESSION['people_id'],$_POST["rent_premium_period"], $_POST["rent_premium_count"]);
//                DB::Update("re_company", "balance=balance-".Helper::FilterVal('sum')."-duty, duty=0", "id=".Helper::getCompanyByLogin()['id']);
//				//PAY PARSE
//			}else if($_POST["type"] == "pay_parse"){
//				if($_POST["pay_parse_period"]>0){
//					self::updatePayParse($_SESSION['people_id'],$_POST["pay_parse_period"]);
//                    DB::Update("re_company", "balance=balance-".Helper::FilterVal('sum')."-duty, duty=0", "id=".Helper::getCompanyByLogin()['id']);
//				}
				//APPLICATION
//			} else if($_POST["type"] == "application"){
//				$balance_change = $_POST["rielter_count"] ? $_POST["rielter_count"] * 100 : $_POST["rielter_sum"];
//				DB::Update("re_company", "balance=balance-".$balance_change."-duty, duty=0", "id=".Helper::getCompanyByLogin()['id']);
//				DB::Insert("re_applications", "user_id, people_id, company_id, date, comment", $_SESSION['user'].", ".$_SESSION['people_id'].", ".Helper::getCompanyByLogin()['id'].", '".date("Y-m-d H:i:s")."', '".$_POST["comment"]." (оплачено: ".$balance_change.")'");
//				unset($balance_change);
//				// DUTY
//			}
		}
	}
	
	public function callboard(){
		if($_SESSION["user"] && $_GET["callboard_topic"])
		{
			$columns = "re_callboard.id, re_callboard.text, re_people.id as people_id, DATE_FORMAT(re_callboard.date,'%d.%m.%Y %H:%i') as date, name, phone, company_name, photo";
			$table = "re_callboard INNER JOIN re_people ON re_people.id=re_callboard.people_id INNER JOIN re_company ON re_company.id=re_people.company_id";
			$data = DB::Select($columns, $table, "callboard_topic = '".$_GET["callboard_topic"]."' ORDER BY id DESC");
			unset($columns, $table);
			return $data;
		}
	}
	
	public function delete_callboard(){
		if(isset($_POST['id']) && isset($_SESSION['people_id'])){
			$query = mysql_query("SELECT people_id FROM re_callboard WHERE id={$_POST['id']}");
			$people_id = mysql_fetch_assoc($query)["people_id"];
			if($people_id == $_SESSION['people_id']){
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
	}
	
	public function forum(){
		if(isset($_SESSION["people_id"])){
			$blackListForum = Get_functions::Get_black_list_forum();
			/*выборка тем обсуждения форума*/
			if(!isset($_GET["new"]) && !isset($_GET["topic"])){

				$data = DB::Select("f.id, f.title, f.people_id, p.name, p.second_name, c.company_name", 
					"re_forum_topic as f, re_people as p, re_company as c", "f.id <> 12 AND f.people_id = p.id AND p.company_id=c.id ORDER BY f.date DESC");
				return $data;

			}else if($_GET["new"]=="title" && isset($_POST["title"])){

				/*Добавление новой темы для обсуждения*/
				DB::Insert("re_forum_topic", "people_id, title, date", "'".$_SESSION["people_id"]."', '".$_POST["title"]."', NOW()");
				$res = mysql_query("SELECT id FROM re_forum_topic WHERE people_id='".$_SESSION["people_id"]."' AND title='".$_POST["title"]."'");
				$id = mysql_fetch_assoc($res)["id"];
				header("Location: http://". $_SERVER['SERVER_NAME']."/?task=profile&action=forum&topic=".$id);

			}else if(isset($_GET["topic"])){
				if($_GET["new"]=="text" && isset($_POST["text"])){

					$newRentMess = DB::Insert("re_forum", 
							"topic_id, people_id, text, date", 
							"'".$_GET["topic"]."', '".$_SESSION["people_id"]."', '".$_POST["text"]."', NOW()");
					if($_GET["topic"] == 12){
						if($newRentMess ==1 ){
							Helper::createRentMessages($_SESSION["people_id"], $_POST["text"]);
							header("Location: http://". $_SERVER['SERVER_NAME']."/?task=profile&action=forum_rent&topic={$_GET["topic"]}");
						}
					}else{
						/*добавление нового сообщения в теме и обновление даты темы*/
						DB::Update("re_forum_topic", "date=NOW()", "id=".$_GET["topic"]);
						header("Location: http://". $_SERVER['SERVER_NAME']."/?task=profile&action=forum&topic=".$_GET["topic"]);
					}

				}else if($_GET["new"]=="comment" && isset($_POST["text"])){
					/*добавление комментария к сообщению в теме и обновление даты комментируемого сообщения*/
					DB::Insert("re_forum", "topic_id, people_id, text, comment_id, date", 
						"'".$_GET["topic"]."', '".$_SESSION["people_id"]."', '".$_POST["text"]."', '".$_POST["id"]."', NOW()");
					DB::Update("re_forum", "date=NOW()", "id=".$_POST["id"]);
					

					if($_GET["topic"] == 12){
						Helper::createRentMessagesAnsver($_POST["id"], $_SESSION["people_id"], $_POST["text"]);
						header("Location: http://". $_SERVER['SERVER_NAME']."/?task=profile&action=forum_rent&topic=".$_GET["topic"]);
					}else{
						header("Location: http://". $_SERVER['SERVER_NAME']."/?task=profile&action=forum&topic=".$_GET["topic"]);
					}
				}
				/*выборка сообщений и комментариев в теме*/
				$page = $_GET['page']>1 ? $_GET['page'] : 1;
				$limit = ($page - 1)*50;
					$conditionInterval = '';
					if($_GET["topic"] == 12){
						$conditionInterval = ' f.date >= DATE_SUB(CURRENT_TIMESTAMP(), INTERVAL 15 HOUR) AND ';
					}
					$sqlForumMessage = "SELECT f.*, DATE_FORMAT(DATE_ADD(f.date, INTERVAL -1 hour), '%H:%i %d.%m.%Y') as date_f, p.phone, p.name, p.second_name, c.company_name,
				 (SELECT count(topic_id) FROM re_forum as f2 WHERE f2.comment_id = f.id AND f2.people_id NOT IN ({$blackListForum}) GROUP BY topic_id) as comment_count,
				  (SELECT count(*) as count from re_forum WHERE topic_id={$_GET['topic']} AND comment_id is null AND people_id NOT IN ({$blackListForum})) as count
				   FROM re_forum as f, re_people as p, re_company as c
				    WHERE {$conditionInterval} f.topic_id={$_GET['topic']} AND f.people_id = p.id AND p.company_id = c.id AND f.comment_id is null AND f.people_id NOT IN ({$blackListForum}) ORDER BY f.date 
				    DESC LIMIT {$limit}, 50";
				$res = mysql_query(
					"SELECT f.*, DATE_FORMAT(DATE_ADD(f.date, INTERVAL -1 hour), '%H:%i %d.%m.%Y') as date_f, p.phone, p.name, p.second_name, c.company_name,
				 (SELECT count(topic_id) FROM re_forum as f2 WHERE f2.comment_id = f.id AND f2.people_id NOT IN ({$blackListForum}) GROUP BY topic_id) as comment_count,
				  (SELECT count(*) as count from re_forum WHERE topic_id={$_GET['topic']} AND comment_id is null AND people_id NOT IN ({$blackListForum})) as count
				   FROM re_forum as f, re_people as p, re_company as c
				    WHERE {$conditionInterval} f.topic_id={$_GET['topic']} AND f.people_id = p.id AND p.company_id = c.id AND f.comment_id is null AND f.people_id NOT IN ({$blackListForum}) ORDER BY f.date 
				    DESC LIMIT {$limit}, 50");

				while($row = mysql_fetch_assoc($res)){
					$data[]=$row;
				}				
				unset($res);
				/*выбор заголовка темы*/
				$res = mysql_query("SELECT title FROM re_forum_topic WHERE id=".$_GET["topic"]);
				$data[0]["title"] = mysql_fetch_assoc($res)["title"];
				unset($res);
				return $data;
			}
		}
	}
	


	public function forum_comments()
	{	$blackListForum = Get_functions::Get_black_list_forum();
		if(isset($_SESSION['people_id']) && $_POST["id"]){
			$res = mysql_query("SELECT f.*, DATE_FORMAT(f.date, '%H:%i %d.%m.%Y') as date_f, p.phone ,p.name, p.second_name, c.company_name, 
				(SELECT count(topic_id) FROM re_forum as f2 WHERE f2.comment_id = f.id AND f2.people_id NOT IN ({$blackListForum}) GROUP BY topic_id) as comment_count
				 FROM re_forum as f, re_people as p, re_company as c
				  WHERE f.comment_id={$_POST['id']} AND f.people_id = p.id AND p.company_id = c.id AND f.people_id NOT IN ({$blackListForum}) ORDER BY f.date");
			while($row = mysql_fetch_assoc($res)){
				$data[]=$row;
			}
			return $data;
		}
	}
	
	public function delete_from_forum()
	{
		if($_SESSION["admin"]==1 || $_POST["people_id"] ==  $_SESSION['people_id']){
			if($_POST["name"]=="title"){
				DB::Delete("re_forum_topic", "id=".$_POST["id"]);
				DB::Delete("re_forum", "topic_id=".$_POST["id"]);
			}else if($_POST["name"]=="text"){
				DB::Delete("re_forum", "id=".$_POST["id"]." OR comment_id=".$_POST["id"]);
			}
		}
	}
	
	public function recipients(){
		if(isset($_SESSION["people_id"])){
			$data = DB::Select("GROUP_CONCAT(DISTINCT text) as ids, id, address, DATE_FORMAT(DATE_ADD(date, INTERVAL -1 hour), '%d.%m.%Y %H:%i') as date",
					 "re_recipients_list", "people_id = ".$_SESSION['people_id']." GROUP BY address, DATE(date) ORDER BY date DESC");
			return $data;
		}
	}
	
	public function caution()
	{
		if(isset($_SESSION["people_id"])){
			$condition="";
			if(isset($_POST["phone"]) && isset($_POST["comment"]) && !isset($_POST["search"])){
				$column ="";
				$values ="";
				foreach($_POST as $k => $v){
					if($v!=""){
						$column.="`".$k."`, ";
						$values.="'".$v."', ";
					}
				}
				//handle_people_id
				$column.="`date`, owner_people_id";
				$values.="'".date("Y-m-d H:i:s")."', {$_SESSION['people_id']}";
				DB::Insert("re_caution", $column, $values);
				if($_POST["type"]==1){

				    $query = mysql_query("SELECT p.id FROM re_people as p, re_company as c WHERE p.company_id = c.id 
                                          AND p.phone='{$_POST["phone"]}' AND c.company_name='{$_POST["an"]}'");

					$people_id = mysql_fetch_assoc($query)['id'];
					if(isset($people_id)){
						DB::Update("re_people", "warning=1", "id={$people_id}");
					}
				}
				header("Location: http://". $_SERVER['SERVER_NAME']."/?task=profile&action=caution&type=".$_POST["type"]);
			}else if(isset($_POST["search"])){
				foreach($_POST as $k=>$v){
					if($v!="" && $k!="type" && $k!="search"){
						$condition.="`".$k."`='".$v."' AND ";
					}
				}
			}


			$condition.="type=".$_GET["type"];
			$condition.= Helper::FilterVal('handle_people_id') ? " AND handle_people_id='".Helper::FilterVal('handle_people_id')."'" : '';

			$data = DB::Select("*, DATE_FORMAT(DATE_ADD(date, INTERVAL -1 hour), '%H:%i:%s %d.%m.%Y') as date_time", "re_caution", $condition." ORDER BY date DESC");
			return $data;
		}
	}
	
	public function delete_caution()
	{
		if($_SESSION['admin']==1 && isset($_POST["id"])){
			$people_an = DB::Select("an, phone", "re_caution", "id={$_POST['id']}")[0];
			DB::Delete("re_caution", "id='".$_POST["id"]."'");
			$count = DB::Select("count(*) as c", "re_caution", "an='{$people_an['an']}' AND phone='{$people_an['phone']}'")[0]['c'];
			if($count == 0){
				$query = mysql_query("SELECT p.id FROM re_people as p, re_company as c WHERE p.company_id = c.id AND p.phone='{$people_an["phone"]}' AND c.company_name='{$people_an["an"]}'");
				$people_id = mysql_fetch_assoc($query)['id'];
				if(isset($people_id)){
					DB::Update("re_people", "warning=0", "id={$people_id}");
				}
			}
		}
	}
	
	public function lists()
	{
		if(isset($_SESSION['people_id'])){
			$data = [];
			$table= $_POST['list_type'] == 'white' || $_GET['type'] == 'white' ? "re_white_list" : "re_black_list";
			if($_POST['type']=='search' && (isset($_POST['phone']) || isset($_POST['an_id']))){
				$phone = isset($_POST['phone']) ? " p.phone like '%{$_POST['phone']}%' OR p.phone_addon like '%{$_POST['phone']}%' OR p.phone_archive like '%{$_POST['phone']}%'" : "";
				$company_id= isset($_POST['an_id']) ? " c.id={$_POST['an_id']} " : "";
				$data = DB::Select("p.id, p.name, p.second_name, p.phone, c.company_name as an", "re_people as p, re_company as c", "p.company_id=c.id AND ({$phone}".($phone!="" && $company_id!="" ? " OR " : "")."{$company_id})");
				return $data;
			}else if($_POST['type']=='add' && isset($_POST['id'])){				
				if(!ereg($_POST['id'].",", $_SESSION['in_black_list']) ){
					DB::Insert($table, "owner_people_id, people_id", "{$_SESSION['people_id']}, {$_POST['id']}");
					$_SESSION['in_black_list'].= $_POST['id'].",";
				}
				$table_delete = array(
					"re_white_list"=>"re_black_list",
					"re_black_list"=>"re_white_list"
				);
				DB::Delete($table_delete[$table], "owner_people_id='{$_SESSION['people_id']}' AND people_id='{$_POST['id']}'");
			}else if($_POST['type']=='delete'){				
				DB::Delete($table, "people_id={$_POST['id']} AND owner_people_id={$_SESSION['people_id']}");
			}else{
				$text = $table=="re_black_list" ? ", l.text" : "";
				$data = DB::Select("p.id, p.name, p.second_name, p.phone, c.company_name as an{$text}, l.show_var, l.show_forum", "re_people as p, re_company as c, {$table} as l", "p.company_id=c.id AND l.people_id=p.id AND l.owner_people_id={$_SESSION['people_id']}");
				
			}

			if($_POST['mess_view']=='show_var'){				
				$show = 1; if($_POST['show'] == 1) $show = 0;
				DB::Update($table, "show_var=".$show, "people_id={$_POST['id']} AND owner_people_id={$_SESSION['people_id']}");
			}
			if($_POST['mess_view']=='show_forum'){				
				$show = 1; if($_POST['show'] == 1) $show = 0;
				DB::Update($table, "show_forum=".$show, "people_id={$_POST['id']} AND owner_people_id={$_SESSION['people_id']}");
			}
			
			return $data;

		}
	}
	
	public function update()
	{
		if($_SESSION['parent']==0){
			DB::Update("re_{$_POST['name']}", "{$_POST['col']}={$_POST['value']}", "user_id={$_POST['id']}");
		}
	}

	public function updateById()
	{
		if($_SESSION['parent']==0){
			DB::Update("re_people LEFT JOIN re_user ON re_user.people_id = re_people.id",
                "rent_view = {$_POST['value']}",
                "re_user.user_id={$_POST['id']}");
		}
	}


	
	public function delete(){
		if($_POST['people_id']==$_SESSION['people_id'] || $_SESSION['admin']==1){
			if($_POST['name']=="review_parse"){
				$count = DB::Select("count(*) as c, parse_id", "re_review_parse", "parse_id=(SELECT parse_id FROM re_review_parse WHERE id={$_POST['id']})")[0];
				if(($count['c']-1)==0){
					DB::Update("re_parse", "review=0", "id={$count['parse_id']}");
				}
			}else if($_POST['name']=="review_pay_parse"){
				$count = DB::Select("count(*) as c, parse_id", "re_review_pay_parse", "parse_id=(SELECT parse_id FROM re_review_pay_parse WHERE id={$_POST['id']})")[0];
				if(($count['c']-1)==0){
					DB::Update("re_pay_parse", "review=0", "id={$count['parse_id']}");
				}
			}else if($_POST['name']=="review"){
				$count = DB::Select("count(*) as c, var_id", "re_review", "var_id=(SELECT var_id FROM re_review WHERE id={$_POST['id']})")[0];
				if(($count['c']-1)==0){
					DB::Update("re_var", "review=0", "id={$count['var_id']}");
				}
			}
			DB::Delete("re_{$_POST['name']}", "id={$_POST['id']}");
		}
	}

	public function coord_by_address()
    {
        echo Geocode::getCoordByAddress($_POST['live_point'], $_POST['street'], $_POST['house']);
	}

	public function find_on_phone(){

		if(isset($_SESSION['user'])){
			if($_POST['type']=="for_caution"){
				$data = DB::Select("p.name, p.second_name, c.company_name, p.id pid", "re_people as p, re_company as c", "p.company_id = c.id AND p.date_dismiss = '0000-00-00 00:00:00' AND (p.phone = '{$_POST['phone']}' OR p.phone_addon='{$_POST['phone']}')")[0];
				echo "{$data['name']};{$data['second_name']};{$data['company_name']};{$data['pid']}";
			}
		}
	}
	
	public function for_open_site(){
		if(isset($_SESSION['user']) && isset($_POST['val'])){
			DB::Update("re_user", "for_open_site={$_POST['val']}", "user_id={$_SESSION['user']}");
		}
		if($_POST['val']==2){
			$res = mysql_query("SELECT id FROM re_var WHERE user_id={$_SESSION['user']} AND photo=1");
			while($var = mysql_fetch_assoc($res)){
				DB::Insert("for_delete", "var_id", $var['id']);
			}
		}
	}
	
	public function session_update(){
		if(isset($_SESSION["start_time"]) && $_SESSION['admin']==0){
			$date = date("Y-m-d H:i:s");
			//DB::Delete("re_session", "DATE_ADD(date_start, INTERVAL +5 HOUR) < NOW()");
			$count = mysql_fetch_assoc(mysql_query("SELECT count(*) as count FROM re_session WHERE people_id = '{$_SESSION['people_id']}' AND name='".session_id()."'"))['count'];
			$ip = DB::Select("count(*) AS c", 
							"re_addresses", 
							"people_id={$_SESSION['people_id']} 
								AND 
							(
								(
									'{$_SERVER['REMOTE_ADDR']}' LIKE replace('0%', '0', ip) 
										AND 
									 ip!=''
								) 
									OR 
								ip='1'
							)
						")[0]['c'];
			if($count == 0 || $ip==0){
				DB::Delete("re_session", "people_id='{$_SESSION['people_id']}'");
				session_destroy();
				header('Location: http://'. $_SERVER['SERVER_NAME']);
			}else{
				$_SESSION["start_time"] = $date;
				DB::Update("re_session", "date_start = '{$date}'", "people_id = '{$_SESSION["people_id"]}'");
			}
			//echo $date;
			unset($date, $ses_date);
		}else if(!isset($_SESSION["start_time"])){
			header('Location: http://'.$_SERVER['SERVER_NAME']);
		}
	}
	
	public function group_setting(){
		if(isset($_SESSION['people_id'])){
			$group_list = Get_functions::Get_black_group_list($_SESSION['fio']);
			$group_list_arr = explode('||', $group_list['black_group']);
			$count = count($group_list_arr);
			$condition = "";
			for($i=0; $i<$count; $i++){
				if($group_list_arr[$i] != ""){
					$condition .= "CONCAT_WS(' ', surname, name, second_name)='".$group_list_arr[$i]."' OR ";
				}
			}
			$peoples = "";
			if($condition != ""){
				$condition = substr($condition, 0, -3);
				$column = "`company_name`, `surname`, `name`, `second_name`, `phone`";
				$table = "`re_people` INNER JOIN re_company ON re_company.id = re_people.company_id";
				$data = DB::Select($column, $table, $condition);
			}
			return $data;
		}
	}


	public function sample(){
		if(isset($_SESSION["people_id"])){
			$data = DB::Select("*", "re_sample", "people_id = ".$_SESSION['people_id']." ORDER BY modified DESC");
			return $data;
		}
	}


	public function add_sample()
	{
		if(Helper::Post_filters('name')){
			$samples = Helper::Save_sample();
			$search_count = count($samples);
			$samplesBalance = DB::Select('samples_balance', 're_people',"id = {$_SESSION['people_id']}");
			if($search_count >= $samplesBalance[0]['samples_balance']) {
				echo "too_much";
				return null;
			}
			$length = 6;
			$chartypes = "lower,numbers";
			$link = Helper::random_string($length, $chartypes)."_".Helper::random_string($length, $chartypes);
            $actionTYpe = 'buysell';

			if(DB::Insert("re_sample", "sample_name, people_id, external_link, action_type, created, modified", "'{$_POST['name']}', '{$_SESSION['people_id']}', '{$link}', '{$actionTYpe}',  NOW(), NOW()")){
				echo DB::Select("id", "re_sample", 
					"people_id = ".$_SESSION['people_id'] ." AND `external_link` = '{$link}'" )[0]['id'];
			}else{
				echo 0;
			}
		}
	}

	public function delete_sample()
	{
		if($_POST['id']){			
			if(DB::Delete('re_sample', "id = {$_POST['id']}") == 1){
				DB::Delete('re_sample_var', "sample_id = {$_POST['id']}");
				echo 1;
			}else{
				echo 0;
			}
		}
	}

	public function clear_sample()
	{
		if($_POST['id']){
		    try{
                DB::Update('re_sample', " sample_vars = '' ", "id = {$_POST['id']}", true);
                DB::Delete('re_sample_var', "sample_id = {$_POST['id']}",true);
            }catch(Exception $e){
                return 0;
            }
			echo 1;
		}
        return 0;
	}

	public function sample_add_var()
	{
		if(empty($_POST['var_id']) ||  empty($_POST['sample_id']) ) return null;
		$varId = $_POST['var_id'];
		$sampleId = $_POST['sample_id'];
		$type = 'ag';
		$text = '';
		$clientPrice = '';

        if(!empty($_POST['client_price']) ){
            $clientPrice = $_POST['client_price'];
        }

        if(!empty($_POST['text']) ){
            $text = $_POST['text'];
        }

		if(!empty($_POST['type']) ){ 
			$type = $_POST['type'];
		}
		$sampleVars = DB::Select('*', 're_sample_var', "sample_id = {$sampleId}");
		$sampleVarExists = DB::Select('id','re_sample_var', "sample_id = {$sampleId} AND var_id = {$varId}");

		if(!empty($sampleVarExists))
		{
			echo 2;	
		}elseif( count($sampleVars) > 50){
			echo 3;	
		}else{
			$query_sample_var =  DB::Insert('re_sample_var','sample_id, var_id, type, description, `created`, `client_price`',
					"'{$_POST['sample_id']}', '{$_POST['var_id']}', '{$type}', '{$text}', NOW() , '{$clientPrice}' ");

			if(!empty($query_sample_var)){
			//	Helper::linkImagesExternalCreate($_POST['var_id'], $type);
				echo 1;
			}else{
				echo 0;
			}	
		}
	}

	public function sample_delete_var()
	{
		if(empty($_POST['var_id']) ||  empty($_POST['sample_id']) ) return null;
		$delResult = Helper::deleteSampleVar($_POST['sample_id'], $_POST['var_id']);
		if(!empty($delResult)){
			Helper::linkImagesExternalRemove($_POST['var_id']);
			echo 1;
		}else{
			echo 0;
		}		
	}

	public function forum_rent_add()
	{
		/*if($_GET["new"]=="text" && isset($_POST["text"])){
			$newRentMess = DB::Insert("re_forum", 
				"topic_id, people_id, text, date", 
				"'".$_GET["topic"]."', '".$_SESSION["people_id"]."', '".$_POST["text"]."', NOW()");
			DB::Update("re_forum_topic", "date=NOW()", "id=".$_GET["topic"]);

			if($_GET["topic"] == 12){
				if($newRentMess == 1){
					Helper::createRentMessages($_SESSION["people_id"], $_POST["text"]);
					header("Location: http://". $_SERVER['SERVER_NAME']."/?task=profile&action=forum_rent&topic={$_GET["topic"]}");
				}
				//header("Location: http://". $_SERVER['SERVER_NAME']."/?task=profile&action=forum_rent&topic=".$_GET["topic"]."&newmess=9".$newRentMess."9");

			}else{
				header("Location: http://". $_SERVER['SERVER_NAME']."/?task=profile&action=forum&topic=".$_GET["topic"]);
			}
		}
		/**/
	}

}
