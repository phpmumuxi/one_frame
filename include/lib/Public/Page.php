<?php
/**
 * 牛逼的数据库查询分页
 *
 * @Version： V11.0.1
 * @Author：  Hardy
 */
class Public_Page
{
    private $s1, $s2, $sqlcc;
    private $pageNum, $totalCount, $pageCount;
    private $pageSize, $showNum, $db, $db_arr;
    public $url_tp = 1;
    //地址类型：1/，2=，3js方法,4蜘蛛ajax方法，5同时使用$pageUrl和$param
    public $pageUrl;
    //页面地址：上面参数为3时，这个参数是js方法名称
    public $param = array();
    //页面参数   分页参数是P
    public $boxSize = 40;
    //分页框大小
    /**
     * 初始化
     * 
     * @param $s1 SQL语句，from之前的
     * @param $s2 SQL语句，from之后的
     * @param $pageNum 当前第几页
     * @param $pageSize 每页显示几条记录
     * @param $db_arr sql语句参数，如( array(':name'=>'得得得') )
     * @param $sqlcc 查询总记录的属性默认是 1，也可以是 * 或 DISTINCT(name)
     * @param $showNum 显示几个页码
     * @param $maxtotalCount 最多查询多少条数据
     */
    public function __construct($s1, $s2, $pageNum = 1, $pageSize = 15, $db_arr = array(), $sqlcc = '1', $showNum = 7, $maxtotalCount = 0)
    {
        $this->s1 = $s1;
        $this->s2 = $s2;
        $this->sqlcc = $sqlcc;
        $this->db_arr = $db_arr;
        $pageNum = !is_numeric($pageNum) || $pageNum < 1 ? 1 : $pageNum;
        $pageSize = !is_numeric($pageSize) || $pageSize < 1 ? 15 : $pageSize;
        $this->pageSize = $pageSize > 200 ? 200 : $pageSize;
        $showNum = !is_numeric($showNum) || $showNum < 3 ? 3 : $showNum;
        $showNum = $showNum > 30 ? 30 : $showNum;
        $this->showNum = $showNum % 2 == 0 ? $showNum + 1 : $showNum;
        $this->db = Sys::getdb();
        $this->totalCount = $this->getTotalCount();
        if ($maxtotalCount > 0 && $this->totalCount > $maxtotalCount) {
            $this->totalCount = $maxtotalCount;
        }
        $this->pageCount = ceil($this->totalCount / $this->pageSize);
        $this->pageNum = $pageNum > $this->pageCount ? $this->pageCount : $pageNum;
    }
    //查询总记录
    public function getTotalCount()
    {
        if ($this->totalCount > 0) {
            return $this->totalCount;
        }
        $s = preg_replace('/(order by.+[asc|desc])$/', '', strtolower($this->s2));
        $s = 'select count(' . $this->sqlcc . ') ' . $s;
        return intval($this->db->fetchOne($s, $this->db_arr));
    }
    /**
     * 查询数据
     * @param $t  0不加密，1加密
     */
    public function getItems($t = 0)
    {
        if ($this->totalCount < 1) {
            return array();
        }
        $s = $this->s1 . ' ' . $this->s2 . ' limit ' . ($this->pageNum - 1) * $this->pageSize . ', ' . $this->pageSize;
        $a = $this->db->fetchAll($s, $this->db_arr);
        if ($t == 1) {
            return base64_encode($a);
        }
        return $a;
    }
    //获取去除page部分的当前URL字符串
    private function getUrl()
    {
        $s = '';
        if ($this->url_tp == 5) {
            $s = $this->pageUrl;
            if (!empty($this->param)) {
                foreach ($this->param as $k => $v) {
                    if ($v != '') {
                        $s .= '/' . $k . '/' . $v;
                    }
                }
            }
            $s .= '/p/';
        } elseif ($this->url_tp == 3) {
            if (!empty($this->param)) {
                foreach ($this->param as $v) {
                    $s .= "'" . $v . "'" . ',';
                }
            }
            $s = 'javascript:;" onclick="' . $this->pageUrl . '(' . $s;
        } else {
            $s = preg_replace('/\\/$/', '', $_SERVER['REQUEST_URI']);
            if ($this->url_tp == 1) {
                if (preg_match('/\\/p\\/' . $this->pageNum . '/', $s)) {
                    $s = preg_replace('/\\/p\\/' . $this->pageNum . '/', '', $s);
                }
                $s .= '/p/';
            } elseif ($this->url_tp == 2) {
                if (preg_match('/\\?/', $s)) {
                    if (preg_match('/&p=' . $this->pageNum . '/', $s)) {
                        $s = preg_replace('/&p=' . $this->pageNum . '/', '', $s) . '&p=';
                    } else {
                        $s .= '&p=';
                    }
                } else {
                    $s .= '?p=';
                }
            }
        }
        return $s;
    }
    //获取分页地址
    private function getPageUrl($p)
    {
        if ($this->url_tp == 4) {
            return str_replace('[?]', $p, $this->pageUrl);
        } else {
            return $this->getUrl() . ($this->url_tp == 3 ? "'" . $p . "')" : $p);
        }
    }
    //获取分页数组
    public function getPageArr()
    {
        //初始值
        $a['url'] = $this->getPageUrl('');
        $a['first'] = $this->getPageUrl(1);
        $a['previous'] = $this->pageNum == 1?$this->getPageUrl(1):$this->getPageUrl($this->pageNum - 1);
        $a['next'] = $this->getPageUrl($this->pageNum + 1);
        $a['last'] = $this->getPageUrl($this->pageCount);
        $a['current'] = $this->pageNum;
        $a['pageCount'] = $this->pageCount;
        $a['itemCount'] = $this->totalCount;
        $a['pageSize'] = $this->pageSize;
        $a['page'] = array();
        if ($this->totalCount > 0) {
            if ($this->pageCount <= $this->showNum) {
                for ($i = 1; $i <= $this->pageCount; $i++) {
                    $a['page'][] = $i;
                }
            } else {
                if ($this->pageNum < $this->showNum) {
                    for ($i = 1; $i <= $this->showNum; $i++) {
                        $a['page'][] = $i;
                    }
                    $a['page'][] = '...';
                    $a['page'][] = $this->pageCount;
                } elseif ($this->pageNum >= $this->showNum && $this->pageCount + 2 - $this->pageNum > $this->showNum) {
                    $a['page'][] = 1;
                    $a['page'][] = '...';
                    $aa = floor($this->showNum / 2);
                    for ($i = $this->pageNum - $aa; $i <= $this->pageNum + $aa; $i++) {
                        $a['page'][] = $i;
                    }
                    $a['page'][] = '...';
                    $a['page'][] = $this->pageCount;
                } elseif ($this->pageCount + 1 - $this->pageNum < $this->showNum) {
                    $a['page'][] = 1;
                    $a['page'][] = '...';
                    for ($i = $this->pageCount - ($this->showNum - 1); $i <= $this->pageCount; $i++) {
                        $a['page'][] = $i;
                    }
                }
            }
        }
        return $a;
    }
    /**
     * 获取分页字符串
     * @param $style 1要样式，0不要样式
     * @param $t  0不加密，1加密
     */
    public function getPageStr($style = 1, $t = 0)
    {
        $s = '';
        if ($style == 1) {
            $s .= '<style>.ko_public_pagination{line-height:' . $this->boxSize . 'px;text-align:center;font-size:12px;font-family:Arial,Helvetica,sans-serif,"宋体";}' . '.ko_public_pagination ul{display:inline-block;*display:inline;margin-top:40px;margin-bottom:10px;margin-left:0;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;*zoom:1;-webkit-box-shadow:0 1px 2px rgba(0, 0, 0, 0.05);-moz-box-shadow:0 1px 2px rgba(0, 0, 0, 0.05);box-shadow:0 1px 2px rgba(0, 0, 0, 0.05);}';
            if ($this->totalCount > 0) {
                $s .= '.ko_public_pagination li{display:inline;}' . '.ko_public_pagination a{float:left;padding:0 ' . (($this->boxSize - 2) / 2 - 3) . 'px;color:#333;background:#fff;line-height:' . ($this->boxSize - 2) . 'px;text-decoration:none;border:1px solid #ddd;border-left-width:0;_border-width:1px;}' . '.ko_public_pagination a:hover,.ko_public_pagination .li_active a{background-color:#f5f5f5;color:#f60;}' . '.ko_public_pagination .li_active a{color:#999;cursor:default;}' . '.ko_public_pagination .disabled span,.ko_public_pagination .disabled a,.ko_public_pagination .disabled a:hover{color:#999;cursor:default;background-color:#fff;}' . '.ko_public_pagination li:first-child a{border-left-width:1px;background:#fff;-webkit-border-radius:3px 0 0 3px;-moz-border-radius:3px 0 0 3px;border-radius:3px 0 0 3px;}' . '.ko_public_pagination li:last-child a{-webkit-border-radius:0 3px 3px 0;-moz-border-radius:0 3px 3px 0;border-radius:0 3px 3px 0;}';
            }
            $s .= '</style>';
        }
        $s .= '<div class="ko_public_pagination">';
        if ($this->totalCount < 1) {
            $s .= '暂无相关记录';
        } else {
            $s .= '<ul>';
            if ($this->pageNum == 1) {
                $s .= '<li class="disabled"><a rel="nofollow" title="上一页">«</a></li>';
            } else {
                $s .= '<li><a href="' . $this->getPageUrl($this->pageNum - 1) . '" rel="nofollow" title="上一页">«</a></li>';
            }
            if ($this->pageCount <= $this->showNum) {
                for ($i = 1; $i <= $this->pageCount; $i++) {
                    if ($i == $this->pageNum) {
                        $s .= '<li class="li_active"><a rel="nofollow">' . $i . '</a></li>';
                    } else {
                        $s .= '<li><a href="' . $this->getPageUrl($i) . '" rel="nofollow">' . $i . '</a></li>';
                    }
                }
            } else {
                if ($this->pageNum < $this->showNum) {
                    for ($i = 1; $i <= $this->showNum; $i++) {
                        if ($i == $this->pageNum) {
                            $s .= '<li class="li_active"><a rel="nofollow">' . $i . '</a></li>';
                        } else {
                            $s .= '<li><a href="' . $this->getPageUrl($i) . '" rel="nofollow">' . $i . '</a></li>';
                        }
                    }
                    $s .= '<li class="disabled"><a>...</a></li>';
                    $s .= '<li><a href="' . $this->getPageUrl($this->pageCount) . '" rel="nofollow">' . $this->pageCount . '</a></li>';
                } elseif ($this->pageNum >= $this->showNum && $this->pageCount + 2 - $this->pageNum > $this->showNum) {
                    $s .= '<li><a href="' . $this->getPageUrl(1) . '" rel="nofollow">1</a></li>';
                    $s .= '<li class="disabled"><a>...</a></li>';
                    $aa = floor($this->showNum / 2);
                    for ($i = $this->pageNum - $aa; $i <= $this->pageNum + $aa; $i++) {
                        if ($i == $this->pageNum) {
                            $s .= '<li class="li_active"><a rel="nofollow">' . $i . '</a></li>';
                        } else {
                            $s .= '<li><a href="' . $this->getPageUrl($i) . '" rel="nofollow">' . $i . '</a></li>';
                        }
                    }
                    $s .= '<li class="disabled"><a>...</a></li>';
                    $s .= '<li><a href="' . $this->getPageUrl($this->pageCount) . '" rel="nofollow">' . $this->pageCount . '</a></li>';
                } elseif ($this->pageCount + 1 - $this->pageNum < $this->showNum) {
                    $s .= '<li><a href="' . $this->getPageUrl(1) . '" rel="nofollow">1</a></li>';
                    $s .= '<li class="disabled"><a>...</a></li>';
                    for ($i = $this->pageCount - ($this->showNum - 1); $i <= $this->pageCount; $i++) {
                        if ($i == $this->pageNum) {
                            $s .= '<li class="li_active"><a rel="nofollow">' . $i . '</a></li>';
                        } else {
                            $s .= '<li><a href="' . $this->getPageUrl($i) . '" rel="nofollow">' . $i . '</a></li>';
                        }
                    }
                }
            }
            if ($this->pageNum == $this->pageCount) {
                $s .= '<li class="disabled"><a rel="nofollow" title="下一页">»</a></li>';
            } else {
                $s .= '<li><a href="' . $this->getPageUrl($this->pageNum + 1) . '" rel="nofollow" title="下一页">»</a></li>';
            }
            $s .= '</ul>';
        }
        $s .= '</div>';
        if ($t == 1) {
            return base64_encode($s);
        }
        return $s;
    }
}
//end class