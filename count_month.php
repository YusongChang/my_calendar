<!--處理 使用者 按下 上月或下月 的事件-->

<?php 
    require 'function.php';
    require 'Solar_Lunar_YearTrans.php';
    //避免使用 require 'calendar.php' ，重新載入 $current_year 會導致計算錯誤
    
    /**
    *判斷 $_GET (上個月 或 下個月) 以及 年分  資料是否存在 
    */ 
    if((isset($_GET['prem']) || isset($_GET['nextm'])) && isset($_GET['year']) && isset($_GET['d']))
    {    //-------初始化-----------

        if(is_numeric($_GET['d'])  ? true : false){
            $current_day = intval($_GET['d']);
        }
        else
        {
            //d 非數字
            header('Location: calendar.php');
        }

        //取得目前年份，並轉換正整數
        if(is_numeric($_GET['year']) && !empty($_GET['year'])){
            $current_year = intval($_GET['year']);
        }
        else
        {
            //年分 非數字
            header('Location: calendar.php');
        }

        //使用者按下 前月
        //月份 一定要 小於 等於 12 才執行
        if(!empty($_GET['prem']) && $_GET['prem'] <=12 )
        {
            $is_numeric = is_numeric($_GET['prem']);
            $pre_month = intval($_GET['prem']);

            if($is_numeric)
            {  
                if($pre_month == 1)
                {
                    //月份 等於 1 再往前 就是上一年的 12 月份
                    $current_month = 12;
                    //年份 為上一年 故 -1 
                    $current_year--;
                }
                else
                {
                    //為上一月 故 -1 
                    $current_month = --$pre_month;
                }
                //取得該月 的 該月 是 星期幾
                $mktime = mktime(0,0,0,$current_month,1,$current_year);
                //取得該月的天數
                $month_day = date('t',$mktime);
                //取得該月 第 1 天是 星期幾
                $week_day = date('w',$mktime);
            }   
            else
            {
                //非數字
                //轉移回首頁
                header('Location: calendar.php');
            } 
        }

        //使用者按下 下個月
        //月份 一定要 小於 等於 12 才執行
        else if(!empty($_GET['nextm']) && $_GET['nextm'] <=12 )
        {
            $is_numeric = is_numeric($_GET['nextm']);
            $next_month = intval($_GET['nextm']);

            if($is_numeric)
            {  //上月 故 初始月份 轉換成正整數
        
                if($next_month == 12 )
                {
                    //月份 等於 12 在往後 就是 下一年的 1 月份
                    $current_month = 1;
                    //年份 為下一年 故 +1 
                     $current_year++;
                }
                    
                else
                {
                    //為下一月 故 +1 
                    $current_month = ++$next_month;
                        
                }
                //取得該月 的 該月 是 星期幾
                $mktime = mktime(0,0,0,$current_month,1,$current_year);
                //取得該月的天數
                 $month_day = date('t',$mktime);
                //取得該月 第 1 天是 星期幾
                $week_day = date('w',$mktime); 
            }
        }   
        else
        {
            //非 1~12
            //轉移回首頁
            header('Location: calendar.php');
        } 
    }
    else
    {    //值不存在，代表使用者直接訪問此頁
        //轉移回首頁
        header('Location: calendar.php');
    }               
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
			
			table,th
			{text-align:center;
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
            <p style="font-size:100px">
                <?php echo $current_year.' 年 '. $current_month.' 月 ';?>
            </p>
            <p align = "center" style="font-size:45px;margin:1px 0 5px 0;">
                <?php 
					$lunarDate  = new Gregorian2Lunar($current_year, $current_month, $current_day);
					$lunarDate->getLunarDateTime();
				?>
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
                    calendar_table($month_day, $week_day, $current_day);
            ?>
                  </table>
		</div>

		<?php include 'menu.php' ?>

	</body>
</html>

