<?php

//echo hash('sha256', $_POST['txt']);
$token = '';
//$args['Password'] = $this->_secretKey;
//ksort($args);
//foreach ($args as $arg) {
//    $token .= $arg;
//}
$token = hash('sha256', $_POST['txt']);
echo $token;



    ?>