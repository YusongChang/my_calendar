<?php
    
     $gg = new Gregorian_Lunar();
    
     $gg-> _construct();

    class Gregorian_Lunar
    { 
        /**
        *變數定義區 
        */
        private $gap_days = 0;//紀錄間隔多少天
        //基準年為 公曆 1900 年 - 1 - 31 (1900 正月 初 1)
        private $startYear = 1900;
        private $startMonth = 1;
        private $startDay = 31;
        //指定日期 1901-1-1
        private $gregorianYear = 2018;
        private $gregorianMonth = 6;
        private $gregorianDay = 28;
        //建立公曆每月天數
        private $GregorianMonthsData =[31,28,31,30,31,30,31,31,30,31,30,31];
        //暫存農曆月份的天數
        private $tempdays = 0;
        //農曆月份個數
        private $monthsInLunarYear = 0;
        //指定日期的農曆月
        private $currenLunarMonth = 0;
        //指定日期的農曆日
        private $currenLunarDay = 0;
        //農曆壓縮數據
        //二進制 由左至右  1月 ~ 12月 ，1代表 30 天 , 0 代表 29 天
        //0100 1010 1110 0000
        //1000 0000 0000 0000
        private $lunarData = [0x04bd8,0x04ae0,0x0a570,0x054d5,0x0d260,0x0d950,0x16554,0x056a0,0x09ad0,0x055d2,//1900-1909
        0x04ae0,0x0a5b6,0x0a4d0,0x0d250,0x1d255,0x0b540,0x0d6a0,0x0ada2,0x095b0,0x14977,//1910-1919
        0x04970,0x0a4b0,0x0b4b5,0x06a50,0x06d40,0x1ab54,0x02b60,0x09570,0x052f2,0x04970,//1920-1929
        0x06566,0x0d4a0,0x0ea50,0x06e95,0x05ad0,0x02b60,0x186e3,0x092e0,0x1c8d7,0x0c950,//1930-1939
        0x0d4a0,0x1d8a6,0x0b550,0x056a0,0x1a5b4,0x025d0,0x092d0,0x0d2b2,0x0a950,0x0b557,//1940-1949
        0x06ca0,0x0b550,0x15355,0x04da0,0x0a5b0,0x14573,0x052b0,0x0a9a8,0x0e950,0x06aa0,//1950-1959
        0x0aea6,0x0ab50,0x04b60,0x0aae4,0x0a570,0x05260,0x0f263,0x0d950,0x05b57,0x056a0,//1960-1969
        0x096d0,0x04dd5,0x04ad0,0x0a4d0,0x0d4d4,0x0d250,0x0d558,0x0b540,0x0b6a0,0x195a6,//1970-1979
        0x095b0,0x049b0,0x0a974,0x0a4b0,0x0b27a,0x06a50,0x06d40,0x0af46,0x0ab60,0x09570,//1980-1989
        0x04af5,0x04970,0x064b0,0x074a3,0x0ea50,0x06b58,0x055c0,0x0ab60,0x096d5,0x092e0,//1990-1999
        0x0c960,0x0d954,0x0d4a0,0x0da50,0x07552,0x056a0,0x0abb7,0x025d0,0x092d0,0x0cab5,//2000-2009
        0x0a950,0x0b4a0,0x0baa4,0x0ad50,0x055d9,0x04ba0,0x0a5b0,0x15176,0x052b0,0x0a930,//2010-2019
        0x07954,0x06aa0,0x0ad50,0x05b52,0x04b60,0x0a6e6,0x0a4e0,0x0d260,0x0ea65,0x0d530,//2020-2029
        0x05aa0,0x076a3,0x096d0,0x04afb,0x04ad0,0x0a4d0,0x1d0b6,0x0d250,0x0d520,0x0dd45,//2030-2039
        0x0b5a0,0x056d0,0x055b2,0x049b0,0x0a577,0x0a4b0,0x0aa50,0x1b255,0x06d20,0x0ada0,//2040-2049
        /**Add By JJonline@JJonline.Cn**/
        0x14b63,0x09370,0x049f8,0x04970,0x064b0,0x168a6,0x0ea50, 0x06b20,0x1a6c4,0x0aae0,//2050-2059
        0x0a2e0,0x0d2e3,0x0c960,0x0d557,0x0d4a0,0x0da50,0x05d55,0x056a0,0x0a6d0,0x055d4,//2060-2069
        0x052d0,0x0a9b8,0x0a950,0x0b4a0,0x0b6a6,0x0ad50,0x055a0,0x0aba4,0x0a5b0,0x052b0,//2070-2079
        0x0b273,0x06930,0x07337,0x06aa0,0x0ad50,0x14b55,0x04b60,0x0a570,0x054e4,0x0d160,//2080-2089
        0x0e968,0x0d520,0x0daa0,0x16aa6,0x056d0,0x04ae0,0x0a9d4,0x0a2d0,0x0d150,0x0f252,//2090-2099
        0x0d520];


        /**
        *計算公曆 1900-1-31 到指定日期的 1月1日 前 間隔多少天 從 31 日算起 故 365-30天
        *順便計算農曆1900年有多少個月份
        */

        public function _construct()
        {
            $this->init();
        }

       /**
       * 將傳入的日期轉換農曆
       */
        public function init()
        {
            //驗證用 :
            $basedate='1900-1-31';//参照日期
            $timezone='PRC';
            $datetime= new DateTime($basedate, new DateTimeZone($timezone));
            $curTime=new DateTime('2018-6-28', new DateTimeZone($timezone));
            $offset   = ($curTime->format('U') - $datetime->format('U'))/86400; //相差的天数
            $offset=ceil($offset);
            echo '驗證間隔天數: '.$offset.'<br />';
            

            /*
            *計算 基準年到 指定日期 的 間隔天數
            */
            for($y = $this->startYear; $y < $this->gregorianYear; $y ++)
            {
                $this->gap_days += 365; //平年天數
                if($this->isGregorianLeapYear($y)) $this->gap_days++ ;//是閏年 故加多一天
               
                //計算農曆1900年~指定年前共 有多少個月份
                $this->monthsInLunarYear += $this->monthsInLunarYear($y);
                //計算農曆幾月幾日
             }
             
             $this->gap_days -= $this->startDay; // 從 31 日算起 故 減去 31  天(注意這是算間隔 不是總共幾天)
             echo  $this->gap_days.'---'. '$this->gap_days<br />';
            /**
            *從上方得到 "間隔多少天" 需再 + (指定日期 距離該年 1月1日 的天數)
            *指定日期 2月份 以上 才有能進入迴圈計算
            */
            for($m = $this->startMonth; $m < $this->gregorianMonth ; $m++)
            {
                //得到 基準年 1900-1-31 到 指定日期 過去多少天 
                $this->gap_days += $this->daysInGregorianMonth($this->gregorianYear,$m); 
                
            }
            echo  $m.'---'.$this->gap_days.'---'. '$this->gap_days<br />';
            //最後 + (指定日期 日) 就可得知從基準日期 到 指定日期的是第 幾 天了! ^_^
            $this->gap_days += ($this->gregorianDay - 1);
            echo  '---'.$this->gap_days.'---'. '$this->gap_days<br />';
            /**
            *計算 指定日期 是農曆 幾月 幾日
            *公歷年 間隔天數 - 農曆年間隔月份的天數 = 指定日期的 上一年 農曆 日 
            *註:間隔天數 一次減一個月的天數，直到小於農曆月的天數 則會變 負值 天數
            * 負值 天數 + 迴圈當前到達的農曆月的天數 = 農曆 幾月 幾日
            */

            for($y = $this->startYear; $y < $this->gregorianYear; $y ++)
            {   
                    $this->gap_days -= $this->daysInLunarYear($y);
            }
            echo  $this->gap_days.'---'. '$this->gap_days<br />';
             //公曆間隔天數 與 農曆年總天數 的差值 為負數
            //代表 還有 多少天 才到達 指定公曆年日期 的農曆 正月 1 日 
            if($this->gap_days < 0) //17-30 = -13
            {   
                $gap = $this->gap_days;

                $y--;//未到達指定日期的 農曆 正月 1 日 故尚未過年 QAQ

                //從上個農曆年的 最後 一個月 12月 開始 + 回去,求出 指定公曆年日期的農曆日期
                for($m = 12; $m > 1 && $gap < 0 ;$m--)
                {
                    $gap += $this->daysInLunarMonth($y,$m); 
                }
                //$gap > 0 代表 月份尚未超過 $m-- 月 上一年農曆尚未結束

                $m++; //將月份 + 1 補正回來

                $this->currenLunarDay =  $gap + 1;  // +1 就得到 當前的日子
                $this->currenLunarMonth = $m;
                
            }
            //公曆間隔天數 與 農曆年總天數 的差值 為正數
            //代表 的已經超過 該指定年的農曆 正月 1 日 的天數
            else if($this->gap_days > 0)
            { 
                $gap =$this->gap_days;
                //從頭減農曆月份天數值到為負數
               for($m = 1; $m < 12 && $gap > 0 ;$m++)
                {   
                    $temp = $this->daysInLunarMonth($y,$m);
                    $gap -= $temp; 
                }
                
                $m--;// $gap 為負數 代表 月份尚未到達 $m++ 月
                //差多少天 + 當前的月份天數 + 1= 指定年的農曆日
                $this->currenLunarDay =  ($gap + $temp)+1; 
                $this->currenLunarMonth = $m; 
            }
            //$this->ylDays=$offset;
            //此时$offset代表是农历该年的第多少天
            //$this->ylYeal=$i;//农历哪一年
            //计算月份，依次减去1~12月份的天数，直到offset小于下个月的天数
            /*$offset = 60;
            $curen = 29;
            for ($i=1; $i < 13 && $curen < $offset; ++$i){ 
                echo $i.'<br />';
               if(2==$i){ $i--;$offset-=29;}
            }
            */
            echo $y.'-'.$this->currenLunarMonth.'-'.$this->currenLunarDay;
            

        }
        //公歷閏年判斷
        public function isGregorianLeapYear($y)
        {
            if($y%4 == 0) return true;
            if($y%100 == 0) return false;
            if($y%400 == 0) return true;

            //輸入非數字
            return false;
        }
        
        /**
        *公歷月份天數
        */
        public function daysInGregorianMonth($y,$m)
        {
            //二月，需判斷閏年
            if($m == 2) {

                //若成立就 返回 29 天;
                if($this->isGregorianLeapYear($y))  
                {
                    $days = $this->GregorianMonthsData[$m-1]+1;
                }

                else $days =$this->GregorianMonthsData[$m-1];
            }
            else
            {   //一般月份天數
                $days = $this->GregorianMonthsData[$m-1]; 
            }

            return $days;
        }

        //農曆年 有無 閏月 判斷
        public function isLunarLeapYear($y)
        {
            $y -= $this->startYear;

            return $this->lunarData[$y] & 0xf ? true : false;
        }


        public function daysInLunarMonth($y,$m)
        {
            //指定年 - 基準年 = 陣列索引值
            //Ex. 1901 -1900 = 1
            $y -= $this->startYear;
            //基準年 二進制 表示 :  0001 0100 1011 1101 1000
            $count = 0x8000; //1000 0000 0000 0000 用以判斷 月份的天數
            
            //取出指定用月份的天數
            $lunarDays = 0;
            for($i=0; $i < $m && $count > 0x8 ; $i++) 
            {   
                // 1 代表 30天 為 true，0 代表 29 天 為 false 
                $lunarDays = $count & $this->lunarData[$y] ? 30 : 29;
                $count >>= 1;
            }

            return $lunarDays;
        }

        public function monthsInLunarYear($y)
        {
            //指定年 - 基準年 = 陣列索引值
            //Ex. 1901 -1900 = 1
           
            $y = $y - $this->startYear;

            //有閏月則回傳 13 個月 反之 12 個月
            return ($this->lunarData[$y] & 0xf) ? 13 : 12;     
        }

        //農曆年總天數
        public function daysInLunarYear($y)
        {
            
            $baseY = $this->startYear;
            //取得陣列 對應 指定年的 索引值
            $year = $y - $baseY;
            //建立基準天數 
            $lunarYearDays = 348; // 暫時不計 閏月 和大小月 12 * 29 = 348

            //判斷閏月存在 需多加 一個月份天數 ，
            if($this->isLunarLeapYear($y)) 
            {    // 0x10000 -> 1 0000 0000 0000 0000 17 位二進制
                //開頭 1 0000 用以判斷 代表閏月的大小 
                // 1 代表 30天 為 true，0 代表 29 天
                $lunarYearDays+=($this->lunarData[$year] & 0x10000)? 30 : 29;
            }
            //計算有幾個 大月 為了 + 回 大月所差的 1 天
            //基準年 二進制 表示 :  10100101111011000
             //1000 0000 0000 0000 用以判斷 月份的天數
             //100 1011 1101 1000
            for($i=0x8000; $i > 0x8 ; $i >>= 1) 
            {   
                // 1 代表 30天 為 true，0 代表 29 天 為 false 
                $lunarYearDays += ($i & $this->lunarData[$year]) ? 1 : 0;
            }

            return $lunarYearDays;
        }

        //間隔天數 +1 日 才會到達 指定日期 的 日 !
        //$gap_days + 1 ;

    }
?>