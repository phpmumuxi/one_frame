<?php
/**
 * 广告 - 逻辑处理
 *
 * @Author Hardy
 */
class Dao_Ads
{
    //获取所有广告位
    public static function getCatAll()
    {
        $db = Sys::getdb();
        return $db->fetchAll('select * from {{ads_cat}}');
    }
    /**
     * 获取广告
     * @param $cid     广告类型ID
     * @param $islist  1获取所有广告，其它获取1条
     * @param $t       1重新生成
     */
    public static function get_ads($cid = 0, $islist = 0, $t = 0)
    {
        $cache = new Public_Cache('ads');
        $cacheid = 'Dao_Ads_get_ads' . $cid . $islist;
        $a = $cache->get($cacheid);
        if ($t == 1 || empty($a)) {
            $db = Sys::getdb();
            $sql = 'select a.*,b.width,b.height from {{ads_con}} a left join {{ads_cat}} b ' . 'on a.cat_id=b.id where a.cat_id=' . $cid . ' order by a.sort asc';
            if ($islist == 1) {
                $a = $db->fetchAll($sql);
            } else {
                $a = $db->fetchRow($sql . ' limit 1');
            }
            $cache->set($cacheid, $a);
        }
        return $a;
    }
}
//end class