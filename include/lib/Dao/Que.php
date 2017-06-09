<?php
/**
 * 新闻 - 逻辑处理
 *
 * @Author Hardy
 */
class Dao_Que
{    
    
    /**
     * 获取所有  新闻 
     * @param $t    0获取缓存分类，1重新查询
     * @param $id    
     */
    public static function getTuiAll($id=0,$t = 1)
    {
        $cache = new Public_Cache('Que');
        $cacheid = 'Dao_Que_getTuiAll'.$id;
        $a = $cache->get($cacheid);
        if ($t == 1 || !$a) {            
            $db = Sys::getdb();
            if($id === 0){
                $a = $db->fetchAll('select * from {{question}} where status =1 order by rand() limit 6'); 
            }else{
                $a= $db->fetchAll('select * from {{question}} where status=1 and type_id='.$id.' order by rand() limit 5');
            }                          
                            
            $cache->set($cacheid, $a);
        }
        return $a;
    }
    /**
     * 获取  单个新闻
     * @param type $id  新闻ID
     * @param type $t  0获取，1重新生成
     */
    public static function get_info($id , $t = 0)
    {
        $cache = new Public_Cache('Que');
        $cacheid = 'Dao_Que_get_info_' . $id;
        $a = $cache->get($cacheid);
        if ($t == 1 || !$a) {
            $db = Sys::getdb();
            $a = $db->fetchAll('select * from {{question}} where type_id=' . $id);
            $cache->set($cacheid, $a);
        }
        return $a;
    }
   //根据type_id获取分类名
    public static function get_type_name($id , $t = 0)
    {
        $cache = new Public_Cache('Que');
        $cacheid = 'Dao_Que_get_type_name_' . $id;
        $a = $cache->get($cacheid);
        if ($t == 1 || !$a) {
            $db = Sys::getdb();
            $a = $db->fetchRow('select name from {{category}} where id=' . $id);
            $cache->set($cacheid, $a);
        }
        return $a;
    }
   
    
}
//end class