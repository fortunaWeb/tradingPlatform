<?
class Model_Tasks extends Model
{	
	public function get_data()
	{
		$data = DB::Select("*", "re_tasks", "archive=0 ORDER BY active DESC, priority DESC, date_add");
		return $data;
	}
	
	public function add(){
		if($_SESSION['admin']==1 && isset($_POST['text'])){
			if($_POST["id"]>0){
				DB::Update("re_tasks", "text = '{$_POST['text']}', priority='{$_POST['priority']}'", "id=".$_POST['id']);
				header("Location: http://{$_SERVER['SERVER_NAME']}/?task=tasks");
			}else{
				DB::Insert("re_tasks", "text, priority, date_add", "'{$_POST['text']}', '{$_POST['priority']}', NOW()");
				header("Location: http://{$_SERVER['SERVER_NAME']}/?task=tasks");
			}
		}
	}
	
	public function update(){
		if(isset($_POST['id']) && $_SESSION['admin']==1){
			$date_end = $_POST['col']=="active" ? ", date_end=NOW()" : "";
			$date_start = $_POST['col']=="in_work" ? ", date_start=NOW()" : "";
			DB::Update("re_tasks", "{$_POST['col']}='{$_POST['val']}'{$date_end}{$date_start}", "id=".$_POST['id']);
		}
	}
	
	public function delete(){
		if(isset($_POST['id']) && $_SESSION['admin']==1){
			DB::Delete("re_tasks", "id=".$_POST['id']);
		}
	}
}?>