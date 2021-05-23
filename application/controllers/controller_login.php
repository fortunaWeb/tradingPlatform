<?php
class Controller_Login extends Controller
{
	
	function action_enter()
	{

		if(isset($_POST['login']) && isset($_POST['password']))
		{
			unset($data, $login, $password, $_SESSION);
			session_destroy();

			$login = $_POST['login'];
			$password = $_POST['password'];
			$date = date("Y-m-d H:i:s");
			$ip = $_SERVER['REMOTE_ADDR'];	
			$browser = $_SERVER['HTTP_USER_AGENT'];			
			$sessionMobile = false;
			$date_block_to = date("Y-m-d H:i:s", strtotime($date." +30 minutes"));

			// $count_try_enter = "count_try_enter = count_try_enter + 1";
			/*поиск неудачных попыток входа с данного IP*/
			$statistic = mysql_fetch_assoc(mysql_query("SELECT * FROM re_enter_statistics WHERE ip = '".$ip."' AND enter_success = 0 ORDER BY id DESC LIMIT 0, 1"));
			$date_block = date("Y-m-d H:i:s", strtotime($statistic["date_block_to"]));
			
			$tf = true;

			/*добавление в статистику попытки входа если таковой нет*/

			if($statistic["id"] == ""){
				mysql_query("INSERT INTO re_enter_statistics (login, ip, browser, date_enter) VALUES ('".$login."', '".$ip."', '".$browser."', '".$date."')");
				$statistic = mysql_fetch_assoc(mysql_query("SELECT * FROM re_enter_statistics WHERE ip = '".$ip."' AND enter_success = 0 ORDER BY id DESC LIMIT 0, 1"));
			}else if($date > $date_block){
				/*проверка на количесво попыток входа за последнии 10 минут и дальнейшая блокировка, вслучае привышения разрешенного количества*/
					if(intval($statistic["count_try_enter"])<15){
						if($date > date("Y-m-d H:i:s", strtotime($statistic["date_enter"]." +10 minutes"))){
							mysql_query("UPDATE re_enter_statistics SET count_try_enter = 1, date_enter='".$date."' WHERE id=".$statistic["id"]);
						}else{
							mysql_query("UPDATE re_enter_statistics SET count_try_enter = count_try_enter + 1 WHERE id=".$statistic["id"]);
						}
					}else{
						mysql_query("UPDATE re_enter_statistics SET count_try_enter = 0, date_block_to='".$date_block_to."' WHERE id=".$statistic["id"]);
						$data = "Вы заблокированы на 30 минут.";
						$tf = false;
					}
			}else{
				$data = "Вы заблокированы до ".date("d.m.Y H:i", strtotime($date_block." -1 hour"));
				$tf = false;
			}

			unset($date_block_to, $date_block);

			if($tf){
				
				$query = "SELECT * FROM re_user 
				INNER JOIN re_people ON re_user.people_id = re_people.id 
				INNER JOIN re_company ON re_people.company_id = re_company.id 
				INNER JOIN re_access_date_end ON re_access_date_end.company_id = re_company.id 
				where ((`login` = '". $login ."') AND (`password` = '". $password ."')) AND active = '1' AND archive = '0'";
				$res_q = mysql_query($query);

				unset($login, $password, $query);				
				/*
				Производим аутентификацию
				*/
				if(mysql_num_rows($res_q) == 1)
				{
					/*проверка на наличие сессии*/
					$row_q = mysql_fetch_assoc($res_q);
                    $queryDouble = "SELECT name  FROM re_session WHERE people_id = '{$row_q['people_id']}' ";
                    mysql_query("DELETE FROM re_session WHERE people_id={$row_q['people_id']}");

                    if( $_POST['mobile'] ) // мобильная версия страниц.
                    {
                        $mobile = true;
                    }

                    if($row_q['admin'] == 0){
                        if((
                            intval($row_q['group_topic_id']) == 2 &&
                            date("Y-m-d", strtotime($row_q["sell_date_end"])) < date("Y-m-d")
                        )){
                            $row_q["group_topic_id"] = 0;
                        }

                        if(intval($row_q['group_topic_id'])==0){
                            if($row_q['parent'] > 0){
                                $data = "У Вас кончился доступ, обратитесь к директору вашего АН.";
                            }else if($row_q['company_id'] && $row_q['user_id'] && $row_q['people_id']){
                                session_start();
                                $_SESSION['company_id'] = $row_q['company_id'];
                                $_SESSION['group_topic_id'] = 0;
                                $_SESSION["order_access"] = $row_q['order_access'];
                                $_SESSION["parent"] = 0;
                                $data[0] = "ex_of_acc";
                                $data[1] = $row_q['company_name'];
                                $data['balance'] = $row_q['balance'];
                                $data['duty'] = $row_q['duty'];
                                $data['subscription'] = $row_q['subscription'];
                                DB::Update('re_enter_statistics',
                                    "date_enter='{$date}', browser='{$browser}', ip='{$ip}', people_id={$row_q['people_id']}",
                                    "id={$statistic['id']}"
                                );

                            }
                            $tf=false;
                        }else if (intval($row_q['group_topic_id']) > 0){
                            $rs = array(
                                1 => "rent",
                                2 => "sell",
                                3 => "rent"
                            );

                            $x=0;
                            $access = DB::Select(' ip, browser, mob', 're_addresses',
                                            "people_id = '{$row_q['people_id']}' AND active = 1 AND archive = 0 ORDER BY `mob` DESC");


                            $isMobAllow = DB::Select('COUNT(mob) as isMobAllow', 're_addresses',
                                        "people_id = '{$row_q['people_id']}' AND active = 1 AND archive = 0 AND mob = 1")[0]['isMobAllow'];
                            if($isMobAllow > 0) $isMobAllow = 1;

                            $num = count($access);
                            foreach ($access as $key => $value) {
                                $mob_temp = $value["mob"];
                                $ip_temp = $value["ip"];
                                $browser_temp = $value["browser"];
                                if($ip_temp!=""){
                                    if(preg_match('/^'.$ip_temp.'/', $ip) || $ip_temp=='1'){
                                        if($browser_temp != '' && strpos($browser, $browser_temp) === false){
                                            $tf=false;
                                            $x = 0;
                                        }else{
                                            if($mobile && $mob_temp ==1){
                                                $sessionMobile = true;
                                            }
                                            $tf=true;
                                            $x=1;
                                            break;
                                        }
                                    }
                                }
                            }

                            if ($x==0)
                            {
                                DB::Update('re_enter_statistics',
                                    "enter_success='1', date_enter='{$date}', browser='{$browser}', ip='{$ip}'",
                                    "id={$statistic['id']}"
                                );
                                $tf=false;
                                $data = "Ваш ip-адресс не совпадает с заявленым.";
                            }
                            unset($num, $x, $rs);
                        }
                    }

                    $res_q = mysql_query($queryDouble);
                        if(mysql_num_rows($res_q) > 0){
                            $tf=false;
                            $sessionDir = '/var/www/fortuna/sessions/';
                            while ($rowSessionName = mysql_fetch_array($res_q)){
                                DB::Delete('re_session', "people_id={$row_q['people_id']}");
                                @unlink($sessionDir.'sess_'.$rowSessionName['name']);
                            }
                        }

                    $premium_count = DB::Select(
                            'sum(premium_count) as premuim_count',
                            're_payment',
                            "company_id = {$row_q['company_id']} and premium_count>0 and active=1 and date_finish <= NOW()"
                    )[0]["premuim_count"];

                    if(intval($premium_count)>0){
                        DB::Update('re_company'," rent_premium = `rent_premium`-{$premium_count}", "id = {$row_q['company_id']}" );
                        DB::Update('re_payment', 'active = 0', "company_id = {$row_q['company_id']} AND premium_count>0 and active=1 AND date_finish <= NOW()");
                        $active_rent_premium = DB::Select('rent_premium', 're_company', "id = {$row_q['company_id']}")[0]['rent_premium'];
                        $ids = DB::Select('v.id', 're_var as v
                                INNER JOIN re_user as u ON u.user_id=v.user_id 
                                INNER JOIN re_people as p ON p.id=u.people_id',
                            "p.company_id={$row_q['company_id']} AND  v.premium=1 
                             ORDER BY 
                                v.date_last_edit DESC 
                             LIMIT ".intval($active_rent_premium).", 999"
                        );

                        $id_str = "";
                        foreach ($ids as $id) {
                            $id_str .= " id=".$id["id"]." OR";
                        }
                        if($id_str!=""){
                            DB::Update('re_var', 'premium=0', substr($id_str, 0, -2));
                        }
                    }

                    if($tf){
                        $data = "Успешный вход.";
                        session_start();
                        $_SESSION["post"] = [];
                        $_SESSION['buysell'] = 0;
                        $_SESSION["isMobAllow"] = $isMobAllow;
                        $_SESSION['user'] = $row_q['user_id'];
                        $_SESSION['rent_view'] = $row_q['rent_view'];
                        $_SESSION['login'] = $row_q['login'];
                        $_SESSION['people_id'] = $row_q['people_id'];
                        $_SESSION['group_id'] = $row_q['group_id'];
                        $_SESSION['fio'] = $row_q['surname']." ".$row_q['name']." ".$row_q['second_name'];
                        $_SESSION['io'] = $row_q['name']." ".$row_q['second_name'];
                        $_SESSION['email'] = $row_q['email'];
                        $_SESSION['phone'] = $row_q['phone'];
                        $_SESSION['phone_addon'] = $row_q['phone_addon'];
                        $_SESSION['company_id'] = $row_q['company_id'];
                        $_SESSION['company_name'] = $row_q['company_name'];
                        $_SESSION['date_company_reg'] = $row_q['date_company_reg'];
                        $_SESSION['pass'] = $row_q['password'];
                        $_SESSION['parent'] = $row_q['parent'];
                        $_SESSION['order_access'] = $row_q['order_access'];
                        $_SESSION['site'] = $row_q['site'];
                        $_SESSION['group_topic_id'] = $row_q['group_topic_id'];
                        $_SESSION['admin'] = $row_q['admin'];
                        $_SESSION['start_time'] = $date;
                        $_SESSION['tariff_id'] = $row_q['tariff_id'];
                        $_SESSION['sell_date_end'] = $row_q["sell_date_end"];
                        $_SESSION['sell_date_end'] = $row_q["sell_date_end"];
                        $_SESSION['sell_date_end'] = $row_q["sell_date_end"];
                        $_SESSION['show_message'] = 1;
                        $_SESSION['access_var'] = $row_q["access_var"];
                        $_SESSION['block_com_an'] = $row_q["block_com_an"];
                        $_SESSION['block_com_parse'] = $row_q["block_com_parse"];
                        $_SESSION['block_forum'] = $row_q["block_forum"];
                        $_SESSION['block_chat'] = $row_q["block_chat"];
                        $_SESSION['nickname'] = $row_q['company_name'];

                        $_SESSION['email_work'] = $row_q["email_work"];
                        $_SESSION['email_pass'] = $row_q["email_pass"];
                        $_SESSION['save_search_limit'] = $row_q["save_search_limit"];
                        if($sessionMobile){
                            $_SESSION['mobile'] = 1;
                        }else{
                            $_SESSION['mobile'] = 0;
                        }
                        mysql_query("UPDATE re_enter_statistics SET enter_success='1', 
date_enter='".$date."', browser='".$browser."', ip='".$ip."', people_id='".$_SESSION["people_id"]."' WHERE id=".$statistic["id"]);

                        DB::Update('re_enter_statistics',
                            "enter_success=1, date_enter='{$date}', browser='{$browser}', ip='{$ip}', people_id={$_SESSION['people_id']}",
                            "id={$statistic['id']}"
                        );
                        if(empty(DB::Select('id','re_photos_look',"`people_id` = '{$row_q['people_id']}'")))
                        {
                            DB::Insert('re_photos_look','`people_id`, `look_vars`', "'{$row_q['people_id']}', ''");
                        }
                        mysql_query("DELETE FROM re_session WHERE people_id = ".$row_q['people_id']);
                        mysql_query("INSERT INTO re_session (people_id, name, date_start) VALUE(".$row_q['people_id'].", '".session_id()."', '".$date."')");


                        if($_SESSION["admin"]==1){
                            header('Location: /?task=admin&action=order');
                        }else{
                            if($_SESSION['mobile']){
                                header('Location: /?task=main&action=mobile&parent_id=1&topic_id=1');
                            }
                            header('Location: /?task=main&action=index&copyright=0&parent_id=1&topic_id=2');
                        }
                        unset($row_q, $date, $browser, $ip, $statistic, $tf, $session);
                    }
				} else {
					$data = "Неправильное имя пользователя или пароль.";
				}				
			}
		}

		$this->view->generate('login_view.php', 'template_view.php', $data);
	}
	
	function action_logout()
	{
		if($_SESSION['user']) {
			mysql_query("DELETE FROM re_session WHERE people_id = ".$_SESSION['people_id']);
			session_destroy();
			header('Location: /');
		} else {
			header('Location: /');
		}
		
		$this->view->generate('login_view.php', 'template_view.php');
	}
	
	function action_login_back()
	{
		if($_POST['login']) {
			mysql_set_charset( 'utf8' );
			$query = "SELECT `email` FROM `re_user` where (`login` = '". $_POST['login'] ."')";
				$res = mysql_query($query);
				if ((mysql_num_rows($res) == 1) AND ($res)) {
					$row_q = mysql_fetch_array($res);
					$email = $row_q['email'];
					
$to  = $email .", " ; 
//$to .= ""; 

$subject = "Восстановление пароля для сайта Arendanovosib.ru"; 

$message = ' 
<html> 
    <head> 
        <title>Восстановление пароля для сайта Arendanovosib.ru</title> 
    </head> 
    <body> 
        <p>
		Здравствуйте логин, <br />
		'. $_POST['login'] . ' <br />
		ваш новый пароль: ' . md5($_POST['login']) .'<br />
		Желаем удачи в далнейшей работе с сайтом.
		</p> 
    </body> 
</html>'; 

$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
$headers .= "From: Arendanovosib.ru <arendanovosib@mail.ru>\r\n"; 

$mailto = mail($to, $subject, $message, $headers); 
					if ($mailto) {
						echo "<p>Новый пароль отправлен вам на почту</p>";
					} else {
						echo "<p>Произошла ошибка.</p>";
					}
	$query2 = "UPDATE `re_user` set `password` = '". md5($_POST['login']) ."' where (`login` = '". $_POST['login'] ."')";
	mysql_query($query2);
				}
		} else {
			echo "<p>повторите попытку</p>";
		}
	}


	function action_check_update()
	{
	    $login = Helper::FilterVal('login');
	    $password = Helper::FilterVal('password');
		if(empty($login) || empty($password)){
			return null;
		}

		$now = new DateTime();
		$user =  DB::Select('user.user_id as user_id, people.id as people_id', 're_user as user
			INNER JOIN re_people as people on user.people_id = people.id
			INNER JOIN re_company as company on people.company_id = company.id
			INNER JOIN re_access_date_end as access_date_end on access_date_end.company_id = company.id
			', "sell_date_end >= '{$now->format('Y-m-d')}' AND `login`='{$_POST['login']}' AND `password`='{$_POST['password']}' AND `active` = 1 LIMIT 1")[0];
		if(empty($user)){			
			return null;
		}


		$lasVar = DB::Select('date_last_edit', 're_var as var', "var.user_id =  '{$user['user_id']}' AND var.active = 1 ORDER BY `date_last_edit` DESC LIMIT 1 ")[0];
		if(empty($lasVar)){
			echo "Нет вариантов к продлению.";
			return null;
		}

		$lastVarDate = new DateTime($lasVar['date_last_edit']);
		$interval = $now->diff($lastVarDate);
		if ($interval->format('%H') < 3) {
			echo "Последнее продление было ". $lastVarDate->format("j/d/Y H:i").".";
			return null;
		}

		$_SESSION['var_update'] = $user['user_id'];

		DB::Insert("`re_enter_statistics`", "people_id, login, ip, browser, date_enter ", "'{$user['people_id']}', '{$_POST['login']}', '{$_SERVER['REMOTE_ADDR']}', '{$_SERVER['HTTP_USER_AGENT']}', NOW()");

		echo 'OK';
		return true;
	}
	
	function action_var_update()
	{
		if(!isset($_POST['update']) || $_POST['update']!=1 || !isset($_SESSION['var_update'])){
			return null;
		}

		$now = new DateTime();
		$lasVar = DB::Select('date_last_edit', 're_var as var', "var.user_id =  '{$_SESSION['var_update']}' ORDER BY `date_last_edit` DESC LIMIT 1 ")[0];
		$lastVarDate = new DateTime($lasVar['date_last_edit']);
		$interval = $now->diff($lastVarDate);
		if ($interval->format('%H') < 3) {
			return null;
		}

		DB::Update("re_var", "date_last_edit= NOW() ", "`active` = 1 AND `user_id`={$_SESSION['var_update']}");
		unset($_SESSION);
		echo 'UPDATE';

	}

	
}
