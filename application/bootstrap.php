<?php
ini_set('date.timezone', 'Europe/Moscow');
ini_set('display_errors', 0);
ini_set('session.save_path', '/var/www/fortuna/sessions');
ini_set('session.gc_maxlifetime', 3600000);
ini_set('session.cookie_lifetime', 3600000);
// подключаем файлы ядра
session_start();
//require_once 'core/sessions.php';

// if ($_SESSION['admin'] == '1') {
	// ini_set('display_errors', 1);
// }

require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';
require_once 'includes/config.php';
require_once 'includes/classes/translate_class.php';
require_once 'includes/classes/get_functions_class.php';
require_once 'includes/classes/helper_class.php';
require_once 'includes/classes/geocode_class.php';
require_once 'includes/classes/db_class.php';
require_once 'modules/phpthumb/ThumbLib.inc.php'; /*плагин для уменьшения фографий*/
// require_once 'modules/phpMailer/PHPMailerAutoload.php';

/*
Здесь обычно подключаются дополнительные модули, реализующие различный функционал:
	> аутентификацию
	> кеширование
	> работу с формами
	> абстракции для доступа к данным
	> ORM
	> Unit тестирование
	> Benchmarking
	> Работу с изображениями
	> Backup
	> и др.
*/


mysql_connect($db_host,$db_user,$db_pass) or die("Невозможно подключится к БД");
mysql_select_db($db_name);
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET NAMES utf8"); 
mysql_query("SET time_zone = '+07:00'");

function w($data)
{
    Helper::show9826($data);
}
if(
	(!isset($_SESSION['people_id']) && isset($_GET['task']) && $_GET['task']!= 'login') 
		AND 
	$_GET['task']!= 'external')
{
	header("Location: http://". $_SERVER['SERVER_NAME']);
}
//Helper::check_access_date();

require_once 'core/route.php';
Route::start(); // запускаем маршрутизатор
mysql_close();
