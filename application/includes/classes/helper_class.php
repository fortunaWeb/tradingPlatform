<?
Class Helper
{

	static function getVarById($table, $var_id)
    {
        if (empty($table) || empty($var_id)) {
            return [];
        }
        return DB::Select('*', $table, " `id` = {$var_id} LIMIT 1");
    }

    public static function isDirector()
	{
		return $_SESSION["parent"] == 0;
	}

    static function getActionVarsCoords($parentId)
	{
		return DB::Select('id, coords',
            're_var',
            "active = 1 AND parent_id = {$parentId}"
        );
	}

	static function isMobileExists($people_id)
	{
		$access = DB::Select('id', 
							're_addresses', 
							"people_id = '{$people_id}' AND 
							active = 1 AND 
							archive = 0  AND
							mob = 1 LIMIT 1");
		if(!empty($access[0])){
			return true;
		}
		return false;
	}

	static function checkReviewOwner($var_id)
	{
		$review = DB::Select('id',
			're_review_pay_parse',
			"parse_id = {$var_id} AND people_id = {$_SESSION['people_id']} ");

		return !empty($review);

	}

	static function  linkImagesExternalRemove($var_id)
	{

		/*$sample = DB::Select("vars.type, sample.people_id", "re_sample as sample
								INNER JOIN re_sample_var as vars on  vars.sample_id = sample.id",
								 " vars.id = {$var_id} AND sample.people_id == {$_SESSION['people_id']}" )[0];
		if(empty($sample))
			return  null;
		$external = "/var/www/arendanovosib/images";
		if($sample['type'] == 'ag') $dir = $sample['people_id'].'/'
		shell_exec("rm -rf " .$external."/".$photos[0]['people_id']."/".$photos[0]['var_id'] ." " );*/
	}

	static function SamplePhotoCreateDir($dir, $var_id){
		if (file_exists( $dir)) {
			@mkdir($dir .'/'. $var_id, 0777);
		} else {
			@mkdir($dir, 0777);
			@mkdir($dir .'/'. $var_id, 0777);
		}

	}

	static function getFilesFromDir($dir, $pattern)
	{
		$files = [];
		$handle = opendir($dir);
			 while ($entry = readdir($handle)) {
		        if (preg_match($pattern, $entry)) {
		            $files[] = $entry;
		        }
		    }
		    closedir($handle);
		  return $files;
	}

	static function  linkImagesExternalCreate($var_id, $type)
	{
		$sourse = $_SERVER['DOCUMENT_ROOT'];
		$external = "/var/www/arendanovosib";
		if($type == 'ag'){			
			$dir = DB::Select('people_id', 're_photos', "var_id = {$var_id}")[0]['people_id'];
		}else if($type == 'pri'){
			$dir = 'parse';
		}else{
			return null;
		}
		$photos = self::getFilesFromDir($sourse .'images/'.$dir."/".$var_id,'/\.jpg$/');
		if(empty($photos))
			return  null;
		Helper::SamplePhotoCreateDir($external .'/images/'.$dir, $var_id);
		foreach ($photos as $key => $photo) {
			$photoFile = "/"."images"."/".$dir."/".$var_id."/".$photo;	
			if(file_exists($sourse.$photoFile) ){
				@shell_exec("ln -s ".$sourse.$photoFile . " " . $external.$photoFile ." " );	
			}			
		}

	}

    static public function log($data)
    {
		$type =  gettype($data);
		if($type== 'string' || $type == 'integer'){
            file_put_contents("/var/www/buysell/logs/userlog", $data . PHP_EOL, FILE_APPEND);
		}else{
            $log = date('Y-m-d H:i:s') . ' ' . print_r($data, true);
            file_put_contents("/var/www/buysell/logs/userlog", $log . PHP_EOL, FILE_APPEND);
        }
    }


    static function show9826($data){

		if( $_SESSION['login'] == 8197|| $_SESSION['login'] == 'admin' )
		{	$type =  gettype($data);
			$types = [
				'array' ,
				'string',
				'integer'
			];
			if($type== 'string' || $type == 'integer'){
				echo $type ." (". strlen($data) .")";
				echo "<br/><br/><br/>";
				echo "|||>". $data ."<|||";
				echo "<br/><br/>";
			}else{
				echo $type ." (". count($data) .")";
				echo "\n\n<br/><br/><br/>||||| >>";
				print_r($data);
				echo "\n\n<< |||||<br/><br/>";
			}
		}
	}

   public static function buildtree($in,$pre="array")
   {
   		$result = '';
        if(is_array($in)){
            foreach($in as $key=>$value){
                self::buildtree($value,$pre.'-'.$key);
            };
        }
        else{
            $result .= $pre.':'.$in."\n\r";
        };
        return $result;
    }

	static public function showArray9826($array)
	{
		$result = '';
        foreach($array as $key => $value)
        {
             $result = "[{$key}] = {$value} \n\r";
		}
		return $result;
	}

	static function isPayParseAccertable($link){
		return (
			preg_match('/avito\.ru/', $link) || preg_match('/ngs\.ru/', $link) 
			);

	}
	static function isPayParseAccertableBuysell($link){
		return true;

	}

	static function sendWhatsapp($myType, $topicId )
	{
		$mobAccess =  DB::Select('mob', "re_addresses",  "mob = 1 AND people_id = {$_SESSION['people_id']}");
		if(isset($mobAccess[0]) && ($myType == 'mytype'  || ($mobAccess[0]['mob'] == 1 && $topicId == 1) ) ){
			return true;
		}
		return false;
	}


	static function showMessagerId($company_id)
	{
		$mesages =  DB::Select('mesenger_id', "re_people",  "company_id = {$company_id}");
		$messIds = '';
		foreach ($mesages as  $mesage)
			if($mesage['mesenger_id'] != 0)
				$messIds .= $mesage['mesenger_id']." ";
		return $messIds;
	}

	static function checkProlongExists($user_id)
	{
		$exists = DB::Select('prolong_garant_no_exists', 
			"re_company
			INNER JOIN re_people on re_people.company_id = re_company.id
			INNER JOIN re_user on re_user.people_id = re_people.id",  
			"re_user.user_id = {$user_id}");
		return  ($exists[0]['prolong_garant_no_exists'] != 1);
	}

	static function varProlongAcess($id)
	{
		$prolongAcess = DB::Select('COUNT(`id`) as cnt', "`re_var`",  
			"`id` = {$id} AND DATE_ADD(date_last_edit, INTERVAL 1 HOUR) <= NOW()");
		return $prolongAcess[0]['cnt'];


	}

	static function company_pay_data($company_id){
			$subscription = mysql_fetch_assoc(mysql_query("SELECT subscription from re_company where id = '".$_SESSION['company_id']."'"))['subscription'];
			$balance = mysql_fetch_assoc(mysql_query("SELECT balance from re_company where id = '".$_SESSION['company_id']."'"))['balance'];
			$sell_date_end = mysql_fetch_assoc(mysql_query("SELECT sell_date_end from re_access_date_end where id = '".$_SESSION['company_id']."'"))['sell_date_end'];
			$sell_date_end = mysql_fetch_assoc(mysql_query("SELECT sell_date_end from re_access_date_end where id = '".$_SESSION['company_id']."'"))['sell_date_end'];
	}

	static function checkAccessByDate($accessType)
	{
        switch ($accessType) {
            case 'parse':
                $column = "sell_date_end";
                break;
            case 'sell':
                $column = "sell_date_end";
                break;
            default:
                $column = "sell_date_end";
                break;
        }
        return $_SESSION[$column] > (new DateTime())->format('Y-m-d');
	}

	static function check_access_date(){
		$now = new DateTime();
		$url = explode('&', $_SERVER['REQUEST_URI']);
		$controller = explode('=', $url[0])[1];
		$action = explode('=', $url[1])[1];

		if(isset($_SESSION['sell_date_end']) && $_SESSION['sell_date_end'] <= $now->format('Y-m-d')){
			if($controller=='profile' && ($action == 'order' || $action == 'order_txt' || $action == "services" || $action == "services_pay")  ){
				if($action == "services" || $action == "services_pay"){
                    return true;
				}
			}else if($controller=='buysell' || $controller=='var'){
				if(isset($_SESSION['sell_date_end']) && $_SESSION['sell_date_end'] < $now->format('Y-m-d')){
					if($action == 'photo_list'){
						return true;
					}
					header("Location: http://". $_SERVER['SERVER_NAME'].'/?task=profile&action=services');
				}
				return true;
			}else{
				header("Location: http://". $_SERVER['SERVER_NAME'].'/?task=profile&action=services');
			}
		}
		return true;
	}

	static function Address($address) {				
		for($i=0; $i<count($address); $i++){
			echo "<br />
			<div class='input-group interval xxl'>
				<span class='input-group-addon'>IP</span>
				<input type='text' class='form-control' value='".($address[$i]['ip'] == '1' ? "Любой" : $address[$i]['ip'])."' disabled>
			</div>
			<div class='input-group interval xxl'>
				<input type='text' class='form-control' placeholder='улица' value='".$address[$i]['street']."' disabled>
				<input type='text' class='form-control' placeholder='номер дома' value='".$address[$i]['house']."' disabled>
				<input type='text' class='form-control' placeholder='номер офиса' value='".$address[$i]['office']."' disabled>
			</div>
			<textarea type='text' class='form-control' placeholder='дополнение' disabled>".$address[$i]['comment']."</textarea>";
		}
	}

	static function filterSampleVarsByActual($sampleId)
	{
		$now = new DateTime();
        $vars = DB::Select(
        	'var.id, user.user_id, access.sell_date_end',
            're_sample_var as sample
		   				INNER JOIN `re_var` as var ON sample.var_id = var.id  
		   				INNER JOIN re_user as user ON var.user_id = user.user_id 
		   				INNER JOIN re_people as people  ON user.people_id = people.id
		   				INNER JOIN re_company as company ON people.company_id = company.id
		   				INNER JOIN re_access_date_end as access ON access.company_id = company.id
				',
            "sample.sample_id = {$sampleId} AND type = 'ag'");

        foreach ($vars as $var){
        	if((new DateTime($var['sell_date_end']))->format('Y-m-d') < $now->format('Y-m-d') ){
                DB::Delete('re_sample_var', "var_id = {$var['id']}");
			}
		}
    }

	static public function checkUserAccess($userId)
	{
		$now = new DateTime();
		$tables = "    `re_user  as user
			INNER JOIN `re_people` as people ON user.people_id = people.id
			INNER JOIN `re_company` as company ON people.company_id = company.id
			INNER JOIN re_access_date_end as access as access.company_id = company.id			
			";
		$userAccess = DB::Select('access.sell_date_end', $tables, "user.user_id = {$userId}");
		return ($now->format('Y-m-d') < (new DateTime($userAccess['sell_date_end']))->format('Y-m-d') );
	}

	static function Cost_for_user($j, $ip_rent, $ip_sell){
		$cost = $j*100 + (count(explode ("||",$ip_rent)) - 1)*400;
		$return_str = $cost == '0' ? 'бесплатный аккаунт' : $cost." р.";
		return $return_str;
	}
	
	static function Modal_win_change_user($data, $j){
		$address_rent = Get_functions::Get_address_by_people_id($data[$j]['people_id'], 'rent');	
		$num = count($address_rent);
		$rent_addressess = $num > 0 ? "<legend style='height:30px;'><div class='input-group interval xl left'>
								<span class='input-group-addon'>Доступ к аренде до</span><input type='text' name='sell_date_end' class='form-control' data-id='date' value='".date("Y-m-d",strtotime($data[$j]['sell_date_end']))."'></div><div class='input-group interval left'>
								<span class='input-group-addon'>Премиумы</span><input type='text' name='rent_premium' class='form-control' title='премиумы аренды' placeholder='премиумы аренды' value='".$data[$j]['rent_premium']."'></div><div class='input-group interval left'><span class='input-group-addon'>Переплата</span><input type='text' name='rent_premium' class='form-control' title='премиумы аренды' placeholder='премиумы аренды' value='".$data[$j]['balance']."'></div><div class='input-group interval left'><span class='input-group-addon'>Долг</span><input type='text' name='rent_premium' class='form-control' title='премиумы аренды' placeholder='премиумы аренды' value='".$data[$j]['duty']."'></div><div class='input-group interval left'><span class='input-group-addon'>Абонентка</span><input type='text' name='rent_premium' class='form-control' title='премиумы аренды' placeholder='премиумы аренды' value='".$data[$j]['subscription']."'></div></legend>" : "";
		for($i=0; $i<$num; $i++){
			$checked = $address_rent[$i]['active'] == 1 ? 'checked' : '';
			$rent_addressess .= 
			"<div style='margin: 20 0px;'><input type='text' name='ip_rent".$address_rent[$i]['id']."' class='form-control' title='ip' placeholder='ip' value='".$address_rent[$i]['ip']."'>
			<div class='checkbox' style='margin-left:20px'>
				<label>
				  <input type='checkbox' name='active_rent".$address_rent[$i]['id']."' ".$checked."> Активный
				</label>
			</div>
			<br />
			<input type='text' name='street_rent".$address_rent[$i]['id']."' class='form-control' title='улица' placeholder='улица' value='".$address_rent[$i]['street']."'>
			<input type='text' name='house_rent".$address_rent[$i]['id']."' class='form-control' title='дом' placeholder='дом' value='".$address_rent[$i]['house']."'>
			<input type='text' name='office_rent".$address_rent[$i]['id']."' class='form-control' title='офис' placeholder='офис' value='".$address_rent[$i]['office']."'><div style='height:20px'></div>			
			<textarea rows='4' cols='50' name='comment_rent".$address_rent[$i]['id']."' class='form-control' title='комментарий' placeholder='комментарий'>".$address_rent[$i]['comment']."</textarea></div>";
		}
		$address_sell = Get_functions::Get_address_by_people_id($data[$j]['people_id'], 'sell');
		$num = count($address_sell);
		$sell_addressess = $num > 0 ? "<legend><div class='input-group interval xl left'>
								<span class='input-group-addon'>Доступ к продаже до</span><input type='text' name='sell_date_end' class='form-control' value='".date("Y-m-d",strtotime($data[$j]['sell_date_end']))."'></div><div class='input-group interval left'>
								<span class='input-group-addon'>Премиумы</span><input type='text' name='sell_premium' class='form-control' title='премиумы продажи' placeholder='премиумы продажи' value='".$data[$j]['sell_premium']."'></div></legend>" : "";		
		for($i=0; $i<$num; $i++){
			$checked = $address_sell[$i]['active'] == 1 ? 'checked' : '';
			$sell_addressess .= 
			"<input type='text' name='ip_sell".$address_sell[$i]['id']."' class='form-control' title='ip' placeholder='ip' value='".$address_sell[$i]['ip']."'>
			<div class='checkbox' style='margin-left:20px'>
				<label>
				  <input type='checkbox' name='active_sell".$address_sell[$i]['id']."' ".$checked."> Активный
				</label>
			</div>
			<br />
			<input type='text' name='street_sell".$address_sell[$i]['id']."' class='form-control' title='улица' placeholder='улица' value='".$address_sell[$i]['street']."'>
			<input type='text' name='house_sell".$address_sell[$i]['id']."' class='form-control' title='дом' placeholder='дом' value='".$address_sell[$i]['house']."'>
			<input type='text' name='office_sell".$address_sell[$i]['id']."' class='form-control' title='офис' placeholder='офис' value='".$address_sell[$i]['office']."'><div style='height:20px'></div>
			<textarea rows='4' cols='50' name='comment_sell".$address_sell[$i]['id']."' class='form-control' title='комментарий' placeholder='комментарий'>".$address_sell[$i]['comment']."</textarea>";
		}		
		$modal =
		"<div class='modal fade' id='modal-win' tabindex='-1' role='dialog' aria-hidden='true'>
		  <div class='modal-dialog'>
			<div class='modal-content'>
			  <div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title'>Изменение пользователя id (".$data[$j]['user_id'].")</h4>
			  </div>
			  <form class='form-inline'>				
				  <div class='modal-body'>							
					<legend>Данные авторизации<label class='right'>".$data[$j]['date_company_reg']."</label></legend>					
					<div class='row'>
						<div class='col-xs-5 deployed'>	
							<div class='input-group interval xxl'>
								<span class='input-group-addon'>А.Н.</span>
								<input type='text' name='company_name' class='form-control' title='ан' placeholder='ан' value='".$data[$j]['company_name']."' style='min-width: 300px;'>
							</div>		
						</div>
						<div class='col-xs-3 deployed'>	
							<div class='input-group interval xxl'>
								<span class='input-group-addon'>Логин</span>
								<input type='text' name='login' class='form-control' title='логин' placeholder='логин' value='".$data[$j]['login']."'>
							</div>		
						</div>	
						<div class='col-xs-3 deployed'>	
							<div class='input-group interval xxl'>
								<span class='input-group-addon'>Пароль</span>
								<input type='text' name= 'password' class='form-control' title='пароль' placeholder='пароль' value='".$data[$j]['password']."'>
							</div>		
						</div>	
					</div>	
					<div style='height: 20px;'></div>
					
					<legend>Личные данные</legend>
					<input type='text' name='surname' class='form-control' title='фамилия' placeholder='фамилия' value='".$data[$j]['surname']."'>
					<input type='text' name='name' class='form-control' placeholder='имя' title='имя' value='".$data[$j]['name']."'>					
					<input type='text' name='second_name' class='form-control' title='отчество' placeholder='отчество' value='".$data[$j]['second_name']."'>
					<br />
					<input type='text' data-id='phone' name='phone' class='form-control' title='телефон' placeholder='телефон' value='".$data[$j]['phone']."'>
					<input type='text' name='email' class='form-control' title='e-mail' placeholder='e-mail' value='".$data[$j]['email']."'>
					<input type='text' name='nickname' class='form-control' title='nickname' placeholder='nickname' value='".$data[$j]['nickname']."'>
					<textarea rows='3' cols='30' id='phone' name='phone_addon' class='form-control' title='доп.телефоны' placeholder='доп.телефоны' style='position: absolute; margin: -35px 0px 0px;'>".$data[$j]['phone_addon']."</textarea>					
					<div style='height: 20px;'></div>
					<textarea rows='4' cols='70' id='phone' name='comment' class='form-control' title='доп.телефоны' placeholder='коментарии с фортуны'>".$data[$j]['comment']."</textarea>
					<div style='height: 20px;'></div>					
					
					".$rent_addressess."
					<div style='height: 20px;'></div>
					
					".$sell_addressess."					
				  </div>
				  <input type='hidden' name='user_id' value='".$data[$j]['user_id']."'>
				  <div class='modal-footer'>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Отмена</button>
					<button type='button' class='btn btn-primary' onclick='formSubmit()'>Сохранить</button>
				  </div>
				</form> 
			</div>
		  </div>
		</div>";
		return $modal;
	}

	static function Modal_win_find_address()
	{
        /**
         *
        "<button type='button' data-id='toggleMap' class='btn btn-success left'>2 ГИС(в разработке...)</button>";
         */
		$modal =
		"<div class='modal fade' id='modal-win' tabindex='-1' role='dialog' aria-hidden='true'>
		  <div class='modal-dialog' style='width: 90%;'>
			<div class='modal-content'>
			  <div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title'>Поиск адреса. Укажите место.</h4>
			  </div>
			  <form class='form-inline'>				
				  <div class='modal-body'>							
						 <div id='map' style='width: 100%; height: 400px'></div>						 
				  </div>				  
				  <div class='modal-footer'>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Отмена</button>
					<button type='button' class='btn btn-primary' onclick='formSubmit()'>Сохранить</button>
				  </div>
				</form> 
			</div>
		  </div>
		</div>";
		return $modal;
	}

	static function Modal_win_clean(){
		//$del_button = $_GET['action']=='mytype' && $_GET['active']=='0' ? "<button type='button' onclick='ArchiveDeleteReview' class='btn btn-danger'>Удалить отзыв</button>" : "";
		$modal =
		"<div class='modal fade' id='clean-modal-win' tabindex='-1' role='dialog' aria-hidden='true'>
		  <div class='modal-dialog' style='width: 90%; max-width:700px'>
			<div class='modal-content'>
			  <div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title'></h4>
			  </div>
			  <form class='form-inline'>				
				  <div class='modal-body'></div>				  
				  <div class='modal-footer'>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Отмена</button>
					<button type='button' class='btn btn-primary'>Отправить</button>
				  </div>
				</form> 
			</div>
		  </div>
		</div>";
		return $modal;
	}

	static function Modal_win_send_sample(){
		$modal =
		"<div class='modal fade' id='send-sample-modal-win' tabindex='-1' role='dialog' aria-hidden='true'>
		  <div class='modal-dialog' style='width: 90%; max-width:700px'>
			<div class='modal-content'>
			  <div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title'>Описание варианта для подборки</h4>
			  </div>
			  <form class='form-inline' id='send-sample'>				
				  <div class='modal-body'>
					<p><textarea name='sample_text' class='form-control' placeholder='Описание' rows='5' cols='80'></textarea></p>
					<p><input name='sample_client_price' class='form-control' placeholder='Цена для клиента' value='' ></p>
				  </div>				  
				  <div class='modal-footer'>
						<button type='button' class='btn btn-primary-emply'>Отправить без описания</button>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Отмена</button>
					<button type='button' class='btn btn-primary'>Отправить</button>
				  </div>
				</form> 
			</div>
		  </div>
		</div>";
		return $modal;
	}

	static function Modal_win_send_review(){
		$modal =
		"<div class='modal fade' id='send-review-modal-win' tabindex='-1' role='dialog' aria-hidden='true'>
		  <div class='modal-dialog' style='width: 90%; max-width:700px'>
			<div class='modal-content'>
			  <div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title'>Отзыв о сообщении</h4>
			  </div>
			  <form class='form-inline' id='send-review'>				
				  <div class='modal-body'>
					<p><textarea name='text' class='form-control' placeholder='содержание отзыва' rows='5' cols='80'></textarea></p>
				  </div>
				  <div class='checkbox'>
						<label>
							<input type='checkbox' id='anonymous' name='anonymous' value='1'>Если хотите ,чтобы ваш комментарий увидел только администратор поставьте галочку
						</label>
					</div>
				  <div class='modal-footer'>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Отмена</button>
					<button type='button' class='btn btn-primary'>Отправить</button>
				  </div>
				</form> 
			</div>
		  </div>
		</div>";
		return $modal;
	}

	static function Modal_win_add_to_black_list(){
		$modal =
		"<div class='modal fade' id='add-to-black-list-modal-win' tabindex='-1' role='dialog' aria-hidden='true'>
		  <div class='modal-dialog' style='width: 90%; max-width:700px'>
			<div class='modal-content'>
			  <div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title'>Добавление риелтера в черный список</h4>
			  </div>
			  <form class='form-inline' id='add-to-black-list'>				
				  <div class='modal-body'>
					<p><textarea name='text' class='form-control' placeholder='причина добавления в черный список' rows='5' cols='80'></textarea></p>					
				  </div>				  
				  <div class='modal-footer'>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Отмена</button>
					<button type='button' class='btn btn-primary'>Отправить</button>
				  </div>
				</form> 
			</div>
		  </div>
		</div>";
		return $modal;
	}

	static function Modal_win_messages(){
		$modal =
		"<div class='modal fade' id='messages-modal-win' tabindex='-1' role='dialog' aria-hidden='true'>
		  <div class='modal-dialog' style='width: 90%; max-width:700px'>
			<div class='modal-content'>
			  <div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title'>Переписка</h4>
			  </div>
				<div class='modal-body'>
					<div class='messages_list'></div>
					<p><textarea name='text' class='form-control' placeholder='ответ' rows='5' cols='80'></textarea></p>					
				</div>				  
				<div class='modal-footer'>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Отмена</button>
					<button type='button' class='btn btn-primary'>Отправить</button>
				</div>
			</div>
		  </div>
		</div>";
		return $modal;
	}

	static function Modal_win_group_setting(){
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
			//$condition = "CONCAT_WS(' ', surname, name, second_name)='".$_SESSION['fio']."'";
			$people_list = DB::Select($column, $table, $condition);
			for($i = 0; $i<count($people_list); $i++){
				$fio = $people_list[$i]['surname']." ".$people_list[$i]['name']." ".$people_list[$i]['second_name'];
				$checked = (!ereg($fio, $group_list['black_group'])) ? "checked" : "";
				$peoples.=	"<tr>
								  <td>".$people_list[$i]['company_name']."</td>
								  <td>".$people_list[$i]['name']." ".$people_list[$i]['second_name']."</td>
								  <td>".$people_list[$i]['phone']."</td>
								  <td><input type='checkbox' value='".$fio."' ". $checked ."></td>
							</tr>";
			}
		}
		unset($group_list, $group_list_arr, $count, $condition, $table, $column, $people_list);

		if($_SESSION['mobile']){
			$colXs = 7;
			$br = "<br/>";
		}else{
			$colXs = 4;
			$br = "";
		}
		$modal =
		"<div class='modal fade' id='modal-win-group' tabindex='-1' role='dialog' aria-hidden='true'>
		  <div class='modal-dialog' style='width: 90%;'>
			<div class='modal-content'>
			  <div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title'>Настройка своей группы. <span class='right'>В мою группу входят все кроме исключенных из нее</span></h4>
			  </div>
							{$br}
							{$br}
			  <form class='form-inline' id='group_setting'>				
				  <div class='modal-body'>	
						<div class='row info' style='margin:0'>
							<h4>Исключить из моей группы</h4>
							<hr>
							<div class='col-xs-{$colXs}'>
								<label class='signature'>Телефон риелтера</label>
								<input type='text' class='form-control' data-id='phone' onkeyup='SearchRieleter($(this).val())'>								
							</div>
							{$br}
							{$br}
							<div class='col-xs-{$colXs}'>	
								<label class='signature'>Название АН</label>
								<input type='text' class='form-control' data-name='an-list' placeholder='агентство' value=''>
								<div class='an_list' style='display: none;overflow: auto; height: 250px;'></div>
								<input type='hidden' name='company_id' value=''>		
							</div>
							<div class='col-xs-12'>
								<table class='table table-striped' data-id='seacrh-rielter'>
									<thead>
										<tr><th>Агентство</th><th>Имя</th><th>Телефон</th><th></th></tr>
									</thead>
									<tbody>		
									</tbody>
								</table>
							</div>
						</div>
						<div class='col-xs-12' style='font-size:17px; margin-top:25px'>Список риелтеров, которые не входят в мою группу и не видят мои варианты</div>
						<table class='table table-striped' data-id='black-group'>
							<thead>
								<tr><th>Агентство</th><th>Имя</th><th>Телефон</th><th>Амнистировать</th></tr>
							</thead>
							<tbody>			
								".$peoples."
							</tbody>
						</table>
				  </div>				  
				  <div class='modal-footer'>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Отмена</button>
					<button type='button' class='btn btn-primary' onclick='formSubmit(\"group_setting\");'>Сохранить</button>
				  </div>
				</form> 
			</div>
		  </div>
		</div>";
		unset($people);
		return $modal;
	}

	static function unsetVarPhoto($var_id)
	{
		if(!empty($var_id)){
			DB::Update("re_var", "photo = 0", "id = {$var_id}");
		}

	}

	static function Post_filters($condition)
	{
		$r=0;/*счетчики повторов*/
		$p=0;
		$d=0;
		$s=0;
		$sq=0;
		$t=0;
		$type_id="";
		foreach($_POST as $k => $v){
			if(!ereg("Выбрано", $v) && !ereg("не важно", $v) && $k != "search_user_id" && $k != "view_type" && $k!="without_cont" && $k!="order" && $k!="residents" && $k!="task" && $k!="action"){
				if (ereg('room_count', $k) && $r==0 && $v!=""){
					if($_SESSION['search_user_id'] == "site"){
						if($_POST["parent_id"] != 18){$condition.=" AND (`room_count`='".$v."'";}
						else{$condition.=" AND `room_count`<='".$v."'";}
					}else{$condition.=" AND (`type_id`='".($v + 18)."'";}
					$r++;
				}else if(ereg('room_count', $k) && $v != ""){
					if($_SESSION['search_user_id'] == "site"){
						$condition.=" OR `room_count`='".$v."'";}
					else{$condition.=" OR `type_id`='".($v + 18)."'";}
					$r++;
				}else if(ereg('planning', $k)){
					if ($r > 0){$condition.=")"; $r = 0;}
					if($v!="")$condition.=" AND `{$k}`='{$v}'";
				}else if(ereg('price', $k) && $p==0){
					if ($r > 0){$condition.=")"; $r = 0;}
					if ($v != ""){
						$condition.=" AND (`price` BETWEEN ".preg_replace("/(&nbsp;)|(\s)|( )/", '', $v);$p++;
					}else{$condition.=" AND (`price` BETWEEN 0"; $p++;}
				}else if(ereg('price', $k)){
					if($v!=""){
						$condition.=" AND ".preg_replace("/(&nbsp;)|(\s)|( )/", '', $v).")";
					}else{$condition.=" AND 999999999)";}
				}else if(ereg('dis', $k) && $d==0){
					if($v!=""){$condition.=" AND (`dis`='".$v."'"; $d++;}
				}else if(ereg('dis', $k)){
					if($v!=""){$condition.=" OR `dis`='".$v."'";}
				}else if(ereg('street', $k) && $s==0){
					if($d != 0){$condition.=")";$d=0;}
					if($v!=""){$condition.=" AND (`street`='".$v."'"; $s++;}
				}else if(ereg('street', $k)){
					if($v!=""){$condition.=" OR `street`='".$v."'";}
				}else if(ereg('house', $k)){
					if($s != 0){$condition.=")";$s=0;}
					if($v != ""){$condition.=" AND `".$k."`='".$v."'";}
				}else if(ereg('from', $k) && $sq==0){
					$k = preg_replace("/from/", '', $k);
					if($v!=""){
						$condition.=" AND (`".$k."` BETWEEN ".$v."";
						$sq++;
					}else{$condition.=" AND (`".$k."` BETWEEN 0"; $sq++;}
				}else if(ereg('to', $k) && $sq>0){
					if($v!=""){
						$condition.=" AND '".$v."')";
						$sq=0;
					}else{$condition.=" AND 99999999)"; $sq=0;}
				}else if($k == "parent_id" && $v == "18" && $_SESSION['search_user_id'] == "ngs"){
					$condition.=" AND type_id=18";
				}else if($k == "live_point" && $v=="НСО"){
					$condition.=" AND `live_point` != 'Новосибирск'";
				}else if($k=="to_metro" && $v!=""){
					$condition.=" AND `distance_to_metro` > 0 AND coords!='55.030199,82.92043' AND `distance_to_metro` < ".$v;
				}else if(ereg('type_id', $k) && $v!=""){
					if($t==0){$type_id.="type_id={$v}"; $t++;}
					else{$type_id.="||{$v}"; $t++;}
				}else if($k=="company_id" && $v != ""){
					$condition.=" AND re_people.company_id='".$v."'";
				}else{
					if ($v != ""){$condition.=" AND `".$k."`='".$v."'";}
				}
			}else if($k=="residents"){
				$residents = explode("||", $v);
				foreach($residents as $resident){
					if($resident!=""){
						$condition.=" AND residents like '%".$resident."%'";
					}
				}
			}
		}
		if($t>0){
			$condition.= " AND (".(str_replace("||", " OR type_id=", $type_id)).")";
		}
		return $condition;
	}

	static function postFiltersBuysell($condition){
		$room_count="";
		$dis="";
		$origin="";
		$garage="";
		$wash = "";
		$ws="";
        $details = '';
		$house_type ="";
		$live_point = '';
		$street="";
		$type_id="";
		$sq = 0;
		$p = 0;

        foreach ($_GET as $key => $item) {
			if($key=="parent_id") {
                if ($item == 18) {
                    $condition .= " AND ({$key} = '{$item}')";
                } elseif ($item == 3) {
                    $condition .= " AND ({$key} = '3' OR {$key} = '4')"; // Дома и дачи
                } elseif ($item == 1) {
                    $condition .= " AND ({$key} = '1' OR {$key} = '2')"; // новостройки/вто
                } else {
                    $condition .= " AND {$key} = '{$item}'";
                }
            }
		}

		foreach($_POST as $k=>$v){
			if($k!="task" && $k!="action" && !ereg('Выбрано', $v) && $k!="residents" && $k!="order"
				&& $k!="view_type" && $k != "company_id" && $k != "page" && $k != "limit"
				&& $k!="view_type" && $k!="residents" && $k!="without_cont"&& $k!="id"&& $k!="race_now"
				&& $k!="sq_livefrom" && $k!="sq_liveto" && $k!="sq_kfrom"&& $k!="sq_kto"&& $k!="sq_kto"
                && $k!="keys" && $k!="text" && $k!="search_user_id" && $k!="details"
			){
				if(ereg('room_count', $k) && $v!=""){
						$room_count.=($v)."||";
				}else if($k=='floor_from'){
					if ($v != ""){
//						$condition.=" AND (`floor` BETWEEN ".preg_replace("/(&nbsp;)|(\s)|( )/", '', $v);
					}else{
//						$condition.=" AND (`floor` BETWEEN 0"; $p++;
					}
				}else if($k == "photo"){
						$condition.=" AND `photos` = 1";
				}else if($k == "live_point"){
						$live_point = "{$v}";
				}else if($k=='floor_to'){
					if ($v != ""){
						$condition.=" AND {$v})";
					}else{
						$condition.=" AND 99999999)";
					}
				}else if(ereg('house_type', $k) && $v!=""){
					$house_type.="{$v}||";

				}else if($k=='floor_count_from'){
					if ($v != ""){
						$condition.=" AND (floor_count BETWEEN ".preg_replace("/(&nbsp;)|(\s)|( )/", '', $v);
					}else{
						$condition.=" AND (floor_count BETWEEN 0"; $p++;
					}
				}else if($k=='floor_count_to'){
					if ($v != ""){
						$condition.=" AND {$v})";
					}else{
						$condition.=" AND 99999999)";
					}
                }else if($k=='pricefrom'){
					$pricefrom = $v;
					if ($v != ""){
						$condition.=" AND (price BETWEEN ".preg_replace("/(&nbsp;)|(\s)|( )/", '', ($pricefrom));
					}else{
						$condition.=" AND (price BETWEEN 0"; $p++;
					}
					unset($pricefrom);
				}else if($k=='priceto'){
					$priceto = $v;
					if ($v != ""){
						$condition.=" AND {$priceto})";
					}else{
						$condition.=" AND 99999999)";
					}
					unset($priceto);
				}else if(ereg('dis', $k) && $v!=""){
					$dis.="{$v}||";
                }else if(ereg('origin', $k) && $v!=""){
                    $origin.="{$v}||";
				}else if(ereg('street', $k) && $v!=""){
					//$v = str_replace(["проспект ", " проспект"], "", $v);
					$street.="{$v}||";

				}else if(ereg('from', $k) && $sq==0){

					$k = preg_replace("/from/", '', $k);
					if($v!=""){
						$condition.=" AND ({$k} BETWEEN {$v}";
						$sq++;
					}else{
						$condition.=" AND ({$k} BETWEEN 0"; $sq++;
					}

				}else if(ereg('to', $k) && $sq>0){

					if($v!=""){
						$condition.=" AND '{$v}')";
						$sq=0;
					}else{
						$condition.=" AND 99999999)"; $sq=0;
					}

				}else if($k=="favorit"){
					$condition.=" AND {$k} like '%|{$v}|%'";
				}else if($k=="parent_id"){

					if($v==18){
						$condition.=" AND ({$k} = '{$v}')";
					}elseif ($v == 3){
						$condition.=" AND ({$k} = '3' OR {$k} = '4')"; // Дома и дачи
					}elseif ($v == 1) {
						$condition.=" AND ({$k} = '1' OR {$k} = '2')"; // новостройки/вто
					}else{
						$condition.=" AND {$k} = '{$v}'";
					}

				}else if($k=="new_house" ){
					$condition.=" AND  `parent_id` = '2' ";

				}else if($k=="to_metro" && $v!=""){
					$condition.=" AND `distance_to_metro` > 0 AND coords!='55.030199,82.92043' AND `distance_to_metro` < ".$v;
				}else if(ereg('type_id', $k) && $v!=""){
					$type_id.="{$v}||";
				}else if($v != ""){
					$condition.=" AND {$k}='{$v}'";
				}
			}
		}


		if( !empty($live_point)){
			if($live_point != 'Все города'){
                $condition.=" AND `live_point` = '{$live_point}'";
			}
		}else{
				$condition.=" AND `live_point` = 'Новосибирск'";
		}

		if($room_count!="")$condition .= Helper::MultiCondition("room_count='".$room_count, "' OR room_count='");
		if($dis!="")	$condition .= Helper::MultiCondition("dis='".$dis, "' OR dis='");

		if($origin!=""){
            $condition .= Helper::MultiConditionLike($origin);
		}

        $text = self::FilterVal('text');
        $residents = self::FilterVal('residents');
        $condition .=  !empty($text) ? " AND `text` LIKE '%{$text}%' " : '';
		$condition .= !empty($street) ? Helper::strPartsCondition($street) : '';
        $condition .= !empty($residents)? Helper::MultiCondition("residents like '%{$residents}%' AND residents like '%", "%'") : '';

		if($type_id!="")	$condition .= Helper::MultiCondition("type_id='".$type_id, "' OR type_id='");
		if($house_type!="")	$condition .= Helper::MultiCondition("parent_id='".$house_type, "' OR parent_id='");

		return $condition;
	}


	static function MultiCondition($str, $delimiter, $s = "'"){
		return " AND (".(str_replace("||", "{$delimiter}", substr($str, 0, -2)))."{$s})";
	}


    static function MultiConditionLike($str)
    {
        $multiLikeCondition = ' AND (';
        $arrayValues = explode('||', $str);

        for ($i = 0; $i < count($arrayValues); $i++){
            if(empty($arrayValues[$i])) continue;
        	if($i<>0) $multiLikeCondition.= " OR ";
        	$multiLikeCondition.= " link LIKE '%$arrayValues[$i]%'";
		}
        return $multiLikeCondition.')';
    }

	static function Get_filters($condition){
		$room_count="";
		$dis="";
		$poligon = '';
        $origin="";
		$planning="";
		$garage = $wc = $wash = $heating = $water = "";
		$street="";
		$type_id="";
		$parent_id = '';
		$sq = 0;
		$p = 0;
		foreach($_GET as $k=>$v){
			if($k!="task" && $k!="action"
				&& !ereg('Выбрано', $v) && $k!="residents" && $k!="order" && $k!="search_user_id"
				&& $k!="view_type" && $k != "company_id" && $k != "page" && $k != "limit"
				&& $k!="view_type" && $k!="residents" && $k!="without_cont"&& $k!="id"&& $k!="race_now"&& $k!="keys"
                && $k!="photo" && $k!="poligon"
			){

				if(ereg('room_count', $k) && $v!=""){

					if( $_GET['action']!="parse_buysell" ){

						$room_count.="{$v}||";
					}else{
						$room_count.=($v+18)."||";
					}


				}else if($k=='pricefrom'){
					if ($v != ""){
						$condition.=" AND (price BETWEEN ".preg_replace("/(&nbsp;)|(\s)|( )/", '', $v);
					}else{
						$condition.=" AND (price BETWEEN 0"; $p++;
					}
				}else if($k=='priceto'){
					if ($v != ""){
						$condition.=" AND {$v})";
					}else{
						$condition.=" AND 99999999)";
					}
				}else if(ereg('origin', $k) && $v!=""){
                    $origin.="{$v}||";
                }else if(preg_match('/washing/', $k) && $v!=""){
						$condition.=" AND `washing` = {$v} ";

				}else if(preg_match('/wash/', $k) && $v!=""){
					$wash.="{$v}||";

				}else if(ereg('water', $k) && $v!=""){
					$water.="{$v}||";

				}else if(ereg('heating', $k) && $v!=""){
					$heating.="{$v}||";

				}else if(ereg('garage', $k) && $v!=""){
					$garage.="{$v}||";

				}else if(ereg('wc', $k) && $v!=""){
					$wc.="{$v}||";

				}else if(ereg('planning', $k) && $v!=""){
					$planning.="{$v}||";

				}else if(ereg('dis', $k) && $v!=""){
					$dis.="{$v}||";

				}else if(ereg('street', $k) && $v!=""){
					$street.="{$v}||";
				}else if(ereg('from', $k) && $sq==0){
					$k = preg_replace("/from/", '', $k);
					if($v!=""){
						$condition.=" AND ({$k} BETWEEN {$v}";
						$sq++;
					}else{
						$condition.=" AND ({$k} BETWEEN 0"; $sq++;
					}
				}else if(ereg('to', $k) && $sq>0){
					if($v!=""){
						$condition.=" AND '{$v}')";
						$sq=0;
					}else{
						$condition.=" AND 99999999)"; $sq=0;
					}
				}else if($k=="favorit"){
					$condition.=" AND {$k} like '%|{$v}|%'";
				}else if($k=="parent_id"){
                    $parent_id = $v;
					/*if($v==18 && $_GET['action']=="parse"){
						$condition.=" AND ({$k} = '{$v}' OR type_id='18')";
					}else{
					}/**/
						$condition.=" AND {$k} = '{$v}'";


				}else if($k=="to_metro" && $v!=""){
					$condition.=" AND `distance_to_metro` > 0 AND coords!='55.030199,82.92043' AND `distance_to_metro` < ".$v;
				}else if(ereg('type_id', $k) && $v!=""){
					$type_id.="{$v}||";
				}else if($v != ""){
					$condition.=" AND {$k}='{$v}'";
				}
			}
		}

		if(  $_GET['action']!="parse_buysell" ){
			$condition .= $room_count!="" ? Helper::MultiCondition("room_count='".$room_count, "' OR room_count='"):'';
		}else{
			$condition .= $room_count!="" ? Helper::MultiCondition("type_id='".$room_count, "' OR type_id='"):'';
		}
		$condition .= $dis!="" ? Helper::MultiCondition("dis='".$dis, "' OR dis='"):'';

        if(!empty($_GET['poligon'])){
            $idForMaps = self::geIdVarsForMap($parent_id,$_GET['poligon']);
            $condition .= Helper::MultiCondition("id='".$idForMaps, "' OR id='");
        }

		$condition .= $planning!="" ? Helper::MultiCondition("planning='".$planning, "' OR planning='"):'';
		$condition .= $garage!="" ? Helper::MultiCondition("park='".$garage, "' OR park='"):'';
		$condition .= $wc!="" ? Helper::MultiCondition("wc_type='".$wc, "' OR wc_type='"):'';
		$condition .= $wash!="" ? Helper::MultiCondition("wash='".$wash, "' OR wash='"):'';
		$condition .= $heating!="" ? Helper::MultiCondition("heating='".$heating, "' OR heating='"):'';
		$condition .= $water!="" ? Helper::MultiCondition("water='".$water, "' OR water='"):'';
		$condition .= $street!="" ? Helper::strPartsCondition($street):'';
		$condition .= $origin!="" ? Helper::MultiConditionLike($origin) : '';
		$condition .= !empty($_GET['residents']) ? Helper::MultiCondition("residents like '%".$_GET['residents'], "%' AND residents like '%", "%'"):'';
		$condition .= $type_id!="" ? Helper::MultiCondition("type_id='".$type_id, "' OR type_id='"):'';
		return $condition;
	}

	static function strPartsCondition($conditionString, $prefix = ''){
		$strCondition = ' AND (';
		$strList= explode('||', $conditionString);
		foreach ($strList as $key => $strParts) {
			if(empty($strParts)) continue;
			$varStr = explode(' ', $strParts);
			$strCondition .= '(';
			foreach ($varStr as $key => $value) {
				$strCondition .="( {$prefix}`street` LIKE '{$value}%' OR   {$prefix}`street` LIKE '% {$value}%'  ) AND";
			}
			$strCondition = substr($strCondition, 0, -3);
			$strCondition .= ')OR';
		}
		$strCondition = substr($strCondition, 0, -2);
		$strCondition .= ')';
		return $strCondition;
	}

	static function Price($price, $prepayment, $utility_payment, $deposit, $view_date, $race_date){
		$str_price = number_format($price, 0, ',', ' ');
		if(isset($prepayment)){
			$str_price.="/".$prepayment;
		}
		switch ($utility_payment)
		{
			case 'платить дополнительно':
				$utility_payment = "+ <img title='дополнительно за свет' width='20px' style='margin-right:2px' src='images/icon/lite.png'> + <img title='дополнительно за воду' width='20px' src='images/icon/water.png'>";
				break;
			case 'оплата включена в цену':
				$utility_payment = " + <img title='все включено' width='20px' src='images/icon/allinc.png'>";
				break;
			case 'дополнительно только за воду':
				$utility_payment = " + <img title='дополнительно за воду' width='20px' src='images/icon/water.png'>";
				break;
			case 'дополнительно только за свет':
				$utility_payment = "+ <img title='дополнительно за свет' width='20px' src='images/icon/lite.png'>";
				break;
		}
		if($deposit > 0){
			$utility_payment.=" + депозит(".$deposit.")";
		}
		unset($price, $prepayment, $deposit);
		if($_SESSION['post']['view_type'] != "compact"){
			$result = $str_price." <span style='display: inline-block;font-size: 18px; vertical-align: text-top;'>".$utility_payment."</span>";
		}else{
			$result = $str_price." <span style='display: inline-block;font-size: 17px; vertical-align: top;'>".$utility_payment."</span>";
		}
		return $result;
	}

	static function PriceRetro($price, $prepayment, $utility_payment, $torg, $rent_type, $topic, $topic_id, $priceOptions = [])
	{
        $result = '';
		$str_price = number_format($price, 0, ',', ' ');
		$utility_payment = ' ';

		foreach ($priceOptions as $option => $value) {
			$utility_payment .= $value
				? "<font style='color:green; font-size: 13px'> {$option} </font>"
				: "";
		}

		unset($price);
		$result = "<font style='color: #476BC6;font-size: 16px;'>цена: </font><span data-name='price'>{$str_price}</span>"
			.$utility_payment;

		return $result;
	}

	static function PriceRetroMobile($price, $prepayment, $utility_payment, $torg, $rent_type, $topic, $topic_id){
		$str_price = number_format($price, 0, ',', ' ');
		if($topic=="Аренда"){
			$rent_type = $rent_type == "16" ? "сут" : "мес";

			if(isset($prepayment) && $topic_id!=3 && $topic_id!=4){
				$str_price.=" / ".$prepayment."<font  class='retro-gray'> {$rent_type}.,".($torg==1 ? ' торг! ' : ' ')."</font>";
			}

			switch ($utility_payment)
			{
				case 'платить дополнительно':
					$utility_payment = "<font style='color:green; font-size: 13px'>+ ВОДА, СВЕТ.</font>";
					break;
				case 'оплата включена в цену':
					$utility_payment = "<font style='color:green; font-size: 13px'>ВСЕ ВКЛЮЧЕНО.</font>";
					break;
				case 'дополнительно только за воду':
					$utility_payment = "<font style='color:green; font-size: 13px'>+ ВОДА.</font>";;
					break;
				case 'дополнительно только за свет':
					$utility_payment = "<font style='color:green; font-size: 13px'>+ СВЕТ.</font>";;
					break;
			}
			unset($price, $prepayment);
			//<font style='color: #476BC6;font-size: 16px;'>цена: </font>
			$result = "<br/><span data-name='price'>{$str_price}</span> <font style='display: inline-block;font-size: 17px; vertical-align: top;'>".$utility_payment."</font>";
		}
		return $result;
	}

	static function PriceBuySell($price, $prepayment, $utility_payment, $torg, $rent_type, $topic, $topic_id){
		$str_price = number_format($price, 0, ',', ' ');
		return "<font style='color: #476BC6;font-size: 16px;'>цена: </font><span data-name='price' style = 'color:#B10659;font-weight:normal;'>{$str_price}</span><font  class='retro-gray'>".($torg==1 ? ' торг! ' : ' ')."</font>";
	}

	static function FurnList($inet, $furn, $tv, $washing, $refrig, $conditioner, $view_date, $race_date, $residents){
		$class = array(0 => "_off",1 => "");
		$exist = array(0 => "отсутствует",1 => "есть");
		$furnList = "<span style='display:inline-block'><img width='22px' title='мебель ".$exist[$furn]."' src='images/icon/furn".$class[$furn]."'></span>"
					."<span style='display:inline-block'><img width='22px' title='холодильнык ".$exist[$refrig]."' src='images/icon/refrig".$class[$refrig]."'></span>"
					."<span style='display:inline-block'><img width='22px' title='телевизор ".$exist[$tv]."' src='images/icon/tv".$class[$tv]."'></span>"
					."<span style='display:inline-block'><img width='22px' title='стиральная машина ".$exist[$washing]."' src='images/icon/washing".$class[$washing]."'></span>"
					."<span style='display:inline-block'><img width='22px' title='интернет ".$exist[$inet]."' src='images/icon/wifi".$class[$inet]."'></span>"
					."<span style='display:inline-block'><img width='22px' title='кондиционер ".$exist[$conditioner]."' src='images/icon/conditioner".$class[$conditioner]."'></span>";
		$furnList.=Helper::Residents($residents);
		if(isset($view_date) && isset($race_date) && $_SESSION['post']['view_type'] != "compact"){
			$view_arr = explode('-', $view_date);
			$race_arr = explode('-', $race_date);
			$view = $view_arr[2].".".$view_arr[1].".".$view_arr[0];
			$race = $race_arr[2].".".$race_arr[1].".".$race_arr[0];
			if(date('d.m.y', strtotime($race)) < date('d.m.y') || $race_arr[0] == '0000'){
				$furnList.="<span style='  font-size: 14px;'>просмотр и заезд сегодня</span>";
			}else{
				$furnList.="<span style='  font-size: 14px;'> просмотр: ".$view.", заезд: ".$race."</span>";
			}
		}
		return $furnList;
	}

	static function FurnListRetro($furn, $tv, $washing, $refrig, $residents, $ngs, $parent_id = 1, $pay_parse=false){
		if($parent_id == 4 || $parent_id == 5) return ''; // в дачах не показываем
		$furnList = '';
		$class = array(1 => "color: rgb(0, 128, 0);text-transform: uppercase;",0 => "color: rgb(255, 0, 0);");
		$exist = array(0 => "-",1 => "+");
		if(!$ngs){
			$furnList = "<font style='{$class[$furn]}'>м{$exist[$furn]}</font> "
					."<font style='{$class[$refrig]}'>х{$exist[$refrig]}</font> "
					."<font style='{$class[$tv]}'>tv{$exist[$tv]}</font> "
					."<font style='{$class[$washing]}'>ст{$exist[$washing]}</font>";
		}else if(!$pay_parse){
			$furnList = "<font style='{$class[$furn]}'>м{$exist[$furn]}</font> "
					."<font style='{$class[$refrig]}'>х{$exist[$refrig]}</font> ";
		}

		return "<font style='font-weight: normal;font-weight: bold;'>".$furnList."</font>";

	}

	static function FurnListRetroBuysell($furn, $tv, $washing, $refrig, $residents, $ngs, $pay_parse=false){
		$furnList = '';
		$class = array(1 => "color: rgb(0, 128, 0);text-transform: uppercase;",0 => "color: rgb(255, 0, 0);");
		$exist = array(0 => "-",1 => "+");
		if(!$ngs){
			$furnList = "<font style='{$class[$furn]}'>м{$exist[$furn]}</font> "
					."<font style='{$class[$refrig]}'>х{$exist[$refrig]}</font> "
					."<font style='{$class[$tv]}'>tv{$exist[$tv]}</font> "
					."<font style='{$class[$washing]}'>ст{$exist[$washing]}</font>";
		}else if(!$pay_parse){
			$furnList = "<font style='{$class[$furn]}'>м{$exist[$furn]}</font> "
					."<font style='{$class[$refrig]}'>х{$exist[$refrig]}</font> ";
		}
		return $furnList;
	}

	static function Residents($residents)
	{
		if (count(explode("||", $residents)) > 0){$img.="&nbsp;&nbsp;&nbsp;";}
		//$residents_arr = ;
		if(ereg("Одиноких мужчин", $residents)){
			$img.="<span class='resident'><img width='22px' title='берут одиноких мужчин' src='images/icon/residents/man.png' /></span>";
		}else{
			$img.="<span class='resident'><img width='22px' title='не берут одиноких мужчин' src='images/icon/residents/man_off.png' /></span>";
		}
		if(ereg("Одиноких женщин", $residents)){
			$img.="<span class='resident'><img width='22px' title='берут одиноких женщин' src='images/icon/residents/woman.png' /></span>";
		}else{
			$img.="<span class='resident'><img width='22px' title='не берут одиноких женщин' src='images/icon/residents/woman_off.png' /></span>";
		}
		if(ereg("Семейных", $residents)){
			$img.="<span class='resident'><img width='22px' title='берут семейных' src='images/icon/residents/married.png' /></span>";
		}else{
			$img.="<span class='resident'><img width='22px' title='не берут семейных' src='images/icon/residents/married_off.png' /></span>";
		}
		if(ereg("С детьми", $residents)){
			$img.="<span class='resident'><img width='22px' title='берут с детьми' src='images/icon/residents/baby.png' /></span>";
		}else{
			$img.="<span class='resident'><img width='22px' title='не берут с детьми' src='images/icon/residents/baby_off.png' /></span>";
		}
		if(ereg("Студентов", $residents)){
			$img.="<span class='resident'><img width='22px' title='берут студентов' src='images/icon/residents/student.png' /></span>";
		}else{
			$img.="<span class='resident'><img width='22px' title='не берут студентов' src='images/icon/residents/student_off.png' /></span>";
		}
		if(ereg("Строителей", $residents)){
			$img.="<span class='resident'><img width='22px' title='берут строителей' src='images/icon/residents/bilder.png' /></span>";
		}else{
			$img.="<span class='resident'><img width='22px' title='не берут строителей' src='images/icon/residents/bilder_off.png' /></span>";
		}
		if(ereg("Нерусских", $residents)){
			$img.="<span class='resident'><img width='22px' title='берут иностранцев' src='images/icon/residents/inostran.png' /></span>";
		}else{
			$img.="<span class='resident'><img width='22px' title='не берут иностранцев' src='images/icon/residents/inostran_off.png' /></span>";
		}
		if(ereg("С животными", $residents)){
			$img.="<span class='resident'><img width='22px' title='берут с животными' src='images/icon/residents/animal.png' /></span>";
		}else{
			$img.="<span class='resident'><img width='22px' title='не берут с животными' src='images/icon/residents/animal_off.png' /></span>";
		}
		unset($residents);
		return $img;
	}

	static function ResidentsRetro($residents, $topic_id)
	{
		if(!isset($img))$img = '';
		if(ereg("1м", $residents)){
			$img.="1м, ";
		}
		if(ereg("1ж", $residents)){
			$img.="1ж, ";
		}
		if(ereg("Сп\|", $residents)){
			$img.="сп, ";
		}
		if(preg_match("/Сп.р/", $residents)){
			$img.="сп*р, ";
		}
		if(ereg("Студ", $residents)){
			$img.="студ, ";
		}
		if(preg_match("/Ж.р/", $residents)){
			$img.="ж*р, ";
		}
		if(ereg("Нер", $residents)){
			$img.="нер, ";
		}
		if(ereg("Жив", $residents)){
			$img.="жив, ";
		}
		if(ereg("2м", $residents)){
			$img.="2м, ";
		}
		if(ereg("2ж", $residents)){
			$img.="2ж, ";
		}
		if(ereg("субаренда", $residents)){
			$img.="субаренда, ";
		}
		unset($residents);
		return substr($img, 0, -1)."</font>";
	}

	static function An_options(){
		$an_names =  DB::Select('DISTINCT company_name, company_id', 're_company INNER JOIN re_people ON re_company.id = re_people.company_id', "date_dismiss = '0000-00-00 00:00:00' ORDER BY company_name");
		$num = count($an_names);
		for($c=0; $c<$num; $c++)
		{
			echo "<option value='".$an_names[$c]['company_id']."'>".$an_names[$c]['company_name']."</option>";
		}
		unset($num, $an_names, $c);
	}

	static function getCompany()
	{
		return current(DB::Select('*', 're_company', "id = {$_SESSION['company_id']}"));

	}
	static function getCompanyByLogin()
	{
		return current(DB::Select('c.id', '
			re_company c
			INNER JOIN re_people p on p.company_id = c.id
			INNER JOIN re_user u on u.people_id = p.id 
			', "u.login = {$_SESSION['login']}"));
	}

	static function getCompanyByPeople($peopleId)
	{
		return current(DB::Select('c.*', '
			re_company c
			INNER JOIN re_people p on p.company_id = c.id
			', "p.id = {$peopleId}"));
	}

	static function logFile($file, $dataArray)
	{
        $fd = fopen("/var/www/cemeh/logs/{$file}", 'a');
        $content = htmlentities(fgets($fd));
        $dataString = '';
        foreach ($dataArray as $item) {
				$dataString.= json_encode($item);
        }
        fwrite($fd, $content . "\n\r<".date("Y-m-d H:i:s") .">{$dataString}\n\r");
        fclose($fd);
        DB::Insert('re_logs','`created`,`service`,`message`',
			"NOW(), '{$file}','".json_encode($dataArray)."'"
		);
	}
	static function logFileServicesPay($service_id, $file, $dataArray)
	{
        $fd = fopen("/var/www/cemeh/logs/{$file}", 'a');
        $content = htmlentities(fgets($fd));
        $dataString = '';
        foreach ($dataArray as $item) {
				$dataString.= "\n\r". json_encode($item);
        }
        fwrite($fd, $content . "\n\r<".date("Y-m-d H:i:s") .">{$dataString}\n\r");
        fclose($fd);
        DB::Insert('re_logs','`created`,`service_id`,`service`,`message`',
			"NOW(),{$service_id}, '{$file}','".json_encode($dataArray)."'"
		);
	}

	static function Login_options(){
		$logins =  DB::Select('surname, name, second_name, login, user_id', 're_people INNER JOIN re_user ON re_people.id = re_user.people_id', "archive = 0 ORDER BY login");
		$num = count($logins);
		for($l=0; $l<$num; $l++)
		{
			echo "<option value='".$logins[$l]['user_id']."'>".$logins[$l]['login']." ".$logins[$l]['surname']." ".$logins[$l]['name']." ".$logins[$l]['second_name']."</option>";
		}
		unset($num, $logins, $l);
	}

	static function City_list_options(){
		$cities = DB::Select("distinct name", "re_city");
		$cities['count'] = count($cities);
		return $cities;
	}

	static function Services_data(){
		$now = new DateTime();
		if($_SESSION['parent']==0){
			$query = "SELECT u.login, u.group_topic_id, TO_DAYS(sell_date_end) - TO_DAYS(NOW()) as day_count, 
								rent_premium, balance, duty, subscription,subscription_sell, duty_comment, sell_date_end, sell_date_end 
						FROM re_company as c, re_access_date_end as a, re_user as u, re_people as p
						 	WHERE c.id=a.company_id AND p.id=u.people_id AND p.company_id=c.id AND
						 	 c.id = '{$_SESSION['company_id']}' AND u.parent=0 limit 1";

			$data = mysql_fetch_assoc(mysql_query($query));
			$res = mysql_query("(SELECT p.id, p.company_id, p.month_count, p.day_count, p.premium_count, 
				p.sum, p.date_finish, p.date_payment, p.comment from re_payment as p 
				where company_id = '".$_SESSION['company_id']."') UNION (SELECT a.id, a.company_id, null, null, null, 
						a.comment, a.date, a.date, null from re_applications as a 
							where company_id = '".$_SESSION['company_id']."' and `comment` like '%оплачено%')
							ORDER BY date_payment DESC");
			$count = mysql_num_rows($res);
			for($i=0; $i<$count; $i++){
				$res_data[] = mysql_fetch_assoc($res);
			}
			$data["payment_list"] = $res_data;
			unset($res);
			$res = mysql_query("SELECT date_finish, SUM(premium_count) AS prem_sum FROM re_payment 
						WHERE company_id = ".$_SESSION["company_id"]." AND 
						active = 1 AND premium_count > 0
						 GROUP BY (date_finish) ORDER BY date_finish");
			while($row = mysql_fetch_assoc($res)){
				$data["prem_end_date"][] = $row;
			}
			unset ($query, $res, $count, $i, $res_data, $row);

			$lastPeriodRent = (new DateTime($data["sell_date_end"]))->diff($now);
			$data['lastPeriodRent'] = $lastPeriodRent->days+1;
			return $data;

		}
	}

	static function Service_Need_Finance($factor,$count,$sum,$duty){
		$balance = DB::Select("balance", "re_company", "id=".$_SESSION["company_id"])[0]['balance'];
		$financeNeed = $balance - ($factor * $count * $sum) - $duty;
		if($financeNeed >= 0) return true;
		return false;
	}


	static function Session_date_update(){

		if(isset($_SESSION["start_time"])){
			$date = date("Y-m-d H:i:s", strtotime("+2 hours"));
			$count = mysql_fetch_assoc(mysql_query("SELECT count(*) as count FROM re_session WHERE people_id = '{$_SESSION['people_id']}' AND name='".session_id()."'"))['count'];
			if($count == 0){
				$sessionDir = $_SERVER['DOCUMENT_ROOT'].'sessions/';
				if(!empty(session_id())){
					unlink($sessionDir.session_id());
				}
				DB::Delete("re_session", "people_id='{$_SESSION['people_id']}'");
				session_destroy();
				header('Location: /');
			}else{
				DB::Update("re_session", "date_update = '{$date}'", "people_id = '{$_SESSION["people_id"]}'");
			}
			unset($date, $ses_date);
		}
	}

	static function Session_update(){
		if(isset($_SESSION["start_time"]) && $_SESSION['admin']==0){
			$date = date("Y-m-d H:i:s");
			DB::Delete("re_session", "DATE_ADD(date_start, INTERVAL +5 HOUR) < NOW()");
			$count = mysql_fetch_assoc(mysql_query("SELECT count(*) as count FROM re_session WHERE people_id = '{$_SESSION['people_id']}' AND name='".session_id()."'"))['count'];
			if($count == 0){
				DB::Delete("re_session", "people_id='{$_SESSION['people_id']}'");
				session_destroy();
				header('Location: /');
			}else{
				$_SESSION["start_time"] = $date;
				DB::Update("re_session", "date_start = '{$date}'", "people_id = '{$_SESSION["people_id"]}'");
			}
			unset($date, $ses_date);
		}
	}

	static function Main_photo_update($way)
	{
		if(file_exists($_SERVER['DOCUMENT_ROOT'].$way."main.jpg")){
			unlink($_SERVER['DOCUMENT_ROOT'].$way."main.jpg");
		}
		$i=0;
		$dir =  opendir(substr($way, 1, -1));
		while($file = readdir($dir)){
			if($file!="." && $file!=".." && $i==0){
				$thumb = PhpThumbFactory::create($_SERVER['DOCUMENT_ROOT'].$way.$file);
				$thumb->adaptiveResize(200, 150);
				$thumb->save($_SERVER['DOCUMENT_ROOT'].$way."main.jpg");
				$i++;
				unset($thumb);
			}
		}
	}

	static function createWaterMark($people_id)
	{
        $source = imagecreatefrompng( $_SERVER['DOCUMENT_ROOT'].'/images/waterMarkPeople.png');
	   	$bleu = ImageColorAllocate ($source, 0, 0, 255);

        ImageString ($source, 3, 1, 1, $people_id, $bleu);

		$watermarkFile = $_SERVER['DOCUMENT_ROOT'].'/images/'.$people_id.'/waterMarkPeople.png';
        ImagePng($source, $watermarkFile);
        return $watermarkFile;
	}

	static function Add_watermark($photo, $people_id){
		$watermark = imagecreatefrompng(Helper::createWaterMark($people_id));

		$watermark_width = imagesx($watermark);
		$watermark_height = imagesy($watermark);

		$image = imagecreatetruecolor($watermark_width, $watermark_height);
		$image = imagecreatefromjpeg($photo);

		$size = getimagesize($photo);
			$dest_x = $size[0] - $watermark_width - 45;
		$dest_y = $size[1] - $watermark_height - 15;

		imagecopymerge($image, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height, 50);

		imagejpeg($image, $photo);
		imagedestroy($image);
		imagedestroy($watermark);
	}

	static function Send_mail($email, $subject, $text){
		//require 'modules/phpMailer/PHPMailerAutoload.php';

		$mail = new PHPMailer;

		//$mail->SMTPDebug = 3; // Enable verbose debug output

		$mail->isSMTP();
		$mail->Host = 'smtp.mail.ru';
		$mail->SMTPAuth = true;
		$mail->Username = '89139179516@mail.ru';
		$mail->Password = 'BLKJf934tnkks4(nn';
		$mail->SMTPSecure = 'ssl';
		$mail->Port = 465;

		$mail->CharSet='UTF-8';
		$mail->From = '89139179516@mail.ru';
		$mail->FromName = 'Fortunasib';
		$mail->addAddress($email);
		//$mail->addReplyTo('info@example.com', 'Information');
		//$mail->addCC('cc@example.com');
		//$mail->addBCC('bcc@example.com');

		//$mail->addAttachment('/var/tmp/file.tar.gz'); // Add attachments
		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name
		$mail->isHTML(true);

		$mail->Subject = $subject;
		$mail->Body    = $text;
		//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
			echo 'Message has been sent';
		}
	}

    static public function displayOption($title,$value, $postfix = '')
    {
        if(empty($value))
            return null;
        return  "<font class='retro-gray'> $title</font>:<font style = 'font-weight: bold' class='retro-green'>$value$postfix</font>";
    }

	static function Online_count(){
        $sessions = DB::Select("count(*) as cnt ", "re_session",
            "DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -5 MINUTE), '%Y-%m-%d%H%i%s') < DATE_FORMAT(date_update, '%Y-%m-%d%H%i%s')");
        return $sessions['cnt'];
	}

	static function Online_bool($id){
        $session = DB::Select("count(*) as cnt ", "re_session",
			"DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -5 MINUTE), '%Y-%m-%d%H%i%s') < DATE_FORMAT(date_update, '%Y-%m-%d%H%i%s'
				AND people_id={$id}");
		return (!empty($session)) ? $session['cnt']: '';
	}

	static function Admin_message(){
		$today = date('Y-m-d');
		$styleMobile = '';
		if($_SESSION['mobile'] == 1){
			$styleMobile = " style = 'width:90%; left:10%;'";
		}

		$mesNew = DB::Select("*", "re_messages", "people_id_to={$_SESSION['people_id']} AND new=1 AND people_id_from=1");
		$mesRentNew = DB::Select("*", "re_messages_rent as mess",
					"mess.people_from_id <> {$_SESSION['people_id']} AND 
							mess.created >= DATE_SUB(CURRENT_TIMESTAMP(), INTERVAL 15 HOUR) AND mess.text <> '' AND 
					id NOT IN (
							SELECT message_id FROM re_messages_view WHERE people_id = {$_SESSION['people_id']}
					)");
		$mesRentNewAnsver = DB::Select(
				"mess.id as rent_message_id, mess.text as comment, mess.message_id as forum_id, forum.text as text",
				"re_messages_rent as mess
				LEFT JOIN re_forum as forum ON forum.id = mess.message_id",
				"mess.people_from_id <> {$_SESSION['people_id']} AND 
						mess.created >= DATE_SUB(CURRENT_TIMESTAMP(), INTERVAL 15 HOUR) AND mess.text <> '' AND 
						mess.people_for_id  = {$_SESSION['people_id']} AND
				mess.id NOT IN (
						SELECT message_id FROM re_messages_view WHERE people_id = {$_SESSION['people_id']}
				)");


		if(!empty($mesNew) || !empty($mesRentNew) || !empty($mesRentNewAnsver)){
			echo "<div class='admin-mes-main' {$styleMobile}>";

			$mes = DB::Select("*", "re_messages", "people_id_to={$_SESSION['people_id']} AND new=1 AND people_id_from=1");
			if(count($mes)>0 || $_SESSION['show_message']==1){
				echo "<div class='admin-mes' {$styleMobile}>
				<button type='button' data-id = '{$mes[$i]['id']}'  class='close' style='padding-right: 5px;' onclick='$(this).parent().remove()'>
					<span aria-hidden='true'>×</span></button>";
				if($_SESSION['show_message']==1){
					$access_data = DB::Select("DATE_FORMAT(a.sell_date_end,'%d.%m.%Y') as sell_date_end, DATE_FORMAT(a.sell_date_end,'%d.%m.%Y') as sell_date_end, c.company_name, c.balance, c.subscription, c.duty, c.rent_premium", "re_access_date_end as a, re_company as c", "c.id = {$_SESSION['company_id']} AND c.id = a.company_id")[0];
					$recharge = ($access_data['balance'] - 50 - $access_data['duty'] - $access_data['subscription']) > 0;
					$warn_rent = date('Y-m-d', strtotime($access_data['sell_date_end']." - 5 day")) <= date('Y-m-d') ? "rgb(205, 24, 24);" : "rgb(0, 128, 0);";
					$warn_sell = date('Y-m-d', strtotime($access_data['sell_date_end']." - 5 day")) <= date('Y-m-d') ? "rgb(205, 24, 24);" : "rgb(0, 128, 0);";
					$duty_color = $access_data['duty'] > 0 ? "rgb(205, 24, 24);" : "#000;";
					$balance_color = $access_data['balance'] > 0 ? "rgb(0, 128, 0);" : "#000";
					echo "<div style='padding: 5px;'><span style='display: block;text-align: center;'>АН «{$access_data['company_name']}»</span>";
					echo "</span><div>Аренда до: <font style='color:{$warn_rent}'>{$access_data['sell_date_end']}</font><br />Продажа от частников до: <font style='color:{$warn_sell}'>{$access_data['sell_date_end']}</font>";/*<br />Премиумы: {$access_data['rent_premium']};*/
					if($_SESSION['parent']==0)
					{
						$access_end = date('Y-m-d', strtotime($access_data['sell_date_end'])) <= date('Y-m-d');
						echo "<span style='margin-top: -40px;'><!--Аб. аредна: {$access_data['subscription']}--><br />Долг: <font style='color:{$duty_color}'>{$access_data['duty']}</font><br />Баланс: <font style='color:{$balance_color}'>{$access_data['balance']}</font></span>";
						if($access_end && !$recharge){
							echo "<span style='font-size: 38px;color: rgb(205, 24, 24);display: block;'>Доступ к аренде закончился!<br />
							Вам требуется: <br />
							1. пополнить баланс <br />
							2. продлить доступ 
							<a href='?task=profile&action=order'>Пополнить баланс</a>";
						}else if($access_end && $recharge){
							echo "<span style='font-size: 38px;color: rgb(205, 24, 24);display: block;'>Доступ к аренде закончился! 
							<br />Вам требуется:<br />
							<a href='?task=profile&action=services'>продлить доступ</a>";
						}
					}
					echo "</div></div>";

				}
				$count=count($mes);

				for($i=0; $i<$count; $i++){

					echo "<div style='margin: 15px;border: 1px solid #ccc;border-radius: 5px;padding: 5px;'>
					<div style='text-decoration: underline;color:#E81010'>Сообщение от администратора:</div>";
					echo $mes[$i]['text'];
					echo "</div>";
				}
				echo "</div>";
			}

			$mesRentNew = DB::Select(
				"mess.id as message_id, mess.text as txt, mess.people_from_id  people, mess.created created",
				"re_messages_rent as mess",
				"mess.people_from_id <> {$_SESSION['people_id']} AND 
						mess.created >= DATE_SUB(CURRENT_TIMESTAMP(), INTERVAL 15 HOUR) AND mess.text <> '' AND 
						mess.people_for_id IS NULL AND
				id NOT IN (
						SELECT message_id FROM re_messages_view WHERE people_id = {$_SESSION['people_id']}
				) ORDER BY created DESC");
			if(count($mesRentNew)  > 0 && $_SESSION['rent_view'] ==1){
				$count=count($mesRentNew);
				for($i=0; $i<$count; $i++){
                    $agent = DB::Select(
                        'p.id, p.phone phone, p.name, c.company_name ',
                        're_people p LEFT JOIN re_company c ON c.id = p.company_id',
                        "p.id ={$mesRentNew[$i]['people']} LIMIT 1"
                    )[0];
				echo "<div class='rent-mess' {$styleMobile} >
				<button type='button' data-id = '{$mesRentNew[$i]['message_id']}' 
					class='close' style='padding-right: 5px;' onclick='$(this).parent().remove()'>
				<span aria-hidden='true'> × </span></button>";

				echo "<span style='margin-top: -40px;'>
					<b>АН:</b> {$agent['company_name']}<span class='right'>
					<b style='color:#1A831E;'>{$mesRentNew[$i]['created']}</b>
					</span>
					<br/>
					<a href='tel:{$agent["phone"]}'>{$agent["phone"]}</a> {$agent["name"]}
					</p>";
				echo "{$mesRentNew[$i]['txt']} </span><br/></div>";


				}
			}

			//	Ответы на СНИМУ
			$mesRentNewAnsver = DB::Select(
				"mess.id as rent_message_id, mess.text as comment, mess.message_id as forum_id, forum.text as text",
				"re_messages_rent as mess
				LEFT JOIN re_forum as forum ON forum.id = mess.message_id",
				"mess.people_from_id <> {$_SESSION['people_id']} AND 
						mess.created >= DATE_SUB(CURRENT_TIMESTAMP(), INTERVAL 15 HOUR) AND mess.text <> '' AND 
						mess.people_for_id  = {$_SESSION['people_id']} AND
				mess.id NOT IN (
						SELECT message_id FROM re_messages_view WHERE people_id = {$_SESSION['people_id']}
				) GROUP BY mess.message_id ");

			if(!empty($mesRentNewAnsver)  > 0 && $_SESSION['rent_view'] ==1
				//&& ($_SESSION['login'] == 8197 || $_SESSION['login'] == 'admin')
				){

				foreach ($mesRentNewAnsver as $key => $messages) {
				echo "<div class='rent-message' {$styleMobile} >
				<button type='button' data-id = '{$ansver['id']}' class='close' style='padding-right: 5px;' 
									onclick='$(this).parent().remove()'><span aria-hidden='true'>×</span></button>
									";
					echo "<span style='margin-top: -40px;'>";
					echo $messages['text'];
					echo "</span><br/>";
					$ansvers = DB::Select('mess.text, mess.id, mess.created as date_f, company.company_name, people.phone, people.name',
						're_messages_rent as mess 
						LEFT JOIN re_people as people ON people.id = mess.people_from_id
						LEFT JOIN re_company as company ON people.company_id = company.id
						', "message_id = {$messages['forum_id']}");
					foreach ($ansvers as $key => $ansver) {
					echo "<div class='rent-mess-ansver' {$styleMobile} >
								<button type='button' data-id = '{$ansver['id']}' class='close' style='padding-right: 5px;' 
									onclick='$(this).parent().remove()'><span aria-hidden='true'>×</span></button>";
					echo  "<p align = left style = 'font-size: 9px;'>
							<b style='color:#1A831E;' >АН:</b> {$ansver['company_name']}<span class='right'><b style='color:#1A831E;'>
							</b> {$ansver['date_f']}</span>
							<br/>
							<a href='tel:{$ansver['phone']}'>{$ansver['phone']}</a> {$ansver['name']} 
						</p>";
					echo "{$ansver['text']}</div>";
					}
				echo "</div>";
				}
			}
			echo "</div>";
		}

	}

	static function Retro_pag($count, $var_on_page){
		$page = 0;
		if(isset($_GET['page']))
			$page = $_GET['page'];
		$pages = ceil($count/$var_on_page);
		$link = preg_replace("/&page=\d+/", '', $_SERVER['QUERY_STRING']);
		echo "<select onChange='window.location=\"?{$link}&page=\"+$(this).val()'>";
			for($i=1; $i<=$pages; $i++){
				$selected = $page==$i || ($page==0 && $i==1) ? "selected" : "";
				echo "<option value='{$i}' {$selected}>Страница {$i}</option>";
			}
		echo "</select>";
	}

    static function FilterVal($filter){
        if (isset($_GET[$filter])&& $_GET[$filter]!='undefined' ){
            return $_GET[$filter];
        } else if (isset($_POST[$filter])&& $_POST[$filter]!='undefined' ){
            return $_POST[$filter];
        }
        return null;
    }

    static function PostFilterVal($filter){
        if (isset($_POST[$filter])){
            return $_POST[$filter];
        }else{
            return false;
        }
    }

	static function UpdateReview($id)
	{
		if($id>0){
			$review = DB::Select("count(anonymous) as count, anonymous", "re_review", "var_id={$id} GROUP BY (anonymous)");
			$count = count($review);
			if($count == 1 && $review[0]['count']!=0){
				if($review[0]['anonymous'] == 1){
					return 0;
				}else{
					return 1;
				}
			}else if($count==0){
				DB::Update("re_var", "review=0", "id={$id}");
				return 0;
			}else{
				return 1;
			}
		}
	}

	static function Warn($date){
		return date('Y-m-d', strtotime($date." - 5 day")) <= date('Y-m-d') ? "color:rgb(205, 24, 24);" : "";
	}

	static function Pay_parse_company_count(){
		return DB::Select("count(*) as c", "re_access_date_end", "sell_date_end > NOW()")[0]['c'];
	}

	static function Pay_parse_buysell_company_count(){
		return DB::Select("count(*) as c", "re_access_date_end", "sell_date_end > NOW()")[0]['c'];
	}

	static function Origins(){
		$origins = DB::Select("DISTINCT origin", "re_pay_parse", "origin <>''");
		$origin = Helper::FilterVal("origin");
		echo "<div class='col-xs-2 deployed'>
				<select class='form-control' name='origin'>
					<option value=''>все</option>";
					$origins_count = count($origins);
					for($or=0; $or<$origins_count; $or++){
						$selected = $origin == $origins[$or]['origin'] ? "selected" : "";
						echo "<option value='{$origins[$or]['origin']}' {$selected}>{$origins[$or]['origin']}</option>";
					}
			echo "</select>
			</div>";
		unset($origins, $origin, $origins_count, $or, $selected);
	}


	static function OriginsParse(){
		$origins = DB::Select("DISTINCT origin", "re_pay_parse", "origin !=''");
		$origins = ['avito.ru', 'ngs.ru'];
		$origin = Helper::FilterVal("origin");
		echo "<div class='col-xs-2 deployed'>
				<select class='form-control' name='origin'>
					<option value=''>все</option>";
					$origins_count = count($origins);
					for($or=0; $or<$origins_count; $or++){
						$selected = $origin == $origins[$or] ? "selected" : "";
						echo "<option value='{$origins[$or]}' {$selected}>{$origins[$or]}</option>";
					}
			echo "</select>
			</div>";
		unset($origins, $origin, $origins_count, $or, $selected);
	}

	static function Free_ip_count(){
		return DB::Select("count(DISTINCT company_name) as c", "re_addresses as a, re_company as c, re_people as p", "a.people_id = p.id AND p.company_id = c.id AND a.ip = 1 and a.active=1")[0]['c'];
	}

	/*удаление папок*/
	static function removeDirectory($dir){
		if($_SESSION['admin']==1){
			if ($objs = glob($dir."/*")){
				foreach($objs as $obj) {
					is_dir($obj) ? Helper::removeDirectory($obj) : unlink($obj);
				}
			}
			try{
				rmdir($dir);
			}catch(Exeption $e){}
		}
	}

	static function Order_access_off_count(){
		return DB::Select("count(*) as c", "re_company", "order_access=0")[0]['c'];
	}

	// дата окончания доступа к сайту
	static function Company_assess_date($company_id){
		 $end_date = DB::Select("sell_date_end as end_date", "re_access_date_end", "company_id = {$company_id}")[0][''];
		return (new DateTime($end_date))->format('d.m.Y');
	}


	static function Company_with_duty_count(){
		return DB::Select("count(*) as c", "re_company", "duty>0")[0]['c'];
	}

	static function Save_search(){
		return DB::Select("id, search_name, people_id, search_str, CONCAT_WS(' ', client_name, client_email, client_phone) as client, hidden_var, new_var, action, date",
							"re_save_search",
							"people_id=".$_SESSION['people_id']);
	}

	static function Save_sample(){

        $actionType = 'buysell' ;
		return DB::Select("*", "re_sample", "action_type = 'buysell' AND  people_id = ".$_SESSION['people_id']." ORDER BY modified DESC");
	}

	static function deleteSampleVar($sample_id, $var_id)
	{
		//$sample = DB::Select("*", "re_sample", " id = {$sample_id}" )[0];
		return DB::Delete('re_sample_var', "var_id = '{$var_id}' AND sample_id = '{$sample_id}' ");
	}

	static function sampleClear($sample_id)
	{
		$sample = DB::Select("*", "re_sample", " id = {$sample_id}" )[0];
		if(!empty($sample['sample_vars'])) {
			$vars = preg_replace("/\ /", '', $sample['sample_vars']);
			$vars = explode(',', $vars);
			foreach ($vars as $key => $var) {
				$active = DB::Select('active', 're_var', "id = {$var}");
				if(empty($active[0]) || $active[0]['active'] == 0 ){
					Helper::deleteSampleVar($sample_id, $var);
				}
			}
		}
		return  DB::Select("*", "re_sample", " id = {$sample_id}" )[0];
	}

	static function New_var_by_filter($filter_str, $table, $last_date){
		if($filter_str!=""){
			$filter_arr = explode("&", $filter_str);
			$condition = "date_added = DATE_FORMAT('{$last_date}', '%Y-%m-%d') AND
			 DATE_ADD(date_last_edit, INTERVAL -1 hour) > DATE_FORMAT('{$last_date}', '%Y-%m-%d %H:%i:%s')";
			$room_count="";
			$dis="";
			$street="";
			$type_id="";
			$residents="";

				//$k!="without_cont"
			foreach($filter_arr as $filter){
				$kv = explode('=', $filter);
				$k = $kv[0];
				$v = $kv[1];
				if ($k=="without_cont" ){

				}
				elseif(ereg('room_count', $k) && $v!=""){
					if($_GET['action']!="parse"){
						$room_count.="{$v}||";
					}else{
						$room_count.=($v+18)."||";
					}
				}
				else if($k=='pricefrom'){
					if ($v != ""){
						$condition.=" AND (price BETWEEN ".preg_replace("/(&nbsp;)|(\s)|( )/", '', $v);
					}else{
						$condition.=" AND (price BETWEEN 0"; $p++;
					}
				}else if($k=='priceto'){
					if ($v != ""){
						$condition.=" AND {$v})";
					}else{
						$condition.=" AND 99999999)";
					}
				}else if(ereg('dis', $k) && $v!=""){
					$dis.="{$v}||";
				}else if(ereg('street', $k) && $v!=""){
					$street.="{$v}||";
				}else if(ereg('from', $k) && $sq==0){
					$k = preg_replace("/from/", '', $k);
					if($v!=""){
						$condition.=" AND ({$k} BETWEEN {$v}";
						$sq++;
					}else{
						$condition.=" AND ({$k} BETWEEN 0"; $sq++;
					}
				}else if(ereg('to', $k) && $sq>0){
					if($v!=""){
						$condition.=" AND '{$v}')";
						$sq=0;
					}else{
						$condition.=" AND 99999999)"; $sq=0;
					}
				}else if($k=="favorit"){
					$condition.=" AND {$k} like '%|{$v}|%'";
				}else if($k=="parent_id"){
					if($v==18 && $_GET['action']=="parse"){
						$condition.=" AND ({$k} = '{$v}' OR type_id='18')";
					}else{
						$condition.=" AND {$k} = '{$v}'";
					}
				}else if($k=="to_metro" && $v!=""){
					$condition.=" AND `distance_to_metro` > 0 AND coords!='55.030199,82.92043' AND `distance_to_metro` < ".$v;
				}else if(ereg('type_id', $k) && $v!=""){
					$type_id.="{$v}||";
				}else if($k == "residents"){
					$residents=$k;
				}else if($v != ""){
					$condition.=" AND {$k}='{$v}'";
				}
			}

			if($_GET['action']!="parse"){
				if($room_count!="")$condition .= Helper::MultiCondition("room_count='".$room_count, "' OR room_count='");
			}else{
				if($room_count!="")$condition .= Helper::MultiCondition("type_id='".$room_count, "' OR type_id='");
			}
			if($dis!="")$condition .= Helper::MultiCondition("dis='".$dis, "' OR dis='");
			if($street!="")$condition .= Helper::MultiCondition("street like '%".$street, "%' OR street like '%", "%'");
			if($_GET['residents']!="")$condition .= Helper::MultiCondition("residents like '%".$_GET['residents'], "%' AND residents like '%", "%'");
			if($type_id!="")$condition .= Helper::MultiCondition("type_id='".$type_id, "' OR type_id='");

			switch($table) {
				case 'parse':
					$table = "re_parse";
					break;
				case 'pay_parse':
					$table = "re_pay_parse";
					break;
				default:
					$table = "re_var";
			}
			$result = DB::Select("GROUP_CONCAT(id) as ids, count(*) as count", $table, $condition)[0];
			return $result;

		}
	}

	static function For_archive_interval(){
		$interval = DB::Select("for_archive_interval", "re_admin_data limit 1")[0]["for_archive_interval"];
		return $interval;
	}


	static function checkPriPhotosExists($varId)
    {
		$files = self::getFilesFromDir($_SERVER['DOCUMENT_ROOT'] . 'images/parse/' . $varId, '/\.jpg$/');
        if (!empty($files)){
            return str_replace($_SERVER['DOCUMENT_ROOT'], "",$files[0]);
        }
        return false;
    }

    static function checkAgPhotosExists($varId, $people_id)
	{
		$basePhotos = DB::Select('photo', 're_photos', "var_id = {$varId}");
		if(empty($basePhotos)) {
			return null;
		}
        foreach ($basePhotos as $basePhoto) {
			$file = $_SERVER['DOCUMENT_ROOT'].
                'images'.'/'.
                $people_id.'/'.
                $varId.'/'.
                $basePhoto['photo'];
			if(file_exists($file)){
				return str_replace($_SERVER['DOCUMENT_ROOT'], "",$file);
			}
		}
		return null;
	}

	static function Create_image_link($var_id){
		$data = DB::Select("photo as photo, people_id as people", "re_photos", "var_id = {$var_id}");
		$path = $data[0]['people'].'/'.$var_id;
		@unlink($path.'/index.php');
		$content = "<?php ?><html><head></head><body>";
		foreach ($data as $key => $photo) {
			$content .= "<img src = 'http://fortunasib.ru/images/{$path}/{$photo['photo']}'><br/><br/>";
		}
		$content .= "</body></html><?php ?>";
		$fp = fopen($_SERVER['DOCUMENT_ROOT']."images/{$path}/index.php", "w");
		fwrite($fp, $content);
		fclose($fp);
	}

	static function random_string ($str_length, $str_characters)
	{
	    $str_characters = array (0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	    if (!is_int($str_length) || $str_length < 0){
	        return false;
	    }
	    $characters_length = count($str_characters) - 1;
	    $string = '';
	    for ($i = $str_length; $i > 0; $i--){
	        $string .= $str_characters[mt_rand(0, $characters_length)];
	    }
	    return $string;
	}



	static function getSampleListMobile($people_id, $var_id, $type)
	{
		$list = DB::Select('sample_name, id,sample_vars', 're_sample',
					"`people_id` = {$people_id}");
		$sampleList = '';


		foreach ($list as $sample) {
			$sampleVarExists = DB::Select('id','re_sample_var', "sample_id = {$sample['id']} AND var_id = {$var_id}");
			$styleExists = (!empty($sampleVarExists))?'color:red;background-color:brown;':'';

			$sampleList .="<li  class = 'sample'  data-id='{$sample['id']}'> <a style = '{$styleExists}'
								href='javascript:void(0)' 
								OnClick =' SampleAddVar({$sample['id']}, {$var_id}, ".'"'.$type.'"'.")'
								>
								  {$sample['sample_name']}</a></li>";
		}
	    return $sampleList."";
	}

    static function getSampleList($people_id, $var_id, $type, $action_type = 'buysell')
    {
        $list = DB::Select('sample_name, id,sample_vars', 're_sample',
            "`people_id` = {$people_id} AND `action_type` = '{$action_type}' ");
        $sampleList = '';
        foreach ($list as $sample) {
            $sampleVarExists = DB::Select(
                'id',
                're_sample_var',
                "sample_id = {$sample['id']} AND var_id = {$var_id}");
            $styleExists = 'color: grey;';
            if(!empty($sampleVarExists)){
                $styleExists = 'color:red;background-color:brown;';
          	}
            $sampleList .="
				<li  class = 'sample'  >
					<a href='javascript:void(0)' 
						style='{$styleExists}' 
						OnClick = 'SendSample({$var_id},{$sample['id']},\"ag\", \"buysell\",1)'
						>
						{$sample['sample_name']}
					</a>
				</li>";
        }
        return $sampleList."";
    }

    static function createRentMessages($people_id_from, $text, $answer_people_id  = NULL)
	{
		if(empty($people_id_from) || empty($text)) return null;

		$today = date('Y-m-d');
		$isset = DB::Select('id', 're_messages_rent',
					"people_from_id = {$people_id_from} AND text = '{$text}' AND created > '{$today}' ");
		if(!empty($isset)) return null;
		DB::Insert("re_messages_rent", "people_from_id, text, created", "{$people_id_from}, '{$text}', NOW()");
	}

	static function createRentMessagesAnsver($id, $peopleId, $commentText)
	{
		if(empty($id) || empty($peopleId) || empty($commentText)) return null;
		$people_from_id = DB::Select('people_id', 're_forum', "id = {$id}")[0]['people_id'];
		if(empty($people_from_id)) return null;
		DB::Insert("re_messages_rent",
			"people_from_id, text, created, people_for_id, message_id",
			"{$peopleId}, '{$commentText}', NOW(), {$people_from_id},{$id}");
	}

	static function declension($int, $expr){
	  settype($int, "integer");
	  $count = $int % 100;
	  if ($count >= 5 && $count <= 20) {
		$result = $int." ".$expr['2'];
	  } else {
		$count = $count % 10;
		if ($count == 1) {
			$result = $int." ".$expr['0'];
		} elseif ($count >= 2 && $count <= 4) {
			$result = $int." ".$expr['1'];
		} else {
			$result = $int." ".$expr['2'];
		}
	  }
		return $result;
	}

    private function geIdVarsForMap($getPagentId, $poligon)
    {
        $poligonPoints = self::decompressString($poligon);
    	$vertices_x = [];
        $vertices_y = [];
        $varsInPolygon = [];
		$poligonPointsArray = explode('@',$poligonPoints);

        foreach ($poligonPointsArray as $poligonPoint) {
        	$vertices = explode('#', $poligonPoint);
        	if(count($vertices) < 2) continue;
            $vertices_x[] = $vertices['0'];
            $vertices_y[] = $vertices['1'];
        }

        $cntPointsPolygon = count($vertices_x);
        $vars = Helper::getActionVarsCoords($getPagentId);
        $varsInPolygonCoords = '';
        foreach ($vars as $key => $var) {
            $coords = explode(',',$var['coords']);
            if (self::is_in_polygon($cntPointsPolygon, $vertices_x, $vertices_y, $coords[0], $coords[1])){
                $varsInPolygon[] = $var['id'];
            }
        }

        return implode('||',$varsInPolygon);
    }

    private function is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y)
    {
		$i = $j = $c = 0;
        for ($i = 0, $j = $points_polygon-1 ; $i < $points_polygon; $j = $i++) {
            if ( (($vertices_y[$i] > $latitude_y != ($vertices_y[$j] > $latitude_y)) &&
                ($longitude_x < ($vertices_x[$j] - $vertices_x[$i]) * ($latitude_y - $vertices_y[$i]) / ($vertices_y[$j] - $vertices_y[$i]) + $vertices_x[$i]) ) )
                $c = !$c;
        }
        return $c;
    }

    public static function compressString($string)
    {
        return base64_encode($string);
    }

    public static function decompressString($string)
    {
        return  base64_decode($string);
    }

    public static function checkIpLogin()
	{
		if(!isset($_SESSION['login'])){
			return null;
		}
        $sessionStat = DB::Select('browser, ip', 're_enter_statistics',
            "login = '{$_SESSION['login']}' ORDER BY id DESC LIMIT 1")[0];
        if($sessionStat['browser'] != $_SERVER['HTTP_USER_AGENT']
			|| $sessionStat['ip'] != $_SERVER['REMOTE_ADDR']
		) {
			DB::Delete('re_session',"people_id = '{$_SESSION['people_id']}'");
			session_destroy();
		}
    }

    public static function phone_format($phone, $format, $mask = '#')
    {
    	if( substr($phone,0,1) == '8'){
            $phone = substr($phone,1);
		}
    	if( substr($phone,0,2) == '+7'){
            $phone = substr($phone,2);
		}
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (is_array($format)) {
            if (array_key_exists(strlen($phone), $format)) {
                $format = $format[strlen($phone)];
            } else {
                return false;
            }
        }

        $pattern = '/' . str_repeat('([0-9])?', substr_count($format, $mask)) . '(.*)/';

        $format = preg_replace_callback(
            str_replace('#', $mask, '/([#])/'),
            function () use (&$counter) {
                return '${' . (++$counter) . '}';
            },
            $format
        );

        return ($phone) ? trim(preg_replace($pattern, $format, $phone, 1)) : false;
    }

    static function Post_filters_search($condition){
        $room_count="";
        $dis="";
        $poligon = '';
        $origin="";
        $planning="";
        $garage = $wc = $wash = $heating = $water = "";
        $street="";
        $type_id="";
        $parent_id = '1';
        $sq = 0;
        $p = 0;

        foreach($_POST as $k => $v){
            if($k!="task" && $k!="action"
                && !ereg('Выбрано', $v) && $k!="residents" && $k!="order" && $k!="search_user_id"
                && $k!="view_type" && $k != "company_id" && $k != "page" && $k != "limit"
                && $k!="view_type" && $k!="residents" && $k!="without_cont"&& $k!="id"&& $k!="race_now"&& $k!="keys"
                && $k!="photo" && $k!="poligon" && $k!="parent_id" && $k!="val_bal" && $k!="val_lodg" && $k!="text"
            ){
                if(ereg('room_count', $k) && $v!=""){
                    if( $_POST['action']!="parse_buysell" ){
                        $room_count.="{$v}||";
                    }else{
                        $room_count.=($v+18)."||";
                    }
                }else if($k=='pricefrom'){
                    if ($v != ""){
                        $condition.=" AND (price BETWEEN ".preg_replace("/(&nbsp;)|(\s)|( )/", '', $v);
                    }else{
                        $condition.=" AND (price BETWEEN 0"; $p++;
                    }
                }else if($k=='priceto'){
                    if ($v != ""){
                        $condition.=" AND {$v})";
                    }else{
                        $condition.=" AND 99999999)";
                    }
                }else if(ereg('origin', $k) && $v!=""){
                    $origin.="{$v}||";
                }else if(ereg('deliv_period', $k)){
                    $condition .= empty($v)
                        ? " AND deliv_period <> 16"
                        : " AND deliv_period = {$v}";
                }else if(preg_match('/washing/', $k) && $v!=""){
                    $condition.=" AND `washing` = {$v} ";

                }else if(preg_match('/wash/', $k) && $v!=""){
                    $wash.="{$v}||";

                }else if(ereg('water', $k) && $v!=""){
                    $water.="{$v}||";

                }else if(ereg('heating', $k) && $v!=""){
                    $heating.="{$v}||";

                }else if(ereg('garage', $k) && $v!=""){
                    $garage.="{$v}||";

                }else if(ereg('wc', $k) && $v!=""){
                    $wc.="{$v}||";

                }else if(ereg('planning', $k) && $v!=""){
                    $planning.="{$v}||";

                }else if(ereg('dis', $k) && $v!=""){
                    $dis.="{$v}||";

                }else if(ereg('street', $k) && $v!=""){
                    $street.="{$v}||";
                }else if(ereg('from', $k) && $sq==0){
                    $k = preg_replace("/from/", '', $k);

                    if($v!=""){
                        $condition.=" AND ({$k} BETWEEN {$v}";
                        $sq++;
                    }else{
                        $condition.=" AND ({$k} BETWEEN 0"; $sq++;
                    }
                }else if(ereg('to', $k) && $sq>0){

                    if($v!=""){
                        $condition.=" AND '{$v}')";
                        $sq=0;
                    }else{
                        $condition.=" AND 99999999)"; $sq=0;
                    }
                }else if($k=="favorit"){
                    $condition.=" AND {$k} like '%|{$v}|%'";
                }else if($k=="to_metro" && $v!=""){
                    $condition.=" AND `distance_to_metro` > 0 AND coords!='55.030199,82.92043' AND `distance_to_metro` < ".$v;
                }else if(ereg('type_id', $k) && $v!=""){
                    $type_id.="{$v}||";
                }else if($v != ""){
                    $condition.=" AND {$k}='{$v}'";
                }
            }
        }

        if(  $_POST['action']!="parse_buysell" ){
            $condition .= $room_count!="" ? Helper::MultiCondition("room_count='".$room_count, "' OR room_count='"):'';
        }else{
            $condition .= $room_count!="" ? Helper::MultiCondition("type_id='".$room_count, "' OR type_id='"):'';
        }
        $condition .= $dis!="" ? Helper::MultiCondition("dis='".$dis, "' OR dis='"):'';

        if(!empty(Helper::FilterVal("parent_id"))){
            $condition.= ' AND parent_id = '.Helper::FilterVal("parent_id");
        }
        if(!empty($_POST['poligon'])){
            $idForMaps = self::geIdVarsForMap($parent_id, $_POST['poligon']);
            $condition .= Helper::MultiCondition("v.id='".$idForMaps, "' OR v.id='");
        }

        if(Helper::FilterVal('val_bal')){
            $condition .= Helper::FilterVal('val_bal')!=0
                ? Helper::FilterVal('val_bal') == 5
                    ? ' AND val_bal = 5'
                    : ' AND val_bal IN(1,2,3,4)'
                : '';
        }
        if(Helper::FilterVal('val_lodg')){
            $condition .= Helper::FilterVal('val_lodg')!=0
                ? Helper::FilterVal('val_lodg') ==5
                    ? ' AND val_lodg = '.Helper::FilterVal('val_lodg')
                    : ' AND val_lodg  IN(1,2,3,4)'
                : '';
        }

        if(Helper::FilterVal('text')){
            $condition .= " AND text LIKE '%".Helper::FilterVal('text')."%' ";
		}

        $condition .= $planning!="" ? Helper::MultiCondition("planning='".$planning, "' OR planning='"):'';
        $condition .= $garage!="" ? Helper::MultiCondition("park='".$garage, "' OR park='"):'';
        $condition .= $wc!="" ? Helper::MultiCondition("wc_type='".$wc, "' OR wc_type='"):'';
        $condition .= $wash!="" ? Helper::MultiCondition("wash='".$wash, "' OR wash='"):'';
        $condition .= $heating!="" ? Helper::MultiCondition("heating='".$heating, "' OR heating='"):'';
        $condition .= $water!="" ? Helper::MultiCondition("water='".$water, "' OR water='"):'';
        $condition .= $street!="" ? Helper::strPartsCondition($street):'';
        $condition .= $origin!="" ? Helper::MultiConditionLike($origin) : '';
        $condition .= !empty($_POST['residents']) ? Helper::MultiCondition("residents like '%".$_POST['residents'], "%' AND residents like '%", "%'"):'';
        $condition .= $type_id!="" ? Helper::MultiCondition("type_id='".$type_id, "' OR type_id='"):'';
        return $condition;
    }
}
?>
