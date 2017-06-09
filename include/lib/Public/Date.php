<?php
/**
 * PHP - 时间处理函数
 *
 * @Author Hardy
 */
class Public_Date
{
    /** 
     * 获得指定年有多少周，每周从星期一开始， 
     * 如果最后一天在周四后（包括周四）算完整的一周，否则不计入当年的最后一周 
     * 如果第一天在周四前（包括周四）算完整的一周，否则不计入当年的第一周 
     * @param int $year 
     * return int 
     */
    public static function getWeek($year = 2015)
    {
        $year_start = mktime(0, 0, 0, 1, 1, $year);
        $year_end = mktime(0, 0, 0, 12, 31, $year);
        if (intval(date('W', $year_end)) === 1) {
            return date('W', strtotime('last week', $year_end));
        } else {
            return date('W', $year_end);
        }
    }
    /**
     * 根据指定日期判断是本月的第几个星期
     * @param type $date
     */
    public static function getMonthWeek($date = '2015-01-01')
    {
        $date_now = date('j', strtotime($date));
        //得到几号
        return ceil($date_now / 7);
    }
    //根据指定日期判断是这一年的第几周
    public static function getWeekNow($date = '2015-01-01')
    {
        $datearr = getdate(strtotime($date));
        $year = strtotime($datearr['year'] . '-1-1');
        $startdate = getdate($year);
        $firstweekday = 7 - $startdate['wday'];
        //获得第一周几天
        $yday = $datearr['yday'] + 1 - $firstweekday;
        //今年的第几天
        return ceil($yday / 7) + 1;
        //取到第几周
    }
    /**
     * PHP获取自然周的开始日期和结束日期
     * @param type $year      年份
     * @param type $weeknum   一年的第几个周
     * @return type
     */
    public static function getWeekDate($year = 2015, $weeknum = 1)
    {
        $firstdayofyear = mktime(0, 0, 0, 1, 1, $year);
        $firstweekday = date('N', $firstdayofyear);
        $firstweenum = date('W', $firstdayofyear);
        if ($firstweenum == 1) {
            $day = 1 - ($firstweekday - 1) + 7 * ($weeknum - 1);
            $startdate = date('Y-m-d', mktime(0, 0, 0, 1, $day, $year));
            $enddate = date('Y-m-d', mktime(0, 0, 0, 1, $day + 6, $year));
        } else {
            $day = 9 - $firstweekday + 7 * ($weeknum - 1);
            $startdate = date('Y-m-d', mktime(0, 0, 0, 1, $day, $year));
            $enddate = date('Y-m-d', mktime(0, 0, 0, 1, $day + 6, $year));
        }
        return array('start' => $startdate, 'end' => $enddate);
    }
    /**
     * 获取指定日期的第几天或后几天的[凌晨，结束]的时间戳
     * @param $t  0为当天，正数为第$t天，负数为前$t天
     * @param $end  0凌晨，否则为结束 
     * @Author Hardy
     */
    public static function getDayTime($date = '', $cur = 0, $end = 0)
    {
        if (empty($date)) {
            $t = strtotime(intval($cur) . ' day');
        } else {
            $t = strtotime($date) + intval($cur) * 86400;
        }
        if ($end == 0) {
            return mktime(0, 0, 0, date('m', $t), date('d', $t), date('Y', $t));
        } else {
            return mktime(23, 59, 59, date('m', $t), date('d', $t), date('Y', $t));
        }
    }
    /**
     * 时间转换函数
     * @param   int      $t    时间戳
     * @return  string  形如: 刚刚
     * @Author Hardy
     */
    public static function tran_time($t = 0)
    {
        $s = $dtime = date('Y-m-d H:i', $t);
        $rtime = date('m-d H:i', $t);
        $htime = date('H:i', $t);
        $kotime = time() - $t;
        if ($kotime < 60) {
            $s = $kotime . '秒前';
        } else {
            if ($kotime < 60 * 60) {
                $s = floor($kotime / 60) . '分钟前';
            } else {
                if ($kotime < 60 * 60 * 24) {
                    $s = floor($kotime / (60 * 60)) . '小时前' . $htime;
                } else {
                    if ($kotime < 60 * 60 * 24 * 3) {
                        $d = floor($kotime / (60 * 60 * 24));
                        if ($d == 1) {
                            $s = '昨天' . $rtime;
                        } else {
                            $s = '前天' . $rtime;
                        }
                    }
                }
            }
        }
        return $s;
    }
}
//end class