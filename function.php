<?php
    function calendar_table($month_day,$week_day,$curren_day)
    {
        
		//1號 小於當月的天數 $month_day 就循環幾次
		for($day=1;$day<=$month_day;)
		{	
		    echo "<tr style='font-size:50px'>";//執行外層迴圈依次就會產生一列

			//處理當月 1 號擺放位置，其他跟在後面加上去，
			//一列放置七日故要執行七次
            for($i=1;$i<=7;$i++)
            {
				//$i 比 week_day 多 1天
				//檢查 $day <= $month_day 確保在執行七次之中不被多加天數
				//以及( 星期 $week_day  是否小於 $i 或是 $day 天數 不等於 1) 才能成立  
				// $week_day < $i 每個月遍歷天數時只會用到 1 次，處理 初 1 星期幾
				if($day <= $month_day && ($day >1 || $week_day < $i))
                { // 成立，表示 $day 可以放入月曆當前的一列之中
					
					//如是今日則 highlight
					echo $day == $curren_day ? "<th><a href='javascript:void(0);' id='{$day}' style='color:white;'"
											: "<th><a href='javascript:void(0);' id='{$day}'";
					//星期日 要變紅色 						
					echo $i == 1 ? "style='color:red;'>".$day : ">". $day;
					echo "</a></th>"; 
					$day++;//天數+1
				}
				else
				{
                   	//不成立則印出空位
                    echo '<th></th>';
				}
			}

	    	echo '</tr>';
        }
				
	}
	//計算 當前年份,月份 往前 或 往後 需顯示的日期
	function pre_or_next ($year,$month){
		
	}
?>