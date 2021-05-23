<?php
$arr_num = count($data);
$people_ids_in_an = Get_functions::Get_peoples_ids_in_an($_SESSION['company_id']);
echo "~~~";
for ($j=0; $j<$arr_num ; ++$j) {

echo $data[$j]['id'].";".$data[$j]['parent_id'].";".
$data[$j]['room_count'].";". 
$data[$j]['live_point'].";".
$data[$j]['dis'].";". 
$data[$j]['street']."; ".
$data[$j]['house']."; ". 
$data[$j]['planning']."; ".
$data[$j]['floor'].";".
$data[$j]['floor_count'].";".
$data[$j]['price'].";".
$data[$j]['text'].""
."|";
?>

<?php
}
echo "###";
?>
