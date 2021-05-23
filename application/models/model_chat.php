<?php
class Model_Chat extends Model
{
	public function send_call()
	{	
		if($_SESSION["user"] && $_POST){
			$date = date("Y-m-d H:i:s - 1 hours");
			DB::Insert("re_callboard", "callboard_topic, text, people_id, date, photo", "'".$_POST["callboard_topic"]."', '".$_POST["text"]."', '".$_SESSION["people_id"]."', '".$date."', '".$_POST["photo"]."'");
			$id = mysql_fetch_assoc(mysql_query("SELECT id FROM re_callboard WHERE callboard_topic='".$_POST["callboard_topic"]."' AND text='".$_POST['text']."' AND people_id = '".$_SESSION["people_id"]."' AND date='".$date."' AND photo='".$_POST["photo"]."'"))["id"];
			if ($id) {
				// $cur_var = mysql_fetch_assoc($res2);					
				//$_SESSION['cur_var'] = $var_id;
				$uploaddir = $_SERVER['DOCUMENT_ROOT'] .'/images/'. $_SESSION['people_id'];
				if (!file_exists($uploaddir)) {
					@mkdir($uploaddir, 0777);
					@mkdir($uploaddir.'/callboard', 0777);
					@mkdir($uploaddir.'/callboard/'. $id, 0777);
				} else if (!file_exists($uploaddir."/callboard")) {
					@mkdir($uploaddir.'/callboard', 0777);
					@mkdir($uploaddir.'/callboard/'. $id, 0777);
				} else {
					@mkdir($uploaddir.'/callboard/'. $id, 0777);
				}
				echo $uploaddir = $uploaddir.'/callboard/'. $id;
			}
			unset($date, $_POST, $uploaddir, $id);
		}
	}
	
	public function read_mes(){
		if(!isset($_SESSION['people_id'])) return null;
		if( !isset($_GET['mess']) ||  empty($_GET['mess']) ){
			echo DB::Update("re_messages", "new=0", "people_id_to = {$_SESSION['people_id']} AND people_id_from = 1");
		}else{
			echo DB::Update("re_messages", "new=0", "people_id_to = {$_SESSION['people_id']} AND id = {$_GET['mess']}");
		}
	}

	public function read_mes_rent(){
		if(!isset($_SESSION['people_id'])) {
				return null;
		} 
			
		if(!isset($_GET['mess']) ||  empty($_GET['mess']))  return null;
			echo "!!!!!!!!!!!!!";
			echo DB::Insert("re_messages_view", "people_id, message_id, created, view", 
						"{$_SESSION['people_id']}, {$_GET['mess']}, NOW(), 1");
	}
	
	public function nick_create(){
		if(isset($_SESSION['people_id'])){
			if($_POST['nick']!="" && ($_POST['user_id']==null || $_POST['user_id']==$_SESSION['user'])){
				DB::Update("re_user", "nickname='{$_POST['nick']}'", "user_id={$_SESSION['user']}");
				$_SESSION["nickname"] = $_POST['nick'];
			}else if($_POST['nick']!=""){
				DB::Update("re_user", "nickname='{$_POST['nick']}'", "user_id={$_POST['user_id']} AND parent={$_SESSION['user']}");
				$people_id = Get_functions::Get_people_id_by_user_id($_POST['user_id']);
				if($people_id>0){
					DB::Delete("re_session", "people_id=".$people_id);
				}
			}
		}
	}
	
	public function new_chat_mess(){
		if($_POST["text"]!=""){
			DB::Insert("re_chat", "text,nickname,user_id,date", "'{$_POST["text"]}','{$_SESSION["nickname"]}',{$_SESSION["user"]}, NOW()");
		}
	}
	
	public function chat_mess_count(){
		Get_functions::Get_chat_mess_count();
	}
	
	public function chat_user_info(){
		if(isset($_SESSION['people_id']) && isset($_POST['user_id'])){
			echo DB::Select("CONCAT_WS(' ',name,second_name,'АН:',company_name) as info", "re_people as p, re_user as u, re_company as c", "u.user_id = {$_POST['user_id']} AND u.people_id=p.id AND c.id = p.company_id")[0]["info"];
		}
	}
}
?>