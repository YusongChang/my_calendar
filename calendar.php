<?php
	require 'function.php';
	require 'Solar_Lunar_YearTrans.php';
	
	//取得當前年份，並賦予上年下年 初始值 等於當前年份
	$current_year  = date('Y');
	//取得當前月份，並賦予上個月下個月 初始值 等於當前月份
	$current_month = date('m');
	//當前的日子
	$current_day = date('d');
	//當前的月份天數
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
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
		<style>
			
			table, th
			{	
					text-align:center;
    				border: 1px solid black;
    				border-radius:5px;
			}
			.btn
			{
				font-size:40px;
				margin:3px 0 4px 0;
			}

		</style>
	</head>
	<body>
		<div align='center'>
			<p style="font-size:100px; margin:3px 0 3px 0; padding: 2px 0 0 0;">
                <?php echo $current_year.' 年 '. $current_month.' 月 ';?>
            </p>
			
			<p align = "center" style="font-size:45px;margin: 1px 0 5px 0;padding: 0 0 20px 0;">
				<?php 
					$lunarDate  = new Gregorian2Lunar($current_year, $current_month, $current_day);
					$lunarDate->getLunarDateTime();
				?>
			</p>

            <table>
                <tr style="font-size:75px;" class="tr">
                    <th style="color:red;">日</th>
                    <th>一</th>
                    <th>二</th>
                    <th>三</th>
                    <th>四</th>
                    <th>五</th>
					<th>六</th>
				</tr>		
            <?php
                    //載入月曆
                    calendar_table($month_day, $week_day, $current_day);
            ?>
            </table>		
		</div>
		<?php include 'menu.php' ?>

<!--==============JS=================-->
		<script src="https://code.jquery.com/jquery-1.12.4.js" integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU=" crossorigin="anonymous"></script>
		<script src="Solar_Lunar_YearTrans.js"></script>
		<script>
			/*$(document).on("ready",function(){

				$('input.submit').on("click",function (){
					var y = $('.y').val(),
						m = $('.m').val(),
						d = $('.d').val();
					var lunar = calendar.solar2lunar(y,m,d);
    			$('div.solarlunar').html('<strong>调用代码示例Demo</strong><br />阳历：'+lunar.cYear + '年' +lunar.cMonth +  '月' + lunar.cDay +'日（'+lunar.astro+'）<br />农历：'+lunar.lYear + '年' +lunar.IMonthCn+lunar.IDayCn+'，'+lunar.gzYear+'年'+lunar.gzMonth+'月'+lunar.gzDay+'日（'+lunar.Animal+'年）'+'<br />');
				});
			});*/
		</script>
		
	</body>
</html>
