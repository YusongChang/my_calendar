<?php
	require 'function.php';
	
	//取得當前年份，並賦予上年下年 初始值 等於當前年份
	$current_year  = date('Y');
	//取得當前月份，並賦予上個月下個月 初始值 等於當前月份
	$current_month = date('m');
	//取得當月的天數
	$month_day = date('t');
	//取得當月的 1 號 是星期幾 0 ~ 7 表示
	$week_day = date('w',mktime(0,0,0,$current_month,1,$current_year));
?>

<!DOCTYPE html>
<html lang="zh-TW">
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
			<p style="font-size:100px">
                <?php echo $current_year.' 月 '. $current_month.' 月 ';?>
            </p>
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
                    //處理完第二層 if 判斷 就 載入月曆
                    //註:只有月份往前算 ，月份不用改變
                    calendar_table($month_day, $week_day);
            ?>
            </table>
				
		</div>

		<?php include 'menu.php' ?>

	</body>
</html>