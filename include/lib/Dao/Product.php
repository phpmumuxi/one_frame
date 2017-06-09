<?php
/**
 * 实验平台 - 逻辑处理
 *
 * @Author Hardy
 */
class Dao_Product
{
    /**
     * 获取所有   
     * @param $id  根据类型id获取所有产品
     * @param $t    0获取缓存分类，1重新查询
     * 
     */
    public static function getProductAll($id,$t = 0)
    {
        $cache = new Public_Cache('product');
        $cacheid = 'Dao_Product_getProductAll'.$id;
        $a = $cache->get($cacheid);
        if ($t == 1 || !$a) {            
            $db = Sys::getdb();
            $a = $db->fetchAll('select * from {{product}} where parent_id='.$id);                
            $cache->set($cacheid, $a);
        }
        return $a;
    }
    /**
     * 获取所有   
     * @param $id  根据类型id获取所有产品
     * @param $t    0获取缓存分类，1重新查询
     * 
     */
    public static function getCategoryAll($t = 0)
    {
        $cache = new Public_Cache('product');
        $cacheid = 'Dao_Product_getCategoryAll';
        $a = $cache->get($cacheid);
        if ($t == 1 || !$a) {            
            $db = Sys::getdb();
            $res=array();
            for($i=1;$i<6;$i++){
                $a1 = $db->fetchRow('select id,name from {{category}} where id='.$i);                
                $a2=$db->fetchAll('select id,name from {{product}} where parent_id='.$i.' order by id asc limit 3');
                $a1['child']=$a2;                
                $res[]=$a1;                
            } 
            $cache->set($cacheid, $res);
        }
        return $a;
    }
    
    /**
     * 获取  单个产品
     * @param type $id  ID
     * @param type $t  0获取，1重新生成
     */
    public static function get_info($id, $t = 0)
    {
        $cache = new Public_Cache('product');
        $cacheid = 'Dao_Product_get_info_' . $id;
        $a = $cache->get($cacheid);
        if ($t == 1 || !$a) {
            $db = Sys::getdb();
            $a = $db->fetchRow('select * from {{product}} where id=' . $id);
            $cache->set($cacheid, $a);
        }
        return $a;
    }
    
    /**
     * 获取  单个产品
     * @param type $id  ID
     * @param type $t  0获取，1重新生成
     */
    public static function get_category_parent($id, $t = 0)
    {
        $cache = new Public_Cache('product');
        $cacheid = 'Dao_Product_get_category_parent' . $id;
        $a = $cache->get($cacheid);
        if ($t == 1 || !$a) {
            $db = Sys::getdb();
            $a = $db->fetchRow('select name from {{category}} where id=' . $id);
            $cache->set($cacheid, $a);
        }
        return $a;
    }
    
     /**
     * 获取  单个产品
     * @param type $id  ID
     * @param type $t  0获取，1重新生成
     */
    public static function get_parent_info($id, $t = 0)
    {
        $cache = new Public_Cache('product');
        $cacheid = 'Dao_Product_get_parent_info_' . $id;
        $a = $cache->get($cacheid);
        if ($t == 1 || !$a) {
            $db = Sys::getdb();
            $a = $db->fetchRow('select * from {{category}} where id=' . $id);
            $cache->set($cacheid, $a);
        }
        return $a;
    }
   
    /**
     * 获取所有 推荐产品 （倒序）
     * @param $id  根据类型id获取所有产品 0随机推荐所有类型 1，根据具体类型推荐
     * @param $t    0获取缓存分类，1重新查询
     * 
     */
    public static function getHotProduct($id=0,$limit=4, $t = 1)
    {
        $cache = new Public_Cache('product');
        $cacheid = 'Dao_Product_getHotProduct'.$id;
        $a = $cache->get($cacheid);
        if ($t == 1 || !$a) {            
            $db = Sys::getdb();
            if($id===0){
               $a = $db->fetchAll('select * from {{product}} where is_tui =1 order by rand() limit '.$limit);
            }else{
               $a = $db->fetchAll('select * from {{product}} where parent_id ='.$id.' order by rand() limit '.$limit); 
            }                            
            $cache->set($cacheid, $a);
        }
        return $a;
    }
}
//end class