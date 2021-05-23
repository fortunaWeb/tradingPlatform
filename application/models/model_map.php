<?
class Model_Map extends Model
{	
	public function get_coords()
	{
		if($_SESSION["user"]){
			$condition = Helper::Post_filters("active=1 and coords!='' and coords is not null");
            $coords = DB::Select("coords, id, people_id", "re_var", $condition);
            $coordsStr ="";

            foreach ($coords as $coord) {
                $people_id_black_show_var = Get_functions::Get_black_list_show_var($coord['people_id']);
                if($people_id_black_show_var == 0) continue;

                if($coord['coords']!=""){
                    $coordsStr .= $coord['coords'].",".$coord['id']."|";
                }
			}

			echo $coordsStr;
		}
	}

   public  function get_points_on_poligon()
   {
       $varsInPolygon = [];
       $varsInPolygonCoords = '';
       $poligonPoints = $_POST['point'];
       $vertices_x = $vertices_y = [];
       foreach ($poligonPoints as $key => $poligonPoint) {
           $vertices_x[] = $poligonPoint['longitude'];
           $vertices_y[] = $poligonPoint['latitude'];
       }
       $points_polygon = count($vertices_x);

       $vars = Helper::getActionVarsCoords($_GET['parent_id']);

       foreach ($vars as $key => $var) {
           $coords = explode(',',$var['coords']);
           if (self::is_in_polygon($points_polygon, $vertices_x, $vertices_y, $coords[0], $coords[1])){
               $varsInPolygon[$var['id']]['longitude'] = $coords[0];
               $varsInPolygon[$var['id']]['latitude'] = $coords[1];
               $varsInPolygonCoords .= $coords[0].",".$coords[1].";";
           }
       }
       echo $varsInPolygonCoords;
//       echo trim(json_encode($varsInPolygon, JSON_PRETTY_PRINT));

       return json_encode($varsInPolygon);
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

	public function get_data_by_coords()
	{
		if($_SESSION["user"] && $_POST['coords']){
	    $contacts = (Helper::FilterVal('without_cont')!=1 && $_SESSION["post"]["without_cont"]!=1);
    	if ( !$contacts ) $contectsText = 'style="display:none;"';
			else $contectsText =  'style="display:inline-block;"';

        $idList = explode(',', $_POST['idList']);

        $count=count($idList)-1;
        $condition = "v.active=1";
        if($count > 0){
            for($i=0; $i<$count; $i++){
                if($count == 1){
                    $condition.=" AND v.id=".$idList[$i];
                }else if($i==0){
                    $condition.=" AND (v.id=".$idList[$i];
                }else if($i == $count-1){
                    $condition.=" OR v.id=".$idList[$i].")";
                }else{
                    $condition.=" OR v.id=".$idList[$i]." ";
                }
            }
        }else{
            $condition .= Helper::Post_filters();
        }
        unset($idList, $count);
        $order = $_POST ? $_POST["order"] : "date_last_edit";
        $res = mysql_query("SELECT 
                        v.id, v.street, v.house, v.price, v.type_id, v.topic_id, v.parent_id, v.room_count, v.planning, v.ap_layout,
                         v.deposit, v.ap_view_date, v.ap_race_date,
                        v.deliv_period, v.favorit, v.text, v.sq_all, v.sq_live, v.sq_k, v.furn, v.tv, v.washing, v.refrig, v.residents, 
                        v.owner, c.company_name, p.id as people_id, p.name, p.second_name, p.phone, u.user_id 
                            FROM re_var as v, re_company as c, re_people as p, re_user as u WHERE v.user_id = u.user_id AND u.people_id = p.id AND p.company_id = c.id AND ".$condition." ORDER BY premium DESC, ".$order." DESC");
        unset($data_str);
        $data_str = '';
			while($data = mysql_fetch_assoc($res)){
				$photo_dir = "images/".$data['people_id']."/".$data['id']."/";				
				$first_photo = "images/".$data['people_id']."/".$data['id']."/main.jpg";				
				$product_title = Translate::Var_title($data['type_id'], $data['topic_id'], $data['parent_id'], $data['room_count'], $data['planning'], $data['ap_layout'], $data['deliv_period']);
				$f_box = '';

				if(empty($_POST['sample_id']) AND Helper::isMobileExists($_SESSION['people_id']) ){
                    $f_box .="
						<a href='javascript:void(0)'  style='color: green;' id='check' data-toggle='dropdown' aria-expanded='false'>подборка</a>
						<div data_sample = '{$data['id']}' class='dropdown-menu'  style ='top:20px;padding:0px' >
							".
                        Helper::getSampleList($_SESSION['people_id'], $data['id'], 'ag').
                        "</div>
									</span>
							<br/>";
					}

				if(file_exists($first_photo) ){
 					$f_box.= "<a class='fancybox-thumbs pull-left' href='".$first_photo."' data-fancybox-group='msg".$data['id']."'>
						<img class='media-object' style='max-width: 100px; width: 100%; height:75px;' src='".$first_photo."'></a>" ;
				}else{
					$photo = '';
					if(file_exists($photo_dir))
						$files = scandir($photo_dir);
					foreach ($files as $key => $value) {
						if($value != '.' && $value !='..'){
							$photo = $value;
							break;
						}
					}
					if(!empty($photo)){
						$f_box.= " <a class='fancybox-thumbs pull-left' href='".$first_photo."' data-fancybox-group='msg".$data['id']."'>
							<img class='media-object' style='max-width: 100px; width: 100%; height:75px;' src='".$photo_dir.$photo."'></a>" ;	
					}
				}
				unset($photo, $photo_dir, $first_photo, $files);
				
				$data_str .= 
				"<div class='balloonContent product' style = 'position: relative;' data-id={$data['id']}>"
					.$f_box
					.$product_title."<br />"
					.$data['street']." ".$data['house'].
					"<span class='price'>"
						.number_format($data['price'], 0, ',', ' ');
						if($data['deposit'] >0) $data_str .= " (<font style = 'color:red' >Депозит:{$data['deposit']}</font>)</span><br />";
					$data_str .= "</span><br />"
					.($data['owner']!='' ? "проживает: ".$data['owner']."<br />" : "").
					"«".$data["company_name"]."»<br />".
					$data['name']." ".$data['second_name']."<br />".
					"<font data-name='contacts'  {$contectsText}>".
					$data['phone']. "</font>";
					
					$data_str .= "<input data-name='favorit' type='hidden' value='".$data['favorit']."'>";

					if($data['text'] != "") {
                        $data_str .= "
                                    
                            <p class='' >
                                <span class = 'comment'>{$data['text']}</span>";
                    }
						if(isset($data['ap_view_date']) && isset($data['ap_race_date'])){
							
							if(date("Y-m-d", strtotime($data['ap_race_date'])) < date("Y-m-d")){
								$data_str .= "<br/><font class='retro-green'>Смотреть и заезжать сегодня!</font><br/>";
							}else{
								$data_str .= "<br/><font class='retro-gray'>Смотреть c : </font>
                        <font  style='color: rgb(255, 0, 0);'>".date("d.m", strtotime($data['ap_view_date']))."</font>
                        <font class='retro-gray'> заезд c : </font>
                        <font  style='color: rgb(255, 0, 0);'>".date("d.m", strtotime($data['ap_race_date']))."</font>
                <br/>";
							}
						}
						if(floatval($data['sq_all']) || floatval($data['sq_live'])|| floatval($data['sq_k']))
						{ 
							$data_str .= "<font class='retro-gray'> пл:</font><font class='retro-green'>";
							if($parent != "Гаражи" && $parent != "Дачи"){
								if($data['sq_all']){$data_str .= $data['sq_all']."/";}else{$data_str .= "-/";}
								if($data['sq_live']){$data_str .= $data['sq_live']."/";}else{$data_str .= "-/";}
								if($data['sq_k']){$data_str .= $data['sq_k'];}else{$data_str .= "-";}
							}else if (floatval($data['sq_live']) && !$ngs){
								$data_str .= $data['sq_live'];
							}else{
								$data_str .= $data['sq_all'];
							}
							$data_str .= "</font>"; 
						}
						if($topic != "Продажа"){
							$data_str .= "<br />
                                <font style='font-weight: normal;font-weight: bold;'>"
                                    .Helper::FurnListRetro($data['furn'], $data['tv'], $data['washing'], $data['refrig'],  $data['residents'], $ngs)
                                ."</font>";
						}
						$data_str.= ""
                            ."</p>"
//                            ."</div>"
                            ;

					$data_str .=
                        ""
//                        ."</div>"
                        ."</div>";
			}
			echo $data_str;
		}
	}
	
	public function encodePoligonPoints()
    {
        if(!isset($_SESSION['user']) || !isset($_POST['poligon']))  return null;
        $poligon = $_POST['poligon'];
        echo Helper::compressString(json_encode($poligon));
        return true;
    }

	public function map_tolist()
	{
		if(!isset($_SESSION['user']) || !isset($_POST['coords'])) {
		    return null;
        }
        $idsCoordsMassive = explode(';',$_POST['coords']);
		$idsList = '';
        foreach ($idsCoordsMassive as $item) {
            $idsListBlck = explode(',',$item);
            if(empty($idsListBlck[2])) continue;
            $idsList .= $idsListBlck[2].', ';
		}
        $idsList .= 999999;
        $condition = "`re_var`.active = 1 AND `re_var`.id IN ({$idsList})";
        $row_list = "re_var.id, re_var.user_id, re_var.active, re_var.owner, ap_layout, re_var.parent_id, re_var.rent_type, re_var.commission, re_company.company_name, re_people.name, re_people.id as people_id, re_people.second_name, re_people.phone, dis, planning, live_point, street, house, orientir, text, topic_id, type_id, price, date_last_edit, sq_all, sq_live, sq_k, sq_land, floor, floor_count, room_count, coords, deliv_period, prepayment, utility_payment, deposit, furn, tv, washing, refrig, ap_view_date, ap_race_date, status, premium, favorit, ap_view_price, in_black_list, review, residents, wc_type, heating, wash, water, sewage, torg, DATE_FORMAT(DATE_ADD(`date_last_edit`, INTERVAL -1 hour),'%d/%m/%Y %H:%i') as `date_last_edit_format`, DATE_FORMAT(`date_added`, '%d/%m/%Y %H:%i') as `date_added_format`";
        $table = "`re_var` INNER JOIN re_user ON re_var.user_id = re_user.user_id INNER JOIN re_people ON re_user.people_id = re_people.id INNER JOIN re_company ON re_people.company_id = re_company.id INNER JOIN re_access_date_end ON re_company.id = re_access_date_end.company_id";
        $data = DB::Select($row_list, $table, $condition." ORDER BY premium DESC, date_last_edit DESC");
        $num = count($data);
        for($j=0; $j<$num; $j++)
        {
            $data[$j]['date_last_edit'] = Translate::month_ru($data[$j]['date_last_edit_format']);
            $data[$j]['date_added'] = Translate::month_ru($data[$j]['date_added_format']);
        }
        return $data;
	}

}
?>