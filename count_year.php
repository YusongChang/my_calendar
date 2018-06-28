<!--處理 使用者 按下 上年或下年 的事件-->
<?php 
    require 'function.php';

    //避免使用 require 'calendar.php' ，重新載入 $current_year 會導致計算錯誤

    /**
     * 處理使用者 按下 上 或 下 年 以及月份 資料是否存在
     */
    if((isset($_GET['prey']) || isset($_GET['nexty'])) && isset($_GET['month']))
    {  
        //--------初始化-----------
        //取得目前月份，，是數字且不為 0 
        if(is_numeric($_GET['month']) && !empty($_GET['month'])){
            //轉為正整數
            $current_month = intval($_GET['month']);
        }
        else
        {
            //年分 非數字
            header('Location: calendar.php');
        }
        //註:這是年份往前算 ，取得不用改變，故取得當前月份
       
        //使用者按下 前年
        if(!empty($_GET['prey']))
        {   //判斷是否為 數字 或是 含數字的字串
            $is_numeric = is_numeric($_GET['prey']);
            //轉正整數
            $pre_year = intval($_GET['prey']);

            if($is_numeric && $pre_year >= 2)
            {    //上年 故 初始年份 轉換成正整數 - 1
                //並賦值給 $current_year 以供標題與按鈕的日期 更新 用
                $current_year = --$pre_year;

                //取得該年資料 
                $mktime = mktime(0,0,0,$current_month,1,$pre_year);
                //取得該月的天數
                $month_day = date('t',$mktime);
                //該月 是 星期幾
                $week_day = date('w',$mktime);
            }   
            else
            {
                //非數字 且 數字 非 大於 等於 2 (年份等於 1 往前按 會變0)
                //轉移回首頁
                header('Location: calendar.php');
            }
            
        }
        elseif(!empty($_GET['nexty']))
        {
          
            //使用者按下 下一年
            //判斷是否為 數字 或是 含數字的字串
            $is_numeric = is_numeric($_GET['nexty']);
            //轉正整數
            $next_year = intval($_GET['nexty']);
            if($is_numeric)
            {    //下一年 故 初始年份 轉換成正整數 + 1
                //並賦值給 $current_year 以供標題與按鈕的日期 更新 用
                $current_year = ++ $next_year;
                //取得該年資料 
                $mktime = mktime(0,0,0,$current_month,1,$next_year);
                //取得該月的天數
                $month_day = date('t',$mktime);
                //該月 是 星期幾
                $week_day = date('w',$mktime); 
            }   
            else
            {
                //非數字 且 數字 非 大於 等於 1 (年份不可以 小於 1 )
                //轉移回首頁
                header('Location: calendar.php');
            }

           
        }
        else
        {
            //代表使用者亂填寫參數
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
                <?php echo $current_year.' 年 '. $current_month.' 月 ';?>
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
                    //註:只有年份往前算 ，月份不用改變
                    calendar_table($month_day, $week_day);
            ?>
                   </table>
		</div>

		<?php include 'menu.php' ?>

	</body>
</html>

