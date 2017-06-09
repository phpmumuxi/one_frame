<?php
/**
 * 通用的树型类，可以生成任何树型结构
 *
 * @Author Hardy
 */
class Public_Tree
{
    public $arr = array();
    public $icon = array('&nbsp;│&nbsp;', '&nbsp;├──&nbsp;', '&nbsp;└──&nbsp;');
    //生成树型结构所需修饰符号
    public $nbsp = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    /**
     * 构造函数，初始化类
     * @param array 2维数组，例如：
     * array(
     *      1 => array('id'=>'1','parent_id'=>0,'name'=>'一级栏目一'),	
     *      3 => array('id'=>'2','parent_id'=>1,'name'=>'二级栏目二'),
     *      4 => array('id'=>'3','parent_id'=>2,'name'=>'二级栏目三'),
     *      )
     */
    function __construct($arr = array())
    {
        $this->arr = $arr;
    }
    /**
     * 得到父级数组
     * @param $fid 父级ID
     */
    public function get_parent($fid = 0)
    {
        $newarr = array();
        if (@is_array($this->arr) && !empty($this->arr)) {
            foreach ($this->arr as $v) {
                if ($v['id'] == $fid) {
                    $newarr[] = $v;
                    break;
                }
            }
        }
        return $newarr;
    }
    /**
     * 得到子级数组
     * @param $fid 父级ID
     */
    public function get_child($fid = 0)
    {
        $newarr = array();
        if (@is_array($this->arr) && !empty($this->arr)) {
            foreach ($this->arr as $v) {
                if ($v['parent_id'] == $fid) {
                    $newarr[] = $v;
                }
            }
        }
        return $newarr;
    }
    /**
     * 得到树型结构数组
     * @param int $fid 表示获得这个ID下的所有子级
     * @param string $nbsp 树形格式修饰字符串
     */
    public function get_tree($fid, $nbsp = '')
    {
        $child = $this->get_child($fid);
        $number = 1;
        $total = count($child);
        if (@is_array($child) && $total > 0) {
            foreach ($child as $v) {
                $j = $k = '';
                if ($number == $total) {
                    $j = $this->icon['2'];
                } else {
                    $j = $this->icon['1'];
                    $k = $nbsp ? $this->icon['0'] : '';
                }
                $v['nbsp'] = $nbsp ? $nbsp . $j : '';
                $this->tree_arr[] = $v;
                $this->get_tree($v['id'], $nbsp . $k . $this->nbsp);
                $number++;
            }
        }
        return isset($this->tree_arr) ? $this->tree_arr : array();
    }
}
//end class