<div class="row">
	<div class="col-xs-12 pagination_row" <?php
		if($_SESSION['mobile']){
			echo 'style = "border-bottom: 0px solid #ccc;text-align: center;"';
		}
	?>>
		<div class="col-xs-4" <?php
	if($_SESSION['mobile']){
		echo 'style = "width: 100%"';
	}
	?>>
			<div class="input-group interval xl">
				<span class="input-group-addon"><?echo $data[0]['count'];?> вариантов</span>	
				<select type="text"  class="form-control" name="limit" id="limit">
					<?if($_GET['post']['view_type']!= "map"){?>
						<option value="50" <?php if($_SESSION['limit'] == 50 OR !$_SESSION['limit']) echo "selected"; ?> >по 50</option>
						<option value="100" <?php if($_SESSION['limit'] == 100) echo "selected"; ?>  >по 100</option>
						<option value="200" <?php if($_SESSION['limit'] == 200) echo "selected"; ?> >по 200</option>	
					<?}else{						
						echo "<option value='50' selected>по 50</option>";
					}?>
				</select>
			</div>	
		</div>
		<?php
if($_SESSION['mobile'])
{
?>
</div>
	<div class="col-xs-12 pagination_row" style = "border-top: 0px solid #ccc;text-align: center;">

<?php
}
?>
		<ul class="pagination pagination-sm">
			<?
			if ($_GET['limit']){
				$limit = $_GET['limit'];
				$_SESSION['limit'] = $limit;
			} else {
				$limit = isset($_SESSION['limit']) ? $_SESSION['limit'] : 50;
			}
			$pages = $data[0]['count']/$limit;

			if ($_GET['page']){
				$page = $_GET['page'];
			} else {
				$page = 1;
			}

			if ($pages > 1)
			{
				if($page == 1)
				{?>
					<li class="disabled">
						<a data-name="previous" href="javascript:void(0)">«</a>
					</li>
				<?}else{
					//$link = preg_replace("/(.+page=)(\d+)(.+)/", '{$1}'.($page-1).'{$3}', $_SERVER['REQUEST_URI']);?>
					<li>
						<a href="javascript:void(0)" onclick="NewPage(<?=($page-1)?>)" aria-label="Previous">
							<span aria-hidden="true">«</span>
						</a>
					</li>
				<?}
				for ($p = 1; $p < $pages + 1; $p++)
				{
					//$link = preg_replace("/(.+page=)(\d+)(.+)/", '{$1}'.$p.'{$3}', $_SERVER['REQUEST_URI']);
					$active = ($p == $page) ? 'active' : '';
					
					if (abs($p-$page) <= 2)
					{?>					
						<li class='<?=$active?>'>
							<a href="javascript:void(0)" onclick="NewPage(<?=$p?>)"><?=$p?></a>
						</li>
					<?}
					elseif($p == 1 || $p == ceil($pages))
					{?>				
						<li>
							<a href="javascript:void(0)" onclick="NewPage(<?=$p?>)"><?=$p?></a>
						</li>
					<?}
				}

				if($page == ceil($pages))
				{?>		
					<li class="disabled">
						<a data-name="next" href="javascript:void(0)">»</a>
					</li>
				<?}else{
					//$link = preg_replace("/(.+page=)(\d+)(.+)/", '{$1}'.($page+1).'{$3}', $_SERVER['REQUEST_URI']);?>
					<li>
						<a data-name="next" href="javascript:void(0)" onclick="NewPage(<?=($page+1)?>)">»</a>
					</li>
				<?}		
			}?>
		</ul>
	</div>
</div>