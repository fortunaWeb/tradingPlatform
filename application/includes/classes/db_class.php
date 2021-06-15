<?php
Class DB
{	
	static function Select($column, $table, $condition, $log = null) {
		$data = [];
		$condition = $condition != null ? (" WHERE ".$condition) : "";
		$query = "SELECT ".$column." FROM ".$table.$condition;
//        self::viewSelectLog($query);
        if($log){
            self::log($query,'select');
        }
		$res = mysql_query($query);
		if(!empty($res)){
			$num = [];
			$num = mysql_num_rows($res);
			for($j=0; $j<$num; ++$j) {
				$data[] = mysql_fetch_assoc($res);
			}		
		}
		unset($condition, $query, $res, $num, $j);
		return $data;
	}

	static function Insert($table, $column, $values, $log = null)
    {
		$query = "INSERT INTO ".$table." (".$column.") VALUE (".$values.")";
        if(null!=$log){
            self::log($query,'insert');
        }
		try{
			$res = mysql_query($query);
			if($res){
				return 1;
			}else{
				return $res;
			}			
		}catch(Exception $e){
			return $e;
		}		
	}

	static function Update($table, $values, $condition, $log = null)
    {
		$condition = $condition != null ? (" WHERE ".$condition) : "";
		$query = "UPDATE ".$table." SET ".$values.$condition;
        if(null != $log){
            self::log($query,'update');
        }
		try{
			mysql_query($query);
		}catch(Exception $e){
			return $e;
		}
	}

	static function Delete($table, $condition, $log = null)
    {
		$query = "DELETE FROM ".$table." WHERE ".$condition."";
		$data = '1';
        if(null != $log){
            self::log($query,'delete');
        }
		try{
			mysql_query($query);
		}catch(Exception $e){
			$data = $e;
		}
		return $data;
	}

    static public function log($query, $command = 'db.log')
    {
        $fp = fopen('/var/www/trading_platform/logs/db/'.$command, "a");
	    $now = new DateTime();
        fwrite($fp, "\r\n{$now->format('Y-m-d H:i:s')} {$query} \n\r");
        fclose($fp);
    }

    private function viewSelectLog($query)
    {
        if( $_SESSION['login'] == 8197|| $_SESSION['login'] == 'admin' )// || $_SESSION['login'] == 'admin' ){ //empty($_SESSION) ||
        {
            echo "<br/>!>  " . $query . " <! <br/><br/>";
        }
    }
}
?>