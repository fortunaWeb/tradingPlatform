<div class="row">
	<div class="col-xs-12 pagination_row"
	<?php
		if($_SESSION['mobile']){
			echo 'style = "border-bottom: 0px solid #ccc;text-align: center;"';
		}
	?>>
		<div class="col-xs-4" 
		<?php
	if($_SESSION['mobile']){
		echo 'style = "width: 100%"';
	}
	?>>
		<?php
		 if(!isset($_SESSION['limit'])){
			$sessionLimit = 50;
		}else{
			$sessionLimit = $_SESSION['limit'];
		}
		?>
			<div class="input-group interval xl">
				<span class="input-group-addon"><?echo $data[0]['count'];?> </span>
				<select type="text"  class="form-control" name="limit" id="limit" form='main_search'>
					<?if( !isset($_SESSION['post']['view_type'])  ||  $_SESSION['post']['view_type']!= "map"){?>
					<option value="50" <?php if($sessionLimit == 50 OR !$sessionLimit) echo "selected"; ?> > 50</option>
					<option value="100" <?php if($sessionLimit == 100) echo "selected"; ?>  > 100</option>
					<option value="200" <?php if($sessionLimit == 200) echo "selected"; ?> > 200</option>
					<?}else{
						echo "<option value='50' selected> 50</option>";
					}?>
				</select>
			</div>
		</div>
    <?php
    if(isset($_SESSION['mobile']) && $_SESSION['mobile'])
    {
    ?>
    </div>
        <div class="col-xs-12 pagination_row" style = "border-top: 0px solid #ccc;text-align: center;">
    <?php
    }
    ?>
		<ul class="pagination pagination-sm">
		<?
		if ($sessionLimit){
			$limit = $sessionLimit;
		} else {
			$limit = 50;
		}
		$pages = $data[0]['count']/$limit;
        $page = !empty(Helper::FilterVal('page')) ? Helper::FilterVal('page') : 1;
		if ($pages > 1)
			{
				if($page == 1)
				{
					echo '<li class="disabled">
							<a data-name="previous" href="javascript:void(0)">«</a>
						</li>';
				}else{
					echo '<li>
							<a data-name="previous" href="javascript:void(0)" onclick="changePagePost('.($page - 1).')">«</a>
						</li>';
				}
				for ($p = 1; $p < $pages + 1; $p++)
				{
					$active = ($p == $page) ? 'active' : '';
					
					if (abs($p-$page) <= 2)
					{						
						echo '<li data-id='.$p.' class='.$active.'>
								<a href="javascript:void(0)" onclick="changePagePost('.$p.')">'.$p.'</a>
							</li>';
					}
					elseif($p == 1 || $p == ceil($pages))
					{					
						echo '<li data-id='.$p.'>
								<a href="javascript:void(0)" onclick="changePagePost('.$p.')">'.$p.'</a>
							</li>';
					}
				}
				if($page == ceil($pages))
				{			
					echo '<li class="disabled">
							<a data-name="next" href="javascript:void(0)">»</a>
						</li>';
				}else{
					echo '<li>
							<a data-name="next" href="javascript:void(0)" onclick="changePagePost('.($page + 1).')">»</a>
						</li>';
				}		
			}?>
		</ul>
	</div>
</div>