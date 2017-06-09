<?php
/**
 * 新闻 - 逻辑处理
 *
 * @Author Hardy
 */
class Dao_News
{    
    /**
     * 获取所有  新闻 
     * @param $t    0获取缓存分类，1重新查询
     * @param $p     根据ID获取文章列表或详情
     */
    public static function getCategoryAll($p,$t = 0)
    {
        $cache = new Public_Cache('news');
        $cacheid = 'Dao_News_getCategoryAll'.$p;
        $a = $cache->get($cacheid);
        if ($t == 1 || !$a) {            
            $db = Sys::getdb();
            $a=$db->fetchAll('select id,name from {{category}} where parent_id='.$p);                     
            $cache->set($cacheid, $a);
        }
        return $a;
    }
    /**
     * 获取所有  新闻 
     * @param $t    0获取缓存分类，1重新查询
     * @param $id    
     */
    public static function getTuiAll($id=0,$t = 0)
    {
        $cache = new Public_Cache('news');
        $cacheid = 'Dao_News_getTuiAll'.$id;
        $a = $cache->get($cacheid);
        if ($t == 1 || !$a) {            
            $db = Sys::getdb();
            if($id === 0){
                $a = $db->fetchAll('select * from {{news}} where is_tui =1 order by rand() limit 4'); 
            }else{
                $a= $db->fetchAll('select * from {{news}} where is_tui=1 and parent_id='.$id.' order by rand() limit 3');
            }                          
                            
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
        public static function getNewsAll($id,$t = 0)
    {
        $cache = new Public_Cache('news');
        $cacheid = 'Dao_News_getNewsAll'.$id;
        $a = $cache->get($cacheid);
        if ($t == 1 || !$a) {            
            $db = Sys::getdb();
            $data = $db->fetchRow('select parent_id from {{category}} where id='.$id);                
            $a= $db->fetchAll('select id,name from {{category}} where parent_id='.$data['parent_id']);                
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
        $cache = new Public_Cache('news');
        $cacheid = 'Dao_News_get_info_'.$id;
        $a = $cache->get($cacheid);
        if ($t == 1 || !$a) {
            $db = Sys::getdb();
            $a = $db->fetchRow('select * from {{news}} where id='.$id);            
            $cache->set($cacheid, $a);
        }
        return $a;
    }
  //获取热 门 资 讯
    public static function get_art_info($t = 0)
    {
        $cache = new Public_Cache('news');
        $cacheid = 'Dao_News_get_art_info_';
        $a = $cache->get($cacheid);
        if ($t == 1 || !$a) {
            $db = Sys::getdb();
            $a = $db->fetchRow('select * from {{news}} where parent_id=18 and is_tui=1 limit 9');
            $cache->set($cacheid, $a);
        }
        return $a;
    }
   /**
     * 获取  单个新闻
     * @param type $id  新闻ID
     * @param type $t  0获取，1重新生成
     */
    public static function parent_info($id , $t = 0)
    {
        $cache = new Public_Cache('news');
        $cacheid = 'Dao_News_parent_info'.$id;
        $a = $cache->get($cacheid);
        if ($t == 1 || !$a) {
            $db = Sys::getdb();
            $a=array();
            $data=$db->fetchRow('select id,name,parent_id from {{category}}  where type=2 and id='.$id);            
            $a[]=array('id'=>$data['id'],'name'=>$data['name']);         
            $data1= $db->fetchRow('select id,name from {{category}}  where type=2 and id='.$data['parent_id']);
            $a[]= array('id'=>$data1['id'],'name'=>$data1['name']);          
            $cache->set($cacheid, $a);
        }
        return $a;
    }
    
    public static function getAllArts($id,$t = 1)
    {
        $cache = new Public_Cache('news');
        $cacheid = 'Dao_News_getAllArts'.$id;
        $a = $cache->get($cacheid);
        if ($t == 1 || !$a) {            
            $db = Sys::getdb();
            $arrs=$db->fetchAll('select * from {{category}}');
            $data=Dao_Site::get_child_ids($arrs,$id);                                   
            $arr= $db->fetchAll('select id,title,parent_id from {{news}} where parent_id in('.$data.') order by rand() limit 4'); 
            $a=array();
            foreach ($arr as $k => $v) {                
                $datas=$db->fetchRow('select id,name from {{category}}  where type=2 and id='.$v['parent_id']); 
                $v['child']=array('id'=>$datas['id'],'name'=>$datas['name']);
                $a[]=$v;
            }
            $cache->set($cacheid, $a);
        }
        return $a;
    }
    
    public static function getTuiArt($id,$t = 0)
    {
        $cache = new Public_Cache('news');
        $cacheid = 'Dao_News_getTuiArt'.$id;
        $a = $cache->get($cacheid);
        if ($t == 1 || !$a) {            
            $db = Sys::getdb();
            $arrs=$db->fetchAll('select * from {{category}}');
            $data=Dao_Site::get_child_ids($arrs,$id);                                   
            $arr= $db->fetchAll('select id,title,parent_id from {{news}} where parent_id in('.$data.') and is_tui=1 limit=7 '); 
            $a=array();
            foreach ($arr as $k => $v) {                
                $datas=$db->fetchRow('select id,name from {{category}}  where type=2 and id='.$v['parent_id']); 
                $v['child']=array('id'=>$datas['id'],'name'=>$datas['name']);
                $a[]=$v;
            }
            $cache->set($cacheid, $a);
        }
        return $a;
    }
    
}
//end class