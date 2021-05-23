<?php
class ModulesHelper{

	static function loadModules($position = null)
	{
		global $router;
		$html = '';
			
		$query = 'select * from modules where position="'.$position.'" order by ordering asc';
		$res = mysql_query($query);
		while($row = mysql_fetch_array($res))
		{
			if ($row['controllers'] != '*')
			{
				$row['controllers'] = json_decode($row['controllers'],true);
				if (!in_array($router->controller_name,$row['controllers']))
					continue;
			}

			if (file_exists(PATH_ROOT.'/modules/'.$row['name'].'/'.$row['name'].'.php'))
				require PATH_ROOT.'/modules/'.$row['name'].'/'.$row['name'].'.php';
		}
	}
	
	static function loadModuleTemplate($name,$template)
	{
		if (file_exists(PATH_ROOT.'/modules/'.$name.'/tmpl/'.$template.'.php'))
			require PATH_ROOT.'/modules/'.$name.'/tmpl/'.$template.'.php';	
	}

}
?>