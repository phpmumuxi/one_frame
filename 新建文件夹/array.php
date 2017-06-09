<?php
$arr=array(    
    1=>array('id'=>'1','name'=>'北京','pid'=>'0'),    
    2=>array('id'=>'2','name'=>'上海','pid'=>'0'),    
    3=>array('id'=>'3','name'=>'浦东','pid'=>'2'),    
    4=>array('id'=>'4','name'=>'朝阳','pid'=>'1'),    
    5=>array('id'=>'5','name'=>'广州','pid'=>'0'),    
    6=>array('id'=>'6','name'=>'三里屯','pid'=>'4'),   
    7=>array('id'=>'7','name'=>'广东','pid'=>'5'),   
    8=>array('id'=>'8','name'=>'三里','pid'=>'4'),  
    10=>array('id'=>'10','name'=>'小胡同','pid'=>'8')  
    ); 

    function generateTree($items){  
        $tree = array();  
        foreach($items as $item){  
            //判断是否有数组的索引==  
            if(isset($items[$item['pid']])){     //查找数组里面是否有该分类  如 isset($items[0])  isset($items[1])  
                $items[$item['pid']]['son'][] = &$items[$item['id']]; //上面的内容变化,$tree里面的值就变化  
            }else{  
                $tree[] = &$items[$item['id']];   //把他的地址给了$tree  
            }    
        }  
        return $tree;  
    }     

    //print_r(generateTree($arr));
   //print_r(array_column($arr,'id'));
//上面这个程序有一个主要问题，数组的索引是我们手动添加的？那我们可不可以自动添加数组索引呢？当然可以,下面这个程序就实现了，自动为数组添加索引然后再把子栏目放到父栏目的son数组中，思想和上面的程序是一样的
    function make_tree($list,$pk='id',$pid='pid',$child='_child',$root=0){  
        $tree=array();   
        $packData=array();  
        foreach ($list as  $data) { 
            //转换为带有主键id的数组  
            $packData[$data[$pk]] = $data; //$packData[1]=$data; $packData[2]=$data   
        }  
        foreach ($packData as $key =>$val){       
            if($val[$pid]==$root){   //代表跟节点         
                $tree[]=& $packData[$key];  
            }else{  
                //找到其父类  
                $packData[$val[$pid]][$child][]=& $packData[$key];  
            }  
        }  
        return $tree;  
    }  