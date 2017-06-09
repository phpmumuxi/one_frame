<?php
/**
 * PHP：PDO 连接 MYSQL 类
 *
 * 使用PDO的注意事项
 * 1.  php升级到5.3.6+，生产环境强烈建议升级到php 5.3.9+ php 5.4+，php 5.3.8存在致命的hash碰撞漏洞。
 * 2. 若使用php 5.3.6+, 请在在PDO的DSN中指定charset属性
 * 3. 如果使用了PHP 5.3.6及以前版本，设置PDO::ATTR_EMULATE_PREPARES参数为false（即由MySQL进行变量处理），
 *	  php 5.3.6以上版本已经处理了这个问题，无论是使用本地模拟prepare还是调用mysql server的prepare均可。
 *	  在DSN中指定charset是无效的，同时set names <charset>的执行是必不可少的。
 * 
 * @Author: Hardy
 */
class Public_PdoMysql
{
    private $db = null;
    private $prefix = '';
    //构造函数
    function __construct($a = array())
    {
        $dbtype = isset($a['dbtype']) ? $a['dbtype'] : 'mysql';
        $dbhost = isset($a['dbhost']) ? $a['dbhost'] : 'localhost';
        $dbport = isset($a['dbport']) ? $a['dbport'] : '3306';
        $dbname = isset($a['dbname']) ? $a['dbname'] : 'qikan';
        $dbuser = isset($a['dbuser']) ? $a['dbuser'] : 'root';
        $dbpass = isset($a['dbpass']) ? $a['dbpass'] : '1';
        $charset = isset($a['charset']) ? $a['charset'] : 'UTF8';
        $this->prefix = isset($a['prefix']) ? $a['prefix'] : 'ko_';
        try {
            $dsn = $dbtype . ':host=' . $dbhost . ';port=' . $dbport . ';dbname=' . $dbname . ';charset=' . $charset;
            $this->db = new PDO($dsn, $dbuser, $dbpass);
        } catch (PDOException $e) {
            die('Connect Error :' . $e->getMessage());
        }
        //禁用prepared statements的仿真效果，禁用模拟预处理语句
        $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        //设置数据编码
        $this->db->exec('SET NAMES ' . $charset);
    }
    //析构函数
    function __destruct()
    {
        $this->db = null;
    }
    //处理一条SQL语句，并返回所影响的条目数
    public function query($s)
    {
        $r = $this->db->query($this->sql_qz($s));
        $this->getError($s);
        return $r;
    }
    /**
     * 添加
     * @param $t 表名
     * @param $a 要修改的信息 如：array('name'=>'测试') 其中name必须是字段名
     * @return 返回操作后影响的行数
     */
    public function insert($t, $a = array())
    {
        $b = $this->getCode($a, 1);
        return $this->_fetch('INSERT INTO `' . $this->table_qz($t) . '` SET ' . $b['0'], $b['1'], 4);
    }
    //获得最后INSERT的主鍵ID
    public function getlastInsertId()
    {
        return $this->db->lastInsertId();
    }
    /**
     * 修改
     * @param $t 表名
     * @param $a 要修改的信息 如：array('name'=>'测试') 其中name必须是字段名
     * @param $w 参数 如：array('id'=>5) 其中id必须是字段名
     * @return 返回操作后影响的行数
     */
    public function update($t, $a = array(), $w = array())
    {
        $b = $this->getCode($a, 1);
        $c = $this->getCode($w);
        return $this->_fetch('UPDATE `' . $this->table_qz($t) . '` SET ' . $b['0'] . ' WHERE ' . $c['0'], array_merge($b['1'], $c['1']), 4);
    }
    /**
     * 刪除
     * @param $t 表名
     * @param $w 参数 如：array('id'=>5) 其中id必须是字段名
     * @return 返回操作后影响的行数
     */
    public function delete($t, $w = array())
    {
        $c = $this->getCode($w);
        return $this->_fetch('DELETE FROM `' . $this->table_qz($t) . '` WHERE ' . $c['0'], $c['1'], 4);
    }
    /**
     * 查询总记录数
     * @param $t 表名
     * @param $w 参数 如：array('id'=>5) 其中id必须是字段名
     * @return 返回查询结果正整数
     */
    public function fetchCvn($t, $w = array())
    {
        $c = $this->getCode($w);
        if (empty($c)) {
            return intval($this->fetchOne('SELECT COUNT(1) FROM `' . $this->table_qz($t) . '`'));
        } else {
            return intval($this->fetchOne('SELECT COUNT(1) FROM `' . $this->table_qz($t) . '` WHERE ' . $c['0'], $c['1']));
        }
    }
    //获取首行首列数据
    public function fetchOne($s, $p = array())
    {
        return $this->_fetch($this->sql_qz($s), $p, 1);
    }
    //获取單行数据(返回表內第一条記录)
    public function fetchRow($s, $p = array())
    {
        return $this->_fetch($this->sql_qz($s), $p, 2);
    }
    //获取所有数据
    public function fetchAll($s, $p = array())
    {
        return $this->_fetch($this->sql_qz($s), $p, 3);       
    }
    //执行具体SQL操作
    private function _fetch($s, $p = array(), $t)
    {
        $r = array();
        $stmt = $this->db->prepare($s);
        $this->getError($s);
        $res = $stmt->execute($p);
        if ($res) {
            switch ($t) {
                case 1:
                    $r = $stmt->fetchColumn(0);
                    break;
                case 2:
                    $r = $stmt->fetch(PDO::FETCH_ASSOC);
                    break;
                case 3:
                    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    break;
                case 4:
                    $r = $stmt->rowCount();
                    break;
            }
        }
        return $r;
    }
    /**
     * PDO中的事务处理示列
    try {
    	$this->db->beginTransaction();
    	$this->db->exec("INSERT INTO `test`.`table` (`name` ,`age`)VALUES ('mick', 22);");
    	$this->db->commit();	
    } catch(Exception $e) {
    	$this->db->rollBack();
    	echo 'Failed: ' . $e->getMessage();
    }
    */
    //开启事务，标明回滚起始点
    public function begin()
    {
        $this->db->beginTransaction();
    }
    //执行事务，标明回滚结束点
    public function commit()
    {
        $this->db->commit();
    }
    //回滚事务
    public function rollBack()
    {
        $this->db->rollBack();
    }
    //捕获PDO错误信息
    private function getError($s)
    {
        if ($this->db->errorCode() != '00000') {
            $a = $this->db->errorInfo();
            die('MYSQL Query Error :' . $a['2'] . '，SQL: ' . $s);
        }
    }
    //表添加前缀
    private function table_qz($tn)
    {
        if (!preg_match('/' . $this->prefix . '/', $tn)) {
            return $this->prefix . $tn;
        }
        return $tn;
    }
    //sql语句添加表前缀
    private function sql_qz($s)
    {
        return preg_replace('/\\{\\{(.*?)\\}\\}/', '`' . $this->prefix . '$1`', $s);
    }
    /*
     * 合併后的SQL語句
     * @param $t 类型：1添加和修改，其它为查询
     */
    private function getCode($a, $t = 0)
    {
        $s = '';
        $b = array();
        if (!empty($a)) {
            foreach ($a as $k => $v) {
                $fh = '=';
                if (preg_match('/\\!$/', $k)) {
                    $fh = '!=';
                    $k = str_replace('!', '', $k);
                } elseif (preg_match('/\\>$/', $k)) {
                    $fh = '>';
                    $k = str_replace('>', '', $k);
                } elseif (preg_match('#\\>\\=$#', $k)) {
                    $fh = '>=';
                    $k = str_replace('>=', '', $k);
                } elseif (preg_match('/\\<$/', $k)) {
                    $fh = '<';
                    $k = str_replace('<', '', $k);
                } elseif (preg_match('/\\<\\=$/', $k)) {
                    $fh = '<=';
                    $k = str_replace('<=', '', $k);
                }
                $s .= $s != '' ? $t == 1 ? ',' : ' AND ' : '';
                if ($t == 1 && $v == $k . '+1') {
                    //整型数累加
                    $s .= '`' . $k . '`' . $fh . $v;
                } else {
                    $s .= '`' . $k . '`' . $fh . ':' . $k;
                    $b[':' . $k] = $v;
                }
            }
            return array($s, $b);
        }
        return $b;
    }
}
//end class