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

		<div class = solarlunar></div>
		<div>
			<hr />
			年 : <input type="text" class="y">
			月 : <input type="text" class="m">
			日 : <input type="text" class="d">
			<input class ="submit" type="button" value="submit">
		</div>
		<script
  src="https://code.jquery.com/jquery-1.12.4.js"
  integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU="
  crossorigin="anonymous"></script>
		<script src="Solar_Lunar_YearTrans.js"></script>
		<script>
			$(document).on("ready",function(){

				$('input.submit').on("click",function (){
					var y = $('.y').val(),
						m = $('.m').val(),
						d = $('.d').val();
					var lunar = calendar.solar2lunar(y,m,d);
    			$('div.solarlunar').html('<strong>调用代码示例Demo</strong><br />阳历：'+lunar.cYear + '年' +lunar.cMonth +  '月' + lunar.cDay +'日（'+lunar.astro+'）<br />农历：'+lunar.lYear + '年' +lunar.IMonthCn+lunar.IDayCn+'，'+lunar.gzYear+'年'+lunar.gzMonth+'月'+lunar.gzDay+'日（'+lunar.Animal+'年）'+'<br />');
				});
			});
			
		</script>
		
	</body>
</html>