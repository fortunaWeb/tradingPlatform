<?php

if ((!$_SESSION) OR (!$_SESSION['user'])){
	$_SESSION['user'] = "guest";
} 

if ($_SESSION['user'] == 'guest' AND $_GET['task'] AND $_GET['task'] != 'main' AND $_GET['task'] != 'login' AND $_GET['task'] != 'var' AND ($_GET['task'] == 'profile')) {
	header("Location: /?task=login&action=enter");
// print_r($_SESSION);
} else if (($_SESSION['user'] == 'guest' OR ($_GET['user'] != $_SESSION['user'])) AND ($_GET['task'] == 'profile' AND $_GET['action'] == 'newvar_old')) {
	if($_GET['user'] != $_SESSION['user']) {
		$_SESSION['user'] = $_GET['user'];
		$_SESSION['login'] = $_GET['user'];
		$_SESSION['fio'] = $_GET['fio'];
		$_SESSION['names'] = $_GET['names'];
		$_SESSION['group_id'] = 3;
		$_SESSION['group_topic_id'] = 1;
		$_SESSION['phone'] = $_GET['phone'];
		$_SESSION['topic_id'] = 1;
		$_SESSION['parent_id'] = 0;
		var_dump("123");
	}

	header("Location: /?task=profile&action=newvar_old&user=". $_SESSION['user'] ."");
}

?>