<?php
/**
 * 商品分类 - 逻辑处理
 *
 * @Author Hardy
 */
class Dao_Cat
{
    /**
     * 给用户加积分，推广人数累加
     * @param type $id 用户ID
     */
    public static function get_data($qk = 0)
    {
        $cache = new Public_Cache('setcat');
        $cacheid = 'Dao_Cat_get_data';
        $a = $cache->get($cacheid);
        if ($qk == 1 || empty($a)) {
            $db = Sys::getdb();
            $a = $db->fetchAll('select * from {{category}} order by sort asc');
            if (!empty($a)) {
                foreach ($a as $v) {
                    $child_ids = Dao_Site::get_child_ids($a, $v['id']);
                    $b = array('child_ids' => $child_ids);
                    $db->update('category', $b, array('id' => $v['id']));
                }
            }
            $cache->set($cacheid, $a);
        }
        return $a;
    }
}
//end class