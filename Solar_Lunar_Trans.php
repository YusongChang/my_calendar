<?php
    /**
     * 農曆 1900 - 2100 月份 壓縮數據
     * @ return Hex;
     * 1900年: 0x04bd8 -> 0100 1011 1101 1000 (1月份只有 29 天 故 補上 0 ，總共 16 位 2 進制)
     * 由左至右 每個月份 1 代表 30 天 ， 0 代表 29 天
     * 最後 4 位 2 進制 1000 代表 閏月 的月份 等於 8月
     * 註: 閏 8 月 為 29 天 故 為 0 需再 開頭 4位 0100 之前 再補 0000 (代表 閏 8 月 只有 29 天)
     * 故總共有 20 位 2 進制 來紀錄 月份資料 : 0000 0100 1011 1101 1000
     */
     $lunarData=[0x04bd8,0x04ae0,0x0a570,0x054d5,0x0d260,0x0d950,0x16554,0x056a0,0x09ad0,0x055d2,//1900-1909
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
    
    //設基準年 1900-1-31 (農曆 正月初 1)
    $startYear = 1900;
    $startMonth = 1;
    $starday = 31;
    //設公歷 普通月份天數表
    $solarData = [31,28,31,30,31,30,31,31,30,31,30,31];
    //設目前日期
    $curYear = 1901;
    $curMonth = 1;
    $curDay = 1;

    /**
    * 1900-1-31 ~ 指定日期的 1/1 日 前 有幾天
    * = 1900-1-31 ~ 1901-1/1  前 間隔幾天
    * 順便計算基準年到 指定日期 間隔 多少個農曆月份
    */
    //紀錄間隔幾天
    $gap_days = 0;

    for($y = $startYear; $y < $curYear; $y++)
    {
        for($m = 0; $m < 12; $m++)//12個月天數累加
        {   
            $gap_days += $solarData[$m];
            if(isGregorianLeapYear($y)) $gap_days++; //判斷 某公曆年是否是閏年，2月 為 28 + 1天
        }
       
    }

    $gap_days -= $starday - 1; //基準年 不是 從 1 日 開始 是從 31 日 開始算 故要扣掉 31 - 1 天

     //加上 指定日期 1 月 1 日 距離 指定日期的 月份的 第1日前 有幾天
     for($curm = 1 ; $curm < $curMonth; $curm ++ )
     {
         $gap_days += $solarData[$curm];
         if(isGregorianLeapYear($y)) $gap_days++;
     }
        
        $gap_days += $curDay - 1; //加上 從 指定日期的月份第1日  到 指定日期前 有幾天 (不是求共幾天喔!)

        //echo $gap_days;

     /** 驗算用:
      *  $basedate='1900-1-31';//參照日期
      *  $timezone='PRC';
      *  $datetime= new DateTime($basedate, new DateTimeZone('PRC'));
      *  $curTime=new DateTime('1901-1-1', new DateTimeZone('PRC'));
      *  $offset   = ($curTime->format('U') - $datetime->format('U'))/86400; //相差的天数
      *  $offset=ceil($offset);
      *  echo $offset;
      */

     
 
    function isGregorianLeapYear($year)
    {
        $isLeap = false;
        if ($year%4==0) $isLeap = true;
        if ($year%100==0) $isLeap = false;
        if ($year%400==0) $isLeap = true;
        return $isLeap;
    }


    /**
    * 計算 某 農曆年 共有幾個月
    */
    function monthsInLunarYear($y,$m)
    {
        $y - 1900;

        //壓縮數據最後 4 位 ，若計算 為 1 代表有閏月 一年有 13個月
        return $lunarData[$y] & 0xf ?　13 : 12;
    }


    /**
     * 計算某 公曆日期 1/1 是農曆 幾月 幾日
     */

?>