<div id="spacer"><h4>
Избранное
</h4></div>
<div id="msg-box">

<?php		
		$query = "SELECT * FROM re_favorites WHERE user_id = '". $_SESSION['user'] ."'";
		$q_fav = mysql_query($query);
		$fav_num = mysql_num_rows($q_fav);
		for ($i=0; $i<$fav_num; ++$i) {		
					$fav = mysql_fetch_array($q_fav);
					$query2 = "SELECT * FROM re_var WHERE id = '". $fav['var_id'] ."'";
					$q_var = mysql_query($query2);		
					$fav_num2 = mysql_num_rows($q_var);
					for ($j=0; $j<$fav_num2; ++$j) {	
						$fav2 = mysql_fetch_array($q_var);
?>

						<div id="msg<?php echo $i; ?>" class="msg">
							<li>Id варианта: <?php echo $fav2['id']; ?></li>
							<li id="control_panel">
								
							</li>
						</div>
			
		<?php }}?>
		
</div>