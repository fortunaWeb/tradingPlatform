<?php
ini_set('display_errors', 1);
//	header('Content-Type: text/html; charset=ANSI');


date_default_timezone_set('Asia/Novosibirsk');
require 'application/modules/phpthumb/ThumbLib.inc.php';
require_once 'application/includes/config.php';
require_once 'application/includes/classes/db_class.php';
ini_set('date.timezone', 'Asia/Novosibirsk');
ini_set('session.save_path', '/var/www/fortuna/sessions');
ini_set('session.gc_maxlifetime', 3600000);
ini_set('session.cookie_lifetime', 3600000);

$db1 = mysql_connect($db_host,$db_user,$db_pass, true);
mysql_select_db($db_name, $db1);
mysql_query("SET CHARACTER SET utf8", $db1);
mysql_query("SET NAMES utf8", $db1);
mysql_query("SET time_zone = '+07:00'", $db1);


require 'application/modules/simple_html_dom.php';

$tArr = array(
    0 => "cmns_id",
    1 => "date_last_edit",
    2 => "topic_id",
    3 => "parent_id",
    4 => "room_count",
    5 => "sq_all",
    6 => "sq_land",
    7 => "price",
    9 => "live_point",
    10 => "street",
    11 => "dis",
    14 => "coords",
    15 => "photos",
    16 => "text",
    17 => "floor",
    18 => "floor_count",
    19 => "origin",
    20 => "link",
    21 => "phone"
);
$topic = array(
    "Сдам" => 1,
    "Продам" => 2,
    "Сниму" => 3,
    "Куплю" => 4
);

$parent = array(
    "жилая" => 1,
    "коммерческая" => 7,
    "земля" => 5
);

function ToUtf8($str){
    return mb_convert_encoding($str, 'utf8', 'cp1251');
}

function toAnsi($str){
    return mb_convert_encoding($str, 'cp1251', 'utf8');
}

function replaceStreet($str)
{
    $street = ToUtf8($str);
    $street =  ltrim(rtrim($street));
    $street = str_replace('"', '', $street);
    $street = str_ireplace('имени', '', $street);
    $street = str_ireplace('улица', '', $street);
    $street = str_ireplace(' им ', '', $street);
    $street = str_replace('ул.', '', $street);
    $street = str_ireplace (' ул. ', '', $street);
    $street = str_ireplace('ул ', '', $street);
    $street = str_replace(' ул', '', $street);
    return  toAnsi(ltrim(rtrim($street)));
}

$db = new DB();
$filelist = [];
$parseDir = "/var/www/buysell/parse/";
$dirParsed = '/var/www/buysell/parse/parsed/';
$htmlDir = 'http://prod.fortunasib.ru/parse/';

if ($handle = opendir($parseDir)) {
    while ($entry = readdir($handle)) {
        if (strpos($entry, "cmns") === 0) {
            $filelist[] = $entry;
        }
    }
}

closedir($handle);


foreach ($filelist as $file) {

    $html_url = $htmlDir . $file;
    $html = file_get_html($html_url);

    if ($html!= false) {

//    $fp = fopen($dirParsed . $file, "a");


//    $html_url="http://novosibirsk.cmns.ru/export/api.php?key=js1em2mdeuc94jfdp&filetip=htm&tip=2,4&dom=1,2,3,4,5,6,7,8,9&hour=3&goodaddr=2&repeats=1&ndzvon=1&limit=200";


    if (strpos($html, 'CMNS_API') && strpos($html, '119')) {
        echo $html;
    } else {
        $f_test = fopen("/var/www/fortuna/parsing/html/cmns_parse_" . date("YmdGis") . ".html", "w");
        fwrite($f_test, $html);
        fclose($f_test);
    }

    $i = 0;


    $trs = $html->find('tr');
    $data = [];

    foreach ($trs as $tr) {
        $row = null;
        if ($i > 0) {
            foreach ($tr->find('td') as $td) {
                $row[] = $td->plaintext;
            }
            $data[] = $row;
        }
        $i++;
    }
    $countVar = count($data);
    $date = date("Y-m-d");

//    fwrite($fp, "\r\n" . date("Y-m-d G:i:s T") . " " . $countVar . " "); // Запись в файл

    for ($i = 0; $countVar > $i; $i++) {
        $actionType = 1;
        $parsing_test_file = '';

        $countColumn = count($data[$i]);
        $column = "";
        $value = "";
        $value = "";
        $strForUpd = "";
        $phone = "";
        for ($j = 0; $countColumn > $j; $j++) {
            if (isset($tArr[$j])) {
                if ($j == 20) {
                    $td = $trs[$i + 1]->find('td');
                    $a = $td[$j]->find('a');
                    $href = $a[0]->href;
//                    $parsing_test_file .= $href . " ";
                    $value .= "'{$href}',";
                    $column .= $tArr[$j] . ",";
                } else if ($j == 1) {
                    $dateLastUpd = date("Y-m-d"); //, strtotime($data[$i][$j]));
                    $value .= "'{$dateLastUpd}', '{$date}',";
                    $column .= $tArr[$j] . ", date_added,";
                    $strForUpd .= $tArr[$j] . "='{$dateLastUpd}',";
                } else if ($j == 10) {

                    $sHArr = explode(", ", $data[$i][$j]);

                    if (count($sHArr) == 2) {
                        $street = replaceStreet($sHArr[0]);
                        $column .= $tArr[$j] . ", house,";
                        $value .= "'{$street}', '" . str_replace(" ", "", $sHArr[1]) . "',";
                        $strForUpd .= $tArr[$j] . "='{$street}', house='" . str_replace(" ", "", $sHArr[1]) . "',";
                    } else {
                        $street = replaceStreet($sHArr[0]);
                        $column .= $tArr[$j] . ",";
                        $value .= "'{$street}',";
                        $strForUpd .= $tArr[$j] . "='{$street}',";
                    }
                } else if ($j == 2) {
                    $value .= "'{$topic[ToUtf8($data[$i][$j])]}',";
                    $actionType = $topic[ToUtf8($data[$i][$j])];
                    $column .= $tArr[$j] . ",";
                } else if ($j == 3) {
                    if (ToUtf8($data[$i][4]) == "Комната") {
                        $value .= "'18',";
                    } else if (ToUtf8($data[$i][4]) == "Дом") {
                        $value .= "'3',";
                    } else {
                        $value .= "'{$parent[ToUtf8($data[$i][$j])]}',";
                    }
                    $column .= $tArr[$j] . ",";
                } else if ($j == 19) {
                    if ($data[$i][$j] == 'mirkvartir.ru') continue;
                } else if ($j == 15) {
                    $photos = "";
                    $td = $trs[$i + 1]->find('td');
                    $a_arr = $td[$j]->find('a');
                    $column .= $tArr[$j] . ",";
                    $value .= "1,";
                    $strForUpd .= $tArr[$j] . "=1,";
                } else {
                    if ($j == 21 && ereg('NGS', $data[$i][$j])) {
                        $phone = current($db->Select('contact_tel', 're_parse', "link like '%{$href}%'"))['contact_tel'];
                        $value .= "'{$phone}',";
                        $column .= $tArr[$j] . ",";
                        $strForUpd .= $tArr[$j] . "='{$phone}',";
                    } else {
                        $value .= "'{$data[$i][$j]}',";
                        $column .= $tArr[$j] . ",";
                        $strForUpd .= $tArr[$j] . "='{$data[$i][$j]}',";
                    }
                }
            }
        }


        if ($actionType == 2) {
            $dir = "/var/www/buysell/images/parse/";
            $table = 're_pay_parse_buysell';
        } else {
            continue;
        }
        $queryDb = '';

        if (DB::Select('COUNT(id) cnt', $table, "link='{$href}'")[0]['cnt'] > 0) {
            $strForUpd .= " `modified` = NOW(),";
            $strForUpd = ToUtf8(substr($strForUpd, 0, -1));
            $queryDb = $db->Update($table, $strForUpd, "link='{$href}'", true);
        } else {
            $column .= " `created`, `modified`,";
            $value .= " NOW(), NOW(),";
            $column = substr($column, 0, -1);
            $value = ToUtf8(substr($value, 0, -1));
            $queryDb = $db->Insert($table, $column, $value, true);
        }
        $parsing_test_file .= date("Y_m_d") . " " . date("G_i_s") . " " . $queryDb . "\n\r";
        //		echo "\n\r".$parsing_test_file."\n\r";


        $checkAddress = DB::Select('dis, street, house', $table, "link='$href'")[0];

        if ($checkAddress['dis'] == '' || $checkAddress['dis'] == '0') {
            $queryDis = "SELECT id,house,street,dis,COUNT(*) as cnt
                    FROM {$table}
                    WHERE  `dis` <> ''  AND
                            `dis` <> '0' AND
                            live_point = 'Сочи'  AND
                            street = '{$checkAddress['street']}' AND
                            house = '{$checkAddress['house']}'
                    GROUP BY dis HAVING COUNT(*) = (
                    SELECT MAX(cnt)
                         FROM (
                                SELECT street, dis,COUNT(*) as cnt
                                    FROM {$table}
                                        WHERE `dis` <> ''  AND
                                                `dis` <> '0' AND
                                                live_point = 'Сочи'  AND
                                                street = '{$checkAddress['street']}' AND
                                                house = '{$checkAddress['house']}'
                                        GROUP By dis
                            ) t1
                    )";

            $resDis = mysql_query($queryDis);
            $dataDis = mysql_fetch_assoc($resDis);

            if (!empty($dataDis['dis'])) {
                $db->Update($table, "`dis` = '{$dataDis['dis']}'", "link='{$href}'");
            }
        }

        $queryStreet = '';
        $streetUpdate = '';

        if (count($a_arr) > 0) {
            foreach ($a_arr as $a) {
                $img_link = $a->href;
                $id = DB::Select('id', $table, "link='$href'")[0]['id'];
                if ($id > 0) {
                    $save_way = $dir . $id;
                    if (!file_exists($save_way)) {
                        mkdir($save_way, 0777);
                    }
                    $p_name = explode("/", $img_link);
                    $count = count($p_name);
                    $img_name = $p_name[$count - 1];
                    $save_way .= "/" . $img_name;

                    if (!file_exists($save_way)) {
                        file_put_contents($save_way, file_get_contents($img_link));
                    }
                }
                DB::Update('re_parse', "`photos` = '$id'", "`link` = '$href'");
            }
        }
//        fwrite($fp, $parsing_test_file);
    }
//    fwrite($fp, " \r\n");
//
//    fclose($fp);

}

    copy($parseDir.$file,"/var/www/buysell/parse/parsed/".$file);

    unlink($parseDir.$file);
    /**/
}
?>
