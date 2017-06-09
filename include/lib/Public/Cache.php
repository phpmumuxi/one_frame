<?php
/**
 * 文件缓存类
 *
 * @Author Hardy
 */
class Public_Cache
{
    private $cache_dir = '';
    private $cache_path = '';
    //构造函数
    function __construct($dir = 'public')
    {
        $this->cache_dir = preg_replace('/\\/$/', '', KO_CACHE_PATH) . '/';
        $this->cache_path = $this->cache_dir . $dir;
        if (!@file_exists($this->cache_path)) {
            @mkdir($this->cache_path, 0700, true);
        }
    }
    //生成缓存文件名
    private function cache_id($id)
    {
        return $this->cache_path . '/' . md5($id) . '.ko';
    }
    /**
     * 获取缓存信息
     * 
     * @param $id   缓存id
     */
    public function get($id)
    {
        $file = $this->cache_id($id);
        $f = @fopen($file, 'r');
        $c = @fread($f, @filesize($file));
        @fclose($f);
        $c = unserialize(Str::ko_auth_code($c));
        //解密
        if ($c['expire'] == 0 || $c['expire'] > time()) {
            return $c['data'];
        }
        $this->del($id);
        return false;
    }
    /**
     * 设置一个缓存
     * 
     * @param $id      缓存id
     * @param $data    缓存内容
     * @param $expire  缓存生命：默认为0无限生命
     */
    public function set($id, $data = null, $expire = 0)
    {
        $file = $this->cache_id($id);
        $c = array();
        $c['data'] = $data;
        $c['expire'] = $expire;
        if ($expire > 0) {
            $c['expire'] += time();
        }
        $c = Str::ko_auth_code(serialize($c), 'KO');
        //加密
        $f = @fopen($file, 'wb');
        if ($f) {
            @fwrite($f, $c);
        }
        @fclose($f);
    }
    /**
     * 删除单个缓存文件
     * 
     * @param $id   缓存id
     */
    public function del($id)
    {
        $file = $this->cache_id($id);
        if (@file_exists($file)) {
            @unlink($file);
        }
    }
    //删除指定目录所有缓存
    public function clearAll($dir = '')
    {
        if ($dir == '') {
            $dir = $this->cache_path;
        }
        $this->deldir($dir);
    }
    //删除文件夹和文件(先删除目录下的文件，然后删除文件夹)
    private function deldir($dir)
    {
        $dir = preg_replace('/\\/$/', '', $dir) . '/';
        if (@file_exists($dir)) {
            $dh = @opendir($dir);
            if ($dh) {
                while (false !== ($file = @readdir($dh))) {
                    $path = str_replace('\\', '/', $dir . $file);
                    if ($file == '.' || $file == '..') {
                        continue;
                    } elseif (@is_dir($path)) {
                        $this->deldir($path);
                    } else {
                        @unlink($path);
                    }
                }
            }
            @closedir($dh);
            @rmdir($dir);
            //删除当前文件夹
        }
    }
}
//end class