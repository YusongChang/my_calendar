<?php
	require 'function.php';
	
	//取得當前年份
	$pre_year = $next_year= $year = date('Y');
	//取得當前月份
	$month = date('m');	
	//取得當月的天數
	$month_day = date('t');
	//取得當月的 1 號 是星期幾 0 ~ 7 表示
	$week_day = date('w',mktime(0,0,0,$month,1,$year));
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title></title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="css/style.css" rel="stylesheet">
		<style>
			
			table, th
			{
    			border: 1px solid black;
    			border-radius:5px;
			}	

		</style>
	</head>
	<body>
		<div align='center'>
			<p style="font-size:100px"><?php echo date('Y').' 年 '.date('n').' 月 '?></p>
			<table>
				<tr style="font-size:75px;">
					<th style="color:red;">日</th>
					<th>一</th>
					<th>二</th>
					<th>三</th>
					<th>四</th>
					<th>五</th>
					<th>六</th>
				</tr>
				<?php 
					if(isset($_GET['y'])){
						if($_GET['y']=='pre'){
							$pre_year--;

						}
						else if($_GET['y']=='next'){
							
						}
					}
					if(isset($_GET['m'])){

					}
					calendar_table($month_day, $week_day);
				?>
			</table>
		</div>
		<div align="center">
			<p style="font-size:40px;">
				<a href="?y=pre"><<</a>
					<?php echo " ".$year." "."年 ";?>
				<a href="?y=next">>></a>
				<a style="padding-left:10px;" href="?m=pre"><</a>
					<?php echo " ".$month." "."月 ";?>
				<a href="?m=next">></a>
			</p>	
		</div>
	</body>
</html>

