<!--上下年 上下月的 menu按鈕-->
<div align="center">
<p style="font-size:40px;">
    <a href="count_year.php?prey=<?php echo $current_year.'&month='.$current_month."&d=".$current_day;?>"> << </a>
        <?php echo " ".$current_year." "."年 ";?>
    <a href="count_year.php?nexty=<?php echo $current_year.'&month='.$current_month."&d=".$current_day;?>">>></a>
    <!--月份的頁面 需連同 年份 一起進行處理，以免計算錯誤-->
    <a style="padding-left:10px;" href="count_month.php?prem=<?php echo $current_month."&year=".$current_year.'&d='.$current_day;?>"><</a>
        <?php echo " ".$current_month." "."月 ";?>
    <a href="count_month.php?nextm=<?php echo $current_month."&year=".$current_year."&d=".$current_day;?>">></a>
</p>	
</div>

<!--主頁 顯示當前日期 include menu.php 顯示值也是顯示當前日期

主頁 按下 上年 下年 顯示 count_year 頁面
->標題年份 , include menu.php 年份跟著更新


主頁 按下 上個月 下個月 顯示 count_month 頁面
->標題 月份 或 年份 , include menu.php 年份 或 月份跟著更新

-->
