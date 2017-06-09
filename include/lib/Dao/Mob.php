<?php
/**
 * 手机 - 逻辑处理
 *
 * @Author Hardy
 */
class Dao_Mob {
    
    /**
     * 手机首页
     * @param $cid     广告类型ID
     * @param $islist  1获取所有广告，其它获取1条
     * @param $t       1重新生成
     */
    public static function get_index($t=0) {
        $cache = new Public_Cache('mob'); $cacheid = 'Dao_Mob_get_index';
        $a = $cache->get( $cacheid );
        if ($t==1 || empty($a)) {
            $db = Sys::getdb(); $b = Dao_Art::getCatRow(0, 2); $a = array();
            foreach ($b as &$v) {
                if ($v['lx_id'] == 2) {                    
                    $s1 = 'select a.id,a.title,a.jump_url from {{art_con}} a where a.isshow=1 and a.cat_id in ('.$v['child_ids'].') and a.lx_id=2 order by rand() limit 16';
                    $v['qikan'] = Dao_Base::getArtUrl( $db->fetchAll( $s1 ) ); $a[] = $v;
                }
            }
            $cache->set($cacheid, $a);
        }
        return $a;
    }
    /**
     * 用户名称
     * @param $id  用户ID
     * @param $t       1重新生成
     */
    public static function get_manager_name($id=0,$t=0) {
        if(!$id) return;
        $cache = new Public_Cache('mob'); $cacheid = 'Dao_get_manager_name'.$id;
        $a = $cache->get( $cacheid );
        if ($t==1 || empty($a)) {
            $db = Sys::getdb();
            $a = $db->fetchOne('select nick from {{manager}} where id = '.$id);
            $cache->set($cacheid, $a);
        }
        return $a;
    } 

} //end class