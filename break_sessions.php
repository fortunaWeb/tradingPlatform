<?php
ini_set('display_errors', 1);
date_default_timezone_set('Asia/Novosibirsk');
require 'application/modules/phpthumb/ThumbLib.inc.php';
require_once 'application/includes/config.php';
require_once 'application/includes/classes/translate_class.php';
require_once 'application/includes/classes/db_class.php';
$db1 = mysql_connect($db_host,$db_user,$db_pass, true);
mysql_select_db($db_name, $db1);
mysql_query("SET CHARACTER SET utf8", $db1);
mysql_query("SET NAMES utf8", $db1);
mysql_query("SET time_zone = '+07:00'", $db1);
$sessionDir = 'sessions/';

/**
 * проверка активности раз в 3 часа
 */
$querySession = "SELECT
            c.id, c.fortuna_mid, c.company_name, s.date_update, s.name, s.id
        FROM
                 re_company as c
            JOIN re_access_date_end as a ON a.company_id = c.id
            JOIN re_people as p ON p.company_id = c.id
            JOIN re_session as s ON p.id = s.people_id
        WHERE
            c.company_name!=''
             AND DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -3 HOUR), '%Y%m%d%H%i%s') > DATE_FORMAT(s.date_update, '%Y%m%d%H%i%s')


     ";

$res = mysql_query($querySession);

if (mysql_num_rows($res) > 0){
    while ($sess = mysql_fetch_array($res)){
        mysql_query("DELETE FROM `re_session` WHERE `id` = {$sess['id']}");
    }
}

$sessions= scandir($sessionDir);

foreach ($sessions as $session) {
    if($session!= '.' && $session != '..')
    unlink($sessionDir.'/'.$session);
}
/**
 * Ночное обнуление
 */
if(isset($argv[1]) && $argv[1] == 'night_null'){
    /**
     *  Обнуление истории просмотра вариантов.
     */
    mysql_query("DELETE FROM `re_photos_look` WHERE 1");
    $res = mysql_query("UPDATE `re_people` SET `photo_limit_used` =  0 ", $db1);
}
?>